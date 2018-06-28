<?php

namespace App\Extensions\Newsletter\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Newsletter\Models\User as NewsletterUser;
use App\Extensions\Newsletter\Models\Group as NewsletterGroup;

class GroupsController extends BaseController
{
    /**
     * Display list of groups
     * @return type
     */
    public function index()
    {
        // Get newsletter groups
        $groups = NewsletterGroup::all();
        
        return view('Newsletter.Views.administrator.groups', ['groups' => $groups]);
    }
    
    /**
     * Add a new newsletter group
     * @return type
     */
    public function create()
    {
        return view('Newsletter.Views.administrator.group-add');
    }
    
    public function store()
    {
        $rules = [
            'name' => ['required']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $group = new NewsletterGroup;
        $group->name = \Input::get('name');
        $group->save();
        
        return redirect('administrator/newsletter/groups/' . $group->id . '/edit')->with('success', trans('newsletter::admin.msg_group_added'));
    }
    
    /**
     * Edit a newsletter group
     * @return type
     */
    public function edit($group_id)
    {
        $group = NewsletterGroup::find($group_id);
        if(!$group){
            return redirect('administrator/newsletter/groups');
        }
        
        return view('Newsletter.Views.administrator.group-edit', ['group' => $group]);
    }
    
    public function update($group_id)
    {
        $group = NewsletterGroup::find($group_id);
        if(!$group){
            return redirect('administrator/newsletter/groups');
        }
        
        $rules = [
            'name' => ['required']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $group->name = \Input::get('name');
        $group->save();
        
        return redirect('administrator/newsletter/groups/')->with('success', trans('newsletter::admin.msg_group_updated'));
    }
}
