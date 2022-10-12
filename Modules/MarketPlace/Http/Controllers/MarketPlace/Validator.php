<?php

namespace Modules\MarketPlace\Http\Controllers\MarketPlace;

use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use Modules\MarketPlace\Models\Car;

trait Validator{

    function getValidator(){
        return validator(request()->all(), [
            'price' => 'required|numeric',
            'title' => 'required|string',
            'year' => 'required|numeric|min:1950|max:'.today()->year,
            'mileage' => 'required|numeric|min:0',
            'fuel' => 'required|in:'.implode(',', Car::FUEL_TYPES),
            'transmission' => 'required|in:'.implode(',', Car::TRANSMISSIONS),
            'color' => 'required',
            'engine' => 'required|numeric',
            'drive_type' => 'required|in:'.implode(',', array_keys(Car::DRIVE_TYPES)),
            'location' => 'array',
            'location.town' => 'required|string',
            'location.area' => 'nullable|string',
            'description' => 'nullable',
            'category' => 'required|exists:'.Category::TABLE_NAME.',id',
            'body_type' => 'required|exists:'.BodyType::TABLE_NAME.',id',
            'make' => 'required|exists:'.CarMake::TABLE_NAME.',id',
            'model' => 'required|exists:'.CarModel::TABLE_NAME.',id',
            'features' => 'nullable|array',
            'features.*' => 'in:'.implode(',', Car::FEATURES),
            'main_image' => 'required|image',
            'images' => 'required|array',
            'images.*' => 'required|image',
        ], [

        ]);
    }

}
