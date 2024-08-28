<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
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
