<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admins\AdminResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Get an admin information
     *
     * @return JsonResponse
     */
    public function getAdminInfo(): JsonResponse
    {
        $admin = Auth::user();
        return $this->apiResponse(new AdminResource($admin));
    }

    /**
     * Update an admin information.
     *
     * @param Request $request
     * @param Admin $admin
     * @return JsonResponse
     */
    public function updateProfile(Request $request, Admin $admin): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:admins,email,' . $admin->id,
        ], [
            'name.required' => __('validation.name.required'),
            'name.string' => __('validation.name.string'),
            'email.required' => __('validation.email.required'),
            'email.string' => __('validation.email.string'),
            'email.email' => __('validation.email.email'),
            'email.unique' => __('validation.email.unique'),
        ]);
        $admin->update($validatedData);
        return $this->apiResponse(new AdminResource($admin));
    }

    /**
     * Change admin password.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
        ]);
        $validatedData['password'] = Hash::make($request->password);
        $admin = Auth::user();
        $admin->update($validatedData);
        return $this->apiResponse(new AdminResource($admin));
    }
}
