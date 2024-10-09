<?php
declare(strict_types=1);

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;
use PHPUnit\Framework\Attributes\Depends;

class TiebreakRuleControllerTest extends HttpTestCase
{
    public function testCreateTiebreakRule(): int
    {
        $data = [
            'rule' => 'Rule 1',
            'description' => 'Description 1',
            'created_by' => 114499,
            'updated_by' => 114499,
        ];

        $response = $this->post('/api/v1/tiebreak-rules', $data);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'rule' => 'Rule 1',
                'description' => 'Description 1',
                'created_by' => 114499,
            ]);

        return json_decode($response->getBody()->getContents())->id;
    }

    public function testGetTiebreakRules(): void
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

    #[Depends('testCreateTiebreakRule')]
    public function testGetSingleTiebreakRule(int $ruleId): void
    {
        print_r($ruleId . PHP_EOL);
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

    #[Depends('testCreateTiebreakRule')]
    public function testUpdateTiebreakRule(int $ruleId): void
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

    #[Depends('testCreateTiebreakRule')]
    public function testDeleteTiebreakRule(int $ruleId): void
    {
        $this->delete("/api/v1/tiebreak-rules/{$ruleId}")
            ->assertStatus(204);
    }
}
