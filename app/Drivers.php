<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Drivers extends Model implements JWTSubject
{
    use Notifiable;
    protected $table = 'drivers';
    public $timestamps = true;
    protected $guarded = ['id']; 
    protected $fillable = [
        'warehouseId', 'fullName', 'fullName_ar', 'mobileNumber', 'nationality_id',
        'iqama', 'iqamaExpireyDate','driver_type_id', 'email_id', 'job_id', 'dob', 'status_id','verificationCode', 'termination_reason_id',
        'interview_date', 'start_date', 'licenseExpireyDate', 'passportNo', 'passportExpireyDate',
        'password', 'tshirtSize', 'pantSize', 'shoesSize', 'bank_id', 'accountNumber', 'profileImage', 'licenseProof',
        'identityProof','basic_salary','created_by_id','fuel_per_day', 'passportProof','vehicleIdentityProof', 'created_at','vehicle_id', 'updated_at'
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

        /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    
}
