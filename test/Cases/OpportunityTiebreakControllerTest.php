<?php

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;
use PHPUnit\Framework\Attributes\Depends;

class OpportunityTiebreakControllerTest extends HttpTestCase
{
    public function testCreateOpportunityTiebreak(): int
    {
        $data = [
            'opportunity_id' => 4459,
            'tiebreak_rule_id' => 1,
            'sort_order' => 1,
            'created_by' => 114499,
            'updated_by' => 114499,
        ];

        $response = $this->post('/api/v1/tiebreak-rules', $data);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'opportunity_id' => 4459,
                'tiebreak_rule_id' => 1,
                'sort_order' => 1,
                'created_by' => 114499,
                'updated_by' => 114499,
            ]);

        return json_decode($response->getBody()->getContents())->id;
    }

    public function testGetOpportunityTiebreak()
    {
        $this->get('/api/v1/tiebreak-rules')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'rule',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    #[Depends('testCreateOpportunityTiebreak')]
    public function testGetSingleOpportunityTiebreak(int $ruleId)
    {
        $this->get("/api/v1/tiebreak-rules/{$ruleId}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'rule',
                'description',
                'created_at',
                'updated_at',
            ]);
    }

    #[Depends('testCreateOpportunityTiebreak')]
    public function testUpdateOpportunityTiebreak(int $ruleId)
    {
        $data = [
            'rule' => 'Updated Rule',
            'description' => 'Updated Description',
        ];

        $this->put("/api/v1/tiebreak-rules/{$ruleId}", $data)
            ->assertStatus(201)
            ->assertJsonFragment([
                'rule' => 'Updated Rule',
                'description' => 'Updated Description',
                'id' => $ruleId,
            ]);
    }

    #[Depends('testCreateOpportunityTiebreak')]
    public function testDeleteOpportunityTiebreak(int $ruleId)
    {
        $this->delete("/api/v1/tiebreak-rules/{$ruleId}")
            ->assertStatus(204);
    }
}
