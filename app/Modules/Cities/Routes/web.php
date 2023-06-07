<?php
namespace App\Modules\Cities\Http\Controllers\Web;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth:api']], function () {
    // Route::resource('cities', [CityController::class])->parameter('', 'city_id');
});
