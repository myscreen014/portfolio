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
        $idPage = 0;
        for ($i=0; $i < 3; $i++) { 
            DB::table('pages')->insert([
                'slug'      => 'page-'.$i,
                'menu'      => 'primary',
                'controller'=> 'pages',
                'name'      => 'Page '.$i,
                'content'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ligula enim, rutrum pretium mi non, faucibus rutrum felis',
            ]);
            $idPage++;
            for ($j=0; $j < 1; $j++) { 
                DB::table('pages')->insert([
                    'parent'    => $idPage,
                    'slug'      => 'page-'.$i.'-'.$j,
                    'menu'      => 'primary',
                    'controller'=> 'pages',
                    'name'      => 'Sous-page '.$i.'-'.$j,
                    'content'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ligula enim, rutrum pretium mi non, faucibus rutrum felis',
                ]);
                $idPage++;
            }
        }
        
    }
}
