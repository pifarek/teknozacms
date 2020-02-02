<?php

namespace App\Extensions\Events\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Models\Locale;
use App\Extensions\Events\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseController
{
    /**
     * Display list of news
     * @return View
     */
    public function index()
    {
        // Get events
        $events = Event::orderBy('start_time')->get();
        
        return view('Events.Views.administrator.index', ['events' => $events]);
    }
    
    /**
     * Add a new event
     * @return View
     */
    public function create()
    {
        return view('Events.Views.administrator.add', ['locales' => Locale::all()]);
    }
    
    public function store(Request $request)
    {
        $rules = [];
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $event = new Event;
        
        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $event->name = $request->get('name-' . $locale->language);
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
     * @param $request
     * @param int $event_id
     * @return response
     */
    public function update(Request $request, $event_id)
    {
        $event = Event::find($event_id);
        if(!$event) {
            return redirect('administrator/events');
        }
        
        $rules = [
            'status' => ['required', 'numeric', 'min:0', 'max:1']
        ];
        
        if($request->get('register') == 1){
            $rules += [
                'tickets' => ['required', 'numeric'],
                'guests' => ['required', 'numeric', 'max:5']
            ];
        }
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $event->url = $request->get('url');
        $event->start_time = strtotime($request->get('start'));
        $event->end_time = strtotime($request->get('end'));
        $event->address = $request->get('address');
        $event->status = $request->get('status');

        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $event->name = $request->get('name-' . $locale->language);
            $event->description = $request->get('description-' . $locale->language);
        }
        
        $event->save();
        
        return redirect('administrator/events')->with('success', trans('events::admin.msg_updated'));
    }
}
