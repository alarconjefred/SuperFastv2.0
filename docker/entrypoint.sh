#!/usr/bin/env sh
set -e

# 1. Configurar dinámicamente el puerto de escucha asignado por Render (o 80 por defecto)
PORT_NUMBER="${PORT:-80}"
echo "==> [SuperFast] Configurando Nginx en el puerto ${PORT_NUMBER}..."
sed -i "s/__PORT__/${PORT_NUMBER}/g" /etc/nginx/http.d/default.conf 2>/dev/null || \
sed -i "s/__PORT__/${PORT_NUMBER}/g" /etc/nginx/sites-available/default 2>/dev/null || true

# Asegurar que Nginx ejecute bajo el usuario www-data igual que PHP-FPM
sed -i "s/user nginx;/user www-data;/g" /etc/nginx/nginx.conf 2>/dev/null || true

# 2. Asegurar existencia de directorios de almacenamiento y caché
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/app/public \
         bootstrap/cache

# Asignar permisos al usuario www-data
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 3. Crear enlace simbólico de almacenamiento público si no existe
php artisan storage:link --force || true

# 4. Optimizar cachés de Laravel en arranque si la clave de aplicación está definida
if [ -n "$APP_KEY" ]; then
    echo "==> [SuperFast] Optimizando cachés de configuración y rutas..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# 5. Iniciar supervisor para gestionar Nginx y PHP-FPM en primer plano
echo "==> [SuperFast] Servidor listo. Iniciando PHP-FPM y Nginx..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
