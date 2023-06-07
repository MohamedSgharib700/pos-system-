<?php

namespace App\Modules\Branch\Transformers\Admin;

use App\Modules\Cities\Transformers\Admin\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'name' => $this->name,
            'company' => $this->company,
            'manager' => $this->manager,
            'city' => new CityResource($this->city),
            'pos_users' => $this->posUsers,
            'deactivated_at' => $this->deactivated_at,
            'created_at' => $this->created_at,
        ];
    }
}
