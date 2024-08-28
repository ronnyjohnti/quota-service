<?php
declare (strict_types=1);
namespace App\Schema;

use App\Schema\QuotasPolicySchema;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;
#[Schema(title: 'AgentQuotasPolicySchema')]
class AgentQuotasPolicySchema implements JsonSerializable
{
    const string REF = '#/components/schemas/AgentQuotasPolicySchema';

    #[Property(property: 'id', title: '', type: 'int')]
    public ?int $id;
    #[Property(property: 'agent_id', title: '', type: 'int')]
    public ?int $agentId;
    #[Property(property: 'quotas_policy', schema: 'QuotasPolicySchema')]
    public ?int $quotasPolicy;
    #[Property(property: 'start_date', title: '', type: 'mixed')]
    public mixed $startDate;
    #[Property(property: 'end_date', title: '', type: 'mixed')]
    public mixed $endDate;
    #[Property(property: 'created_by', title: '', type: 'int')]
    public ?int $createdBy;
    #[Property(property: 'deleted_by', title: '', type: 'int')]
    public ?int $deletedBy;
    #[Property(property: 'deleted_at', title: '', type: 'mixed')]
    public mixed $deletedAt;
    #[Property(property: 'created_at', title: '', type: 'mixed')]
    public mixed $createdAt;
    #[Property(property: 'updated_at', title: '', type: 'mixed')]
    public mixed $updatedAt;
    public function __construct(\App\Model\AgentQuotasPolicy $model)
    {
        $this->id = $model->id;
        $this->agentId = $model->agent_id;
        $this->quotasPolicy = $model->quotas_policy;
        $this->startDate = $model->start_date;
        $this->endDate = $model->end_date;
        $this->createdBy = $model->created_by;
        $this->deletedBy = $model->deleted_by;
        $this->deletedAt = $model->deleted_at;
        $this->createdAt = $model->created_at;
        $this->updatedAt = $model->updated_at;
    }
    public function jsonSerialize() : mixed
    {
        return [
            'id' => $this->id,
            'agentId' => $this->agentId,
            'quotasPolicy' => $this->quotasPolicy,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'createdBy' => $this->createdBy,
            'deletedBy' => $this->deletedBy,
            'deletedAt' => $this->deletedAt,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}