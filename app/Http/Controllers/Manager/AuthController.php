<?php

namespace App\Http\Controllers\Manager;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Services\Wathq\Wathq;
use App\Events\ManagerActivited;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Facades\CheckCommercialNumberValidity;
use App\Http\Requests\Manager\RegisterRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Manager\ManagerResource;
use App\Http\Requests\Interfaces\LoginRequestInterface;

/**
 * Class AuthController
 * @package App\Http\Controllers\Manager
 */

class AuthController extends Controller
{
    /**
     * The Wathq Service instance.
     *
     * @var \App\Services\Wathq\Wathq
     */
    protected $wathq_service;

    /**
     * Create a new AuthController instance.
     *
     * @param  \App\Services\Wathq\Wathq  $wathq_service
     * @return void
     */
    public function __construct(Wathq $wathq_service)
    {
        $this->wathq_service = $wathq_service;
    }

    /**
     * Register new manager.
     *
     * @param  \App\Http\Requests\Manager\RegisterRequest  $request
     * @return \App\Http\Resources\Manager\ManagerResource|array ['message'=>'text']
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterRequest $request)
    {
        if(! $request->hasFile('delegation_file')) {
                try {

                    $commercial_registration_info = $this->wathq_service->getCommercialRegistrationInfo($request->commercial_registration_number);

                } catch (\Exception $e) {
                    throw ValidationException::withMessages([
                        'commercial_registration_number' => trans('general.invalid_data')
                    ]);
                }
                CheckCommercialNumberValidity::check($request->commercial_registration_number, $request->identification_number, $commercial_registration_info);
                $manager = Manager::create($request->validated() + ['user_type'=>Manager::OWNER, 'is_active'=>true]);
                $manager->assignRole(Manager::OWNER);
                event(new ManagerActivited($manager,$request->commercial_registration_number, $request->tax_number, $commercial_registration_info['crName']));
                $token = $manager->createToken('manager-token')->plainTextToken;
                $managerData = collect(new ManagerResource($manager));
                $managerData->put('token', $token);
                return $this->apiResponse($managerData);
        } else {
            $delegation_file = $request->file('delegation_file')->store('managers', 'public');
            $manager = Manager::create(['user_type' => Manager::OWNER, 'delegation_file' => $delegation_file] + $request->validated());
            $manager->assignRole(Manager::OWNER);
            return $this->apiResponse(['message' => __('general.manager_registeration_pending')]);
        }
    }

    /**
     * Login manager.
     *
     * @param  App\Http\Requests\Interfaces\LoginRequestInterface $request
     * @return \App\Http\Resources\Manager\ManagerResource|string $message
     */
    public function login(LoginRequestInterface $request)
    {
        try {
            $request->authenticate();
        } catch(\AuthenticationException $e) {
            return $this->errorResponse(__('messages.not_match'), 401);
        }

        $manager = Auth::guard('manager_s')->user();

        $token = $manager->createToken('manager-token')->plainTextToken;

        $managerData = collect(new ManagerResource($manager));

        $managerData->put('token', $token);

        return $this->apiResponse($managerData, 200);

        // $manager = Manager::whereEmail($input['email'])
        //     ->orWhere('identification_number', $input['email'])
        //     ->orWhereHas('company', function ($q) use ($input) {
        //         $q->where('commercial_register', $input['email']);
        //     })
        //     ->first();

        // if ($manager && \Hash::check($input['password'], $manager->password)) {
            
        //     Auth::guard('manager_s')->login($manager);

        //     $token = $manager->createToken('manager-token')->plainTextToken;

        //     $managerData = collect(new ManagerResource($manager));

        //     $managerData->put('token', $token);

        //     return $this->apiResponse($managerData, 200);
        // }

        // return $this->errorResponse(__('messages.not_match'), 401);
    }

    /**
     * Logout manager.
     *
     * @param  Illuminate\Http\Request  $request
     * @return array ['message' => 'text message']
     */
    public function logout(Request $request)
    {
        if ($request->logout_all) {
            auth()->user()->tokens()->delete();
        } else {
            auth()->user()->currentAccessToken()->delete();
        }

        return $this->apiResponse(['message' => __('general.logout_successfully')]);
    }
}
