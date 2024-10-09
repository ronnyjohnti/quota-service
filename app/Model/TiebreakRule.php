<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class TiebreakRule extends Model
{
    public string $keyType = 'integer';

    public bool $incrementing = true;

    protected array $fillable = [
        'rule',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
