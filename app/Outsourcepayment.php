<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outsourcepayment extends Model
{
    //
    public $table = 'outsourcepayments';
    protected $fillable = [
        'AMP_ID','fullName','amount','status','payment_date','warehouse_id','driver_identity','stcpay_identity','stcpay_number','created_by',
        'updated_by'
    ];
    public function warehouse(){
        return $this->belongsTo('App\Warehouse','warehouse_id','id');
    }
    public function updated_user(){
        return $this->belongsTo('App\User','updated_by','id');
    }
    public function created_user(){
        return $this->belongsTo('App\User','created_by','id');
    }
}
