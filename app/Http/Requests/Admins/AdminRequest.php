<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()  :bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() :array
    {
        if ($this->method() == 'PUT') {
            $email = 'required|email|unique:admins,email,' . $this->admin;
            $password = 'nullable|confirmed';

        } else {
            $email = 'required|email|unique:admins,email';
            $password = 'required|confirmed';
        }
        $data = [
            'name' => 'required|string',
            'email' => $email,
            'roles' => 'required|exists:roles,name',
        ];
        if (request('password')) {
            $data['password'] = $password;
        }

        return $data;
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages() :array
    {
        return [
            'name.required' => __('validation.name.required'),
            'name.string' => __('validation.name.string'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.unique' => __('validation.email.unique'),
            'password.required' => __('validation.password.required'),
            'password.confirmed' => __('validation.password.confirmed'),
            'roles.required' => __('validation.roles.required'),
            'roles.exists' => __('validation.roles.exists'),
        ];
    }
}
