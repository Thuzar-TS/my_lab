<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $user = User::paginate(5);
        // $roles = Role::all();
        // return response()->json(['users' => $user, 'roles' => $roles]);

        $user = User::select('users.id','name','email','role_id','roles.role_name')
        ->join('roles','roles.id','=','users.role_id')->paginate(5);
        $roles = Role::all();
        return response()->json(['users' => $user, 'roles' => $roles]);
    }

    public function store(Request $request){
        
        if ($request->name) {
            $sta = new User;
            $sta->name = $request->name;
            $sta->email = $request->email;
            $sta->password = bcrypt($request->password);
            $sta->role_id = $request->role_id;
            $sta->user_id = Auth::user()->id;
            $sta->save();
        }
        $user = User::select('users.id','name','email','role_id','roles.role_name')
        ->join('roles','roles.id','=','users.role_id')->paginate(5);
        $roles = Role::all();
        return response()->json(['users' => $user, 'roles' => $roles]);
    }

    public function edit($id){
        $users = User::find($id);
        //$users = User::where('id',$id)->value('name','email','role_id');
        $roles = Role::all();

        return response()->json(['users' => $users, 'roles' => $roles]);
    }

    public function update(Request $request,$id){
        if ($request->name) {
            $sta = User::find($id);
            $sta->name = $request->name;
            $sta->email = $request->email;
            $sta->password = bcrypt($request->password);
            $sta->role_id = $request->role_id;
            $sta->user_id = Auth::user()->id;
            $sta->save();
        }
        $user = User::select('users.id','name','email','role_id','roles.role_name')
        ->join('roles','roles.id','=','users.role_id')->paginate(5);
        $roles = Role::all();
        return response()->json(['users' => $user, 'roles' => $roles]);
    }

    public function delete($id){
        $state = User::find($id);
        $state->delete();
        return '';
    }

}