# -----------------------------
# 1) PHP-FPM + Composer
# -----------------------------
FROM php:8.2-fpm-alpine AS php

RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    curl-dev \
    supervisor

RUN docker-php-ext-install pdo pdo_mysql bcmath zip

WORKDIR /var/www/html

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN chown -R www-data:www-data storage bootstrap/cache


# -----------------------------
# 2) FINAL STAGE: CADDY + PHP-FPM
# -----------------------------
FROM alpine:3.19

RUN apk add --no-cache caddy supervisor php82 php82-fpm php82-pdo_mysql php82-mbstring php82-xml php82-session php82-tokenizer php82-zip php82-curl php82-fileinfo php82-json php82-dom php82-gd

COPY --from=php /var/www/html /var/www/html

COPY Caddyfile /etc/caddy/Caddyfile
COPY supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
