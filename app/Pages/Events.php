<?php
namespace App\Pages;

use App\Models\Events\Event as EventModel;
use App\Models\Events\User as EventUser;
use App\Models\Events\Ticket;
use App\Models\User;

/**
 * Display News list and single News
 */
class Events extends Main{    
    public function __construct($item_id = null){
        $this->title = 'Events';
        parent::__construct($item_id);
        $this->shortcut = ['name' => 'View Events', 'url' => url('administrator/events')];
    }   
    
    public function logic(){
        $params = $this->params();
        $event_id = $params[0];
        if($event_id){
            $action = request()->get('action');
            // If we need to register to the event
            if($action === 'register'){
                $event = EventModel::where('status', true)->get()->find($event_id);
                if(!$event){
                    return redirect('/');
                }
                
                // Check if we can register to this event
                if($event->register != 1){
                    return redirect('/');
                }
                
                // Check event start date
                $close_date = $event->end_time - 21600;
                $can_register = $close_date > time()? true : false;
                
                if(\Request::method() === 'POST'){
                    
                    // If we didnt make it
                    if(!$can_register){
                        return redirect()->back();
                    }
                    
                    $rules = [
                        'quantity' => ['required', 'numeric', 'min:1'],
                        'first_name' => ['required'],
                        'last_name' => ['required'],
                        'email' => ['required', 'email', 'unique:events_users,email'],
                    ];
                    
                    // Get number of tickets
                    $quantity = request()->get('quantity');
                    
                    for($i = 2; $i < ($quantity + 1) && $i < ($event->guests + 1); $i++){
                        $rules += [
                            'first_name_'. $i => ['required'],
                            'last_name_' . $i => ['required'],
                        ];
                        var_dump($i);
                    }

                    $validation = \Validator::make(request()->all(), $rules);
                    
                    if($validation->fails()){
                        return redirect()->back()->withErrors($validation->errors())->withInput();
                    }

                    $eventUser = new EventUser;
                    $eventUser->event_id = $event_id;
                    $eventUser->email = request()->get('email');
                    $eventUser->save();
                    
                    // Check if we have that user registered
                    $user = User::where('email', request()->get('email'))->get()->first();
                    
                    if($user){
                        $eventUser->user_id = $user->id;
                        $eventUser->save();
                    }
                    
                    // Add a main user
                    $ticket = new Ticket;
                    $ticket->user_id = $eventUser->id;
                    $ticket->name = request()->get('first_name');
                    $ticket->surname = request()->get('last_name');
                    $ticket->save();
                    
                    // Add next users
                    for($i = 2; $i < ($quantity + 1) && $i < ($event->guests + 1); $i++){
                        $ticket = new Ticket;
                        $ticket->user_id = $eventUser->id;
                        $ticket->name = request()->get('first_name_'. $i);
                        $ticket->surname = request()->get('last_name_' . $i);
                        $ticket->save();
                    }
                    
                    // Send email with informations
                    $data = [];
                    \Mail::send('email.event-information', $data, function($mail) use ($eventUser){
                        $mail->to($eventUser->email)->subject('UTV event registration');
                    });
                    
                    return view('page.pages.event-success')->with([
                        'event' => $event
                    ]);
                }else{
                    return view('page.pages.event-register')->with([
                        'event' => $event,
                        'can_register' => $can_register
                    ]);
                }
            }else{
                $event = EventModel::where('status', true)->get()->find($event_id);
                if(!$event){
                    return redirect('/');
                }
                
                // Set the title
                $this->title($event->name);

                return view('page.pages.events')->with([
                    'display' => 'single',
                    'event' => $event,
                    'address' => $event->address? urlencode($event->address) : false
                ]);
            }
        }else{
            
            // Get upcoming events
            $upcoming = EventModel::where('start_time', '>', time())
                ->orWhere(function($query){
                    $query->where('start_time', '<=', time())
                        ->where('end_time', '>=', time());
                })->where('status', true)->get();
                
            // Get past events
            $past = EventModel::where('status', true)->where('end_time', '<', time())->get();
            
            return view('page.pages.events')->with([
                'display' => 'list',
                'upcoming' => $upcoming,
                'past' => $past
            ]);
            
        }
    }
}
