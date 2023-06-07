<?php

namespace App\Modules\Company\Http\Requests\Manager;

use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        if ($request->has('owner_id')) {
            return $request->owner_id == auth()->id();
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PUT') {
            $finance_manager = [
                'nullable',
                'integer',
                Rule::exists('managers', 'id')->where(function ($query) {
                    return $query->where('user_type', Manager::FINANCE_MANAGER)->where(function ($q) {
                        $q->whereNULL('company_id')
                            ->orWhere('company_id', auth('manager')->user()->company->id ?? '');
                    });
                }),
            ];
            $tax_number = 'required|string|max:15|unique:companies,tax_number,' . auth('manager')->user()->company->id ?? '';
            $commercial_register = 'required|string|max:10|unique:companies,commercial_register,' . auth('manager')->user()->company->id ?? '';
            $type = 'string|in:' . implode(',', Company::getTypes());
        } else {
            $finance_manager = 'nullable|integer|exists:managers,id,company_id,NULL,user_type,' . Manager::FINANCE_MANAGER;
            $tax_number = 'required|string|max:15|unique:companies,tax_number';
            $commercial_register = 'required|string|max:10|unique:companies,commercial_register';
            $type = 'required|string|in:' . implode(',', Company::getTypes());
        }

        return [
            'name' => 'required',
            'finance_manager_id' => $finance_manager,
            'tax_number' => $tax_number,
            'commercial_register' => $commercial_register,
            'type' => $type,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('company::validation.name.required'),
            'finance_manager_id.required' => __('company::validation.finance_manager.required'),
            'finance_manager_id.exists' => __('company::validation.finance_manager.exists'),
            'tax_number.required' => __('company::validation.tax_number.required'),
            'tax_number.string' => __('company::validation.tax_number.string'),
            'tax_number.max' => __('company::validation.tax_number.max'),
            'tax_number.unique' => __('company::validation.tax_number.unique'),
            'commercial_register.required' => __('company::validation.commercial_register.required'),
            'commercial_register.string' => __('company::validation.commercial_register.string'),
            'commercial_register.max' => __('company::validation.commercial_register.max'),
            'commercial_register.unique' => __('company::validation.commercial_register.unique'),
            'type.required' => __('company::validation.type.required'),
            'type.string' => __('company::validation.type.string'),
            'type.in' => __('company::validation.type.in'),
        ];
    }
}
