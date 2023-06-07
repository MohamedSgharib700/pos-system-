<?php

namespace App\Modules\Banks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'name' => 'required|array',
            'name.*'   => 'required|string',
        ];
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "name.required" => __("banks::validation.name.required"),
            "name.array" => __("banks::validation.name.array"),
            'name.*.required' => __("banks::validation.name.*.required"),
            'name.*.string' => __("banks::validation.name.*.string")
        ];
    }
}
