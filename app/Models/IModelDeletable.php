<?php

namespace App\Models;

/**
 * Interface
 * <p>
 * Model-ek törölhetőségének ellenőrzése
 */
interface IModelDeletable
{
	/**
	 * Model törölhetőségének ellenőrzése
	 *
	 * @return bool
	 */
	public function isDeletable(): bool;
}