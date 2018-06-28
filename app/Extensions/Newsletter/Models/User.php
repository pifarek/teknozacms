<?php

namespace App\Extensions\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'newsletter_users';
    
    public function group()
    {
        return $this->hasOne(\App\Extensions\Newsletter\Models\Group::class, 'id', 'group_id');
    }
}