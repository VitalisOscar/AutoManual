<?php

use Illuminate\Support\Facades\Route;
use Modules\Account\Http\Controllers\Auth\AuthDataController;
use Modules\Account\Http\Controllers\Auth\LoginController;
use Modules\Account\Http\Controllers\Auth\SignupController;
use Modules\Account\Http\Controllers\Auth\VerifyPhoneController;

Route::prefix('account')
->middleware('auth:user')
->name('account')
->group(static function () {

    Route::get('refresh-user', [AuthDataController::class, 'refreshUser'])->name('.refresh_user');

    Route::post('login', [LoginController::class, 'index'])->name('.login')->withoutMiddleware('auth:user');
    Route::post('signup', [SignupController::class, 'index'])->name('.signup')->withoutMiddleware('auth:user');

    Route::post('verification/phone/request', [VerifyPhoneController::class, 'requestCode'])->name('.request_phone_verification');
    Route::post('verification/phone/verify', [VerifyPhoneController::class, 'verify'])->name('.verify_phone');

});
