<?php

return [
    'driver'    => env('DB_DRIVER', 'mysql'),
    'host'      => env('DB_HOST', 'localhost'),
    'port'      => env('DB_PORT', 3306),
    'username'  => env('DB_USERNAME', 'root'),
    'passowrd'  => env('DB_PASSWORD', ''),
    'db'        => env('DB_DATABASE', env('APP_NAME')),
];
