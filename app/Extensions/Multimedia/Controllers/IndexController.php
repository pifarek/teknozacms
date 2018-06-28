<?php

namespace App\Extensions\Multimedia\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Multimedia\Models\Multimedia;
use App\Extensions\Multimedia\Models\Album;
use App\Models\Locale;

class IndexController extends BaseController
{
    /**
     * Display list of multimedia
     * @return type
     */
    public function manage($album_id = NULL)
    {
        // Get all albums
        $albums = $this->albumsArray(NULL);
        
        // Get child albums from current album
        $oneLevelAlbums = Album::where('parent_id', $album_id)->get();
        
        // Get items from current album
        $items = Multimedia::where('album_id', $album_id)->orderBy('order')->get();
        
        // Build breadcrumbs
        $breadcrumbs = $this->breadcrumbs($album_id);
        
        return view('Multimedia.Views.administrator.index', [
            'albums' => $albums,
            'oneLevelAlbums' => $oneLevelAlbums,
            'items' => $items,
            'locales' => Locale::all(),
            'album_id' => $album_id,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
    
    private function breadcrumbs($album_id)
    {
        $array = [];
        $album = Album::find($album_id);
        if(!$album){
            return $array;
        }
        $item = ['url' => url('administrator/multimedia/' . $album->id), 'title' => $album->name];
        if($album->parent_id != NULL){
            $array += $this->breadcrumbs($album->parent_id);            
        }
        
        $array[] = $item;
        
        return $array;
    }
    
    private function albumsArray($album_id = NULL, $parent_id = NULL, $level = 0)
    {
        $array = [];
        $albums = Album::where('parent_id', '=', $parent_id)->get();
        
        if($albums->count()){
            foreach($albums as $album){
                $array[$album->id] = str_repeat('- ', $level) . $album->name;
                if(!$album->parent_id) $level = 0;
                if($album->children->count()){
                    $array += $this->albumsArray($album_id, $album->id, ++$level);                
                }
            }
        }
        return $array;
    }
}
