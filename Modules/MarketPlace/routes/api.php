<?php

use Illuminate\Support\Facades\Route;
use Modules\MarketPlace\Http\Controllers\Listing\AddCarController;
use Modules\MarketPlace\Http\Controllers\Listing\EditCarController;
use Modules\MarketPlace\Http\Controllers\Listing\ListedCarsController;
use Modules\MarketPlace\Http\Controllers\MarketPlace\PublicListingsController;

// public Listings
Route::prefix('marketplace')
->name('marketplace')
->group(function(){

    Route::get('', [PublicListingsController::class, 'all']);

    Route::get('seller/{slug}', [PublicListingsController::class, 'bySeller']);

    // Single
    Route::prefix('{slug}')
    ->name('.single')
    ->group(function(){

        Route::get('', [PublicListingsController::class, 'single']);

    }); // End single

}); // End public listings


Route::prefix('seller')
->middleware(['auth:user', 'is_seller'])
->name('seller')
->group(function(){

    // Listings
    Route::prefix('listings')
    ->name('.listings')
    ->group(function(){

        Route::get('', [ListedCarsController::class, 'all']);

        Route::post('add', [AddCarController::class, 'index'])->name('.add');

        // Single
        Route::prefix('single/{car_id}')
        ->name('.single')
        ->group(function(){

            Route::get('', [ListedCarsController::class, 'single']);

            Route::post('edit', [EditCarController::class, 'index'])->name('.edit');

        }); // End single

    }); // End listings

});
