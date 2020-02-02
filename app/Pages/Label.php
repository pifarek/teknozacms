<?php
namespace App\Pages;

use Illuminate\Http\Request;

class Label extends Main{
    public function __construct(){
        $this->title = 'Label';
    }
    
    public function logic(Request $request){
        return redirect('/');
    }
}
