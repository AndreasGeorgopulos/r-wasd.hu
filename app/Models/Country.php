<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ország model
 *
 * @property string $code
 * @property string $name
 * @property bool $is_active
 * @property BelongsToMany $postal_parcels
 */
class Country extends Model implements IModelDeletable, IModelRules
{
	use SoftDeletes;

    protected $table = 'countries';

	protected $fillable = ['id', 'code', 'name', 'is_active'];

	protected $casts = [
		'is_active' => 'bool',
	];

	/**
	 * Postai csomagok reláció
	 *
	 * @return BelongsToMany
	 */
	public function postal_parcels(): BelongsToMany
	{
		return $this->belongsToMany(PostalParcel::class, 'postal_parcels_countries', 'country_id', 'postal_parcel_id');
	}

	/**
	 * Model törölhetőségének ellenőrzése
	 *
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		if (!$this->postal_parcels->count() && !$this->is_active) {
			return true;
		}
		return false;
	}

	/**
	 * Dropdown items of active countries
	 *
	 * @return mixed
	 */
	public static function getDropdownItems()
	{
		return static::select(['id', 'name'])
			->where('is_active', true)
			->orderBy('name', 'asc')
			->get()
			->toArray();
	}

	/**
	 * A model validálásakor használt mező szabályok
	 *
	 * @return array
	 */
	public static function rules(): array
	{
		return [
			'code' => [
				'required',
				'min:2',
				'max:3',
			],
			'name' => [
				'required',
				'min:3',
				'max:100',
			],
			'is_active' => [
				'required',
				'boolean'
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
			'code' => trans('Code'),
			'name' => trans('Name'),
			'is_active' => trans('Is active'),
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
