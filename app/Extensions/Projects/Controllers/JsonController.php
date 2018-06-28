<?php

namespace App\Extensions\Projects\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Projects\Models\Project;
use App\Extensions\Projects\Models\Tag;
use App\Extensions\Projects\Models\Image;

class JsonController extends BaseController
{
    /*
     * Remove selected project
     */
    public function remove($project_id)
    {
        $project = Project::find($project_id);
        if($project){
            $project->delete();
        }
        
        \Session::flash('success', __('projects::admin.projects_msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /*
     * Upload project cover
     */
    public function cover($project_id)
    {
        $project = Project::find($project_id);
        if(!empty($_FILES['image']['tmp_name']) && $project){
            $filename = uniqid(null, true) . '.jpg';
        
            \Image::make($_FILES['image']['tmp_name'])->fit(1200, 400)->save('upload/projects/covers/' . $filename);
            
            if($project->filename){
                @unlink('upload/projects/covers/' . $project->filename);
            }
            
            $project->filename = $filename;
            $project->save();
            
            return response()->json(['status' => 'ok', 'filename' => $filename]);
        }
        return response()->json(['status' => 'err']);
    }
    
    /*
     * Remove project cover
     */
    public function coverRemove($project_id)
    {
        $project = Project::find($project_id);
        if($project){
            @unlink('upload/projects/covers/' . $project->filename);
            $project->filename = '';
            $project->save();
            return response()->json(['status' => 'ok']);
        }
        return response()->json(['status' => 'err']);
    }
    
    /*
     * Upload project image
     */
    public function image($project_id)
    {
        $project = Project::find($project_id);
        if(!empty($_FILES['image']['tmp_name']) && $project){
            $filename = uniqid(null, true) . '.jpg';
        
            \Image::make($_FILES['image']['tmp_name'])->fit(1280, 1024)->save('upload/projects/' . $filename);
            
            if($project->filename){
                @unlink('upload/projects/' . $project->filename);
            }
            
            $image = new Image;
            $image->project_id = $project_id;
            $image->filename = $filename;
            $image->save();
            
            return response()->json(['status' => 'ok', 'filename' => $filename, 'image_id' => $image->id]);
        }
        return response()->json(['status' => 'err']);
    }
    
    /*
     * Remove project image
     */
    public function imageRemove($image_id)
    {
        $image = Image::find($image_id);
        if($image){
            $image->delete();
            return response()->json(['status' => 'ok']);
        }
        return response()->json(['status' => 'err']);
    }
    
    /*
     * Remove selected project tag
     */
    public function tagRemove($tag_id)
    {
        $tag = Tag::find($tag_id);
        if($tag){
            $tag->delete();
        }
        
        \Session::flash('success', __('projects::admin.projects_msg_tag_removed'));
        
        return response()->json(['status' => 'ok']);
    }
}
