<?php

namespace App\Helpers;

class Page
{
    /*
     * Return list of pages
     * @return array
     */
    public static function getPages()
    {
        $classes = [];
        $handler = opendir(app_path() . DIRECTORY_SEPARATOR . 'Pages');
        while($file = readdir($handler)){
            $full = app_path() . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . $file;
            if(!is_dir($full) && strpos($full, '.php') !== false)
            {
                $class_name = "\App\Pages\\" . str_replace('.php', '', $file);
                $classes[] = new $class_name;
            }
        }
        return $classes;
    }
    
    /**
     * Return page class instance
     * @param string $name
     * @return Page
     */
    public static function getClass($name)
    {
        $class_name = 'App\Pages\\' . ucfirst($name);
        return new $class_name;
    }
    
    public static function find($url)
    {
        $page = ItemTranslation::where('url', (string)$url)->get()->first();
        if($page){
            $class_name = '\App\Pages\\' . ucfirst($page->item->type);
            $new = new $class_name($page->item_id);
            $new->title($page->item->name);
            $new->type($page->item->type);
            $new->image($page->item->image?:'');
            $new->type($page->item->type);
            $new->url($url);
            return $new;
        }
        return new \App\Pages\Index;
    }
    
    public static function get($name)
    {
        if(class_exists('\App\Pages\\' . ucfirst($name))){
            $class_name = '\App\Pages\\' . ucfirst($name);
            
            return new $class_name;
        }
        
        return new \App\Pages\Index;
    }
    
    /**
     * Generate html <a> element
     * @param array $page
     * @param array $params
     * @param string|bool $slug
     */
    public static function linkHTML(array $page, array $params = [], $slug = false)
    {
        if(!class_exists('\App\Extensions\Menus\Models\Item')) {
            throw new Exception('Missing required Extension: Menus');
        }

        $itemModel = \App\Extensions\Menus\Models\Item::class;

        $item = Page::findItem($page, $params, $slug);
        if($item) {
            $url = $itemModel::generateRoute($item->url, \App::getLocale(), $item->parent_id);
            return '<a href="' . url(Page::appendParams($url, $params, $slug)) . '">' . $item->name . '</a>';
        }
        return false;
    }
    
    /**
     * Return complete url to the page
     * @param array $page
     * @param array $params
     * @param string|bool $slug
     * @return string
     */
    public static function link(array $page, array $params = [], $slug = false)
    {
        if(!class_exists('\App\Extensions\Menus\Models\Item')) {
            throw new Exception('Missing required Extension: Menus');
        }

        $itemModel = \App\Extensions\Menus\Models\Item::class;

        $item = Page::findItem($page, $params, $slug);
        if($item) {
            $url = $itemModel::generateRoute($item->url, \App::getLocale(), $item->parent_id);
            return url(Page::appendParams($url, $params, $slug));
        }
        return false;
    }
    
    public static function shortcut($type)
    {
        return self::getClass($type)->shortcut;
    }
    
    /**
     * Find selected item in the Database
     * @param array $page
     * @return mixed
     */
    private static function findItem(array $page)
    {
        if(!class_exists('\App\Extensions\Menus\Models\Item')) {
            throw new Exception('Missing required Extension: Menus');
        }

        $itemModel = \App\Extensions\Menus\Models\Item::class;
        $itemTranslationModel = \App\Extensions\Menus\Models\ItemTranslation::class;

        if(isset($page['type'])) {
            $item = $itemModel::getByType($page['type']);
        } elseif(isset($page['url'])) {
            $item = $itemTranslationModel::getItemByUrl($page['url']);
        } elseif(isset($page['id'])) {
            $item = $itemModel::getById($page['id']);
        }
        
        return $item ?? false;
    }
    
    /**
     * Append params to the url
     * @param type $url
     * @param array $params
     * @param type $slug
     * @return string
     */
    private static function appendParams($url, array $params = [], $slug = false)
    {
        $address = $url;
        if($slug)
        {
            $address .= '/' . $slug;
        }
        if(sizeof($params)){
            $count = 0;
            foreach($params as $key => $value){
                if(!$count){
                    $address .= '?' . $key . '=' . $value;
                }else{
                    $address .= '&' . $key . '=' . $value;
                }
                $count++;
            }
        }
        return $address;
    }
}
