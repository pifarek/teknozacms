<?php
namespace App\Pages;

use App\Extensions\Partners\Models\Partner as PartnerModel;
use Illuminate\Http\Request;

/**
 * Display Projects list and single Project
 */
class Partners extends Main
{
    public function __construct($item_id = null)
    {
        $this->title = 'Partners';
        parent::__construct($item_id);
    }   
    
    public function logic(Request $request)
    {
        // Get projects
        $partners = PartnerModel::all();

        return view('page.pages.partners', [
            'partners' => $partners
        ]);
    }
}
