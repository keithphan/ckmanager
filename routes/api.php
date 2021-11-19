<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// =========================== Public APIs ===========================
Route::post('categories', [CategoryController::class, 'getAllCategories']);
Route::post('products', [ProductController::class, 'getProductsByCompanyAndCategory']);
Route::post('onSaleProducts', [ProductController::class, 'getOnSaleProducts']);
Route::post('product', [ProductController::class, 'getProductByCompanyAndCategory']);

// Customer APIs
Route::post('login', [CustomerController::class, 'login']);
Route::post('register', [CustomerController::class, 'register']);