<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Product extends Model
{
	use SoftDeletes;

	private $currentTranslate;

	protected $table = 'products';

	protected $fillable = ['title', 'price'];

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
