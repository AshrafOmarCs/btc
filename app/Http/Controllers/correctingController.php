<?php

namespace App\Http\Controllers;
use App\Exports\UsersExport;
use App\Exports\JournalExport;
use DB;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class correctingController extends Controller
{
    //
    public function SANEDPaidSaveSaned(Request $request)
    {
        # code...
        dd($request->all());

        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);


        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');

        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();


        $date = date("Y-m-d H:i:s");

        $id = DB::table('drivers_saned_import_paid_master')->insertGetId(
            ['user_id' => Auth::user()->id,
                'fileName' => $request->file('select_file')->getClientOriginalName(),
                'create_at' => $date]
        );

        $values = '';

        for ($row = 2; $row <= $lastRow; $row++) {
            //return $worksheet->getCell('A' . $row)->getValue();
            $Select_db = DB::table(DB::raw("(select SUM(SANED_amount) as SANED_amount,SUM(Jahiz_Amount) as Jahiz_Amount,SUM(bank_balance)as bank_balance from
                                    (
                                    select drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit AS SANED_amount,0 AS Jahiz_Amount,0 AS bank_balance
                                    from drivers_saned_settlement
                                    where id in(" . str_replace('*', ',', $worksheet->getCell('K' . $row)->getValue()) . ")
                                     UNION
                                    select 0,CASE
                                                 WHEN Jahiz_Amount_Sign = 1 THEN Jahiz_Amount
                                                 WHEN Jahiz_Amount_Sign = 2 THEN
                                                 Jahiz_Amount *-1
                                                 END AS Jahiz_Amount,

                                                 CASE
                                                 WHEN clearing_type_id = 1 THEN
                                                 CAST(FLOOR(bank) AS SIGNED )*-1
                                                 WHEN clearing_type_id = 2 THEN
                                                 FLOOR(bank)
                                                 END AS bank_balance

                                    from drivers_jahiz_clearing
                                    where id in(" . str_replace('*', ',', $worksheet->getCell('L' . $row)->getValue()) . "))a) as sub"))
                ->first();

            $drivers_saned_settlement_IDs = explode("*", $worksheet->getCell('K' . $row)->getValue());
            $drivers_jahiz_clearing_IDs = explode("*", $worksheet->getCell('L' . $row)->getValue());
            $AMP_IDs = explode("*", $worksheet->getCell('I' . $row)->getValue());
            $bank_paid = explode("*", $worksheet->getCell('M' . $row)->getValue());

            if (floatval($Select_db->SANED_amount) == floatval($Select_db->Jahiz_Amount) && floatval($Select_db->bank_balance) == floatval($worksheet->getCell('C' . $row)->getValue())) {
                for ($i = 0; $i < count($drivers_saned_settlement_IDs); $i++) {

                    $values .= "(" . $id . ",
                             " . $drivers_saned_settlement_IDs[$i] . ",
                             " . $drivers_jahiz_clearing_IDs[$i] . ",
                             '" . $AMP_IDs[$i] . "',
                             " . $worksheet->getCell('A' . $row)->getValue() . ",
                             '" . $worksheet->getCell('B' . $row)->getValue() . "',
                             " . $worksheet->getCell('C' . $row)->getValue() . ",
                             " . $worksheet->getCell('H' . $row)->getValue() . ",
                             " . $bank_paid[$i] . ",
                               1),";

                    try {
                        DB::update(" UPDATE drivers_saned_settlement
                    SET drivers_jahiz_clearing_paid_id = " . $drivers_jahiz_clearing_IDs[$i] . ",
                        paid_dt = '" . $date . "',
                        paid_by_id = " . Auth::user()->id . "
                    where id = " . $drivers_saned_settlement_IDs[$i]);


                        DB::update(" UPDATE drivers_jahiz_clearing
                    SET paid_id = " . $drivers_saned_settlement_IDs[$i] . ",
                        paid_dt = '" . $date . "',
                        paid_by_id = " . Auth::user()->id . "
                    where id = " . $drivers_jahiz_clearing_IDs[$i]);

                    } catch (\Illuminate\Database\QueryException $e) {
                        return redirect('/SANEDPaid')->with('error', $e->getPrevious()->getMessage());
                    }
                }
            } else {
                for ($i = 0; $i < count($drivers_saned_settlement_IDs); $i++) {
                    $values .= "(" . $id . ",
                             " . $drivers_saned_settlement_IDs[$i] . ",
                             " . $drivers_jahiz_clearing_IDs[$i] . ",
                             '" . $AMP_IDs[$i] . "',
                             " . $worksheet->getCell('A' . $row)->getValue() . ",
                             '" . $worksheet->getCell('B' . $row)->getValue() . "',
                             " . $worksheet->getCell('C' . $row)->getValue() . ",
                             " . $worksheet->getCell('H' . $row)->getValue() . ",
                             " . $bank_paid[$i] . ",
                               0),";
                }
            }

        }

        $values = substr($values, 0, strlen($values) - 1);

        //return $values;
        if ($values <> '') {
            try {
                DB::insert("insert  into drivers_saned_import_paid_details
                    (paid_master_id, drivers_saned_settlement_id, drivers_jahiz_clearing_id,
                        AMP_ID, account_owner_iqama, accountNumber, bank_minus_plus, CO,
                        bank_paid,paid)
                  VALUES
                  " . $values);
            } catch (\Illuminate\Database\QueryException $e) {
                return view('SANED.SANEDPaid')->with('error', $e->getPrevious()->getMessage());
            }
        }
        return $this->SANEDPaid($request)->with('success', 'Done successfully');
    }
    public function index()
    {
        # code...
        $payload = DB::select('select * from users');
        // dd($payload);
        return Excel::download(new JournalExport(), 'SanadStcPay.xlsx');
        return Excel::download(new JournalExport, 'test.xlsx');
        return 'maping';
    }
}
