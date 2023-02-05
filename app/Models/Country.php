<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Country model
 */
class Country extends Model
{
	use SoftDeletes;

    protected $table = 'countries';

	protected $fillable = ['code', 'name', 'is_active'];

	protected $casts = [
		'is_active' => 'bool',
	];

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
}
