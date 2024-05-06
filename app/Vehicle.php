<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    public $table = 'vehicles';
    protected $fillable = [
        'plate','otometer','extraOtometerCharge','freeExtraOtometer',
        'vehicle_model_id',
        'vehicle_opreater_id',
        'SNno',
        'city_id',
        'registertion_type',
        'body_number',
        'color',
        'checkup_id',
        'current_status',
        'vehicle_registration_expire_date',
        'recive_date',
        'created_by' 
    ];
    
}
