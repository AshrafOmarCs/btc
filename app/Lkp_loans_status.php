<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lkp_loans_status extends Model
{
    //
    public $table = 'lkp_driver_status';
    protected $fillable = [
        'driver_status_en',
        'driver_status_ar' 
    ];
}
