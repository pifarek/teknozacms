<?php
namespace App\Pages;

use App\Extensions\Contacts\Models\Contact as ContactModel;
use Illuminate\Http\Request;

class Contact extends Main
{
    public function __construct($item_id = null)
    {
        $this->title = 'Contact Page';
        parent::__construct($item_id);
        $this->shortcut = ['name' => 'View Contact Persons', 'url' => url('administrator/contacts')];        
    }  
    
    public function logic(Request $request)
    {
        $contact_id = (int) $this->getCustom('contact_id');

        if(!$contact_id) {
            list($contact_id) = $this->params();
        }
        
        // Get the contact
        $contact = ContactModel::find($contact_id);
        
        if($contact) {
            $success = false;
            if($request->method() === 'POST') {
                $rules = [
                    'name' => ['required'],
                    'email' => ['required', 'email'],
                    'message' => ['required']
                ];
                
                $validation = \Validator::make($request->all(), $rules);
                if($validation->fails()){
                    return redirect()->back()->withInput()->withErrors($validation->errors());
                }else{
                    
                    $data = [
                        'ip_addr' => $_SERVER['REMOTE_ADDR'],
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'body' => $request->get('message'),
                    ];
                    
                    $success = true;

                    \Mail::send('email.contact', $data, function($mail) use ($contact){
                        $mail->to($contact->email)->subject('Contact Form');
                    });
                }
            }
            
            $address = $contact->street . ', ' . $contact->postal . ' ' . $contact->city;
            
            $address = urlencode($address);
            
            return view('page.pages.contact', [
                'display' => 'single',
                'address' => $address,
                'contact' => $contact,
                'success' => $success
            ]);
        }

        $contacts = ContactModel::all();

        return view('page.pages.contact', [
            'display' => 'list',
            'contacts' => $contacts
        ]);
    }
    
    public function fields()
    {
        // Get the contacts
        $contacts = [];
        foreach(ContactModel::all() as $contact){
           $contacts[$contact->id] = $contact->name;
        }
        
        return [
            (object) [
                'label' => __('admin.page_contact_display'),
                'name' => 'contact_id',
                'type' => 'select',
                'multilanguage' => false,
                'rules' => ['required', 'numeric'],
                'options' => [
                    0 => __('admin.page_contact_display_all'),
                ] + $contacts
            ],
                
        ];
    }

}
