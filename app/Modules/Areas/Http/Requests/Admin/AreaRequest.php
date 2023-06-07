<?php

namespace App\Modules\Areas\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AreaRequest extends FormRequest
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
            'name' => 'required|array',
            'name.ar' =>'required|string|unique:areas,name->ar',
            'name.en' =>'required|string|unique:areas,name->en',

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
            "name.required" => __("areas::validation.name.required"),
            "name.array" => __("areas::validation.name.array"),
            'name.ar.required' => __("areas::validation.name.ar.required"),
            'name.ar.string' => __("areas::validation.name.ar.string"),
            'name.en.required' => __("areas::validation.name.en.required"),
            'name.en.string' => __("areas::validation.name.en.string"),
        ];
    }
}
