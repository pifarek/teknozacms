<?php

namespace App\Extensions\Projects\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Projects\Models\Project;
use App\Extensions\Projects\Models\Tag;
use App\Models\Locale;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    
    /**
     * Display list of projects
     * @return type
     */
    public function index()
    {
        // Get the projects
        $projects = Project::orderBy('year', 'desc')->orderBy('id', 'desc')->get();
        
        return view('Projects.Views.administrator.index', ['projects' => $projects]);
    }
    
    /**
     * Add a new project
     * @return view
     */
    public function create()
    {
        return view('Projects.Views.administrator.add', ['locales' => Locale::all()]);
    }
    
    public function store(Request $request)
    {
        $rules = [

        ];
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $project = new Project;
        
        foreach(Locale::all() as $locale) {
            \App::setLocale($locale->language);
            $project->name = $request->get('name-' . $locale->language);
            $project->description = $request->get('description-' . $locale->language);
        }
        
        $project->year = $request->get('year');
        $project->save();

        \App::setLocale($this->administratorLocale);
        
        return redirect('administrator/projects/' . $project->id . '/edit')->with('success', trans('projects::admin.projects_msg_added'));
    }

    /**
     * Update selected project
     * @param $project_id
     * @return View
     */
    public function edit($project_id)
    {
        $project = Project::find($project_id);
        if(!$project) {
            return redirect('administrator/projects');
        }
        
        // Get the tags
        $tags = Tag::all();

        $partnersExtensionEnabled = class_exists('\App\Extensions\Partners\Controllers\IndexController');

        $partners = collect();

        if($partnersExtensionEnabled) {
            // Get the partners
            $partners = \App\Extensions\Partners\Models\Partner::pluck('name', 'id')->toArray();
        }
        
        return view('Projects.Views.administrator.edit', [
            'locales' => Locale::all(),
            'project' => $project,
            'tags' => $tags,
            'partners' => $partners,
            'partnersExtensionEnabled' => $partnersExtensionEnabled
        ]);
    }
    
    public function update(Request $request, $project_id)
    {
        $project = Project::find($project_id);
        if(!$project){
            return redirect('administrator/projects');
        }
        
        $rules = [
            'partner' => ['numeric']
        ];
        
        foreach(Locale::all() as $locale){
            $rules['name-' . $locale->language] = ['required'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $project->name = $request->get('name-' . $locale->language);
            $project->description = $request->get('description-' . $locale->language);
        }
        
        // First remove all tags
        $project->tags()->detach();
        
        $project->tags()->attach($request->get('tags'));
        
        $project->year = $request->get('year');
        $project->partner_id = $request->get('partner')?: NULL;
        $project->save();

        \App::setLocale($this->administratorLocale);
        
        return redirect('administrator/projects')->with('success', trans('projects::admin.projects_msg_updated'));
    }
}
