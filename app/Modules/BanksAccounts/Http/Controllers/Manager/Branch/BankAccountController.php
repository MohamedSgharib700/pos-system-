<?php

namespace App\Modules\BanksAccounts\Http\Controllers\Manager\Branch;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Branch\Entities\Branch;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\BanksAccounts\Http\Requests\Manager\BankAccountRequest;
use App\Modules\BanksAccounts\Transformers\Manager\BankAccountResource;

class BankAccountController extends Controller
{
    /**
     * Instance of logged manager.
     *
     * @var Authenticatable|null
     */
    private $manager;

    private $branch;

    /**
     * Create a new BankAccountController instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->manager = auth('manager')->user();
    }

    /**
     * Get all bank accounts of specified branch.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        $this->manager->load('company');
        $branch = Branch::findOrFail($request->branch_id);
        $this->authorize('view', ['BranchBankAcountsPolicy', $branch, $this->manager]);
        $bank_accounts = $branch->banksAccounts;
        return $this->apiResponse(BankAccountResource::collection($bank_accounts));
    }


    /**
     * Create a bank account to specified branch.
     *
     * @param BankAccountRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(BankAccountRequest $request): JsonResponse
    {
        $this->manager->load('company');
        $branch = Branch::findOrFail($request->branch_id);
        $this->authorize('create', ['BranchBankAcountsPolicy', $branch, $this->manager]);
        $bank_account = $branch->banksAccounts()->create($request->validated());
        return $this->apiResponse(new BankAccountResource($bank_account));
    }

    /**
     * Show specified bank account of specified branch.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->manager->load('company');
        $branch = Branch::findOrFail($request->branch_id);
        $this->authorize('view', ['BranchBankAcountsPolicy', $branch, $this->manager]);
        $bank_account = $branch->banksAccounts()->findOrFail($id);
        return $this->apiResponse(new BankAccountResource($bank_account));
    }

    /**
     * Update a bank account of specified branch.
     *
     * @param BankAccountRequest $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(BankAccountRequest $request, $id): JsonResponse
    {
        $this->manager->load('company');
        $branch = Branch::findOrFail($request->branch_id);
        $this->authorize('update', ['BranchBankAcountsPolicy', $branch, $this->manager]);
        $bank_account = $branch->banksAccounts()->findOrFail($id);
        $bank_account->update($request->validated());
        return $this->apiResponse(new BankAccountResource($bank_account));
    }

    /**
     * delete a bank account of specified branch.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $this->manager->load('company');
        $branch = Branch::findOrFail($request->branch_id);
        $this->authorize('delete', ['BranchBankAcountsPolicy', $branch, $this->manager]);
        $bank_account = $branch->banksAccounts()->findOrFail($id);
        try {
            $bank_account->delete();
        } catch (\Exception $e) {
            $bank_account-->update(['deactivated_at' => now()]);
        }
        return $this->apiResponse(['message'=>__('banks_accounts::messages.deleted_successfuly')]);
    }
}
