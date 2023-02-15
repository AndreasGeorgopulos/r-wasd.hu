<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PostalParcel;
use App\Traits\TCart;
use App\Traits\TDbTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends Controller
{
	use TCart, TDbTransaction;

	private $_api_context;

	public function __construct()
	{
		$paypal_configuration = \config('paypal');
		$this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
		$this->_api_context->setConfig($paypal_configuration['settings']);
	}

    public function checkout(Request $request)
    {
	    if (!($cartData = $this->getCartData()) || empty($cartData['cart_items'])) {
		    return redirect(route('cart_index'));
	    }

		$model = new Order();
		$order = $this->getCookieOrder();
		$model->fill($order);

	    if ($request->isMethod('post')) {
			$model->fill($request->all());
		    $validator = Validator::make($request->all(), Order::rules());
		    $validator->setAttributeNames(Order::niceNames());
		    if ($validator->fails()) {
			    /*return redirect(route('admin_contents_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
				    trans('Sikertelen mentés'),
				    trans('A tartalom adatainak rögzítése nem sikerült a következő hibák miatt:')
			    ]);*/
		    }

			$this->setCookieOrder($model);

			return redirect(route('order_checkout_check'));
		}

	    $pageContentBlock_1 = Content::getBlockContent(7);
	    $pageContentBlock_2 = Content::getBlockContent(8);

	    return view('order.checkout', [
			'model' => $model,
			'cartData' => $this->getCartData(),
			'accepted_terms_and_conditions' => (bool) !empty($order),
		    'meta_data' => [
			    'title' => 'r-Wasd.com',
		    ],
		    'pageContentBlock_1' => $pageContentBlock_1,
		    'pageContentBlock_2' => $pageContentBlock_2,
	    ]);
    }

	public function checkoutCheck()
	{
		if (!($order = $this->getCookieOrder()) || !($cartData = $this->getCartData()) || empty($cartData['cart_items'])) {
			return redirect(route('cart_index'));
		}

		$model = (new Order())->fill($order);

		$pageContentBlock_1 = Content::getBlockContent(9);
		$pageContentBlock_2 = Content::getBlockContent(10);

		return view('order.checkout_check', [
			'model' => $model,
			'order' => $order,
			'cartData' => $cartData,
			'meta_data' => [
				'title' => 'r-Wasd.com',
			],
			'pageContentBlock_1' => $pageContentBlock_1,
			'pageContentBlock_2' => $pageContentBlock_2,
		]);
	}

	public function payment(Request $request)
	{
		$redirect_url = null;

		if (!($order = $this->getCookieOrder()) || !($cartData = $this->getCartData()) || empty($cartData['cart_items'])) {
			return redirect(route('cart_index'));
		}

		if ($request->isMethod('post')) {

			$this->runDbTransaction(function () use($cartData, &$redirect_url) {
				$model = new Order();

				// postai csomag választás a kiválasztott ország alapján.
				$model->postal_parcel_id = 1;

				$model->fill($this->getCookieOrder())->save();
				$model->order_code = date('Ymd') . '_' . $model->id;
				$model->save();

				$payer = new Payer();
				$payer->setPaymentMethod('paypal');

				$items = [];
				foreach ($cartData['cart_items'] as $cartItem) {
					(new OrderItem())->fill([
						'order_id' => $model->id,
						'product_id' => $cartItem['product_id'],
						'unit_price' => $cartItem['price'],
						'amount' => $cartItem['amount'],
					])->save();

					$items[] = (new Item())->setName($cartItem['name'])
						->setDescription($cartItem['description'])
						->setCurrency('EUR')
						->setQuantity($cartItem['amount'])
						->setPrice($cartItem['price']);
				}

				$item_list = new ItemList();
				$item_list->setItems($items);

				$amount = new Amount();
				$amount->setCurrency('EUR')->setTotal($cartData['total']);

				$transaction = new Transaction();
				$transaction->setAmount($amount)
					->setItemList($item_list)
					->setDescription('Enter Your transaction description');

				$redirect_urls = new RedirectUrls();
				$redirect_urls->setReturnUrl(url(route('success_payment', ['order_code' => $model->order_code])))
					->setCancelUrl(url(route('cancel_payment', ['order_code' => $model->order_code])));

				$payment = new Payment();
				$payment->setIntent('Sale')
					->setPayer($payer)
					->setRedirectUrls($redirect_urls)
					->setTransactions(array($transaction));

				try {
					$payment->create($this->_api_context);

					// cookie-k törlése
					//$this->setCookieOrder(null);
					//$this->eraseCartItems();

					foreach($payment->getLinks() as $link) {
						if($link->getRel() == 'approval_url') {
							$redirect_url = $link->getHref();
							break;
						}
					}

				} catch (\PayPal\Exception\PPConnectionException $ex) {
					throw new Exception($ex->getMessage());
				}

			}, function ($exception) use(&$redirect_url) {
				Session::put('error', $exception->getMessage());
				$redirect_url = url(route('order_payment'));
			});

			if (!empty($redirect_url)) {
				return redirect($redirect_url);
			}
		}

		$pageContentBlock = Content::getBlockContent(11);

		return view('order.payment', [
			'order' => $order,
			'cartData' => $cartData,
			'meta_data' => [
				'title' => 'r-Wasd.com',
			],
			'pageContentBlock' => $pageContentBlock,
		]);
	}

	public function successPayment(Request $request, string $order_code)
	{
		$model = Order::where(function ($q) use ($order_code) {
			$q->where('order_code', $order_code);
			$q->whereNull('paypal_response');
		})->first();

		if (!$model) {
			throw new NotFoundHttpException('Order not found');
		}

		$model->paypal_response = $request->get('paymentId', null);
		$model->save();

		$pageContentBlock = Content::getBlockContent(12);

		return view('order.finish', [
			'model' => $model,
			'meta_data' => [
				'title' => 'r-Wasd.com',
			],
			'pageContentBlock' => $pageContentBlock,
		]);
	}

	public function cancelPayment(Request $request, string $order_code)
	{
		$model = Order::where(function ($q) use ($order_code) {
			$q->where('order_code', $order_code);
			$q->whereNull('paypal_response');
		})->first();

		if (!$model) {
			throw new NotFoundHttpException('Order not found');
		}

		$pageContentBlock = Content::getBlockContent(13);

		return view('order.cancel_payment', [
			'model' => $model,
			'meta_data' => [
				'title' => 'r-Wasd.com',
			],
			'pageContentBlock' => $pageContentBlock,
		]);
	}

	private function getCookieOrder()
	{
		$orderData = unserialize(base64_decode(Cookie::get('order')));

		return is_array($orderData) ? $orderData : [];
	}

	private function setCookieOrder(Order $model = null)
	{
		if ($model === null) {
			Cookie::queue(Cookie::forget('order'));
			return;
		}

		// set postal parcel
		$postalParcel = PostalParcel::whereHas('countries', function ($q) use($model) {
			$q->where('countries.id', $model->shipping_country_id);
		})->first();

		$model->postal_parcel_id = !empty($postalParcel) ? $postalParcel->id : null;

		Cookie::queue(Cookie::make('order', base64_encode(serialize($model->toArray())), 3600));
	}
}
