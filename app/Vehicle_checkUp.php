<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle_checkUp extends Model
{
    //
    protected $table = 'vehicle_checks';
    public $timestamps = true;
    protected $fillable = [
        'left_image', 'right_image','rear_image','front_image','drivingWheel_image','otometer','vehicle_id','delegation_type',
        'left_image_approve','right_image_approve','front_image_approve','rear_image_approve',
        'interior_image_approve','rejection_reason','approved_by'
    ];
}
