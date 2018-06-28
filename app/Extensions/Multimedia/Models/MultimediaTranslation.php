<?php

namespace App\Extensions\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;

class MultimediaTranslation extends Model
{
    protected $table = 'multimedia_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}