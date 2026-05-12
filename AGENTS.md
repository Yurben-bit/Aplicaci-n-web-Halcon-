## Proyecto de Halcon web

# Backend

EL backend esta hecho en PHP 8.2 laravel 12 con Sanctum, Tinker y UI. El gestor es Composer. El lenguaje de frontend es JS/TS y VITE. 
Para CSS/UI es Tailwind CSS v4, Bootstrap 5, CoreUI, Sass.
Para JS se hace uso de Axios.

# Conexiones a la API - BACK

Para la conexion de endpoints/apis se hace uso de Laravel Sanctum por medio de tokens en el back.
Se encuentra en routes, especificamente api.php. 

# Conexiones a la API - FRONT

En el front se encuentra una carpeta llamada api, por medio de Axios, se utiliza la API/tokens.