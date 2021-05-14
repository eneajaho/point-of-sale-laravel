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
        ]);
        DB::table('stocks')->insert([
            'quantity' => 15,
            'type' => 'pcs',
        ]);
        DB::table('stocks')->insert([
            'quantity' => 20,
            'type' => 'pcs',
        ]);
        DB::table('stocks')->insert([
            'quantity' => 30,
            'type' => 'pcs',
        ]);
        DB::table('stocks')->insert([
            'quantity' => 40,
            'type' => 'pcs',
        ]);
    }
}
