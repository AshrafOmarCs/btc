<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    public $table = 'loan';
    protected $fillable = [
        'driverId',
        'journal_date',
        'amount',
        'status_id',
        'note', 
        'loan_type',
        'journal_id',
        'createdby_id',
        'updatedby_id',
        'created_usertypeid',
        'updated_usertypeid',
        'paid_image'
    ];
}
