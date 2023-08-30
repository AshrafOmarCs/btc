<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_import_paid_detail extends Model
{
    //
    public $table = 'salary_import_paid_details';

    protected $fillable = [
        'paid_master_id ', 'journal_id', 'AMP_ID', 'account_owner_iqama', 'accountNumber', 'bank_sum', 'CO','bank_paid','paid'
    ];
}
