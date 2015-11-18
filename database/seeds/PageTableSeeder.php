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
        for ($i=0; $i < 5; $i++) { 
            DB::table('pages')->insert([
                'slug'      => 'page-'.$i,
                'controller'=> 'pages',
                'name'      => 'Page '.$i,
                'content'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ligula enim, rutrum pretium mi non, faucibus rutrum felis',
            ]);
        }
        
    }
}
