<?php

namespace App\Http\Controllers\Administrator\Settings;

use App\Http\Controllers\Administrator\BaseController;
use App\Models\Administrator;
use App\Models\Locale;
use App\Models\LocaleAccept;
use App\Models\Settings as SettingsModel;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /*
     * Display global settings
     */
    public function getGlobal()
    {
        $settings = $this->settings;

        return view('administrator.settings.global', ['settings' => $settings, 'locales' => Locale::all()]);
    }
    
    /*
     * Display global settings
     */
    public function postGlobal(Request $request)
    {
        $settings = $this->settings;
        
        $rules = [];
        if(is_array($settings)){
            foreach($settings as $setting){
                if($setting['multilanguage']){
                    foreach(Locale::all() as $locale){
                        $rules['setting-' . $setting['name'] . '-' . $locale->language] = $setting['rules'];
                    }
                }else{
                    $rules[$setting['name']] = $setting['rules'];
                }
                
            }
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        if(is_array($settings)){
            foreach($settings as $setting){
                if($setting['multilanguage']){
                    foreach(Locale::all() as $locale){
                        $db_settings = SettingsModel::firstOrCreate([
                            'name' => $setting['name'],
                            'locale_id' => $locale->id
                        ]);
                        $db_settings->value = $request->get('setting-' . $setting['name'] . '-' . $locale->language)?: NULL;
                        $db_settings->save();
                    }
                }else{
                    $db_settings = SettingsModel::firstOrCreate([
                        'name' => $setting['name'],
                        'locale_id' => NULL                        
                    ]);
                    $db_settings->value = $request->get('setting-' . $setting['name'])?: NULL;
                    $db_settings->save();
                }
            }
        }
        
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
    
    /*
     * Display admin users
     */
    public function getUsers()
    {
        $users = Administrator::select(['id', 'email', 'created_at'])->get();
        $data['users'] = $users;

        return view('administrator.settings.users.list', $data);
    }
    
    /*
     * Add a new user form
     */
    public function getUserAdd()
    {
        return view('administrator.settings.users/add');
    }
    
    /*
     * Add a new user
     */
    public function postUserAdd(Request $request)
    {
        $rules = [
            'email' => ['required', 'email', 'unique:administrators,email'],
            'password' => ['required', 'confirmed', 'min:6']
        ];
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){            
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $user = new Administrator;
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->locale = \App::getLocale();
        $user->save();
        
        return redirect('administrator/settings/users/edit/' . $user->id)->with('success', __('admin.settings_users_msg_added'));
    }
    
    public function getUserEdit($user_id)
    {
        $user = Administrator::find($user_id);
        if(!$user)
        {
            return redirect()->back();
        }
        
        return view('administrator.settings.users/edit', ['user' => $user]);
    }
    
    public function postUserEdit(Request $request, $user_id)
    {
        $user = Administrator::find($user_id);
        if(!$user)
        {
            return redirect()->back();
        }
        
        $rules = [
            'password' => ['confirmed', 'min:6']
        ];
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails())
        {            
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        if($request->get('password'))
        {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();
        
        return redirect()->back()->with('success', __('admin.settings_users_msg_updated'));
    }
    
    /*
     * Display locales
     */
    public function getLocales()
    {
        // Get Locales
        $locales = Locale::all();
        
        return view('administrator.settings.locales.list', ['locales' => $locales]);
    }
    
    /*
     * Add a new locale
     */
    public function getLocaleAdd()
    {
        return view('administrator.settings.locales/add');
    }
    
    public function postLocaleAdd(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'language' => ['required', 'min:2', 'max:2', 'unique:locales,language']
        ];
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $locale = new Locale;
        $locale->language = $request->get('language');
        $locale->name = $request->get('name');
        $locale->save();
        
        $this->createTranslationsFiles($locale->language);
        
        return redirect('administrator/settings/locales/list')->with('success', __('admin.settings_locale_msg_added'));
    }
    
    /*
     * Edit selected locale
     */
    public function getLocaleEdit($locale_id)
    {
        $locale = Locale::find($locale_id);
        if(!$locale)
        {
            return redirect('administrator/settings/locales');
        }
        
        return view('administrator/settings/locales/edit', ['locale' => $locale]);
    }
    
    public function postLocaleEdit(Request $request, $locale_id)
    {
        $locale = Locale::find($locale_id);
        if(!$locale)
        {
            return redirect('administrator/settings/locales');
        }
        
        $rules = [
            'name' => ['required'],
            'language' => ['required', 'min:2', 'max:2', 'unique:locales,language,' . $locale_id . ',id'],
            'accept_code' => ['sometimes', 'array'],
            'accept_code.*' => ['required']
        ];
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $locale->assignAccept($request->get('accept_code') ?? []);

        $locale->name = $request->get('name');
        $locale->language = $request->get('language');
        $locale->save();
        
        return redirect()->back()->with('success', __('admin.settings_locale_msg_updated'));
    }
    
    private function createTranslationsFiles($language)
    {
        $files = ['page.php', 'validation.php', 'auth.php', 'email.php', 'pagination.php', 'passwords.php'];
        
        \File::makeDirectory('../resources/lang/' . $language, $mode = 0777, true, true);
        
        foreach($files as $file) {
            \File::put('../resources/lang/' . $language . '/' . $file, '');
        }
    }

    /*
     * Display translations
     */
    public function getTranslations(Request $request)
    {
        $file = null;
        if(\Session::get('file')) {
            $file = \Session::get('file');
        }

        $files = [];

        $extensions = \Teknoza::Translations();

        foreach($extensions as $extensionLangDirectory) {
            foreach(\File::allFiles($extensionLangDirectory['path']) as $extensionsLangFile) {
                $files[$extensionsLangFile->getRealPath()] = $extensionsLangFile->getRelativePathname() . ' - ' . ucfirst($extensionLangDirectory['namespace']);
            }
        }

        foreach(\File::allFiles('../resources/lang/') as $resourceFile) {
            $files[$resourceFile->getRealPath()] = $resourceFile->getRelativePathname();
        }

        return view('administrator/settings/translations', ['files' => $files, 'file' => $file]);
    }

    public function postTranslations(Request $request)
    {
        $rules = [
            'file' => ['required'],
            'content' => ['required']
        ];

        $validation = \Validator::make($request->all(), $rules);

        if($validation->fails())
        {
            return redirect()->back();
        }

        $full_path = $request->get('file');

        file_put_contents($full_path, $request->get('content'));

        return redirect()->back()->with('success', 'File has been updated successfully.')->with('file', $request->get('file'));
    }
}
