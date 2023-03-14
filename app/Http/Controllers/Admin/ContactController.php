<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function index(Request $request)
	{
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'desc');
			$searchtext = $request->get('searchtext', '');

			if ($searchtext != '') {
				$list = Contact::where('id', 'like', '%' . $searchtext . '%')
					->where('name', 'like', '%' . $searchtext . '%')
					->orWhere('email', 'like', '%' . $searchtext . '%')
					->orWhere('phone', 'like', '%' . $searchtext . '%')
					->orWhere('message', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Contact::orderby($sort, $direction)->paginate($length);
			}

			return view('admin.contacts.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.contacts.index');
	}

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function view(int $id)
	{
		if (!($model = Contact::find($id))) {
			abort(404);
		}

		return view('admin.contacts.view', [
			'model' => $model,
		]);
	}

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function delete(int $id)
	{
		if (!($model = Contact::find($id))) {
			abort(404);
		}

		$model->delete();
		return redirect(route('admin_contacts_list'))->with('form_success_message', [
			trans('Delete success'),
			trans('The contact delete successfully.')
		]);
	}
}
