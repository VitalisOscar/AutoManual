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
        if(ProfileType::where('name', 'Personal')->first() == null){
            ProfileType::create([
                'name' => 'Personal'
            ]);
        }

        if(ProfileType::where('name', 'Dealership')->first() == null){
            ProfileType::create([
                'name' => 'Dealership'
            ]);
        }

        if(ProfileType::where('name', 'Auto Company')->first() == null){
            ProfileType::create([
                'name' => 'Auto Company'
            ]);
        }
    }
}
