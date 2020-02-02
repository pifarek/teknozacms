<?php

namespace App\Extensions\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Contact extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'contacts';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatedAttributes = ['name', 'description'];
}
