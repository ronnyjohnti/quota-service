<?php

declare(strict_types=1);

use Carbon\Carbon;
use Hyperf\Database\Seeders\Seeder;
use App\Model\AgentQuotasPolicy as AgentQuotasPolicyModel;
use App\Model\QuotasPolicy as QuotasPolicyModel;

class AgentQuotasPolicy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [[
            'agent_id' => 143224,
            'created_by' => 114499,
        ], [
            'agent_id' => 143223,
            'created_by' => 114499,
        ], [
            'agent_id' => 143222,
            'created_by' => 114499,
        ], [
            'agent_id' => 143221,
            'created_by' => 114499,
        ], [
            'agent_id' => 143220,
            'created_by' => 114499,
        ], [
            'agent_id' => 143219,
            'created_by' => 114499,
        ], [
            'agent_id' => 143215,
            'created_by' => 114499,
        ], [
            'agent_id' => 143213,
            'created_by' => 114499,
        ], [
            'agent_id' => 143212,
            'created_by' => 114499,
        ]];

        foreach ($data as $item) {
            $policy = QuotasPolicyModel::get()->random(1)->first();
            $item['quotas_policy'] = $policy;
            $item['start_date'] = Carbon::now()->subDays(rand(0, 365));
            $item['end_date'] = $item['start_date']->copy()->addYears($policy->validity_duration);
            AgentQuotasPolicyModel::create($item);
        }
    }
}
