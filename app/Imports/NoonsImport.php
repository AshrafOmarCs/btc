<?php

namespace App\Imports;

use App\Models\Journal;
use Maatwebsite\Excel\Concerns\ToModel;

class NoonsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Journal([
            //
        ]);
    }
}
