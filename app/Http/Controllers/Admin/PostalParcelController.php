<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostalParcel;
use App\Models\PostalParcelFee;
use App\Traits\TModelValidate;
use Illuminate\Http\Request;

class PostalParcelController extends Controller implements ICrudController
{
	use TModelValidate;

    //
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
				$list = PostalParcel::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('title', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = PostalParcel::orderby($sort, $direction)->paginate($length);
			}

			return view('admin.postal_parcels.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.postal_parcels.index');
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
		$model = PostalParcel::findOrNew($id);

		if ($request->isMethod('post')) {
			// validate
			$validator = $this->modelValidate($request->all(), PostalParcel::rules(), PostalParcel::niceNames(), PostalParcel::customMessages());
			if ($validator->fails()) {
				return redirect(route('admin_postal_parcels_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Save failed'),
					trans('The postal parcel save failed. Errors:')
				]);
			}

			// data save
			$model->fill($request->all());
			$model->save();

			$model->countries()->sync($request->get('countries'));

			$fees = $request->get('postal_parcels_fees', []);
			foreach ($fees as $item) {
				if (empty($item['id']) || !($feeModal = PostalParcelFee::where('id', $item['id'])->first())) {
					$feeModal = new PostalParcelFee();
					$feeModal->postal_parcel_id = $model->id;
				}

				if (!empty($item['_delete']) && $feeModal->id) {
					$feeModal->delete();
					continue;
				}

				$feeModal->fill($item)->save();
			}

			return redirect(route('admin_postal_parcels_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Save success'),
				trans('The postal parcel save successfully.'),
			]);
		}

		return view('admin.postal_parcels.edit', [
			'model' => $model,
			'countryIds' => $model->countries()->pluck('id')->toArray(),
		]);
	}

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function delete(int $id)
	{
		if (($model = PostalParcel::find($id)) && $model->isDeletable()) {
			$model->countries()->sync([]);
			$model->delete();
			return redirect(route('admin_postal_parcels_list'))->with('form_success_message', [
				trans('Delete success'),
				trans('The postal parcel delete successfully.')
			]);
		}
	}
}
