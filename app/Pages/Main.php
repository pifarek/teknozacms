<?php
namespace App\Pages;

use App\Extensions\Menus\Models\Item;
use Illuminate\Routing\Controller;

class Main extends Controller
{
    public $title;
    public $type;
    public $url;
    public $shortcut;
    private $params;
    private $item_id;
    private $introImage;
    
    public function __construct($item_id = null)
    {
        $this->item_id = $item_id;
        $this->type = false;
        $this->shortcut = false;
        $this->image(false);
    }
    
    /**
     * Get custom settings
     * @param string $name
     * @param int $locale_id
     * @return string
     */
    protected function getCustom($name, $locale_id = NULL)
    {
        if($this->item_id){
            $custom = Item::find($this->item_id)->custom($name, $locale_id)->first();
            return $custom? $custom->value : false;
        }
        return false;
    }
    
    
    public function params(array $params = [])
    {
        if($params){
            $this->params = $params;
        }else{
            return $this->params;
        }
    }
    
    public function itemId()
    {
        return $this->item_id;
    }
    
    public function title($title = false)
    {
        if($title){
            $this->title = $title;
        }else{
            return $this->title;
        }
    }
    
    public function url($url = false){
        if($url){
            $this->url = $url;
        }else{
            return $this->url;
        }
    }
    
    public function type($type = false)
    {
        if($type){
            $this->type = $type;
        }else{
            return $this->type;
        }
    }
    
    public function image($image = false)
    {
        if($image){
            $this->introImage = $image;
        }else{
            return $this->introImage;
        }
    }
    
    public function getData()
    {
        return null;
    }
    
    public function getJson()
    {
        $json = $this->json($this->params[0]);
        return $json;
    }
    
    public function logic() {}
    
    public function fields()
    {
        return false;
    }
    
    public function json($option)
    {
        return response()->json(['empty']);
    }
    
}