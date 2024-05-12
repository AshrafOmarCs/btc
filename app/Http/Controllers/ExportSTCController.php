<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;

use App\User;
use App\Exported_record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Writer_Excel2007;

class ExportSTCController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
       
        //  return $request->all();
        
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Reference Number')
            ->setCellValueExplicit('B1', 'Telephone Number')
            ->setCellValue('C1', 'Amount')
            ->setCellValue('E2', 'Total Amount')
            ->setCellValue('F2', '=SUM(C:C)');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(37);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getStyle("E2:F2")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("C1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                ),
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);


        $Select_db = DB::select($request->SQL);
        

        $txtFile = '';
        $i = 0;

        foreach ($Select_db as $Select_dbdb) {
            // dd($Select_dbdb);
            if ($Select_dbdb->Jahiz_Amount == "") {
                $i++;
                $txtFile .= "<tr><td>" . $i . "</td>
              <td>" . $Select_dbdb->AMP_ID . "</td>
              <td>" . $Select_dbdb->DriverName . "</td>
              <td>" . $Select_dbdb->SANED_amount . "</td>
              <td>" . $Select_dbdb->SettledDate . "</td>
              </tr>";
              
            }
            //   echo $Select_dbdb.' $txtFile'.'<br>';
            // dd($Select_dbdb);
        }   
        
        if ($txtFile == "") {



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
                (" . $request->SQL . "
                                ) a
                WHERE
                    account_owner_iqama IS NOT NULL
                    AND accountNumber IS NOT NULL
                    AND SANED_amount = Jahiz_Amount
                    GROUP BY account_owner_iqama,accountNumber
                    having SUM(IFNULL(bank_minus,0)-IFNULL(bank_plus,0))>0");
            $rowCount = 2;
           
            foreach ($Select_db as $Select_dbdb) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->bank_minus_plus)
                    ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
                    ->SetCellValue('I' . $rowCount, $Select_dbdb->AMP_IDs)
                    ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
                    ->SetCellValue('K' . $rowCount, $Select_dbdb->drivers_saned_settlement_IDs)
                    ->SetCellValue('L' . $rowCount, $Select_dbdb->drivers_jahiz_clearing_IDs)
                    ->SetCellValue('M' . $rowCount, $Select_dbdb->bank_paid);

                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);


                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
                    ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
                    ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('rgb' => '000000')
                            )
                        ),
                        'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
                $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
                $rowCount++;

            }
 
             
            $objPHPExcel->setActiveSheetIndex(0);
            $date = date("Y-m-d H-i-s");
            $fileName = 'JAHIZ'.'_STCPayExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


            //return(public_path() . '/SANEDSettledExcel/' . $fileName);
            $objWriter->save('php://output');
            
             DB::table('drivers_saned_export_excel')->insert(
                ['user_id' => Auth::user()->id,
                    'fileName' => $fileName,
                    'create_at' => date("Y-m-d H:i:s")
                ]
            );
            
            exit;
            
            // end Test code
            // $fileName = 'STC Pay Excel_' . $date . '-' . Auth::user()->id . '.xlsx';
            // // Redirect output to a client’s web browser (Excel2007)
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="' . $fileName . '"');
            // header('Cache-Control: max-age=0');
            // // If you're serving to IE 9, then the following may be needed
            // header('Cache-Control: max-age=1');

            // // If you're serving to IE over SSL, then the following may be needed
            // header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            // header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            // header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            // header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

           
            // dd('HHHHHH HHHH');
            // $objWriter->save(public_path() . '/SANEDSettledExcel/' . $fileName);

            //return(public_path() . '/SANEDSettledExcel/' . $fileName);
            $objWriter->save('php://output');
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
            header('Content-type: html/plain');

            //It will be called report.txt
            header('Content-Disposition: attachment; filename="غير مدخل.html"');
//return $txtFile;
            print($txtFile);
        }
        
    exit;
    }
    
    
    public function ExportSTCShe(Request $request)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Reference Number')
            ->setCellValueExplicit('B1', 'Telephone Number')
            ->setCellValue('C1', 'Amount')
            ->setCellValue('E2', 'Total Amount')
            ->setCellValue('F2', '=SUM(C:C)');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(37);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getStyle("E2:F2")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("C1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                ),
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);


        $Select_db = DB::select($request->SQL);
        

        $txtFile = '';
        $i = 0;

        foreach ($Select_db as $Select_dbdb) {
            // dd($Select_dbdb);
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
        $settlementids = array();
        if ($txtFile == "") {

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
                (" . $request->SQL . "
                                ) a
                WHERE
                    account_owner_iqama IS NOT NULL
                    AND accountNumber IS NOT NULL
                    AND SANED_amount = Jahiz_Amount
                    GROUP BY account_owner_iqama,accountNumber
                    having SUM(IFNULL(bank_minus,0)-IFNULL(bank_plus,0))>0");
            $rowCount = 2;
            $user_id = Auth::user()->id;
            foreach ($Select_db as $Select_dbdb) {
                $settlement_ids = $Select_dbdb->drivers_saned_settlement_IDs;
                $settlement_id_arr = explode('*', $settlement_ids);
                foreach ($settlement_id_arr as $settlement_id) {
                    DB::update("Update drivers_saned_settlement set export_attempt = export_attempt + 1, status = 'Onhold', exported_by = '$user_id', updated_by = '$user_id', updated_at = NOW() where id = '$settlement_id'");
                    $settlementids[] = $settlement_id;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->bank_minus_plus)
                    ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
                    ->SetCellValue('I' . $rowCount, $Select_dbdb->AMP_IDs)
                    ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
                    ->SetCellValue('K' . $rowCount, $Select_dbdb->drivers_saned_settlement_IDs)
                    ->SetCellValue('L' . $rowCount, $Select_dbdb->drivers_jahiz_clearing_IDs)
                    ->SetCellValue('M' . $rowCount, $Select_dbdb->bank_paid);

                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);


                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
                    ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
                    ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('rgb' => '000000')
                            )
                        ),
                        'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
                $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
                $rowCount++;

            }
             
            $objPHPExcel->setActiveSheetIndex(0);
            $date = date("Y-m-d H-i-s");
            $fileName = 'JAHIZ'.'_STCPayExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            
             DB::table('drivers_saned_export_excel')->insert(
                ['user_id' => Auth::user()->id,
                    'fileName' => $fileName,
                    'create_at' => date("Y-m-d H:i:s")
                ]
            );
            
            exit;

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
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
            header('Content-type: html/plain');
            header('Content-Disposition: attachment; filename="غير مدخل.html"');
            print($txtFile);
        }
        if(count($settlementids) > 0) {
            $made_by = Auth::user()->name;
            $msg = "<b>$made_by</b> updated(exported) the Saned Sattlement from Ready to Onhold";
            HelperFunctionsController::add_log($msg, '', $settlementids);
        }
        exit;
    }
//*************************************************************************************************************************
//*************************************************************************************************************************
    public function ExportSalarySTCShe(Request $request)
    {
        $user_id = Auth::user()->id;
        error_reporting(E_ALL);
        $notNullFile = false;
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Reference Number')
            ->setCellValueExplicit('B1', 'Telephone Number')
            ->setCellValue('C1', 'Amount')
            ->setCellValue('E2', 'Total Amount')
            ->setCellValue('F2', '=SUM(C:C)');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(37);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getStyle("E2:F2")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("C1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                ),
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

    
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
                (" . $request->SQL . "
                                ) a
                WHERE account_owner_iqama IS NOT NULL
                AND iqama IS NOT NULL
                AND accountNumber IS NOT NULL
                AND account_owner_iqama REGEXP '^[0-9]+$'
                AND iqama REGEXP '^[0-9]+$'
                AND accountNumber REGEXP '^[0-9]+$'
                AND LENGTH(account_owner_iqama) = 10
                AND LENGTH(iqama) = 10
                AND LENGTH(accountNumber) = 12
                AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
                AND SUBSTR(iqama, 1, 1) in('1','2')
                AND SUBSTR(accountNumber, 1, 3) =('966')
                AND edit_salary>0
                GROUP BY account_owner_iqama,accountNumber");
                
                // SELECT
                // account_owner_iqama,
                // accountNumber,
                // SUM(edit_salary) as edit_salary,
                // GROUP_CONCAT(edit_salary SEPARATOR '*') as bank_paid,
                // count(*) AS CO,
                // GROUP_CONCAT(driverId SEPARATOR '*') as drivers_IDs,
                // GROUP_CONCAT(job_id SEPARATOR '*') as job_ids,
                // GROUP_CONCAT(fullName SEPARATOR '*') as DriverNames
                // FROM
                // (" . $request->SQL . "
                //                 ) a
                // WHERE account_owner_iqama IS NOT NULL
                // AND accountNumber IS NOT NULL
                // AND account_owner_iqama REGEXP '^[0-9]+$'
                // AND accountNumber REGEXP '^[0-9]+$'
                // AND LENGTH(account_owner_iqama) = 10
                // AND LENGTH(accountNumber) = 12
                // AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
                // AND SUBSTR(accountNumber, 1, 3) =('966')
                // AND edit_salary>0
                // GROUP BY account_owner_iqama,accountNumber");
            
            $rowCount = 2;
            
            $Period = explode(' - ', $request->from_to);
            $from = $Period[0];
            $to = $Period[1];
            $amp_ids = $salaryids = array();
            foreach ($Select_db as $Select_dbdb) {
                 if($Select_dbdb->edit_salary < 1)
                    continue;
                $driver_ids = $Select_dbdb->drivers_IDs;
                $driver_ids = explode("*",$driver_ids);
                foreach($driver_ids as $driver_id) {
                    $salary = DB::select("SELECT id, export_attempt from journal where driverId = '$driver_id' AND journal_date BETWEEN '$from' AND '$to'");
                    $export_attempt = $salary[0]->export_attempt;
                    $export_attempt += 1;
                    DB::update("Update journal set export_attempt = '$export_attempt', status = 'Onhold', exported_by = '$user_id', updatedby_id = '$user_id', updated_at = NOW() where driverId = '$driver_id' AND journal_date BETWEEN '$from' AND '$to'");
                    $salaryids[] = $salary[0]->id;
                    $driver = HelperFunctionsController::getDriverData($driver_id);
                    $amp_ids[] = $driver->job_id;
                }

                Exported_record::create([
                    'account_owner_iqama'=>$Select_dbdb->account_owner_iqama,
                    'accountNumber'=>$Select_dbdb->accountNumber,
                    'edit_salary'=>(int)$Select_dbdb->edit_salary,
                    'bank_paid'=>$Select_dbdb->bank_paid,
                    'CO'=>$Select_dbdb->CO,
                    'drivers_IDs'=>$Select_dbdb->drivers_IDs,
                    'job_ids'=>$Select_dbdb->job_ids,
                    'DriverNames'=>$Select_dbdb->DriverNames,
                    'PeriodName'=>$request->PeriodName,
                    'company_Id'=>$request->company_Id,
                    'created_by'=>Auth::user()->id
                ]);

                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->edit_salary)
                    ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
                    ->SetCellValue('I' . $rowCount, $Select_dbdb->job_ids)
                    ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
                    ->SetCellValue('K' . $rowCount, $Select_dbdb->bank_paid);
                
                    $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);

                    $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                    $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                    
                    $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000')
                                )
                            ),
                            'alignment' => array(
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
                    $rowCount++;
                }
            
            $objPHPExcel->setActiveSheetIndex(0);
            $date = date("Y-m-d H-i-s");
            $fileName = $request->companyName.'_'.$request->company_Id.'_'.$request->PeriodName.'_STCPayExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            //return(public_path() . '/SANEDSettledExcel/' . $fileName);
            $objWriter->save('php://output');
            if(count($amp_ids) > 0) {
                $made_by = Auth::user()->name;
                $amp_ids = implode(',', $amp_ids);
                $msg = "<b>$made_by</b> updated(exported) the journal(salary) with driver amp_ids ('$amp_ids') to Onhold";
                HelperFunctionsController::add_log($msg, '', $salaryids);
            }
            exit;

    }
    
    
    public function ExportSalarySTC(Request $request)
    {
        // dd($request->PeriodName());
        error_reporting(E_ALL);
        $notNullFile = false;
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Reference Number')
            ->setCellValueExplicit('B1', 'Telephone Number')
            ->setCellValue('C1', 'Amount')
            ->setCellValue('E2', 'Total Amount')
            ->setCellValue('F2', '=SUM(C:C)');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(37);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getStyle("E2:F2")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("C1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                ),
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

    
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
                (" . $request->SQL . "
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
            
            foreach ($Select_db as $Select_dbdb) {
                 if($Select_dbdb->edit_salary < 1)
                    continue;

                $check_if_exported_before = Exported_record::where([
                    ['account_owner_iqama',$Select_dbdb->account_owner_iqama],
                    ['accountNumber',$Select_dbdb->accountNumber],
                    ['edit_salary', (int)$Select_dbdb->edit_salary],
                    ['bank_paid',$Select_dbdb->bank_paid],
                    ['CO',$Select_dbdb->CO],
                    ['drivers_IDs',$Select_dbdb->drivers_IDs],
                    ['job_ids',$Select_dbdb->job_ids],
                    ['DriverNames',$Select_dbdb->DriverNames]
                ])->get(); 
                
                // if(count($check_if_exported_before)>0){

                // }else{
                    // $notNullFile = true;
                    Exported_record::create([
                        'account_owner_iqama'=>$Select_dbdb->account_owner_iqama,
                        'accountNumber'=>$Select_dbdb->accountNumber,
                        'edit_salary'=>(int)$Select_dbdb->edit_salary,
                        'bank_paid'=>$Select_dbdb->bank_paid,
                        'CO'=>$Select_dbdb->CO,
                        'drivers_IDs'=>$Select_dbdb->drivers_IDs,
                        'job_ids'=>$Select_dbdb->job_ids,
                        'DriverNames'=>$Select_dbdb->DriverNames,
                        'PeriodName'=>$request->PeriodName,
                        'company_Id'=>$request->company_Id,
                        'created_by'=>Auth::user()->id
                    ]);

                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->edit_salary)
                    ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
                    ->SetCellValue('I' . $rowCount, $Select_dbdb->job_ids)
                    ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
                    ->SetCellValue('K' . $rowCount, $Select_dbdb->bank_paid);
                
                    $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);

                    $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                    $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                    
                    $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000')
                                )
                            ),
                            'alignment' => array(
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
                    $rowCount++;
                }
               
            // }
            
            $objPHPExcel->setActiveSheetIndex(0);
            $date = date("Y-m-d H-i-s");
            //  if($notNullFile == true){
                
             
                $fileName = $request->companyName.'_'.$request->company_Id.'_'.$request->PeriodName.'_STCPayExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $fileName . '"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

                //return(public_path() . '/SANEDSettledExcel/' . $fileName);
                $objWriter->save('php://output');
            // }else{
            //     // echo "<script>alert('There is no data to Extract')</script>";
            //     return redirect()->back()->with('message', 'There are no reliable records to Export, Please check the Unpaid Salary Tab For more Payable transactions from ');
            // }

            exit;

    }
//*************************************************************************************************************************
//*************************************************************************************************************************
    public function ExportChefzSTC(Request $request)
    {
//return $request->SQL;
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Reference Number')
            ->setCellValueExplicit('B1', 'Telephone Number')
            ->setCellValue('C1', 'Amount')
            ->setCellValue('E2', 'Total Amount')
            ->setCellValue('F2', '=SUM(C:C)');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(37);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getStyle("E2:F2")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("C1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                ),
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

//return $request->SQL;
        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Select_db = DB::select("
            SELECT
                account_owner_iqama,
                accountNumber,
                SUM(Salary) as edit_salary,
                GROUP_CONCAT(Salary SEPARATOR '*') as bank_paid,
                count(*) AS CO,
                GROUP_CONCAT(id SEPARATOR '*') as chefz_settlement_IDs,
                GROUP_CONCAT(driverId SEPARATOR '*') as drivers_IDs,
                GROUP_CONCAT(job_id SEPARATOR '*') as job_ids,
                GROUP_CONCAT(fullName SEPARATOR '*') as DriverNames
                FROM
                (" . $request->SQL . "
                                ) a
                WHERE account_owner_iqama IS NOT NULL
                AND accountNumber IS NOT NULL
                AND account_owner_iqama REGEXP '^[0-9]+$'
                AND accountNumber REGEXP '^[0-9]+$'
                AND LENGTH(account_owner_iqama) = 10
                AND LENGTH(accountNumber) = 12
                AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
                AND SUBSTR(accountNumber, 1, 3) =('966')
                GROUP BY account_owner_iqama,accountNumber");
        $rowCount = 2;
        foreach ($Select_db as $Select_dbdb) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->edit_salary)
                ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
                ->SetCellValue('I' . $rowCount, $Select_dbdb->job_ids)
                ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
                ->SetCellValue('K' . $rowCount, $Select_dbdb->chefz_settlement_IDs)
                ->SetCellValue('L' . $rowCount, $Select_dbdb->bank_paid);

            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);


            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    ),
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
            $rowCount++;

        }


        $objPHPExcel->setActiveSheetIndex(0);
        $date = date("Y-m-d H-i-s");
        $fileName = $request->companyName.'_'.$request->PeriodName.'_STCPayExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


        //return(public_path() . '/SANEDSettledExcel/' . $fileName);
        $objWriter->save('php://output');
        exit;

    }
    //*************************************************************************************************************************
//*************************************************************************************************************************
    public function ExportLoanSTC(Request $request)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Reference Number')
            ->setCellValueExplicit('B1', 'Telephone Number')
            ->setCellValue('C1', 'Amount')
            ->setCellValue('E2', 'Total Amount')
            ->setCellValue('F2', '=SUM(C:C)');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(37);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getStyle("E2:F2")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("C1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                ),
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Select_db = DB::select("
            SELECT
                account_owner_iqama,
                accountNumber,
                SUM(amount) as edit_salary,
                GROUP_CONCAT(amount SEPARATOR '*') as bank_paid,
                count(*) AS CO,
                GROUP_CONCAT(driverId SEPARATOR '*') as drivers_IDs,
                GROUP_CONCAT(job_id SEPARATOR '*') as job_ids,
                GROUP_CONCAT(fullName SEPARATOR '*') as DriverNames,
                GROUP_CONCAT(id SEPARATOR '*') as Loan_IDs
                FROM
                (" . $request->SQL . "
                                ) a
                WHERE account_owner_iqama IS NOT NULL
                AND accountNumber IS NOT NULL
                AND account_owner_iqama REGEXP '^[0-9]+$'
                AND accountNumber REGEXP '^[0-9]+$'
                AND LENGTH(account_owner_iqama) = 10
                AND LENGTH(accountNumber) = 12
                AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
                AND SUBSTR(accountNumber, 1, 3) =('966')
                GROUP BY account_owner_iqama,accountNumber");
        $rowCount = 2;
        foreach ($Select_db as $Select_dbdb) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->edit_salary)
                ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
                ->SetCellValue('I' . $rowCount, $Select_dbdb->job_ids)
                ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
                ->SetCellValue('K' . $rowCount, $Select_dbdb->bank_paid)
                ->SetCellValue('L' . $rowCount, $Select_dbdb->Loan_IDs);

            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);


            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    ),
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
            $rowCount++;

        }


        $objPHPExcel->setActiveSheetIndex(0);
        $date = date("Y-m-d H-i-s");
        $fileName = 'Loans_STCPayExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


        //return(public_path() . '/SANEDSettledExcel/' . $fileName);
        $objWriter->save('php://output');
        exit;

    }
    
    public function ExportLoanSheSTC(Request $request)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Reference Number')
            ->setCellValueExplicit('B1', 'Telephone Number')
            ->setCellValue('C1', 'Amount')
            ->setCellValue('E2', 'Total Amount')
            ->setCellValue('F2', '=SUM(C:C)');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24.89);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(37);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->getActiveSheet()->getStyle("E2:F2")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("C1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                ),
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);
        $loanids = array();
        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Select_db = DB::select("
            SELECT
                iqama,
                account_owner_iqama,
                accountNumber,
                SUM(amount) as edit_salary,
                GROUP_CONCAT(amount SEPARATOR '*') as bank_paid,
                count(*) AS CO,
                GROUP_CONCAT(driverId SEPARATOR '*') as drivers_IDs,
                GROUP_CONCAT(job_id SEPARATOR '*') as job_ids,
                GROUP_CONCAT(fullName SEPARATOR '*') as DriverNames,
                GROUP_CONCAT(id SEPARATOR '*') as Loan_IDs
                FROM
                (" . $request->SQL . "
                                ) a
                WHERE account_owner_iqama IS NOT NULL
                AND iqama IS NOT NULL
                AND accountNumber IS NOT NULL
                AND account_owner_iqama REGEXP '^[0-9]+$'
                AND iqama REGEXP '^[0-9]+$'
                AND accountNumber REGEXP '^[0-9]+$'
                AND LENGTH(account_owner_iqama) = 10
                AND LENGTH(iqama) = 10
                AND LENGTH(accountNumber) = 12
                AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
                AND SUBSTR(iqama, 1, 1) in('1','2')
                AND SUBSTR(accountNumber, 1, 3) =('966')
                GROUP BY iqama,account_owner_iqama,accountNumber");
                // WHERE account_owner_iqama IS NOT NULL
                // AND accountNumber IS NOT NULL
                // AND account_owner_iqama REGEXP '^[0-9]+$'
                // AND accountNumber REGEXP '^[0-9]+$'
                // AND LENGTH(account_owner_iqama) = 10
                // AND LENGTH(accountNumber) = 12
                // AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
                // AND SUBSTR(accountNumber, 1, 3) =('966')
                // GROUP BY account_owner_iqama,accountNumber");
        $rowCount = 2;
        $user_id = Auth::user()->id;
        foreach ($Select_db as $Select_dbdb) {
                $loan_ids = $Select_dbdb->Loan_IDs;
                $loan_id_arr = explode('*', $loan_ids);
                foreach ($loan_id_arr as $loan_id) {
                    DB::update("UPDATE loan SET export_attempt = export_attempt + 1, status = 'Onhold', exported_by = '$user_id', updated_by = '$user_id', updated_at = NOW() WHERE id = '$loan_id'");
                    $loanids[] = $loan_id;
                }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->account_owner_iqama, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->accountNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                ->SetCellValue('C' . $rowCount, (int)$Select_dbdb->edit_salary)
                ->SetCellValue('H' . $rowCount, $Select_dbdb->CO)
                ->SetCellValue('I' . $rowCount, $Select_dbdb->job_ids)
                ->SetCellValue('J' . $rowCount, $Select_dbdb->DriverNames)
                ->SetCellValue('K' . $rowCount, $Select_dbdb->bank_paid)
                ->SetCellValue('L' . $rowCount, $Select_dbdb->Loan_IDs);

            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->getFont()->setSize(14);


            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle("C$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:C$rowCount")->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    ),
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
            $rowCount++;

        }


        $objPHPExcel->setActiveSheetIndex(0);
        $date = date("Y-m-d H-i-s");
        $fileName = 'Loans_STCPayExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


        //return(public_path() . '/SANEDSettledExcel/' . $fileName);
        $objWriter->save('php://output');
        if(count($loanids) > 0) {
            $made_by = Auth::user()->name;
            $msg = "<b>$made_by</b> updated(exported) the Loan from Ready to Onhold";
            HelperFunctionsController::add_log($msg, '', $loanids);
        }
        exit;

    }
}

