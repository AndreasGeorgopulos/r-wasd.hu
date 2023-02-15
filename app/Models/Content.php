<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
			['value' => self::TYPE_SITE, 'title' => trans('Site'), 'selected' => (bool) $selected === self::TYPE_SITE],
			['value' => self::TYPE_BLOCK, 'title' => trans('Block'), 'selected' => (bool) $selected === self::TYPE_BLOCK],
			['value' => self::TYPE_EMAIL, 'title' => trans('E-mail'), 'selected' => (bool) $selected === self::TYPE_EMAIL],
		];
	}
}
