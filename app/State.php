<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
      protected $table = 'states';
    	protected $fillable = ['id', 'state_name','user_id'];
}
