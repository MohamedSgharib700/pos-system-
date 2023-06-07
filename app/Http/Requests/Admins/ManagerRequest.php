<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:managers,email,' . optional($this->route('manager'))->id ?? '',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|unique:managers,phone,' . optional($this->route('manager'))->id ?? '',
            'identification_number' => 'required|integer|unique:managers,identification_number,' . optional($this->route('manager'))->id ?? '',
            'user_type' => 'required|in:owner',
            'birthdate' => 'required',
        ];
    }

    /**
     * Return messages of validation.
     *
     * @return array
     */
    public function messages() :array
    {
        return [
            'name.required' => __('validation.name.required'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.unique' => __('validation.email.unique'),
            'password.required' => __('validation.password.required'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
            'phone.required' => __('validation.phone.required'),
            'phone.unique' => __('validation.phone.unique'),
            'identification_number.required' => __('manager.validation.identification_number.required'),
            'identification_number.integer' => __('manager.validation.identification_number.integer'),
            'identification_number.unique' => __('manager.validation.identification_number.unique'),
            'birthdate.required' => __('manager.validation.birthdate.required'),
            'user_type.required' => __('manager.validation.user_type.required'),
            'user_type.in' => __('manager.validation.user_type.in'),
        ];
    }
}
