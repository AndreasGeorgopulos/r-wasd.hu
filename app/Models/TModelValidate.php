<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;

/**
 * Model validálás trait
 */
trait TModelValidate
{
	/**
	 * @param array $attributes
	 * @param array $rules
	 * @param array $niceNames
	 * @param array $customMessages
	 */
	public function modelValidate(array $attributes, array $rules, array $niceNames, array $customMessages)
	{
		$validator = Validator::make($attributes, $rules, $customMessages);
		$validator->setAttributeNames($niceNames);
		//dd($validator);
		return $validator;
	}
}