<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\QuotasPolicy;
use App\Schema\QuotasPolicySchema;
use Exception;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\Server\Exception\ServerException;
use Hyperf\Swagger\Annotation as SA;
use OpenApi\Attributes\Schema;
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
#[SA\Server(
    url: 'http://localhost:9501/api/v1',
    description: 'Servidor local',
)]
class QuotaController extends AbstractController
{
    #[SA\Get(
        path: '/quotas',
        description: 'Retorna uma lista de todas as cotas',
        summary: 'Lista todas as cotas',
        security: [['apiKey' => []]],
        tags: ['Cotas'],
        responses: [
            new SA\Response(response: 200, content: new SA\MediaType(
                mediaType: 'application/json',
                schema: new SA\Schema(type: 'array', items: new SA\Items(ref: QuotasPolicySchema::REF))
            )),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ],
    )]
    public function index(): ResponseInterface
    {
        $quotas = QuotasPolicy::get();
        return $this->response->json($quotas);
    }

    #[SA\Get(
        path: '/quotas/{id}',
        summary: 'Devolvendo uma cota pelo id',
        security: [['apiKey' => []]],
        tags: ['Cotas'],
        parameters: [
            new SA\Parameter(
                name: 'id',
                description: 'Quota ID',
                in: 'path',
                required: true,
                schema: new Schema(type: 'string', example: 1),
            ),
        ],
        responses: [
            new SA\Response(response: 200, description: 'Success', content: new SA\MediaType(
                mediaType: 'application/json',
                schema: new Schema(ref: QuotasPolicySchema::REF),
            )),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 404, description: 'Not found'),
            new SA\Response(response: 500, description: 'Internal server error'),
        ],
    )]
    public function show(int $id): ResponseInterface
    {
        $quota = QuotasPolicy::find($id);
        if ($quota === null) {
            throw new NotFoundHttpException();
        }

        $this->response->json($quota);
        return $this->response;
    }

    #[SA\Post(
        path: '/quotas',
        description: 'Cria uma cota',
        summary: 'Criação de uma cota',
        security: [['apiKey' => []]],
        requestBody: new SA\RequestBody(
            description: 'Detalhes dos campos para criar cotas',
            required: true,
            content: new SA\JsonContent(
                required: ['name', 'validity_duration', 'status', 'created_by'],
                properties: [
                    new SA\Property(property: 'name', description: 'Name of the quotas policy', type: 'string'),
                    new SA\Property(property: 'description', description: 'Description of the quotas policy', type: 'string'),
                    new SA\Property(property: 'validity_duration', description: 'Validity duration in days', type: 'integer'),
                    new SA\Property(property: 'status', description: 'Status of the quotas policy', type: 'integer'),
                    new SA\Property(property: 'created_by', description: 'ID of the user who created the policy', type: 'integer'),
                    new SA\Property(property: 'updated_by', description: 'ID of the user who last updated the policy', type: 'integer'),
                    new SA\Property(property: 'deleted_by', description: 'ID of the user who deleted the policy', type: 'integer'),
                ]
            ),
        ),
        tags: ['Cotas'],
        responses: [
            new SA\Response(response: 201, description: 'Quota created', content: new SA\JsonContent(type: 'integer')),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ]
    )]
    public function store(): ResponseInterface
    {
        try {
            $quota = QuotasPolicy::create($this->request->all());
            $this->response->json($quota->id);
        } catch (Exception $e) {
            $this->container->get(LoggerInterface::class)
                ->error($e->getMessage());
            throw new ServerException();
        }

        return $this->response->withStatus(201);
    }

    #[SA\Put(
        path: '/quotas/{id}',
        description: 'Atualizar uma cota',
        summary: 'Atualização de uma cota',
        security: [['apiKey' => []]],
        requestBody: new SA\RequestBody(
            description: 'Detalhes dos campos para criar cotas',
            required: true,
            content: new SA\JsonContent(
                required: ['updated_by'],
                properties: [
                    new SA\Property(property: 'name', description: 'Name of the quotas policy', type: 'string'),
                    new SA\Property(property: 'description', description: 'Description of the quotas policy', type: 'string'),
                    new SA\Property(property: 'validity_duration', description: 'Validity duration in days', type: 'integer'),
                    new SA\Property(property: 'status', description: 'Status of the quotas policy', type: 'integer'),
                    new SA\Property(property: 'created_by', description: 'ID of the user who created the policy', type: 'integer'),
                    new SA\Property(property: 'updated_by', description: 'ID of the user who last updated the policy', type: 'integer'),
                    new SA\Property(property: 'deleted_by', description: 'ID of the user who deleted the policy', type: 'integer'),
                ]
            ),
        ),
        tags: ['Cotas'],
        parameters: [new SA\Parameter(parameter: 'id', in: 'path', required: true)],
        responses: [
            new SA\Response(response: 201, description: 'Quota updated'),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 404, description: 'Not found'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ],
    )]
    public function update(int $id): ResponseInterface
    {
        try {
            if (QuotasPolicy::find($id)->update($this->request->all())) {
                return $this->response->withStatus(201);
            }
        } catch (Exception $e) {
            $this->container->get(LoggerInterface::class)
                ->error($e->getMessage());
            throw new ServerException();
        }

        return $this->response->withStatus(404);
    }

    #[SA\Delete(
        path: '/quotas/{id}',
        description: 'Exclui uma política de cotas identificada pelo seu ID. Retorna um status 204 se for bem-sucedido, ou um 404 se não for encontrado.',
        summary: 'Excluir uma política de cotas por ID',
        security: [['apiKey' => []]],
        tags: ['Cotas'],
        parameters: [
            new SA\Parameter(
                name: 'id',
                description: 'ID da política de cotas a ser excluída',
                in: 'path',
                required: true,
                schema: new SA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new SA\Response(response: 204, description: 'Quotas policy deleted successfully'),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 404, description: 'Not Found'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ],
    )]
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
