<?php

namespace App\Extensions\Menus\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Menus\Models\Menu;
use App\Extensions\Menus\Models\Item;
use Illuminate\Http\Request;

class JsonController extends BaseController
{
    /*
     * Remove selected menu
     */
    public function remove($menu_id)
    {
        $menu = Menu::find($menu_id);
        if($menu)
        {
            $menu->delete();
        }
        
        \Session::flash('success', trans('menus::admin.menus_msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Remove selected item
     * @param int $item_id
     */
    public function itemRemove($menu_id, $item_id) {
        $item = Item::find($item_id);
        if($item){
            $item->delete();
        }
        
        \Session::flash('success', trans('menus::admin.menus_item_msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Upload item intro image
     * @param int $item_id
     * @return json
     */
    public function postItemIntroImage(Request $request, $item_id){
        $item = Item::find($item_id);
        if(!$item){
            return response()->json(['status' => 'err']);
        }
        
        $image = $request->file('image');
        
        $rules = [
            'image' => ['required', 'image']
        ];
        
        $validation = \Validator::make(['image' => $image], $rules);
        
        if($validation->passes()){
            $filename = uniqid(null, true) . '.jpg';
        
            \Image::make($image->getRealPath())->fit(1200, 400)->save('upload/menus/' . $filename);
            
            if($item->image){
                @unlink('upload/menus/' . $item->image);
            }
            
            $item->image = $filename;
            $item->save();
            return response()->json(['status' => 'ok', 'filename' => $filename]);
        }        
        return response()->json(['status' => 'err']);
    }
    
    public function getItemRemoveIntroImage($item_id){
        $item = Item::find($item_id);
        if(!$item){
            return response()->json(['status' => 'err']);
        }
        
        if($item->image){
            @unlink('upload/menus/' . $item->image);
        }
            
        $item->image = NULL;
        $item->save();
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Move menu item in a selected direction
     * @param string $direction
     * @param int $item_id
     * @return json
     */
    public function itemMove($menu_id, $direction, $item_id)
    {
        $item = Item::find($item_id);
        if(!$item && false === in_array($direction, ['up', 'down'])){
            return response()->json(['status' => 'err']);
        }
        
        $item->move($direction);
        
        return response()->json(['status' => 'ok']);
    }
    
    public function pageShortcut($type)
    {
        $shortcut = \App\Helpers\Page::shortcut($type);
        if($shortcut){
            return response()->json(['status' => 'ok', 'shortcut' => $shortcut]);
        }
        return response()->json(['status' => 'empty']);
    }
}
