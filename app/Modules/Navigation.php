<?php
namespace App\Modules;
use App\Models\Menus\Menu as Menus;
use App\Models\Menus\Item;

class Navigation extends Module{
    protected $view = 'page.modules.navigation';
    private $current_url;
    
    public function logic(){
        $items = false;

        $this->current_url = isset($this->params['current_url'])? $this->params['current_url'] : false;

        if(!isset($this->params['shortcode'])){
            return ['items' => $items];
        }else{
            $shortcode = $this->params['shortcode'];
        }
        
        $menu = Menus::where('code', '=', $shortcode)->get()->first();
        
        if($menu){
            $items = $this->getMenuItems($menu->id);
            if(!$items){
                return ['items' => $items];
            }
            $items = $this->recursiveItems($items);            
        }
        return [
            'items' => $items
        ];
    }
    
    private function getMenuItems($menu_id){
        $items = Item::where('menu_id', '=', $menu_id)->where('parent_id', '=', NULL)->orderBy('order', 'ASC')->get();
        return $items->count()? $items : false;
    }
    
    private function recursiveItems($items){        
        foreach($items as $item){            
            $item = $this->rewriteUrl($item);
            $item = $this->current($item);
            if($item->children->count()){
                $item->children = $this->recursiveItems($item->children);
            }
        }
        return $items;
    }
    
    private function rewriteUrl($item){
        $item->rewrited_url = $item->url;
        if($item->type === 'alias'){
            $new = new \App\Pages\Alias($item->id);
            $item->rewrited_url = $new->aliasUrl();
        }
        if($item->type === 'url'){
            $url = new \App\Pages\Url($item->id);
            $item->rewrited_url = $url->getUrl();
        }        
        return $item;
    }
    
    private function current($item){
        if($item->rewrited_url === $this->current_url){
            $item->current = true;
        }else{
            $item->current = false;
            if($item->children->count()){
                if($this->currentInChildren($item->children)){
                    $item->current = true;
                }
            }
        }
        return $item;
    }
    
    private function currentInChildren($items){
        foreach($items as $item){
            $item = $this->rewriteUrl($item);
            if($item->rewrited_url === $this->current_url){
                return true;
            }
            
            if($item->children->count()){
                if($this->currentInChildren($item->children)){
                    return true;
                }
            }
        }
        return false;
    }
}