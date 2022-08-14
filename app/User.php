<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{   
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function roles(){
        return $this->belongsToMany('App\role','role_user','user_id','role_id');
    }

    function checkPermissionAccess($permission_check){
        $roles = Auth()->user()->roles;
       
        foreach($roles as $role){
            $permissions = $role->permission;
            // return dd($permissions);
          if(  $permissions->contains('key_code',$permission_check)){
           
              return true;
          }
        }
        return false;
    }
}
