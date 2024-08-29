<?php

declare(strict_types=1);
use App\Controller\AgentQuotasPolicyController;
use App\Controller\QuotaController;
use App\Middleware\ApiTokenMiddleware;
use App\Middleware\CorsMiddleware;
use Hyperf\HttpServer\Router\Router;
use Hyperf\Swagger\Annotation as SA;

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
}, ['middleware' => [CorsMiddleware::class, ApiTokenMiddleware::class]]);
