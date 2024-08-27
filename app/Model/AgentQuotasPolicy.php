<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

class AgentQuotasPolicy extends Model
{
    use SoftDeletes;

    public string $keyType = 'integer';

    public bool $incrementing = true;

    protected array $fillable = [
        'agent_id',
        'quotas_policy_id',
        'start_date',
        'end_date',
        'created_by',
        'deleted_by',
    ];
}
