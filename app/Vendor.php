<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
      protected $table = 'vendors';
      protected $fillable = ['id', 'vendor_name','vendor_type_id','contact_name',
      'phone','address','state_id','city','country','email','website','balance',
      'account_number','purchase_account_number','remark','user_id'];
}
