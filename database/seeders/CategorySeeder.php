<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Brand New', 'Locally Used', 'Foreign Used', 'Imports'];

        foreach($names as $name){
            if(Category::where('name', $name)->first() == null){
                Category::create([
                    'name' => $name,
                    'slug' => \Illuminate\Support\STr::slug($name)
                ]);
            }
        }
    }
}
