<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   	public function run()
    {
        for ($i=0; $i < 3; $i++) { 
            DB::table('pages')->insert([
                'slug'      => 'page-'.$i,
                'menu'      => 'primary',
                'controller'=> 'pages',
                'name'      => 'Page '.$i,
                'content'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ligula enim, rutrum pretium mi non, faucibus rutrum felis',
            ]);
        }
        
    }
}
