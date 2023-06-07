<?php
namespace App\Modules\Branch\Http\Controllers\Manager;

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
     Route::resource('branches', BranchController::class)->parameter('', 'branch_id');
});
