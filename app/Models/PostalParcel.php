<?php

namespace App\Models;

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
}