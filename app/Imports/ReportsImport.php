<?php

namespace App\Imports;

use App\Reports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ReportsImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    //private $no=0;
    public function startRow(): int
    {
        return 3;
    }
    public function model(array $row)
    {
        //$this->no++;
        //echo $this->no."<br>";
        return new Reports([
            'Location'  => $row[1],
            'Email'   => $row[2],
            'UserName'   => $row[3],
            'NoFD'   => $row[5],
            'No_of_CIR'=> $row[6],
            'NoFTP'    => $row[7],
            'Total_OFD'  => $row[8],
        ]);
    }
}
