<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
    protected $table = 'drivers';
    public $timestamps = true;
    protected $fillable = [
        'warehouseId','absher_no' ,'fullName', 'fullName_ar', 'mobileNumber', 'nationality_id',
        'iqama', 'iqamaExpireyDate','vehicle_id', 'email_id', 'job_id', 'dob', 'status_id','verificationCode', 'termination_reason_id','driver_data',
        'interview_date', 'start_date', 'licenseExpireyDate', 'passportNo', 'passportExpireyDate','warehouseId ',
        'password', 'tshirtSize', 'pantSize', 'shoesSize', 'bank_id', 'accountNumber', 'profileImage', 'licenseProof',
        'identityProof', 'passportProof','vehicleIdentityProof', 'created_at','vehicle_id', 'updated_at'
    ];
    public function warehouse(){
        return $this->belongsTo('App\Warehouse','warehouseId','id');
    }
    public function vehicle(){
        return $this->belongsTo('App\Vehicle','vehicle_id','id');
    }
    public function statusString(){
        return $this->belongsTo('App\Lkp_loans_status','status_id','id');
    }
    public function driver_type(){
        return $this->belongsTo('App\Driver_type','driver_type_id','id');
    }
    protected $hidden = ['updated_at', 'password'];
    /**
     * @var array|mixed|string|null
     */
    private $warehouseId;
}
