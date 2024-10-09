<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opportunity_tiebreak_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('opportunity_id');
            $table->unsignedBigInteger('tiebreak_rule_id');
            $table->foreign('tiebreak_rule_id')->references('id')->on('tiebreak_rules');
            $table->integer('sort_order');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunity_tiebreak_rules');
    }
};
