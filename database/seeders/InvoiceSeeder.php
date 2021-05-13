<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->insert([
            'created_at' => Carbon::now(),
            'total' => 140,
            'is_paid' => true,
            'user_id' => 1,
            'shift_id' => 1,
        ]);
    }
}
