<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Postai csomag díj model
 *
 * @property int $id
 * @property int $postal_parcel_id
 * @property float $weight_from
 * @property float $weight_to
 * @property double $price
 */
class PostalParcelFee extends Model
{
	use SoftDeletes;

    protected $table = 'postal_parcels_fees';
	protected $fillable = ['weight_from', 'weight_to', 'fee'];

	/**
	 * @param $countryId
	 * @param $weight
	 * @return void|null
	 */
	public static function findByCountry($countryId, $weight)
	{
		if (!($postalParcel = PostalParcel::findByCountry($countryId))) {
			return null;
		}

		$postalParcel->where(function ($q) use($weight) {
			$q->whereNotNull('weight_from');
			$q->whereNotNull('weight_to');
			$q->where('weight_from', '<=', $weight);
			$q->where('weight_to', '>=', $weight);
		})->orWhere(function ($q) use($weight) {
			$q->whereNotNull('weight_from');
			$q->whereNull('weight_to');
			$q->where('weight_from', '<=', $weight);
		})->first();
	}

	/**
	 * @param $countryId
	 * @param $weight
	 * @return float
	 */
	public static function getPostalFeeByWeight($countryId, $weight)
	{
		if (!($model = static::findByCountry($countryId, $weight))) {
			return 0.0;
		}

		return (float) $model->fee;
	}
}