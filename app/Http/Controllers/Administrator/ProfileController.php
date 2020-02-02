<?php
namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    
    /*
     * Edit currently logged user profile
     */
    public function getIndex()
    {
        return view('administrator.profile')->with([
            'user' => \Auth::guard('administrator')->user()
        ]);
    }
    
    public function postIndex(Request $request)
    {
        $rules = [
            'image' => ['max:10000', 'image'],
            'name' => [],
            'surname' => [],
        ];
        
        if($request->get('password')) {
            $rules['password'] = ['min:6'];
            $rules['repassword'] = ['min:6', 'same:password'];
        }
        
        $validation = \Validator::make($request->all(), $rules);
        
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        
        $user = \Auth::guard('administrator')->user();
        

        
        $user->name = $request->get('name');
        $user->surname = $request->get('surname');
        if($request->get('password')){
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();
        
        return redirect('administrator/profile')->with('success', trans('admin.profile_msg_updated'));
    }

    /**
     * Remove logged user avatar
     * @return type
     */
    public function avatarRemove()
    {
        $user = \Auth::guard('administrator')->user();
        if($user->avatar){
            @unlink('upload/users/' . $user->avatar);
            $user->avatar = '';
            $user->save();
        }
        return response()->json(['status' => 'ok']);
    }

    /**
     * Upload logged user avatar
     * @param Request $request
     */
    public function avatar(Request $request)
    {
        $avatar = $request->file('avatar');

        $rules = [
            'image' => ['max:10000', 'image']
        ];

        $validation = \Validator::make($request->all(), $rules);

        if($validation->passes()) {
            if($avatar) {
                $user = \Auth::guard('administrator')->user();
                $filename = uniqid(null, true) . '.jpg';
                \Image::make($avatar->getRealPath())->fit(300, 300)->save('upload/users/' . $filename);
                $user->avatar = $filename;
                $user->save();

                return response()->json(['status' => 'ok', 'filename' => $filename]);
            }
        }

        return response()->json(['status' => 'err']);
    }
}
