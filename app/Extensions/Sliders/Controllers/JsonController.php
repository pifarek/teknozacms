<?php

namespace App\Extensions\Sliders\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Sliders\Models\Slider;
use App\Extensions\Sliders\Models\Slide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JsonController extends BaseController
{

    /**
     * Remove selected slide
     * @param int $slider_id
     */
    public function remove($slider_id)
    {
        $slider = Slider::find($slider_id);
        if($slider){
            $slider->delete();
        }
        
        \Session::flash('success', trans('sliders::admin.slider_msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Remove selected slide
     * @param int $slide_id
     */
    public function slideRemove($slide_id)
    {
        $slide = Slide::find($slide_id);
        if($slide) {
            $slide->delete();
        }
        
        \Session::flash('success', trans('sliders::admin.slide_msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Upload slide image
     * @param Request $request
     * @param int $slide_id
     * @return JsonResponse
     */
    public function image(Request $request, $slide_id)
    {
        $slide = Slide::find($slide_id);
        if(!$slide){
            return response()->json(['status' => 'err']);
        }
        $image = $request->file('image');
        if(!$image){
            return response()->json(['status' => 'err']);
        }
        
        $filename = uniqid(null, true) . '.jpg';
        
        \Image::make($image->getRealPath())->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('upload/slides/' . $filename, 95);
        
        $slide->imageDelete();
        $slide->filename = $filename;
        $slide->save();
        
        return response()->json(['status' => 'ok', 'filename' => $filename]);
    }
    
    /**
     * Upload tmp slide image
     * @param Request $request
     * @return JsonResponse
     */
    public function imageTmp(Request $request)
    {
        $image = $request->file('tmp');
        if(!$image){
            return response()->json(['status' => 'err']);
        }
        
        $filename = uniqid(null, true) . '.jpg';
        
        \Image::make($image->getRealPath())->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('upload/tmp/' . $filename, 95);
        
        return response()->json(['status' => 'ok', 'filename' => $filename]);
    }
    
    /**
     * Change the order of the selected slide
     * @param string $direction
     * @param int $slide_id
     * @return response
     */
    public function move($direction, $slide_id){
        $slide = Slide::find($slide_id);
        if(!$slide && false === in_array($direction, ['up', 'down'])){
            return response()->json(['status' => 'err']);
        }
        
        $slide->move($direction);
        
        return response()->json(['status' => 'ok']);
    }
}
