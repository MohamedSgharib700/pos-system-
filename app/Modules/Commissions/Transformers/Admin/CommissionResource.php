<?php

namespace App\Modules\Commissions\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Company\Transformers\Admins\CompanyResource;

class CommissionResource extends JsonResource
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
            'value'=>$this->value,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'created_at' => $this->created_at,
        ];
    }
}
