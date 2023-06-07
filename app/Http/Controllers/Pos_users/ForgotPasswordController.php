<?php

namespace App\Http\Controllers\Pos_users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pos_users\PosUserResource;
use App\Models\Admin;
use App\Models\PosUser;
use App\Notifications\SendForgetPassword;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgetPassword(Request $request)
    {
        $user = PosUser::where('email', $request->email)->first();
        if(!$user) return $this->errorResponse(__('messages.email.invalid'));
        $code = random_int(100000, 999999);
        $user->update(['forget_code' => $code]);
        $user->notify(new SendForgetPassword($code));
        return $this->apiResponse(['message' => __('messages.mail.sended')], 200);
    }

    public function resetPassword(Request $request)
    {
        $user = PosUser::where('email', $request->email)->where('forget_code', $request->forget_code)->first();
        if(!$user) return $this->errorResponse(__('messages.forget_code.invalid'));
        $token = $user->createToken('admin-token')->plainTextToken;
        return $this->apiResponse(['token' => $token], 200);
    }

    public function updateForgetPassword(Request $request)
    {
        $user = $request->user();
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ], [
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
        ]);
        $validatedData['password'] = Hash::make($request->password);
        $user->update($validatedData);
        return $this->apiResponse(new PosUserResource($user));
    }
}
