<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\State;
use App\User;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return State::paginate(5);
    }

    public function store(Request $request){
        if ($request->state_name) {
            $sta = new State;
            $sta->state_name = $request->state_name;
            $sta->user_id = Auth::user()->id;
            $sta->save();
        }
        return State::paginate(5);  
    }

    // public function edit($id){
    //     $state = State::find($id);
    //     $states = State::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
    //     return view("states.browser",['editst'=>$state,'states'=>$states]);
    // }

    public function update(Request $request,$id){
        if ($request->state_name) {
            $sta = State::find($id);
            $sta->state_name = $request->state_name;
            $sta->user_id = Auth::user()->id;
            $sta->save();
        }
        return State::paginate(5);
    }

    public function delete($id){
        $state = State::find($id);
        $state->delete();
        return '';
    }

}