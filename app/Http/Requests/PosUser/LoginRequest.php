<?php

namespace App\Http\Requests\PosUser;

use App\Http\Requests\Interfaces\LoginRequestInterface;
use App\Models\PosUser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('validation.email.required'),
            'email.string' => __('validation.email.string'),
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
        ];
    }

    public function getKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->getKey(), 3)) {
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
        $pos_user = PosUser::where('email', $this->input('email'))
            ->orWhere('identification_number', $this->input('email'))
                ->first();
        if ($pos_user) {
            $pos_user->update(['blocked_key' => $this->getKey()]);
        }
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $pos_user = PosUser::whereEmail($this->input('email'))
            ->orWhere('identification_number', $this->input('email'))
            ->first();

        if (!($pos_user && \Hash::check($this->input('password'), $pos_user->password))) {
            $this->hit($this->getKey(), 6 * 60 * 60);
            throw new AuthenticationException;
        }
        Auth::guard('pos_s')->login($pos_user);
        RateLimiter::clear($this->getKey());
    }
}
