<?php
namespace App\Modules;
use App\Models\News\News as NewsModel;
use App\Models\Locale;

/**
 * Display a latest news
 */
class News extends Module{
    protected $view = 'page.modules.news';
    
    public function logic() {
        $limit = isset($this->params['limit'])? $this->params['limit'] : 5;
        $locale = isset($this->params['locale'])? $this->params['locale'] : \App::getLocale();

        $query = NewsModel::query();

        $query->whereHas('translations', function($query) use($locale){
            $query->where('locale', $locale);
        });
        
        $news = $query->orderBy('created_at', 'desc')->where('is_active', '=', '1')->limit($limit)->get();
        
        return [
            'news' => $news
        ];
    }
}