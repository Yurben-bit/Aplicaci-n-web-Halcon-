<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Dominios del front:
    // https://app5-gules.vercel.app/
    // https://app5-halconwebadmin-8191s-projects.vercel.app/

    'allowed_origins' => ['https://app5-gules.vercel.app', 'https://app5-halconwebadmin-8191s-projects.vercel.app'], 
    // Importante restringir, si es posible, a los dominios específicos del frontend.

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
