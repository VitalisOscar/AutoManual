<?php

namespace Database\Seeders;

use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'make' => 'Toyota',
                'models' => [
                    'Toyota Avalon',
                    'Toyota Camry',
                    'Toyota Corolla',
                    'Toyota Prius',
                    'Toyota Yaris',
                    'Toyota 86',
                    'Toyota Sienna'
                ]
            ]
        ];

        foreach($data as $model_data){
            $make = $model_data['make'];
            $db_make = CarMake::where('name', $make)->first();

            $models = $model_data['models'];

            foreach($models as $model){
                if(
                    CarModel::where('name', $model)
                    ->where('car_make_id', $db_make->id)
                    ->first() == null
                ){

                    CarModel::create([
                        'name' => $model,
                        'car_make_id' => $db_make->id,
                        'slug' => \Illuminate\Support\STr::slug($model)
                    ]);
                }
            }


        }
    }
}
