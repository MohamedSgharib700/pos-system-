<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class BranchManagerRequest extends FormRequest
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
            'branch_id'=>'exists:branches,id,company_id,'. auth()->user()->company_id
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'branch_id.exists' => __('manager.validation.branch_id.exists'),
        ];
    }
}
