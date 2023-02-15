<?php

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $fp = fopen(database_path('seeds/data/contents.csv'), 'r');
	    $index = 0;
	    while ($row = fgetcsv($fp, null, ';')) {
		    if (!$index++ || Content::where('id', $row[0])->count()) {
			    continue;
		    }

		    (new Content())->fill([
			    'id' => $row[0],
			    'title' => $row[1],
			    'description' => $row[2],
			    'type' => $row[3],
			    'active' => $row[4],
		    ])->save();
	    }
	    fclose($fp);
    }
}
