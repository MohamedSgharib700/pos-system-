<?php

namespace App\Http\Requests\Admins;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Interfaces\LoginRequestInterface;

class LoginRequest extends FormRequest implements LoginRequestInterface
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
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('validation.email.required'),
            'email.string' => __('validation.email.string'),
            'email.email' => __('validation.email.email'),
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
        ];
    }

    public function getKey()
    {
       return Str::lower($this->input('email')).'|'.$this->ip();
    }
    public function ensureIsNotRateLimited()
    {
       if (! RateLimiter::tooManyAttempts($this->getKey(), 3)) {
           return;
       }

       $this->storeBlockedKey();

       $seconds = RateLimiter::availableIn($this->getKey());
       throw ValidationException::withMessages([
           'email' => trans('auth.throttle', [
               'seconds' => $seconds,
               'minutes' => ceil($seconds / 60),
               'hours' => ceil($seconds / 3600),
           ]),
       ]);
    }
    public function hit($key, $block_duration)
    {
       RateLimiter::hit($key, $block_duration);
    }

    public function storeBlockedKey()
    {
       $admin = Admin::where('email', $this->input('email'))->first();
       if($admin) {
           $admin->update(['blocked_key' => $this->getKey()]);
       }
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::guard('admin_s')->attempt($this->validated())) {
            $this->hit($this->getKey(), 6 * 60 * 60);
            throw new AuthenticationException;
        }

        RateLimiter::clear($this->getKey());
    }
}
