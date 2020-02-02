<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Support\Str;

class Email extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'emails';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatedAttributes = ['content', 'subject'];
    
    public function setTagAttribute($value)
    {
        $tag = Str::slug($value, '_');
        $tmp = $tag;
        
        while($check = $this->where('tag', '=', $tmp)->where('id', '!=', (int)$this->id)->get()->first()){
            $count = str_replace($tag, '', $check->url);            
            if($count == ''){
                $tmp = $tag . '_2';
            }else{
                $count = (int) str_replace('_', '', $count);
                $count++;
                $tmp = $tag . '_' . $count;
            }
        }
        $tag = $tmp;
        $this->attributes['tag'] = $tag;
    }
    
    public function isStatic(){
        return $this->static == '1'? true : false;
    }
}
