<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
	public function login (Request $request)
	{
		if ($request->isMethod('post')) {
			
			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
				'password' => 'required',
			]);
			
			if ($validator->fails()) {
				return redirect(route('login'))
					->withErrors($validator)
					->withInput();
			}
			
			$email = $request->input('email');
			$password = $request->input('password');
			
			if (Auth::attempt(['email' => $email, 'password' => $password])) {

				return redirect()->intended(route('admin_dashboard'));
				
				if (Auth::user()->roles()->where('role_id',2)->first() == null)
				{
					$validator->errors()->add('email', trans('common.Nincs jogosultsága a belépéshez!'));
					
					return redirect(route('login'))
						->withErrors($validator)
						->withInput();
				}
				
				if (Auth::user()->roles()->where('role_id', 1)->first() != null) {
					return redirect()->intended(route('admin_dashboard'));
				} else {
					$menu = config('menu');
					
					$redirect = null;
					foreach ($menu as $item):
						if (!is_array($item['route']) && self::checkAccessForUri($item['route'])) {
							$redirect = $item['route'];
							break;
						} else if (is_array($item['route']))
						{
							foreach ($item['route'] as $rt)
							{
								if (self::checkAccessForUri($rt['route']) && strpos($rt['route'],'list'))
								{
									$redirect = $rt['route'];
									break;
								}
							}
						}
					endforeach;
					
					if ($redirect != null) {
						return redirect()->intended(route($redirect));
					} else {
						return response()->view('errors.401', [], 401);
					}
				}
				
			} else {
				$validator->errors()->add('email', trans('common.E-mail cím/Jelszó nem egyezik!'));

				return redirect(route('login'))
					->withErrors($validator)
					->withInput();
			}
		}
		
		return view('admin.login');
	}
	
	public function logout(Request $request)
	{
		Auth::logout();
		
		$request->session()->flush();
		
		$request->session()->regenerate();
		
		return redirect(route('login'));
	}
	
	public function dashboard (Request $request) {
		return view('admin.dashboard');
	}
	
	public function changeLanguage (Request $request, $locale) {
		$request->session()->put('locale', $locale);
		return redirect(url()->previous());
	}
}
