<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\ApiTokenMiddleware;
use App\Middleware\CorsMiddleware;
use App\Model\AgentQuotasPolicy;
use App\Model\Mapas\Agent;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;


#[Controller(prefix: '/api/v1/agent')]
#[Middlewares(middlewares: [CorsMiddleware::class, ApiTokenMiddleware::class])]
class AgentController extends AbstractController
{
    #[GetMapping(path: '[/]')]
    public function index(): ResponseInterface
    {
        $agentIds = AgentQuotasPolicy::get(['agent_id'])->toArray();

        $agent = Agent::with('quotasPolicy.quotasPolicy')
            ->select(['agent.id', 'name', Db::raw('agent_meta.value as cpf')])
            ->join('agent_meta', function ($join) {
                $join->on('agent.id', '=', 'agent_meta.object_id')
                    ->where('agent_meta.key', '=', 'cpf');
            })
            ->findMany($agentIds);
        $this->response->json($agent);
        return $this->response;
    }
}
