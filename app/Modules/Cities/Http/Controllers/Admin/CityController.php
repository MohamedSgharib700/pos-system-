<?php

namespace App\Modules\Cities\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Cities\Repositories\CityRepository;
use App\Modules\Cities\Entities\City;
use App\Modules\Cities\Http\Requests\Admin\ImportCityExcel;
use App\Modules\Cities\Http\Requests\Admin\CityRequest;
use App\Modules\Cities\Transformers\Admin\CityResource;
use App\Modules\Cities\Exports\CityExport;
use App\Modules\Cities\Imports\CityImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CityController extends Controller
{
    /**
     * City repository instance for query database.
     *
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * Create a new CityController instance.
     *
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->middleware('permission:cities-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:cities-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cities-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cities-delete', ['only' => ['destroy']]);
        $this->middleware('permission:cities-active', ['only' => ['active']]);
        $this->middleware('permission:cities-deactive', ['only' => ['deactive']]);
        $this->middleware('permission:cities-export-excel', ['only' => ['exportCities']]);
        $this->middleware('permission:cities-import-excel', ['only' => ['importCities']]);
    }

    /**
     * Get all cities.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cities = $this->cityRepository->getCities($request->all());
        return $this->apiResponse(CityResource::collection($cities));
    }

    /**
     * Create a new city.
     *
     * @param CityRequest $request
     * @return JsonResponse
     */
    public function store(CityRequest $request): JsonResponse
    {
        $city = $this->cityRepository->create($request->validated());
        return $this->apiResponse(new CityResource($city));
    }

    /**
     * Show specified city.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $city = $this->cityRepository->show($id);
        return $this->apiResponse(new CityResource($city));
    }

    /**
     * Update specified city.
     *
     * @param CityRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(CityRequest $request, $id): JsonResponse
    {
        $city = $this->cityRepository->update($request->validated(), $id);
        return $this->apiResponse(new CityResource($city));
    }

    /**
     * Delete specified city.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->cityRepository->delete($id);
        return $this->apiResponse(['message'=>__('cities::messages.deleted_successfuly')]);
    }

    /**
     * Export Excel sheet of cities.
     *
     * @return BinaryFileResponse
     */
    public function exportCities(): BinaryFileResponse
    {
        return Excel::download(new CityExport, 'cities.xlsx');
    }

    /**
     * Import sheet excel of cities.
     *
     * @param ImportCityExcel $request
     * @return JsonResponse
     */
    public function importCities(ImportCityExcel $request): JsonResponse
    {
        Excel::import(new CityImport, $request->file('file'));
        return $this->apiResponse(CityResource::collection(City::activated()->get()));
    }
}
