<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers_jahiz_claim_reply extends Model
{
    //
    protected $table = 'drivers_jahiz_claim_reply';
    public $timestamps = true;
    protected $fillable = [
        'drivers_jahiz_claim_id','reply_txt','claim_status_id','created_by_id','created_at'
    ];
}
