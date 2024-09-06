<?php

declare(strict_types=1);

namespace App\Model\Mapas;

use App\Model\AgentQuotasPolicy;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\DbConnection\Model\Model;

/**
 * @property string $id
 * @property string $parent_id
 * @property string $user_id
 * @property int $type
 * @property string $name
 * @property string $location
 * @property string $_geo_location
 * @property string $short_description
 * @property string $long_description
 * @property string $create_timestamp
 * @property int $status
 * @property bool $is_verified
 * @property bool $public_location
 * @property string $update_timestamp
 * @property string $subsite_id
 */
class Agent extends Model
{
    protected ?string $table = 'agent';

    protected ?string $connection = 'mapas';

    protected array $fillable = [];

    protected array $casts = [
        'type' => 'integer',
        'status' => 'integer',
        'is_verified' => 'boolean',
        'public_location' => 'boolean',
    ];

    public function quotasPolicy(): HasMany
    {
        return $this->hasMany(AgentQuotasPolicy::class, 'agent_id', 'id');
    }
}
