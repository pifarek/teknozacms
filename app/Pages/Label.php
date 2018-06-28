<?php
namespace App\Pages;

class Label extends Main{    
    public function __construct(){
        $this->title = 'Label';
    }
    
    public function logic(){
        return redirect('/');
    }
}