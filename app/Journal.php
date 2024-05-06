<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    //
    public $table = 'journal';
    protected $fillable = [
        'driverId','journal_type_id','journal_date','createdby_id','updatedby_id','debit','credit','note'
    ];
    public function driver(){
        return $this->belongsTo('App\Drivers','driverId','id');
    }
    public function journal_type(){
        return $this->belongsTo('App\Journal_type','journal_type_id','id');
    }
    public function createdby(){
        return $this->belongsTo('App\User','createdby_id','id');
    }
    public function updatedby(){
        return $this->belongsTo('App\User','updatedby_id','id');
    }

}
