FROM php:8.2-fpm

# Instala dependencias
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

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crea carpeta del proyecto
WORKDIR /var/www

# Copia el contenido del proyecto Laravel
COPY . .

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Copia archivos de configuración de Nginx y Supervisor
COPY deploy/nginx.conf /etc/nginx/nginx.conf
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Da permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expone el puerto que NGINX usará
EXPOSE 80

# Usa supervisor para correr nginx y php-fpm
CMD ["/usr/bin/supervisord"]
