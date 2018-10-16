<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radiologic extends Model
{
    protected $table = 'radiologics';
    protected $fillable = ['radiologic_name','nrc','licence_number','gender','dob','degree','specialization','mobile','address','rank','department','referred_percent','show_in_result','user_id'];
}
