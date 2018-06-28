<?php

namespace App\Extensions\News\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table = 'news_categories_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}