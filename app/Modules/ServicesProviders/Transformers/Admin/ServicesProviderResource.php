<?php

namespace App\Modules\ServicesProviders\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicesProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'deactivated_at' => $this->deactivated_at,
            'created_at' => $this->created_at,
        ];
    }
}
