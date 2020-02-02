<?php
namespace App\Extensions\News\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Model implements TranslatableContract
{
    use Translatable;
    
    protected $table = 'news_categories';
    
    public $timestamps = false;

    protected $translatedAttributes = ['name'];
}
