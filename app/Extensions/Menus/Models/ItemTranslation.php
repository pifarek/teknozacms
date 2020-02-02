<?php

namespace App\Extensions\Menus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemTranslation extends Model
{
    protected $table = 'items_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
    
    public function item(){
        return $this->belongsTo(Item::class);
    }
    
    public function setUrlAttribute($value){
        $slug = Str::slug($value);
        $tmp = $slug;
        
        while($check = $this->where('url', '=', $tmp)->where('id', '!=', (int)$this->id)->where('locale', '=', $this->locale)->get()->first()){
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
        $this->attributes['url'] = $slug;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
