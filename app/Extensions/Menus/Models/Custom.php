<?php

namespace App\Extensions\Menus\Models;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $table = 'custom';
    
    public $timestamps = false;
    
    public $fillable = ['item_id', 'locale', 'name', 'value'];
    
    public function item()
    {
        return $this->belongsTo(\App\Extensions\Menus\Models\Item::class);
    }
}

