<?php

namespace App\Listeners;

use App\Events\ManagerActivited;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use App\Modules\Company\Entities\Company;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCompany
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ManagerActivited $event)
    {
        DB::transaction(function () use($event){
            $company = Company::create(
            ['name'=>$event->company_name ?? $event->manager->name,
            'tax_number'=>$event->tax_number,
            'type'=>Company::COMMERCIAL_RECORD,
            'commercial_register'=>$event->commercial_registration_number]
            );
           $event->manager->update(['company_id'=>$company->id]);
        });           
    }
}
