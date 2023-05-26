<?php

namespace App\Models;

use App\Traits\TModelImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
	use SoftDeletes, TModelImage;

    protected $table = 'product_images';

	function __construct(array $attributes = [])
	{
		$this->loadImageConfig(config('app.products.images'));
		parent::__construct($attributes);
	}

	public function save(array $options = [])
	{
		if (!$this->id) {
			$this->sort = ProductImage::getNextSort($this->product_id);
		}

		return parent::save($options);
	}

	/**
	 * @param int $product_id
	 * @return int
	 */
	public static function getNextSort(int $product_id): int
	{
		return static::where('product_id', $product_id)->max('sort') + 1;
	}
}
