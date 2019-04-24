<?php

namespace App\Http\Middleware;

use Closure;

class Locale
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
        $locale_id = $request->cookie('locale_id');
        $locale = \App\Models\Locale::find($locale_id);

        if($locale) {
            // Set application locale
            \App::setLocale($locale->language);
            // Set also the locale for date class
            \Date::setLocale(\App::getLocale());
        }

        return $next($request);
    }
}
