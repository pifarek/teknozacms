<?php

namespace App\Extensions\Events\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Events\Models\Event;

class JsonController extends BaseController
{
    /*
     * Upload event image
     */
    public function image($event_id)
    {
        $event = Event::find($event_id);
        if(!empty($_FILES['image']['tmp_name']) && $event){
            $filename = uniqid(null, true) . '.jpg';
        
            \Image::make($_FILES['image']['tmp_name'])->fit(1200, 400)->save('upload/events/' . $filename);
            
            if($event->filename){
                @unlink('upload/events/' . $event->filename);
            }
            
            $event->filename = $filename;
            $event->save();
            
            return response()->json(['status' => 'ok', 'filename' => $filename]);
        }
        return response()->json(['status' => 'err']);
    }
    
    /*
     * Remove selected image
     */
    public function imageRemove($event_id)
    {
        $event = Event::find($event_id);
        if($event)
        {
            @unlink('upload/events/' . $event->filename);
            $event->filename = '';
            $event->save();
            return response()->json(['status' => 'ok']);
        }
        return response()->json(['status' => 'err']);
    }
    
    /*
     * Remove selected event
     */
    public function remove($event_id)
    {
        $event = Event::find($event_id);
        if($event) {
            $event->delete();
        }
        
        \Session::flash('success', trans('events::admin.msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
}