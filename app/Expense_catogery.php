<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense_catogery extends Model
{
    //
    protected $table = 'expenses_catogeries';
    public $timestamps = true;
    protected $fillable = [
        'expense_desciption','created_by', 'created_at', 'updated_at' 
    ];
    public function user(){
        return $this->belongsTo('App\User','created_by','id');
    }
}
