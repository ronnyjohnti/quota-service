<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\AgentQuotasPolicy;
use App\Model\QuotasPolicy;
use App\Schema\AgentQuotasPolicySchema;
use Carbon\Carbon;
use Exception;
use Hyperf\Database\Model\Collection;
use Hyperf\Swagger\Annotation as SA;
use OpenApi\Attributes\Schema;

#[SA\HyperfServer('http')]
class AgentQuotasPolicyController extends AbstractController
{
    #[SA\Get(
        path: '/agent-quotas',
        description: 'Retorna uma lista de todos os relacionamento entre agentes e cotas',
        summary: 'Lista todos os relacionamento entre agentes e cotas',
        security: [['apiKey' => []]],
        tags: ['Cotas do Agente'],
        responses: [
            new SA\Response(response: 200, content: new SA\MediaType(
                mediaType: 'application/json',
                schema: new SA\Schema(type: 'array', items: new SA\Items(ref: AgentQuotasPolicySchema::REF))
            )),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 500, description: 'Internal Server Error'),
        ],
    )]
    public function index(): Collection
    {
        return AgentQuotasPolicy::get();
    }

    #[SA\Get(
        path: '/agent-quotas/{id}',
        summary: 'Devolvendo uma relação entre agente e cota pelo id',
        security: [['apiKey' => []]],
        tags: ['Cotas do Agente'],
        parameters: [
            new SA\Parameter(
                name: 'id',
                description: 'Agent Quota ID',
                in: 'path',
                required: true,
                schema: new Schema(type: 'string', example: 1),
            ),
        ],
        responses: [
            new SA\Response(response: 200, description: 'Success', content: new SA\MediaType(
                mediaType: 'application/json',
                schema: new Schema(ref: AgentQuotasPolicySchema::REF),
            )),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 404, description: 'Not found'),
            new SA\Response(response: 500, description: 'Internal server error'),
        ],
    )]
    public function show(int $id): AgentQuotasPolicy
    {
        return AgentQuotasPolicy::findOrFail($id);
    }

    #[SA\Post(
        path: '/agent-quotas',
        description: 'Relacionamento entre agente e cota',
        summary: 'Relacionamento entre agente e cota',
        security: [['apiKey' => []]],
        requestBody: new SA\RequestBody(
            description: "Detalhes dos campos para criar cotas",
            required: true,
            content: [new SA\MediaType(
                mediaType: 'application/json',
                schema: new SA\Schema(ref: AgentQuotasPolicySchema::REF),
            )],
        ),
        tags: ['Cotas do Agente'],
        responses: [
            new SA\Response(response: 201, description: 'Quota created', content: new SA\JsonContent(type: 'integer')),
            new SA\Response(response: 401, description: 'Unauthorized'),
            new SA\Response(response: 500, description: 'Internal Server Error')
        ]
    )]
    public function store(): AgentQuotasPolicy
    {
        $data = $this->request->all();
        $attributes = [
            'agent_id' => $data['agent_id'],
            'quotas_policy_id' => $data['quotas_policy_id'],
        ];

        $quota = QuotasPolicy::find($data['quotas_policy_id']);
        $data['end_date'] = (new Carbon($data['start_date']))->addYears($quota->validity_duration);
        return AgentQuotasPolicy::updateOrCreate($attributes, $data);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $this->response->withStatus(204);
        AgentQuotasPolicy::findOrFail($id)?->delete();
    }
}
