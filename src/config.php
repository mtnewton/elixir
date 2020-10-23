<?php

return [
    'discord' => [
        'token' => env('DISCORD_TOKEN', ''),
        'prefix' => env('DISCORD_PREFIX', '@mention'),
    ],
    'database' => [
        'host' => env('DATABASE_HOST', ''),
        'port' => env('DATABASE_HOST', ''),
        'username' => env('DATABASE_USERNAME', ''),
        'password' => env('DATABASE_PASSWORD', ''),
    ],
    'log' => [
        'debug' => filter_var(env('LOG_DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    ],
];
