<?php

namespace App\Extensions\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

class Tag extends Model
{
    use Translatable;

    protected $table = 'projects_tags';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatable = ['name'];
    
    public function translations()
    {
        return $this->hasMany(\App\Extensions\Projects\Models\TagTranslation::class);
    }
}