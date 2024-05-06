<?php

namespace App\Exports;

use App\Juornal;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class SalaryExport implements FromCollection
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $sql;

    public function __construct(String $sql) {
        
        $this->sql = $sql; 
    }
    public function collection()
    {
        $array = array();
        // $Select_db = DB::select($this->sql);
        

        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Select_db = DB::select("
        SELECT
            account_owner_iqama,
            accountNumber,
            SUM(edit_salary) as edit_salary,
            GROUP_CONCAT(edit_salary SEPARATOR '*') as bank_paid,
            count(*) AS CO,
            GROUP_CONCAT(driverId SEPARATOR '*') as drivers_IDs,
            GROUP_CONCAT(job_id SEPARATOR '*') as job_ids,
            GROUP_CONCAT(fullName SEPARATOR '*') as DriverNames
            FROM
            (" . $this->sql . "
                            ) a
            WHERE account_owner_iqama IS NOT NULL
            AND accountNumber IS NOT NULL
            AND account_owner_iqama REGEXP '^[0-9]+$'
            AND accountNumber REGEXP '^[0-9]+$'
            AND LENGTH(account_owner_iqama) = 10
            AND LENGTH(accountNumber) = 12
            AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
            AND SUBSTR(accountNumber, 1, 3) =('966')
            AND edit_salary>0
            GROUP BY account_owner_iqama,accountNumber");
        $rowCount = 2;
        // dd($rowCount);
        $res = collect([
            ['Reference Number','Telephone Number','Amount','','','','','','','','','',''],
        ]);
       
        foreach ($Select_db as $k=>$Select_dbdb) {
            dd($Select_dbdb);
            if($k == 0){
                $res->push([$Select_dbdb->account_owner_iqama,$Select_dbdb->accountNumber,$Select_dbdb->edit_salary,'','Total Amount','=SUM(C:C)','',$Select_dbdb->CO,$Select_dbdb->job_ids,$Select_dbdb->DriverNames,$Select_dbdb->drivers_saned_settlement_IDs,$Select_dbdb->drivers_jahiz_clearing_IDs,$Select_dbdb->bank_paid]);
            }else{
                $res->push([$Select_dbdb->account_owner_iqama,$Select_dbdb->accountNumber,$Select_dbdb->edit_salary,'','','','',$Select_dbdb->CO,$Select_dbdb->job_ids,$Select_dbdb->DriverNames,$Select_dbdb->drivers_saned_settlement_IDs,$Select_dbdb->drivers_jahiz_clearing_IDs,$Select_dbdb->bank_paid]);
            }
    
            // dd($Select_db);
            // $objPHPExcel->setActiveSheetIndex(0)
            //     ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
            //     ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
            //     ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->edit_salary)
            //     ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
            //     ->SetCellValue('I' . $rowCount, $Select_dbdb->job_ids)
            //     ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
            //     ->SetCellValue('K' . $rowCount, $Select_dbdb->bank_paid);

            // $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);


            // $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
            //     ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            // $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
            //     ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            // $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
            //     array(
            //         'borders' => array(
            //             'allborders' => array(
            //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
            //                 'color' => array('rgb' => '000000')
            //             )
            //         ),
            //         'alignment' => array(
            //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            //         )
            //     )
            // );
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
            $rowCount++;

        }

        dd($res);
    }
}
