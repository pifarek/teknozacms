<?php

namespace App\Extensions\Newsletter\Controllers\Send;

use App\Http\Controllers\Administrator\BaseController;
use Illuminate\Http\Request;


class JsonController extends BaseController
{

    public function contentElements(Request $request)
    {
        $elements = $request->get('elements');
        
        if(!$elements or !  is_array($elements)){
            return response()->json(['status' => 'err']);
        }
        
        // Save the session
        session(['newsletter_elements' => $elements]);
        
        return response()->json(['status' => 'ok']);
    }

}
