<?php

namespace App\Modules\ServicesProviders\Http\Controllers\Web;

use App\Modules\ServicesProviders\Transformers\Admin\ServicesProviderResource;
use App\Modules\ServicesProviders\Entities\ServicesProvider;
use App\Http\Controllers\Controller;

class ServicesProviderController extends Controller
{
    /**
     * Show services provider info.
     *
     * @param int $id
     * @return \App\Modules\ServicesProviders\Transformers\Admin\ServicesProviderResource
    */
    public function show($id)
    {
        $servicesProvider = ServicesProvider::findOrFail($id);
        return $this->apiResponse(new ServicesProviderResource($servicesProvider));
    }
}
