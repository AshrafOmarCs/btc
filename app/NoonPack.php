<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoonPack extends Model
{
    //
    public $table = 'noon_pack';
    protected $fillable = [
        'period_id','Location','UserName','driverId','Emp_ID','name','No_of_Delivered','No_of_TouchPoint','No_of_CIR','Remarks'
    ];
}
