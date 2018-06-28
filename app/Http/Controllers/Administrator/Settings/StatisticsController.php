<?php

namespace App\Http\Controllers\Administrator\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Administrator\BaseController;

class StatisticsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credentials = \Teknoza::statisticsCheckCredentialsFile();
        
        return view('administrator.settings.statistics.index', ['credentials' => $credentials]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'analytics' => [],
            'analytics_view_id' => ['numeric', 'nullable'],
            'credentials' => ['file', 'mimetypes:application/javascript,application/json,text/plain']
        ];
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        \Settings::set('analytics', $request->get('analytics'));
        \Settings::set('analytics_view_id', $request->get('analytics_view_id'));
        $jsonCredentials = $request->file('credentials');
        if($jsonCredentials) {
            $jsonCredentials->storeAs('analytics', 'service-account-credentials.json');
            // Clear Google Analytics Cache
            \Storage::deleteDirectory('analytics/google-cache');
        }
        
        return redirect()->back()->with('success', __('admin.settings_statistics_messages_success'));
    }


}
