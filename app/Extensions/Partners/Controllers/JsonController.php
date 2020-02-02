<?php

namespace App\Extensions\Partners\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Partners\Models\Partner;
use Illuminate\Http\Request;

class JsonController extends BaseController
{
    
    /**
     * Remove selected partner
     * @param int $partner_id
     * @return type
     */
    public function remove($partner_id)
    {
        $partner = Partner::find($partner_id);
        if($partner){
            $partner->delete();
        }
        
        \Session::flash('success', __('partners::admin.partners_msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Upload partner image
     */
    public function imageUpload(Request $request, $partner_id)
    {
        $partner = Partner::find($partner_id);
        
        if(!$partner){
            return response()->json(['status' => 'err']);
        }
        
        $image = $request->file('image');
        
        $rules = [
            'image' => ['required', 'image']
        ];
        
        $validation = \Validator::make(['image' => $image], $rules);
        
        if($validation->passes()){
            $filename = uniqid(null, true) . '.jpg';
        
            \Image::make($image->getRealPath())->fit(1000, 605)->save('upload/partners/' . $filename);
            
            $partner->filename = $filename;
            $partner->save();
            return response()->json(['status' => 'ok', 'filename' => $filename]);
        }        
        return response()->json(['status' => 'err']);
    }
    
    public function imageRemove($partner_id)
    {
        $partner = Partner::find($partner_id);
        
        if(!$partner){
            return response()->json(['status' => 'err']);
        }
        
        if($partner->filename){
            @unlink('upload/partners/' . $partner->filename);
        }
        
        $partner->filename = '';
        $partner->save();
        
        return response()->json(['status' => 'ok']);
    }
    
    public function move($direction, $partner_id)
    {
        $partner = Partner::find($partner_id);
        if(!$partner && false === in_array($direction, ['up', 'down'])) {
            return response()->json(['status' => 'err']);
        }
        
        $partner->move($direction);
        
        return response()->json(['status' => 'ok']);
    }
}
