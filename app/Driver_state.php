<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver_state extends Model
{
    //
    protected $table = "lkp_driver_status";
    public $timestamps = false;
    protected $fillable = [
        'driver_status_en', 'driver_status_ar'
    ];
}
