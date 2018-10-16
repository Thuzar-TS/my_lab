<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     return Location::all();
    // }

    public function index()
    {
        //$locations = Location::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
        //return view('locations.browser',compact("locations"));
        return Location::paginate(5);
        //$locations = Location::paginate(3);
        //return request()->json(200,$locations);
    }

    public function store(Request $request)
    {
        if ($request->location_name) {
            $loca = new Location;
            $loca->location_name = $request->location_name;
            $loca->user_id = Auth::user()->id;
            $loca->save();
        }
        //return $loca;
        return Location::paginate(5);
    }

    // public function edit($id)
    // {
    //     $location = Location::find($id);
    //     $locations = Location::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(5);
    //     return view("locations.browser", ['editst' => $location, 'locations' => $locations]);
    // }

    public function update(Request $request, $id)
    {
        if ($request->location_name) {
            $loca = Location::find($id);
            $loca->location_name = $request->location_name;
            $loca->user_id = Auth::user()->id;
            $loca->save();
        }
        //return Location::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return Location::paginate(5);
    }

    public function delete($id)
    {
        $location = Location::find($id);
        $location->delete();
        return '';
    }

}
