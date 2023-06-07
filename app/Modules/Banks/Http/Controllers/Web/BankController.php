<?php

namespace App\Modules\Banks\Http\Controllers\Web;

use App\Modules\Banks\Transformers\BankResource;
use App\Modules\Banks\Entities\Bank;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    public function show($id)
    {
        $bank = Bank::findOrFail($id);
        return $this->apiResponse(new BankResource($bank));
    }
}
