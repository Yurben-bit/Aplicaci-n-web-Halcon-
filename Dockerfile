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

# Instalar PHP y supervisord en la imagen final
RUN apk add --no-cache \
    php8 \
    php8-fpm \
    php8-mysqli \
    php8-pdo_mysql \
    php8-session \
    php8-zip \
    php8-opcache \
    php8-tokenizer \
    php8-xml \
    php8-mbstring \
    php8-curl \
    php8-fileinfo \
    php8-json \
    php8-phar \
    php8-dom \
    php8-gd \
    php8-simplexml \
    supervisor

# Copiar Caddyfile
COPY Caddyfile /etc/caddy/Caddyfile

# Copiar el código de Laravel desde la etapa php
COPY --from=php /var/www/html /var/www/html

# Copiar configuración de supervisord
COPY supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
