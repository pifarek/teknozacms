<?php
namespace App\Modules;
use App\Models\Multimedia\Multimedia;

/**
 * Display latest videos
 */
class Videos extends Module{
    protected $view = 'page.modules.videos';
    
    public function logic() {
        $videos = Multimedia::where('type', '=', 'video')->get();

        return [
            'videos' => $videos
        ];
    }
}