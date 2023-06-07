<?php

namespace App\Modules\Cities\Http\Controllers\Manager;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Cities\Repositories\CityRepository;
use App\Modules\Cities\Transformers\Admin\CityResource;

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
     * @return void
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
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

}
