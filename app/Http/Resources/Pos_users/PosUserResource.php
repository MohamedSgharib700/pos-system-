<?php

namespace App\Http\Resources\Pos_users;

use Illuminate\Http\Resources\Json\JsonResource;

class PosUserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'serial_number' => $this->serial_number,
            'serial_code' => $this->serial_code,
            'identification_number' => $this->identification_number,
            'company' => $this->company,
            'branch' => $this->branch,
            'created_at' => $this->created_at
        ];
    }
}
