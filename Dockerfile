FROM php:8.2-apache

# Instalar dependencias del sistema necesarias para Composer y extensiones
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath zip

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Dar permisos a storage y bootstrap
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer puerto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
