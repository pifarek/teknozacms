<?php

namespace App\Extensions\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

class Album extends Model
{
    use Translatable;

    protected $table = 'multimedia_albums';

    public $timestamps = false;
    
    protected $fillable = ['id', 'name', 'description'];
    
    protected $translatable = ['name' ,'description'];

    public function translations(){
        return $this->hasMany(\App\Extensions\Multimedia\Models\AlbumTranslation::class);
    }
    
    /**
     * @var array
     */
    protected $translatedAttributes = ['name'];
    
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