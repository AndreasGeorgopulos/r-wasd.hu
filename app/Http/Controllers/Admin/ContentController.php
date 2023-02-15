<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ICrudController;
use App\Models\Content;
use App\Models\Content_Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContentController extends Controller implements ICrudController
{
	public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');

			if ($searchtext != '') {
				$list = Content::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('title', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Content::orderby($sort, $direction)->paginate($length);
			}

			return view('admin.contents.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.contents.index');
	}

	public function edit (Request $request, int $id = 0) {
		$model = Content::findOrNew($id);

		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = ['title' => 'Cím'];
			$rules = ['title' => 'required'];

			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('admin_contents_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Sikertelen mentés'),
					trans('A tartalom adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}

			// data save
			$model->fill($request->all());
			$model->category = Content::CATEGORY_PAGE;
			$model->save();

			// Translates save
			foreach ($request->get('translate') as $lang => $t) {
				if (!$translate = $model->translates()->where('language_code', $lang)->first()) {
					$translate = new Content_Translate();
					$translate->content_id = $model->id;
					$translate->language_code = $lang;
				}

				$translate->fill($t);
				$translate->slug = Str::slug($translate->meta_title);
				$translate->save();
			}

			return redirect(route('admin_contents_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A tartalom adatai sikeresen rögzítve lettek.'),
			]);
		}

		return view('admin.contents.edit', [
			'model' => $model,
		]);
	}

	public function delete (int $id) {
		if ($model = Content::find($id)) {
			$model->translates()->delete();
			$model->delete();
			return redirect(route('admin_contents_list'))->with('form_success_message', [
				trans('Sikeres törlés'),
				trans('A tartalom sikeresen el lett távolítva.')
			]);
		}
	}

	public function view(int $id)
	{
		// TODO: Implement view() method.
	}
}
