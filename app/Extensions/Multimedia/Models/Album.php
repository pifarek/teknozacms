<?php

namespace App\Extensions\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Album extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'multimedia_albums';

    public $timestamps = false;
    
    protected $fillable = ['id', 'name', 'description'];
    
    protected $translatedAttributes = ['name' ,'description'];
    
    public function thumbnail()
    {
        $media = $this->multimedia;
        return $media->count()? $media->first()->thumbnail() : false;
    }
    
    public function multimedia()
    {
        return $this->hasMany(\App\Extensions\Multimedia\Models\Multimedia::class);
    }
    
    /**
     * Get all the children
     */
    public function children()
    {
        return $this->hasMany(\App\Extensions\Multimedia\Models\Album::class, 'parent_id');
    }

}
