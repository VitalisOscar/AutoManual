<?php

namespace Modules\Seller\Http\Controllers\Cars;

use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use Modules\Seller\Models\Car;

trait Validator{

    function getValidator(){
        return validator(request()->all(), [
            'title' => 'required|string',
            'year' => 'required|numeric|min:1950|max:'.today()->year,
            'mileage' => 'required|numeric|min:0',
            'fuel' => 'required|in:'.implode(',', Car::FUEL_TYPES),
            'transmission' => 'required|in:'.implode(',', Car::TRANSMISSIONS),
            'color' => 'required',
            'engine' => 'required|numeric',
            'drive_type' => 'required|in:'.implode(',', Car::DRIVE_TYPES),
            'location',
            'description',
            'category' => 'required|exists:'.Category::TABLE_NAME.',id',
            'body_type' => 'required|exists:'.BodyType::TABLE_NAME.',id',
            'make' => 'required|exists:'.CarMake::TABLE_NAME.',id',
            'model' => 'required|exists:'.CarModel::TABLE_NAME.',id',
            'features',
        ], [

        ]);
    }

}
