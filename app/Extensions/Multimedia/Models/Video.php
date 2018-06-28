<?php

namespace App\Extensions\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'multimedia_videos';

    public $timestamps = false;

    public function multimedia(){
        return $this->belongsTo(\App\Extensions\Multimedia\Models\Multimedia::class);
    }
}