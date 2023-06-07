<?php

namespace App\Modules\Company\Http\Controllers\Manager;

use App\Modules\Company\Entities\Company;
use App\Modules\Company\Http\Requests\Manager\CompanyRequest;
use App\Modules\Company\Transformers\Admins\CompanyResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Create a new CompanyController instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('check.manager.has.company')->except('store');
    }

    /**
     * create new company.
     *
     * @param \App\Modules\Company\Http\Requests\Manager\CompanyRequest $request
     * @return \App\Modules\Company\Transformers\Admins\CompanyResource
     */
    public function store(CompanyRequest $request)
    {
        if(auth()->user()->company()->exists()) return $this->errorResponse(__('company::messages.already_have_a_company'), 422);
        return DB::transaction(function () use ($request) {
            $company = auth()->user()->company()->create($request->validated());
            Manager::where('id', auth()->user()->id)->update(['company_id' => $company->id]);
            if ($request->has('finance_manager_id'))
                Manager::where('id', $request->finance_manager_id)->update(['company_id' => $company->id]);

            return $this->apiResponse(new CompanyResource($company));
        });
    }

    /**
     * Update company.
     *
     * @param \App\Modules\Company\Http\Requests\Manager\CompanyRequest $request
     * @param \App\Modules\Company\Entities\Company $company
     * @return \App\Modules\Company\Transformers\Admins\CompanyResource
     */
    public function update(CompanyRequest $request)
    {
        auth('manager')->user()->load('company');
        $company = auth('manager')->user()->company;
        return DB::transaction(function () use ($request, $company) {
            $company->update($request->validated());
            if ($request->has('finance_manager_id')) {
                if ($request->finance_manager_id != optional($company->financeManager)->id) {
                    $company->financeManager()->update(['company_id' => NULL]);
                    Manager::find($request->finance_manager_id)->update(['company_id' => $company->id]);
                }
            }
            return $this->apiResponse(new CompanyResource($company));
        });
    }

    public function show()
    {
        auth('manager')->user()->load(
                                      ['company.owner',
                                       'company.financeManager',
                                       'company.branches.manager',
                                       'company.branches.city',
                                       'company.branches.posUsers'
                                      ]
                                    );
        return $this->apiResponse(new CompanyResource(auth('manager')->user()->company));
    }
}
