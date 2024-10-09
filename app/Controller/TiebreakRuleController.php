<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\TiebreakRule;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\Server\Exception\ServerException;
use Hyperf\Swagger\Annotation as SA;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use OpenApi\Attributes\Schema;
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
class TiebreakRuleController extends AbstractController
{
    #[SA\Get(
        path: '/tiebreak-rules',
        description: 'Retorna uma lista de todas as regras desempate disponíveis',
        summary: 'Lista as regras de desempate',
        security: [['apiKey' => []]],
        tags: ['Regras de Desempate'],
        responses: [
            new SA\Response(response: 200, content: new SA\MediaType(
                mediaType: 'application/json',
            )),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ],
    )]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $rules = TiebreakRule::get();
        return $response->json($rules);
    }

    #[SA\Get(
        path: '/tiebreak-rules/{id}',
        summary: 'Consulta uma regra pelo ID',
        security: [['apiKey' => []]],
        tags: ['Regras de Desempate'],
        parameters: [
            new SA\Parameter(
                name: 'id',
                description: 'Tiebreak Rule ID',
                in: 'path',
                required: true,
                schema: new Schema(type: 'string', example: 1),
            ),
        ],
        responses: [
            new SA\Response(response: 200, description: 'Success', content: new SA\MediaType(
                mediaType: 'application/json',
            )),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 404, description: 'Not found'),
            new SA\Response(response: 500, description: 'Internal server error'),
        ],
    )]
    public function show(int $id): \Psr\Http\Message\ResponseInterface
    {
        $rule = TiebreakRule::find($id);
        if ($rule === null) {
            throw new NotFoundHttpException();
        }

        $this->response->json($rule);
        return $this->response;
    }

    #[SA\Post(
        path: '/tiebreak-rules',
        description: 'Cria regra de desempate',
        summary: 'Criação de uma regra de desempate',
        security: [['apiKey' => []]],
        requestBody: new SA\RequestBody(
            description: 'Detalhes dos campos para criar regras de desempate',
            required: true,
            content: new SA\JsonContent(
                required: ['rule', 'created_by'],
                properties: [
                    new SA\Property(property: 'rule', description: 'Name of the tiebreak rule', type: 'string'),
                    new SA\Property(property: 'description', description: 'Description of the tiebreak rule', type: 'string'),
                    new SA\Property(property: 'created_by', description: 'ID of the user who created the rule', type: 'integer'),
                    new SA\Property(property: 'updated_by', description: 'ID of the user who last updated the rule', type: 'integer'),
                    new SA\Property(property: 'deleted_by', description: 'ID of the user who deleted the rule', type: 'integer'),
                ]
            ),
        ),
        tags: ['Regras de Desempate'],
        responses: [
            new SA\Response(response: 201, description: 'Rule created', content: new SA\JsonContent(type: 'integer')),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ]
    )]
    public function store(): ResponseInterface
    {
        try {
            $rule = TiebreakRule::create($this->request->all());
            $this->response->json($rule);
        } catch (Exception $e) {
            $this->container->get(LoggerInterface::class)
                ->error($e->getMessage());
            throw new ServerException();
        }

        return $this->response->withStatus(201);
    }

    #[SA\Put(
        path: '/tiebreak-rules/{id}',
        description: 'Atualizar uma regra de desempate',
        summary: 'Atualização de uma regra de desempate',
        security: [['apiKey' => []]],
        requestBody: new SA\RequestBody(
            description: 'Detalhes dos campos para regra de desempate',
            required: true,
            content: new SA\JsonContent(
                required: ['updated_by'],
                properties: [
                    new SA\Property(property: 'rule', description: 'Name of the tiebreak rule', type: 'string'),
                    new SA\Property(property: 'description', description: 'Description of the tiebreak rule', type: 'string'),
                    new SA\Property(property: 'created_by', description: 'ID of the user who created the rule', type: 'integer'),
                    new SA\Property(property: 'updated_by', description: 'ID of the user who last updated the rule', type: 'integer'),
                    new SA\Property(property: 'deleted_by', description: 'ID of the user who deleted the rule', type: 'integer'),
                ]
            ),
        ),
        tags: ['Regras de Desempate'],
        parameters: [new SA\Parameter(parameter: 'id', in: 'path', required: true)],
        responses: [
            new SA\Response(response: 201, description: 'Rule updated'),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 404, description: 'Not found'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ],
    )]
    public function update(int $id): ResponseInterface
    {
        try {
            $rule = TiebreakRule::find($id);
            $updated = $rule->update($this->request->all());
            if ($updated) {
                $this->response->json($rule);
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
        path: '/tiebreak-rules/{id}',
        description: 'Exclui uma regra de desempate identificada pelo seu ID. Retorna um status 204 se for bem-sucedido, ou um 404 se não for encontrado.',
        summary: 'Excluir uma regra de desempate por ID',
        security: [['apiKey' => []]],
        tags: ['Regras de Desempate'],
        parameters: [
            new SA\Parameter(
                name: 'id',
                description: 'ID da regra de desempate a ser excluída',
                in: 'path',
                required: true,
                schema: new SA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new SA\Response(response: 204, description: 'Rule deleted successfully'),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 404, description: 'Not Found'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ],
    )]
    public function delete(int $id): ResponseInterface
    {
        try {
            if (TiebreakRule::destroy([$id])) {
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
