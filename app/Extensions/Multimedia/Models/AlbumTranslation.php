<?php

namespace App\Extensions\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumTranslation extends Model
{
    protected $table = 'multimedia_albums_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}