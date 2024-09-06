<?php

declare(strict_types=1);
return [
    'enable' => false,
    'port' => 9500,
    'json_dir' => BASE_PATH . '/runtime/swagger',
    'html' => null,
    'url' => '/',
    'auto_generate' => true,
    'scan' => [
        'paths' => null,
    ],
    'processors' => [
        // users can append their own processors here
    ],
    'servers' => [
        'url' => 'http://localhost:9501/api/v1',
        'description' => 'Local server',
    ],
];
