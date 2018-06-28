<?php

namespace App\Extensions\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTranslation extends Model
{
    protected $table = 'projects_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}