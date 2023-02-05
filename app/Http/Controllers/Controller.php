<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public static function checkAccessForUri ($uri)
	{
		return true;

		if (($user = User::find(Auth::user()->id)) === null) {
			return false;
		}

		if ($user->roles->where('key', 'superadmin')->count()) {
			return true;
		}

		$result = false;
		foreach ($user->roles as $role) {
			foreach ($role->acls as $acls) {
				if ($acls->path == $uri) {
					$result = true;
					break;
				}
			}
		}

		return $result;
	}
}
