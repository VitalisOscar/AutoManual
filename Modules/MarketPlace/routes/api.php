<?php

use Illuminate\Support\Facades\Route;
use Modules\MarketPlace\Http\Controllers\Listing\AddCarController;
use Modules\MarketPlace\Http\Controllers\Listing\CarDeletionController;
use Modules\MarketPlace\Http\Controllers\Listing\CarImagesController;
use Modules\MarketPlace\Http\Controllers\Listing\EditCarController;
use Modules\MarketPlace\Http\Controllers\Listing\ListedCarsController;
use Modules\MarketPlace\Http\Controllers\MarketPlace\PublicListingsController;
use Modules\MarketPlace\Http\Controllers\User\FavoritesController;
use Modules\MarketPlace\Http\Controllers\User\UserAlertsController;

// public Listings
Route::prefix('marketplace')
->name('marketplace')
->group(function(){

    Route::get('', [PublicListingsController::class, 'all']);

    // Route::get('seller/{slug}', [PublicListingsController::class, 'bySeller']);

    // Single
    Route::prefix('{slug}')
    ->name('.single')
    ->group(function(){

        Route::get('', [PublicListingsController::class, 'single']);

    }); // End single

}); // End public listings


// User functionality
Route::prefix('user')
->name('user')
->middleware('auth:user')
->group(function(){

    Route::get('favorites', [FavoritesController::class, 'getAll'])->name('favorites');
    Route::post('favorites/{car_slug}/toggle', [FavoritesController::class, 'addOrRemove'])->name('toggle_favorite');

    Route::get('alerts', [UserAlertsController::class, 'getAll'])->name('alerts');
    Route::post('alerts/add', [UserAlertsController::class, 'add'])->name('alerts.add');
    Route::post('alerts/{alert_id}/delete', [UserAlertsController::class, 'delete'])->name('alerts.delete');

}); // End user functionality



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

            // Manage Images
            Route::post('images/add', [CarImagesController::class, 'add'])->name('.images.add');
            Route::post('images/remove', [CarImagesController::class, 'delete'])->name('.images.delete');
            Route::post('images/main', [CarImagesController::class, 'updateMain'])->name('.images.update_main');

            // Delete or restore
            Route::post('delete', [CarDeletionController::class, 'deleteOrTrash'])->name('.delete');
            Route::post('restore', [CarDeletionController::class, 'restoreTrashed'])->name('.restore');

        }); // End single

    }); // End listings

});
