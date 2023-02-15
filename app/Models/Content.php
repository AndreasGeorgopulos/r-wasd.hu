<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Content extends Model
{
	const TYPE_SITE = 1;
	const TYPE_BLOCK = 2;
	const TYPE_EMAIL = 3;

	use SoftDeletes;

	const CATEGORY_PAGE = 1;

	protected $table = 'contents';

	protected $fillable = ['title', 'description', 'type', 'category', 'active'];

	/**
	 * @return HasMany
	 */
	public function translates (): HasMany
	{
		return $this->hasMany(Content_Translate::class);
	}

	/**
	 * @param $selected
	 * @return array[]
	 */
	public static function getTypeDropdownItems($selected): array
	{
		return [
			['value' => self::TYPE_SITE, 'title' => trans('Site'), 'selected' => (bool) ($selected == self::TYPE_SITE)],
			['value' => self::TYPE_BLOCK, 'title' => trans('Block'), 'selected' => (bool) ($selected == self::TYPE_BLOCK)],
			['value' => self::TYPE_EMAIL, 'title' => trans('E-mail'), 'selected' => (bool) ($selected == self::TYPE_EMAIL)],
		];
	}

	/**
	 * @return bool|void|null
	 * @throws \Exception
	 */
	public function delete()
	{
		if ($this->deletable) {
			return parent::delete();
		}
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->getCurrentTranslate()->meta_title;
	}

	/**
	 * @return mixed
	 */
	public function getSlug()
	{
		return $this->getCurrentTranslate()->slug;
	}

	/**
	 * @return mixed
	 */
	public function getLead()
	{
		return $this->getCurrentTranslate()->lead;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->getCurrentTranslate()->body;
	}

	/**
	 * @return Model|HasMany|object|null
	 */
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

	/**
	 * @param $id
	 * @return null
	 */
	public static function getBlockContent($id)
	{
		$model = static::where(function ($q) use($id) {
			$q->where('id', $id);
			$q->where('active', 1);
			$q->where('type', static::TYPE_BLOCK);
		})->first();

		return !empty($model) ? $model->getBody() : null;
	}
}
