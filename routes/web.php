<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RevenueController;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});

Auth::routes();

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/getMonthlyRevenue', [DashboardController::class, 'getMonthlyRevenue']); // Ajax call
Route::post('/getAnnuallyRevenue', [DashboardController::class, 'getAnnuallyRevenue']); // Ajax call


Route::group(['prefix' => 'goods', 'middleware' => ['auth']], function(){
    // Companies Routes
    Route::resource('companies', CompanyController::class);
    Route::post('companies/deleteSelected', [CompanyController::class, 'destroySelected'])->name('companies.destroySelected');

    Route::group(['middleware' => ["isAdministrator"]], function(){
        //Categories Routes
        Route::resource('categories', CategoryController::class);
        Route::post('categories/deleteSelected', [CategoryController::class, 'destroySelected'])->name('categories.destroySelected');
    });

    //Products Routes
    Route::resource('products', ProductController::class);
    Route::post('products/deleteSelected', [ProductController::class, 'destroySelected'])->name('products.destroySelected');
});

Route::group(['middleware' => ['auth']], function(){
    //Orders Routes
    Route::resource('orders', OrderController::class);
    Route::post('orders/deleteSelected', [OrderController::class, 'destroySelected'])->name('orders.destroySelected');
    Route::post('orders/getTotalPriceByIds', [OrderController::class, 'getTotalPriceByIds'])->name('orders.getTotalPriceByIds');
    Route::post('orders/deliverOrder', [OrderController::class, 'deliverOrder'])->name('orders.deliverOrder');
    Route::post('orders/finishOrder', [OrderController::class, 'finishOrder'])->name('orders.finishOrder');
    Route::post('orders/restoreOder', [OrderController::class, 'restoreOder'])->name('orders.restoreOder');

    //Customers Routes
    Route::resource('customers', CustomerController::class);
    Route::post('customers/deleteSelected', [CustomerController::class, 'destroySelected'])->name('customers.destroySelected');
    Route::post('customers/getCustomerInfoByIdAndCompanyId', [CustomerController::class, 'getCustomerInfoByIdAndCompanyId']);

    //Revenue Routes
    Route::get('revenue', [RevenueController::class, 'index'])->name('revenue.index');
    Route::get('revenue/{companySlug}', [RevenueController::class, 'revenue'])->name('revenue.company');
    Route::post('getDateRevenueByDateRange', [RevenueController::class, 'getDateRevenueByDateRange']); // Ajax call
});
