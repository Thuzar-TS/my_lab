<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = ['item_code','description','short_description','item_type_id','group_id',
    'category_id','brand_id','packing','lastvendor_id','expired_date',
    'lastpurchase_date','lastsale_date','inactive','ismultilevel',
    'usebarcode','useexpire','sale_account_number','purchase_account_number',
    'salereturn_account_number','purchasereturn_account_number','img_path','user_id'];
}