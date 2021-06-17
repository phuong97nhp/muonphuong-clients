<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\chuyenWebAdmin\AppController;
use App\Http\Controllers\cpn\AppController as CpnAppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// trang quan trị
// Route::group(['prefix' => '/cw-admin'], function () {
//     Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
// });
Route::get('/', [CpnAppController::class, 'index'])->name('home');
Route::post('/', [CpnAppController::class, 'add'])->name('add');
Route::post('/export', [CpnAppController::class, 'export'])->name('export');