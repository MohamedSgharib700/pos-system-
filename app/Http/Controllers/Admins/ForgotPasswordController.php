<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admins\AdminResource;
use App\Models\Admin;
use App\Notifications\SendForgetPassword;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * send code to the admin via email to make sure he is the owner of this account.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function forgetPassword(Request $request) :JsonResponse
    {
        $user = Admin::where('email', $request->email)->first();
        if(!$user) return $this->errorResponse('البريد الإلكتروني خاطئ');
        $code = random_int(100000, 999999);
        $user->update(['forget_code' => $code]);
        $user->notify(new SendForgetPassword($code));
        return $this->apiResponse(['message' => __('messages.mail.sended')], 200);
    }

    /**
     * make sure from sent code and create a token if it is right.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request) :JsonResponse
    {
        $user = Admin::where('email', $request->email)->where('forget_code', $request->forget_code)->first();
        if(!$user) return $this->errorResponse('الرمز غير صحيح');
        $token = $user->createToken('admin-token')->plainTextToken;
        return $this->apiResponse(['token' => $token], 200);
    }

    /**
     * change password.
     *
     * @param Request $request
     * @return JsonResponse
     */
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
        return $this->apiResponse(new AdminResource($user));
    }
}
