<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lkp_company extends Model
{
    //
    protected $table = "lkp_company";
    public $timestamps = false;
    protected $fillable = [
        'companyName', 'companyName_AR'
    ];
}
