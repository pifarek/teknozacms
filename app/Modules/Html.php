<?php
namespace App\Modules;
use App\Models\Menus\Item;
use App\Models\Locale;

/**
 * Display a html page as module
 */
class Html extends Module{
    protected $view = 'page.modules.html';
    
    public function logic() {

        if(!isset($this->params['id'])){
            return [
                'type' => 'empty'
            ];
        }
        
        $page_id = (int) $this->params['id'];
        
        // Get the selected item
        $item = Item::where('id', '=', $page_id)->where('type', '=', 'html')->get()->first();

        if(!$item){
            return [
                'type' => 'empty'
            ];
        }

        // Get current locale
        $locale = Locale::where('language', '=', \App::getLocale())->get()->first();
        
        return [
            'type' => 'normal',
            'item' => $item,
            'locale' => $locale
        ];
    }
}