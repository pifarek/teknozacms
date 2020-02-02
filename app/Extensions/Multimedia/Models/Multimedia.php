<?php

namespace App\Extensions\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Multimedia extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'multimedia';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $translatedAttributes = ['name', 'description'];
    
    public function album()
    {
        return $this->hasOne(Album::class, 'id', 'album_id');
    }
    
    public function image()
    {
        return $this->hasOne(Image::class);
    }
    
    public function video()
    {
        return $this->hasOne(Video::class);
    }
    
    public function isVideo()
    {
        return $this->type == 'video'? true : false;
    }
    
    public function isImage()
    {
        return $this->type == 'image'? true : false;
    }
    
    public function delete()
    {
        if($this->isImage())
        {
            @unlink('upload/multimedia/' . $this->image->filename);
        }
        elseif($this->isVideo())
        {
            @unlink('upload/multimedia/' . $this->video->filename);
        }
        parent::delete();
    }
    
    public function videoType(){
        return Multimedia::checkVideoType($this->video->url);
    }
    
    public static function checkVideoType($url = false){
        if(!$url){
            $url = self::$video->url;
        }
        
        $patterns = array(
            array(
                'pattern' => '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                'type' => 'youtube'
            )
        );
        
        foreach($patterns as $pattern)
        {
            preg_match_all($pattern["pattern"], $url, $matches);
            if(!empty($matches[1]))
            {
                return array(
                    'type' => $pattern["type"],
                    'code' => $matches[1][0]
                );
            }
        }
        return false;
    }
    
    public function thumbnail()
    {
        if($this->isImage()){
            return $this->image->filename;
        }
        if($this->isVideo()){
            return $this->video->filename;
        }
        return false;
    }
}
