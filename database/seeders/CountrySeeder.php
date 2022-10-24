<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Country::where('name', 'Kenya')->first() == null){
            Country::create([
                'name' => 'Kenya',
                'code' => 'KE',
                'phone_code' => '+254'
            ]);
        }
    }
}
