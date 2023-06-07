<?php

namespace App\Modules\Banks\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Banks\Transformers\Admin\BankResource;
use App\Modules\Banks\Repositories\Admin\BankRepository;

class BankController extends Controller
{
    private $bankRepository;

    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function index()
    {
        $banks = $this->bankRepository->all();
        return $this->apiResponse(BankResource::collection($banks));
    }
}
