<?php

namespace App\Http\Controllers\Pos_users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pos_users\PosUserResource;
use App\Models\Admin;
use App\Models\PosUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getInfo()
    {
        $pos_user = Auth::user();
        return $this->apiResponse(new PosUserResource($pos_user));
    }

    public function updateProfile(Request $request, PosUser $pos_user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:pos_users,email,'.$pos_user->id
        ], [
            'name.required' => __('validation.name.required'),
            'name.string' => __('validation.name.string'),
            'email.required' => __('validation.email.required'),
            'email.string' => __('validation.email.string'),
            'email.unique' => __('validation.email.unique')
        ]);
        $pos_user->update($validatedData);
        return $this->apiResponse(new PosUserResource($pos_user));
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ], [
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
        ]);
        $validatedData['password'] = Hash::make($request->password);
        $pos_user = Auth::user();
        $pos_user->update($validatedData);
        return $this->apiResponse(new PosUserResource($pos_user));
    }
}
