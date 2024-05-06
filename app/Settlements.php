<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Settlements extends Model
{
    public $table = 'settlements';  

    protected $fillable = [
        'driverId', 'journal_date', 'credit', 'debit', 'note', 'createdby_id', 'updatedby_id',
    ];
   /* public function User(){
        return $this->hasMany('App\User');
    }
    */
}
