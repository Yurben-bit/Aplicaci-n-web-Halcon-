# PHP-FPM
FROM php:8.2-fpm AS php

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath zip

WORKDIR /var/www/html

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN chown -R www-data:www-data storage bootstrap/cache


# Caddy server
FROM caddy:2-alpine

COPY Caddyfile /etc/caddy/Caddyfile
COPY --from=php /var/www/html /var/www/html

EXPOSE 80

CMD ["caddy", "run", "--config", "/etc/caddy/Caddyfile"]
