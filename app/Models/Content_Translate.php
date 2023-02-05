<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content_Translate extends Model
{
	protected $table = 'content_translates';

	protected $fillable = ['url', 'meta_title', 'meta_description', 'meta_keywords', 'title', 'lead', 'body', 'active'];
}
