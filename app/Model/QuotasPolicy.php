<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

class QuotasPolicy extends Model
{
    use SoftDeletes;

    public string $keyType = 'integer';

    public bool $incrementing = true;

    protected array $fillable = [
        'name',
        'description',
        'validity_duration',
        'status',
        'show_in_dashboard',
        'show_in_opportunity',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
