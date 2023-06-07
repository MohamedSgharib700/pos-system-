<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;


class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:managers',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string',
            'identification_number' => 'required|integer|unique:managers,identification_number',
            'birthdate' => 'required|string',
            'tax_number' => 'required_without:delegation_file|string|max:15|unique:companies,tax_number',
            'commercial_registration_number'=>'required_without:delegation_file|string|max:10|unique:companies,commercial_register',
            'delegation_file'=>'file|mimes:jpg,jpeg,png,pdf|max:5120'
        ];
    }

    public function messages()
    {
        return [
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
            'identification_number.required' => __('manager.validation.identification_number.required'),
            'identification_number.integer' => __('manager.validation.identification_number.integer'),
            'identification_number.unique' => __('manager.validation.identification_number.unique'),
            'birthdate.required' => __('manager.validation.birthdate.required'),
            'birthdate.string' => __('manager.validation.birthdate.string'),
            'tax_number.required_without' => __('manager.validation.tax_number.required_without'),
            'tax_number.string' => __('manager.validation.tax_number.string'),
            'tax_number.max' => __('manager.validation.tax_number.max'),
            'tax_number.unique' => __('manager.validation.tax_number.unique'),
            'commercial_registration_number.required_without' => __('manager.validation.commercial_registration_number.required_without'),
            'commercial_registration_number.string' => __('manager.validation.commercial_registration_number.string'),
            'commercial_registration_number.max' => __('manager.validation.commercial_registration_number.max'),
            'commercial_registration_number.unique' => __('manager.validation.commercial_registration_number.unique'),
            'delegation_file.file' => __('manager.validation.delegation_file.file'),
            'delegation_file.mimes' => __('manager.validation.delegation_file.mimes'),
            'delegation_file.max' => __('manager.validation.delegation_file.max'),
        ];
    }
}
