<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Vendor;
use App\State;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor = Vendor::select('vendors.*','vendor_types.description as vtypename','states.state_name')
        ->join('vendor_types','vendor_types.id','=','vendors.vendor_type_id')
        ->join('states','states.id','=','vendors.state_id')
        ->paginate(2);

        $state = State::all();
        $type = DB::select('SELECT * FROM vendor_types');
        return response()->json(['vendors' => $vendor, 'states' => $state, 'types'=>$type]);
    }

    public function store(Request $request){
        if ($request->input('vendor_name')) {
         
            $vendor = new Vendor;
            $vendor->vendor_name = $request->input('vendor_name');
            $vendor->vendor_type_id = $request->input('vendor_type_id');
            $vendor->contact_name = $request->input('contact_name');
            $vendor->phone = $request->input('phone');
            $vendor->address = $request->input('address');
            $vendor->state_id = $request->input('state_id');
            $vendor->city = $request->input('city');
            $vendor->country = $request->input('country');
            $vendor->email = $request->input('email');
            $vendor->website = $request->input('website');
            $vendor->balance = $request->input('balance');
            $vendor->account_number = $request->input('account_number');
            $vendor->purchase_account_number = $request->input('purchase_account_number');
            $vendor->remark = $request->input('remark');
            $vendor->user_id = Auth::user()->id;
            $vendor->save();
        }
        $vendor = Vendor::paginate(2);
        $state = State::all();
        return response()->json(['vendors' => $vendor, 'states' => $state]);
    }

    public function edit($id){
        $vendor = Vendor::find($id);
        $state = State::all();
        return response()->json(['vendors' => $vendor, 'states' => $state]);
    }

    public function update(Request $request,$id){
        if ($request->input('vendor_name')) {
            $vendor = Vendor::find($id);
            $vendor->vendor_name = $request->input('vendor_name');
            $vendor->vendor_type_id = $request->input('vendor_type_id');
            $vendor->contact_name = $request->input('contact_name');
            $vendor->phone = $request->input('phone');
            $vendor->address = $request->input('address');
            $vendor->state_id = $request->input('state_id');
            $vendor->city = $request->input('city');
            $vendor->country = $request->input('country');
            $vendor->email = $request->input('email');
            $vendor->website = $request->input('website');
            $vendor->balance = $request->input('balance');
            $vendor->account_number = $request->input('account_number');
            $vendor->purchase_account_number = $request->input('purchase_account_number');
            $vendor->remark = $request->input('remark');
            $vendor->user_id = Auth::user()->id;
            $vendor->save();
        }
        $vendor = Vendor::paginate(2);
        $state = State::all();
        return response()->json(['vendors' => $vendor, 'states' => $state]);
    }

    public function delete($id){
        $vendor = Vendor::find($id);
        $vendor->delete();
        return '';
    }

}