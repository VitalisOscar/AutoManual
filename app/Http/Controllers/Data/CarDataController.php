<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\Category;
use Illuminate\Http\Request;
use Modules\MarketPlace\Models\Car;

class CarDataController extends Controller
{

    public function getOptions(){
        return $this->json->data(
            [
                'body_types' => BodyType::all(),
                'categories' => Category::all(),
                'car_makes' => CarMake::all(),
                'transmissions' => Car::TRANSMISSIONS,
                'fuel_types' => Car::FUEL_TYPES,
            ]
        );
    }

    public function getModels(Request $request){
        $make = CarMake::whereId($request->get('make'))->first();

        if($make == null){
            $models = [];
        }else{
            $models = $make->models()->get();
        }

        return $this->json->data($models);
    }

}
