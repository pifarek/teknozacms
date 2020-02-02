<?php
namespace App\Extensions\Sliders\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Slide extends Model implements TranslatableContract
{
    use Translatable;
    
    protected $table = 'slides';
    
    protected $translatedAttributes = ['name', 'description', 'button_label'];
    
    public $timestamps = false;
    
    public function locales()
    {
        $translations = SlideTranslation::where('slide_id', '=', $this->id)->get();
        $locales = [];
        foreach($translations as $translation){
            $locales[] = \App\Models\Locale::where('language', '=', $translation->locale)->get()->first();
        }
        return $locales;
    }
    
    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
    
    /*public function locale()
    {
        return $this->belongsTo(\App\Models\Locale::class);
    }*/
    
    public function delete()
    {
        @unlink('upload/slides/' . $this->filename);
        parent::delete();
    }
    
    public function imageDelete()
    {
        if($this->filename) {
            @unlink('upload/slides/' . $this->filename);
            $this->filename = '';
            $this->save();
        }
    }
    
    public function move($direction)
    {
        switch($direction){
            case 'up':
                $this->moveUp();
                break;
            case 'down':
                $this->moveDown();
                break;
        }
    }
    
    public function moveUp()
    {
        $current_order = $this->order;
        
        // get the item with next order
        $slide = Slide::where('order', '=', $current_order - 1)->where('slider_id', $this->slider_id)->get()->first();
        if($slide){
            // switch with current item if exists
            $slide->order = $current_order;
            $slide->save();
        }
        
        // check if order < 0
        if($current_order - 1 >= 0){
            $this->order = $current_order - 1;
            $this->save();
        }

        $this->clearOrder();
        return true;
    }
    
    public function moveDown()
    {
        $current_order = $this->order;
        
        // get the item with next order
        $slide = Slide::where('order', '=', $current_order + 1)->where('slider_id', $this->slider_id)->get()->first();
        if($slide){
            // switch with current item if exists
            $slide->order = $current_order;
            $slide->save();
        }
        $this->order = $current_order + 1;
        $this->save();

        $this->clearOrder();
        return true;
    }
    
    private function clearOrder($parent_id = NULL)
    {
        
        $sliders = Slider::all();
        
        foreach($sliders as $slider){
            // Get parent items
            $slides = Slide::where('slider_id', $slider->id)->orderBy('order', 'ASC')->get();

            if($slides->count()){
                $count = 0;
                foreach($slides as $slide){
                    $slide->order = $count;
                    $slide->save();
                    $count++;
                }
            }
        }
    }
}
