<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->insert([
            'quantity' => 5,
            'price' => 10,
            'total' => 50,
            'product_id' => 1,
            'invoice_id' => 1
        ]);
    }
}
