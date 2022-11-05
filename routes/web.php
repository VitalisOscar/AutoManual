<?php

use Illuminate\Support\Facades\Route;

Route::get('app/{path?}', function () {
    return view('app');
})->where('path', '(.*)');
