<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostalParcel extends Model
{
	use SoftDeletes;

	protected $table = 'postal_parcel';

	protected $fillable = ['name', 'unit_price', 'is_active'];

	protected $casts = [
		'is_active' => 'bool',
	];

	public function countries()
	{
		return $this->belongsToMany(Country::class);
	}
}
