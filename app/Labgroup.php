<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labgroup extends Model
{
      protected $table = 'lab_groups';
    	protected $fillable = ['id', 'labgroup_name','user_id'];
}
