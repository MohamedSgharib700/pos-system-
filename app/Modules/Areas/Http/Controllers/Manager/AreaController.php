<?php

namespace App\Modules\Areas\Http\Controllers\Manager;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Areas\Repositories\AreaRepository;
use App\Modules\Areas\Transformers\Admin\AreaResource;

class AreaController extends Controller
{
    /**
     * @var AreaRepository
     */
    private $areaRepository;

    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    /**
     * Get all areas
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $areas = $this->areaRepository->getAreas($request->all());
        return $this->apiResponse(AreaResource::collection($areas));
    }

}
