<?php

namespace App\Modules\Company\Http\Requests\Admins;

use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PUT') {
            $owner_id = [
                Rule::exists('managers', 'id')->where(function ($query) {
                    return $query->where('user_type', Manager::OWNER)->where(function ($q) {
                        $q->whereNULL('company_id')
                            ->orWhere('company_id', $this->company['id']  ?? '');
                    });
                }),
            ];
            $finance_manager_id = [
                Rule::exists('managers', 'id')->where(function ($query) {
                    return $query->where('user_type', Manager::FINANCE_MANAGER)->where(function ($q) {
                        $q->whereNULL('company_id')
                            ->orWhere('company_id', $this->company['id'] ?? '');
                    });
                }),
            ];
            $tax_number = 'required|string|max:15|unique:companies,tax_number,' . $this->company['id']  ?? '';
            $commercial_register = 'required|string|max:10|unique:companies,commercial_register,' . $this->company['id']  ?? '';
            $type = 'string|in:' . implode(',', Company::getTypes());
        } else {
            $owner_id = 'required|exists:managers,id,company_id,NULL,user_type,' . Manager::OWNER;
            $finance_manager_id = 'required|exists:managers,id,company_id,NULL,user_type,' . Manager::FINANCE_MANAGER;
            $tax_number = 'required|string|max:15|unique:companies,tax_number';
            $commercial_register = 'required|string|max:10|unique:companies,commercial_register';
            $type = 'required|string|in:' . implode(',', Company::getTypes());
        }

        return [
            'owner_id' => $owner_id,
            'finance_manager_id' => $finance_manager_id,
            'name' => 'required',
            'tax_number' => $tax_number,
            'commercial_register' => $commercial_register,
            'type' => $type,
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
            'name.required' => __('company::validation.name.required'),
            'owner_id.required' => __('company::validation.owner_id.required'),
            'owner_id.exists' => __('company::validation.owner_id.exists'),
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
