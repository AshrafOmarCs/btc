<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approved_record extends Model
{
    //
    protected $table = "approved_records";
    public $timestamps = true;
    protected $fillable = [
        'user_id','company_id'.'periodFrom','periodTo','status'
    ];
}
