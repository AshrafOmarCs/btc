<?php

namespace App\Imports;

use App\Reports_zajil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ReportsImport_zajil implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    //private $no=0;
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        //$this->no++;
        //echo $this->no."<br>";
        return new Reports_zajil([
            'name'  => $row[0],
            'Total_OFD'   => $row[1],
            'NoFD'   => $row[2],
        ]);
    }
}
