<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndexVideo;
use Illuminate\Http\Request;

class VideoController extends Controller
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
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');

			if ($searchtext != '') {
				$list = IndexVideo::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orderby('sort', 'asc')
					->paginate($length);
			}
			else {
				$list = IndexVideo::orderby('sort', 'asc')->paginate($length);
			}

			return view('admin.videos.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.videos.index');
	}

	public function upload(Request $request)
	{
		if (!($uploadedFiles = $request->file('video_files'))) {
			abort(404);
		}

		$path = public_path('images/');

		foreach ($uploadedFiles as $file) {
			(new IndexVideo())->fill([
				'sort' => (IndexVideo::all()->max('sort') + 1),
				'filename' => $file->getClientOriginalName(),
				'is_active' => false,
			])->save();

			$file->move($path, $file->getClientOriginalName());
		}

		return redirect(route('admin_videos_list'))->with('form_success_message', [
			trans('Sikeres feltöltés'),
			trans('A videók sikeresen fel lettek töltve.'),
		]);
	}

	public function delete($id)
	{
		if (!($model = IndexVideo::find($id))) {
			abort(404);
		}

		$path = public_path('images/') . $model->filename;

		if (file_exists($path)) {
			unlink($path);
		}

		$model->delete();

		return redirect(route('admin_videos_list'))->with('form_success_message', [
			trans('Sikeres törlés'),
			trans('A videó sikeresen törölve lett.'),
		]);
	}

	public function setStatus($id)
	{
		if (!($model = IndexVideo::find($id))) {
			abort(404);
		}

		$model->is_active = $model->is_active ? 0 : 1;
		$model->save();

		return redirect(route('admin_videos_list'));
	}

	public function reOrder(Request $request)
	{
		if (!($ids = $request->get('ids'))) {
			abort(404);
		}

		$i = 1;
		foreach ($ids as $id) {
			(IndexVideo::find($id))->update([
				'sort' => $i++,
			]);
		}

		return redirect(route('admin_videos_list'))->with('form_success_message', [
			trans('Sikeres sorrendezés'),
			trans('A videók sorrendje sikeresen mentve lett.'),
		]);
	}
}
