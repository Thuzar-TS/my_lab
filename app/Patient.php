<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    protected $fillable = ['patient_reference','patient_name','nrc','age','blood_type','gender','dob',
    'marital_status','city','country','address','nationality','religion','state_id','father_name',
    'mother_name','occupation','phone','fax','email','allergy','remark','patientstatus','user_id'];
}