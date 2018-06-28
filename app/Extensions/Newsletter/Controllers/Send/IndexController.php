<?php

namespace App\Extensions\Newsletter\Controllers\Send;

use App\Http\Controllers\Administrator\BaseController;
use App\Extensions\Newsletter\Models\User as NewsletterUser;
use App\Extensions\Newsletter\Models\Group as NewsletterGroup;

class IndexController extends BaseController
{
    public function index()
    {
        // Forget session data
        \Session::forget('newsletter_elements');
        
        return view('Newsletter.Views.administrator.send.index');
    }
    
    public function postIndex()
    {
        $rules = [
            'newsletter_type' => ['required', 'in:option_1,option_2,option_3']
        ];
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        switch(\Input::get('newsletter_type')){
            case 'option_1': return redirect('administrator/newsletter/send/greetings');
            case 'option_2': return redirect('administrator/newsletter/send/content');
            case 'option_3': return redirect('administrator/newsletter/send/empty');
            default: die('you shouldn\'t see this');
        }
    }
    
    /**
     * Send greetings newsletter
     * @return type
     */
    public function composeGreetings()
    {
        // Get the newsletter users
        $users = NewsletterUser::all();
        
        // Get newsletter groups
        $groups = NewsletterGroup::all();
        
        return view('Newsletter.Views.administrator.send.greetings')->with([
            'users' => $users,
            'groups' => $groups
        ]);
    }
    
    public function sendGreetings()
    {
        $rules = [
            'type' => ['required', 'in:users,groups'],
            'subject' => ['required'],
            'image' => ['required', 'image']
        ];
        
        if(\Input::get('type') == 'users'){
            $rules['users'] = ['required', 'array'];
        }else{
            $rules['groups'] = ['required', 'array'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $subject = \Input::get('subject');
        
        $image = \Input::file('image');
        
        $filename = uniqid(null, true) . '.jpg';
        
        \Image::make($image->getRealPath())->resize(900, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('upload/newsletter/' . $filename);
        
        if(\Input::get('type') == 'users'){
            $users_id = \Input::get('users');
            $users = NewsletterUser::find($users_id);
        }else{
            $groups_id = \Input::get('groups');
            $groups = NewsletterGroup::find($groups_id);
            $users = collect();
            if($groups->count()){
                foreach($groups as $group){
                    if($group->users->count()){
                        foreach($group->users as $user){
                            $users->push($user);
                        }
                    }
                }
            }
        }
        
        if($users->count()){
            foreach($users as $user){
                $data = [
                    'image' => $filename,
                    'user' => $user
                ];
                \Mail::send('Newsletter.Views.email.greetings-template', $data, function($mail) use ($user, $subject){
                    $mail->to($user->email)->subject($subject);
                });
            }
        }
        
        return redirect('administrator/newsletter/send')->with('success', 'New newsletter has been successfully sent.');
    }
    
    public function composeContent()
    {       
        $sessionElements = session('newsletter_elements');

        // Step #1
        if(!$sessionElements){
        
            // Collections
            $newsCollection = collect();
            $eventsCollection = collect();

            $newsExtensionEnabled = class_exists('\App\Extensions\News\Controllers\IndexController');
            $eventsExtensionEnabled = class_exists('\App\Extensions\Events\Controllers\IndexController');

            if($newsExtensionEnabled) {
                // Get latest news
                $news = \App\Extensions\News\Models\News::all();

                if ($news->count()) {
                    foreach ($news as $single) {
                        $element = (object)[
                            'id' => $single->id,
                            'time' => strtotime($single->created_at),
                            'title' => $single->title,
                            'url' => 'url',
                            'description' => $single->content,
                            'type' => 'news',
                        ];

                        $newsCollection->push($element);
                    }
                }
            }

            if($eventsExtensionEnabled) {
                // Get latest events
                $events = \App\Extensions\Events\Models\Event::all();

                if ($events->count()) {
                    foreach ($events as $event) {
                        $element = (object)[
                            'id' => $event->id,
                            'time' => strtotime($event->created_at),
                            'title' => $event->name,
                            'url' => 'url',
                            'description' => $event->description,
                            'type' => 'event'
                        ];

                        $eventsCollection->push($element);
                    }
                }
            }

            return view('Newsletter.Views.administrator.send.content')->with([
                'news' => $newsCollection,
                'events' => $eventsCollection,
                'step' => 1
            ]);
        }else{
            // Get the newsletter users
            $users = NewsletterUser::all();

            // Get newsletter groups
            $groups = NewsletterGroup::all();
            
            return view('Newsletter.Views.administrator.send.content')->with([
                'users' => $users,
                'groups' => $groups,
                'step' => 2
            ]);
        }
    }
    
    public function sendContent()
    {
        $sessionElements = \Session::get('newsletter_elements');
        
        if($sessionElements){
            $rules = [
                'type' => ['required', 'in:users,groups'],
                'subject' => ['required'],
                'content' => ['required'],
            ];

            if(\Input::get('type') == 'users'){
                $rules['users'] = ['required', 'array'];
            }else{
                $rules['groups'] = ['required', 'array'];
            }

            $validation = \Validator::make(\Input::all(), $rules);

            if($validation->fails()) {
                return redirect()->back()->withErrors($validation->errors())->withInput();
            }

            $subject = \Input::get('subject');

            if(\Input::get('type') == 'users'){
                $users_id = \Input::get('users');
                $users = NewsletterUser::find($users_id);
            }else{
                $groups_id = \Input::get('groups');
                $groups = NewsletterGroup::find($groups_id);
                $users = collect();
                if($groups->count()){
                    foreach($groups as $group){
                        if($group->users->count()){
                            foreach($group->users as $user){
                                $users->push($user);
                            }
                        }
                    }
                }
            }

            $buildContent = '';
            
            if(!is_array($sessionElements) or sizeof($sessionElements) < 1){
                // Forget session data
                \Session::forget('newsletter_elements');
                return redirect();
            }
            
            // Create an html content
            foreach($sessionElements as $element){
                switch($element["type"]){
                    case 'news':

                        $news = \App\Extensions\News\Models\News::find($element["id"]);
                        $buildContent .= view('Newsletter.Views.administrator.send.elements.news', ['news' => $news]);
                        break;
                    case 'event':
                        $event = \App\Extensions\Events\Models\Event::find($element["id"]);
                        $buildContent .= view('Newsletter.Views.administrator.send.elements.event', ['event' => $event]);
                        break;
                }
            }

            if($users->count()){
                foreach($users as $user){
                    $data = [
                        'description' => \Input::get('content'),
                        'content' => $buildContent,
                        'user' => $user
                    ];
                    \Mail::send('Newsletter.Views.email.content', $data, function($mail) use ($user, $subject){
                        $mail->to($user->email)->subject($subject);
                    });
                }
            }

            return redirect('administrator/newsletter/send')->with('success', 'New newsletter has been successfully sent.');
        }
    }
    
    /**
     * Create an empty email
     */
    public function composeEmpty()
    {
        
        // Get the newsletter users
        $users = NewsletterUser::all();
        
        // Get newsletter groups
        $groups = NewsletterGroup::all();
        
        return view('Newsletter.Views.administrator.send.empty', [
            'users' => $users,
            'groups' => $groups
        ]);
    }
    
    public function sendEmpty()
    {
        $rules = [
            'type' => ['required', 'in:users,groups'],
            'subject' => ['required'],
            'content' => ['required'],
        ];
        
        if(\Input::get('type') == 'users'){
            $rules['users'] = ['required', 'array'];
        }else{
            $rules['groups'] = ['required', 'array'];
        }
        
        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $subject = \Input::get('subject');
        
        if(\Input::get('type') == 'users'){
            $users_id = \Input::get('users');
            $users = NewsletterUser::find($users_id);
        }else{
            $groups_id = \Input::get('groups');
            $groups = NewsletterGroup::find($groups_id);
            $users = collect();
            if($groups->count()){
                foreach($groups as $group){
                    if($group->users->count()){
                        foreach($group->users as $user){
                            $users->push($user);
                        }
                    }
                }
            }
        }
        
        if($users->count())
        {
            foreach($users as $user){
                $data = [
                    'content' => \Input::get('content'),
                    'user' => $user
                ];
                \Mail::send('Newsletter.Views.email.empty-template', $data, function($mail) use ($user, $subject){
                    $mail->to($user->email)->subject($subject);
                });
            }
        }
        
        return redirect('administrator/newsletter/send')->with('success', 'New newsletter has been successfully sent.');
    }
}
