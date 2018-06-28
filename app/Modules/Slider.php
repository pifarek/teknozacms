<?php
namespace App\Modules;
use App\Extensions\Sliders\Models\Slider as SliderModule;
use App\Extensions\Sliders\Models\Slide;
use App\Models\Locale;

/**
 * Display slider
 */
class Slider extends Module
{
    protected $view = 'page.modules.slider';
    
    public function logic() {
        $slides = false;
        
        $shortcode = $this->params['shortcode'];
        $slider = SliderModule::where('shortcode', '=', $shortcode)->get()->first();
        
        if(!$slider){
            return ['slides' => $slides];
        }

        $query = Slide::query();
        
        $query->where('slider_id', $slider->id);
        
        $query->whereHas('translations', function($query){
            $query->where('locale', \App::getLocale());
        });
        
        $slides = $query->get();
        
        return [
            'slides' => $slides->count() ? $slides : false
        ];
    }
}