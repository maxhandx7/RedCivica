#!/bin/sh
set -e

echo "🚀 Iniciando contenedor Laravel..."

# Crear directorios necesarios si no existen
mkdir -p /var/log/nginx /var/log/php-fpm /var/log/supervisor
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views

# Permisos correctos
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Limpiar caches previas
echo "🧹 Limpiando caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ejecutar migraciones (--force requerido en producción)
echo "📦 Ejecutando migraciones..."
php artisan migrate --force

# Optimizar para producción
echo "⚡ Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "✅ Todo listo. Arrancando servicios..."

# Arrancar supervisor (nginx + php-fpm + scheduler)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
