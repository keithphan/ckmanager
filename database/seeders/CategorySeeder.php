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
        Category::create([
            'name' => 'Fruit & Vegetables',
        ]);

        Category::create([
            'name' => 'Fruit',
            'parent_id' => 1
        ]);

        Category::create([
            'name' => 'Vegetables',
            'parent_id' => 1
        ]);
    }
}
