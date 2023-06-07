<?php

namespace App\Http\Requests\PosUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the Manager is authorized to make this request.
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
            'company_id' => 'required|int|exists:companies,id',
            'branch_id' => 'required|int|exists:branches,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pos_users',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string',
            'identification_number' => 'required|integer',
            'serial_number' => 'required|integer',
            'serial_code' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => __('pos_user.validation.company_id.required'),
            'company_id.int' => __('pos_user.validation.company_id.integer'),
            'company_id.exists' => __('pos_user.validation.company_id.exists'),
            'branch_id.required' => __('pos_user.validation.branch_id.required'),
            'branch_id.int' => __('pos_user.validation.branch_id.integer'),
            'branch_id.exists' => __('pos_user.validation.branch_id.exists'),
            'name.required' => __('validation.name.required'),
            'name.string' => __('validation.name.string'),
            'name.max' => __('validation.name.max'),
            'email.required' => __('validation.email.required'),
            'email.string' => __('validation.email.string'),
            'email.email' => __('validation.email.email'),
            'email.max' => __('validation.email.max'),
            'email.unique' => __('validation.email.unique'),
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
            'phone.required' => __('validation.phone.required'),
            'phone.string' => __('validation.phone.string'),
            'identification_number.required' => __('pos_user.validation.identification_number.required'),
            'identification_number.integer' => __('pos_user.validation.identification_number.integer'),
            'serial_number.required' => __('pos_user.validation.serial_number.required'),
            'serial_number.integer' => __('pos_user.validation.serial_number.integer'),
            'serial_code.required' => __('pos_user.validation.serial_code.required'),
            'serial_code.integer' => __('pos_user.validation.serial_code.integer')
        ];
    }
}
