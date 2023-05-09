<?php

namespace App\Http\Controllers\Admin;

use App\Mail\NotifyShippedOrderMail;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
	public function indexNew(Request $request)
	{
		return $this->request($request, Order::STATUS_NEW);
	}

	public function indexSent(Request $request)
	{
		return $this->request($request, Order::STATUS_SENT);
	}

	public function indexDone(Request $request)
	{
		return $this->request($request, Order::STATUS_DONE);
	}

	public function edit(Request $request, int $id = 0)
	{
		$model = Order::findOrNew($id);

		if ($request->isMethod('post')) {
			// data save
			$model->fill($request->all());
			if ($model->status == Order::STATUS_NEW) {
				$model->status = Order::STATUS_SENT;
				Mail::to($model->email)->send(new NotifyShippedOrderMail($model));

			} elseif ($model->status == Order::STATUS_SENT) {
				$model->status = Order::STATUS_DONE;
			}
			$model->save();

			return redirect(route($model->getBackRouteName(), ['id' => $model->id]))->with('form_success_message', [
				trans('Save success'),
				trans('The order save successfully.'),
			]);
		}

		return view('admin.orders.edit', [
			'model' => $model,
		]);
	}

	private function request(Request $request, $status)
	{
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'desc');
			$searchtext = $request->get('searchtext', '');

			$list = Order::where(function ($q) use ($searchtext, $status) {
				$q->where('status', $status);
				if (!empty($searchtext)) {
					$q->where(function ($q) use($searchtext) {
						$q->where('id', 'like', '%' . $searchtext . '%')
							->orWhere('name', 'like', '%' . $searchtext . '%')
							->orWhere('email', 'like', '%' . $searchtext . '%')
							->orWhere('phone', 'like', '%' . $searchtext . '%')
							->orWhere('order_code', 'like', '%' . $searchtext . '%')
							->orWhere('postal_tracking_code', 'like', '%' . $searchtext . '%')
							->orWhere('paypal_response', 'like', '%' . $searchtext . '%');
					});
				}
			})->orderby($sort, $direction)->paginate($length);

			return view('admin.orders.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.orders.index');
	}

	private function sendOrderEmail(Order &$model)
	{
		try {
			Mail::to($model->email)->send(new NotifyShippedOrderMail($model));

		} catch (Exception $exception) {
			echo $exception->getMessage();
			$this->fail();

		}
	}
}
