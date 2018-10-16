<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Radiologic;
use App\User;
use Illuminate\Support\Facades\Auth;

class RadiologicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Radiologic::paginate(3);
    }

    public function store(Request $request){
        if ($request->input('radiologic_name')) {
         
            $radiologic = new Radiologic;
            $radiologic->radiologic_name = $request->input('radiologic_name');
            $radiologic->nrc = $request->input('nrc');
            $radiologic->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $radiologic->dob = $bdd[0];
            $radiologic->mobile = $request->input('mobile');
            $radiologic->address = $request->input('address');
            $radiologic->degree = $request->input('degree');
            $radiologic->specialization = $request->input('specialization');
            $radiologic->licence_number = $request->input('licence_number');
            $radiologic->department = $request->input('department');
            $radiologic->referred_percent = $request->input('referred_percent');
            $radiologic->rank = $request->input('rank');
            $radiologic->show_in_result = $request->input('show_in_result');
            $radiologic->user_id = Auth::user()->id;
            $radiologic->save();
        }
        return Radiologic::paginate(3);
    }

    public function edit($id){
        return Radiologic::find($id);
    }

    public function update(Request $request,$id){
        if ($request->input('radiologic_name')) {
            $radiologic = Radiologic::find($id);
            $radiologic->radiologic_name = $request->input('radiologic_name');
            $radiologic->nrc = $request->input('nrc');
            $radiologic->gender = $request->input('gender');
            $bd = $request->input('dob');
            $bdd = explode("T",$bd);
            $radiologic->dob = $bdd[0];
            $radiologic->mobile = $request->input('mobile');
            $radiologic->address = $request->input('address');
            $radiologic->degree = $request->input('degree');
            $radiologic->specialization = $request->input('specialization');
            $radiologic->licence_number = $request->input('licence_number');
            $radiologic->department = $request->input('department');
            $radiologic->referred_percent = $request->input('referred_percent');
            $radiologic->rank = $request->input('rank');
            $radiologic->show_in_result = $request->input('show_in_result');
            $radiologic->user_id = Auth::user()->id;
            $radiologic->save();
        }
    //    // return redirect("/");
         return Radiologic::paginate(3);
    }

    public function delete($id){
        $radiologic = Radiologic::find($id);
        $radiologic->delete();
        return '';
    }
}
