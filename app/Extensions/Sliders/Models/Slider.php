<?php
namespace App\Extensions\Sliders\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';
    
    public $timestamps = false;
    
    public function slides()
    {
        return $this->hasMany(\App\Extensions\Sliders\Models\Slide::class, 'slider_id', 'id');
    }
}