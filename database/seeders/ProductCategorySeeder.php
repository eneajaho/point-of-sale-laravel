<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(10)->create();

        DB::table('product_category')->insert([
            'name' => 'Te ftohta',
            'icon' => 'sports_bar',
            'color' => 'blue'
        ]);
    }
}
