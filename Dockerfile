# Usamos la imagen oficial de PHP con FPM
FROM php:8.2-fpm

# Instalamos extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecemos el directorio de trabajo
WORKDIR /var/www

# Copiamos el código del proyecto al contenedor
COPY . .

# Instalamos las dependencias de Laravel (sin las de desarrollo)
RUN composer install --no-dev --optimize-autoloader

# Damos permisos a las carpetas necesarias
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Puerto que va a escuchar (CapRover lo necesita)
EXPOSE 9000

# Comando que ejecuta PHP-FPM
CMD ["php-fpm"]
