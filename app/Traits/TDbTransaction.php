<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\DB;

/**
 *
 */
trait TDbTransaction
{
	/**
	 * @param callable $funcTransaction
	 * @param callable|null $funcException
	 * @param callable|null $funcFinally
	 * @return void
	 */
	public function runDbTransaction(callable $funcTransaction, callable $funcException = null, callable $funcFinally = null)
	{
		try {
			DB::beginTransaction();
			DB::transaction($funcTransaction);
			DB::commit();
		} catch (Exception $exception) {
			DB::rollBack();
			if ($funcException !== null) {
				$funcException($exception);
			}
		} finally {
			if ($funcFinally !== null) {
				$funcFinally();
			}
		}
	}
}