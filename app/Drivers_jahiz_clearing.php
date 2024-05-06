<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers_jahiz_clearing extends Model
{
    //
    protected $table = 'drivers_jahiz_clearing';
    public $timestamps = true;
    protected $fillable = [
        'driverId',
        'driver_type_id',
        'Jahiz_Amount',
        'Jahiz_Amount_Sign',
        'Bander_Commission',
        'clearing_type_id',
        'bank',
        'cash',
        'ATM',
        'paid_id',
        'paid_dt',
        'paid_by_id',
        'created_by_id',
        'updated_by_id',
        'created_at',
        'updated_at'
    ];
    public function driver(){
        return $this->belongsTo('App\Drivers','driverId','id');
    }
   
}
