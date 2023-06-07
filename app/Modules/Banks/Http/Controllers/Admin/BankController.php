<?php

namespace App\Modules\Banks\Http\Controllers\Admin;

use App\Modules\Banks\Http\Requests\BankRequest;
use App\Modules\Banks\Repositories\Admin\BankRepository;
use App\Modules\Banks\Transformers\Admin\BankResource;
use App\Modules\Banks\Entities\Bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BankController extends Controller
{
    /**
     * @var BankRepository
     */
    private $bankRepository;

    /**
     * Create a new BankController instance.
     *
     * @param BankRepository $bankRepository
     */
    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
        $this->middleware('permission:banks-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:banks-create', ['only' => ['store']]);
        $this->middleware('permission:banks-edit', ['only' => ['update']]);
        $this->middleware('permission:banks-delete', ['only' => ['destroy']]);
    }

    /**
     * Get all banks
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $banks = $this->bankRepository->all();
        return $this->apiResponse(BankResource::collection($banks));
    }

    /**
     * Create a bank.
     *
     * @param BankRequest $request
     * @return JsonResponse
     */
    public function store(BankRequest $request): JsonResponse
    {
        $bank = $this->bankRepository->create($request->validated());
        return $this->apiResponse(new BankResource($bank));
    }

    /**
     * Show the specified bank.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $bank = $this->bankRepository->show($id);
        return $this->apiResponse(new BankResource($bank));
    }

    /**
     * Update the specified bank.
     *
     * @param BankRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BankRequest $request, $id): JsonResponse
    {
        $this->bankRepository->update($request->validated(), $id);
        $bank = $this->bankRepository->show($id);
        return $this->apiResponse(new BankResource($bank));
    }

    /**
     * Remove the specified bank.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $bank = Bank::findOrFail($id);
        $this->bankRepository->delete($bank);
        return $this->apiResponse(['message'=>__('banks::messages.deleted_successfuly')]);
    }
}
