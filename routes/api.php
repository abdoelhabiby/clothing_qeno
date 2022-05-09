<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Front\AuthUserController;
use App\Http\Controllers\Api\Front\ProductController;
use App\Http\Controllers\Api\Front\CategoryController;


if (!defined('API_PAGINATE_COUNT')) {
    define('API_PAGINATE_COUNT', 10);
}

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

Route::prefix('user')->group(function () {

    Route::get('/', [AuthUserController::class, 'getUser'])->middleware('auth:sanctum');

    Route::post('/register', [AuthUserController::class, 'register']);
    Route::post('/login', [AuthUserController::class, 'login']);
});





Route::get('categories', [CategoryController::class, 'index']);

Route::get('categories/products', [CategoryController::class, 'categoriesProducts']);

Route::get('category/{category:slug}/products', [CategoryController::class, 'productsCategory']);

Route::get('products', [ProductController::class, 'index']);
