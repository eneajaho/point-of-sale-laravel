<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductStockHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(10)->create();

        DB::table('products_stock_history')->insert([
            'before_supply' => 20,
            'after_supply' => 40,
            'product_id' => 1,
            'stock_id' => 1,
            'product_category_id' => 1
        ]);
    }
}
