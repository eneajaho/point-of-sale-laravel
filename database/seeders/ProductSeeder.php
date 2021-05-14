<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Birra Stela',
            'price' => 140,
            'low_stock' => 15,
            'optimal_stock' => 100,
            'barcode' => '8472942',
            'product_category_id' => 1,
            'stock_id' => 1
        ]);

        DB::table('products')->insert([
            'name' => 'Birra Peja',
            'price' => 110,
            'low_stock' => 15,
            'optimal_stock' => 100,
            'barcode' => '8472942',
            'product_category_id' => 1,
            'stock_id' => 2
        ]);

        DB::table('products')->insert([
            'name' => 'Birra Peroni',
            'price' => 130,
            'low_stock' => 15,
            'optimal_stock' => 100,
            'barcode' => '8472942',
            'product_category_id' => 1,
            'stock_id' => 3
        ]);

        DB::table('products')->insert([
            'name' => 'Birra Korca',
            'price' => 120,
            'low_stock' => 15,
            'optimal_stock' => 100,
            'barcode' => '8472942',
            'product_category_id' => 1,
            'stock_id' => 4
        ]);

        DB::table('products')->insert([
            'name' => 'Birra Paulaner',
            'price' => 200,
            'low_stock' => 15,
            'optimal_stock' => 100,
            'barcode' => '8472942',
            'product_category_id' => 1,
            'stock_id' => 5
        ]);
    }
}
