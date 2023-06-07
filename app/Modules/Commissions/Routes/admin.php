<?php
namespace App\Modules\Commissions\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use App\Modules\Commissions\Http\Controllers\Admin\CommissionController;

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
Route::resource('commissions', CommissionController::class)->except(['destroy'])->middleware('auth:admin');


