<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    public $table = 'report';

    protected $fillable = [
        'Location', 'Email', 'UserName', 'NoFD', 'No_of_CIR', 'NoFTP', 'Total_OFD',
    ];
    /* public function User(){
         return $this->hasMany('App\User');
     }
     */
}
