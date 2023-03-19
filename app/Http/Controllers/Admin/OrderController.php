<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
	public function index(Request $request)
	{
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'desc');
			$searchtext = $request->get('searchtext', '');

			if ($searchtext != '') {
				$list = Order::where('id', 'like', '%' . $searchtext . '%')
					/*->where('name', 'like', '%' . $searchtext . '%')
					->orWhere('email', 'like', '%' . $searchtext . '%')
					->orWhere('phone', 'like', '%' . $searchtext . '%')
					->orWhere('message', 'like', '%' . $searchtext . '%')*/
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Order::orderby($sort, $direction)->paginate($length);
			}

			return view('admin.orders.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.orders.index');
	}
}
