<?php

use Illuminate\Database\Seeder;

class BankrollTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('bankrolls')->insert([
            'name'      => 'Bankroll 1 ',
            'user_id'   => 2,
        ]);
        
    }
}
