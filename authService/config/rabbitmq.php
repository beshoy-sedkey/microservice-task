<?php
return [
    'host' => env('RABBITMQ_HOST', '127.0.0.1'),
    'port' => env('RABBITMQ_PORT', 5672),
    'vhost' => env('RABBITMQ_VHOST', '/'),
    'user' => env('RABBITMQ_USER', 'guest'),
    'password' => env('RABBITMQ_PASSWORD', 'guest'),
    'queue' => env('RABBITMQ_QUEUE', 'default'),
    'exchange_name' => env('RABBITMQ_EXCHANGE_NAME', 'default'),
    'exchange_type' => env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
    'exchange_declare' => env('RABBITMQ_EXCHANGE_DECLARE', true),
];
