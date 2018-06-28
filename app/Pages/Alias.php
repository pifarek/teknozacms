<?php
namespace App\Pages;

use App\Models\Menus\Item;

/**
 * Display Members/Board page
 */
class Alias extends Main{    
    public function __construct($item_id = null){
        $this->title = 'Alias';
        parent::__construct($item_id);
    }  
    
    public function logic(){
        
    }
    
    public function aliasUrl(){
        $page_id = $this->getCustom('alias');
        $anchor = $this->getCustom('anchor');
        $page = Item::where('id', '=', $page_id)->get()->first();
        if(!$page){
            return url('/');
        }
        if($anchor){
            if(0 !== strpos($anchor, '#')){
                $anchor = '#' . $anchor;
            }            
        }else{
            $anchor = '';
        }
        return $page->url . $anchor;
    }
    
    public function fields(){
        
        // Get the contacts
        $items = [];
        // Get menu items
        $items = [];
        foreach(Item::where('id', '!=', $this->item_id)->get() as $item) {
           $items[$item->id] = $item->name . ' [' . $item->menu->name . ']';
        }
        
        return [
            (object) [
                'label' => 'Alias for',
                'name' => 'alias',
                'type' => 'select',
                'multilanguage' => false,
                'rules' => ['required', 'numeric'],
                'options' => $items
            ],
            (object) [
                'label' => 'Anchor',
                'name' => 'anchor',
                'type' => 'text',
                'multilanguage' => false,
                'rules' => []
            ], 
        ];
    }
}