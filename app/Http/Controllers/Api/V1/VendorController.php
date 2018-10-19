<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Vendor;
use App\State;
use App\User;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor = Vendor::paginate(2);
        $state = State::all();
        return response()->json(['vendors' => $vendor, 'states' => $state]);
    }

    public function store(Request $request){
        if ($request->input('vendor_name')) {
         
            $vendor = new Vendor;
            $vendor->vendor_name = $request->input('vendor_name');
            $vendor->vendor_reference = $request->input('vendor_reference');
            $vendor->nrc = $request->input('nrc');
            $vendor->age = $request->input('age');
            $vendor->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $vendor->dob = $bdd[0];
            $vendor->phone = $request->input('phone');
            $vendor->address = $request->input('address');
            $vendor->blood_type = $request->input('blood_type');
            $vendor->marital_status = $request->input('marital_status');
            $vendor->city = $request->input('city');
            $vendor->country = $request->input('country');
            $vendor->nationality = $request->input('nationality');
            $vendor->religion = $request->input('religion');
            $vendor->state_id = $request->input('state_id');
            $vendor->father_name = $request->input('father_name');
            $vendor->mother_name = $request->input('mother_name');
            $vendor->occupation = $request->input('occupation');
            $vendor->fax = $request->input('fax');
            $vendor->email = $request->input('email');
            $vendor->allergy = $request->input('allergy');
            $vendor->remark = $request->input('remark');
            $vendor->vendorstatus = $request->input('vendorstatus');            
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
            $vendor->vendor_reference = $request->input('vendor_reference');
            $vendor->nrc = $request->input('nrc');
            $vendor->age = $request->input('age');
            $vendor->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $vendor->dob = $bdd[0];
            $vendor->phone = $request->input('phone');
            $vendor->address = $request->input('address');
            $vendor->blood_type = $request->input('blood_type');
            $vendor->marital_status = $request->input('marital_status');
            $vendor->city = $request->input('city');
            $vendor->country = $request->input('country');
            $vendor->nationality = $request->input('nationality');
            $vendor->religion = $request->input('religion');
            $vendor->state_id = $request->input('state_id');
            $vendor->father_name = $request->input('father_name');
            $vendor->mother_name = $request->input('mother_name');
            $vendor->occupation = $request->input('occupation');
            $vendor->fax = $request->input('fax');
            $vendor->email = $request->input('email');
            $vendor->allergy = $request->input('allergy');
            $vendor->remark = $request->input('remark');
            $vendor->vendorstatus = $request->input('vendorstatus');            
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