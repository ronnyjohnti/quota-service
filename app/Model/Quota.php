<?php

declare(strict_types=1);

namespace App\Model;


/**
 *
 */
class Quota extends Model
{
    public string $keyType = 'integer';

    public bool $incrementing = true;

    protected array $fillable = [
        'name',
        'description',
        'validity_duration',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
