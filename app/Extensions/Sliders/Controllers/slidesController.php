<?php

namespace App\Extensions\Sliders\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Sliders\Models\Slider;
use App\Extensions\Sliders\Models\Slide;
use App\Models\Locale;
use Illuminate\Http\Request;

class SlidesController extends BaseController
{
    
    /*
     * Add a new slider
     */
    public function create(Request $request)
    {
        // Selected slider
        $slider_id = $request->get('slider_id');
        
        // Get the sliders
        $sliders = Slider::pluck('shortcode', 'id');

        return view('Sliders.Views.administrator.slide-add', ['sliders' => $sliders, 'locales' => Locale::all(), 'slider_id' => $slider_id]);
    }
    
    public function store(Request $request)
    {
        $locales = Locale::find($request->get('locales'));
        
        if(!$locales){
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['locales' => __('admin.msg_select_language')]))->withInput();
        }
        
        $rules = [
            'slider' => ['numeric'],
            'image' => ['required'],
            'available_date' => ['required', 'numeric', 'max:1']
        ];
        
        if($request->get('available_date') == 1) {
            $rules['start_date'] = ['required', 'date'];
            $rules['end_date'] = ['required', 'date'];
        }
        
        foreach($locales as $locale) {
            $rules['name-' . $locale->language] = ['required'];

            if($request->get('url')) {
                $rules['button-' . $locale->language] = ['required'];
            }
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $filename = uniqid(null, true) . '.jpg';
        
        \File::move('upload/tmp/' . $request->get('image'), 'upload/slides/' . $filename);
        
        // Check last order
        $order = 0;
        $lastSlide = Slide::where('slider_id', $request->get('slider'))->limit(1)->orderBy('order', 'desc')->get()->first();
        if($lastSlide){
            $order = $lastSlide->order + 1;
        }
        
        $slide = new Slide;

        foreach($locales as $locale) {
            \App::setLocale($locale->language);
            $slide->name = $request->get('name-' . $locale->language);
            $slide->description = $request->get('description-' . $locale->language);

            if($request->get('url')) {
                $slide->button_label = $request->get('button-' . $locale->language);
            }
        }

        \App::setLocale($this->administratorLocale);
        
        $slide->slider_id = $request->get('slider');
        $slide->filename = $filename;
        $slide->url = $request->get('url');
        $slide->blank = $request->get('blank')? true : false;
        $slide->available_date = $request->get('available_date');
        
        if($request->get('available_date') == 1){
            $slide->start_date = strtotime($request->get('start_date'));
            $slide->end_date = strtotime($request->get('end_date'));
        }
        
        $slide->order = $order;
        $slide->save();

        return redirect('administrator/sliders')->with('success', __('sliders::admin.slide_msg_added'));
    }
    
    /**
     * Edit selected slide
     * @param type $slide_id
     */
    public function edit($slide_id)
    {
        $slide = Slide::find($slide_id);
        if(!$slide) {
            return redirect('administrator/sliders');
        }
        
        // Get the sliders
        $sliders = Slider::pluck('shortcode', 'id');
        
        return view('Sliders.Views.administrator.slide-edit', ['locales' => Locale::all(), 'sliders' => $sliders, 'slide' => $slide]);
    }

    public function update(Request $request, $slide_id)
    {
        $slide = Slide::find($slide_id);
        if(!$slide){
            return redirect('administrator/sliders');
        }
        
        $locales = Locale::find($request->get('locales'));
        
        if(!$locales){
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['locales' => __('admin.select_one_language')]))->withInput();
        }
        
        $rules = [
            'slider' => ['numeric'],
            'image' => 'image',
            'available_date' => ['required', 'numeric', 'max:1']
        ];
        
        if($request->get('available_date') == 1){
            $rules['start_date'] = ['required', 'date'];
            $rules['end_date'] = ['required', 'date'];
        }
        
        foreach($locales as $locale){
            $rules['name-' . $locale->language] = ['required'];

            if($request->get('url')) {
                $rules['button-' . $locale->language] = ['required'];
            }
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $slide->translations()->delete();
        
        foreach($locales as $locale) {
            \App::setLocale($locale->language);
            $slide->name = $request->get('name-' . $locale->language);
            $slide->description = $request->get('description-' . $locale->language);

            if($request->get('url')) {
                $slide->button_label = $request->get('button-' . $locale->language);
            }
        }
        \App::setLocale($this->administratorLocale);
        
        $slide->slider_id = $request->get('slider');
        $slide->url = $request->get('url');
        $slide->blank = $request->get('blank')? true : false;
        $slide->available_date = $request->get('available_date');
        
        if($request->get('available_date') == 1){
            $slide->start_date = strtotime($request->get('start_date'));
            $slide->end_date = strtotime($request->get('end_date'));
        }
        
        $slide->save();
        
        return redirect('administrator/sliders')->with('success', __('sliders::admin.slide_msg_updated'));
    }
}
