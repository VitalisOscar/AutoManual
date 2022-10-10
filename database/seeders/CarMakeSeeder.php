<?php

namespace Database\Seeders;

use App\Models\CarMake;
use Illuminate\Database\Seeder;

class CarMakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Toyota', 'BMW', 'Subaru', 'Tesla', 'Chevrolet', 'Honda'];

        foreach($names as $name){
            if(CarMake::where('name', $name)->first() == null){
                CarMake::create([
                    'name' => $name,
                ]);
            }
        }
    }
}
