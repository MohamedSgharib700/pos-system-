<?php

namespace App\Modules\ServicesProviders\Http\Controllers\Admin;

use App\Modules\ServicesProviders\Http\Requests\ServicesProviderRequest;
use App\Modules\ServicesProviders\Repositories\Admin\ServicesProviderRepository;
use App\Modules\ServicesProviders\Transformers\Admin\ServicesProviderResource;
use App\Modules\ServicesProviders\Entities\ServicesProvider;
use App\Http\Controllers\Controller;

class ServicesProviderController extends Controller
{
    /**
     * services provider repository for query database.
     * @var  \App\Modules\ServicesProviders\Repositories\Admin\ServicesProviderRepository
     */
    private $servicesProviderRepository;

    /**
     * Create a new ServicesProviderController instance.
     *
     * @param  \App\Modules\ServicesProviders\Repositories\Admin\ServicesProviderRepository $servicesProviderRepository
     * @return void
    */
    public function __construct(ServicesProviderRepository $servicesProviderRepository)
    {
        $this->servicesProviderRepository = $servicesProviderRepository;
        $this->middleware('permission:services-providers-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:services-providers-create', ['only' => ['store']]);
        $this->middleware('permission:services-providers-edit', ['only' => ['update']]);
        $this->middleware('permission:services-providers-delete', ['only' => ['destroy']]);
    }

    /**
     * List all services providers.
     *
     * @return \App\Modules\ServicesProviders\Transformers\Admin\ServicesProviderResource[]
     */
    public function index()
    {
        $servicesProviders = $this->servicesProviderRepository->all();
        return $this->apiResponse(ServicesProviderResource::collection($servicesProviders));
    }

    /**
     * Creat new services provider.
     *
     * @param \App\Modules\ServicesProviders\Http\Requests\ServicesProviderRequest $request
     * @return \App\Modules\ServicesProviders\Transformers\Admin\ServicesProviderResource
    */
    public function store(ServicesProviderRequest $request)
    {
        $servicesProvider = $this->servicesProviderRepository->create($request->validated());
        return $this->apiResponse(new ServicesProviderResource($servicesProvider));
    }

    /**
     * Show services provider info.
     *
     * @param int $id
     * @return \App\Modules\ServicesProviders\Transformers\Admin\ServicesProviderResource
    */
    public function show($id)
    {
        $servicesProvider = $this->servicesProviderRepository->show($id);
        return $this->apiResponse(new ServicesProviderResource($servicesProvider));
    }

    /**
     * Update services provider.
     *
     * @param \App\Modules\ServicesProviders\Http\Requests\ServicesProviderRequest $request
     * @param int $id
     * @return \App\Modules\ServicesProviders\Transformers\Admin\ServicesProviderResource
    */
    public function update(ServicesProviderRequest $request, $id)
    {
        $this->servicesProviderRepository->update($request->validated(), $id);
        $servicesProvider = $this->servicesProviderRepository->show($id);
        return $this->apiResponse(new ServicesProviderResource($servicesProvider));
    }

   
    /**
     * Delete services provider.
     *
     * @param int $id
     * @return array ['message' => 'text message']
    */
    public function destroy($id)
    {
        $servicesProvider = ServicesProvider::findOrFail($id);
        $this->servicesProviderRepository->delete($servicesProvider);
        return $this->apiResponse(['message'=>__('services-providers::messages.deleted_successfuly')]);
    }
}
