<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Webhook extends Model
{
    //
    protected $table = "webhooks";
    public $timestamps = true;
    protected $fillable = [
       'json_payload'
    ];
    
    
}
