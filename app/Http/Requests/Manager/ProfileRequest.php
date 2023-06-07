<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;


class ProfileRequest extends FormRequest
{
    /**
     * Determine if the Manager is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->id != $this->route('profile'))
            return false;

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
            'email' => 'required|string|email|max:255|unique:managers,email,' . $this->route('profile'),
            'phone' => 'required|string',
            'identification_number' => 'required|integer',
            'birthdate' => 'required|string',
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
            'phone.required' => __('validation.phone.required'),
            'phone.string' => __('validation.phone.string'),
            'identification_number.required' => __('manager.validation.identification_number.required'),
            'identification_number.integer' => __('manager.validation.identification_number.integer'),
            'identification_number.unique' => __('manager.validation.identification_number.unique'),
            'birthdate.required' => __('manager.validation.birthdate.required'),
            'birthdate.string' => __('manager.validation.birthdate.string'),
        ];
    }
}
