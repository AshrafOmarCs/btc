<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle_checkUp_utlitie extends Model
{
    //
    protected $table = 'vehicle_check_utlities';
    public $timestamps = true;
    protected $fillable = [
        'vehicle_utlity_id', 'vehicle_check_id','utlity_condition','approval','rejection_count'
    ];
}
