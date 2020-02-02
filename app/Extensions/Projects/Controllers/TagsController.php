<?php

namespace App\Extensions\Projects\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Projects\Models\Tag;
use App\Models\Locale;
use Illuminate\Http\Request;

class TagsController extends BaseController
{
    
    /**
     * Get projects tags
     */
    public function index()
    {
        // Get tags
        $tags = Tag::all();
        
        return view('Projects.Views.administrator.tags', ['tags' => $tags]);
    }
    
    /**
     * Add a new project tag
     */
    public function create()
    {
        return view('Projects.Views.administrator.tag-add', ['locales' => Locale::all()]);
    }
    
    public function store(Request $request)
    {
        $rules = [];
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $tag = new Tag;
        
        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $tag->name = $request->get('name-' . $locale->language);
        }
        
        $tag->save();
        
        return redirect('administrator/projects/tags')->with('success', trans('projects::admin.projects_msg_tag_added'));
    }
    
    /**
     * Edit selected project tag
     * @param int $tag_id
     */
    public function edit($tag_id)
    {
        $tag = Tag::find($tag_id);
        if(!$tag){
            return redirect('administrator/projects/tags');
        }
        
        return view('Projects.Views.administrator.tag-edit', [
            'tag' => $tag,
            'locales' => Locale::all()
        ]);
    }
    
    public function update(Request $request, $tag_id)
    {
        $tag = Tag::find($tag_id);
        if(!$tag){
            return redirect('administrator/projects/tags');
        }
        
        $rules = [];
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $tag->name = $request->get('name-' . $locale->language);
        }
        
        $tag->save();
        
        return redirect('administrator/projects/tags')->with('success', trans('projects::admin.projects_msg_tag_updated'));
    }
}
