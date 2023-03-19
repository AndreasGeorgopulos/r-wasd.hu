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
}
