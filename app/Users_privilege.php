<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_privilege extends Model
{
    //
    protected $table = 'users_privilege';
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'warehouseId','privilage_type_id'
    ];
    public function warehouse(){
        return $this->belongsTo('App\Warehouse','warehouseId','id');
    }
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
