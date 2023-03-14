<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Product;
use App\Traits\TCart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
	use TCart;

	/**
	 * @return Factory|Application|View
	 */
	public function index ()
	{
		$pageContentBlock_1 = Content::getBlockContent(5);
		$pageContentBlock_2 = Content::getBlockContent(6);

		list($cart_items, $cart_items_count, $total, $total_formated) = $this->getItems();

		return view('order.cart', [
			'meta_data' => [
				'title' => 'r-Wasd.com',
			],
			'pageContentBlock_1' => $pageContentBlock_1,
			'pageContentBlock_2' => $pageContentBlock_2,
			'cart_items' => $cart_items,
			'cart_item_count' => $cart_items_count,
			'total' => $total,
			'total_formated' => $total_formated,
		]);
	}

	/**
	 * @return JsonResponse
	 */
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
	 * @param Request $request
	 * @return Application|RedirectResponse|Redirector|void
	 */
	public function set(Request $request)
	{
		$product_id = $request->get('product_id');
		$amount = $request->get('amount');

		if (!$product_id) {
			$this->eraseCartItems();
			return;
		}

		if (!($product = Product::find($product_id)) /*|| $amount > $product->stock || $amount < 0*/) {
			abort(404);
		}

		$this->setCartItem($product_id, $amount);

		return redirect(url(route('cart_index')));
	}

	private function getItems()
	{
		$cart_items = $this->getCartItems();
		$total = 0;
		foreach ($cart_items as &$item) {
			$product = Product::find($item['product_id']);

			$data = [];
			$data['name'] = $product->getTitle();
			$data['description'] = $product->getLead();
			$data['url'] = url(route('product', ['slug' => $product->getSlug()]));
			$data['index_image'] = $product->hasIndexImage() ? $product->getIndexImageFileUrl('index') : null;
			$data['price'] = $product->price;
			$data['price_formated'] = $this->priceFormat($product->price, '€', '', 2);

			$item['product'] = $data;
			$item['total'] = (round($product->price) * $item['amount']);
			$item['total_formated'] = $this->priceFormat((float) $item['total'], '€', '', 2);
			$total += (round($product->price) * $item['amount']);
		}

		return [
			$cart_items,
			count($cart_items),
			$total,
			$this->priceFormat($total, '€', '', 2),
		];
	}
}
