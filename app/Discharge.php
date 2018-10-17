<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discharge extends Model
{
      protected $table = 'discharge_types';
    	protected $fillable = ['id', 'description','user_id'];
}
