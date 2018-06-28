<?php
namespace App\Modules;
use App\Models\Events\Event as EventModel;
use App\Models\Locale;

/**
 * Display a latest news
 */
class Events extends Module{
    protected $view = 'page.modules.events';
    
    public function logic() {
        
        $events = EventModel::all();
        
        return [
            'events' => $events
        ];
    }
}