<?php

use App\Http\Controllers\Data\CarDataController;
use App\Http\Controllers\Data\CountriesDataController;
use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

$modules = Module::scan();

foreach($modules as $module){
    if($module->isDisabled()){
        continue;
    }

    $routes_path = module_path($module) . '/routes/api.php';

    if(file_exists($routes_path)){
        require $routes_path;
    }
}

Route::prefix('data')
->name('data')
->group(function(){

    Route::get('car/options', [CarDataController::class, 'getOptions'])->name('car_options');
    Route::get('car/models', [CarDataController::class, 'getModels'])->name('car_models');

    Route::get('countries', [CountriesDataController::class, 'getCountries'])->name('countries');

});
