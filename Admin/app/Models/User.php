<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password',
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


    public function roles(){
        return $this->belongsToMany('App\Models\Roles', 'user_role', 'user_id', 'role_id');
    }

    public function hasAnyRole($roles){
        if(is_array($roles)){
            foreach($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }
        else{
            if($this->hasRole($roles)){
                return true;
            }
        }
        return false;
    }

    public function hasRole($role){
        if($this->roles()->where('name', $role)->first()){
            return true;
        }
        return false;
    }

    public function education_det()
    {
        return $this->belongsTo('App\Models\education', 'education');
    }

    public function occupation_det()
    {
        return $this->belongsTo('App\Models\occupation', 'occupation');
    }

    public function children_group_det()
    {
        return $this->belongsTo('App\Models\children_group', 'children_group');
    }

    public function children_household_det()
    {
        return $this->belongsTo('App\Models\children_household', 'children_household');
    }

    public function house_hold_det()
    {
        return $this->belongsTo('App\Models\house_hold_sub_category', 'house_hold');
    }

    public function role_purchasing_det()
    {
        return $this->belongsTo('App\Models\role_purchasing', 'role_purchasing');
    }

}
