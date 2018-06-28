<?php
namespace App\Pages;

/**
 * Display homepage
 */
class Index extends Main{
    public function __construct(){
        $this->title = 'Home';
        $this->type('index');
        $this->title(false);
    }
    
    public function logic(){
        return view('page.pages.index');
    }
}