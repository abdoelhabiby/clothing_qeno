<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;

if (!defined('DASHBOARD_PAGINATE_COUNT')) {
    define('DASHBOARD_PAGINATE_COUNT',10);
}


Route::name('dashboard.')->group(function () {


    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('home');

        Route::resource('categories',\CategoryController::class,[
            'except' => 'show'
        ]);

        Route::resource('products',\ProductController::class);

        Route::post('logout',[AuthController::class,'logout'])->name('logout');
    });



    Route::get('/login',[AuthController::class,'showLogin'])->name('show_login');

    Route::post('/login',[AuthController::class,'login'])->name('login')->middleware('throttle:60,1');



});
