<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = "lkp_city";
    public $timestamps = false;
    protected $fillable = [
        'name_en','name_ar'
    ];
}
