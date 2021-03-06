<?php

namespace LibrosJB\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \LibrosJB\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \LibrosJB\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \LibrosJB\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \LibrosJB\Http\Middleware\RedirectIfAuthenticated::class,
        'auth.admin' => \LibrosJB\Http\Middleware\AdminAuthMiddleware::class,
        'alreadyLoggedIn' => \LibrosJB\Http\Middleware\AlreadyLoggedIn::class,
        'clearUnreadMessages' => \LibrosJB\Http\Middleware\ClearUnreadMessages::class,
    ];
}
