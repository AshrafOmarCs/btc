<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporary extends Model
{
    //
    public $table = 'temporary';
    protected $fillable = [
        'path','status','journal_date','journal_period'
    ];
}
