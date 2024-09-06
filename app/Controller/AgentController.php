<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\AgentQuotasPolicy;
use App\Model\Mapas\Agent;
use Hyperf\DbConnection\Db;
use Hyperf\Swagger\Annotation as SA;
use Psr\Http\Message\ResponseInterface;

#[SA\HyperfServer('http')]
class AgentController extends AbstractController
{
    #[SA\Get(
        path: '/agent',
        summary: 'Listar agentes',
        security: [['apiKey' => []]],
        tags: ['Agent'],
        parameters: [],
        responses: [
            new SA\Response(response: 200, description: 'Lista de agentes', content: new SA\MediaType(
                mediaType: 'application/json',
            )),
        ]
    )]
    public function index(): ResponseInterface
    {
        $filterIds = explode(',', $this->request->query('filter_agent_ids') ?? '');
        if (count($filterIds) !== 1 or $filterIds[0] !== '') {
            $agentIds = $filterIds;
        }
        $agentIds ??= AgentQuotasPolicy::get(['agent_id'])->toArray();
        $query = Agent::with('quotasPolicy.quotasPolicy')
            ->select(['agent.id', 'name', Db::raw('agent_meta.value as cpf')])
            ->join('agent_meta', function ($join) {
                $join->on('agent.id', '=', 'agent_meta.object_id')
                    ->where('agent_meta.key', '=', 'cpf');
            });

        $agents = $query->findMany($agentIds);

        if (count($filterIds) !== 1 or $filterIds[0] !== '') {
            $agents = $agents->filter(function ($agent) {
                return preg_match('/[R|r]acial/', implode(
                    '',
                    array_map(fn ($value) => $value['quotas_policy']['name'], $agent->quotasPolicy->toArray())
                ));
            });
        }

        return $this->response->json($agents);
    }
}
