<?php

return [
    'paths' => ['api/*', 'login', 'logout', 'sanctum/csrf-cookie'], // Add 'login' here if it's not under api/
    'allowed_origins' => ['*'],
    'supports_credentials' => true,
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];