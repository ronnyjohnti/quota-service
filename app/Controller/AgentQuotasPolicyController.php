<?php

namespace App\Controller;

use App\Model\AgentQuotasPolicy;
use Hyperf\Database\Model\Collection;

class AgentQuotasPolicyController extends AbstractController
{
    public function index(): Collection
    {
        return AgentQuotasPolicy::get();
    }

    public function show(int $id): AgentQuotasPolicy
    {
        return AgentQuotasPolicy::findOrFail($id);
    }

    public function store(): AgentQuotasPolicy
    {
        $data = $this->request->all();
        $attributes = [
            'agent_id' => $data['agent_id'],
            'quotas_policy_id' => $data['quotas_policy_id'],
        ];
        return AgentQuotasPolicy::updateOrCreate($attributes, $data);
    }

    public function delete(int $id): void
    {
        $this->response->withStatus(204);
        AgentQuotasPolicy::findOrFail($id)?->delete();
    }
}
