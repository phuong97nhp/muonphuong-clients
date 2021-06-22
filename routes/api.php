<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\OrdersController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/v1/export-list-tracking', [OrdersController::class, 'exportListTracking'])->name('export-list-tracking');
Route::get('/v1/export-detail-tracking', [OrdersController::class, 'exportDetailTracking'])->name('export-list-tracking');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
