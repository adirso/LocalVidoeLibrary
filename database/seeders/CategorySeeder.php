<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        \App\Models\Category::create(['name' => 'Action']);
        \App\Models\Category::create(['name' => 'Drama']);
        \App\Models\Category::create(['name' => 'Comedy']);
        \App\Models\Category::create(['name' => 'Thriller']);
        // Add more categories if needed
    }

}
