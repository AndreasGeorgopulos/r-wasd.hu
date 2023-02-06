<?php

namespace App\Models;

/**
 * Interface
 * <p>
 * Model-ek validálásához szükséges mező szabályok és feliratok
 */
interface IModelRules
{
	/**
	 * A model validálásakor használt mező szabályok
	 *
	 * @return array
	 */
	public static function rules(): array;

	/**
	 * A model validálásakor használt mező feliratok
	 *
	 * @return array
	 */
	public static function niceNames(): array;

	/**
	 * A model validálásakor használt egyedi üzenetek
	 *
	 * @return array
	 */
	public static function customMessages(): array;
}