<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Translate extends Model
{
	protected $table = 'product_translates';

	protected $fillable = ['url', 'meta_title', 'meta_description', 'meta_keywords', 'title', 'lead', 'body', 'active'];
}