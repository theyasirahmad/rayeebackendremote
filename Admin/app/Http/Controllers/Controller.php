<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Crypt;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        return view('Admin.dashboard');
    }

    public function userGet(){
        if(request()->ajax()){

            $user = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'User');
            })->get();
            return datatables()->of($user)
                    ->addColumn('action', function($data){
                        $url = url('').'/admin/user-details/'.Crypt::encrypt($data->id);
                        $button = '<a href="'.$url.'">'.$data->first_name.'</a>';
                        return $button;
                    })
                    ->addColumn('last_name', function($data){
                        return $data->last_name;
                    })
                    ->addColumn('gender', function($data){
                        return ($data->gender == '1') ? 'Male' : 'Female';
                    })
                    ->addColumn('email', function($data){
                        return $data->email;
                    })
                    ->addColumn('phone', function($data){
                        return $data->phone;
                    })
                    ->make(true);

        }
        return View('Admin.user');
    }

    public function userDetails($id){

        $idd = Crypt::decrypt($id);
        $profile = User::with(['education_det','occupation_det','children_group_det',
        'children_household_det','house_hold_det','role_purchasing_det'])->where('id', $idd)->first();
        return view('admin.user-details', ['user' => $profile]);
    }

}
