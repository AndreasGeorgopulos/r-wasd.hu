<?php

namespace App\Models;

use App\Traits\TModelIndexImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Product extends Model implements IModelIndexImage
{
	use SoftDeletes, TModelIndexImage;

	private $currentTranslate;

	protected $table = 'products';

	protected $fillable = ['title', 'price'];

	function __construct(array $attributes = [])
	{
		$this->loadIndexImageConfig(config('app.products.index_images'));
		parent::__construct($attributes);
	}

	public function translates () {
		return $this->hasMany('App\Models\Product_Translate');
	}

	public function getTitle()
	{
		return $this->getCurrentTranslate()->meta_title;
	}

	public function getSlug()
	{
		return $this->getCurrentTranslate()->slug;
	}

	public function getLead()
	{
		return $this->getCurrentTranslate()->lead;
	}

	public function getBody()
	{
		return $this->getCurrentTranslate()->body;
	}

	private function getCurrentTranslate()
	{
		if (empty($this->currentTranslate)) {
			$this->currentTranslate = $this->translates()->where('language_code', app()->getLocale())->first();
			if (empty($this->currentTranslate)) {
				throw new NotFoundHttpException('Product not found.');
			}
		}

		return $this->currentTranslate;
	}
}
