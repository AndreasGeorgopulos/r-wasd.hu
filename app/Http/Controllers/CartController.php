<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Product;
use App\Traits\TCart;
use Illuminate\Support\Str;

class CartController extends Controller
{
	use TCart;

	public function index ()
	{
		$pageContentBlock_1 = Content::getBlockContent(5);
		$pageContentBlock_2 = Content::getBlockContent(6);

		return view('order.cart', [
			'meta_data' => [
				'title' => 'r-Wasd.com',
			],
			'pageContentBlock_1' => $pageContentBlock_1,
			'pageContentBlock_2' => $pageContentBlock_2,
		]);
	}

	public function get ()
	{
		$cart_items = $this->getCartItems();
		$total = 0;
		foreach ($cart_items as &$item) {
			$product = Product::find($item['product_id']);

			$data = [];
			$data['name'] = $product->getTitle();
			$data['url'] = url(route('product', ['slug' => $product->getSlug()]));
			$data['price'] = $product->price;
			$data['price_formated'] = $this->priceFormat($product->price, '€', '', 2);

			$item['product'] = $data;
			$item['total'] = (round($product->price) * $item['amount']);
			$item['total_formated'] = $this->priceFormat((float) $item['total'], '€', '', 2);
			$total += (round($product->price) * $item['amount']);
		}

		return response()->json([
			'cart_items' => $cart_items,
			'cart_item_count' => count($cart_items),
			'total' => $total,
			'total_formated' => $this->priceFormat($total, '€', '', 2),
		]);
	}

	/**
	 * @param int $product_id
	 * @param int $amount
	 */
	public function set (int $product_id = 0, int $amount = 0)
	{
		if (!$product_id) {
			$this->eraseCartItems();
			return;
		}

		if (!($product = Product::find($product_id)) /*|| $amount > $product->stock || $amount < 0*/) {
			abort(404);
		}

		$this->setCartItem($product_id, $amount);

		return response()->json(['data' => $this->getCartItems()]);
	}
}
