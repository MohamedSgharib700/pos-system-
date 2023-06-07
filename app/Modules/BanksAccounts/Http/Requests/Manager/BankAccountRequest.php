<?php

namespace App\Modules\BanksAccounts\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_id' => 'required|int|exists:banks,id',
            'iban' => 'required|string|unique:banks_accounts,iban,' . $this->route('bank_account') . ',id',
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

    /**
     * Messages of validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'bank_id.required' => __('banks_accounts::validation.banck.required'),
            'bank_id.int' => __('banks_accounts::validation.banck.int'),
            'bank_id.exists' => __('banks_accounts::validation.banck.exists'),
            'iban.required' => __('banks_accounts::validation.iban.required'),
            'iban.string' => __('banks_accounts::validation.iban.string'),
            'iban.unique' => __('banks_accounts::validation.iban.unique')
        ];
    }
}
