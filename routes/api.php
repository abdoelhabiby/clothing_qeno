<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CategoryCollection;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('categories',function(Request $request){
    $vaidted = $request->validate([
        'name' => 'required|string',
        'slug' => 'required|string'
    ]);

    return $vaidted;
});


Route::get('categories',[CategoryController::class,'index']);

Route::get('category/{category:slug}/products',[CategoryController::class,'productsCategory']);

Route::get('products',[ProductController::class,'index']);

