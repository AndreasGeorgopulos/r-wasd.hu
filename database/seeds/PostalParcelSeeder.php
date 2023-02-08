<?php

use App\Models\PostalParcel;
use Illuminate\Database\Seeder;

class PostalParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $fp = fopen(database_path('seeds/data/postal_parcels.csv'), 'r');
	    $index = 0;
	    while ($row = fgetcsv($fp, null, ';')) {
		    if (!$index++ || PostalParcel::where('id', $row[0])->count()) {
			    continue;
		    }

			$model = new PostalParcel();
		    $model->fill([
			    'id' => $row[0],
			    'name' => $row[1],
			    'is_active' => $row[2],
		    ]);
			$model->save();
			$model->countries()->sync(!empty($row[3]) ? explode(',', $row[3]) : []);
	    }

		fclose($fp);
    }
}
