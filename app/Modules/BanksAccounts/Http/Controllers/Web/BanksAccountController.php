<?php

namespace App\Modules\BanksAccounts\Http\Controllers\Web;

use App\Modules\BanksAccounts\Transformers\Admin\BanksAccountResource;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use App\Http\Controllers\Controller;

class BanksAccountController extends Controller
{
    public function show($id)
    {
        $banksAccount = BanksAccount::findOrFail($id);
        return $this->apiResponse(new BanksAccountResource($banksAccount));
    }
}
