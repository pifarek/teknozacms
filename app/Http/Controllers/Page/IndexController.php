<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Locale;

class IndexController extends Controller
{
    public function __construct()
    {
        // Set the page language        
        if($locale_language = \Cookie::get('locale'))
        {
            $locale = Locale::where('language', '=', $locale_language)->get()->first();
            if($locale)
            {
                \App::setLocale($locale->language);
                // Set also the locale for date class
                \Date::setLocale(\App::getLocale());
            }
        }
    }
    
    public function route($params = '')
    {
        $page = \Teknoza::instance()->findRoute($params);
        $page_url = $page->url();        
        
        // Get the locale id
        $locale_id = Locale::where('language', '=', \App::getLocale())->get()->first()->id;

        // Set the page title
        $meta_title = \Settings::get('title', $locale_id);
        
        \View::share('page_title', $meta_title);

        if($page->type() !== 'index'){
            $meta_title = htmlentities($page->title()) . ' | ' . $meta_title;
        }

        \View::share('meta_title', $meta_title);
        
        // Set the page type
        \View::share('page_type', $page->type());
        
        // Set the current page url
        \View::share('page_url', $page_url);
        
        \View::share('locale_id', $locale_id);
        
        return $page->logic()->with([
            'title' => $page->title(),
            'image' => $page->image(),
            'type' => $page->type()
        ]);
    }
    
    
    
    /**
    public function route($page_url = false, $param2 = false, $param3 = false, $param4 = false){
        $page = \App\Helpers\Page::find($page_url);
        $page->params([$param2, $param3, $param4]);
        
        // Get the locale id
        $locale_id = Locale::where('language', '=', \App::getLocale())->get()->first()->id;

        // Set the page title
        $meta_title = \Settings::get('title', $locale_id);
        
        \View::share('page_title', $meta_title);

        if($page->type() !== 'index'){
            $meta_title = htmlentities($page->title()) . ' | ' . $meta_title;
        }

        \View::share('meta_title', $meta_title);
        
        // Set the page type
        \View::share('page_type', $page->type());
        
        // Set the current page url
        \View::share('page_url', $page_url);
        
        \View::share('locale_id', $locale_id);
        
        // Return the view
        return $page->logic()->with([
            'title' => $page->title(),
            'image' => $page->image(),
            'type' => $page->type()
        ]);
    }
     **/
    
    /*
     * Take care of AJAX request
     */
    public function jsonRoute($page_name, $option = false, $param3 = false, $param4 = false){
        $page = \App\Helpers\Page::find($page_name);
        $page->params([$option, $param3, $param4]);
        return $page->getJson($option);
    }
    
    /**
     * Change the page locale
     * @param int $locale_id
     * @return type
     */
    public function locale($locale_id)
    {
        $locale = Locale::find($locale_id);
        if(!$locale){
            return redirect('/');
        }
        return redirect()->back()->withCookie(cookie()->forever('locale', $locale->language));
    }
}