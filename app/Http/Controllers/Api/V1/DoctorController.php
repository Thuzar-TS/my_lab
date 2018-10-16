<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Doctor;
use App\User;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $doctors = Doctor::where('user_id',Auth::user()->id)->paginate(5);
        // return view('doctors.browser',compact("doctors"));

        return Doctor::paginate(2);
    }

    public function store(Request $request){
        if ($request->input('doctor_name')) {
            //$doctor = new Doctor(Input::all());
           // dd($request->all());
            //$doctor = Doctor::create($request->all());
            $doctor = new Doctor;
            $doctor->doctor_name = $request->input('doctor_name');
            $doctor->nrc = $request->input('nrc');
            $doctor->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $doctor->dob = $bdd[0];
            $doctor->mobile = $request->input('mobile');
            $doctor->address = $request->input('address');
            $doctor->degree = $request->input('degree');
            $doctor->specialization = $request->input('specialization');
            $doctor->licence_number = $request->input('licence_number');
            $doctor->department = $request->input('department');
            $doctor->referred_percent = $request->input('referred_percent');
            $doctor->rank = $request->input('rank');
            $doctor->show_in_result = $request->input('show_in_result');
            $doctor->user_id = Auth::user()->id;
            $doctor->save();
        }
        return Doctor::paginate(2);
    }

    public function edit($id){
        return Doctor::find($id);
    }

    public function update(Request $request,$id){
        if ($request->input('doctor_name')) {
            $doctor = Doctor::find($id);
            $doctor->doctor_name = $request->input('doctor_name');
            $doctor->nrc = $request->input('nrc');
            $doctor->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $doctor->dob = $bdd[0];
            $doctor->mobile = $request->input('mobile');
            $doctor->address = $request->input('address');
            $doctor->degree = $request->input('degree');
            $doctor->specialization = $request->input('specialization');
            $doctor->licence_number = $request->input('licence_number');
            $doctor->department = $request->input('department');
            $doctor->referred_percent = $request->input('referred_percent');
            $doctor->rank = $request->input('rank');
            $doctor->show_in_result = $request->input('show_in_result');
            $doctor->user_id = Auth::user()->id;
            $doctor->save();
        }
         return Doctor::paginate(2);
    }

    public function delete($id){
        $doctor = Doctor::find($id);
        $doctor->delete();
        return '';
    }

}