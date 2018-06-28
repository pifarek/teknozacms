<?php

namespace App\Extensions\Events\Models;

use Illuminate\Database\Eloquent\Model;

class EventTranslation extends Model{
    protected $table = 'events_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}