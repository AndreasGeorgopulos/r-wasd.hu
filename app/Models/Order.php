<?php

namespace App\Models;

use App\Rules\ReCaptchaRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Rendelés model
 */
class Order extends Model implements IModelDeletable, IModelRules
{
    use SoftDeletes;

	const STATUS_NEW = 1;
	const STATUS_SENT = 2;
	const STATUS_DONE = 3;

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
		'postal_tracking_code',
		'postal_notice',
		'finish_notice',
		'status',
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
	 * @return float
	 */
	public function getSubTotal(): float
	{
		$total = 0.0;
		foreach ($this->order_items as $orderItem) {
			$total += $orderItem->getTotal();
		}
		return $total;
	}

	/**
	 * @return float
	 */
	public function getTotal(): float
	{
		return $this->getSubTotal() + floatval($this->postal_fee);
	}

	/**
	 * @return string
	 */
	public function getBackRouteName(): string
	{
		switch ($this->status) {
			case Order::STATUS_DONE:
				$backRoute = 'admin_orders_done';
				break;
			case Order::STATUS_SENT:
				$backRoute = 'admin_orders_sent';
				break;
			case Order::STATUS_NEW:
			default:
				$backRoute = 'admin_orders_new';
		}

		return $backRoute;
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

	/**
	 * @param int $orderId
	 * @return string
	 */
	public function generateOrderCode(): string
	{
		$date = date('Y-m-d', strtotime($this->created_at));
		$dailyId = (int) self::where(function ($q) use($date) {
			$q->where('created_at', '>=', $date . ' 00:00:00');
			$q->where('created_at', '<=', $date . ' 23:59:00');
			$q->whereNotNull('order_code');
			$q->where('id', '<>', $this->id);
		})->count();

		return date('Ymd', strtotime($this->created_at)) . '-' . str_pad(++$dailyId, 6, '0', STR_PAD_LEFT);
	}
}
