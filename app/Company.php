<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "lkp_company";
    public $timestamps = false;
    protected $fillable = [
        'companyName', 'companyName_AR', 'calculation_method_id',
        'period_start', 'period_end', 'shipment_price', 'monthly_salary',
        'daily_salary', 'companyFullName_en', 'companyFullName_ar',
        'TaxNumber', 'CreditNote_Letter','company_unit_cost','company_vat','createdby_id','updatedby_id'
    ];
    public function calculation_method(){ 
        return $this->belongsTo('App\Calculation_method','calculation_method_id','id');
    }
    public function createdby(){  
        return $this->belongsTo('App\User','createdby_id','id');
    }
    public function updatedby(){  
        return $this->belongsTo('App\User','updatedby_id','id');
    }

}
