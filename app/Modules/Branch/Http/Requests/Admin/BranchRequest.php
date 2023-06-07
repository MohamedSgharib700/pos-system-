<?php

namespace App\Modules\Branch\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'required|exists:managers,id',
            'city_id' => 'required|exists:cities,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => __('branch::validation.name.required'),
            'company_id.required' => __('branch::validation.company_id.required'),
            'company_id.exists' => __('branch::validation.company_id.exists'),
            'manager_id.required' => __('branch::validation.manager_id.required'),
            'manager_id.exists' => __('branch::validation.manager_id.exists'),
            'city_id.required' => __('branch::validation.city_id.required'),
            'city_id.exists' => __('branch::validation.city_id.exists'),
        ];
    }
}
