<?php
namespace App\Modules;
use App\Extensions\Menus\Models\Menu as Menus;
use App\Extensions\Menus\Models\Item;
use Illuminate\Support\Facades\Cache;

class Menu extends Module
{
    protected $view = 'page.modules.menu';
    private $current_url;
    
    /**
     * Login of the module
     * @return array
     */
    
    public function logic()
    {
        $this->current_url = $this->params['current_url'] ?? false;
        $shortcode = $this->params['shortcode'];

        return [
            'items' => $this->items($shortcode)
        ];
    }

    private function items($shortcode)
    {
        $items = collect();

        if(!$shortcode) {
            // Render menu with zero items
            return $items;
        }

        $menu = Menus::where('code', $shortcode)->first();

        if(!$menu) {
            // Render menu with zero items
            return $items;
        }

        if(Cache::has('menu_' . $shortcode)) {
            $items = Cache::get('menu_' . $shortcode);
        } else {
            $items = $this->getMenuItems($menu->id);

            if(!$items){
                // Render menu with zero items
                return ['items' => $items];
            }

            Cache::put('menu_' . $shortcode, $items, 5);
        }

        return $items;
    }
    
    /**
     * Get the menu items of the parent item
     * @param int $menu_id
     * @param int $parent_id
     * @return collection
     */
    private function getMenuItems($menu_id, $parent_id = NULL)
    {
        $items = Item::where('menu_id', $menu_id)->where('parent_id', $parent_id)->orderBy('order', 'ASC')->get();
        if($items) {
            foreach($items as $item) {
                $item = $this->rewriteUrl($item);
                $item = $this->current($item);
                $item->children = $this->getMenuItems($menu_id, $item->id);
            }
        }
        return $items->count()? $items : false;
    }
    
    /**
     * Rewrite original URL stored in database
     * @param Item $item
     * @return Item
     */
    private function rewriteUrl($item)
    {
        $item->rewrited_url = $this->hierarchyURL($item);
        if($item->type === 'alias') {
            $new = new \App\Pages\Alias($item->id);
            $item->rewrited_url = $new->aliasUrl();
        }
        if($item->type === 'url') {
            $url = new \App\Pages\Url($item->id);
            $item->rewrited_url = $url->getUrl();
        }        
        return $item;
    }
    
    /**
     * Get the parent elements and create url divided by slashes
     * @param Item $item
     * @return Item
     */
    private function hierarchyURL($item, $urlPartial = '')
    {
        $urlPartial = $item->url;
        if($item->parent) {
            $item->rewrited_url = 'dupa8';
            $urlPartial = $this->hierarchyURL($item->parent, $urlPartial) . '/' . $urlPartial;
        }
        
        return $urlPartial;
    }
    
    private function current($item)
    {
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
    
    private function currentInChildren($items)
    {
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
