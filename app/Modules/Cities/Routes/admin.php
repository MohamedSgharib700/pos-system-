<?php
namespace App\Modules\Cities\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\Localization;

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
    Route::middleware([Localization::class])->group(function () {
        Route::resource('cities', CityController::class);
        Route::get('export_cities', [CityController::class, 'exportCities']);
        Route::post('import_cities', [CityController::class, 'importCities']);
    });
});
