<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_catogery extends Model
{
    //
    protected $table = 'expenses_sub_catogeries';
    public $timestamps = true;
    protected $fillable = [
        'expense_catogery_id', 'expense_name','amount','created_by', 'created_at', 'updated_at' 
    ];
    public function company(){
        return $this->belongsTo('App\Company','company_id','id');
    }
    public function user(){
        return $this->belongsTo('App\User','created_by','id');
    }
    public function expense_catogery(){
        return $this->belongsTo('App\Expense_catogery','created_by','id');
    }
}
