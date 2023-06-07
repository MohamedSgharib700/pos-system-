<?php

namespace App\Modules\BanksAccounts\Http\Controllers\Admin;

use App\Modules\BanksAccounts\Http\Requests\BanksAccountRequest;
use App\Modules\BanksAccounts\Repositories\Admin\BanksAccountRepository;
use App\Modules\BanksAccounts\Transformers\Admin\BanksAccountResource;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BanksAccountController extends Controller
{
    /**
     * BanksAccount repository instance for query database.
     *
     * @var BanksAccountRepository
     */
    private $banks_accountRepository;

    /**
     * Create a new BanksAccountController instance.
     *
     * @param BanksAccountRepository $banks_accountRepository
     * @return void
     */
    public function __construct(BanksAccountRepository $banks_accountRepository)
    {
        $this->banks_accountRepository = $banks_accountRepository;
        $this->middleware('permission:banks-accounts-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:banks-accounts-create', ['only' => ['store']]);
        $this->middleware('permission:banks-accounts-edit', ['only' => ['update']]);
        $this->middleware('permission:banks-accounts-delete', ['only' => ['destroy']]);
    }

    /**
     * Get all bank accounts.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $banks_accounts = $this->banks_accountRepository->all();
        return $this->apiResponse(BanksAccountResource::collection($banks_accounts));
    }

    /**
     * Create a bank account.
     *
     * @param BanksAccountRequest $request
     * @return JsonResponse
     */
    public function store(BanksAccountRequest $request): JsonResponse
    {
        $banks_account = $this->banks_accountRepository->create($request->validated());
        return $this->apiResponse(new BanksAccountResource($banks_account));
    }

    /**
     * Show a bank account.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $banks_account = $this->banks_accountRepository->show($id);
        return $this->apiResponse(new BanksAccountResource($banks_account));
    }

    /**
     * Update a bank account.
     *
     * @param BanksAccountRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(BanksAccountRequest $request, $id): JsonResponse
    {
        $this->banks_accountRepository->update($request->validated(), $id);
        $banks_account = $this->banks_accountRepository->show($id);
        return $this->apiResponse(new BanksAccountResource($banks_account));
    }

    /**
     * delete a bank account.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $banks_account = BanksAccount::findOrFail($id);
        $this->banks_accountRepository->delete($banks_account);
        return $this->apiResponse(['message'=>__('banks-accounts::messages.deleted_successfuly')]);
    }
}
