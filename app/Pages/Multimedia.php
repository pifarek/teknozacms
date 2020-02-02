<?php
namespace App\Pages;

use App\Models\Multimedia\Album;
use App\Models\Multimedia\Multimedia as MultimediaModel;
use Illuminate\Http\Request;

class Multimedia extends Main
{
    public function __construct($item_id = null)
    {
        $this->title = 'Multimedia';
        parent::__construct($item_id);
        $this->shortcut = ['name' => 'View Multimedia', 'url' => url('administrator/multimedia')];
    }  
    
    public function logic(Request $request)
    {
        $type = $this->getCustom('display');
        $album_id = $this->getCustom('album')?: NULL;
        
        $params = $this->params();
        if($params[0]){
            $album_id = (int) $params[0];
        }

        $query = MultimediaModel::select();

        $query->where('album_id', '=', $album_id)->orderBy('order', 'asc');

        if(false !== in_array($type, ['video', 'image'])){
            $items = $query->where('type', '=', $type)->get();
        }else{
            $items = $query->get();
        }

        // Get the children albums
        $albums = Album::where('parent_id', '=', $album_id)->get();

        return view('page.pages.multimedia')->with([
            'items' => $items,
            'albums' => $albums,
            'page_url' => $this->url()
        ]);
    }
    
    public function fields()
    {
        return [
            (object) [
                'label' => 'Display',
                'name' => 'display',
                'type' => 'select',
                'multilanguage' => false,
                'rules' => ['required'],
                'options' => [
                    'both' => 'Images and Videos',
                    'video' => 'Videos',
                    'images' => 'Images',
                ]
            ],
            (object) [
                'label' => 'Album',
                'name' => 'album',
                'type' => 'select',
                'multilanguage' => false,
                'rules' => ['required'],
                'options' => [0 => 'Display all'] + $this->getAlbums()
            ],
        ];
    }
    
    private function getAlbums($parent_id = NULL, $level = 0)
    {
        $tmp = [];
        
        $albums = Album::where('parent_id', '=', $parent_id)->get();
        foreach($albums as $album){
            $tmp[$album->id] = str_repeat(' - ', $level) . $album->name;
            if($album->children->count()){
                $tmp += $this->getAlbums($album->id, ++$level);
                $level--;
            }
        }
        return $tmp;
    }
}
