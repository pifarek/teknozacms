<?php

namespace App\Http\Middleware\Administrator;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
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
    public function handle($request, Closure $next, $guard = null)
    {
        if (!\Auth::guard($guard)->user()) {
            return redirect()->guest('administrator/auth/login');
        }

        return $next($request);
    }
}
