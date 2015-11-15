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
            'key'       => md5(Config::get('app.key').'Eric'.'eric.tarillon@gmail.com'),
            'password' 	=> bcrypt('pwdpwdpwd'),
        ]);
    }
}
