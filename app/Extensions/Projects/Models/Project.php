<?php

namespace App\Extensions\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Project extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'projects';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatedAttributes = ['name', 'description'];
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'projects_tag_project');
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function partner()
    {
        return $this->belongsTo(\App\Extensions\Partners\Models\Partner::class);
    }
    
    public function delete()
    {
        // Remove project images
        foreach($this->images as $image) {
            $image->delete();
        }
		
        if($this->filename) {
            @unlink('upload/projects/covers/' . $this->filename);
        }
        parent::delete();
    }
}
