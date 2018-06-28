<?php

namespace App\Extensions\Newsletter\Controllers\Send;

use App\Http\Controllers\Administrator\BaseController;


class JsonController extends BaseController
{

    public function contentElements()
    {
        $elements = \Input::get('elements');
        
        if(!$elements or !  is_array($elements)){
            return response()->json(['status' => 'err']);
        }
        
        // Save the session
        session(['newsletter_elements' => $elements]);
        
        return response()->json(['status' => 'ok']);
    }

}