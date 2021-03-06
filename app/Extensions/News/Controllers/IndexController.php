<?php

namespace App\Extensions\News\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\News\Models\News;
use App\Extensions\News\Models\Category;
use App\Models\Locale;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Display list of news
     * @return type
     */
    public function index()
    {
        // Get News
        $news = News::orderBy('id', 'desc')->paginate(15);
        
        return view('News.Views.administrator.index', ['news' => $news]);
    }
    
    /**
     * Add a new news
     * @return view
     */
    public function create()
    {
        // Get categories
        $categories = [];

        foreach(Category::all() as $category){
            $categories[$category->id] = $category->name;
        }
        
        return view('News.Views.administrator.add', [
            'locales' => Locale::all(),
            'categories' => $categories
        ]);
    }
    
    public function store(Request $request)
    {
        $locales = Locale::find($request->get('locales'));
        
        if(!$locales) {
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['locales' => trans('admin.select_one_language')]))->withInput();
        }

        $rules = [

        ];
        
        foreach($locales as $locale) {
            $rules['title-' . $locale->language] = ['required'];
            $rules['content-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $news = new News;
        $news->category_id = $request->get('category')?: NULL;
        
        foreach($locales as $locale){
            \App::setLocale($locale->language);
            $news->title = $request->get('title-' . $locale->language);
            $news->slug = $request->get('title-' . $locale->language);
            $news->content = $request->get('content-' . $locale->language);
        }
        \App::setLocale($this->administratorLocale);

        $news->save();
        
        return redirect('administrator/news')->with('success', __('news::admin.msg_added'));
    }
    
    /**
     * Edit selected news
     * @param int $news_id
     * @return view
     */
    public function edit($news_id)
    {
        $news = News::find($news_id);
        if(!$news){
            return redirect('administrator/news');
        }
        
        // Get categories
        $categories = [];

        foreach(Category::all() as $category){
            $categories[$category->id] = $category->name;
        }

        $multimediaExtensionEnabled = class_exists('\App\Extensions\Multimedia\Controllers\IndexController');

        // Get multimedia albums
        $albums = [];
        if($multimediaExtensionEnabled) {
            foreach (\App\Extensions\Multimedia\Models\Album::all() as $album) {
                $albums[$album->id] = $album->name;
            }
        }
        
        return view('News.Views.administrator.edit', [
            'news' => $news,
            'locales' => Locale::all(),
            'categories' => $categories,
            'albums' => $albums,
            'multimediaExtensionEnabled' => $multimediaExtensionEnabled
        ]);
    }
    
    public function update(Request $request, $news_id)
    {
        $news = News::find($news_id);
        if(!$news){
            return redirect('administrator/news');
        }
        
        $locales = Locale::find($request->get('locales'));
        
        if(!$locales){
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['locales' => trans('admin.select_one_language')]))->withInput();
        }
        
        $rules = [
            'date' => ['required', 'date_format:"d-m-Y, H:i:s"']
        ];
        
        foreach($locales as $locale){
            $rules['title-' . $locale->language] = ['required'];
            $rules['content-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $news->category_id = $request->get('category')?: NULL;

        $news->translations()->delete();
        
        foreach($locales as $locale) {
            \App::setLocale($locale->language);
            $news->title = $request->get('title-' . $locale->language);
            $news->slug = $request->get('title-' . $locale->language);
            $news->content = $request->get('content-' . $locale->language);
        }

        \App::setLocale($this->administratorLocale);

        $news->album_id = $request->get('album')? $request->get('album') : NULL;
        $news->created_at = date('Y-m-d H:i:s', strtotime($request->get('date')));
        $news->save();
        
        return redirect('administrator/news')->with('success', __('news::admin.msg_updated'));
    }
}
