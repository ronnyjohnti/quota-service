<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\QuotasPolicy;
use App\Schema\QuotasPolicySchema;
use Exception;
use Hyperf\Database\Model\Collection;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\Server\Exception\ServerException;
use Hyperf\Swagger\Annotation as SA;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

#[SA\Info(version: '1.0.0', title: 'Quotas API')]
#[SA\HyperfServer('http')]

#[SA\SecurityScheme(
    securityScheme: 'apiKey',
    type: 'http',
    description: 'Enter your apiKey',
    name: 'Authorization',
    in: 'header',
    scheme: 'bearer'
)]
#[SA\Server(url: 'http://localhost:9501/api/v1', description: 'Servidor local')]
#[SA\Response(response: 401, description: 'Error: unauthorized')]
class QuotaController extends AbstractController
{
    #[SA\Get(
        path: '/quotas',
        operationId: 'quotas_index',
        description: 'Retorna uma lista de todas as cotas',
        summary: 'Lista todas as cotas',
        security: ['apiKey'],
        tags: ['Cotas'],
        responses: [
            new SA\Response(response: 200, content: new SA\MediaType(
                mediaType: 'application/json',
                schema: new SA\Schema(ref: QuotasPolicySchema::REF)
            ))
        ]
    )]
    public function index(): Collection
    {
        return QuotasPolicy::get();
    }

    #[SA\Get(path: '/quotas/{id}', summary: 'Devolvendo uma cota pelo id', tags: ['Cotas'])]
    #[SA\Response(response: 200, description: 'Success')]
    #[SA\Response(response: 404, description: 'Quota Policy not found')]
    public function show(int $id): QuotasPolicy
    {
        $quota = QuotasPolicy::find($id);
        if ($quota === null) {
            throw new NotFoundHttpException('Quota Policy not found');
        }

        return $quota;
    }

    public function store(): QuotasPolicy
    {
        return QuotasPolicy::create($this->request->all());
    }

    public function update(int $id): ResponseInterface
    {
        try {
            if (QuotasPolicy::find($id)->update($this->request->all())) {
                return $this->response->withStatus(200);
            }
        } catch (Exception $e) {
            $this->container->get(LoggerInterface::class)
                ->error($e->getMessage());
            throw new ServerException();
        }

        return $this->response->withStatus(404);
    }

    public function delete(int $id): ResponseInterface
    {
        try {
            if (QuotasPolicy::destroy($id)) {
                return $this->response->withStatus(204);
            }
        } catch (Exception $e) {
            $this->container->get(LoggerInterface::class)
                ->error($e->getMessage());
            throw new ServerException();
        }

        return $this->response->withStatus(404);
    }
}
