<?php
namespace App\Modules\Company\Http\Controllers\Admins;

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

Route::group(['middleware' => ['auth:admin']], function () {
     Route::resource('companies', CompanyController::class)->parameter('', 'company_id');
});
