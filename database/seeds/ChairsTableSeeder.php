<?php

use Illuminate\Database\Seeder;
use App\Models\Reservations\Chair;

class ChairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	      $json =  json_decode(file_get_contents(base_path() . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR .'data' . DIRECTORY_SEPARATOR .'chairs.json'), true);
	      foreach ($json as $v) {
	          Chair::create([
	              'rows'=> $v['rows'],
	              'columns'=> $v['columns']
	          ]);
	      }
    }
}
