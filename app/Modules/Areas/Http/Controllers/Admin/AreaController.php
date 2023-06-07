<?php

namespace App\Modules\Areas\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Modules\Areas\Repositories\AreaRepository;
use App\Modules\Areas\Entities\Area;
use App\Modules\Areas\Http\Requests\Admin\ImportAreaExcel;
use App\Modules\Areas\Http\Requests\Admin\AreaRequest;
use App\Modules\Areas\Transformers\Admin\AreaResource;

use App\Modules\Areas\Exports\AreaExport;
use App\Modules\Areas\Imports\AreaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class AreaController extends Controller
{

    /**
     * @var AreaRepository
     */
    private $areaRepository;

    /**
     * @param AreaRepository $areaRepository
     */
    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
        $this->middleware('permission:areas-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:areas-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:areas-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:areas-delete', ['only' => ['destroy']]);
        $this->middleware('permission:areas-export-excel', ['only' => ['exportAreas']]);
        $this->middleware('permission:areas-import-excel', ['only' => ['importAreas']]);
    }

    /**
     * Get all areas.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $areas = $this->areaRepository->getAreas($request->all());
        return $this->apiResponse(AreaResource::collection($areas));
    }

    /**
     * Create an area.
     *
     * @param AreaRequest $request
     * @return JsonResponse
     */
    public function store(AreaRequest $request): JsonResponse
    {
        $area = $this->areaRepository->create($request->validated());
        return $this->apiResponse(new AreaResource($area));
    }

    /**
     * Show an area information.
     *
     * @param $id int
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $area = $this->areaRepository->show($id);
        return $this->apiResponse(new AreaResource($area));
    }

    /**
     * Update an area information.
     *
     * @param AreaRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(AreaRequest $request, $id): JsonResponse
    {
        $area = $this->areaRepository->update($request->validated(), $id);
        return $this->apiResponse(new AreaResource($area));
    }

    /**
     * Delete an area.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->areaRepository->delete($id);
        return $this->apiResponse(['message'=>__('areas::messages.deleted_successfuly')]);

    }

    /**
     * Export Excel sheet of areas.
     *
     * @return BinaryFileResponse
     */
    public function exportAreas(): BinaryFileResponse
    {
        return Excel::download(new AreaExport, 'areas.xlsx');
    }

    /**
     * Import areas by Excel sheet.
     *
     * @param ImportAreaExcel $request
     * @return JsonResponse
     */
    public function importAreas(ImportAreaExcel $request): JsonResponse
    {
        Excel::import(new AreaImport, $request->file('file'));
        return $this->apiResponse(AreaResource::collection(Area::activated()->get()));
    }
}
