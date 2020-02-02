<?php
namespace App\Extensions\News\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsTranslation extends Model
{
    protected $table = 'news_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
    
    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        $tmp = $slug;
        
        while($check = $this->where('slug', '=', $tmp)->where('id', '!=', (int)$this->id)->where('locale', '=', $this->locale)->get()->first()){
            $count = str_replace($slug, '', $check->url);            
            if($count == ''){
                $tmp = $slug . '-2';
            }else{
                $count = (int) str_replace('-', '', $count);
                $count++;
                $tmp = $slug . '-' . $count;
            }
        }
        $slug = $tmp;
        $this->attributes['slug'] = $slug;
    }
    
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id', 'id');
    }
}
