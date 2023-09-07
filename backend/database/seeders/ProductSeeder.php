<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Basketball', 'description' => 'A round basketball', 'price' => 20.99, 'image' => null],
            ['name' => 'Football', 'description' => 'A classic football', 'price' => 15.50, 'image' => 'football.png'],
            ['name' => 'Tennis Ball', 'description' => 'A small tennis ball', 'price' => 5.25, 'image' => null],
        ];

        DB::table('products')->insert($products);
    }

}
