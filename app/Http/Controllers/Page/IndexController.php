<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function route(Request $request, $params = '')
    {
        $page = \Teknoza::instance()->findRoute($params);
        $page_url = $page->url();        
        
        // Get the locale id
        $locale_id = Locale::where('language', \App::getLocale())->first()->id;

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

        // Available locales
        \View::share('locales', Locale::all());
        
        return $page->logic($request)->with([
            'title' => $page->title(),
            'image' => $page->image(),
            'type' => $page->type()
        ]);
    }

    /*
     * Take care of AJAX request
     */
    public function jsonRoute($page_name, $option = false, $param3 = false, $param4 = false)
    {
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
        return redirect()->back()->withCookie(cookie()->forever('locale_id', $locale_id));
    }
}
