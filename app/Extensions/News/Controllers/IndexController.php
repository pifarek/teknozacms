<?php

namespace App\Extensions\News\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\News\Models\News;
use App\Extensions\News\Models\Category;
use App\Models\Locale;

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
    
    public function store()
    {
        $locales = Locale::find(\Input::get('locales'));
        
        if(!$locales) {
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['locales' => trans('admin.select_one_language')]))->withInput();
        }

        $rules = [

        ];
        
        foreach($locales as $locale) {
            $rules['title-' . $locale->language] = ['required'];
            $rules['content-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $news = new News;
        $news->category_id = \Input::get('category')?: NULL;
        
        foreach($locales as $locale){
            \App::setLocale($locale->language);
            $news->title = \Input::get('title-' . $locale->language);
            $news->slug = \Input::get('title-' . $locale->language);
            $news->content = \Input::get('content-' . $locale->language);
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
        
        // Check if we will show categories for current user
        $show_categories = true;
        if(\Auth::guard('administrator')->user()->group_id && \Auth::guard('administrator')->user()->group->news_category_id){
            $show_categories = false;
        }
        
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
            'show_categories' => $show_categories,
            'multimediaExtensionEnabled' => $multimediaExtensionEnabled
        ]);
    }
    
    public function update($news_id)
    {
        $news = News::find($news_id);
        if(!$news){
            return redirect('administrator/news');
        }
        
        $locales = Locale::find(\Input::get('locales'));
        
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
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        if(\Auth::user()->group_id && \Auth::user()->group->news_category_id){
            $news->category_id = \Auth::user()->group->news_category_id;
        }else{
            $news->category_id = \Input::get('category')?: NULL;
        }
        
        $news->translations()->delete();
        
        foreach($locales as $locale) {
            \App::setLocale($locale->language);
            $news->title = \Input::get('title-' . $locale->language);
            $news->slug = \Input::get('title-' . $locale->language);
            $news->content = \Input::get('content-' . $locale->language);
        }

        \App::setLocale($this->administratorLocale);

        $news->album_id = \Input::get('album')? \Input::get('album') : NULL;
        $news->created_at = date('Y-m-d H:i:s', strtotime(\Input::get('date')));
        $news->save();
        
        return redirect('administrator/news')->with('success', __('news::admin.msg_updated'));
    }
}
