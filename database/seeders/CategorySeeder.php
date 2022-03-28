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
        Category::truncate();

        $categories = [
           ['slug' => 'hats', 'name' => 'hats'],
           ['slug' => 'jackts', 'name' => 'jackts'],
           ['slug' => 'mens' ,'name' => 'mens'],
        ];

        Category::insert($categories);
    }
}
