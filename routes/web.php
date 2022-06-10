<?php

use App\Http\Controllers\Api\Internal\CartController;
use App\Http\Controllers\Api\Internal\ProductController as ApiProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function() {
    Route::get('/login','login')->name('login');
    Route::post('/login','authenticate')->name('authenticate');
});

Route::middleware(['auth'])->group(function() {
    Route::controller(HomeController::class)->group(function() {
        Route::get('/home','index')->name('home');
    });

    Route::resource('product',ProductController::class);

    Route::controller(PosController::class)->prefix('pos')->group(function() {
        Route::get('/', 'index')->name('pos.index');
        Route::post('/store-transaction','storeTransaction')->name('pos.store-transaction');
        Route::get('/transaction/{transaction}', 'detailTransaction')->name('pos.detail-transaction');
    });

    Route::controller(TransactionController::class)->prefix('transaction')->group(function () {
        Route::get('/', 'index')->name('transaction.index');
        Route::get('/{transaction}/detail', 'show')->name('transaction.show');
    Route::post('/{transaction}/refund','doRefund')->name('transaction.refund');
    });

    // API for Internal Apps
    Route::prefix('api-in')->name('api-in.')->group(function() {
        Route::controller(ApiProductController::class)->prefix('product')->group(function() {
            Route::get('/all','all')->name('product.all');
        });

        Route::controller(CartController::class)->prefix('cart')->group(function() {
            Route::get('/get','get')->name('cart.get');
            Route::post('/create', 'create')->name('cart.create');
            Route::post('/clear', 'clear')->name('cart.clear');
            Route::post('/manual-input', 'manualInput')->name('cart.manual-input');
        });
    });

});
