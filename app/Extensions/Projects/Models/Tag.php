<?php

namespace App\Extensions\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Tag extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'projects_tags';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatedAttributes = ['name'];
}
