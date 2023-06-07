<?php

namespace App\Modules\Commissions\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Commissions\Entities\Commission;

class CommissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value'=>'required|integer|min:1',
            'company_id'=>'required|integer|exists:companies,id',
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
            "value.required" => __("commissions::validation.value.required"),
            "value.integer" => __("commissions::validation.value.integer"),
            "value.min" => __("commissions::validation.value.min"),
            'company_id.required' => __('commissions::validation.company_id.required'),
            'company_id.integer' => __('commissions::validation.company_id.integer'),
            'company_id.exists' => __('commissions::validation.company_id.exists'),
        ];
    }
}
