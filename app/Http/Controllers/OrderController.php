<?php

namespace App\Http\Controllers;

use App;
use App\Mail\NotifyCancelPayOrderMail;
use App\Mail\NotifySuccessPayOrderMail;
use App\Models\Content;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PostalParcel;
use App\Rules\ReCaptchaRule;
use App\Traits\TCart;
use App\Traits\TDbTransaction;
use App\Traits\TModelValidate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PPConnectionException;
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function config;

class OrderController extends Controller
{
	use TCart, TDbTransaction, TModelValidate;

	private $_api_context;

	public function __construct()
	{
		//$paypal_configuration = config('paypal');
		$paypal_configuration = config('paypal.' . config('paypal.settings.mode'));
		$this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
		$this->_api_context->setConfig($paypal_configuration['settings']);
		//$this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
		//$this->_api_context->setConfig($paypal_configuration['settings']);
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
			$rules = Order::rules();
			//$rules['recaptcha_token'] = ['required', new ReCaptchaRule($request->get('recaptcha_token'))];
		    $validator = $this->modelValidate($request->all(), $rules, Order::niceNames(), Order::customMessages());
		    if ($validator->fails()) {
			    return redirect(route('order_checkout') . '#error')->withErrors($validator)->withInput()->with('form_warning_message', [
				    'title' => trans('Checkout failed'),
				    'lead' => trans('The form save fail. Errors:'),
			    ]);
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
			    'title' => 'я-WASD',
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
				'title' => 'я-WASD',
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
				$model->postal_fee = $cartData['postal_fee'];
				$model->order_code = $model->generateOrderCode();
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
						->setCurrency('USD')
						->setQuantity($cartItem['amount'])
						->setPrice($cartItem['price']);
				}

				$items[] = (new Item())->setName('Shipping cost')
					->setDescription('')
					->setCurrency('USD')
					->setQuantity(1)
					->setPrice($cartData['postal_fee']);

				$item_list = new ItemList();
				$item_list->setItems($items);

				$amount = new Amount();
				$amount->setCurrency('USD')->setTotal((float)$cartData['total']);

				$transaction = new Transaction();
				$transaction->setAmount($amount)
					->setItemList($item_list)
					->setDescription('Enter Your transaction description');

				$redirect_urls = new RedirectUrls();
				$redirect_urls->setReturnUrl(url(route('success_payment', ['order_code' => $model->order_code])))
					->setCancelUrl(url(route('cancel_payment', ['order_code' => $model->order_code])));

				$payment = new Payment();
				$payment->setIntent('sale')
					->setPayer($payer)
					->setRedirectUrls($redirect_urls)
					->setTransactions(array($transaction));

				try {
					$payment->create($this->_api_context);

					// cookie-k törlése
					$this->setCookieOrder(null);
					$this->eraseCartItems();

					foreach($payment->getLinks() as $link) {
						if($link->getRel() == 'approval_url') {
							$redirect_url = $link->getHref();
							break;
						}
					}

				} catch (PPConnectionException $ex) {
					throw new Exception($ex->getMessage() . ' on ' . $ex->getFile() . ' line ' . $ex->getLine());
				}

			}, function ($exception) use(&$redirect_url) {
				Session::put('error', $exception->getMessage() . ' on ' . $exception->getFile() . ' line ' . $exception->getLine());
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
				'title' => 'я-WASD',
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

		try {
			Mail::to($model->email)->send(new NotifySuccessPayOrderMail($model));
		} catch (Exception $exception) {
			throw new Exception($exception->getMessage() . ' on ' . $exception->getFile() . ' line ' . $exception->getLine());
		}

		$pageContentBlock = Content::getBlockContent(12);

		return view('order.finish', [
			'model' => $model,
			'meta_data' => [
				'title' => 'я-WASD',
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

		try {
			Mail::to($model->email)->send(new NotifyCancelPayOrderMail($model));
		} catch (Exception $exception) {
			throw new Exception($exception->getMessage() . ' on ' . $exception->getFile() . ' line ' . $exception->getLine());
		}

		$pageContentBlock = Content::getBlockContent(13);

		return view('order.cancel_payment', [
			'model' => $model,
			'meta_data' => [
				'title' => 'я-WASD',
			],
			'pageContentBlock' => $pageContentBlock,
		]);
	}

	public function getPostalFee($country_id)
	{
		$cartData = $this->getCartData();

		if (!($countryModel = Country::where('id', $country_id)->first())) {
			throw new Exception('Country model (ID: ' . $country_id . ') not found');
		}

		if (!($feeModel = PostalParcel::getFee($countryModel->id, $cartData['weight']))) {
			throw new Exception('Fee model (Country ID: ' . $countryModel->id  . ', Weight: ' . $cartData['weight'] . ') not found');
		}

		$fee = round($feeModel->fee / config('app.usd_rate'), 2);
		$total = $cartData['subtotal'] + $fee;

		return [
			'country' => $countryModel->name,
			'weight' => $cartData['weight'],
			'fee' => $fee,
			'fee_formated' => $this->priceFormat($fee, '$', '', 2),
			'total' => $total,
			'total_formated' => $this->priceFormat($total, '$', '', 2),
		];
	}

	public function getProFormInvoice(string $hash, $output = 'pdf')
	{
		if (!($order = Order::where(DB::raw('md5(order_code)'), $hash)->first())) {
			throw new NotFoundHttpException('Page not found');
		}

		$view = view('order.proform_invoice', [
			'order' => $order,
			'company' => config('app.company'),
		]);

		if ($output !== 'pdf') {
			return $view;
		}

		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHtml($view->render(), 'UTF-8');
		return $pdf->stream('r-wasd-order-' . $order->order_code . '.pdf');
	}

	private function getCookieOrder()
	{
		$orderData = unserialize(base64_decode(Cookie::get('order')));

		return is_array($orderData) ? $orderData : [];
	}

	private function setCookieOrder(Order $model = null)
	{
		$cartData = $this->getCartData();
		if ($model === null) {
			Cookie::queue(Cookie::forget('order'));
			return;
		}

		// set postal parcel
		$postalParcel = PostalParcel::findByCountry($model->shipping_country_id);
		$model->postal_parcel_id = null;
		if (!empty($postalParcel)) {
			$model->postal_parcel_id = $postalParcel->id;
			$feeModel = PostalParcel::getFee($model->shipping_country_id, $cartData['weight']);
			$model->postal_fee = floatval(round($feeModel->fee, 2));
		}

		Cookie::queue(Cookie::make('order', base64_encode(serialize($model->toArray())), 3600));
	}
}
