<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Content;
use App\Models\Product;
use App\Rules\ReCaptchaRule;
use App\Traits\TModelValidate;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController extends Controller
{
	use TModelValidate;

	public function index()
	{
		$meta_data = [
			'title' => '',
			'description' => '',
			'keywords' => '',
		];

		$pageContentBlock_1 = Content::getBlockContent(1);
		$pageContentBlock_2 = Content::getBlockContent(2);

		$products = Product::where('active', 1)->get();

		return view('index', [
			'products' => $products,
			'meta_data' => $meta_data,
			'pageContentBlock_1' => $pageContentBlock_1,
			'pageContentBlock_2' => $pageContentBlock_2,
		]);
	}

	public function page($slug)
	{
		$content = Content::whereHas('translates', function ($q) use($slug) {
				$q->where('content_translates.slug', '=', $slug);
				$q->where('contents.category', '=', Content::CATEGORY_PAGE);
			})
			->where('active', 1)
			->first();

		if (empty($content) || !($model = $content->translates->where('language_code', app()->getLocale())->first())) {
			throw new NotFoundHttpException('Page not found');
		}

		$meta_data = [
			'title' => $model->meta_title,
			'description' => $model->meta_description,
			'keywords' => $model->meta_keywords,
		];

		return view('page', [
			'model' => $model,
			'meta_data' => $meta_data,
		]);
	}

	public function contact(Request $request)
	{
		if ($request->isMethod('post')) {
			$model = new Contact();
			$model->fill($request->all());
			$rules = Contact::rules();
			$rules['recaptcha_token'] = ['required', new ReCaptchaRule($request->get('recaptcha_token'))];

			$validator = $this->modelValidate($request->all(), $rules, Contact::niceNames(), Contact::customMessages());
			if ($validator->fails()) {
				return redirect(route('contact') . '#error')->withErrors($validator)->withInput()->with('form_warning_message', [
					'title' => trans('Message failed'),
					'lead' => trans('The message send failed. Errors:'),
				]);
			}

			$model->save();

			return redirect(route('contact'))->with('send_success', true);
		}

		$meta_data = [
			'title' => '',
			'description' => '',
			'keywords' => '',
		];

		return view('contact', [
			'meta_data' => $meta_data,
		]);
	}
}