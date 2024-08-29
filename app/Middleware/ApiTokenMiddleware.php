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
use Hyperf\Swagger\Annotation as SA;

use function Hyperf\Support\env;

class ApiTokenMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected ContainerInterface $container,
        protected HttpResponse $response,
        protected RequestInterface $request
    ) {
    }

    #[SA\HyperfServer('http')]
    #[SA\Response(response: 401, description: 'Unauthorized')]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $apiKey = $request->getHeader('Authorization');
        if (! in_array(env('AUTHORIZATION_API_KEY'), $apiKey)) {
            return $this->response->withStatus(401);
        }

        return $handler->handle($request);
    }
}
