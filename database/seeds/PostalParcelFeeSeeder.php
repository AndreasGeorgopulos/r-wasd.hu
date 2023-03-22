<?php

use App\Models\PostalParcelFee;
use Illuminate\Database\Seeder;

class PostalParcelFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $fp = fopen(database_path('seeds/data/postal_parcels_fees.csv'), 'r');
	    $index = 0;
	    while ($row = fgetcsv($fp, null, ';')) {
		    if (!$index++) {
			    continue;
		    }

			$model = new PostalParcelFee();
			$model->postal_parcel_id = $row[0];
			$model->weight_from = $row[1];
			$model->weight_to = $row[2];
			$model->fee = $row[3];
			$model->save();
	    }

	    fclose($fp);
    }
}
