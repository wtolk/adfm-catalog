<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adfm\Catalog\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(5)->create();
    }
}
