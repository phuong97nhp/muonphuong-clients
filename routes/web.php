<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clients\UsersController;
use App\Http\Controllers\clients\OrdersController; 
use App\Http\Controllers\clients\AddressController; 
use App\Http\Controllers\cpn\AppController; 
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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


Route::get('/chinh-noi-dung', [AppController::class, 'edit'])->name('app-edit');

Route::group(['prefix' => '/', 'middleware' => 'CheckOut'], function () {
    // đăng nhập
    Route::get('/dang-nhap', [UsersController::class, 'login'])->name('login');

    Route::get('/dang-ky', function(){
        $value = [
            'password' => Hash::make('azexpress.com.vn'),
            'user_name' => 'nguyenhang',
            'last_name' => "Bản Việt",
            'code_customer' => 'BVIET',
            'code_product' => '2323',
            'first_name' => "Ngân hàng",
            'full_name' =>"Ngân hàng Bản Việt",
            'email' => 'bvieta@vietcapitalbank.com.vn',
            'website' => 'https://www.vietcapitalbank.com.vn/personal',
            'level' => 0,
            'phone' => "1900 555 596",
            'updated_at' => "2021-03-10 00:09:59",
            'created_at' => "2021-03-10 00:09:59",
            'status' => 0,
        ];
        if(User::insert($value)){
            echo "thành công";
        }
        
    });

    // ajax
    Route::post('/ajax/login', [UsersController::class, 'postLogin'])->name('post-login');
});

Route::group(['prefix' => '/', 'middleware' => 'CheckAdmin'], function () {

    Route::get('', [OrdersController::class, 'index'])->name('order-index');
    Route::get('/tao-don-van', [OrdersController::class, 'add'])->name('order-add');
    Route::get('/them-dia-chi', [AddressController::class, 'add'])->name('address-add');
    Route::post('/chinh-dia-chi/{id}', [AddressController::class, 'edit'])->name('address-edit');
    Route::post('/xoa-dia-chi', [AddressController::class, 'delete'])->name('address-delete');
    Route::post('/cap-nhat-dia-chi-cho-tai-khoan', [UsersController::class, 'updateAddressId'])->name('user-update-address-id');
    Route::get('/theo-doi-don-van', [OrdersController::class, 'index'])->name('order-index');
    Route::get('/dang-xuat', [UsersController::class, 'logout'])->name('logout');

    Route::post('/yeu-cau-phat', [OrdersController::class, 'yeuCauPhat'])->name('yeu-cau-phat');
    Route::post('/post-add-address', [AddressController::class, 'postAdd'])->name('post-add-address');
    Route::post('/tao-don-van-api-map', [OrdersController::class, 'postAddByMapAPI'])->name('post-add-map-api');
    
    Route::post('/theo-doi-don-van-search', [OrdersController::class, 'postSearchIndex'])->name('post-order-index');
    Route::post('/post-import-order', [OrdersController::class, 'postImport'])->name('post-import-order');
    Route::post('/post-add-order', [OrdersController::class, 'postAdd'])->name('post-add-order');
    Route::post('/post-add-order-excel', [OrdersController::class, 'postAddExcel'])->name('post-add-address');
    Route::post('/post-payment', [OrdersController::class, 'postPayment'])->name('post-payment');

    // Route::get('/', [AppController::class, 'index'])->name('home');
    // Route::post('/', [AppController::class, 'add'])->name('add');
    // Route::get('tao-don-hang', [ProductController::class, 'creat'])->name('product');

});
    

// Route::get('/{any}', [AppController::class, 'pagenotfound'])->where('any', '.*');