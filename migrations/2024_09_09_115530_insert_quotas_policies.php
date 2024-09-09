<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use App\Model\QuotasPolicy as QuotasPolicyModel;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $quotasPolicies = [[
            'id', 9,
            'name' => 'Cota Racial',
            'description' => 'Cota Racial',
            'show_in_dashboard' => true,
            'show_in_opportunity' => false,
            'validity_duration' => 2,
            'status' => 1,
            'created_by' => 114499,
        ], [
            'id', 10,
            'name' => 'Cota PCD',
            'description' => 'Cota PCD',
            'show_in_dashboard' => false,
            'show_in_opportunity' => true,
            'validity_duration' => 2,
            'status' => 1,
            'created_by' => 114499,
        ], [
            'id', 11,
            'name' => 'Cota Quilombola',
            'description' => 'Cota Quilombola',
            'show_in_dashboard' => false,
            'show_in_opportunity' => true,
            'validity_duration' => 4,
            'status' => 1,
            'created_by' => 114499,
        ], [
            'id', 12,
            'name' => 'Cota Indígena',
            'description' => 'Cota Indígena',
            'show_in_dashboard' => false,
            'show_in_opportunity' => true,
            'validity_duration' => 4,
            'status' => 1,
            'created_by' => 114499,
        ]];

        foreach ($quotasPolicies as $quotasPolicyData) {
            QuotasPolicyModel::create($quotasPolicyData);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        QuotasPolicyModel::destroy([9, 10, 11, 12]);
    }
};
