<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\QuoteItemController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\WhyChooseUsController;
use App\Http\Controllers\Api\WeHelpSectionApiController;




Route::get('/products/featured', [ProductApiController::class, 'featured']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/product/{slug}', [ProductApiController::class, 'getBySlug']);

Route::get('/category/{slug}', [ProductApiController::class, 'productsByCategories']);
Route::get('/categories/{parentSlug}/{childSlug}', [ProductApiController::class, 'productsByChildCategory']);

Route::Resource('sliders', SliderController::class);
Route::Resource('categories', CategoriesController::class);

Route::get('/blocks', [BlockController::class, 'index']);
Route::get('/blocks/{identifier}', [BlockController::class, 'showByIdentifier']);

Route::Resource('pages', PageController::class);

Route::Resource('orderitems', OrderItemController::class);

Route::get('/orderitems', [OrderItemController::class, 'index']);

Route::get('/order', [OrderController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/users', UserController::class)->except(['store']);
    Route::post('/cart/add', [QuoteItemController::class, 'addToCart']);
    Route::get('/cart', [QuoteItemController::class, 'getCart']);
    Route::delete('/cart/remove/{id}', [QuoteItemController::class, 'removeItem']);
    Route::post('/quotes', [QuoteController::class, 'store']);
    Route::get('/quotes', [QuoteController::class, 'index']);
    Route::put('/quotes/{id}', [QuoteController::class, 'update']);
    Route::get('/coupons', [CouponController::class, 'index']);
    Route::post('/coupon/apply', [CouponController::class, 'apply']);
    Route::post('/coupon/remove', [CouponController::class, 'remove']);
    Route::post('/place-order', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'userOrders']);
    Route::put('/user/update', [UserController::class, 'update']);
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/add', [WishlistController::class, 'store']);
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'destroy']);
    Route::get('/orders/{orderId}/invoice', [OrderController::class, 'generateInvoice']);


});


Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);








