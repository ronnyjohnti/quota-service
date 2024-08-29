<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\Relations\HasOne;
use Hyperf\Database\Model\SoftDeletes;

class AgentQuotasPolicy extends Model
{
    use SoftDeletes;

    public string $keyType = 'integer';

    public bool $incrementing = true;

    protected array $fillable = [
        'agent_id',
        'start_date',
        'end_date',
        'created_by',
        'deleted_by',
    ];

    public function quotasPolicy(): HasOne
    {
        return $this->hasOne(QuotasPolicy::class, 'id', 'quotas_policy_id');
    }
}
