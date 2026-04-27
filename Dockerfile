# ============================================================
# Stage 1: Node - Build de assets con Vite
# ============================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copiar archivos de dependencias primero (mejor cache de capas)
COPY package.json package-lock.json ./

RUN npm ci --frozen-lockfile

# Copiar el resto del código fuente
COPY . .

# Build de producción con Vite
RUN npm run build

# ============================================================
# Stage 2: Composer - Dependencias PHP
# ============================================================
FROM composer:2.7 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./

# Instalar dependencias sin dev y optimizando autoload
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

# Instalar dependencias del sistema y extensiones PHP necesarias
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
    # Para spatie/laravel-permission y doctrine/dbal
    postgresql-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        gd \
        zip \
        bcmath \
        mbstring \
        exif \
        pcntl \
        intl \
        opcache \
    && rm -rf /var/cache/apk/*

# Configuración de OPcache para producción
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
} > /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

# Copiar vendor desde el stage de Composer
COPY --from=composer-builder /app/vendor ./vendor

# Copiar assets compilados desde el stage de Node
COPY --from=node-builder /app/public/build ./public/build

# Copiar el código de la aplicación
COPY . .

# Configurar Nginx
RUN mkdir -p /etc/nginx/http.d
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Configurar Supervisor (para correr nginx + php-fpm juntos)
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Script de inicio (migraciones + cache + arranque)
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
