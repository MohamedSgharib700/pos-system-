<?php

namespace App\Modules\Company\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use App\Modules\Company\Http\Requests\Admins\CompanyRequest;
use App\Modules\Company\Transformers\Admins\CompanyResource;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Create a new CompanyController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:company-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }
    /**
     * List all companies.
     *
     * @return \App\Modules\Company\Transformers\Admins\CompanyResource[]
     */
    public function index()
    {
        $companies = Company::activated()->orderBy('id', 'desc')->get();
        return $this->apiResponse(CompanyResource::collection($companies));
    }

    /**
     * create new company.
     *
     * @param \App\Modules\Company\Http\Requests\Admins\CompanyRequest $request
     * @return \App\Modules\Company\Transformers\Admins\CompanyResource
     */
    public function store(CompanyRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $company = Company::create($request->validated());
            if ($request->has('owner_id'))
                Manager::where('id', $request->owner_id)->update(['company_id' => $company->id]);

            if ($request->has('finance_manager_id'))
                Manager::where('id', $request->finance_manager_id)->update(['company_id' => $company->id]);

            return $this->apiResponse(new CompanyResource($company));
        });
    }

    /**
     * Show company info.
     *
     * @param \App\Modules\Company\Entities\Company $company
     * @return \App\Modules\Company\Transformers\Admins\CompanyResource
     */
    public function show(Company $company)
    {
        $company->load(['owner', 'financeManager', 'branches.manager', 'branches.city', 'branches.posUsers']);
        return $this->apiResponse(new CompanyResource($company));
    }

    /**
     * Update company.
     *
     * @param \App\Modules\Company\Http\Requests\Admins\CompanyRequest $request
     * @param \App\Modules\Company\Entities\Company $company
     * @return \App\Modules\Company\Transformers\Admins\CompanyResource
     */
    public function update(CompanyRequest $request, Company $company)
    {
        return DB::transaction(function () use ($request, $company) {
            $company->update($request->validated());
            if ($request->has('owner_id')) {
                if ($request->owner_id != optional($company->owner)->id) {
                    $company->owner()->update(['company_id' => NULL]);
                    Manager::find($request->owner_id)->update(['company_id' => $company->id]);
                }
            }

            if ($request->has('finance_manager_id')) {
                if ($request->finance_manager_id != optional($company->financeManager)->id) {
                    $company->financeManager()->update(['company_id' => NULL]);
                    Manager::find($request->finance_manager_id)->update(['company_id' => $company->id]);
                }
            }
            return $this->apiResponse(new CompanyResource($company));
        });
    }

    /**
     * Delete company.
     *
     * @return array ['message' => 'text message']
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        try {
            $company->delete();
        } catch (\Exception $e) {
            $company->update(['deactivated_at' => now()]);
        }
        return $this->apiResponse(['message' => __('company::messages.deleted_successfuly')]);
    }

}
