<?php
namespace App\Modules;
use App\Models\Contacts\Contact as ContactModel;

class Contact extends Module{
    protected $view = 'page.modules.contact';
    
    public function __construct($params = []) {
        parent::__construct($params);
    }
    
    public function logic() {
        $contact_id = isset($this->params['id'])? $this->params['id'] : '';

        $contact = ContactModel::find($contact_id);
        
        return [
            'contact' => $contact
        ];
    }
}