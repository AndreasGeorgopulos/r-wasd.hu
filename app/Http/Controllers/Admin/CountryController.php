<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\TModelValidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller implements ICrudController
{
	use TModelValidate;

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function index(Request $request)
	{
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');

			if ($searchtext != '') {
				$list = Country::where('id', 'like', '%' . $searchtext . '%')
					->where('code', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Country::orderby($sort, $direction)->paginate($length);
			}

			return view('admin.countries.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.countries.index');
	}

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function view(int $id)
	{
		// TODO: Implement view() method.
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return mixed
	 */
	public function edit(Request $request, int $id = 0)
	{
		$model = Country::findOrNew($id);

		if ($request->isMethod('post')) {
			// validate
			$validator = $this->modelValidate($request->all(), Country::rules(), Country::niceNames(), Country::customMessages());
			if ($validator->fails()) {
				return redirect(route('admin_countries_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Save failed'),
					trans('The country save failed. Errors:')
				]);
			}

			// data save
			$model->fill($request->all());
			$model->save();

			return redirect(route('admin_countries_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Save success'),
				trans('The country save successfully.'),
			]);
		}

		return view('admin.countries.edit', [
			'model' => $model,
		]);
	}

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function delete(int $id)
	{
		if (($model = Country::find($id)) && $model->isDeletable()) {
			$model->delete();
			return redirect(route('admin_countries_list'))->with('form_success_message', [
				trans('Delete success'),
				trans('The country delete successfully.')
			]);
		}
	}
}
