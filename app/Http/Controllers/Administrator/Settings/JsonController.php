<?php

namespace App\Http\Controllers\Administrator\Settings;

use App\Http\Controllers\Administrator\BaseController;
use App\Models\User;
use App\Models\Locale;
use App\Models\Settings\Email;
use yajra\Datatables\Facades\Datatables;

class JsonController extends BaseController
{
    /**
     * Delete selected user
     */
    public function userRemove($user_id)
    {
        // we can't remove currently logged user
        // and user that isn't administrator
        if(\Auth::user()->id != $user_id && \Auth::user()->isAdmin()){
            User::find($user_id)->delete();
            
            \Session::flash('success', __('admin.settings_users_msg_removed'));
            
            return response()->json(['status' => 'ok']);
        }
        return response()->json(['status' => 'err']);
    }
    
    /*
     * Remove selected locale
     */
    public function localeRemove($locale_id)
    {
        // Check if it isnt the last locale
        if(Locale::all()->count() <= 1) {
            return response()->json(['status' => 'err', 'error' => '']);
        }

        $locale = Locale::find($locale_id);
        if($locale) {
            $locale->delete();
        }
        
        \Session::flash('success', trans('admin.settings_locale_msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Read and display selected translation file
     * @param string $file
     * @return view
     */
    public function translationEdit($file)
    {
        $full_name = base64_decode($file);

        if(!file_exists($full_name)){
            return response()->json(['status' => 'err']);
        }
        
        $content = file_get_contents($full_name);
                
        $array = include $full_name;

        $view = view('administrator.settings.partial.file', ['array' => $array, 'content' => $content]);
        
        return response()->json(['status' => 'ok', 'html' => $view->render()]);
    }
}