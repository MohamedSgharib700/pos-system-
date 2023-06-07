<?php
namespace App\Modules\Areas\Http\Controllers\Admin;

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
        Route::resource('areas', AreaController::class);
        Route::get('export_areas', [AreaController::class, 'exportAreas']);
        Route::post('import_areas', [AreaController::class, 'importAreas']);
    });
});
