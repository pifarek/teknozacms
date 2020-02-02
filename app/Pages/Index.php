<?php
namespace App\Pages;

use Illuminate\Http\Request;

/**
 * Display homepage
 */
class Index extends Main
{
    public function __construct()
    {
        $this->title = 'Home';
        $this->type('index');
        parent::__construct();
    }
    
    public function logic(Request $request)
    {
        return view('page.pages.index');
    }
}
