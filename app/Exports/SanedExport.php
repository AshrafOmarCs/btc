<?php

namespace App\Exports;
use Response;
use App\Drivers_saned_settlement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use DB;
class SanedExport implements FromCollection
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
        
        $Select_db = DB::select($this->sql);

        $txtFile = '';
        $i = 0;

        foreach ($Select_db as $Select_dbdb) {
            if ($Select_dbdb->Jahiz_Amount == "") {
                $i++;
                $txtFile .= "<tr><td>" . $i . "</td>
              <td>" . $Select_dbdb->AMP_ID . "</td>
              <td>" . $Select_dbdb->DriverName . "</td>
              <td>" . $Select_dbdb->SANED_amount . "</td>
              <td>" . $Select_dbdb->SettledDate . "</td>
              </tr>";
            }
        }

        if ($txtFile == "") {

            // dd($this->sql);

            DB::statement('SET SESSION group_concat_max_len = 5555555');

            $Select_db = DB::select("
            SELECT
                account_owner_iqama,
                accountNumber,
                SUM(IFNULL(bank_minus,0)-IFNULL(bank_plus,0)) as bank_minus_plus,
                GROUP_CONCAT(TRIM(IFNULL(bank_minus,0)-IFNULL(bank_plus,0))+0 SEPARATOR '*') as bank_paid,
                count(*) AS CO,
                GROUP_CONCAT(id SEPARATOR '*') as drivers_saned_settlement_IDs,
                GROUP_CONCAT(drivers_jahiz_clearing_id SEPARATOR '*') as drivers_jahiz_clearing_IDs,
                GROUP_CONCAT(AMP_ID SEPARATOR '*') as AMP_IDs,
                GROUP_CONCAT(DriverName SEPARATOR '*') as DriverNames
                FROM
                (" . $this->sql . "
                                ) a
                WHERE
                    account_owner_iqama IS NOT NULL
                    AND accountNumber IS NOT NULL
                    AND SANED_amount = Jahiz_Amount
                    GROUP BY account_owner_iqama,accountNumber
                    having SUM(IFNULL(bank_minus,0)-IFNULL(bank_plus,0))>0");
            $rowCount = 2;
            // dd($Select_db[5]);
            $res = collect([
                ['Reference Number','Telephone Number','Amount','','','','','','','','','',''],
            ]);
            foreach ($Select_db as $k=>$Select_dbdb) {
              
                if($k == 0){
                    $res->push([$Select_dbdb->account_owner_iqama,$Select_dbdb->accountNumber,$Select_dbdb->bank_minus_plus,'','Total Amount','=SUM(C2:C200)','',$Select_dbdb->CO,$Select_dbdb->AMP_IDs,$Select_dbdb->DriverNames,$Select_dbdb->drivers_saned_settlement_IDs,$Select_dbdb->drivers_jahiz_clearing_IDs,$Select_dbdb->bank_paid]);
                }else{
                    $res->push([$Select_dbdb->account_owner_iqama,$Select_dbdb->accountNumber,$Select_dbdb->bank_minus_plus,'','','','',$Select_dbdb->CO,$Select_dbdb->AMP_IDs,$Select_dbdb->DriverNames,$Select_dbdb->drivers_saned_settlement_IDs,$Select_dbdb->drivers_jahiz_clearing_IDs,$Select_dbdb->bank_paid]);
                }
                
            }
            
            return collect($res);
            
            // $date = date("Y-m-d H-i-s");
            // $fileName = 'STC Pay Excel_' . $date . '-' . Auth::user()->id . '.xlsx';

            // DB::table('drivers_saned_export_excel')->insert(
            //     ['user_id' => Auth::user()->id,
            //         'fileName' => $fileName,
            //         'create_at' => date("Y-m-d H:i:s")
            //     ]
            // );

            //return(public_path() . '/SANEDSettledExcel/' . $fileName);
             
            exit;

        } else {
            $txtFile = "
         <style>

                .show_table th {
                    padding: 0.3rem 0.3rem !important;
                    border: solid 1px !important;
                    margin: 0 !important;
                    width: 10px;
                    text-align: center;
                    background-color: #00ca6d;
                    white-space: nowrap;
                    font-family: 'Segoe UI','Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    font-weight: 400;
                    font-size: 12px !important;
                }

                .show_table td {
                    white-space: nowrap;
                    padding: 0.0rem 0.3rem !important;
                    border: solid 1px !important;
                    vertical-align: middle !important;
                    font-family: 'Segoe UI','Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    font-weight: 400;
                    font-size: 12px !important;
                }
            </style>
            <table class='show_table' style='width:10px!important;border-collapse: collapse;'>
            <tr><th colspan='5'><b>
            غير مدخل
            </b></th></tr>
            <tr><th>#</th><th>AMP_ID</th><th>DriverName</th><th>SANED Amount</th><th>SANED SettledDate</th></th></tr>
            " . $txtFile . "</table>";
            

            //It will be called report.txt
            
            print($txtFile);
        }

    }
     
}
