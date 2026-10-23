# ==============================================================================
# ETAPA 1: Compilación de Frontend con Node.js y Vite
# ==============================================================================
FROM node:20-alpine AS frontend
WORKDIR /app

# Instalar dependencias de npm
COPY package.json package-lock.json ./
RUN npm ci

# Copiar configuraciones y recursos para la compilación de Vite y Tailwind CSS v4
COPY vite.config.js ./
COPY resources/ resources/
COPY public/ public/

# Compilar assets de producción (genera public/build/manifest.json)
RUN npm run build

# ==============================================================================
# ETAPA 2: Servidor PHP 8.2-FPM + Nginx (Alpine Linux)
# ==============================================================================
FROM php:8.2-fpm-alpine

# Instalar paquetes del sistema, Nginx, Supervisor y utilidades necesarias
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    ca-certificates \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    bash \
    sed \
    dos2unix

# Instalar instalador oficial de extensiones PHP de Docker
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Instalar extensiones requeridas para Laravel 12 y MySQL (incluyendo pdo_mysql, gd para imágenes y opcache)
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache

# Instalar Composer binario oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar manifiestos de dependencias para aprovechar la caché de capas de Docker
COPY composer.json composer.lock ./

# Instalar dependencias PHP sin dev ni autoloader pesado
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

# Copiar todo el código de la aplicación
COPY . .

# Copiar los assets compilados desde la etapa de Node.js
COPY --from=frontend /app/public/build ./public/build

# Generar el autoloader optimizado de producción
RUN composer dump-autoload --optimize --no-dev --no-interaction

# Copiar configuraciones de servidor y scripts de inicio
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Normalizar saltos de línea y permisos de ejecución del entrypoint
RUN dos2unix /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

# Ajustar permisos para www-data en storage y cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto por defecto expuesto (Render asigna la variable $PORT)
EXPOSE 80 10000

# Punto de entrada de la aplicación
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
