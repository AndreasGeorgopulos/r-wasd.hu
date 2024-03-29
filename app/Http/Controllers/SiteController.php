<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\Content;
use App\Models\Product;
use App\Rules\ReCaptchaRule;
use App\Traits\TModelValidate;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
		$indexTitleContentBlock = Content::getBlockContent(19);
		$indexLeadContentBlock = Content::getBlockContent(20);

		$products = Product::where('active', 1)->get();

		return view('index', [
			'products' => $products,
			'meta_data' => $meta_data,
			'pageContentBlock_1' => $pageContentBlock_1,
			'pageContentBlock_2' => $pageContentBlock_2,
			'indexTitleContentBlock' => $indexTitleContentBlock,
			'indexLeadContentBlock' => $indexLeadContentBlock,
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
				return redirect(route('contact'))->withErrors($validator)->withInput()->with('form_warning_message', [
					'title' => trans('Message failed'),
					'lead' => trans('The message send failed. Errors:'),
				]);
			}

			$model->save();

			try {
				Mail::to(config('app.company.email'))->send(new ContactMail($model));
			} catch (Exception $exception) {
				return redirect(route('contact'))->withInput()->with('form_warning_message', [
					'title' => trans('Fatal error'),
					'lead' => trans('The message sent fail. Please try later!'),
				]);
			}

			return redirect(route('contact'))->with('send_success', true);
		}

		$meta_data = [
			'title' => trans('Contact'),
			'description' => '',
			'keywords' => '',
		];

		return view('contact', [
			'meta_data' => $meta_data,
		]);
	}

	public function sitemap()
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . chr(13);
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . chr(13);

		// Main and contact pages
		$xml .= '<url><loc>' . url(route('main-page')) . '</loc></url>' . chr(13);
		$xml .= '<url><loc>' . url(route('contact')) . '</loc></url>' . chr(13);

		// Pages
		$contents = Content::where(function ($q) {
			$q->where('active', true);
			$q->where('type', Content::TYPE_SITE);
		})->get();
		foreach ($contents as $model) {
			$xml .= '<url><loc>' . url(route('page', ['slug' => $model->getSlug()])) . '</loc></url>' . chr(13);
		}

		// Products
		$products = Product::where(function ($q) {
			$q->where('active', true);
		})->get();
		foreach ($products as $model) {
			$xml .= '<url><loc>' . url(route('product', ['slug' => $model->getSlug()])) . '</loc></url>' . chr(13);
		}

		$xml .= '</urlset>';

		header('Content-type: application/xml');
		echo $xml;
		exit;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function imageUpload(Request $request): JsonResponse
	{
		if(!($uploadedFile = $request->file('file'))) {
			abort(404);
		}

		$fileName = $uploadedFile->getClientOriginalName();
		$uploadedFile->move(public_path('uploads/'), $fileName);

		return response()->json(['location'=>asset('/uploads/' . $fileName)]);
	}
}