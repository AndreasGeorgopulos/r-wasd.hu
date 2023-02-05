<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Rendelés model
 */
class Order extends Model implements IModelDeletable, IModelRules
{
    use SoftDeletes;

	protected $table = 'orders';

	protected $fillable = [
		//'postal_parcel_id',
		'shipping_country_id',
		'shipping_zip',
		'shipping_city',
		'shipping_address',
		'name',
		'email',
		'phone',
		'notice',
	];

	/**
	 * Postai csomag reláció
	 *
	 * @return HasOne
	 */
	public function postal_parcel()
	{
		return $this->hasOne(PostalParcel::class, 'id', 'postal_parcel_id');
	}

	/**
	 * Ország reláció
	 *
	 * @return HasOne
	 */
	public function shipping_country()
	{
		return $this->hasOne(Country::class, 'id', 'shipping_country_id');
	}

	/**
	 * Rendelés elemek reláció
	 *
	 * @return HasMany
	 */
	public function order_items()
	{
		return $this->hasMany(OrderItem::class, 'order_id', 'id');
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
		return [];
	}

	/**
	 * A model validálásakor használt mező feliratok
	 *
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [];
	}
}
