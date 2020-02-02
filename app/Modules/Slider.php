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
    
    public function logic()
    {
        $shortcode = $this->params['shortcode'];
        $slider = SliderModule::where('shortcode', $shortcode)->first();

        if(!$slider)
        {
            return ['slides' => collect()];
        }

        $query = Slide::query();
        
        $query->where('slider_id', $slider->id);
        
        $query->whereHas('translations', function($query){
            $query->where('locale', \App::getLocale());
        });
        
        $slides = $query->get();

        return [
            'slides' => $slides
        ];
    }
}
