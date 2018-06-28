<?php
namespace App\Extensions\News\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

class Category extends Model
{
    use Translatable;
    
    protected $table = 'news_categories';
    
    public $timestamps = false;

    protected $guarded = ['_token', '_method'];

    protected $translatable = ['name'];

    public function translations()
    {
        return $this->hasMany(\App\Extensions\News\Models\CategoryTranslation::class);
    }
}