<?php

namespace Database\Seeders;

use App\Models\BodyType;
use Illuminate\Database\Seeder;

class BodyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['SUVs', 'Saloon Cars', 'Sedan', 'Pickup Trucks', 'Vans and Minivans', 'Buses'];

        foreach($names as $name){
            if(BodyType::where('name', $name)->first() == null){
                BodyType::create([
                    'name' => $name,
                    'slug' => \Illuminate\Support\STr::slug($name)
                ]);
            }
        }
    }
}
