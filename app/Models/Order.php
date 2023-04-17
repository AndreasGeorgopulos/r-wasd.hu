<?php

namespace App\Models;

use App\Rules\ReCaptchaRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cookie;

/**
 * Rendelés model
 */
class Order extends Model implements IModelDeletable, IModelRules
{
    use SoftDeletes;

	protected $table = 'orders';

	protected $fillable = [
		'postal_parcel_id',
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
		return [
			'name' => 'required|min:3|max:100',
			'email' => 'required|email',
			'confirm_email' => !Cookie::has('order') ? 'required_with:email|same:email' : '',
			'phone' => 'required|min:10|max:30',
			'shipping_country_id' => 'required',
			'shipping_zip' => 'required',
			'shipping_city' => 'required',
			'shipping_address' => 'required',
			'accept_term_and_conditions' => !Cookie::has('order') ? 'required' : '',
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
			'name' => trans('Full name'),
			'email' => trans('E-mail'),
			'confirm_email' => trans('Confirm e-mail'),
			'phone' => trans('Phone'),
			'shipping_country_id' => trans('Country'),
			'shipping_zip' => trans('Zip'),
			'shipping_city' => trans('City'),
			'shipping_address' => trans('Address'),
		];
	}

	/**
	 * A model validálásakor használt egyedi üzenetek
	 *
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [];
	}
}
