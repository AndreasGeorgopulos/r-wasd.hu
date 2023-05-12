<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],

	    'adminer' => [
		    \App\Http\Middleware\EncryptCookies::class,
		    \Illuminate\Session\Middleware\StartSession::class,
		    // TODO: you may create customized middleware to fit your needs
		    // example uses Laravel default authentication (default protection)
		    \Illuminate\Auth\Middleware\Authenticate::class,
	    ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'acl' => \App\Http\Middleware\Acl::class,
		'locale' => \App\Http\Middleware\Locale::class,
    ];
	
	/*public function bootstrap() {
		parent::bootstrap();
		
		if (! function_exists('trans')) {
			
			function trans($id = null, $replace = [], $locale = null)
			{
				if (is_null($id)) {
					return app('translator');
				}
				
				echo 'a kurca';
				
				$translated = app('translator')->trans($id, $replace, $locale);
				
				if (strpos($translated, 'common.') === 0)
				{
					$translated = explode("common.",$translated)[1];
				}else if (strpos($translated, 'frontend.') === 0)
				{
					$translated = explode("frontend.",$translated)[1];
				}else if (strpos($translated, 'validation.') === 0)
				{
					$translated = explode("validation.",$translated)[1];
				}
				
				return $translated;
			}
		}
	}*/
}
