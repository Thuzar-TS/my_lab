<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Patient;
use App\State;
use App\User;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $patient = Patient::paginate(2);
        $state = State::all();
        return response()->json(['patients' => $patient, 'states' => $state]);
    }

    public function store(Request $request){
        if ($request->input('patient_name')) {
         
            $patient = new Patient;
            $patient->patient_name = $request->input('patient_name');
            $patient->patient_reference = $request->input('patient_reference');
            $patient->nrc = $request->input('nrc');
            $patient->age = $request->input('age');
            $patient->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $patient->dob = $bdd[0];
            $patient->phone = $request->input('phone');
            $patient->address = $request->input('address');
            $patient->blood_type = $request->input('blood_type');
            $patient->marital_status = $request->input('marital_status');
            $patient->city = $request->input('city');
            $patient->country = $request->input('country');
            $patient->nationality = $request->input('nationality');
            $patient->religion = $request->input('religion');
            $patient->state_id = $request->input('state_id');
            $patient->father_name = $request->input('father_name');
            $patient->mother_name = $request->input('mother_name');
            $patient->occupation = $request->input('occupation');
            $patient->fax = $request->input('fax');
            $patient->email = $request->input('email');
            $patient->allergy = $request->input('allergy');
            $patient->remark = $request->input('remark');
            $patient->patientstatus = $request->input('patientstatus');            
            $patient->user_id = Auth::user()->id;
            $patient->save();
        }
        $patient = Patient::paginate(2);
        $state = State::all();
        return response()->json(['patients' => $patient, 'states' => $state]);
    }

    public function edit($id){
        $patient = Patient::find($id);
        $state = State::all();
        return response()->json(['patients' => $patient, 'states' => $state]);
    }

    public function update(Request $request,$id){
        if ($request->input('patient_name')) {
            $patient = Patient::find($id);
            $patient->patient_name = $request->input('patient_name');
            $patient->patient_reference = $request->input('patient_reference');
            $patient->nrc = $request->input('nrc');
            $patient->age = $request->input('age');
            $patient->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $patient->dob = $bdd[0];
            $patient->phone = $request->input('phone');
            $patient->address = $request->input('address');
            $patient->blood_type = $request->input('blood_type');
            $patient->marital_status = $request->input('marital_status');
            $patient->city = $request->input('city');
            $patient->country = $request->input('country');
            $patient->nationality = $request->input('nationality');
            $patient->religion = $request->input('religion');
            $patient->state_id = $request->input('state_id');
            $patient->father_name = $request->input('father_name');
            $patient->mother_name = $request->input('mother_name');
            $patient->occupation = $request->input('occupation');
            $patient->fax = $request->input('fax');
            $patient->email = $request->input('email');
            $patient->allergy = $request->input('allergy');
            $patient->remark = $request->input('remark');
            $patient->patientstatus = $request->input('patientstatus');            
            $patient->user_id = Auth::user()->id;
            $patient->save();
        }
        $patient = Patient::paginate(2);
        $state = State::all();
        return response()->json(['patients' => $patient, 'states' => $state]);
    }

    public function delete($id){
        $patient = Patient::find($id);
        $patient->delete();
        return '';
    }

}