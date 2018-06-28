<?php

namespace App\Extensions\Menus\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    
    public $timestamps = false;
    
    public function items()
    {
        return $this->hasMany(\App\Extensions\Menus\Models\Item::class);
    }
    
    public function itemsParent()
    {
        return $this->hasMany(\App\Extensions\Menus\Models\Item::class)->where('parent_id', '=', NULL)->orderBy('order');
    }
}

