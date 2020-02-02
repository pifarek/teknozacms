<?php

namespace App\Extensions\Partners\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Partners\Models\Partner;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    
    /**
     * Get list of partners
     */
    public function index()
    {
        // Get partners
        $partners = Partner::orderBy('order')->get();
        
        return view('Partners.Views.administrator.index', ['partners' => $partners]);
    }
    
    /**
     * Add a new partner
     */
    public function create()
    {
        return view('Partners.Views.administrator.add');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required']
        ];
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $partner = new Partner;
        $partner->name = $request->get('name');
        $partner->save();
        
        return redirect('administrator/partners/' . $partner->id . '/edit')->with('success', __('partners::admin.partners_msg_added'));
    }
    
    /**
     * Edit a selected partner
     */
    public function edit($partner_id)
    {
        $partner = Partner::find($partner_id);
        if(!$partner) {
            return redirect('administrator/partners');
        }
        
        return view('Partners.Views.administrator.edit', ['partner' => $partner]);
    }
    
    public function update(Request $request, $partner_id)
    {
        $partner = Partner::find($partner_id);
        if(!$partner){
            return redirect('administrator/partners');
        }
        
        $rules = [
            'name' => ['required']
        ];
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $partner->name = $request->get('name');
        $partner->url = $request->get('url');
        $partner->save();
        
        return redirect('administrator/partners')->with('success', __('partners::admin.partners_msg_updated'));
    }
}
