<?php
namespace App\Extensions\News\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class News extends Model implements TranslatableContract
{
    use Translatable;
    
    protected $table = 'news';
    
    protected $translatedAttributes = ['title', 'slug', 'content'];
    
    public function locales()
    {
        $translations = NewsTranslation::where('news_id', '=', $this->id)->get();
        $locales = [];
        foreach($translations as $translation){
            $locales[] = \App\Models\Locale::where('language', '=', $translation->locale)->get()->first();
        }
        return $locales;
    }
    
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    
    public function album()
    {
        return $this->hasOne(Album::class, 'id', 'album_id');
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
}
