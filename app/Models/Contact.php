<?php

namespace App\Models;

use App\Traits\TModelSanitization;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model implements IModelRules
{
	use TModelSanitization;

    protected $table = 'contacts';

	protected $fillable = ['name', 'email', 'phone', 'subject', 'message'];

	/**
	 * @param $selected
	 * @return array[]
	 */
	public static function getSubjectDropdownOptions($selected = null): array
	{
		return [
			['value' => 1, 'title' => 'Option 01', 'selected' => (bool) ($selected == 1)],
			['value' => 2, 'title' => 'Option 02', 'selected' => (bool) ($selected == 2)],
			['value' => 3, 'title' => 'Option 03', 'selected' => (bool) ($selected == 3)],
			['value' => 4, 'title' => 'Option 04', 'selected' => (bool) ($selected == 4)],
			['value' => 5, 'title' => 'Option 05', 'selected' => (bool) ($selected == 5)],
		];
	}

	/**
	 * A model validálásakor használt mező szabályok
	 *
	 * @return array
	 */
	public static function rules(): array
	{
		return [
			'name' => 'required|max:255',
			'email' => 'required|email',
			'phone' => 'max:255',
			'subject' => 'numeric',
			'message' => 'required',
		];
	}

	/**
	 * A model validálásakor használt mező feliratok
	 *
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'name' => trans('Full name'),
			'email' => trans('E-mail'),
			'phone' => trans('Phone'),
			'subject' => trans('Subject'),
			'message' => trans('Your message'),
		];
	}

	/**
	 * A model validálásakor használt egyedi üzenetek
	 *
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [];
	}
}
