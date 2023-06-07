<?php

namespace App\Http\Resources\Admins;

use App\Modules\Permission\Transformers\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request) :array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // FIXED :: Error in Permissions resourse
            'role' => new RoleResource($this->getRoleNames()->first()),
            'email' => $this->email,
            'created_at' => $this->created_at,
        ];
    }
}
