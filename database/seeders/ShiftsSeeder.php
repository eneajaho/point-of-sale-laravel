<?php


namespace Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(10)->create();

        DB::table('shifts')->insert([
            'name' => 'Turni 1',
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()
        ]);
    }
}
