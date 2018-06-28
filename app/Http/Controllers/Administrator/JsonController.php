<?php
namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Administrator\BaseController;
use App\Models\User;
use App\Models\Locale;
use App\Models\Multimedia\Multimedia;
use App\Models\Multimedia\Image;
use Illuminate\Http\Request;

class JsonController extends BaseController
{
    /**
     * Set the fullscreen option
     */
    public function fullscreen(Request $request)
    {
        $fullscreen = $request->get('fullscreen');

        if($fullscreen) {
            $cookie = \Cookie::forever('fullscreen', true);
            return response()->json(['status' => 'ok'])->withCookie($cookie);
        }

        $cookie = \Cookie::forget('fullscreen');
        return response()->json(['status' => 'ok'])->withCookie($cookie);
    }
    
    /*
     * Send email and store in the DB
     */
    public function getMessage(){
        $rules = [
            'address' => ['required', 'email', 'exists:users,email'],
            'subject' => ['required'],
            'message' => ['required'],
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return response()->json(['status' => 'err']);
        }
        
        $user = User::where('email', '=', \Input::get('address'))->get()->first();
        
        $email = new Email;
        $email->user_id = $user->id;
        $email->subject = \Input::get('subject');
        $email->message = \Input::get('message');
        $email->save();
        
        \Mail::send('email.template', ['content' => \Input::get('message')], function($mail) use ($user){
            $mail->to($user->email)->subject(\Input::get('subject'));
        });
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Display list of multimedia images
     * @return response
     */
    public function getFileUpload(){        
        $album_id = \Input::get('album_id')?: NULL;

        if($album_id){
            // Get images from the selected category
            $images = Multimedia::where('type', '=', 'image')->orderBy('id', 'desc')->where('album_id', '=', $album_id)->get();
        }else{
            // or get the latest images
            $images = Multimedia::where('type', '=', 'image')->orderBy('id', 'desc')->limit(20)->get();
        }
        
        $view = view('administrator.partial.file_upload')->with([
            'images' => $images
        ]);
        return response()->json(['status' => 'ok', 'html' => $view->render()]);
    }
    
    /**
     * Upload multimedia image
     * @return response
     */
    public function postImageUpload(){
        $album_id = \Input::get('image-uploader-album')?: NULL;
        
        $file = \Input::file('upload-image');
        
        $rules = [
            'file' => ['required', 'image']
        ];
        
        $validation = \Validator::make(['file' => $file], $rules);
        
        if($validation->fails()){
            return response()->json(['status' => 'err']);
        }
        
        $filename = uniqid(null, true) . '.jpg';

        \Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('upload/multimedia/' . $filename);

        $multimedia = new Multimedia;
        $multimedia->type = 'image';
        $multimedia->featured = 0;
        $multimedia->album_id = $album_id;

        foreach(Locale::all() as $locale){
            \App::setLocale($locale->language);
            $multimedia->name = '';
            $multimedia->description = '';
        }
        \App::setLocale($this->administratorLocale);

        $multimedia->save();

        $image = new Image;
        $image->filename = $filename;
        $image->multimedia_id = $multimedia->id;
        $image->save();
        
        return response()->json(['status' => 'ok', 'filename' => $filename]);
    }
    
    public function getRequestsStatusList(){
        $ids = \Input::get('ids');
        if(!is_array($ids)){
            return response()->json(['status' => 'err']);
        }
        
        // Get the users
        $users = User::findMany($ids);
        
        // Get the scholarships categories
        foreach(Category::all() as $category){
            $categories[$category->id] = $category->name;
        }
        
        $view = view('administrator.partial.requests_status')->with([
            'users' => $users,
            'categories' => $categories
        ]);
        
        return response()->json(['status' => 'ok', 'html' => $view->render()]);
    }
    
    public function getRequestStatus(){
        return response()->json(['status' => 'ok']);
    }
}