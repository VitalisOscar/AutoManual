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
        $this->call(SellerDatabaseSeeder::class);
    }
}
