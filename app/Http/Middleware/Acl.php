<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Route;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = Route::getFacadeRoot()->current()->getName();

        if (!Controller::checkAccessForUri($routeName))
        {
            $menu = config('adminlte.menu');

            $redirect = null;
            foreach ($menu as $item):
                if (!is_array($item['route']) && Controller::checkAccessForUri($item['route'])) {
                    $redirect = $item['route'];
                    break;
                } else if (is_array($item['route']))
                {
                    foreach ($item['route'] as $rt)
                    {
                        if (Controller::checkAccessForUri($rt['route']) && strpos($rt['route'],'list'))
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
            return response()->view('errors.401', [], 401);
        }

        return $next($request);
    }
}
