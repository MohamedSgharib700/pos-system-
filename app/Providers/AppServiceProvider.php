<?php

namespace App\Providers;

use App\Services\Wathq\Wathq;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Manager\LoginRequest as ManagerLoginRequest;
use App\Http\Requests\Admins\LoginRequest as AdminLoginRequest;
use App\Http\Requests\PosUser\LoginRequest as PosUserLoginRequest;
use App\Helpers\CheckCommercialNumberValidity;
use App\Http\Requests\Interfaces\LoginRequestInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacades();

        $this->app->singleton(Wathq::class, function ($app) {
            return new Wathq();
        });

        $this->app->bind(LoginRequestInterface::class, function ($app) {
            if(request()->segment(1) == str_replace('/','',RouteServiceProvider::ADMIN_PREFIX)) {
                return resolve(AdminLoginRequest::class);
            } elseif(request()->segment(1) == str_replace('/','',RouteServiceProvider::MANAGER_PREFIX)) {
                return resolve(ManagerLoginRequest::class);
            }elseif(request()->segment(1) == str_replace('/','',RouteServiceProvider::POS_PREFIX)) {
                return resolve(PosUserLoginRequest::class);
            }
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('activated', function() {
            return $this->whereNull('deactivated_at');
        });
    }

    private function registerFacades(){
        $this->app->bind('CheckCommercialNumberValidity', function () {
            return $this->app->make(CheckCommercialNumberValidity::class);
        });
    }
}
