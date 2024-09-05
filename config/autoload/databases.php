<?php

declare(strict_types=1);
use function Hyperf\Support\env;

return [
    'default' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'host' => env('DB_HOST', 'localhost'),
        'database' => env('DB_DATABASE', 'hyperf'),
        'port' => env('DB_PORT', 3306),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => env('DB_CHARSET', 'utf8'),
        'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('DB_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('DB_MAX_IDLE_TIME', 60),
        ],
        'commands' => [
            'gen:model' => [
                'path' => 'app/Model',
                'force_casts' => true,
                'inheritance' => 'Model',
            ],
        ],
    ],
    'mapas' => [
        'driver' => env('MAPAS_DB_DRIVER', 'pgsql'),
        'host' => env('MAPAS_DB_HOST', 'localhost'),
        'database' => env('MAPAS_DB_DATABASE', 'mapas'),
        'port' => env('MAPAS_DB_PORT', 5432),
        'username' => env('MAPAS_DB_USERNAME', 'mapas'),
        'password' => env('MAPAS_DB_PASSWORD', 'mapas'),
        'charset' => env('MAPAS_DB_CHARSET', 'utf8'),
        'commands' => [
            'gen:model' => [
                'path' => 'app/Model/Mapas',
                'force_casts' => true,
                'inheritance' => 'Model',
            ],
        ],
    ],
];
