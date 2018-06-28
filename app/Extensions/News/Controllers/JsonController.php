<?php

namespace App\Extensions\News\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\News\Models\News;
use App\Extensions\News\Models\Category;

class JsonController extends BaseController
{
    /**
     * Remove selected news
     * @param int $category_id
     * @return type
     */
    public function remove($news_id)
    {
        $news = News::find($news_id);
        
        if($news){
            $news->delete();
        }
        
        \Session::flash('success', __('news::admin.msg_removed'));
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove selected category
     * @param type $category_id
     * @return type
     */
    public function categoryRemove($category_id)
    {
        $category = Category::find($category_id);
        if($category) {
            $category->delete();
        }
        
        \Session::flash('success', __('news::admin.msg_category_removed'));
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Upload news image
     */
    public function imageUpload($news_id) {
        $news = News::find($news_id);
        
        if(!$news) {
            return response()->json(['status' => 'err']);
        }
        
        $image = \Input::file('image');
        
        $rules = [
            'image' => ['required', 'image']
        ];
        
        $validation = \Validator::make(['image' => $image], $rules);
        
        if($validation->passes()) {
            $filename = uniqid(null, true) . '.jpg';
        
            \Image::make($image->getRealPath())->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('upload/news/s/' . $filename);

            \Image::make($image->getRealPath())->fit(1200, 400)->save('upload/news/n/' . $filename);
            
            $news->filename = $filename;
            $news->save();
            return response()->json(['status' => 'ok', 'filename' => $filename]);
        }        
        return response()->json(['status' => 'err']);
    }
    
    public function imageRemove($news_id)
    {
        $news = News::find($news_id);
        
        if(!$news) {
            return response()->json(['status' => 'err']);
        }
        
        if($news->filename) {
            @unlink('upload/news/s/' . $news->filename);
            @unlink('upload/news/n/' . $news->filename);
            $news->filename = '';
            $news->save();
        }
        
        return response()->json(['status' => 'ok']);
    }
}
