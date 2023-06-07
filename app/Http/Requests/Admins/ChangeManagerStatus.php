<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;

class ChangeManagerStatus extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_active'=>'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'is_active.required' => 'فضلا توضيح الحالة',
            'is_active.boolean' => 'الحالة يحب ان تكون اما 1 او 0'
        ];
    }
}
