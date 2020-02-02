<?php

namespace App\Extensions\News\Controllers;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\News\Models\News;
use App\Extensions\News\Models\Category;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JsonController extends BaseController
{
    /**
     * Remove selected news
     * @param Request $request
     * @param int $news_id
     * @return type
     */
    public function remove(Request $request, $news_id)
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
     * @param Request $request
     * @param int $news_id
     * @return JsonResponse
     */
    public function imageUpload(Request $request, $news_id)
    {
        $news = News::find($news_id);
        
        if(!$news) {
            return response()->json(['status' => 'err']);
        }
        
        $image = $request->file('image');
        
        $rules = [
            'image' => ['required', 'image']
        ];
        
        $validation = \Validator::make(['image' => $image], $rules);

        if($validation->fails()) {
            return response()->json(['status' => 'err', 'errors' => $validation->errors()]);
        }

        $filename = uniqid(null, true) . '.jpg';

        \Image::make($image->getRealPath())->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('upload/news/s/' . $filename);

        \Image::make($image->getRealPath())->fit(1200, 400)->save('upload/news/n/' . $filename);

        $news->filename = $filename;
        $news->save();
        return response()->json(['status' => 'ok', 'filename' => $filename]);
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
