<?php

namespace App\Modules\BanksAccounts\Http\Controllers\Manager;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use App\Modules\BanksAccounts\Http\Requests\Manager\BankAccountRequest;
use App\Modules\BanksAccounts\Transformers\Manager\BankAccountResource;
use App\Modules\BanksAccounts\Repositories\Admin\BanksAccountRepository;

class BankAccountController extends Controller
{
    /**
     * Instance of logged manager.
     *
     * @var Authenticatable|null
     */
    private $manager;

    /**
     * Create a new BankAccountController instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->manager = auth('manager')->user();
      $this->middleware('can.manager.create.bankAccounts')->only('store');
    }

    /**
     * Get all bank accounts of logged manager.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->manager->load('company');
        $bank_accounts = $this->manager->company->banksAccounts;
        return $this->apiResponse(BankAccountResource::collection($bank_accounts));
    }


    /**
     * Create a new bank account for logged manager.
     *
     * @param BankAccountRequest $request
     * @return JsonResponse
     */
    public function store(BankAccountRequest $request): JsonResponse
    {
        $this->manager->load('company');
        $bank_account = $this->manager->company->banksAccounts()->create($request->validated());
        return $this->apiResponse(new BankAccountResource($bank_account));
    }

    /**
     * Show specified bank account of logged manager.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $this->manager->load('company');
        $bank_account = $this->manager->company->banksAccounts()->findOrFail($id);
       return $this->apiResponse(new BankAccountResource($bank_account));
    }

    /**
     * Update specified bank account of logged manager.
     *
     * @param BankAccountRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(BankAccountRequest $request, $id): JsonResponse
    {
        $this->manager->load('company');
        $bank_account = $this->manager->company->banksAccounts()->findOrFail($id);
        $bank_account->update($request->validated());
        return $this->apiResponse(new BankAccountResource($bank_account));
    }

    /**
     * Delete specified bank account of logged manager.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->manager->load('company');
        $bank_account = $this->manager->company->banksAccounts()->findOrFail($id);
        try {
            $bank_account->delete();
        } catch (\Exception $e) {
            $bank_account-->update(['deactivated_at' => now()]);
        }
        return $this->apiResponse(['message'=>__('banks_accounts::messages.deleted_successfuly')]);
    }
}
