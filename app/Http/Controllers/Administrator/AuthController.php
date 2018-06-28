<?php
namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Mail\newAdministratorPassword;
use App\Mail\resetAdministratorPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        // logout just in case
        \Auth::logout();
    }

    /**
     * Display login form
     * @return view
     */
    public function form()
    {
        return view('administrator.auth.login');
    }
    
    public function login()
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];

        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        $params = [
            'email' => \Input::get('email'),
            'password' => \Input::get('password')
        ];
        
        $t = User::where('email', '=', \Input::get('email'))->first();
        
        // Find a administrator user
        if(User::where('email', '=', \Input::get('email'))->where('role', '=', 'administrator')->first()){
            if(\Auth::attempt($params, (bool)\Input::get('remember'))){
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
            'email' => ['required', 'email', 'exists:users,email']
        ];

        $validation = \Validator::make(\Input::all(), $rules);
        
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        }
        
        $user = User::where('email', $request->get('email'))->where('role', 'administrator')->get()->first();

        // Generate reset token
        $reset_token = str_random(30);

        // Save the user's reset token
        $user->reset_token = $reset_token;
        $user->update();

        Mail::to($user)->send(new resetAdministratorPassword($user, $reset_token));

        return redirect('administrator/auth/login')->with('reset_link_sent', true);
    }

    public function generate($token)
    {
        $user = User::where('reset_token', $token)->where('role', 'administrator')->first();

        if(!$user) {
            return redirect('administrator');
        }

        // generate random new password
        $new_password = str_random();

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
        \Auth::logout();
        return redirect('administrator');
    }
}