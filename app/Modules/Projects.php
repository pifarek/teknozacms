<?php
namespace App\Modules;
use App\Models\Projects\Project;
use App\Models\Projects\Tag;

/**
 * Display projects
 */
class Projects extends Module{
    protected $view = 'page.modules.projects';
    
    public function logic() {
        $tags = Tag::all();
        $projects = Project::limit(6)->get();
        
        return [
            'projects' => $projects,
            'tags' => $tags
        ];
    }
}