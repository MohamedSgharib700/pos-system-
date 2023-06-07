<?php

namespace App\Modules\ServicesProviders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesProviderRequest extends FormRequest
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
            'name.*' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('servicesproviders::validation.name.required'),
            'name.array' => __('servicesproviders::validation.name.array'),
            'name.*.required' => __('servicesproviders::validation.name.*.required'),
            'name.*.string' => __('servicesproviders::validation.name.*.string'),
        ];
    }
}
