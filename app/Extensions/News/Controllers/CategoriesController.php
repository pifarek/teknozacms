<?php

namespace App\Extensions\News\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\News\Models\Category;
use App\Models\Locale;

class CategoriesController extends BaseController
{
    /**
     * Display list of news
     * @return type
     */
    public function index()
    {
        // Get the categories
        $categories = Category::all();
        
        return view('News.Views.administrator.categories', ['categories' => $categories]);
    }
    
    /**
     * Add a new news
     * @return view
     */
    public function create()
    {
        return view('News.Views.administrator.category-add', ['locales' => Locale::all()]);
    }
    
    public function store()
    {
        $rules = [];
        
        foreach(Locale::all() as $locale) {
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $category = new Category;
        
        foreach(Locale::all() as $locale) {
            \App::setLocale($locale->language);
            $category->name = \Input::get('name-' . $locale->language);
        }
        
        $category->save();
        
        return redirect('administrator/news/categories')->with('success', __('news::admin.msg_added'));
    }
    
    /**
     * Edit selected news
     * @param int $news_id
     * @return view
     */
    public function edit($category_id)
    {
        $category = Category::find($category_id);
        if(!$category) {
            return redirect('administrator/news/categories');
        }
        
        return view('News.Views.administrator.category-edit', ['locales' => Locale::all(), 'category' => $category]);
    }
    
    /**
     * Update selected category
     * @param type $news_id
     * @return type
     */
    public function update($category_id)
    {
        $category = Category::find($category_id);
        if(!$category) {
            return redirect('administrator/news/categories');
        }
        
        $rules = [];
        
        foreach(Locale::all() as $locale) {
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        foreach(Locale::all() as $locale) {
            $category->translate($locale->language)->name = \Input::get('name-' . $locale->language);
        }
        
        $category->save();
        
        return redirect('administrator/news/categories')->with('success', __('news::admin.msg_updated'));
    }
}
