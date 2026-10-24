#!/usr/bin/env sh
set -e

# 1. Configurar dinámicamente el puerto de escucha asignado por Render (o 80 por defecto)
PORT_NUMBER="${PORT:-80}"
echo "==> [SuperFast] Configurando Nginx en el puerto ${PORT_NUMBER}..."
if [ -f /etc/nginx/http.d/default.conf ]; then
    sed -i "s/__PORT__/${PORT_NUMBER}/g" /etc/nginx/http.d/default.conf
elif [ -f /etc/nginx/sites-available/default ]; then
    sed -i "s/__PORT__/${PORT_NUMBER}/g" /etc/nginx/sites-available/default
else
    echo "==> [SuperFast] [ERROR CRÍTICO] No se encontró el archivo de configuración de Nginx." >&2
    exit 1
fi

# Asegurar que Nginx ejecute bajo el usuario www-data igual que PHP-FPM
if [ -f /etc/nginx/nginx.conf ]; then
    sed -i "s/user nginx;/user www-data;/g" /etc/nginx/nginx.conf
fi

# Asegurar directorios temporales de Nginx con permisos mínimos para www-data (modo 700)
mkdir -p /var/lib/nginx/tmp/client_body \
         /var/lib/nginx/tmp/proxy \
         /var/lib/nginx/tmp/fastcgi
chown -R www-data:www-data /var/lib/nginx/tmp /var/log/nginx
chmod -R 700 /var/lib/nginx/tmp

# 2. Asegurar existencia de directorios de almacenamiento y caché
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/app/public \
         storage/logs \
         bootstrap/cache

# Asignar permisos al usuario www-data
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 3. Crear enlace simbólico de almacenamiento público
php artisan storage:link --force

# 4. Validar clave de aplicación (APP_KEY)
if [ -z "$APP_KEY" ]; then
    echo "==> [SuperFast] [ERROR CRÍTICO] La variable APP_KEY no está configurada. Deteniendo arranque." >&2
    exit 1
fi

# 5. Verificación de permisos de usuario y validación estricta del certificado SSL
echo "==> [SuperFast] [Permisos] Usuario www-data - GIDs: $(id -G www-data 2>/dev/null) | Grupos: $(id -G -n www-data 2>/dev/null)"

if [ "$DB_CONNECTION" = "mysql" ]; then
    if [ -z "$MYSQL_ATTR_SSL_CA" ]; then
        echo "==> [SuperFast] [ERROR CRÍTICO] DB_CONNECTION='mysql' pero MYSQL_ATTR_SSL_CA no está configurada o está vacía." >&2
        exit 1
    fi

    echo "==> [SuperFast] [SSL] Verificando ruta configurada: $MYSQL_ATTR_SSL_CA"
    if [ ! -f "$MYSQL_ATTR_SSL_CA" ]; then
        echo "==> [SuperFast] [ERROR CRÍTICO] El archivo de certificado '$MYSQL_ATTR_SSL_CA' NO existe en el contenedor." >&2
        echo "==> [SuperFast] [SSL INFO] Archivos presentes en /etc/secrets (solo nombres):" >&2
        ls -la /etc/secrets 2>/dev/null || echo "    Directorio /etc/secrets no encontrado." >&2
        exit 1
    fi

    if [ ! -s "$MYSQL_ATTR_SSL_CA" ]; then
        echo "==> [SuperFast] [ERROR CRÍTICO] El archivo de certificado '$MYSQL_ATTR_SSL_CA' existe pero está VACÍO (0 bytes)." >&2
        exit 1
    fi

    CERT_SIZE=$(wc -c < "$MYSQL_ATTR_SSL_CA" 2>/dev/null || echo "0")
    echo "==> [SuperFast] [SSL OK] Archivo presente y no vacío ($CERT_SIZE bytes)."

    if ! su -s /bin/sh www-data -c "test -r '$MYSQL_ATTR_SSL_CA'" 2>/dev/null; then
        echo "==> [SuperFast] [ERROR CRÍTICO] Archivo '$MYSQL_ATTR_SSL_CA' NO es legible por el usuario www-data." >&2
        exit 1
    fi
    echo "==> [SuperFast] [SSL OK] Archivo es LEGIBLE por el usuario www-data."
fi

# 6. Limpiar y optimizar caché de configuración con las variables de entorno de producción
echo "==> [SuperFast] Limpiando y optimizando caché de configuración..."
php artisan config:clear
if ! php artisan config:cache; then
    echo "==> [SuperFast] [ERROR CRÍTICO] Falló la optimización de la configuración (config:cache). Deteniendo arranque." >&2
    exit 1
fi

# 7. Prueba de conexión segura a MySQL inicializando Laravel (Sin exponer credenciales)
if [ "$DB_CONNECTION" = "mysql" ]; then
    echo "==> [SuperFast] [DB] Probando conexión PDO con MySQL en Aiven..."
    if ! php -r "
        require 'vendor/autoload.php';
        \$app = require_once 'bootstrap/app.php';
        \$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
        \$kernel->bootstrap();
        try {
            Illuminate\Support\Facades\DB::connection()->getPdo();
            echo '==> [SuperFast] [DB OK] Conexión PDO con MySQL establecida correctamente.' . PHP_EOL;
            exit(0);
        } catch (Throwable \$e) {
            \$msg = \$e->getMessage();
            if (str_contains(\$msg, 'failed loading cafile stream')) {
                \$desc = 'No se pudo cargar el archivo de certificado CA especificado.';
            } elseif (str_contains(\$msg, 'Access denied')) {
                \$desc = 'Acceso denegado por el servidor MySQL (credenciales o permisos).';
            } elseif (str_contains(\$msg, 'Connection refused') || str_contains(\$msg, 'timed out')) {
                \$desc = 'No se pudo contactar al host MySQL (posible restricción de red/IP en Aiven).';
            } elseif (str_contains(\$msg, 'SSL') || str_contains(\$msg, 'certificate')) {
                \$desc = 'Fallo en la negociación o verificación del certificado SSL/TLS.';
            } else {
                \$desc = 'Fallo durante la inicialización de la conexión PDO.';
            }
            echo '==> [SuperFast] [DB ERROR] ' . get_class(\$e) . ' (Código: ' . \$e->getCode() . '): ' . \$desc . PHP_EOL;
            exit(1);
        }
    "; then
        echo "==> [SuperFast] [ERROR CRÍTICO] La prueba de conexión a MySQL falló. Deteniendo arranque." >&2
        exit 1
    fi
fi

# 8. Ejecutar migraciones pendientes de la base de datos antes de abrir el tráfico web
echo "==> [SuperFast] [DB] Ejecutando migraciones pendientes en la base de datos..."
if ! php artisan migrate --force --no-interaction; then
    echo "==> [SuperFast] [ERROR CRÍTICO] Falló la ejecución de las migraciones en la base de datos. Deteniendo arranque." >&2
    exit 1
fi
echo "==> [SuperFast] [DB OK] Migraciones completadas exitosamente."

# 9. Optimizar cachés de rutas y vistas (optimizaciones de rendimiento no bloqueantes)
echo "==> [SuperFast] Optimizando cachés de rutas y vistas..."
if ! php artisan route:cache; then
    echo "==> [SuperFast] [ADVERTENCIA] Falló route:cache. Se continuará con resolución dinámica de rutas." >&2
fi
if ! php artisan view:cache; then
    echo "==> [SuperFast] [ADVERTENCIA] Falló view:cache. Las vistas se compilarán en tiempo de ejecución (JIT)." >&2
fi

# 10. Reasegurar propiedad de storage y bootstrap/cache para www-data tras la generación de cachés
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 11. Iniciar supervisor para gestionar Nginx y PHP-FPM en primer plano
echo "==> [SuperFast] Servidor listo. Iniciando PHP-FPM y Nginx..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
