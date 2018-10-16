<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Category::paginate(5);
    }

    public function store(Request $request){
        if ($request->category_name) {
            $cate = new Category;
            $cate->category_name = $request->category_name;
            $cate->user_id = Auth::user()->id;
            $cate->save();
        }
        return Category::paginate(5);  
    }

    // public function edit($id){
    //     $category = Category::find($id);
    //     $categories = Category::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
    //     return view("categories.browser",['editst'=>$category,'categories'=>$categories]);
    // }

    public function update(Request $request,$id){
        if ($request->category_name) {
            $cate = Category::find($id);
            $cate->category_name = $request->category_name;
            $cate->user_id = Auth::user()->id;
            $cate->save();
        }
        return Category::paginate(5);
    }

    public function delete($id){
        $category = Category::find($id);
        $category->delete();
        return '';
    }

}