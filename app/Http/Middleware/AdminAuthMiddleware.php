<?php

namespace LibrosJB\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

class AdminAuthMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {

            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } 

            return redirect()->guest('adminlogin')
                    ->with('message', 'debes iniciar sesión para ver el contenido');  
        }

        if (! $this->auth->user()->isAdmin()) {
            
            if ($request->ajax()) {
                return response('Forbidden.', 403);
            } 

            abort(403);
        }

        return $next($request);

    }
}
