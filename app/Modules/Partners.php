<?php
namespace App\Modules;
use App\Models\Partners\Partner;

/**
 * Display posters
 */
class Partners extends Module{
    protected $view = 'page.modules.partners';
    
    public function logic() {
        
        $partners = Partner::orderBy('order')->get();
        
        return [
            'partners' => $partners
        ];
    }
}