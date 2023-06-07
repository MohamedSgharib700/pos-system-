<?php

namespace App\Modules\Branch\Http\Requests\Manager;

use App\Models\Manager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'city_id' => 'required|exists:cities,id',
            'manager_id' => [
                'required',
                Rule::exists('managers', 'id')->where(function ($query) {
                    return $query->where('user_type', Manager::BRANCH_MANAGER)->where(function ($q) {
                        $q->where('company_id', auth()->user()->company_id);
                    });
                }),
            ],
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
