<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otp_code extends Model
{
    //
    public $table = 'otp_msgs';
    protected $fillable = [
        'code','user_id','ip_addess'
    ];
}
