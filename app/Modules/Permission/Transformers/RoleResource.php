<?php
namespace App\Modules\Permission\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'permissions' => PermissionResource::collection($this->permissions->groupBy('order_by'))->values(),
            'created_at' => $this->created_at,
        ];

    }

}
