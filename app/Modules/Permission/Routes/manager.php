<?php
namespace App\Modules\Permission\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use App\Modules\Permission\Http\Controllers\Manager\RoleController;

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Manager routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Manager API!
|
*/

Route::group(['middleware' => ['auth:manager']], function () {
    // authenticated staff routes here
    Route::get('permissions', [RoleController::class, 'allPermissions']);
    //Get Admins By Role
    Route::get('managers_role/{roleName}', [RoleController::class, 'ManagersHasRole']);
    // Roles And Permissions
    Route::resource('roles',RoleController::class);
});
