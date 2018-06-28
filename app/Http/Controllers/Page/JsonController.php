<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;

class JsonController extends Controller{

    public function getRequestForm(){
        
        $rules = [
            'name' => ['required'],
            'company' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'message' => ['required']            
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return response()->json(['status' => 'err']);
        }
        
        $data = [
            'ip_addr' => $_SERVER['REMOTE_ADDR'],
            'name' => \Input::get('name'),
            'company' => \Input::get('company'),
            'email' => \Input::get('email'),
            'phone' => \Input::get('phone'),
            'message' => \Input::get('message'),
        ];

        //\Mail::send('email.request', $data, function($mail){
            //$mail->to(\Settings::get('email'))->subject('Contact Form');
        //});
        
        return response()->json(['status' => 'ok']);
    }
    
    /*
     * Accept cookie policy
     */
    public function getCookies(){
        $cookie = \Cookie::forever('cookies', true);
        return response()->json(['status' => 'ok'])->withCookie($cookie);
    }
}
