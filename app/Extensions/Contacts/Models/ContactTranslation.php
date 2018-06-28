<?php

namespace App\Extensions\Contacts\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTranslation extends Model
{
    protected $table = 'contacts_translations';
    
    public $timestamps = false;
    
    protected $guarded = ['_token', '_method'];
}