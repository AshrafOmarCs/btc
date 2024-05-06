<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transcation_history extends Model
{
    //
    public $table = 'transaction_histories';
    protected $fillable = [
        'AMP_ID','stcpay_number','stcpay_identity','project_name','transaction_date','PeriodName','amount','created_by'
    ];
    public function driver(){
        return $this->belongsTo('App\Drivers','driverId','id');
    }
}
