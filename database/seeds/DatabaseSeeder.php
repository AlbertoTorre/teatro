<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User',2)->create();
        
        $this->call(ChairsTableSeeder::class);

        factory('App\Models\Reservations\Premiere',2)->create()->each(function($pt){
        		factory('App\Models\Reservations\PremiereTime',2)->create(['premiere_id'=> $pt]);
        });
    }
}
