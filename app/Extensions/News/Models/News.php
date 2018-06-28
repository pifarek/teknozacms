<?php
namespace App\Extensions\News\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

class News extends Model
{
    use Translatable;
    
    protected $table = 'news';
    
    protected $translatable = ['title', 'slug', 'content'];
    
    public function locales()
    {
        $translations = \App\Extensions\News\Models\NewsTranslation::where('news_id', '=', $this->id)->get();
        $locales = [];
        foreach($translations as $translation){
            $locales[] = \App\Models\Locale::where('language', '=', $translation->locale)->get()->first();
        }
        return $locales;
    }
    
    public function category()
    {
        return $this->hasOne(\App\Extensions\News\Models\Category::class, 'id', 'category_id');
    }
    
    public function album()
    {
        return $this->hasOne(\App\Extensions\News\Models\Album::class, 'id', 'album_id');
    }
    
    public function delete()
    {
        if($this->filename) {
            @unlink('upload/news/s/' . $this->filename);
            @unlink('upload/news/n/' . $this->filename);
        }
        parent::delete();
    }
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    
    public function translations()
    {
        return $this->hasMany(\App\Extensions\News\Models\NewsTranslation::class);
    }
}