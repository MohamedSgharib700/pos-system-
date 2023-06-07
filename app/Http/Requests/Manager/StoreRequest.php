<?php

namespace App\Http\Requests\Manager;

use App\Models\Manager;
use Illuminate\Support\Arr;
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:managers',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string',
            'identification_number' => 'required|integer|unique:managers,identification_number',
            'user_type' => 'required|string|in:'.implode(',',Arr::where(Manager::getTypes(),function($item, $key){return $item != Manager::OWNER;})),
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
            'user_type.required' => __('manager.validation.user_type.required'),
            'user_type.string' => __('manager.validation.user_type.string'),
            'user_type.in' => __('manager.validation.user_type.in'),
        ];
    }

}
