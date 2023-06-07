<?php

namespace App\Modules\Cities\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CityRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'name'      => 'required|array',
            'name.ar' =>'required|string|unique:cities,name->ar',
            'name.en' =>'required|string|unique:cities,name->en',
            'area_id'   =>'required|exists:areas,id,deactivated_at,NULL',
        ];
    }

    /**
     * Messages of validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "name.required" => __("cities::validation.name.required"),
            "name.array" => __("cities::validation.name.array"),
            'name.ar.required' => __("cities::validation.name.ar.required"),
            'name.ar.string' => __("cities::validation.name.ar.string"),
            'name.en.required' => __("cities::validation.name.en.required"),
            'name.en.string' => __("cities::validation.name.en.string"),
            'area_id.required' => __('cities::validation.area_id.required'),
            'area_id.exists' => __('cities::validation.area_id.exists'),
        ];
    }

}
