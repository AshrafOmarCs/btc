<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    public $table = 'vehicles';
    protected $fillable = [
        'details','user_id','grantred_expenses'
    ];
    
}
