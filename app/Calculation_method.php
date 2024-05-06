<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calculation_method extends Model
{
    //
    protected $table = "lkp_calculation_method";
    public $timestamps = false;
    protected $fillable = [
        'calculation_method'
    ];
}
