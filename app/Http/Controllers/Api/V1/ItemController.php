<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Item;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;

class itemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $item = Item::paginate(2);
        $category = Category::all();
        return response()->json(['items' => $item, 'categories' => $category]);
    }

    public function store(Request $request){
        if ($request->input('item_name')) {
         
            $item = new Item;
            $item->item_code = $request->input('item_code');
            $item->description = $request->input('description');
            $item->short_description = $request->input('short_description');
            $item->item_type_id = $request->input('item_type_id');
            $item->group_id = $request->input('group_id');

            $bd = $request->input('expired_date');
            $bdd = explode("T",$bd);
            $item->expired_date = $bdd[0];

            $bd = $request->input('lastpurchase_date');
            $bdd = explode("T",$bd);
            $item->lastpurchase_date = $bdd[0];

            $bd = $request->input('lastsale_date');
            $bdd = explode("T",$bd);
            $item->lastsale_date = $bdd[0];

            $item->category_id = $request->input('category_id');
            $item->brand_id = $request->input('brand_id');
            $item->packing = $request->input('packing');
            $item->lastvendor_id = $request->input('lastvendor_id');
            $item->inactive = $request->input('inactive');
            $item->ismultilevel = $request->input('ismultilevel');
            $item->usebarcode = $request->input('usebarcode');
            $item->useexpire = $request->input('useexpire');
            $item->sale_account_number = $request->input('sale_account_number');
            $item->purchase_account_number = $request->input('purchase_account_number');
            $item->salereturn_account_number = $request->input('salereturn_account_number');
            $item->purchasereturn_account_number = $request->input('purchasereturn_account_number');
            $item->img_path = $request->input('img_path');
            $item->user_id = Auth::user()->id;
            $item->save();
        }
        $item = Item::paginate(2);
        $category = Category::all();
        return response()->json(['items' => $item, 'categories' => $category]);
    }

    public function edit($id){
        $item = Item::find($id);
        $category = Category::all();
        return response()->json(['items' => $item, 'categories' => $category]);
    }

    public function update(Request $request,$id){
        if ($request->input('item_name')) {
            $item = Item::find($id);
            $item->item_code = $request->input('item_code');
            $item->description = $request->input('description');
            $item->short_description = $request->input('short_description');
            $item->item_type_id = $request->input('item_type_id');
            $item->group_id = $request->input('group_id');

            $bd = $request->input('expired_date');
            $bdd = explode("T",$bd);
            $item->expired_date = $bdd[0];

            $bd = $request->input('lastpurchase_date');
            $bdd = explode("T",$bd);
            $item->lastpurchase_date = $bdd[0];

            $bd = $request->input('lastsale_date');
            $bdd = explode("T",$bd);
            $item->lastsale_date = $bdd[0];

            $item->category_id = $request->input('category_id');
            $item->brand_id = $request->input('brand_id');
            $item->packing = $request->input('packing');
            $item->lastvendor_id = $request->input('lastvendor_id');
            $item->inactive = $request->input('inactive');
            $item->ismultilevel = $request->input('ismultilevel');
            $item->usebarcode = $request->input('usebarcode');
            $item->useexpire = $request->input('useexpire');
            $item->sale_account_number = $request->input('sale_account_number');
            $item->purchase_account_number = $request->input('purchase_account_number');
            $item->salereturn_account_number = $request->input('salereturn_account_number');
            $item->purchasereturn_account_number = $request->input('purchasereturn_account_number');
            $item->img_path = $request->input('img_path');          
            $item->user_id = Auth::user()->id;
            $item->save();
        }
        $item = Item::paginate(2);
        $category = Category::all();
        return response()->json(['items' => $item, 'categories' => $category]);
    }

    public function delete($id){
        $item = Item::find($id);
        $item->delete();
        return '';
    }

}