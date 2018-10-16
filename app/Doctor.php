<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    //protected $fillable = ['user_id'];
    protected $fillable = ['doctor_name','nrc','licence_number','gender','dob','degree','specialization','mobile','address','rank','department','referred_percent','show_in_result','user_id'];
    //protected $guarded = [];
}
