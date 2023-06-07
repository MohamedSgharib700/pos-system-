<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admins\ManagerResource;
use App\Models\Manager;
use App\Notifications\SendForgetPassword;
use Illuminate\Http\Request;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Manager
 */

class ForgotPasswordController extends Controller
{
    /**
     * send mail with forget code to manager.
     *
     * @param  Illuminate\Http\Request  $request
     * @return array ['message' => 'text message']
     */
    public function forgetPassword(Request $request)
    {
        $user = Manager::where('email', $request->email)->first();
        if (!$user) {
            return $this->errorResponse(__('messages.email.invalid'));
        }

        $code = random_int(100000, 999999);
        $user->update(['forget_code' => $code]);
        $user->notify(new SendForgetPassword($code));
        return $this->apiResponse(['message' => __('messages.mail.sended')], 200);
    }

    /**
     * reset password for manager.
     *
     * @param  Illuminate\Http\Request  $request
     * @return string $token
     */
    public function resetPassword(Request $request)
    {
        $user = Manager::where('email', $request->email)->where('forget_code', $request->forget_code)->first();
        if (!$user) {
            return $this->errorResponse(__('messages.forget_code.invalid'));
        }

        $token = $user->createToken('admin-token')->plainTextToken;
        return $this->apiResponse(['token' => $token], 200);
    }

    /**
     * update password of manager account.
     *
     * @param  Illuminate\Http\Request  $request
     * @return App\Http\Resources\Admins\ManagerResource
     */
    public function updateForgetPassword(Request $request)
    {
        $user = $request->user();
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
        ]);
        $user->update($validatedData);
        return $this->apiResponse(new ManagerResource($user));
    }
}
