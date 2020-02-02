<?php
namespace App\Pages;

use App\Models\News\News as NewsModel;
use App\Models\News\NewsTranslation;
use App\Models\News\Category;
use App\Models\Locale;

/**
 * Display News list and single News
 */
class News extends Main
{    
    public function __construct($item_id = null){
        $this->title = 'News';
        parent::__construct($item_id);
        $this->shortcut = ['name' => 'View News', 'url' => url('administrator/news')];
    }  
    
    public function logic()
    {
        $params = $this->params();
        $slug = $params[0];

        // Get current locale
        $locale = Locale::where('language', '=', \App::getLocale())->get()->first();
            
        if($slug){
            // Check if there is news in the current language
            $translation = NewsTranslation::where('slug', '=', $slug)->where('locale', '=', $locale->language)->get()->first();
            
            if($translation){
                $single = NewsModel::where('id', '=', $translation->news_id)->where('is_active', '=', '1')->get()->first();

                if($single){
                    $this->title($single->title);
                    
                    return view('page.pages.news')->with([
                        'display' => 'single',
                        'single' => $single
                    ]);
                }
            }

            // check if there is a news in other languages
            $translation = NewsTranslation::where('slug', '=', $slug)->get()->first();

            if($translation){
                $single = $translation->news->where('is_active', '=', '1')->get()->first();

                if($single){
                    $this->title($single->title);
                    // change current language
                    \App::setLocale($translation->locale);
                    \Cookie::queue(\Cookie::make('locale', $translation->locale));

                    // Redirect
                    return redirect(\Page::link(['type' => 'news'], [], $translation->slug));
                }
            }
            
            return redirect('/');
        }else{
            $search_string = request()->get('search_string');
            $search_category = request()->get('search_category');
            
            // Here we will display news list
            $query = NewsModel::query();
        
            $query->whereHas('translations', function($query) use($locale){
                $query->where('locale', $locale->language);
            });

            if($search_string){
                $query->whereHas('translations', function($query) use($search_string){
                    $query->where('title', 'LIKE', '%' . $search_string . '%');
                });
            }
            
            if($search_category){
                $query->where('category_id', '=', $search_category);
            }
            
            $news = $query->orderBy('created_at', 'desc')->where('is_active', '=', '1')->limit(6)->get();
            
            // Get the news categories
            $categories = [];
            
            foreach(Category::all() as $category){
                $categories[$category->id] = $category->name;
            }
            
            return view('page.pages.news')->with([
                'display' => 'list',
                'news' => $news,
                'categories' => $categories
            ]);
        }
    }
}
