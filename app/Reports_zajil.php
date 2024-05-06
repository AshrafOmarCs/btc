<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Reports_zajil extends Model
{
    public $table = 'report_zajil';

    protected $fillable = [
        'name', 'Total_OFD', 'NoFD',
    ];
    /* public function User(){
         return $this->hasMany('App\User');
     }
     */
}
