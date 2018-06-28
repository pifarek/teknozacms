<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class EmailTranslation extends Model{
    protected $table = 'emails_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}