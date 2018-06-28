<?php

namespace App\Extensions\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'multimedia_images';

    public $timestamps = false;

    public function multimedia()
    {
        return $this->belongsTo(\App\Extensions\Multimedia\Models\Multimedia::class);
    }
}