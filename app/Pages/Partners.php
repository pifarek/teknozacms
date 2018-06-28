<?php
namespace App\Pages;

use App\Models\Partners\Partner as PartnerModel;

/**
 * Display Projects list and single Project
 */
class Partners extends Main{    
    public function __construct($item_id = null){
        $this->title = 'Partners';
        
        parent::__construct($item_id);
    }   
    
    public function logic(){
        
        // Get projects
        $partners = PartnerModel::all();

        return view('page.pages.partners', [
            'partners' => $partners
        ]);
    }
}