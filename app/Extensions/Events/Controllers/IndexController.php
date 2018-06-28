<?php

namespace App\Extensions\Events\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Models\Locale;
use App\Extensions\Events\Models\Event;

class IndexController extends BaseController
{
    /**
     * Display list of news
     * @return type
     */
    public function index()
    {
        // Get events
        $events = Event::orderBy('start_time')->get();
        
        return view('Events.Views.administrator.index', ['events' => $events]);
    }
    
    /**
     * Add a new event
     * @return type
     */
    public function create()
    {
        return view('Events.Views.administrator.add', ['locales' => Locale::all()]);
    }
    
    public function store()
    {
        $rules = [];
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $event = new Event;
        
        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $event->name = \Input::get('name-' . $locale->language);
        }

        \App::setLocale($this->administratorLocale);
        
        $event->save();
        
        return redirect('administrator/events/' . $event->id . '/edit')->with('success', trans('events::admin.msg_added'));
    }
    
    
    /**
     * Edit a selected event
     * @param int $event_id
     * @return view
     */
    public function edit($event_id)
    {
        $event = Event::find($event_id);
        if(!$event) {
            return redirect('administrator/events');
        }
        
        return view('Events.Views.administrator.edit', ['locales' => Locale::all(), 'event' => $event]);
    }
    
    /**
     * Edit a selected event
     * @param int $event_id
     * @return response
     */
    public function update($event_id)
    {
        $event = Event::find($event_id);
        if(!$event) {
            return redirect('administrator/events');
        }
        
        $rules = [
            'status' => ['required', 'numeric', 'min:0', 'max:1']
        ];
        
        if(\Input::get('register') == 1){
            $rules += [
                'tickets' => ['required', 'numeric'],
                'guests' => ['required', 'numeric', 'max:5']
            ];
        }
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $event->url = \Input::get('url');
        $event->start_time = strtotime(\Input::get('start'));
        $event->end_time = strtotime(\Input::get('end'));
        $event->address = \Input::get('address');
        $event->status = \Input::get('status');

        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $event->name = \Input::get('name-' . $locale->language);
            $event->description = \Input::get('description-' . $locale->language);
        }
        
        $event->save();
        
        return redirect('administrator/events')->with('success', trans('events::admin.msg_updated'));
    }
}
