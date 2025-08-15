<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\WeHelpSectionController;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('pages', PageController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('blocks', BlockController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('products', ProductController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('we-help', WeHelpSectionController::class);
    Route::apiResource('quotes', QuoteController::class);
    Route::apiResource('quote-items', QuoteItemController::class);
    Route::resource('order', OrderController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('/admin/orders/{id}/invoice', [OrderController::class, 'generateInvoice'])->name('admin.orders.invoice');

});