<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers_jahiz_claim extends Model
{
    //
    protected $table = 'drivers_jahiz_claim';
    public $timestamps = true;
    protected $fillable = [
        'driverId',
        'amount',
        'claim_dt',
        'note',
        'bag_fee',
        'Bander_Commission',
        'created_by_id',
        'updated_by_id'
    ];
}
