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

# 4. Verificación de permisos de usuario y diagnóstico seguro del certificado SSL
echo "==> [SuperFast] [Permisos] Usuario www-data - GIDs: $(id -G www-data 2>/dev/null) | Grupos: $(id -G -n www-data 2>/dev/null)"

SSL_CERT_OK=0
if [ "$DB_CONNECTION" = "mysql" ]; then
    if [ -z "$MYSQL_ATTR_SSL_CA" ]; then
        echo "==> [SuperFast] [SSL ERROR] DB_CONNECTION='mysql' pero MYSQL_ATTR_SSL_CA no está configurada o está vacía."
    else
        echo "==> [SuperFast] [SSL] Verificando ruta configurada: $MYSQL_ATTR_SSL_CA"
        if [ ! -f "$MYSQL_ATTR_SSL_CA" ]; then
            echo "==> [SuperFast] [SSL ERROR] El archivo '$MYSQL_ATTR_SSL_CA' NO existe en el contenedor."
            echo "==> [SuperFast] [SSL INFO] Archivos presentes en /etc/secrets (solo nombres):"
            ls -la /etc/secrets 2>/dev/null || echo "    Directorio /etc/secrets no encontrado."
        elif [ ! -s "$MYSQL_ATTR_SSL_CA" ]; then
            echo "==> [SuperFast] [SSL ERROR] El archivo '$MYSQL_ATTR_SSL_CA' existe pero está VACÍO (0 bytes)."
        else
            CERT_SIZE=$(wc -c < "$MYSQL_ATTR_SSL_CA" 2>/dev/null || echo "0")
            echo "==> [SuperFast] [SSL OK] Archivo presente y no vacío ($CERT_SIZE bytes)."

            if su -s /bin/sh www-data -c "test -r '$MYSQL_ATTR_SSL_CA'" 2>/dev/null; then
                echo "==> [SuperFast] [SSL OK] Archivo es LEGIBLE por el usuario www-data."
                SSL_CERT_OK=1
            else
                echo "==> [SuperFast] [SSL ERROR] Archivo NO es legible por www-data (revisar permisos GID 1000)."
            fi
        fi
    fi
else
    # Para motores de base de datos que no sean MySQL (ej. sqlite local) no se requiere certificado CA
    SSL_CERT_OK=1
fi

# 5. Prueba de conexión segura a MySQL inicializando Laravel (Sin exponer credenciales)
if [ -n "$APP_KEY" ] && [ "$DB_CONNECTION" = "mysql" ]; then
    if [ "$SSL_CERT_OK" -ne 1 ]; then
        echo "==> [SuperFast] [DB OMITIDO] No se intenta la conexión a MySQL debido a errores en la configuración o lectura del certificado SSL."
    else
        echo "==> [SuperFast] [DB] Probando conexión PDO con MySQL en Aiven..."
        php -r "
            require 'vendor/autoload.php';
            \$app = require_once 'bootstrap/app.php';
            \$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
            \$kernel->bootstrap();
            try {
                Illuminate\Support\Facades\DB::connection()->getPdo();
                echo '==> [SuperFast] [DB OK] Conexión PDO con MySQL establecida correctamente.' . PHP_EOL;
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
            }
        " || true
    fi
fi

# 6. Optimizar cachés de Laravel en arranque si la clave de aplicación está definida
if [ -n "$APP_KEY" ]; then
    echo "==> [SuperFast] Optimizando cachés de configuración y rutas..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# 7. Iniciar supervisor para gestionar Nginx y PHP-FPM en primer plano
echo "==> [SuperFast] Servidor listo. Iniciando PHP-FPM y Nginx..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
