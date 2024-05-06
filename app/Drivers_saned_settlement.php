<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers_saned_settlement extends Model
{
    //
    protected $table = 'drivers_saned_settlement';
    public $timestamps = true;
    protected $fillable = [
        'AMP_ID',
        'DriverName',
        'CollectionAmount',
        'DeliveryPrice',
        'FreeOrderAmount',
        'DriverCredit',
        'DriverDebit',
        'SettledDate',
        'drivers_jahiz_clearing_paid_id',
        'paid_dt',
        'paid_by_id',
        'NoOfDispatch',
        'created_by_id',
    ];
}
