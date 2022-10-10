<?php

namespace Modules\Seller\database\seeds;

use Illuminate\Database\Seeder;
use Modules\Seller\Models\ProfileType;

class ProfileTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Personal', 'Dealership', 'Auto Company'];

        foreach($names as $name){

            if(ProfileType::where('name', $name)->first() == null){
                ProfileType::create([
                    'name' => $name
                ]);
            }

        }

    }
}
