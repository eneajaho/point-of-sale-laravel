<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            ShiftsSeeder::class,
            UserShiftsSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            ProductStockHistorySeeder::class
        ]);
    }
}
