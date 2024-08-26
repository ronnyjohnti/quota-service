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

use App\Controller\AgentQuotasPolicyController;
use App\Controller\QuotaController;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

Router::addGroup('/api/v1', function () {
    Router::addGroup('/quotas', function () {
        Router::get('[/]', [QuotaController::class, 'index']);
        Router::get('/{id}[/]', [QuotaController::class, 'show']);
        Router::post('[/]', [QuotaController::class, 'store']);
        Router::put('/{id}[/]', [QuotaController::class, 'update']);
        Router::delete('/{id}[/]', [QuotaController::class, 'delete']);
    });

    Router::addGroup('/agent-quotas', function () {
        Router::get('[/]', [AgentQuotasPolicyController::class, 'index']);
        Router::get('/{id}[/]', [AgentQuotasPolicyController::class, 'show']);
        Router::addRoute(['POST', 'PUT'], '[/]', [AgentQuotasPolicyController::class, 'store']);
        Router::delete('/{id}[/]', [AgentQuotasPolicyController::class, 'delete']);
    });
});
