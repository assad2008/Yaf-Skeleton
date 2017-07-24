<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'account_hospital_staff';
    protected $primaryKey = "ID";
    public $timestamps = false;
}
