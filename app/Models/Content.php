<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
	use SoftDeletes;

	const CATEGORY_PAGE = 1;

	protected $table = 'contents';

	protected $fillable = ['title'];

	public function translates () {
		return $this->hasMany('App\Models\Content_Translate');
	}
}
