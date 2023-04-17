<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Postai csomag model
 *
 * @property int $id
 * @property string $name
 * @property bool $is_active
 */
class PostalParcel extends Model implements IModelRules, IModelDeletable
{
	use SoftDeletes;

	protected $table = 'postal_parcels';

	protected $fillable = ['name', 'is_active'];

	protected $casts = [
		'is_active' => 'bool',
	];

	/**
	 * Országok reláció
	 *
	 * @return BelongsToMany
	 */
	public function countries()
	{
		return $this->belongsToMany(Country::class, 'postal_parcels_countries', 'postal_parcel_id', 'country_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function fees()
	{
		return $this->hasMany(PostalParcelFee::class)->orderBy('weight_from', 'asc');
	}

	/**
	 * Model törölhetőségének ellenőrzése
	 *
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		return true;
	}

	/**
	 * A model validálásakor használt mező szabályok
	 *
	 * @return array
	 */
	public static function rules(): array
	{
		return [
			'name' => [
				'required',
				'min:3',
				'max:100',
			],
			'is_active' => [
				'required',
				'boolean',
			],
			'countries' => [
				'required',
				'array',
			],
		];
	}

	/**
	 * A model validálásakor használt mező feliratok
	 *
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'name' => trans('Name'),
			'is_active' => trans('Is active'),
			'countries' => trans('Countries'),
		];
	}

	/**
	 * A model validálásakor használt egyedi üzenetek
	 *
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [
			'is_active.boolean' => trans('Is active field must be yes or no.'),
		];
	}

	/**
	 * @param $countryId
	 * @return mixed
	 */
	public static function findByCountry($countryId)
	{
		return static::whereHas('countries', function ($q) use($countryId) {
			$q->where('countries.id', $countryId);
		})->first();
	}

	/**
	 * @param $countryId
	 * @param $weight
	 * @return PostalParcelFee
	 * @throws Exception
	 */
	public static function getFee($countryId, $weight)
	{
		$model = static::findByCountry($countryId);
		if (!$model) {
			throw new Exception('Postal parcel model not found');
		}

		$feeModel = $model->fees()->where(function ($q) use($weight) {
			$q->where('weight_from', '<=', $weight);
			$q->where('weight_to', '>=', $weight);
		})->first();

		if (!$feeModel) {
			throw new Exception('Postal parcel fee model not found');
		}

		return $feeModel;
	}
}