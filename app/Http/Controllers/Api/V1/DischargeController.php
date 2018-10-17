<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Discharge;
use App\User;
use Illuminate\Support\Facades\Auth;

class DischargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Discharge::paginate(5);
    }

    public function store(Request $request){
        if ($request->description) {
            $bran = new Discharge;
            $bran->description = $request->description;
            $bran->user_id = Auth::user()->id;
            $bran->save();
        }
        return Discharge::paginate(5);  
    }

    // public function edit($id){
    //     $brand = Discharge::find($id);
    //     $discharge_types = Discharge::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
    //     return view("discharge_types.browser",['editst'=>$brand,'discharge_types'=>$discharge_types]);
    // }

    public function update(Request $request,$id){
        if ($request->description) {
            $bran = Discharge::find($id);
            $bran->description = $request->description;
            $bran->user_id = Auth::user()->id;
            $bran->save();
        }
        return Discharge::paginate(5);
    }

    public function delete($id){
        $brand = Discharge::find($id);
        $brand->delete();
        return '';
    }

}