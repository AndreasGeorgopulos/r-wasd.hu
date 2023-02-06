<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;

/**
 *
 */
trait TModelValidate
{
	/**
	 * @param array $attributes
	 * @param array $rules
	 * @param array $niceNames
	 * @return Validator
	 */
	public function modelValidate(array $attributes, array $rules, array $niceNames)
	{
		$validator = Validator::make($attributes, $rules);
		$validator->setAttributeNames($niceNames);
		return $validator;
	}
}