<?php

namespace App\Modules\Cities\Transformers\Admin;

use App\Modules\Areas\Transformers\Admin\AreaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'id'                    => $this->id,
            'name'                  => $this->name,
            'deactivated_at'        => $this->deactivated_at,
            'area'                  => new AreaResource($this->area ),
            'created_at' => $this->created_at,
        ];
    }
}
