# El siguiente comando se utiliza para iniciar el servidor de desarrollo de Laravel en Ralway (y Heroku).

web: php artisan serve --host=0.0.0.0 --port=${PORT}

# Para cuando se quiere ejecutar una migracion (forzada) en el despliegue, se puede usar el siguiente comando:

# web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}

# El comando `php artisan migrate --force` se asegura de que las migraciones se ejecuten sin pedir confirmación,
# lo cual es necesario en un entorno de producción como Railway o Heroku. 
# Luego, el comando `php artisan serve` inicia el servidor de desarrollo de Laravel, 
# escuchando en todas las interfaces (`0.0.0.0`) y en el puerto especificado (${PORT}).

# php artisan route:clear
# php artisan cache:clear
# php artisan optimize:clear

# web: php artisan route:clear && php artisan config:clear && php artisan cache:clear && php artisan optimize:clear && php artisan serve --host=0.0.0.0 --port=${PORT}

# web: php artisan storage:link && php artisan serve --host=0.0.0.0 --port=${PORT}