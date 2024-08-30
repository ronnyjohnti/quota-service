<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function Hyperf\Support\env;

class ApiTokenMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected ContainerInterface $container,
        protected HttpResponse $response,
        protected RequestInterface $request
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authenticationHeaderValues = $request->getHeader('Authorization');
        $envKeyBearer = 'Bearer ' . env('AUTHORIZATION_API_KEY');
        if (! in_array($envKeyBearer, $authenticationHeaderValues)) {
            return $this->response->withStatus(401);
        }

        return $handler->handle($request);
    }
}
