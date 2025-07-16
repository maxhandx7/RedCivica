FROM php:8.2-fpm

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de la app
WORKDIR /var/www

# Copiar todo el proyecto
COPY . .

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Copiar configuración de nginx
COPY deploy/nginx.conf /etc/nginx/sites-available/default

# Copiar supervisord config
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Dar permisos a Laravel
RUN chown -R www-data:www-data /var/www && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord"]
