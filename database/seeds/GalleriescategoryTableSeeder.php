<?php

use Illuminate\Database\Seeder;

class GalleriescategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
            DB::table('gallerycategories')->insert([
                'slug'      => 'category-'.$i,
                'name'      => 'Category '.$i,
                'description'	=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci odio veritatis quae quasi, nisi nobis temporibus totam accusantium, voluptatem omnis inventore, magni voluptas, placeat praesentium iure natus perferendis. Sit, vel.',
            ]);
        }
    }
}
