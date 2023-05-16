<?php

namespace Database\Seeders;

use App\Models\IndexVideo;
use Illuminate\Database\Seeder;

class IndexVideoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $fp = fopen(database_path('seeds/data/index_videos.csv'), 'r');
	    $index = 0;
	    while ($row = fgetcsv($fp, null, ';')) {
		    if (!$index++ || IndexVideo::find($row[0])) {
			    continue;
		    }

		    $model = new IndexVideo();
		    $model->id = $row[0];
		    $model->sort = $row[1];
		    $model->filename = $row[2];
		    $model->is_active = true;
		    $model->save();
	    }

	    fclose($fp);
    }
}
