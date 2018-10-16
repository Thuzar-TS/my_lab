<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use App\User;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Brand::paginate(5);
    }

    public function store(Request $request){
        if ($request->brand_name) {
            $bran = new Brand;
            $bran->brand_name = $request->brand_name;
            $bran->user_id = Auth::user()->id;
            $bran->save();
        }
        return Brand::paginate(5);  
    }

    // public function edit($id){
    //     $brand = Brand::find($id);
    //     $brands = Brand::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
    //     return view("brands.browser",['editst'=>$brand,'brands'=>$brands]);
    // }

    public function update(Request $request,$id){
        if ($request->brand_name) {
            $bran = Brand::find($id);
            $bran->brand_name = $request->brand_name;
            $bran->user_id = Auth::user()->id;
            $bran->save();
        }
        return Brand::paginate(5);
    }

    public function delete($id){
        $brand = Brand::find($id);
        $brand->delete();
        return '';
    }

}