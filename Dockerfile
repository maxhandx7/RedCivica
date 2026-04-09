# ================================
# 1. BUILD FRONTEND (Node)
# ================================
FROM node:18 AS node_builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ================================
# 2. BUILD BACKEND (PHP)
# ================================
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nginx \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    && apt-get clean

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# Copiar proyecto
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Copiar build de Vite
COPY --from=node_builder /app/public/build ./public/build

# Permisos (Laravel se pone delicado si no)
RUN mkdir -p storage/logs \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# ================================
# 3. NGINX CONFIG INLINE (SIN ARCHIVO EXTERNO 👀)
# ================================
RUN rm -f /etc/nginx/sites-enabled/default

RUN echo "server { \
    listen 80; \
    index index.php index.html; \
    root /var/www/public; \
    \
    location / { \
        try_files \$uri \$uri/ /index.php?\$query_string; \
    } \
    \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \
    } \
    \
    location ~ /\.ht { \
        deny all; \
    } \
}" > /etc/nginx/conf.d/default.conf

# Ajustar PHP-FPM
RUN sed -i 's|listen = .*|listen = 9000|' /usr/local/etc/php-fpm.d/www.conf

# Exponer puerto
EXPOSE 80

# ================================
# 4. ARRANQUE
# ================================
CMD service nginx start && php-fpm
