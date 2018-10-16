<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return role::where('user_id', Auth::user()->id)->paginate(5);
    }

    public function store(Request $request){
        if ($request->role_name) {
            $rol = new role;
            $rol->role_name = $request->role_name;
            $rol->user_id = Auth::user()->id;
            $rol->save();
        }
        return role::where('user_id', Auth::user()->id)->paginate(5);   
    }

    // public function edit($id){
    //     $role = role::find($id);
    //     $roles = role::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
    //     return view("roles.browser",['editst'=>$role,'roles'=>$roles]);
    // }

    public function update(Request $request,$id){
        if ($request->role_name) {
            $rol = role::find($id);
            $rol->role_name = $request->role_name;
            $rol->user_id = Auth::user()->id;
            $rol->save();
        }
        return role::where('user_id', Auth::user()->id)->paginate(5);
    }

    public function delete($id){
        $role = role::find($id);
        $role->delete();
        return '';
    }

}
