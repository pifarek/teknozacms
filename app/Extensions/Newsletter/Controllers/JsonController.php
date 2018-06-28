<?php

namespace App\Extensions\Newsletter\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Newsletter\Models\User as NewsletterUser;
use App\Extensions\Newsletter\Models\Group as NewsletterGroup;

class JsonController extends BaseController
{
    /*
     * Remove selected newsletter
     */
    public function remove($newsletter_id)
    {
        $newsletter = NewsletterUser::find($newsletter_id);
        if($newsletter){
            $newsletter->delete();
        }
        
        \Session::flash('success', trans('newsletter::admin.msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /*
     * Remove selected newsletter group
     */
    public function groupRemove($group_id){
        $group = NewsletterGroup::find($group_id);
        if($group){
            $group->delete();
        }
        
        \Session::flash('success', trans('newsletter::admin.msg_group_removed'));
        
        return response()->json(['status' => 'ok']);
    }
}