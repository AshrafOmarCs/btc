<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Date;
use PHPExcel_Style_NumberFormat;


class ChefzController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (!request()->ajax()) {
            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
                INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
                where companyId=7 AND user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $wher = ' where warehouse.id in(' . implode(",", $whereIn_array) . ') ';
            } else
                $wher = ' where companyId=7 ';
            $warehouse = DB::select('SELECT * from warehouse ' . $wher . ' order by warehouseName ');
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
            $lkp_chefz_period = DB::select("SELECT lkp_chefz_period.id,Invoice_From_Date,Invoice_To_Date
            from lkp_chefz_period order by Invoice_To_Date desc");


        }
//***********************************************************************************************************************
//***********************************************************************************************************************

        elseif (request()->ajax()) {

            $Select_db = DB::table('chefz_settlement')
                ->select(DB::raw("chefz_settlement.id,paid_id,Invoice_To_Date,Order_Total_isPaid_NO,Total_Delivery_Fees,
                Total_Delivery_Fees_VAT,Bouns,Deduction ,drivers.id as driverId,drivers.account_owner_iqama, accountNumber,
                Compensation,chefz_settlement.numberOfDispatch,Bander_Commission,Salary,
                warehouseName,job_id, drivers.fullName as fullName"))
                ->leftJoin('drivers', 'chefz_settlement.driverId', '=', 'drivers.id')
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_chefz_period', 'chefz_settlement.chefz_period_id', '=', 'lkp_chefz_period.id');


//return  $request->filter_week1;
            $Select_sum = DB::table('chefz_settlement')
                ->select(DB::raw("SUM(Order_Total_isPaid_NO) as Order_Total_isPaid_NO,
                SUM(Total_Delivery_Fees) as Total_Delivery_Fees,
                SUM(Total_Delivery_Fees_VAT) as Total_Delivery_Fees_VAT,
                SUM(Bouns) AS Bouns,SUM(Deduction) as Deduction ,
                SUM(Compensation) as Compensation,SUM(chefz_settlement.numberOfDispatch) as numberOfDispatch,
                SUM(Bander_Commission) as Bander_Commission,SUM(Salary) as Salary
            "))
                ->leftJoin('drivers', 'chefz_settlement.driverId', '=', 'drivers.id')
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_chefz_period', 'chefz_settlement.chefz_period_id', '=', 'lkp_chefz_period.id');


            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege  inner join warehouse on warehouse.id=users_privilege.warehouseId
                               where companyId=7 AND user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $Select_db->whereRaw('warehouseId in(' . implode(",", $whereIn_array) . ')');
                $Select_sum->whereRaw('warehouseId in(' . implode(",", $whereIn_array) . ')');
            }

            if (!empty($request->filter_warehouseId)) {
                $Select_db->whereRaw('warehouseId=' . $request->filter_warehouseId);
                $Select_sum->whereRaw('warehouseId=' . $request->filter_warehouseId);
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
                $Select_sum->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->whereRaw('drivers.id=' . $request->filter_driverId);
                $Select_sum->whereRaw('drivers.id=' . $request->filter_driverId);
            }

            if (!empty($request->filter_chefz_period_id)) {
                $Select_db->whereRaw('chefz_period_id=' . $request->filter_chefz_period_id);
                $Select_sum->whereRaw('chefz_period_id=' . $request->filter_chefz_period_id);

            }

            if ($request->filter_paid_id <> "") {
                if ($request->filter_paid_id == "1") {
                    $Select_db->whereRaw("chefz_settlement.paid_id is not null ");
                    $Select_sum->whereRaw("chefz_settlement.paid_id is not null ");
                }
                if ($request->filter_paid_id == "2") {
                    $Select_db->whereRaw("chefz_settlement.paid_id is  null ");
                    $Select_sum->whereRaw("chefz_settlement.paid_id is  null ");
                }
            }
            if (!empty($request->filter_SettledDate)) {
                $filter_SettledDate = explode(" - ", $request->filter_SettledDate);
                $Select_db->whereRaw("CAST(lkp_chefz_period.Invoice_To_Date as date) between STR_TO_DATE('$filter_SettledDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_SettledDate[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(lkp_chefz_period.Invoice_To_Date as date) between STR_TO_DATE('$filter_SettledDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_SettledDate[1]','%d/%m/%Y')");
            }


            /* if(isset($_REQUEST['search']['value'])&&$_REQUEST['search']['value']<>'') {
                  $options = strtolower($_REQUEST['search']['value']);
                  $Select_sum->whereRaw("(
              LOWER(
                  `warehouse`.`warehouseName`
              ) LIKE '%" . $options . "%'
              OR LOWER(`drivers`.`job_id`) LIKE '%" . $options . "%'
              OR LOWER(`drivers`.`fullName`) LIKE '%" . $options . "%'
              OR LOWER(`lkp_driver_type`.`driver_type`) LIKE '%" . $options . "%'

             )");
              }
            */

            //return $Select_db->toSql();
            //return $Select_sum->toSql();
            $Select_sum = $Select_sum->first();
            return datatables()->of($Select_db)
                ->with('Order_Total_isPaid_NO', '<b>' . $Select_sum->Order_Total_isPaid_NO . '</b>')
                ->with('Total_Delivery_Fees', '<b>' . $Select_sum->Total_Delivery_Fees . '</b>')
                ->with('Total_Delivery_Fees_VAT', '<b>' . $Select_sum->Total_Delivery_Fees_VAT . '</b>')
                ->with('Bouns', '<b>' . $Select_sum->Bouns . '</b>')
                ->with('Deduction', '<b>' . $Select_sum->Deduction . '</b>')
                ->with('Compensation', '<b>' . $Select_sum->Compensation . '</b>')
                ->with('numberOfDispatch', '<b>' . $Select_sum->numberOfDispatch . '</b>')
                ->with('Bander_Commission', '<b>' . $Select_sum->Bander_Commission . '</b>')
                ->with('Salary', '<b>' . $Select_sum->Salary . '</b>')
                ->with('SQL', $Select_db->toSql())
                ->make(true);

            //return $Select_db->toSql();
            //return datatables()->of($Select_db)->make(true);
        }

        //$data = $Select_db->get();

        return view('Chefz.index')
            ->with(compact('warehouse'))
            ->with(compact('lkp_driver_type'))
            ->with(compact('lkp_chefz_period'));


    }
//****************************************************************************************************************
//****************************************************************************************************************
    public function ChefzImportInvoice(Request $request)
    {

        return view('Chefz.ChefzImportInvoice');
    }
//****************************************************************************************************************
//****************************************************************************************************************
    /**
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ChefzImportInvoiceSave(Request $request)
    {

        //return $request->file('select_file');
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        try {
            $id = DB::table('lkp_chefz_period')->insertGetId(
                [
                    'Invoice_From_Date' => \DateTime::createFromFormat('d/m/Y', $request->input('Invoice_From_Date'))->format('Y-m-d'),
                    'Invoice_To_Date' => \DateTime::createFromFormat('d/m/Y', $request->input('Invoice_To_Date'))->format('Y-m-d'),
                    'createdby_id' => Auth::user()->id,
                    'created_at' => date("Y-m-d H:i:s")
                ]
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return view('Chefz.ChefzImportInvoice')->with('error', $e->getPrevious()->getMessage());
        }


        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');

        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();


        $table = '';
        $values = '';
        $table .= "<center><table border='1' id='customer_data' class='table table-bordered table-striped' style='width: auto!important;'>
          <tr>
          <TH>#</TH>
          <TH>Date Number</TH>
          <TH>Order Number</TH>
          <TH>Driver Name</TH>
          <TH>Driver ID Number</TH>
          <TH>Order Total</TH>
          <TH>Chef Total</TH>
          <TH>isPaid</TH>
          <TH>Original Total Delivery Fees</TH>
          <TH>Bouns</TH>
          <TH>Deduction</TH>
          <TH>Compensation</TH>

          </tr>";

        for ($i = 65; $i <= 90; $i++) {
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Date')) !== false) $Date = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Order Number')) !== false) $Order_Number = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Driver Name')) !== false) $Driver_Name = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Driver ID')) !== false) $Driver_ID = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Order Total')) !== false) $Order_Total = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Chef Total')) !== false) $Chef_Total = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('isPaid')) !== false) $isPaid = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Delivery')) !== false) $Delivery = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Bonus')) !== false || strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Bouns')) !== false) $Bonus = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Deduction')) !== false) $Deduction = chr($i);
            if (strpos(strtoupper($worksheet->getCell(chr($i) . '1')->getValue()), strtoupper('Compensation')) !== false) $Compensation = chr($i);
        }
        if (!isset($Order_Number))
            return view('Chefz.ChefzImportInvoice')->with('error', 'Format Error');

        for ($row = 2; $row <= $lastRow; $row++) {
            //return PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCell($Date . $row)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
            if ($worksheet->getCell($Date . $row)->getValue()=='')
                break;
            $table .= "<tr><td>";
            $table .= $row - 1;
            $table .= "</td><td>";
            $table .= PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCell($Date . $row)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Order_Number . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Driver_Name . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Driver_ID . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Order_Total . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Chef_Total . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($isPaid . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Delivery . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Bonus . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Deduction . $row)->getValue();
            $table .= "</td><td>";
            $table .= $worksheet->getCell($Compensation . $row)->getValue();
            $table .= "</td></tr>";

            if ($worksheet->getCell($Deduction . $row)->getValue() == '') $Deduct = '0'; else $Deduct = $worksheet->getCell($Deduction . $row)->getValue();
            $values .= "(
                              " . $id . ",
                              '" . PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCell($Date . $row)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2) . "',
                              '" . $worksheet->getCell($Order_Number . $row)->getValue() . "',
                              '" . $worksheet->getCell($Driver_Name . $row)->getValue() . "',
                              '" . $worksheet->getCell($Driver_ID . $row)->getValue() . "',
                              '" . $worksheet->getCell($Order_Total . $row)->getValue() . "',
                              '" . $worksheet->getCell($Chef_Total . $row)->getValue() . "',
                              '" . $worksheet->getCell($isPaid . $row)->getValue() . "',
                              '" . $worksheet->getCell($Delivery . $row)->getValue() . "',
                              '" . $worksheet->getCell($Bonus . $row)->getValue() . "',
                              '" . $Deduct . "',
                              '" . $worksheet->getCell($Compensation . $row)->getValue() . "'
                              ),";


        }
        $table .= "</table></center>";
        //return $values;
        $values = substr($values, 0, strlen($values) - 1);
        if ($values <> '') {
            try {

                DB::insert("insert  into chefz_dispatch (chefz_period_id,Date_Number,Order_Number,
                                  Driver_Name,Driver_ID,Order_Total,Chef_Total,isPaid,
                                  Total_Delivery_Fees,Bouns,Deduction,Compensation)
                   VALUES
                   " . $values);
            } catch (\Illuminate\Database\QueryException $e) {
                return view('Chefz.ChefzImportInvoice')->with('error', $e->getPrevious()->getMessage());
            }
        }

        $chefz_dispatch = DB::select("SELECT
                       Driver_Name,
                       Driver_ID,
                       Order_Total_isPaid_NO,
                       Total_Delivery_Fees,
                       Total_Delivery_Fees_VAT,
                       Bouns,
                       Deduction,
                       Compensation,
                       numberOfDispatch,
                       ROUND(Total_Delivery_Fees_VAT - Order_Total_isPaid_NO + Bouns - Deduction + Compensation -(numberOfDispatch * 2), 2) AS Salary
                    FROM
                       (
                          SELECT
                             Driver_Name,
                             Driver_ID,
                             IFNULL(SUM(CASE WHEN isPaid = 'No' THEN IFNULL(Order_Total, 0) END), 0) Order_Total_isPaid_NO,
                             SUM(IFNULL(Total_Delivery_Fees, 0)) AS Total_Delivery_Fees,
                             ROUND(SUM(IFNULL(Total_Delivery_Fees, 0)) / 1.15, 2) AS Total_Delivery_Fees_VAT,
                             SUM(IFNULL(Bouns, 0)) AS Bouns,
                             SUM(IFNULL(Deduction, 0)) AS Deduction,
                             SUM(IFNULL(Compensation, 0)) AS Compensation,
                             count(*) AS numberOfDispatch
                          FROM
                             chefz_dispatch
                          WHERE
                             chefz_period_id = " . $id . "
                          GROUP BY
                             Driver_Name,
                             Driver_ID
                       ) b");
        foreach ($chefz_dispatch as $chefz_dispatchh) {
            $driverId = '';
            $drivers = collect(DB::select("Select drivers.id from drivers where job_id='Chefz_" . $chefz_dispatchh->Driver_ID . "'"))->first();
            if (empty($drivers->id)) {
                $driverId = DB::table('drivers')->insertGetId([
                    'warehouseId' => 218,
                    'fullName' => $chefz_dispatchh->Driver_Name,
                    'job_id' => 'Chefz_' . $chefz_dispatchh->Driver_ID,
                    'iqama' => $chefz_dispatchh->Driver_ID,
                    'status_id' => '1',
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            } else $driverId = $drivers->id;

            DB::table('chefz_settlement')->insert([
                'driverId' => $driverId,
                'chefz_period_id' => $id,
                'Order_Total_isPaid_NO' => $chefz_dispatchh->Order_Total_isPaid_NO,
                'Total_Delivery_Fees' => $chefz_dispatchh->Total_Delivery_Fees,
                'Total_Delivery_Fees_VAT' => $chefz_dispatchh->Total_Delivery_Fees_VAT,
                'Bouns' => $chefz_dispatchh->Bouns,
                'Deduction' => $chefz_dispatchh->Deduction,
                'Compensation' => $chefz_dispatchh->Compensation,
                'numberOfDispatch' => $chefz_dispatchh->numberOfDispatch,
                'Bander_Commission' => $chefz_dispatchh->numberOfDispatch * 2,
                'Salary' => $chefz_dispatchh->Salary,
                'created_at' => date("Y-m-d H:i:s")
            ]);

        }
        return view('Chefz.ChefzImportInvoice')->with(compact('table'))->with('success', 'Done successfully');
    }
    //****************************************************************************************************************
    //****************************************************************************************************************
    public function DriversChefzClearingPost(Request $request)
    {

        $date = date("Y-m-d H:i:s");
        for ($i = 0; $i < 105; $i++) {
            if (!empty($request->input('ID_' . $i))) {
                //$IDs .= $request->input('ID_' . $i) . ",";

                try {
                    DB::update(" UPDATE chefz_settlement
                    SET paid_id = 1,
                        paid_dt='" . $date . "',
                        paid_by_id=" . Auth::user()->id . "
                    where id =" . $request->input('ID_' . $i));




                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect('/DriversChefzClearing')->with('error', $e->getPrevious()->getMessage());
                }

            }
        }

        //return  $UPDATE;


        return redirect('/DriversChefzClearing')->with('success', 'Done successfully');

    }

}

