<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packages_report extends Model
{
    //
    public $table = 'packages_report';
    protected $fillable = [
        'driverId','pakage_date','No_of_TP','updatedby_id','updated_usertypeid','journal_id'
    ];
}
