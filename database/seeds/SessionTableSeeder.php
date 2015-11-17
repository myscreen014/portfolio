<?php

use Illuminate\Database\Seeder;

class SessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
            DB::table('sessions')->insert([
                'amount'    => rand( 50 , 500),
                'bankroll_id'  => 1,
            ]);
        }
    }
}
