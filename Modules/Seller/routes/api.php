<?php

use Illuminate\Support\Facades\Route;
use Modules\Seller\Http\Controllers\Cars\AddCarController;
use Modules\Seller\Http\Controllers\Cars\EditCarController;
use Modules\Seller\Http\Controllers\Profile\SellerSignUpController;

Route::prefix('seller')
->middleware(['auth:user', 'is_seller'])
->name('seller')
->group(function(){

    Route::post('account/start', [SellerSignUpController::class, 'index'])
        ->middleware(['not_seller'])
        ->withoutMiddleware('is_seller')
        ->name('.get_started');

    // Listings
    Route::prefix('listings')
    ->name('.listings')
    ->group(function(){

        Route::post('add', [AddCarController::class, 'index'])->name('.add');

        // Single
        Route::prefix('{car_id}')
        ->name('.single')
        ->group(function(){

            Route::post('edit', [EditCarController::class, 'index'])->name('.edit');

        }); // End single

    }); // End listings

});
