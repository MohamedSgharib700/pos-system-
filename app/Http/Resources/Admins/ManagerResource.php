<?php

namespace App\Http\Resources\Admins;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'identification_number' => $this->identification_number,
            'user_type' => $this->user_type,
            'birthdate' => $this->birthdate,
            'is_active' => (bool)$this->is_active,
            'delegation_file' => $this->delegation_file ? $this->delegation_file_url : null,
            'deactivated_at' => $this->deactivated_at,
            'created_at' => $this->created_at,
        ];
    }
}
