<?php

namespace App\Http\Controllers\Pos_users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\RegisterRequest;
use App\Http\Requests\Interfaces\LoginRequestInterface;
use App\Http\Resources\Admins\AdminResource;
use App\Http\Resources\Pos_users\PosUserResource;
use App\Models\Admin;
use App\Models\PosUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $attr = $request->all();
        $attr['password'] = bcrypt($attr['password']);
        $admin = PosUser::create($attr);
        $adminData = collect(new PosUserResource($admin));
        $token = $admin->createToken('pos-token')->plainTextToken;
        $adminData->put('token', $token);
        return $this->apiResponse($adminData, 200);
    }

    public function login(LoginRequestInterface $request)
    {
        try {
            $request->authenticate();
        } catch(\AuthenticationException $e) {
            return $this->errorResponse('unauthenticated', 401);
        }
        $pos = Auth::guard('pos_s')->user();
        $posData = collect(new PosUserResource($pos));
        $token = $pos->createToken('pos-token')->plainTextToken;
        $posData->put('token', $token);
        return $this->apiResponse($posData);
    }

    public function logout(Request $request)
    {
        if(!$request->all_tokens) {
            auth()->user()->currentAccessToken()->delete();
        } else {
            auth()->user()->tokens()->delete();
        }
        return $this->apiResponse([]);
    }
}
