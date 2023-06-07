<?php

namespace App\Modules\BanksAccounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanksAccountRequest extends FormRequest
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
            'model_id' => 'required|int',
            'model_type' => 'required|string',
            'bank_id' => 'required|int|exists:banks,id',
            'iban' => 'required|string',
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
            'model_id.required' => __('banks_accounts::validation.model_id.required'),
            'model_id.int' => __('banks_accounts::validation.model_id.int'),
            'model_type.required' => __('banks_accounts::validation.model_type.required'),
            'model_type.string' => __('banks_accounts::validation.model_type.string'),
            'bank_id.required' => __('banks_accounts::validation.banck.required'),
            'bank_id.int' => __('banks_accounts::validation.banck.int'),
            'iban.required' => __('banks_accounts::validation.iban.required'),
            'iban.string' => __('banks_accounts::validation.iban.string'),
        ];
    }
}
