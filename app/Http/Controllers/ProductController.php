<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
	public function getBySlug($slug)
	{
		$product = Product::whereHas('translates', function ($q) use($slug) {
			$q->where('product_translates.slug', '=', $slug);
			$q->where('products.active', '=', 1);
		})->first();

		if (empty($product) || !($model = $product->translates->where('language_code', app()->getLocale())->first())) {
			throw new NotFoundHttpException('Product not found');
		}

		$meta_data = [
			'title' => $model->meta_title,
			'description' => $model->meta_description,
			'keywords' => $model->meta_keywords,
		];

		return view('product', [
			//'product' => $product,
			'model' => $product,
			'meta_data' => $meta_data,
		]);
	}
}