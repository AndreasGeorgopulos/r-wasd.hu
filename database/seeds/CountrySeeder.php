<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$allowedCountryCodes = $this->getAllowedCountryCodes();

		$fp = fopen(database_path('seeds/data/countries.csv'), 'r');
		$index = 0;
		while ($row = fgetcsv($fp, null, ';')) {
			if (!$index++ || Country::where('id', $row[0])->count()) {
				continue;
			}

			(new Country())->fill([
				'id' => $row[0],
				'code' => $row[1],
				'name' => $row[2],
				'is_active' => (bool) in_array($row[1], $allowedCountryCodes),
			])->save();
		}
		fclose($fp);
    }

	private function getAllowedCountryCodes()
	{
		$codes = [];
		$fp = fopen(database_path('seeds/data/posta_ems_orszaglista.csv'), 'r');
		while ($row = fgetcsv($fp, null, ';')) {
			$codes[] = $row[1];
		}
		fclose($fp);

		return $codes;
	}
}
