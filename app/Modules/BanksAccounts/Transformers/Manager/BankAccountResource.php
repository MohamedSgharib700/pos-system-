<?php

namespace App\Modules\BanksAccounts\Transformers\Manager;

use App\Modules\Banks\Transformers\Admin\BankResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
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
            'bank' => new BankResource($this->bank),
            'iban' => $this->iban,
            'deactivated_at' => $this->deactivated_at,
            'created_at' => $this->created_at,
        ];
    }
}
