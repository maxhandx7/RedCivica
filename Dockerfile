# --- Etapa 1: Composer (Dependencias de PHP) ---
FROM composer:2.7 AS builder

WORKDIR /app

# Copiamos solo los archivos necesarios para instalar dependencias primero (aprovecha caché de Docker)
COPY composer.json composer.lock ./

# Instalamos dependencias del sistema necesarias para extensiones de PHP (como GD)
# Esto soluciona el error: "phpoffice/phpspreadsheet requires ext-gd * -> it is missing"
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Instalamos dependencias de producción
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# --- Etapa 2: Imagen Final (Runtime) ---
FROM php:8.2-fpm-alpine

# Instalamos dependencias de tiempo de ejecución y extensiones necesarias
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    nginx \
    supervisor

# Instalamos extensiones de PHP en la imagen final
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    intl

WORKDIR /var/www/html

# Copiamos el código del proyecto y las dependencias instaladas en la etapa anterior
COPY . .
COPY --from=builder /app/vendor ./vendor

# Ajustamos permisos para Laravel
RUN chown -R swww-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# NOTA SOBRE SEGURIDAD: 
# No uses ARG para APP_KEY o DB_PASSWORD aquí. 
# Configúralos directamente en el panel de Coolify (Variables de Entorno).

EXPOSE 80

# Comando para iniciar (Asegúrate de tener un script de inicio o usar supervisor)
CMD ["php-fpm"]
