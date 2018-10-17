<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Labgroup;
use App\User;
use Illuminate\Support\Facades\Auth;

class LabGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Labgroup::paginate(5);
    }

    public function store(Request $request){
        if ($request->group_name) {
            $sta = new Labgroup;
            $sta->group_name = $request->group_name;
            $sta->user_id = Auth::user()->id;
            $sta->save();
        }
        return Labgroup::paginate(5);  
    }

    // public function edit($id){
    //     $state = State::find($id);
    //     $states = State::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
    //     return view("states.browser",['editst'=>$state,'states'=>$states]);
    // }

    public function update(Request $request,$id){
        if ($request->group_name) {
            $sta = Labgroup::find($id);
            $sta->group_name = $request->group_name;
            $sta->user_id = Auth::user()->id;
            $sta->save();
        }
        return Labgroup::paginate(5);
    }

    public function delete($id){
        $state = Labgroup::find($id);
        $state->delete();
        return '';
    }

}