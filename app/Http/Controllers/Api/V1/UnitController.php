<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Unit;
use App\User;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $units = Unit::paginate(5);
        //$punits = Unit::all();
        return response()->json(['units' => $units]);
    }

    public function store(Request $request){
        if ($request->unit_name) {
            $uni = new Unit;
            $uni->unit_name = $request->unit_name;
           // $uni->parent_id = $request->parent_id;
            $uni->user_id = Auth::user()->id;
            $uni->save();
        }
        $units = Unit::paginate(5);
        //$punits = Unit::all();
        return response()->json(['units' => $units]);
    }

    // public function edit($id){
    //     $unit = Unit::find($id);
    //     $units = Unit::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
    //     return view("units.browser",['editst'=>$unit,'units'=>$units]);
    // }

    public function update(Request $request,$id){
        if ($request->unit_name) {
            $uni = Unit::find($id);
            $uni->unit_name = $request->unit_name;
            $uni->user_id = Auth::user()->id;
            $uni->save();
        }
        $units = Unit::paginate(5);
        //$punits = Unit::all();
        return response()->json(['units' => $units]);
    }

    public function delete($id){
        $unit = Unit::find($id);
        $unit->delete();
        return '';
    }

}