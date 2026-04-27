FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath zip

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar solo el código de Laravel
COPY . /var/www/html

WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN chown -R www-data:www-data storage bootstrap/cache

# Cambiar Apache al puerto dinámico de Railway
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf
RUN sed -i "s/80/${PORT}/g" /etc/apache2/sites-enabled/000-default.conf

EXPOSE 8080

CMD ["apache2ctl", "-D", "FOREGROUND"]
