<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_Translate;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller implements ICrudController
{
	public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');

			if ($searchtext != '') {
				$list = Product::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('title', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Product::orderby($sort, $direction)->paginate($length);
			}

			return view('admin.products.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('admin.products.index');
	}

	public function edit (Request $request, int $id = 0) {
		$model = Product::findOrNew($id);

		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = ['title' => 'Cím'];
			$rules = ['title' => 'required'];

			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('admin_products_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Sikertelen mentés'),
					trans('A tartalom adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}

			// data save
			$model->fill($request->all());
			$model->active = 1;
			$model->save();

			// Translates save
			foreach ($request->get('translate') as $lang => $t) {
				if (!$translate = $model->translates()->where('language_code', $lang)->first()) {
					$translate = new Product_Translate();
					$translate->product_id = $model->id;
					$translate->language_code = $lang;
				}

				$translate->fill($t);
				$translate->slug = Str::slug($translate->meta_title);
				$translate->save();
			}

			// Index images
			if ($request->get('delete_index_image')) {
				$model->deleteIndexImageFile();
			}
			$model->saveIndexImageFile($request->file('index_image'));

			// Gallery Images
			$deleteImageIds = $request->get('delete_image', []);
			//dd($deleteImageIds);
			foreach ($deleteImageIds as $id) {
				if (!($productImage = ProductImage::where('id', $id)->first())) {
					continue;
				}
				$productImage->deleteImageFile();
			}

			// Reorder product images
			$sort = 1;
			foreach ($request->get('product_image_ids', []) as $productImageId) {
				if (!($productImageModel = ProductImage::find($productImageId))) {
					continue;
				}

				$productImageModel->sort = $sort++;
				$productImageModel->save();
			}

			// Uploaded product images
			$uploadedFiles = $request->file('images', []);
			foreach ($uploadedFiles as $file) {
				$productImage = new ProductImage();
				$productImage->product_id = $model->id;
				$productImage->save();
				$productImage->saveImageFile($file);
			}

			return redirect(route('admin_products_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A tartalom adatai sikeresen rögzítve lettek.'),
			]);
		}

		return view('admin.products.edit', [
			'model' => $model,
		]);
	}

	public function delete (int $id) {
		if ($model = Product::find($id)) {
			$model->translates()->delete();
			$model->deleteIndexImageFile();
			foreach ($model->images as $productImage) {
				$productImage->deleteImageFile();
			}
			$model->delete();
			return redirect(route('admin_products_list'))->with('form_success_message', [
				trans('Sikeres törlés'),
				trans('A tartalom sikeresen el lett távolítva.')
			]);
		}
	}

	public function view(int $id)
	{
		// TODO: Implement view() method.
	}

	public function resizeIndexImages($id = null)
	{
		$models = Product::where(function ($q) use($id) {
			$q->where('active', true);
			if ($id !== null) {
				$q->where('id', $id);
			}
		})->get();

		foreach ($models as $model) {
			$model->resizeIndexImage();
			foreach ($model->images as $productImage) {
				$productImage->resizeImage();
			}
		}

		return redirect(route('admin_products_list'))->with('form_success_message', [
			trans('Sikeres kép átméretezés'),
			trans('A termék képek sikeresen át lettek méretezve.')
		]);
	}
}
