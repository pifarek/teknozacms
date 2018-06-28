<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\IsTranslatable;
use Vinkla\Translator\Translatable;

class Email extends Model implements IsTranslatable{
    use Translatable;

    protected $table = 'emails';

    public $timestamps = false;

    /**
     * @var string
     */
    protected $translator = 'App\Models\Settings\EmailTranslation';

    /**
     * @var array
     */
    protected $translatedAttributes = ['content', 'subject'];
    
    public function translations(){
        return $this->hasMany(\App\Models\Settings\EmailTranslation::class);
    }
    
    public function setTagAttribute($value){
        $tag = str_slug($value, '_');
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