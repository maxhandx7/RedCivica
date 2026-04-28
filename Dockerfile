# ============================================================
# Stage 1: Node - Build de assets con Vite
# ============================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --frozen-lockfile

COPY . .
RUN npm run build

# ============================================================
# Stage 2: Composer - Dependencias PHP
# Usamos php:8.2-fpm-alpine + composer para que ext-gd
# esté disponible (lo necesita maatwebsite/excel / phpspreadsheet)
# ============================================================
FROM php:8.2-fpm-alpine AS composer-builder

# Instalar ext-gd y librerías mínimas que necesita phpspreadsheet
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install gd zip mbstring \
    && rm -rf /var/cache/apk/*

# Instalar composer en esta imagen
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# ============================================================
# Stage 3: Imagen final de producción
# ============================================================
FROM php:8.2-fpm-alpine AS production

# Instalar dependencias del sistema y extensiones PHP
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        zip \
        bcmath \
        mbstring \
        exif \
        pcntl \
        intl \
        opcache \
    && rm -rf /var/cache/apk/*

# OPcache para producción
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
} > /usr/local/etc/php/conf.d/opcache.ini

# ── Nginx config (todo embebido, sin archivos externos) ──
RUN mkdir -p /etc/nginx/http.d /var/log/nginx && \
cat > /etc/nginx/nginx.conf << 'EOF'
user www-data;
worker_processes auto;
pid /run/nginx.pid;
error_log /var/log/nginx/error.log warn;
events { worker_connections 1024; }
http {
    include       /etc/nginx/mime.types;
    default_type  application/octet-stream;
    sendfile on;
    keepalive_timeout 65;
    client_max_body_size 100M;
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml;
    include /etc/nginx/http.d/*.conf;
}
EOF

RUN cat > /etc/nginx/http.d/default.conf << 'EOF'
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php;
    charset utf-8;
    location /build {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    error_page 404 /index.php;
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }
    location ~ /\.(?!well-known).* { deny all; }
}
EOF

# ── Supervisor config (embebida) ──
RUN mkdir -p /etc/supervisor/conf.d /var/log/supervisor && \
cat > /etc/supervisor/conf.d/supervisord.conf << 'EOF'
[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid

[program:nginx]
command=nginx -g "daemon off;"
autostart=true
autorestart=true
stderr_logfile=/var/log/nginx/error.log
stdout_logfile=/var/log/nginx/access.log

[program:php-fpm]
command=php-fpm -F
autostart=true
autorestart=true
stderr_logfile=/var/log/supervisor/php-fpm.log
stdout_logfile=/var/log/supervisor/php-fpm.log

[program:laravel-scheduler]
command=/bin/sh -c "while true; do php /var/www/html/artisan schedule:run --verbose --no-interaction; sleep 60; done"
autostart=true
autorestart=true
stderr_logfile=/var/log/supervisor/scheduler.log
stdout_logfile=/var/log/supervisor/scheduler.log
EOF

# ── Script de inicio (embebido) ──
RUN cat > /start.sh << 'EOF'
#!/bin/sh
set -e
echo "Iniciando contenedor Laravel..."
mkdir -p /var/log/nginx /var/log/php-fpm /var/log/supervisor
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
php artisan config:clear
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
EOF
RUN chmod +x /start.sh

WORKDIR /var/www/html

COPY --from=composer-builder /app/vendor ./vendor
COPY --from=node-builder /app/public/build ./public/build
COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/start.sh"]
