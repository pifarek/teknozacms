<?php

namespace App\Extensions\Events\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Event extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'events';

    protected $translatedAttributes = ['name', 'description', 'ticket_description'];

    /**
     * @return bool|void|null
     * @throws \Exception
     */
    public function delete()
    {
        if($this->filename) {
            @unlink('upload/events/' . $this->filename);
        }
        parent::delete();
    }
    
    /**
     * Get event month
     * @return string
     */
    public function month(){
        \App::setLocale($this->locale);
        return (new \Date())->setTimestamp($this->start_time)->format('M');
    }
    
    /**
     * Get event day
     * @return string
     */
    public function day()
    {
        return (new \Date())->setTimestamp($this->start_time)->format('d');
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'event_id', 'id');
    }
}
