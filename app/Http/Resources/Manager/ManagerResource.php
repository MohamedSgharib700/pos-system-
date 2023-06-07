<?php

namespace App\Http\Resources\Manager;

use App\Modules\Permission\Transformers\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Company\Transformers\Admins\CompanyResource;

class ManagerResource extends JsonResource
{

    public function toArray($request)
    {
        $first_role = $this->getRoleNames()->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'identification_number' => $this->identification_number,
            'user_type' => $this->user_type,
            'birthdate' => $this->birthdate,
            'delegation_file' => $this->delegation_file ? $this->delegation_file_url : null,
            'is_active' => (bool)$this->is_active,
            'role' => $first_role ? new RoleResource($first_role) : null,
            'company' => $this->company
        ];
    }
}
