<?php

namespace App\Extensions\Sliders\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Sliders\Models\Slider;
use App\Extensions\Sliders\Models\Slide;

class IndexController extends BaseController
{
    /*
     * Display slides
     */
    public function index()
    {
        // Get the sliders
        $sliders = Slider::all();
        
        return view('Sliders.Views.administrator.index', ['sliders' => $sliders]);
    }
    
    /*
     * Add a new slider
     */
    public function create()
    {
        return view('Sliders.Views.administrator.add');
    }
    
    public function store()
    {
        $rules = [
            'short' => ['required']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $slider = new Slider;
        $slider->shortcode = \Input::get('short');
        $slider->save();
        
        return redirect('administrator/sliders')->with('success', trans('sliders::admin.slider_msg_added'));
    }
}
