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
        //User::factory(10)->create();

        DB::table('products')->insert([
            'name' => 'Birra',
            'price' => 140,
            'low_stock' => 15,
            'optimal_stock' => 100,
            'barcode' => '8472942',
            'product_category_id' => 1
        ]);
    }
}
