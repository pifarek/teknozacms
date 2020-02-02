<?php
namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Administrator\BaseController;
use App\Models\User;
use App\Models\Locale;
use App\Models\Multimedia\Multimedia;
use App\Models\Multimedia\Image;
use Illuminate\Http\Request;

class JsonController extends BaseController
{
    /**
     * Set the fullscreen option
     */
    public function fullscreen(Request $request)
    {
        $fullscreen = $request->get('fullscreen');

        if($fullscreen) {
            $cookie = \Cookie::forever('fullscreen', true);
            return response()->json(['status' => 'ok'])->withCookie($cookie);
        }

        $cookie = \Cookie::forget('fullscreen');
        return response()->json(['status' => 'ok'])->withCookie($cookie);
    }
}
