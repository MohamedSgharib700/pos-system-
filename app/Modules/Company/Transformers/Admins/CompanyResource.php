<?php

namespace App\Modules\Company\Transformers\Admins;

use App\Modules\Branch\Transformers\Manager\BranchResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner' => $this->owner,
            'finance_manager' => $this->financeManager,
            'name' => $this->name,
            'tax_number' => $this->tax_number,
            'commercial_register' => $this->commercial_register,
            'branches'=> $this->relationLoaded('branches') ? BranchResource::collection($this->branches) : [],
            'type' => $this->type,
            'deactivated_at' => $this->deactivated_at,
            'created_at' => $this->created_at,
        ];
    }
}
