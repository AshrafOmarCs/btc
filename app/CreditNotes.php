<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CreditNotes extends Model
{
    public $table = 'creditnotes';
    
    protected $fillable = [
        'driverId',
        'journal_date',
        'amount',
        'note',
        'invoice_number'
    ];
}
