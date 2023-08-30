<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver_type extends Model
{
    //
    protected $table = 'lkp_driver_type';
    public $timestamps = true;
    protected $fillable = [
        'driver_type'
    ];
}
