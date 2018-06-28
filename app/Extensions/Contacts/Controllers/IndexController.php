<?php

namespace App\Extensions\Contacts\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Contacts\Models\Contact;
use App\Models\Locale;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Display list of contacts
     */
    public function index()
    {
        // Get the contacts
        $contacts = Contact::all();
        
        return view('Contacts.Views.administrator.index', ['contacts' => $contacts]);
    }
    
    /*
     * Add a new contact
     */
    public function create()
    {
        return view('Contacts.Views.administrator.add', ['locales' => Locale::all()]);
    }
    
    public function store(Request $request)
    {
        $rules = [
            'street' => [],
            'postal' => [],
            'city' => [],
            'phone' => [],
            'fax' => [],
            'email' => ['email']
        ];
        
        foreach(Locale::all() as $locale){
            $rules['name-'. $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $contact = new Contact;
        
        foreach(Locale::all() as $locale) {
            \App::setLocale($locale->language);
            
            $contact->name = $request->get('name-'. $locale->language);
            $contact->description = $request->get('description-'. $locale->language);
        }
        
        $contact->street = $request->get('street');
        $contact->postal = $request->get('postal');
        $contact->city = $request->get('city');
        $contact->phone = $request->get('phone');
        $contact->fax = $request->get('fax');
        $contact->email = $request->get('email');
        $contact->save();

        \App::setLocale($this->administratorLocale);
        
        return redirect('administrator/contacts')->with('success', trans('contacts::admin.msg_added'));
    }
    
    /*
     * Edit a selected contact
     */
    public function edit($contact_id)
    {
        $contact = Contact::find($contact_id);
        if(!$contact)
        {
            return redirect('administrator/contacts');
        }
        
        return view('Contacts.Views.administrator.edit', ['locales' => Locale::all(), 'contact' => $contact]);
    }
    
    public function update($contact_id, Request $request)
    {
        $contact = Contact::find($contact_id);
        if(!$contact)
        {
            return redirect('administrator/contacts');
        }
        
        $rules = [
            'street' => [],
            'postal' => [],
            'city' => [],
            'phone' => [],
            'fax' => [],
            'email' => ['email'],
        ];
        
        foreach(Locale::all() as $locale){
            $rules['name-'. $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        foreach(Locale::all() as $locale){            
            \App::setLocale($locale->language);
            
            $contact->name = $request->get('name-'. $locale->language);
            $contact->description = $request->get('description-'. $locale->language);
        }
        
        $contact->street = $request->get('street');
        $contact->postal = $request->get('postal');
        $contact->city = $request->get('city');
        $contact->phone = $request->get('phone');
        $contact->fax = $request->get('fax');
        $contact->email = $request->get('email');
        //dd($request->all());

        $contact->save();

        \App::setLocale($this->administratorLocale);
        
        return redirect('administrator/contacts')->with('success', trans('contacts::admin.msg_update'));
    }
}
