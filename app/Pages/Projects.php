<?php
namespace App\Pages;

use App\Models\Projects\Project as ProjectModel;
use App\Models\Projects\Tag;

/**
 * Display Projects list and single Project
 */
class Projects extends Main{    
    public function __construct($item_id = null){
        $this->title = 'Projects';
        
        parent::__construct($item_id);
    }   
    
    public function logic(){
        $params = $this->params();
        $project_id = $params[0];
        if($project_id){
            
            $project = ProjectModel::find($project_id);
            if(!$project){
                return redirect('/');
            }
            
            // Get next project
            $nextProject = ProjectModel::where('id', '>', $project->id)->get()->first();
            
            // Get previous project
            $previousProject = ProjectModel::where('id', '<', $project->id)->get()->first();
            
            return view('page.pages.projects')->with([
                'display' => 'single',
                'project' => $project,
                'next' => $nextProject,
                'prev' => $previousProject
            ]);
        }else{
            // Get tags
            $tags = Tag::all();
            
            // Get projects
            $projects = ProjectModel::all();
            
            return view('page.pages.projects')->with([
                'display' => 'list',
                'projects' => $projects,
                'tags' => $tags
            ]);
            
        }
    }
}