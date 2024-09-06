<?php

declare(strict_types=1);

namespace App\Schema;

use App\Model\QuotasPolicy;
use Carbon\Carbon;
use DateTime;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: 'QuotasPolicySchema')]
class QuotasPolicySchema implements JsonSerializable
{
    public const string REF = '#/components/schemas/QuotasPolicySchema';

    #[Property(property: 'id', title: '', type: 'integer')]
    public ?int $id;

    #[Property(property: 'name', title: '', type: 'string')]
    public ?string $name;

    #[Property(property: 'description', title: '', type: 'string')]
    public ?string $description;

    #[Property(property: 'validity_duration', title: '', type: 'integer')]
    public ?int $validityDuration;

    #[Property(property: 'status', title: '', type: 'integer')]
    public ?int $status;

    #[Property(property: 'created_by', title: '', type: 'integer')]
    public ?int $createdBy;

    #[Property(property: 'updated_by', title: '', type: 'integer')]
    public ?int $updatedBy;

    #[Property(property: 'deleted_by', title: '', type: 'integer')]
    public ?int $deletedBy;

    #[Property(property: 'deleted_at', title: '', type: 'string')]
    public Carbon|DateTime $deletedAt;

    #[Property(property: 'created_at', title: '', type: 'string')]
    public Carbon|DateTime $createdAt;

    #[Property(property: 'updated_at', title: '', type: 'string')]
    public Carbon|DateTime $updatedAt;

    public function __construct(QuotasPolicy $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->description = $model->description;
        $this->validityDuration = $model->validity_duration;
        $this->status = $model->status;
        $this->createdBy = $model->created_by;
        $this->updatedBy = $model->updated_by;
        $this->deletedBy = $model->deleted_by;
        $this->deletedAt = $model->deleted_at;
        $this->createdAt = $model->created_at;
        $this->updatedAt = $model->updated_at;
    }

    public function jsonSerialize(): mixed
    {
        return ['id' => $this->id, 'name' => $this->name, 'description' => $this->description, 'validity_duration' => $this->validityDuration, 'status' => $this->status, 'created_by' => $this->createdBy, 'updated_by' => $this->updatedBy, 'deleted_by' => $this->deletedBy, 'deleted_at' => $this->deletedAt, 'created_at' => $this->createdAt, 'updated_at' => $this->updatedAt];
    }
}
