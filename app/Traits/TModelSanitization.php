<?php

namespace App\Traits;

/**
 *
 */
trait TModelSanitization
{
	/**
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = []): bool
	{
		foreach ($this->fillable as $f) {
			$this->$f = strip_tags($this->$f);
		}

		return parent::save($options);
	}
}