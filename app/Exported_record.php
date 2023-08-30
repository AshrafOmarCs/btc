<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exported_record extends Model
{
    //
    protected $table = 'exported_records';
    public $timestamps = true;
    protected $fillable = [
        'account_owner_iqama',
        'accountNumber',
        'edit_salary',
        'bank_paid',
        'CO',
        'drivers_IDs',
        'job_ids',
        'DriverNames',
        'record_status',
        'company_Id',
        'PeriodName',
        'created_by',
        'updated_by'
    ];

    public function created_method(){
        return $this->belongsTo('App\User','created_by','id');
    }
    public function updated_method(){
        return $this->belongsTo('App\User','updated_by','id');
    }

}
