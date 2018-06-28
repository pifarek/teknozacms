<?php

namespace App\Extensions\Multimedia\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Multimedia\Models\Album;
use App\Extensions\Multimedia\Models\Multimedia;
use App\Extensions\Multimedia\Models\Image;
use App\Extensions\Multimedia\Models\Video;
use App\Models\Locale;

class JsonController extends BaseController
{

    /**
     * Upload temporary image
     * @return type
     */
    public function imageUpload()
    {
        $rules = [
            'image' => ['required', 'mimes:jpeg,jpg,png', 'max:10000']
        ];
        
        $validation = \Validator::make(['image' => \Input::file('image')], $rules);
        
        if($validation->fails()){
            return response()->json(['status' => 'err', 'errors' => $validation->errors()->toArray()]);
        }
        
        $filename = uniqid(null, true) . '.jpg';

        \Image::make(\Input::file('image'))->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('upload/tmp/' . $filename);
        
        return response()->json(['status' => 'ok', 'filename' => $filename]);
    }
    
    public function add()
    {
        switch(\Input::get('type')){
            case 'image':
                $rules = [
                    'image-filename' => ['required'],
                    'album' => ['required', 'numeric']
                ];

                foreach(Locale::all() as $locale){
                    $rules['name-' . $locale->language] = ['required'];
                }

                $validation = \Validator::make(\Input::all(), $rules);

                if($validation->fails()){
                    return response()->json(['status' => 'err', 'errors' => $validation->errors()->toArray()]);
                }

                $filename = uniqid(null, true) . '.jpg';

                \File::copy('upload/tmp/' . \Input::get('image-filename'), 'upload/multimedia/' . $filename);
                
                $order = 0;
                $last_item = Multimedia::orderBy('order', 'DESC')->limit(1)->get()->first();
                if($last_item){
                    $order = $last_item->order;
                }
                
                $multimedia = new Multimedia;
                $multimedia->order = $order;
                $multimedia->type = 'image';
                $multimedia->featured = 0;
                $multimedia->album_id = \Input::get('album')?: NULL;

                foreach(Locale::all() as $locale){
                    \App::setLocale($locale->language);
                    $multimedia->name = \Input::get('name-'. $locale->language);
                    $multimedia->description = \Input::get('description-'. $locale->language);
                }

                $multimedia->save();
                
                $image = new Image;
                $image->filename = $filename;
                $image->multimedia_id = $multimedia->id;
                $image->save();

                // Remove image from tmp
                \File::delete('upload/tmp/' . \Input::get('image-filename'));
                
                \App::setLocale($this->administratorLocale);
                
                $view = view('Multimedia.Views.administrator.partial.item', ['item' => $multimedia]);
                
                return response()->json(['status' => 'ok', 'item_id' => $multimedia->id, 'view' => $view->render()]);
            case 'video':
                $rules = [
                    'url' => ['required', 'video'],
                    'album' => ['required', 'numeric']
                ];

                foreach(Locale::all() as $locale){
                    $rules['name-' . $locale->language] = ['required'];
                }

                $validation = \Validator::make(\Input::all(), $rules);

                if($validation->fails()){
                    return response()->json(['status' => 'err', 'errors' => $validation->errors()->toArray()]);
                }

                $movie = Multimedia::checkVideoType(\Input::get('url'));
                $filename = 'video.jpg';
                if($movie['type'] === 'youtube'){
                    $image = @file_get_contents('http://img.youtube.com/vi/' . $movie['code'] . '/0.jpg');
                    if($image){
                        // Save Image
                        $filename = uniqid(null, true) . '.jpg';
                        file_put_contents('upload/multimedia/' . $filename, $image);
                    }
                }
               
                $order = 0;
                $last_item = Multimedia::orderBy('order', 'DESC')->limit(1)->get()->first();
                if($last_item){
                    $order = $last_item->order;
                }
                
                $multimedia = new Multimedia;
                $multimedia->order = $order;
                $multimedia->type = 'video';
                $multimedia->featured = 0;
                $multimedia->album_id = \Input::get('album')?: NULL;

                foreach(Locale::all() as $locale){
                    \App::setLocale($locale->language);
                    $multimedia->name = \Input::get('name-'. $locale->language);
                    $multimedia->description = \Input::get('description-'. $locale->language);
                }

                $multimedia->save();
                
                $video = new Video;
                $video->url = \Input::get('url');
                $video->multimedia_id = $multimedia->id;
                $video->filename = $filename;
                $video->save();

                \App::setLocale($this->administratorLocale);
                
                $view = view('Multimedia.Views.administrator.partial.item', ['item' => $multimedia]);
                
                return response()->json(['status' => 'ok', 'item_id' => $multimedia->id, 'view' => $view->render()]);
        }
    }
    
    /**
     * Get multimedia item
     * @param int $multimedia_id
     */
    public function multimedia($multimedia_id)
    {
        $multimedia = Multimedia::find($multimedia_id);
        if(!$multimedia) {
            return response()->json(['status' => 'err']);
        }
        
        $array = [
            'album' => $multimedia->album_id?: 0
        ];
        
        foreach(Locale::all() as $locale) {
            $array['name-' . $locale->language] = $multimedia->translate($locale->language)->name;
            $array['description-' . $locale->language] = $multimedia->translate($locale->language)->description;
        }
        
        return response()->json(['status' => 'ok', 'multimedia' => $array]);
    }
    
    /**
     * Get multimedia album
     * @param int $album_id
     */
    public function album($album_id)
    {
        $album = Album::find($album_id);
        if(!$album) {
            return response()->json(['status' => 'err']);
        }
        
        $array = [
            'parent' => $album->parent_id?: 0
        ];
        
        foreach(Locale::all() as $locale) {
            $array['name-' . $locale->language] = $album->translate($locale->language)->name;
        }
        
        return response()->json(['status' => 'ok', 'album' => $array]);
    }
    
    /**
     * Edit multimedia item
     * @param int $multimedia_id
     * @return json
     */
    public function edit($multimedia_id){
        $multimedia = Multimedia::find($multimedia_id);
        if(!$multimedia){
            return response()->json(['status' => 'err']);
        }
        
        $rules = [
            'album' => ['required', 'numeric']
        ];

        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }

        $validation = \Validator::make(\Input::all(), $rules);

        if($validation->fails()){
            return response()->json(['status' => 'err', 'errors' => $validation->errors()->toArray()]);
        }
        
        $multimedia->album_id = \Input::get('album')?: NULL;
        
        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $multimedia->name = \Input::get('name-'. $locale->language);
            $multimedia->description = \Input::get('description-'. $locale->language);
        }
        
        $multimedia->save();
        
        \App::setLocale($this->administratorLocale);
                
        $view = view('Multimedia.Views.administrator.partial.item', ['item' => $multimedia]);
                
        return response()->json(['status' => 'ok', 'item_id' => $multimedia->id, 'view' => $view->render()]);
    }
    
    public function albumEdit($album_id)
    {
        $album = Album::find($album_id);
        if(!$album){
            return response()->json(['status' => 'err']);
        }
        
        $rules = [
            'parent' => ['required', 'numeric']
        ];

        foreach(Locale::all() as $locale) {
            $rules['name-' . $locale->language] = ['required'];
        }

        $validation = \Validator::make(\Input::all(), $rules);

        if($validation->fails()) {
            return response()->json(['status' => 'err', 'errors' => $validation->errors()->toArray()]);
        }
        
        $album->parent_id = \Input::get('parent')?: NULL;
        
        foreach(Locale::all() as $locale) {
            \App::setLocale($locale->language);
            $album->name = \Input::get('name-'. $locale->language);
        }
        
        $album->save();
        
        \App::setLocale($this->administratorLocale);
                
        $view = view('Multimedia.Views.administrator.partial.album', ['album' => $album]);
                
        return response()->json(['status' => 'ok', 'album_id' => $album->id, 'view' => $view->render()]);
    }
    
    public function albumAdd()
    {
        $rules = [
            'parent' => ['numeric']
        ];
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return response()->json(['status' => 'err', 'errors' => $validation->errors()->toArray()]);
        }
        
        $album = new Album;
        
        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $album->name = \Input::get('name-' . $locale->language);
        }
        
        $album->parent_id = \Input::get('parent')?: NULL;
        $album->save();
        
        \App::setLocale($this->administratorLocale);
        
        $view = view('Multimedia.Views.administrator.partial.album', ['album' => $album]);
                
        return response()->json(['status' => 'ok', 'album_id' => $album->id, 'view' => $view->render()]);
    }

    /*
     * Remove selected album
     */
    public function multimediaRemove($album_id)
    {
        if(Multimedia::find($album_id)){
            Multimedia::find($album_id)->delete();
        }
        
        return response()->json(['status' => 'ok']);
    }    
    
    /*
     * Remove selected album
     */
    public function albumRemove($album_id)
    {
        if($album = Album::find($album_id)) {
            $children = $this->albumChildren($album_id);

            if(sizeof($children)) {
                // Remove children items
                foreach($children as $child){
                    if($child->multimedia->count()) {
                        foreach($child->multimedia as $item) {
                            $item->delete();
                        }
                    }
                    $child->delete();
                }
            }            
            $album->delete();
        }
        return response()->json(['status' => 'ok']);
    }
    
    private function albumChildren($parent_id = NULL)
    {
        $array = [];
        $albums = Album::where('parent_id', '=', $parent_id)->get();
        if($albums->count()) {
            foreach($albums as $album){
                $array[] = $album;
                if($album->children->count()){
                    $array = array_merge($array, $this->albumChildren($album->id));                
                }
            }
        }
        
        return $array;
    }
    
    /**
     * Change the items order
     * @return type
     */
    public function order()
    {
        $ids = \Input::get('ids');
        if(!$ids){
            return response()->json(['status' => 'err']);
        }
        
        $order = 0;
        foreach($ids as $id){
            $item = Multimedia::find($id);
            if($item){
                $item->order = $order;
                $item->save();
            }
            $order++;
        }
        
        return response()->json(['status' => 'ok']);
    }
}
