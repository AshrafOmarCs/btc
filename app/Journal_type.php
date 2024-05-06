<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal_type extends Model
{
    //lkp_journal_type

    public $table = 'lkp_journal_type';
    protected $fillable = [
        'journal_type'
    ];
}
