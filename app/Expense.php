<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //
    protected $table = 'expenses';
    public $timestamps = true;
    protected $fillable = [
        'name', 'expense_type_id','credit', 'debit', 'reciver_Id' , 'company_id',
        'journal_date','note','post_id','status','created_by','updated_by','paid_by','created_at','updated_at'
    ];
    public function expense_type(){
        return $this->belongsTo('App\Expense_type','expense_type_id','id');
    }
    public function driver(){
        return $this->belongsTo('App\Drivers','reciver_Id','id');
    }
    public function company(){
        return $this->belongsTo('App\Company','company_id','id');
    }
    public function updated_user()
    {
        # code...
        return $this->belongsTo('App\User','updated_by','id');
    }
    public function created_user()
    {
        # code...
        return $this->belongsTo('App\User','created_by','id');
    }
}
 