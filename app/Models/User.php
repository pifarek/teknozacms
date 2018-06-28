<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    public function locale()
    {
        return $this->belongsTo('App\Models\Locale');
    }
    
    public function isAdmin(){
        return $this->role == 'administrator'? true : false;
    }
    
    /**
     * 
     */
    public function events(){
        return $this->hasMany(\App\Models\Events\User::class);
    }
    
    /*
     * Get users active in last x minutes
     */
    public static function active($time = 300){
        return self::where('active_at', '>=', \DB::raw('(NOW() - INTERVAL 10 MINUTE)'))->orderBy('active_at', 'DESC')->limit(5)->get();
    }
    
    public function updateActive(){
        $this->active_at = new \DateTime;
        $this->save();
    }
    
    public function logs(){
        return $this->hasMany('App\Models\Log')->orderBy('created_at', 'DESC');
    }
    
    public function name(){
        if($this->name && $this->surname){
            return $this->name . ' ' . $this->surname;
        }else{
            return $this->email;
        }
    }
    
    public function removeAvatar(){
        if($this->avatar){
            @unlink('upload/users/'. $this->avatar);
        }
        $this->avatar = '';
        $this->save();
    }
}
