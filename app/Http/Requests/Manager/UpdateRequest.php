<?php

namespace App\Http\Requests\Manager;

use App\Models\Manager;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'phone' => 'required|string',
            'identification_number' => 'required|integer|unique:managers,identification_number,' . $this->route('manager'),
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
