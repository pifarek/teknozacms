<?php
namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Mail\newAdministratorPassword;
use App\Mail\resetAdministratorPassword;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        // logout just in case
        \Auth::guard('administrator')->logout();
    }

    /**
     * Display login form
     * @return view
     */
    public function form()
    {
        return view('administrator.auth.login');
    }
    
    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];

        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        $params = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        // Find a administrator user
        if(Administrator::where('email', '=', $request->get('email'))->first()){
            if(\Auth::guard('administrator')->attempt($params, (bool) $request->get('remember'))){
                return redirect()->intended('administrator');
            }else{
                return redirect()->back()->withInput();
            }
        }else{
            return redirect()->back()->withInput();
        }
    }
    
    /**
     * Recover the password
     * @return 
     */
    public function resetForm()
    {
        return view('administrator.auth.forgot');
    }
    
    public function reset(Request $request)
    {
        $rules = [
            'email' => ['required', 'email', 'exists:administrators,email']
        ];

        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        }
        
        $user = Administrator::where('email', $request->get('email'))->get()->first();

        // Generate reset token
        $reset_token = Str::random(30);

        // Save the user's reset token
        $user->reset_token = $reset_token;
        $user->update();

        Mail::to($user)->send(new resetAdministratorPassword($user, $reset_token));

        return redirect('administrator/auth/login')->with('reset_link_sent', true);
    }

    public function generate($token)
    {
        $user = Administrator::where('reset_token', $token)->first();

        if(!$user) {
            return redirect('administrator');
        }

        // generate random new password
        $new_password = Str::random();

        // clear reset token
        $user->reset_token = '';
        // generate random password
        $user->password = bcrypt($new_password);
        $user->update();

        // send new password
        Mail::to($user)->send(new newAdministratorPassword($user, $new_password));

        return redirect('administrator/auth/login')->with('reset', true);
    }
    
    /*
     * Logout logged administrator
     */
    public function logout()
    {
        \Auth::guard('administrator')->logout();
        return redirect('administrator/auth/login');
    }
}
