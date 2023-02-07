<?php
namespace App\Traits;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

/**
 * Trait TCart
 * @package App\Traits
 */
trait TCart {
	/**
	 * @param int $product_id
	 * @param int $amount
	 */
	protected function setCartItem (int $product_id, int $amount)
	{
		$cart_items = $this->getCartItems();

		if ($amount > 0) {
			if (collect($cart_items)->where('product_id', $product_id)->count()) {
				$cart_items = array_map(function ($item) use($product_id, $amount) {
					if ($item['product_id'] == $product_id) {
						$item['amount'] = $amount;
					}
					return $item;
				}, $cart_items);
			} else {
				$cart_items[] = [
					'product_id' => $product_id,
					'amount' => $amount,
				];
			}
		}
		else {
			$items = [];
			foreach ($cart_items as $item) {
				if ($item['product_id'] != $product_id) {
					$items[] = $item;
				}
			}
			$cart_items = $items;
		}

		if (!empty($cart_items)) {
			Cookie::queue(Cookie::make('cart_items', base64_encode(serialize($cart_items)), 3600));
		}
		else {
			Cookie::queue(Cookie::forget('cart_items'));
			//Cookie::queue(Cookie::forget('order'));
		}
	}

	/**
	 * @return string
	 */
	protected function getCartItems (): array
	{
		$cart_items = unserialize(base64_decode(Cookie::get('cart_items')));
		return is_array($cart_items) ? $cart_items : [];
	}

	/**
	 *
	 */
	protected function eraseCartItems ()
	{
		if ($cart_items = $this->getCartItems()) {
			Cookie::queue(Cookie::forget('cart_items'));
		}
	}

	/**
	 * @param float $price
	 * @param string $pre_tag
	 * @param string $post_tag
	 * @param int $decimals
	 * @param string $dec_point
	 * @param string $thousands_sep
	 * @return string
	 */
	protected function priceFormat (float $price, string $pre_tag = '€', string $post_tag = '', int $decimals = 0, string $dec_point = '.', string $thousands_sep = ' '): string
	{
		return $pre_tag . number_format(round($price, 2), $decimals, $dec_point, $thousands_sep) . $post_tag;
	}

	/**
	 * @return array
	 */
	private function getCartData()
	{
		$data = [
			'cart_items' => $this->getCartItems(),
		];

		$total = 0;
		$weight = 0;
		foreach ($data['cart_items'] as &$item) {
			$product = Product::find($item['product_id']);
			$item['name'] = $product->getTitle();
			$item['description'] = $product->getLead();
			$item['url'] = url(route('product', ['slug' => $product->getSlug()]));
			$item['weight'] = $product->weight;
			$item['weight_total'] = $product->weight * $item['amount'];
			$item['price'] = $product->price;
			$item['price_formated'] = $this->priceFormat($product->price, '€', '', 2);
			$item['total'] = (round($product->price) * $item['amount']);
			$item['total_formated'] = $this->priceFormat((float) $item['total'], '€', '', 2);
			$total += (round($product->price) * $item['amount']);
			$weight += $product->weight * $item['amount'];
		}

		$data['weight'] = $weight;
		$data['total'] = $total;
		$data['total_formated'] = $this->priceFormat($total, '€', '', 2);

		return $data;
	}
}
