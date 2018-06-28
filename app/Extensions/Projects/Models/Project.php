<?php

namespace App\Extensions\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

class Project extends Model
{
    use Translatable;

    protected $table = 'projects';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatable = ['name', 'description'];
    
    public function translations()
    {
        return $this->hasMany(\App\Extensions\Projects\Models\ProjectTranslation::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(\App\Extensions\Projects\Models\Tag::class, 'projects_tag_project');
    }
    
    public function images()
    {
        return $this->hasMany(\App\Extensions\Projects\Models\Image::class);
    }
    
    public function partner()
    {
        return $this->belongsTo(\App\Extensions\Projects\Models\Partner::class);
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