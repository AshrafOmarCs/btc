<?php

namespace App\Exports;

use App\Journal;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

abstract class JournalExport implements FromQuery, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return 'XXX';
    }
    public function map($array): array
    {
        return [
            '$invoice->invoice_number',
            '$invoice->user->name',
        ];
    }
}
