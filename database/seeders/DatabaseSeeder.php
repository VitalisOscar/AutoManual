<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Seller\database\seeds\SellerDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BodyTypeSeeder::class);
        $this->call(CarMakeSeeder::class);
        $this->call(CarModelSeeder::class);
        $this->call(SellerDatabaseSeeder::class);
    }
}
