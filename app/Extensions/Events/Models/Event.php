<?php

namespace App\Extensions\Events\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;

class Event extends Model
{
    use Translatable;

    protected $table = 'events';

    /**
     * @var string
     */
    protected $translator = 'App\Models\Events\EventTranslation';

    /**
     * @var array
     */
    protected $translatable = ['name', 'description', 'ticket_description'];

    
    public function delete()
    {
        if($this->filename) {
            @unlink('upload/events/' . $this->filename);
        }
        parent::delete();
    }
    
    /**
     * Get event month
     */
    public function month(){
        \App::setLocale($this->locale);
        return (new \Date())->setTimestamp($this->start_time)->format('M');
    }
    
    /**
     * Get event day
     * @return type
     */
    public function day()
    {
        return (new \Date())->setTimestamp($this->start_time)->format('d');
    }
    
    public function translations()
    {
        return $this->hasMany(EventTranslation::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'event_id', 'id');
    }
}