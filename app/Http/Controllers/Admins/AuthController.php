<?php

namespace App\Http\Controllers\Admins;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admins\LoginRequest;
use App\Http\Resources\Admins\AdminResource;
use App\Http\Requests\Admins\RegisterRequest;
use App\Http\Requests\Interfaces\LoginRequestInterface;

class AuthController extends Controller
{
    /**
     * admin register method.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request) :JsonResponse
    {
        if (Admin::count()) {
            return $this->errorResponse('There is already registered admin', 401);
        }

        $attr = $request->all();
        $attr['password'] = bcrypt($attr['password']);
        $admin = Admin::create($attr);
        $adminData = collect(new AdminResource($admin));
        $token = $admin->createToken('admin-token')->plainTextToken;
        $adminData->put('token', $token);
        return $this->apiResponse($adminData, 200);
    }

    /**
     *
     * admin login method.
     *
     * @param App\Http\Requests\Interfaces\LoginRequestInterface $request
     * @return JsonResponse
     */
    public function login(LoginRequestInterface $request) :JsonResponse
    {
        
        try {
            $request->authenticate();
        } catch(\AuthenticationException $e) {
            return $this->errorResponse('unauthenticated', 401);
        }
        $admin = Auth::guard('admin_s')->user();
        $adminData = collect(new AdminResource($admin));
        $token = $admin->createToken('admin-token')->plainTextToken;
        $adminData->put('token', $token);
        return $this->apiResponse($adminData, 200);
    }

    /**
     * admin logout meyhod.
     *
     * @return JsonResponse
     */
    public function logout() :JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->apiResponse(['message' => __('general.logout_successfully')]);
    }
}
