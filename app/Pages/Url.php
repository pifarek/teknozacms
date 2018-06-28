<?php
namespace App\Pages;

use App\Models\Menus\Item;

/**
 * Display Members/Board page
 */
class Url extends Main{    
    public function __construct($item_id = null){
        $this->title = 'URL';
        parent::__construct($item_id);
    }  
    
    public function logic(){
        
    }
    
    public function getUrl(){
        $url = $this->getCustom('url');
        return $url;
    }
    
    public function fields(){
        
        // Get the contacts
        $items = [];
        foreach(Item::all() as $item){
           $items[$item->id] = $item->name . ' [' . $item->menu->name . ']';
        }
        
        return [
            (object) [
                'label' => 'URL',
                'name' => 'url',
                'type' => 'text',
                'multilanguage' => false,
                'rules' => ['required'],
            ],
        ];
    }
}