<?php

namespace App\Extensions\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'projects_images';

    public $timestamps = false;
    
    public function delete()
    {
        @unlink('upload/projects/' . $this->filename);
        parent::delete();
    }
}