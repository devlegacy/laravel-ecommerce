<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categories', Api\CategoryController::class)->names('categories');
Route::apiResource('products', Api\ProductController::class)->names('products');
Route::group(['prefix' => 'products'], function () {
    Route::apiResource('/{product}/reviews', Api\ReviewController::class);
});
