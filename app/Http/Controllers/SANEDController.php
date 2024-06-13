<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperFunctionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPExcel_IOFactory;
use Illuminate\Support\Facades\Storage;


class SANEDController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //****************************************************************************************************************
    //****************************************************************************************************************
    public function SANEDPaid(Request $request)
    {

        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Paid_DB = DB::table(DB::raw("(SELECT
           drivers_saned_import_paid_details.account_owner_iqama,
           drivers_saned_import_paid_details.accountNumber,
           drivers_saned_import_paid_details.bank_minus_plus,
           GROUP_CONCAT(drivers_saned_settlement.id SEPARATOR ';') AS id,
           GROUP_CONCAT(drivers_saned_settlement.AMP_ID SEPARATOR ';') AS AMP_ID,
           GROUP_CONCAT(drivers.fullName SEPARATOR ';') AS fullName,
           GROUP_CONCAT(SettledDate SEPARATOR ';') AS SettledDate,
           GROUP_CONCAT(drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit SEPARATOR ';') AS SANED_amount,
           GROUP_CONCAT(drivers_saned_settlement.drivers_jahiz_clearing_paid_id SEPARATOR ';') AS drivers_jahiz_clearing_paid_id,
           GROUP_CONCAT(drivers.id SEPARATOR ';') AS driverId,
           GROUP_CONCAT(warehouseName SEPARATOR ';') AS warehouseName,
           GROUP_CONCAT(driver_type SEPARATOR ';') AS driver_type,
           GROUP_CONCAT(Bander_Commission SEPARATOR ';') AS Bander_Commission,
           GROUP_CONCAT(CASE WHEN Jahiz_Amount_Sign = 1 THEN Jahiz_Amount WHEN Jahiz_Amount_Sign = 2 THEN Jahiz_Amount *- 1 END SEPARATOR ';') AS Jahiz_Amount,
           GROUP_CONCAT(IFNULL(CASE WHEN clearing_type_id = 1 THEN bank  END,'') SEPARATOR ';') AS bank_plus,
           GROUP_CONCAT(IFNULL(CASE WHEN clearing_type_id = 1 THEN cash  END,'') SEPARATOR ';') AS cash_plus,
           GROUP_CONCAT(IFNULL(FLOOR(CASE WHEN clearing_type_id = 2 THEN bank  END),'') SEPARATOR ';') AS bank_minus,
           GROUP_CONCAT(IFNULL(CASE WHEN clearing_type_id = 2 THEN cash  END,'') SEPARATOR ';') AS cash_minus,
           GROUP_CONCAT(drivers_jahiz_clearing.updated_at SEPARATOR ';') AS updated_at
        FROM
           `drivers_saned_settlement`
        LEFT JOIN `drivers` ON `drivers_saned_settlement`.`AMP_ID` = `drivers`.`job_id`
        LEFT JOIN `warehouse` ON `drivers`.`warehouseId` = `warehouse`.`id`
        LEFT JOIN `lkp_driver_type` ON `drivers`.`driver_type_id` = `lkp_driver_type`.`id`
        INNER JOIN drivers_saned_import_paid_details ON drivers_saned_import_paid_details.drivers_saned_settlement_id = drivers_saned_settlement.id
        AND paid_master_id = (SELECT MAX(id) FROM drivers_saned_import_paid_master)
        INNER JOIN drivers_jahiz_clearing ON drivers_jahiz_clearing.id = drivers_saned_import_paid_details.drivers_jahiz_clearing_id
        GROUP BY
           drivers_saned_import_paid_details.account_owner_iqama,
           drivers_saned_import_paid_details.accountNumber,
           drivers_saned_import_paid_details.bank_minus_plus) as sub"))->get();


        if (isset($success))
            return view('new_porttal.SANED.SANEDPaid')->with(compact('Paid_DB'))->with('success', $success);
        elseif (isset($error))
            return view('new_porttal.SANED.SANEDPaid')->with(compact('Paid_DB'))->with('error', $error);
        else
            return view('new_porttal.SANED.SANEDPaid')->with(compact('Paid_DB'));

    }
    //****************************************************************************************************************
    //****************************************************************************************************************
    /**
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \Illuminate\Validation\ValidationException
     */
    public function SANEDPaidSave(Request $request)
    {

        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);


        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');
        $fileSaved = \Storage::putFileAs('public/paid/saned', $tmpfname, $tmpfname->getClientOriginalName());

        if($fileSaved != true){
            return redirect()->back()->with('error', 'File is not saving properly');
            exit();
        }
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
        $settlement_ids = array();
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

            $user_id = Auth::user()->id;
            $drivers_saned_settlement_IDs = explode("*", $worksheet->getCell('K' . $row)->getValue());
            $drivers_jahiz_clearing_IDs = explode("*", $worksheet->getCell('L' . $row)->getValue());
            $AMP_IDs = explode("*", $worksheet->getCell('I' . $row)->getValue());
            $bank_paid = explode("*", $worksheet->getCell('M' . $row)->getValue());

            foreach($drivers_saned_settlement_IDs as $settlement_id) {
                DB::update("Update drivers_saned_settlement set status = 'Paid', exported_by = '$user_id', updated_by = '$user_id', updated_at = NOW() where id = '$settlement_id'");
                $settlement_ids[] = $settlement_id;
            }

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
        if(count($settlement_ids) > 0) {
            $made_by = Auth::user()->name;
            $msg = "<b>$made_by</b> Paid these settlements.";
            HelperFunctionsController::add_log($msg, '', $settlement_ids);
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
                return view('new_porttal.SANED.SANEDPaid')->with('error', $e->getPrevious()->getMessage());
            }
        }
        return $this->SANEDPaid($request)->with('success', 'Done successfully');
    }
//****************************************************************************************************************
//****************************************************************************************************************

}

