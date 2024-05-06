<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assign_vehicle extends Model
{
    //
    protected $table = "assign_vehicles";
    public $timestamps = true;
    protected $fillable = [
        'vehicle_id','driver_id','status'
    ];
}
