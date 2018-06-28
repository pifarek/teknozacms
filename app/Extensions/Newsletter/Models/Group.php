<?php

namespace App\Extensions\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'newsletter_groups';    
    public $timestamps = false;
    
    public function newsletter()
    {
        return $this->hasMany(\App\Extensions\Newsletter\Models\User::class, 'group_id', 'id');
    }
    
    public function users()
    {
        return $this->hasMany(\App\Extensions\Newsletter\Models\User::class, 'group_id', 'id');
    }
}