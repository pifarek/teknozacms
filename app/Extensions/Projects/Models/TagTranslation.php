<?php

namespace App\Extensions\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $table = 'projects_tags_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}