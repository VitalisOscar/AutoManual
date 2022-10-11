<?php

use Illuminate\Support\Facades\Route;
use Modules\Seller\Http\Controllers\SellerSignUpController;

Route::prefix('seller')
->middleware(['auth:user', 'is_seller'])
->name('seller')
->group(function(){

    Route::post('account/start', [SellerSignUpController::class, 'index'])
        ->middleware(['not_seller'])
        ->withoutMiddleware('is_seller')
        ->name('.get_started');

});
