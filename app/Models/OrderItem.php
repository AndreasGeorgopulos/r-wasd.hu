<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Rendelés elem model
 */
class OrderItem extends Model implements IModelRules
{
	use SoftDeletes;

	protected $table = 'order_items';

	protected $fillable = ['order_id', 'product_id', 'unit_price', 'amount'];

	/**
	 * @return HasOne
	 */
	public function product()
	{
		return $this->hasOne(Product::class, 'id', 'product_id');
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
