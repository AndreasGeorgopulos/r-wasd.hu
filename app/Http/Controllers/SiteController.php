<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController extends Controller
{
	public function index()
	{
		$meta_data = [
			'title' => '',
			'description' => '',
			'keywords' => '',
		];

		$contents = Product::where('active', 1)->get();

		return view('index', [
			'products' => $contents,
			'meta_data' => $meta_data,
		]);
	}

	public function page($slug)
	{
		$content = Content::whereHas('translates', function ($q) use($slug) {
				$q->where('content_translates.slug', '=', $slug);
				$q->where('contents.category', '=', Content::CATEGORY_PAGE);
			})->first();

		if (empty($content) || !($model = $content->translates->where('language_code', app()->getLocale())->first())) {
			throw new NotFoundHttpException('Page not found');
		}

		$meta_data = [
			'title' => $model->meta_title,
			'description' => $model->meta_description,
			'keywords' => $model->meta_keywords,
		];

		return view('product', [
			'model' => $model,
			'meta_data' => $meta_data,
		]);
	}
}