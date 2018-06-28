<?php

namespace App\Extensions\Events\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'events_users';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}