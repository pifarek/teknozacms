<?php

namespace App\Extensions\Menus\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Menus\Models\Menu;
use App\Extensions\Menus\Models\Item;
use App\Extensions\Menus\Models\Custom;
use App\Models\Locale;

class IndexController extends BaseController
{
    /**
     * Display list of news
     * @return type
     */
    public function menus()
    {
        // Get the menus
        $menus = Menu::all();
        
        return view('Menus.Views.administrator.index', ['menus' => $menus]);
    }
    
    /*
     * Add a new menu
     */
    public function getAdd()
    {
        return view('Menus.Views.administrator.add');
    }
    
    public function postAdd()
    {
        $rules = [
            'name' => ['required'],
            'code' => ['required']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $menu = new Menu;
        $menu->name = \Input::get('name');
        $menu->code = \Input::get('code');
        $menu->save();
        
        return redirect('administrator/menus')->with('success', trans('menus::admin.menus_add_success'));
    }
    
    /*
     * Edit selected menu
     */
    public function getEdit($menu_id)
    {
        $menu = Menu::find($menu_id);
        if(!$menu){
            return redirect('administrator/menus');
        }
        
        return view('Menus.Views.administrator.edit', ['menu' => $menu]);
    }
    
    public function postEdit($menu_id)
    {
        $menu = Menu::find($menu_id);
        if(!$menu) {
            return redirect('administrator/menus');
        }
        
        $rules = [
            'name' => ['required'],
            'code' => ['required']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $menu->name = \Input::get('name');
        $menu->code = \Input::get('code');
        $menu->save();
        
        return redirect('administrator/menus/edit/' . $menu_id)->with('success', trans('menus::admin.menus_edit_selected_success'));
    }
    
    /*
     * Manage menu items
     */
    public function items($menu_id)
    {
        $menu = Menu::find($menu_id);
        if(!$menu) {
            return redirect('administrator/menus');
        }
        
        // Get the items
        $items = Item::where('menu_id', '=', $menu_id)->where('parent_id', '=', NULL)->orderBy('order', 'ASC')->get();
        
        return view('Menus.Views.administrator.items', ['menu' => $menu, 'items' => $items]);
    }
    
    /*
     * Add a menu item
     */
    public function getItemAdd($menu_id){
        $menu = Menu::find($menu_id);
        if(!$menu) {
            return redirect('administrator/menus');
        }
        
        $pages = [];
        foreach(\App\Helpers\Page::getPages() as $page){
            if($page->title()){
                $class_name = get_class($page);
                $tmp = explode('\\', $class_name);
                $pages[strtolower($tmp[sizeof($tmp)-1])] = $page->title();
            }
        }

        // Get the parent items
        $parents = [0 => 'Parent item'];
        $items = Item::where('menu_id', '=', $menu_id)->where('parent_id', '=', NULL)->get();

        if($items->count()){
            $parents += $this->getChildItems($items);
        }
        
        return view('Menus.Views.administrator.item-add', ['menu' => $menu, 'parents' => $parents, 'locales' => Locale::all(), 'pages' => $pages]);
    }
    
    public function postItemAdd($menu_id){
        $menu = Menu::find($menu_id);
        if(!$menu){
            return redirect('administrator/menus');
        }
        
        $rules = [
            'parent' => ['numeric']
        ];
        
        foreach(Locale::all() as $locale)
        {
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        // Get highest order
        $order = Item::where('menu_id', '=', $menu_id)->orderBy('order', 'DESC')->take(1)->get()->first();
        if($order){
            $order = (int) $order->order + 1;
        }else{
            $order = 0;
        }
        
        // Add a new menu item
        $item = new Item;
        $item->menu_id = $menu_id;
        $item->parent_id = \Input::get('parent')?: NULL;
        $item->type = \Input::get('type');
        $item->order = $order;
        
        foreach(Locale::all() as $locale) {
            \App::setLocale($locale->language);
            $item->name = \Input::get('name-' . $locale->language);

            if(\Input::get('url-' . $locale->language)) {
                $item->url = \Input::get('url-' . $locale->language);
            }else{
                $item->url = \Input::get('name-' . $locale->language);
            }
        }
        $item->save();
        
        \App::setLocale($this->administratorLocale);
        
        // Add a custom defaults if needed
        $class_name = '\App\Pages\\' . ucfirst($item->type);
        $page = new $class_name;
        if($page->fields()){
             foreach($page->fields() as $field){                
                if($field->multilanguage){
                    foreach(Locale::all() as $locale){
                        $custom = new Custom;
                        $custom->item_id = $item->id;
                        $custom->locale = $locale->language;
                        $custom->name = $field->name;
                        $custom->value = '';
                        $custom->save();
                    }
                }else{
                    $custom = new Custom;
                    $custom->item_id = $item->id;
                    $custom->locale = $locale->language;
                    $custom->name = $field->name;
                    $custom->value = '';
                    $custom->save();
                }
            }
        }

        // Regenerate the routes
        $this->regenerateRoutes();
        
        return redirect('administrator/menus/items/' . $menu_id . '/edit/' . $item->id)->with('success', trans('menus::admin.menus_item_add_success'));
    }
    
    public function getItemEdit($menu_id, $item_id){
        $menu = Menu::find($menu_id);
        $item = Item::find($item_id);
        if(!$item || !$menu){
            return redirect('administrator/menus');
        }

        $pages = [];
        foreach(\App\Helpers\Page::getPages() as $page){
            if($page->title()){
                $class_name = get_class($page);
                $tmp = explode('\\', $class_name);
                $pages[strtolower($tmp[sizeof($tmp)-1])] = $page->title();
            }
        }
        $parents = [0 => 'Parent item'];
        $items = Item::where('menu_id', '=', $menu_id)->where('parent_id', '=', NULL)->get();
        
        $parents += $this->getChildItems($items);

        $class_name = '\App\Pages\\' . ucfirst($item->type);
        $page = new $class_name($item_id);

        return view('Menus.Views.administrator.item-edit')
            ->with('menu', $menu)
            ->with('page', $page)
            ->with('pages', $pages)
            ->with('parents', $parents)
            ->with('item', $item)
            ->with('locales', Locale::all());
    }
    
    private function getChildItems($items, $level = 0, $parent_id = NULL){        
        foreach($items as $item){
            $parents[$item->id] = str_repeat(' - ', $level) . $item->name . ' (' . $item->url . ')';
            if($item->children->count()){
                $parents += $this->getChildItems($item->children, ++$level);
                $level--;
            }
        }
        return $parents;
    }
    
    public function postItemEdit($menu_id, $item_id){        
        $item = Item::find($item_id);
        if(!$item){
            return redirect('administrator/menus');
        }

        // Get a page type
        $type = \Input::get('type');

        // if we are changing page type
        $changingType = ($item->type != $type)? true : false;

        // Check if class exists
        if(!class_exists('\App\Pages\\' . ucfirst($type))){
            return redirect('administrator/menus');
        }
        
        $class_name = '\App\Pages\\' . ucfirst($type);
        $page = new $class_name;        
        
        $rules = [
            'parent' => ['numeric']
        ];
        
        // Rules for multilanguage inputs
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        if(!$changingType){
            // Rules for custom page fields
            if($page->fields()){
                foreach($page->fields() as $field){
                    if($field->multilanguage){
                        foreach(Locale::all() as $locale){
                            $rules['field-' . $field->name . '-' . $locale->language] = $field->rules;
                        }
                    }else{
                        $rules['field-' . $field->name] = $field->rules;
                    }
                }
            }
        }
        
        $validation = \Validator::make(\Input::all(), $rules);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $item->name = \Input::get('name-' . $locale->language);
            if(\Input::get('url-' . $locale->language)){
                $item->url = \Input::get('url-' . $locale->language);
            }else{
                $item->url = \Input::get('name-' . $locale->language);
            }
        }
        
        \App::setLocale($this->administratorLocale);

        // If we dont change item type
        if(!$changingType){
            // Save custom page fields
            if($page->fields()){
                foreach($page->fields() as $field){                
                    if($field->multilanguage){
                        foreach(Locale::all() as $locale){
                            $custom = Custom::firstOrNew(['item_id' => $item->id, 'locale' => $locale->language, 'name' => $field->name]);
                            $custom->item_id = $item->id;
                            $custom->locale = $locale->language;
                            $custom->name = $field->name;
                            $custom->value = \Input::get('field-' . $field->name . '-' . $locale->language);
                            $custom->save();
                        }
                    }else{
                        $custom = Custom::firstOrNew(['item_id' => $item->id, 'locale' => NULL, 'name' => $field->name]);
                        $custom->item_id = $item->id;
                        $custom->locale = NULL;
                        $custom->name = $field->name;
                        $custom->value = \Input::get('field-' . $field->name);
                        $custom->save();
                    }
                }
            }
        }
        // let's better clear old custom values
        else{
            $item->deleteCustom();
        }
        
        $item->type = $type;
        $item->parent_id = \Input::get('parent')?: NULL;
        $item->save();
        
        // Regenerate the routes
        $this->regenerateRoutes();
        
        return redirect()->back()->with('success', trans('menus::admin.menus_item_edit_success'));
    }
    
    /**
     * Regenerate items routes
     */
    private function regenerateRoutes($parent_id = NULL)
    {
        $items = Item::where('parent_id', $parent_id)->get();

        foreach($items as $item) {
            // Do that for every locale
            foreach(Locale::all() as $locale) {
                \App::setLocale($locale->language);
                $item->route = Item::generateRoute($item->url, $locale->language, $item->parent_id);
                
            }
            $item->save();
            
            $this->regenerateRoutes($item->id);
        }

        \App::setLocale($this->administratorLocale);
    }
}
