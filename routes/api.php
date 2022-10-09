<?php

use Rawilk\LaravelModules\Facades\Module;

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
