<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestModal extends Model
{
    //

    public $table = 'requests';

    protected $fillable = [
        'request_type_id', 'vehicle_id', 'driverId', 'executive_supervisor_id', 'vehicle_check_id', 'supporvisor_identity_approve', 'action_id',
        'action_description','created_at','created_by','updated_by','updated_at'
    ];

}
