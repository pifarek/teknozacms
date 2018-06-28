<?php

namespace App\Extensions\Contacts\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Contacts\Models\Contact;

class JsonController extends BaseController
{

    /*
     * Remove selected contact
     */
    public function remove($contact_id)
    {
        $contact = Contact::find($contact_id);
        if($contact) {
            $contact->delete();
        }
        
        \Session::flash('success', trans('contacts::admin.msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
}