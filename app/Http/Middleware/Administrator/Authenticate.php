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
    public function handle($request, Closure $next, $role = 'administrator')
    {
        // If we are trying to auth administrator
        if($role === 'administrator'){
            if (!$request->user()){                
                return redirect()->guest('administrator/auth/login');
            }elseif($request->user()->role !== 'administrator'){
                return redirect()->guest('administrator/auth/login');
            }
        }elseif($role === 'user'){
            die('please finish this!');
        }
        

        return $next($request);
    }
}
