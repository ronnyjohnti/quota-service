<?php

declare(strict_types=1);

use App\Model\QuotasPolicy as QuotasPolicyModel;
use Hyperf\Database\Seeders\Seeder;

class QuotasPolicy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quotasPolicies = [[
            'name' => 'Cota racial',
            'description' => 'Cota racial',
            'show_in_dashboard' => true,
            'show_in_opportunity' => false,
            'validity_duration' => 2,
            'status' => 1,
            'created_by' => 114499,
        ], [
            'name' => 'Cota PCD',
            'description' => 'Cota PCD',
            'show_in_dashboard' => false,
            'show_in_opportunity' => true,
            'validity_duration' => 4,
            'status' => 1,
            'created_by' => 114499,
        ], [
            'name' => 'Cota Quilombola',
            'description' => 'Cota Quilombola',
            'show_in_dashboard' => false,
            'show_in_opportunity' => true,
            'validity_duration' => 4,
            'status' => 1,
            'created_by' => 114499,
        ], [
            'name' => 'Cota indígena',
            'description' => 'Cota indígena',
            'show_in_dashboard' => false,
            'show_in_opportunity' => true,
            'validity_duration' => 2,
            'status' => 1,
            'created_by' => 114499,
        ]];

        foreach ($quotasPolicies as $quotasPolicyData) {
            QuotasPolicyModel::create($quotasPolicyData);
        }

        // DB::table('quotas_policies')->insert($quotasPolicies);
    }
}
