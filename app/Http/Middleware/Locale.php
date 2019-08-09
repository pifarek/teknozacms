<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Locale as LocaleModel;
use App\Models\LocaleAccept;

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
        $cookieLocaleId = $request->cookie('locale_id');
        $cookieLocale = LocaleModel::find($cookieLocaleId);

        // If we already set locale manually
        if($cookieLocale) {
            $this->setLocale($cookieLocale->language);
        }
        // We can try to detect browser locale
        else {
            $browserLanguages = preg_split('/,|;/', $request->server('HTTP_ACCEPT_LANGUAGE'));

            foreach($browserLanguages as $browserLanguage) {
                $accept = LocaleAccept::where('name', $browserLanguage)->first();
                if($accept) {
                    $this->setLocale($accept->locale->language);
                    break;
                }
            }
        }

        return $next($request);
    }

    /**
     * Set locale for application
     * @param $locale
     */
    private function setLocale($locale)
    {
        // Set application locale
        \App::setLocale($locale);
        // Set also the locale for date class
        \Date::setLocale($locale);
    }
}
