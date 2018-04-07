<?php

use Illuminate\Database\Seeder;

/* My uses */
use Illuminate\Support\Facades\Config;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' 		=> 'Eric',
            'email' 	=> 'eric.tarillon@gmail.com',
            'role'      => 'admin',
            'confirmed' => 1,
            'key'       => str_random(30),
            'password' 	=> bcrypt('pwdpwdpwd'),
        ]);

    }
}
