<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCheckup extends Model
{
    //
    public $table = 'vehicle_checks';
    protected $fillable = [
        'left_image',
        'right_image',
        'rear_image',
        'front_image',
        'drivingWheel_image',
        'otometer',
        'vehicle_id',
        'delegation_type',
        'left_image_approve',
        'right_image_approve',
        'front_image_approve',
        'rear_image_approve',
        'interior_image_approve',
        'rejection_reason',
        'note',
        'admin_approve_by',
        'admin_approve_at',
        'suppervisor_approve_by',
        'suppervisor_approve_at',
        'approved_by',
        'created_by' 
    ];
}
