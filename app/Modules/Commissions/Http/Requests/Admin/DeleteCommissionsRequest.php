<?php

namespace App\Modules\Commissions\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCommissionsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commissions'=>'required|array',
            'commissions.*'=>'required|integer|exists:commissions,id'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
