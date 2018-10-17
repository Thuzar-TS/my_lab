<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labgroup extends Model
{
      protected $table = 'groups';
    	protected $fillable = ['id', 'group_name','user_id'];
}
