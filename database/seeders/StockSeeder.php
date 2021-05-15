<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            'quantity' => 10,
            'type' => 'pcs',
            'product_id' => 1
        ]);
        DB::table('stocks')->insert([
            'quantity' => 15,
            'type' => 'pcs',
            'product_id' => 2
        ]);
        DB::table('stocks')->insert([
            'quantity' => 20,
            'type' => 'pcs',
            'product_id' => 3
        ]);
        DB::table('stocks')->insert([
            'quantity' => 30,
            'type' => 'pcs',
            'product_id' => 4
        ]);
        DB::table('stocks')->insert([
            'quantity' => 40,
            'type' => 'pcs',
            'product_id' => 5
        ]);
    }
}
