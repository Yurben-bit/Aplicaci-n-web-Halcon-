FROM heroku/heroku:22-build

# Instalar extensiones PHP necesarias
RUN install-php-extensions bcmath

# Copiar archivos
COPY . /app
WORKDIR /app

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD ["vendor/bin/heroku-php-apache2", "public/"]