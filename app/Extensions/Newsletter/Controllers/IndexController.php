<?php

namespace App\Extensions\Newsletter\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Newsletter\Models\User as NewsletterUser;
use App\Extensions\Newsletter\Models\Group as NewsletterGroup;

class IndexController extends BaseController
{
    /**
     * Display list of email
     * @return type
     */
    public function index()
    {
        // Get newsletter emails
        $emails = NewsletterUser::all();
        
        return view('Newsletter.Views.administrator.index', ['emails' => $emails]);
    }
    
    /**
     * Add a new newsletter
     * @return type
     */
    public function create()
    {
        // Get newsletter groups
        $groups = NewsletterGroup::pluck('name', 'id')->toArray();
        
        return view('Newsletter.Views.administrator.add', ['groups' => $groups]);
    }
    
    public function store()
    {
        $rules = [
            'email' => ['required', 'email']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $newsletter = new NewsletterUser;
        $newsletter->email = \Input::get('email');
        $newsletter->group_id = \Input::get('group')? \Input::get('group') : NULL;
        $newsletter->save();
        
        return redirect('administrator/newsletter')->with('success', trans('newsletter::admin.msg_added'));
    }
    
    /**
     * Display edit form for selected user
     * @param int $newsletter_id
     * @return view
     */
    public function edit($newsletter_id)
    {
        $newsletter = NewsletterUser::find($newsletter_id);
        if(!$newsletter){
            return redirect('administrator/newsletter');
        }
        
        // Get newsletter groups
        $groups = NewsletterGroup::pluck('name', 'id')->toArray();
        
        return view('Newsletter.Views.administrator.edit', ['newsletter' => $newsletter, 'groups' => $groups]);
    }
    
    public function update($newsletter_id)
    {
        $newsletter = NewsletterUser::find($newsletter_id);
        if(!$newsletter){
            return redirect('administrator/newsletter');
        }
        
        $rules = [
            'email' => ['required', 'email']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $newsletter->email = \Input::get('email');
        $newsletter->group_id = \Input::get('group')? \Input::get('group') : NULL;
        $newsletter->save();
        
        return redirect('administrator/newsletter')->with('success', trans('newsletter::admin.msg_updated'));
    }
    
    /**
     * Display list of newsletters groups
     * @return type
     */
    public function getGroups(){
        // Get newsletter emails
        $groups = NewsletterGroup::all();
        
        return view('Newsletter.Views.administrator.groups')->with([
            'groups' => $groups
        ]);
    }
    
    /**
     * Add a new newsletter group
     * @return type
     */
    public function getGroupAdd(){
        return view('Newsletter.Views.administrator.group-add');
    }
    
    public function postGroupAdd(){
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
        
        return redirect('administrator/newsletter/group-edit/' . $group->id)->with('success', trans('newsletter::admin.msg_group_added'));
    }
    
    /**
     * Edit a newsletter group
     * @return type
     */
    public function getGroupEdit($group_id){
        $group = NewsletterGroup::find($group_id);
        if(!$group){
            return redirect('administrator/newsletter/groups');
        }
        
        return view('Newsletter.Views.administrator.group-edit')->with([
            'group' => $group
        ]);
    }
    
    public function postGroupEdit($group_id){
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
        
        return redirect('administrator/newsletter/group-edit/' . $group->id)->with('success', trans('newsletter::admin.msg_group_updated'));
    }
}
