<?php
namespace App\Modules\Company\Http\Controllers\Manager;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Admin API!
|
*/

Route::group(['middleware' => ['auth:manager']], function () {
     Route::post('my/company', [CompanyController::class, 'store']);
     Route::put('my/company', [CompanyController::class, 'update']);
     Route::get('my/company', [CompanyController::class, 'show']);
});
