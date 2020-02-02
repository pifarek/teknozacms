<?php

namespace App\Extensions\Menus\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Item extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'items';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatedAttributes = ['name', 'url', 'route'];

    public function getType()
    {
        return \App\Helpers\Page::getClass($this->type)->title;
    }
    
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    
    /**
     * Get all the children
     */
    public function children()
    {
        return $this->hasMany(Item::class, 'parent_id')->orderBy('order');
    }
    
    /**
     * Get the parent element
     * @return type
     */
    public function parent()
    {
        return $this->belongsTo(\App\Extensions\Menus\Models\Item::class);
    }
    
    /**
     * Get custom values
     */
    public function custom($name, $locale = NULL)
    {
        return $this->hasMany(\App\Extensions\Menus\Models\Custom::class)->where('name', '=', $name)->where('locale', '=', $locale);
    }
    
    public function deleteCustom()
    {
        $customs = \App\Extensions\Menus\Models\Custom::where('item_id', '=', $this->id)->get();
        if($customs){
            foreach($customs as $custom){
                $custom->delete();
            }
        }
    }
    
    public function delete()
    {
        if($this->image){
            @unlink('upload/menus/' . $this->image);
        }
        parent::delete();
    }
    
    public function move($direction)
    {
        switch($direction) {
            case 'up':
                $this->moveUp();
                break;
            case 'down':
                $this->moveDown();
                break;
        }
    }
    
    public function moveUp(){

        $current_order = $this->order;
        
        // get the item with next order
        $item = Item::where('order', '=', $current_order - 1)->where('menu_id', '=', $this->menu_id)->where('parent_id', '=', $this->parent_id)->get()->first();
        if($item){
            // switch with current item if exists
            $item->order = $current_order;
            $item->save();
        }
        
        // check if order < 0
        if($current_order - 1 >= 0){
            $this->order = $current_order - 1;
            $this->save();
        }

        $this->clearOrder();
        return true;
    }
    
    public function moveDown() {

        $current_order = $this->order;
        
        // get the item with next order
        $item = Item::where('order', '=', $current_order + 1)->where('menu_id', '=', $this->menu_id)->where('parent_id', '=', $this->parent_id)->get()->first();
        if($item){
            // switch with current item if exists
            $item->order = $current_order;
            $item->save();
        }
        $this->order = $current_order + 1;
        $this->save();

        $this->clearOrder();
        return true;
    }
    
    private function clearOrder($parent_id = NULL) {
        // Get parent items
        $items = Item::where('menu_id', '=', $this->menu_id)->where('parent_id', '=', $parent_id)->orderBy('order', 'ASC')->get();

        if($items->count()){
            $count = 0;
            foreach($items as $item){
                $item->order = $count;
                $item->save();
                $count++;
                
                if($item->children->count()){
                    $this->clearOrder($item->id);
                }
            }
        }
    }
    
    /**
     * Generate a route for the saved menu item
     * @param string $url
     * @param string $language
     * @param int $parent_id
     * @return string
     */
    public static function generateRoute($url, $locale, $parent_id = NULL)
    {
        $params = [];
        $items = self::getParent($parent_id);
        $items = $items->reverse();
        foreach($items as $item) {
            // get the item url
            $translation = $item->translations()->where('locale', $locale)->first();
            if($translation) {
                $params[] = $translation->url;
            }
        }
        $route = implode('/', $params);

        return $route ? $route . '/' . $url : $url;
    }
    
    private static function getParent($parent_id)
    {
        $children = collect();
        $item = Item::where('id', $parent_id)->first();
        
        if($item) {
            $children->push($item);
            
            $parent = self::getParent($item->parent_id);
            
            if($parent) {
                $children = $children->merge($parent);
            }
            return $children;
        }
        
        return collect();
    }
    
    public static function getByType($type)
    {
        $typeData = Item::where('type', $type)->orderBy('default', 'desc')->get()->first();
        return $typeData;
    }

    public static function getById($id)
    {
        $item = Item::where('id', '=', $id)->get()->first();
        return $item;
    }
}
