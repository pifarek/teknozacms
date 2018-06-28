<?php

namespace App\Extensions\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

class Contact extends Model
{
    use Translatable;

    protected $table = 'contacts';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatable = ['name', 'description'];
    
    public function translations()
    {
        return $this->hasMany(\App\Extensions\Contacts\Models\ContactTranslation::class);
    }
}