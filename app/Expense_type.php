<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense_type extends Model
{
    //
    protected $table = 'expense_types';
    public $timestamps = true;
    protected $fillable = [
        'name', 'amount','expenseTo','company_id','expenses_catogery_id', 'created_at', 'updated_at'
    ];
    public function company(){
        return $this->belongsTo('App\Company','company_id','id');
    }
    public function expenses_catogery(){
        return $this->belongsTo('App\Expense_catogery','expenses_catogery_id','id');
    }
}
