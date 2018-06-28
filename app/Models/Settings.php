<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model{
    protected $table = 'settings';
    public $timestamps = false;
    public $fillable = ['locale_id', 'name', 'value'];
    
    public static function get($key){
        $value = Settings::where('name', '=', $key)->get()->first();
        if($value){
            return $value->value;
        }
        return NULL;
    }
    
    public static function getAll(){
        $settings = Settings::all();
        $values = [];
        
        if($settings)
        {
            foreach($settings as $setting)
            {
                $values[$setting->name] = $setting->value;
            }
        }
        
        return (object) $values;
        
    }
}