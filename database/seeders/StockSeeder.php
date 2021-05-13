<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(10)->create();

        DB::table('stocks')->insert([
            'quantity' => 40,
            'type' => 'pcs',
            'product_id' => 1
        ]);
    }
}
