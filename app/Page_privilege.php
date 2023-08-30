<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page_privilege extends Model
{
    //

    protected $table = "page_privileges";
    // public $timestamps = false;
    protected $fillable = [
        'user_id','privilege_description',
        'granted_by','company_id'
    ];
    
    public function user(){ 
        return $this->belongsTo('App\User','user_id','id');
    }

    public function company(){ 
        return $this->belongsTo('App\lkp_company','company_id','id');
    }
}
