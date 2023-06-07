<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ProfileRequest;
use Illuminate\Http\Request;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Manager
 */

class ProfileController extends Controller
{

    /**
     * show manager profile.
     * @return App\Models\Manager
     */
    public function index()
    {
        return $this->apiResponse(auth()->user());
    }

    /**
     * update manager profile.
     * @param int $id
     * @param App\Http\Requests\Manager\ProfileRequest $request
     * @return App\Models\Manager
     */
    public function update($id, ProfileRequest $request)
    {
        $input = array_filter($request->validated());

        $manager = auth()->user()->update($input);

        return $this->apiResponse(auth()->user());
    }

    /**
     * change manager account password.
     * @param Illuminate\Http\Request $request
     * @return string|array  failed message or ['message'=>'text']
     */
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ], [
            'old_password.required' => __('validation.old_password.required'),
            'old_password.string' => __('validation.old_password.string'),
            'password.required' => __('validation.password.required'),
            'password.string' => __('validation.password.string'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
        ]);

        $manager = auth()->user();

        if ($manager && \Hash::check($validatedData['old_password'], $manager->password)) {
            $manager->update($validatedData );
            return $this->apiResponse([ 'message' => __('messages.password.updated') ]);

        }
        return $this->errorResponse('old password not match', 422);
    }
}
