<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;

use App\Drivers;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use PDF_HTML;



function generateAndSendPdf($ref_no, $created_at, $company, $period)
{
    require_once(app_path() . '/Libraries/fpdf186/html2fpdf.php');
    $pdf=new PDF_HTML();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    // $pdf->Cell(0,10,'I, '.AUTH::user()->name.', holder of ID/residence number: '.AUTH::user()->IdentityNo.' and mobile number: '.AUTH::user()->phone.', pledge that ',0,1);
    // $pdf->Cell(0,10,'the information entered is correct and has been directly verified by the representatives.',0,1);
    // $pdf->Cell(0,10,'I bear full responsibility in the event of any error resulting in a financial transfer as a result of ',0,1);
    // $pdf->Cell(0,10,'entering/updating the representatives data.',0,1);
    // $pdf->Ln(20);
    // $pdf->Ln(20);
    // $pdf->Ln(20);
    // $pdf->Ln(20);
    // $pdf->Cell(0,10,'Bander Al Amir: ',0,1);
    // $pdf->Cell(30);
    // $pdf->Ln(20);
    // $pdf->Cell(0,10,'Signature: ________________________________________________',0,1);

    $pdf->Image(url('/undertake.png'),10,6,190);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(4);
    $pdf->Cell(4,17, strtoupper($ref_no),0,1);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(19);
    $pdf->Cell(41,52, AUTH::user()->phone . '                                          ' . AUTH::user()->IdentityNo . '                                                ' . AUTH::user()->name,0,1);
    $pdf->Cell(10);
    $pdf->Cell(44,-15, AUTH::user()->name . '                                                                     ' . AUTH::user()->IdentityNo . '                                            ' . AUTH::user()->phone,0,1);


    $pdf->Output();
    // Define the path to save the PDF
    $filePath = storage_path('app/public/pdfFiles/Acknowledgment of pledge '.AUTH::user()->name.'-'.$ref_no.'.pdf');

    // Ensure the directory exists
    if (!file_exists(dirname($filePath))) {
        mkdir(dirname($filePath), 0755, true);
    }
    // Output the PDF to the specified path
    $pdf->Output('F', $filePath);
    sendEmailWithAttachment($filePath, $company, $ref_no, $created_at, $period);
}
function sendEmailWithAttachment($pdfPath, $company = '', $ref_no = '', $created_at = '', $period = '')
{
    $email = AUTH::user()->email;
    $body = 'Dear '.AUTH::user()->name.', <br><br>
        This is an automated email to confirm <b>'.$company.' driver information</b> the reference No of the action: #<b>'.strtoupper($ref_no).'</b>, on <b>'.$created_at.'</b> for the period of (<b>'.$period.'</b>), Please reach the attachment section for downloading the <b>Acknowledgment of pledge pdf</b> file. <br><br>
        System feed ';
    Mail::send([], [], function ($message) use ($pdfPath, $body, $email) {
        $message->to($email)
            ->subject('Acknowledgment of pledge')
            ->setBody($body, 'text/html'); // Use setBody to set the email body
        $message->attach($pdfPath);
    });
}


class DriversController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     * @throws Exception
     */

    public function DriversSettlementGet($driverId, $jahiz_period_id) {
        $row = DB::select("SELECT * FROM drivers_jahiz_montly WHERE driverId = '$driverId' AND jahiz_period_id = '$jahiz_period_id'");
        if (count($row) > 0) {
            if ($row[0]->week1 != '')
                echo $row[0]->updated_at;
            else
                echo 0;
            echo ':::';
            if ($row[0]->week2 != '')
                echo $row[0]->updated_at;
            else
                echo 0;
            echo ':::';
            if ($row[0]->week3 != '')
                echo $row[0]->updated_at;
            else
                echo 0;
            echo ':::';
            if ($row[0]->week4 != '')
                echo $row[0]->updated_at;
            else
                echo 0;
            echo ':::';
            if ($row[0]->weekAll != '')
                echo $row[0]->updated_at;
            else
                echo 0;
            echo ':::';
            if ($row[0]->amount_by_days != '')
                echo $row[0]->amount_by_days;
            else
                echo 0;
        } else {
            echo 0;
            echo ':::';
            echo 0;
            echo ':::';
            echo 0;
            echo ':::';
            echo 0;
            echo ':::';
            echo 0;
            echo ':::';
            echo 0;
        }
    }

    public function attendance() {
        $user_id = Auth::user()->id;
        if (Auth::user()->user_type_id <> 1) {
            $lkp_company  = DB::select("SELECT DISTINCT lkp_company.id,lkp_company.companyName FROM `users_privilege` JOIN warehouse ON warehouse.id = users_privilege.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE users_privilege.user_id = '$user_id' AND lkp_company.id <> 6 AND lkp_company.status = 'active'");
        } else {
            $lkp_company  = DB::select("SELECT id, companyName FROM `lkp_company` WHERE lkp_company.id <> 6 AND lkp_company.status = 'active'");
        }

        return view('Drivers.attendance')->with(compact('lkp_company'));
    }
    public function attendance_search(Request $request) {
        $today = date("Y-m-d");
        $user_id = Auth::user()->id;
        $disabled = "";
        if ($today > $request->filter_date AND Auth::user()->user_type_id <> 1) {
            $disabled = "disabled";
        }
        $warehouse_clause_prev = get_warehouse_previlage();

        $warehouse_clause = $company_clause = "1 = 1";
        if (!empty($request->filter_warehouseId)) {
            $warehouse_clause = "warehouse.id = '$request->filter_warehouseId'";
        }
        if (!empty($request->filter_companyId)) {
            $company_clause = "lkp_company.id = '$request->filter_companyId'";
        }

        $drivers = DB::select("SELECT drivers.fullName,warehouse.warehouseName,lkp_city.name_en,drivers.job_id,vehicles.id as vehicle_id,vehicles.plate,lkp_company.companyName FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id INNER JOIN vehicles ON drivers.vehicle_id=vehicles.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE $warehouse_clause AND $company_clause $warehouse_clause_prev AND vehicles.maintenance_status IS NULL AND vehicles.vehicle_opreater_id <> '5'");

        $drivers = add_driver_attendance_status($drivers, $request);
        $response = generate_response($drivers, $disabled);

        return $response;
    }
    public function attendance_update(Request $request) {
        $user_id = Auth::user()->id;
        $today = date("Y-m-d");
        date_default_timezone_set('Asia/Riyadh');
        $current_time = date('h:i');
        if ($current_time < '23:00') {

            $warehouse_clause_prev = get_warehouse_previlage();
            $warehouse_clause = $company_clause = "1 = 1";
            if (!empty($request->filter_warehouseId)) {
                $warehouse_clause = "warehouse.id = '$request->filter_warehouseId'";
            }
            if (!empty($request->filter_companyId)) {
                $company_clause = "lkp_company.id = '$request->filter_companyId'";
            }
            $drivers = DB::select("SELECT drivers.id as driverId, drivers.fullName,warehouse.id as warehouse_id,warehouse.warehouseName,lkp_city.name_en,drivers.job_id,vehicles.id as vehicle_id,vehicles.plate,lkp_company.id as company_id,lkp_company.companyName,vehicle_models.monthly_rent FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id INNER JOIN vehicles ON drivers.vehicle_id=vehicles.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN vehicle_models ON vehicles.vehicle_model_id=vehicle_models.id WHERE $warehouse_clause AND $company_clause $warehouse_clause_prev");

            date_default_timezone_set('Asia/Riyadh');
            $now = date('Y-m-d H:i:s');
            $today = date("Y-m-d");

            foreach ($drivers as $driver) {
                $status_value = $request[$driver->job_id];
                if(empty($status_value))
                    continue;
                $del_result = DB::delete("DELETE FROM supervisors_missed_attendance WHERE JSON_LENGTH(warehouses) <= 1 AND JSON_CONTAINS(warehouses, '$driver->warehouse_id') AND date = '$request->filter_date'");
                if ($del_result > 0) {} else {
                    // fetch all records where this warehouse exist and remove that warehouse by updating record
                    $select_warehouses = DB::select("SELECT id, warehouses FROM supervisors_missed_attendance WHERE date = '$request->filter_date'");
                    foreach ($select_warehouses as $warehoses) {
                        $w_array = trim($warehoses->warehouses, '[]');
                        $w_array = explode(",", $w_array);
                        $keyToRemove = array_search($driver->warehouse_id, $w_array);
                        if ($keyToRemove !== false) {
                            unset($w_array[$keyToRemove]);
                        }
                        $updatedWarehouses = implode(",", $w_array);
                        $updatedWarehouses = "[" . $updatedWarehouses . "]";
                        DB::update("UPDATE supervisors_missed_attendance SET warehouses = '$updatedWarehouses' WHERE id = '$warehoses->id' AND date = '$request->filter_date'");
                    }
                }
                $driver_count = DB::select("SELECT `date` FROM drivers_attendance Where `date` = '$request->filter_date' AND vehicle_id = '$driver->vehicle_id'");
                if(count($driver_count) > 0) {
                    DB::update("UPDATE drivers_attendance set `status` = '$status_value', `company_id` = '$driver->company_id', `warehouse_id` = '$driver->warehouse_id', updated_by = '$user_id', updated_on = '$now' Where `date` = '$request->filter_date' AND vehicle_id = '$driver->vehicle_id'");
                    delete_creditNote($driver, $request);

                    if ($status_value == 'absent with no excuse') {
                        add_creditNote($driver, $request);
                    }
                } else {
                    DB::insert("INSERT INTO drivers_attendance (`vehicle_id`, `date`, job_id, `status`, `company_id`, `warehouse_id`, `created_by`, `created_on`) VALUES ('$driver->vehicle_id','$request->filter_date', '$driver->job_id', '$status_value', '$driver->company_id', '$driver->warehouse_id', '$user_id', '$now')");
                    if ($status_value == 'absent with no excuse') {
                        add_creditNote($driver, $request);
                    }
                }
            }

            if ($driver) {
                return redirect()->back()->with('success', 'Record Updated Successfully');
            } else {
                return redirect()->back()->with('error', 'something bad!');
            }
        } else {
            return redirect()->back()->with('error', 'You can not update the attendance on the selected date and time!');
        }
    }

    public function index(Request $request)
    {
        if (!request()->ajax()) {
            $whereIn_array = array();
            if (Route::getFacadeRoot()->current()->uri() == 'DriversJahiz')
                $companyId = " lkp_company.id=6 ";
            else
                $companyId = " lkp_company.id<>6 ";
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT DISTINCT companyId from users_privilege
            INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
            INNER JOIN lkp_company on lkp_company.id=warehouse.companyId
                where ' . $companyId . ' AND user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->companyId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $wher = " where lkp_company.status = 'active' AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
                $AND = " AND lkp_company.status = 'active' AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
            } else {
                $wher = ' where lkp_company.status = "active" AND ' . $companyId;
                $AND = "";
            }

            $lkp_company = DB::select("SELECT * from lkp_company $wher");

            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
                INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
                where companyId=6 AND user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $wher = 'where warehouse.id in(' . implode(",", $whereIn_array) . ')';
            } else
                $wher = ' where ' . $companyId;

            $warehouse = DB::select('SELECT warehouse.id,warehouse.warehouseName from warehouse
                INNER JOIN lkp_company on lkp_company.id=warehouse.companyId
                ' . $wher . ' order by warehouseName ');
            $lkp_country = DB::select('SELECT * from lkp_country order by country_en');
            $lkp_driver_status = DB::select('SELECT * from lkp_driver_status');
            $lkp_termination_reasons = DB::select('SELECT * from lkp_termination_reasons');
            $lkp_yes_no = DB::select('SELECT * from lkp_yes_no');
            $lkp_bank = DB::select('SELECT * from lkp_bank');
            // now
            $vehicles = DB::select('SELECT * from vehicles order by plate');

            if (Route::getFacadeRoot()->current()->uri() == 'DriversJahiz')
                $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
            else
                $lkp_driver_type = DB::select('SELECT * from lkp_driver_type order by id');


        }
        //***********************************************************************************************************************
        //***********************************************************************************************************************
        elseif (request()->ajax()) {

            $Select_db = DB::table('drivers')
                ->select('drivers_attachments.Image_Identity', 'drivers_attachments.Image_PromissoryNote', 'drivers_attachments.Image_JobContract', 'drivers.id as id', 'companyName', 'company_logo', 'warehouseId', 'warehouseName', 'lkp_city.name_en', 'fullName', 'fullName_ar', 'actualName', 'mobileNumber', 'mobileNumber_someone_else','car_plateNumber' ,'nationality_id', 'lkp_country.country_ar',
                    'iqama', 'iqamaExpireyDate', 'email_id', 'job_id', 'dob', 'status_id', 'lkp_driver_status.driver_status_en', 'termination_reason_id', 'reason_en',
                    'interview_date', 'start_date', 'licenseExpireyDate', 'passportNo', 'passportExpireyDate', 'bank_id', 'bank_name_en', 'accountNumber', 'account_owner_iqama',
                    'a.yes_no AS under_sopnsorship', 'b.yes_no AS ajeer','bander_car.yes_no AS bander_car', 'collectionAmount', 'openBalance',
                    'onhold_date', DB::raw("DATE_FORMAT(drivers.created_at, '%Y-%m-%d') as created_at"), 'drivers.updated_at as updated_at',
                    'driver_type_id', 'driver_type');
            if ($request->filter_screenId == 'Jahiz') {
                $Select_db->selectRaw("NULLIF(IFNULL(Monthly_Salary.p_month,0)+IFNULL(Per_Shipment.p_month,0),0) as per_priod,
                                                NULLIF(IFNULL(Monthly_Salary.c_month,0)+IFNULL(Per_Shipment.c_month,0),0) as cur_priod,
                                                DATEDIFF(NOW(),jahiz_clearing_updated_at) as Last_Clear,Jahiz_Amount,SANED_amount,DATEDIFF(NOW(),SANED_SettledDate) as SANED_SettledDate,
                                                DATEDIFF(NOW(),drivers.created_at) as created_at2,
                                                TRIM(drivers_jahiz_claim.amount)+0 as amount,DATEDIFF(claim_dt,NOW()) as Claim_After");
            } else
                $Select_db->selectRaw("NULLIF(per_priod,0) as per_priod, NULLIF(cur_priod,0) as cur_priod");
            $Select_db->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_city', 'warehouse.cityId', '=', 'lkp_city.id')
                ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
                ->leftJoin('lkp_country', 'drivers.nationality_id', '=', 'lkp_country.id')
                ->leftJoin('lkp_driver_status', 'drivers.status_id', '=', 'lkp_driver_status.id')
                ->leftJoin('lkp_termination_reasons', 'drivers.termination_reason_id', '=', 'lkp_termination_reasons.id')
                ->leftJoin('lkp_bank', 'drivers.bank_id', '=', 'lkp_bank.id')
                ->leftJoin('lkp_yes_no as a', 'drivers.under_sopnsorship_id', '=', 'a.id')
                ->leftJoin('lkp_yes_no as b', 'drivers.ajeer_id', '=', 'b.id')
                ->leftJoin('lkp_yes_no as bander_car', 'drivers.bander_car_id', '=', 'bander_car.id')
                ->leftJoin('lkp_driver_type', 'drivers.driver_type_id', '=', 'lkp_driver_type.id');
                $Select_db->leftJoin('drivers_attachments', 'drivers.id', '=', 'drivers_attachments.driverId');
                // this
                // ->leftJoin('vehicles as v', 'drivers.vehicle_id', '=', 'v.id')

            // if ($request->filter_Image_Identity <> "" || $request->filter_Image_Passport <> "" || $request->filter_Image_DrivingLicence <> "" || $request->filter_Image_VehiclesRegistration <> "" || $request->filter_Image_JobContract <> "" || $request->filter_Image_PromissoryNote <> "")

            if ($request->filter_screenId == 'Jahiz') {
                //return  Route::getFacadeRoot()->current()->uri();
                $Select_db->leftJoin('drivers_jahiz_claim', 'drivers_jahiz_claim.driverId', '=', 'drivers.id');
                $Select_db->leftJoin(DB::raw("(SELECT driverId,
            sum(CASE
                WHEN CONCAT(year,'-',month)= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m') THEN IFNULL(week1,0)+IFNULL(week2,0)+IFNULL(week3,0)+IFNULL(week4,0)+IFNULL(weekAll,0)+IFNULL(amount_by_days,0)
            END) p_month,
            sum(CASE
                WHEN CONCAT(year,'-',month)= DATE_FORMAT(NOW() , '%Y-%m') THEN IFNULL(week1,0)+IFNULL(week2,0)+IFNULL(week3,0)+IFNULL(week4,0)+IFNULL(weekAll,0)+IFNULL(amount_by_days,0)
            END) c_month

            from drivers_jahiz_montly
            LEFT JOIN lkp_jahiz_period on lkp_jahiz_period.id=drivers_jahiz_montly.jahiz_period_id
            LEFT JOIN lkp_month on lkp_month.id=lkp_jahiz_period.month_id
            where CONCAT(year,'-',month) in(DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m'),DATE_FORMAT(NOW() , '%Y-%m'))
            GROUP BY driverId
                )Monthly_Salary"),
                    'Monthly_Salary.driverId', '=', 'drivers.id');
                $Select_db->leftJoin(DB::raw("(select driverId,
                sum(CASE
                    WHEN DATE_FORMAT(updated_at , '%Y-%m')= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')  THEN IFNULL(Bander_Commission,0)
                END) p_month,
                sum(CASE
                    WHEN DATE_FORMAT(updated_at , '%Y-%m')= DATE_FORMAT(NOW() , '%Y-%m')  THEN IFNULL(Bander_Commission,0)
                END) c_month
                 from drivers_jahiz_clearing
                where
                 driver_type_id = 3
                AND DATE_FORMAT(updated_at , '%Y-%m') in(DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m'),DATE_FORMAT(NOW() , '%Y-%m'))
                GROUP BY driverId
                )Per_Shipment"),
                    'Per_Shipment.driverId', '=', 'drivers.id');
                $Select_db->leftJoin(DB::raw("(SELECT a.driverId,
                    CASE
                        WHEN Jahiz_Amount_Sign = 1 THEN a.Jahiz_Amount
                        WHEN Jahiz_Amount_Sign = 2 THEN a.Jahiz_Amount*-1

                    END
                    as Jahiz_Amount,
                    a.updated_at as jahiz_clearing_updated_at
                    FROM drivers_jahiz_clearing a
                    INNER JOIN (
                        SELECT driverId, MAX(updated_at) updated_at
                        FROM drivers_jahiz_clearing
                        GROUP BY driverId
                    ) b ON a.driverId = b.driverId AND a.updated_at = b.updated_at
                )tb_jahiz_amount"),
                    'tb_jahiz_amount.driverId', '=', 'drivers.id');
                $Select_db->leftJoin(DB::raw("(SELECT a.AMP_ID,a.CollectionAmount-a.DeliveryPrice-a.DriverCredit+a.DriverDebit as SANED_amount, a.SettledDate as SANED_SettledDate
                        FROM drivers_saned_settlement a
                        INNER JOIN (
                            SELECT AMP_ID, MAX(SettledDate) SettledDate
                            FROM drivers_saned_settlement
                            GROUP BY AMP_ID
                        ) b ON a.AMP_ID = b.AMP_ID AND a.SettledDate = b.SettledDate
                )drivers_saned_settlement"),
                    'drivers_saned_settlement.AMP_ID', '=', 'drivers.job_id');

            } else
                $Select_db->leftJoin(DB::raw("(SELECT
            driverId,
            TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,
            TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod
           from
        (select driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
               date_format(journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m') AS cur_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod
        from journal
        inner join drivers on drivers.id=journal.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
        group by driverId,per_priod,cur_priod,next_priod
        )balance"),
                    'balance.driverId', '=', 'drivers.id');

            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $Select_db->whereIn('warehouseId', $whereIn_array);
            }


            if ($request->filter_screenId == 'Drivers') {
                $Select_db->whereRaw("companyId<>6");
            }
            if ($request->filter_screenId == 'Jahiz') {
                $Select_db->whereRaw("companyId=6");
            }

            if (!empty($request->filter_companyId)) {
                $Select_db->whereRaw('companyId=' . $request->filter_companyId);
            }
            if (!empty($request->filter_warehouseId)) {
                $Select_db->whereRaw('warehouseId=' . $request->filter_warehouseId);

            }
            if (!empty($request->filter_driver_type_id)) {
                $Select_db->where('driver_type_id', $request->filter_driver_type_id);
            }
            if (!empty($request->filter_fullName)) {
                $Select_db->whereRaw("UPPER(fullName) LIKE '%" . strtoupper($request->filter_fullName) . "%'");
            }
            if (!empty($request->filter_fullName_ar)) {
                $Select_db->whereRaw("UPPER(fullName_ar) LIKE '%" . strtoupper($request->filter_fullName_ar) . "%'");
            }
            if (!empty($request->filter_mobileNumber)) {
                $Select_db->whereRaw("UPPER(mobileNumber) LIKE '%" . strtoupper($request->filter_mobileNumber) . "%'");
            }
            if (!empty($request->filter_nationality_id)) {
                $Select_db->where('nationality_id', $request->filter_nationality_id);
            }
            if (!empty($request->filter_iqama)) {
                $Select_db->whereRaw("UPPER(iqama) LIKE '%" . strtoupper($request->filter_iqama) . "%'");
            }
            if (!empty($request->filter_iqamaExpireyDate)) {
                $filter_iqamaExpireyDate = explode(" - ", $request->filter_iqamaExpireyDate);
                $Select_db->whereRaw("CAST(iqamaExpireyDate as date) between STR_TO_DATE('$filter_iqamaExpireyDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_iqamaExpireyDate[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_email_id)) {
                $Select_db->whereRaw("UPPER(email_id) LIKE '%" . strtoupper($request->filter_email_id) . "%'");
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_dob)) {
                $filter_dob = explode(" - ", $request->filter_dob);
                $Select_db->whereRaw("CAST(dob as date) between STR_TO_DATE('$filter_dob[0]','%d/%m/%Y') and STR_TO_DATE('$filter_dob[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_status_id)) {
                $Select_db->where('status_id', $request->filter_status_id);
            }
            if (!empty($request->filter_termination_reason_id)) {
                $Select_db->where('termination_reason_id', $request->filter_termination_reason_id);
            }
            if (!empty($request->filter_interview_date)) {
                $filter_interview_date = explode(" - ", $request->filter_interview_date);
                $Select_db->whereRaw("CAST(interview_date as date) between STR_TO_DATE('$filter_interview_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_interview_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_start_date)) {
                $filter_start_date = explode(" - ", $request->filter_start_date);
                $Select_db->whereRaw("CAST(start_date as date) between STR_TO_DATE('$filter_start_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_start_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_licenseExpireyDate)) {
                $filter_licenseExpireyDate = explode(" - ", $request->filter_licenseExpireyDate);
                $Select_db->whereRaw("CAST(licenseExpireyDate as date) between STR_TO_DATE('$filter_licenseExpireyDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_licenseExpireyDate[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_passportNo)) {
                $Select_db->whereRaw("UPPER(passportNo) LIKE '%" . strtoupper($request->filter_passportNo) . "%'");
            }
            if (!empty($request->filter_passportExpireyDate)) {
                $filter_passportExpireyDate = explode(" - ", $request->filter_passportExpireyDate);
                $Select_db->whereRaw("CAST(passportExpireyDate as date) between STR_TO_DATE('$filter_passportExpireyDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_passportExpireyDate[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_bank_id)) {
                $Select_db->where('bank_id', $request->filter_bank_id);
            }
            if (!empty($request->filter_accountNumber)) {
                $Select_db->whereRaw("UPPER(accountNumber) LIKE '%" . strtoupper($request->filter_accountNumber) . "%'");
            }
            if (!empty($request->filter_account_owner_iqama)) {
                $Select_db->whereRaw("UPPER(account_owner_iqama) LIKE '%" . strtoupper($request->filter_account_owner_iqama) . "%'");
            }
            if (!empty($request->filter_under_sopnsorship_id)) {
                $Select_db->where('under_sopnsorship_id', $request->filter_under_sopnsorship_id);
            }
            if (!empty($request->filter_ajeer_id)) {
                $Select_db->where('ajeer_id', $request->filter_ajeer_id);
            }
            if (!empty($request->filter_bander_car_id)) {
                $Select_db->where('bander_car_id', $request->filter_bander_car_id);
            }
            // this
            if (!empty($request->filter_vehicleId)) {
                 $Select_db->where('drivers.vehicle_id', $request->filter_vehicleId);
            }
            if (!empty($request->filter_claim_dt)) {
                $filter_claim_dt = explode(" - ", $request->filter_claim_dt);
                $Select_db->whereRaw("CAST(claim_dt as date) between STR_TO_DATE('$filter_claim_dt[0]','%d/%m/%Y') and STR_TO_DATE('$filter_claim_dt[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_SANED_SettledDate)) {
                $filter_SANED_SettledDate = explode(" - ", $request->filter_SANED_SettledDate);
                $Select_db->whereRaw("CAST(SANED_SettledDate as date) between STR_TO_DATE('$filter_SANED_SettledDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_SANED_SettledDate[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_jahiz_clearing_updated_at)) {
                $filter_jahiz_clearing_updated_at = explode(" - ", $request->filter_jahiz_clearing_updated_at);
                $Select_db->whereRaw("CAST(jahiz_clearing_updated_at as date) between STR_TO_DATE('$filter_jahiz_clearing_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_jahiz_clearing_updated_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_collectionAmount)) {
                if ($request->filter_collectionAmount == "1")
                    $Select_db->whereRaw("drivers.collectionAmount >0 ");
                elseif ($request->filter_collectionAmount == "2")
                    $Select_db->whereRaw("drivers.collectionAmount <0 ");
            }
            //-------------------------------------------------------------------------------------------------------
            if ($request->filter_Image_Identity == "1") {
                $Select_db->whereRaw("Image_Identity is not null");
            } elseif ($request->filter_Image_Identity == "2") {
                $Select_db->whereRaw("Image_Identity is  null");
            }
            if ($request->filter_Image_Passport == "1") {
                $Select_db->whereRaw("Image_Passport is not null");
            } elseif ($request->filter_Image_Passport == "2") {
                $Select_db->whereRaw("Image_Passport is  null");
            }
            if ($request->filter_Image_DrivingLicence == "1") {
                $Select_db->whereRaw("Image_DrivingLicence is not null");
            } elseif ($request->filter_Image_DrivingLicence == "2") {
                $Select_db->whereRaw("Image_DrivingLicence is  null");
            }
            if ($request->filter_Image_VehiclesRegistration == "1") {
                $Select_db->whereRaw("Image_VehiclesRegistration is not null");
            } elseif ($request->filter_Image_VehiclesRegistration == "2") {
                $Select_db->whereRaw("Image_VehiclesRegistration is  null");
            }
            if ($request->filter_Image_JobContract == "1") {
                $Select_db->whereRaw("Image_JobContract is not null");
            } elseif ($request->filter_Image_JobContract == "2") {
                $Select_db->whereRaw("Image_JobContract is  null");
            }
            if ($request->filter_Image_PromissoryNote == "1") {
                $Select_db->whereRaw("Image_PromissoryNote is not null");
            } elseif ($request->filter_Image_PromissoryNote == "2") {
                $Select_db->whereRaw("Image_PromissoryNote is  null");
            }
            //-------------------------------------------------------------------------------------------------------
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(drivers.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(drivers.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }

            //return $Select_db->toSql();
            //return Route::getFacadeRoot()->current()->uri();
            return datatables()->of($Select_db)->make(true);
        }
        //$data = $Select_db->get();
        //return $Select_db->toSql();
        if (Route::getFacadeRoot()->current()->uri() == 'DriverWindow')
            $view = "DriverWindow";
        if (Route::getFacadeRoot()->current()->uri() == 'DriverJahizWindow')
            $view = "DriverJahizWindow";
        elseif (Route::getFacadeRoot()->current()->uri() == 'Drivers')
            $view = "index";
        elseif (Route::getFacadeRoot()->current()->uri() == 'DriversJahiz') {
            $view = "index_Jahiz";
        }
        $lkp_jahiz_period = DB::select("SELECT lkp_jahiz_period.id,year,month_id,month,CONCAT(year,'-',month) as ym
                from lkp_jahiz_period
                left join lkp_month on lkp_month.id=lkp_jahiz_period.month_id order by year desc,month_id desc");
        return view('Drivers.' . $view)->with(compact('warehouse'))->with(compact('lkp_country'))
            ->with(compact('lkp_driver_status'))->with(compact('lkp_termination_reasons'))
            ->with(compact('lkp_bank'))->with(compact('lkp_yes_no'))->with(compact('lkp_company'))
            ->with(compact('lkp_driver_type'))->with(compact('vehicles'))->with(compact('lkp_jahiz_period'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create($type_id)
    {
        //return Route::getFacadeRoot()->current()->uri().$type_id;
        //
        if ($type_id == 2) {
            if (Auth::user()->user_type_id == 1)
                $warehouse = DB::select('SELECT * from warehouse where companyId=6 order by warehouseName');
            else
                $warehouse = DB::select('SELECT warehouse.id,warehouseName from users_privilege
                              inner join warehouse on warehouse.id=users_privilege.warehouseId
                               where companyId=6 AND user_id=' . Auth::user()->id);
        } elseif (session('Session_DriversCarrefour') == 'yes')
            $warehouse = DB::select('SELECT warehouse.id,warehouseName from users_privilege
                              inner join warehouse on warehouse.id=users_privilege.warehouseId
                               where companyId=8 AND user_id=' . Auth::user()->id);
        else
            $warehouse = DB::select('SELECT * from warehouse order by warehouseName');

        $companies = DB::select('SELECT * from lkp_company WHERE lkp_company.status = "active" AND id <> 6 order by companyName');
        $lkp_country = DB::select('SELECT * from lkp_country order by country_en');
        $lkp_driver_status = DB::select('SELECT * from lkp_driver_status');
        $lkp_termination_reasons = DB::select('SELECT * from lkp_termination_reasons');
        $lkp_bank = DB::select('SELECT * from lkp_bank');
        $lkp_yes_no = DB::select('SELECT * from lkp_yes_no');
        $vehicles = DB::select("SELECT * from vehicles where current_status = "."'availabe'"." order by plate");

        if ($type_id == 2)
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
        else
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type order by id');
        $warehouse = DB::select('SELECT warehouse.id,warehouse.warehouseName from warehouse
        INNER JOIN lkp_company on lkp_company.id=warehouse.companyId
        WHERE lkp_company.id=6 order by warehouseName');
        return view('new_porttal.Drivers.create')->with(compact('companies'))->with(compact('lkp_country'))
            ->with(compact('lkp_driver_status'))->with(compact('lkp_termination_reasons'))
            ->with(compact('lkp_bank'))->with(compact('lkp_yes_no'))->with(compact('lkp_driver_type'))
            ->with(compact('type_id'))
            ->with(compact('vehicles'))->with(compact('warehouse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        //
        //$this->validate($request, [
        //    'driversName' => ['required', 'string', 'max:255'],
        //   'companyId' => ['required'],
        //   'cityId' => ['required'],
        //   ]);
        try {
            $Drivers = new Drivers;
            $Drivers->warehouseId = $request->input('warehouseId');
            $Drivers->fullName = $request->input('fullName');
            $Drivers->fullName_ar = $request->input('fullName_ar');
            $Drivers->actualName = $request->input('actualName');
            $Drivers->mobileNumber = $request->input('mobileNumber');
            $Drivers->mobileNumber_someone_else = $request->input('mobileNumber_someone_else');
            $Drivers->nationality_id = $request->input('nationality_id');
            $Drivers->iqama = $request->input('iqama');
            if ($request->input('iqamaExpireyDate') == "")
                $Drivers->iqamaExpireyDate = null;
            else
                $Drivers->iqamaExpireyDate = $request->input('iqamaExpireyDate');
            $Drivers->email_id = $request->input('email_id');
            if (session('Session_DriversCarrefour') == 'yes') {
                $d = DB::select("select max(CONVERT(SUBSTR(job_id, 11),UNSIGNED INTEGER))as MX from drivers where job_id like 'Carrefour_%'")[0];
                $Carrefour_ = (int)$d->MX;
                $Carrefour_++;
                $Drivers->job_id = 'Carrefour_' . $Carrefour_;
            } else $Drivers->job_id = $request->input('job_id');

            if ($request->input('dob') == "")
                $Drivers->dob = null;
            else
                $Drivers->dob = $request->input('dob');
            $Drivers->status_id = $request->input('status_id');
            if ($request->input('status_id') != 3) {
                $Drivers->termination_reason_id = null;
            } else {
                $Drivers->termination_reason_id = $request->input('termination_reason_id');
            }
            if ($request->input('interview_date') == "")
                $Drivers->interview_date = null;
            else
                $Drivers->interview_date = $request->input('interview_date');
            if ($request->input('start_date') == "")
                $Drivers->start_date = null;
            else
                $Drivers->start_date = $request->input('start_date');
            if ($request->input('licenseExpireyDate') == "")
                $Drivers->licenseExpireyDate = null;
            else
                $Drivers->licenseExpireyDate = $request->input('licenseExpireyDate');
            $Drivers->passportNo = $request->input('passportNo');
            if ($request->input('passportExpireyDate') == "")
                $Drivers->passportExpireyDate = null;
            else
                $Drivers->passportExpireyDate = $request->input('passportExpireyDate');
            $Drivers->bank_id = $request->input('bank_id');
            $Drivers->accountNumber = $request->input('accountNumber');
            $Drivers->account_owner_iqama = $request->input('account_owner_iqama');
            $Drivers->under_sopnsorship_id = $request->input('under_sopnsorship_id');
            $Drivers->ajeer_id = $request->input('ajeer_id');
            $Drivers->bander_car_id = $request->input('bander_car_id');
            $Drivers->driver_type_id = $request->input('driver_type_id');
            $Drivers->created_by_id = Auth::user()->id;
            $Drivers->updated_by_id = Auth::user()->id;
            $Drivers->vehicle_id = $request->input('vehicle_id');
            $success = $Drivers->save();
            if($success) {
                $driver_job_id = $Drivers->job_id;
                $made_by = Auth::user()->name;
                $action = "<b>$made_by</b> made a new driver with job_id ($driver_job_id)";
                $warehouse_id = $Drivers->warehouseId;
                HelperFunctionsController::add_log($action, $warehouse_id);
                $id = $request->input('vehicle_id');
                if(!empty($id)) {
                    $city = DB::select("SELECT lkp_city.id as city_id FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id WHERE drivers.vehicle_id= = '$id'");
                    DB::update("update vehicles set current_status = 'delegeted', city_id = '$city[0]->city_id' where id = '$id'");
                }
                return response()->json(['status' => 200, 'message' => 'Driver Added successfully. With AMPID: ' . $Drivers->job_id]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 420, 'message' => $e->errorInfo]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function show($id)
    {
        $Drivers = DB::table('drivers')
            ->select('drivers.id as id', 'companyId', 'warehouseId', 'warehouseName', 'fullName', 'fullName_ar', 'actualName', 'mobileNumber', 'mobileNumber_someone_else', 'nationality_id', 'country_en',
                'iqama', 'iqamaExpireyDate', 'email_id', 'job_id', 'dob', 'status_id', 'driver_status_en', 'termination_reason_id', 'reason_en',
                'interview_date', 'start_date', 'licenseExpireyDate', 'passportNo', 'passportExpireyDate', 'drivers.bank_id', 'bank_name_en', 'accountNumber', 'account_owner_iqama',
                'sopnsorship.yes_no as sopnsorship', 'ajeer.yes_no as ajeer','bander_car.yes_no as bander_car', 'collectionAmount', 'numberOfDispatch', 'lastSettlementDate',
                'driver_type_id', 'driver_type', 'ops_name', 'user_created.name as name_created', 'user_updated.name as name_updated',
                'drivers.created_at as created_at', 'drivers.updated_at as updated_at')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_country', 'drivers.nationality_id', '=', 'lkp_country.id')
            ->leftJoin('lkp_driver_status', 'drivers.status_id', '=', 'lkp_driver_status.id')
            ->leftJoin('lkp_termination_reasons', 'drivers.termination_reason_id', '=', 'lkp_termination_reasons.id')
            ->leftJoin('lkp_bank', 'drivers.bank_id', '=', 'lkp_bank.id')
            ->leftJoin('lkp_yes_no as sopnsorship', 'drivers.under_sopnsorship_id', '=', 'sopnsorship.id')
            ->leftJoin('lkp_yes_no as ajeer', 'drivers.ajeer_id', '=', 'ajeer.id')
            ->leftJoin('lkp_yes_no as bander_car', 'drivers.bander_car_id', '=', 'bander_car.id')
            ->leftJoin('lkp_driver_type', 'drivers.driver_type_id', '=', 'lkp_driver_type.id')
            ->leftJoin('users as user_created', 'drivers.created_by_id', '=', 'user_created.id')
            ->leftJoin('users as user_updated', 'drivers.updated_by_id', '=', 'user_updated.id')
            ->where('drivers.id', $id)
            ->first();

        return view('new_porttal.Drivers.show')->with('Drivers', $Drivers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function edit($id, $type_id)
    {
        //return Route::getFacadeRoot()->current()->uri().$id.'-'.$type_id;
        if ($type_id == 2 || $type_id == 3) {
            $warehouse = DB::select('SELECT warehouse.id,warehouse.warehouseName from warehouse
            INNER JOIN lkp_company on lkp_company.id=warehouse.companyId
            WHERE lkp_company.id=6 order by warehouseName');
        } else
            $warehouse = DB::select('SELECT * from warehouse order by warehouseName');
        $lkp_country = DB::select('SELECT * from lkp_country order by country_en');
        $lkp_driver_status = DB::select('SELECT * from lkp_driver_status');
        $lkp_termination_reasons = DB::select('SELECT * from lkp_termination_reasons');
        $lkp_bank = DB::select('SELECT * from lkp_bank');
        $lkp_yes_no = DB::select('SELECT * from lkp_yes_no');
        if ($type_id == 2)
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
        else
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type order by id');
        //$Drivers =DB::select(DB::raw('SELECT * from drivers where id='.$id))[0];
        $Drivers = DB::table('drivers')
            ->select('vehicles.vehicle_expiry_date', 'drivers.vehicle_id','drivers.id as id','fuel_per_day','basic_salary' ,'warehouseId','car_plateNumber' ,'warehouseName', 'companyName', 'fullName', 'fullName_ar', 'actualName', 'mobileNumber', 'mobileNumber_someone_else', 'nationality_id', 'country_ar',
                'iqama', 'iqamaExpireyDate', 'email_id', 'job_id', 'dob', 'status_id', 'driver_status_en', 'termination_reason_id', 'reason_en',
                'interview_date', 'start_date', 'licenseExpireyDate', 'passportNo', 'passportExpireyDate', 'bank_id', 'bank_name_en', 'accountNumber', 'account_owner_iqama',
                'under_sopnsorship_id', 'ajeer_id','bander_car_id', 'ops_name', 'driver_type_id', 'driver_type',
                'drivers.created_at as created_at', 'drivers.updated_at as updated_at')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_country', 'drivers.nationality_id', '=', 'lkp_country.id')
            ->leftJoin('lkp_driver_status', 'drivers.status_id', '=', 'lkp_driver_status.id')
            ->leftJoin('lkp_termination_reasons', 'drivers.termination_reason_id', '=', 'lkp_termination_reasons.id')
            ->leftJoin('lkp_bank', 'drivers.bank_id', '=', 'lkp_bank.id')
            ->leftJoin('lkp_driver_type', 'drivers.driver_type_id', '=', 'lkp_driver_type.id')
            ->leftJoin('vehicles', 'drivers.vehicle_id', '=', 'vehicles.id')

            ->where('drivers.id', $id)
            ->first();
            $id = $Drivers->vehicle_id;
            if ($Drivers->vehicle_id == '')
                $id = 1;

            $vehicles = DB::select("SELECT * from vehicles where id = ". $id ." OR current_status = "."'availabe'"." order by plate");

        return view('new_porttal.Drivers.edit')->with('Drivers', $Drivers)->with(compact('lkp_country'))
            ->with(compact('lkp_driver_status'))->with(compact('lkp_termination_reasons'))
            ->with(compact('lkp_bank'))->with(compact('lkp_yes_no'))
            ->with(compact('warehouse'))->with(compact('lkp_driver_type'))
            ->with(compact('type_id'))->with(compact('vehicles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        try {
            // dd(Auth::user());
            $action = '';
            $Drivers = Drivers::find($id);
            if($Drivers->warehouseId != $request->input('warehouseId') AND $request->input('warehouseId') != '') {
                $action .= "Warehouse: " . $Drivers->warehouseId . " to " . $request->input('warehouseId') . ", ";
            }
            if (Auth::user()->user_type_id == 1)
                $Drivers->warehouseId = $request->input('warehouseId');

            // if (Auth::user()->user_type_id == 1 || session('Session_DriversCarrefour') == 'yes')
                if($Drivers->fullName != $request->input('fullName') AND $request->input('fullName') != '') {
                    $action .= "fullName: " . $Drivers->fullName . " to " . $request->input('fullName') . ", ";
                }
                $Drivers->fullName = $request->input('fullName');
                if($Drivers->fullName_ar != $request->input('fullName_ar')) {
                    $action .= "fullName_ar: " . $Drivers->fullName_ar . " to " . $request->input('fullName_ar') . ", ";
                }
                $Drivers->fullName_ar = $request->input('fullName_ar');
                if($Drivers->actualName != $request->input('actualName') AND $request->input('actualName') != '') {
                    $action .= "actualName: " . $Drivers->actualName . " to " . $request->input('actualName') . ", ";
                }
                $Drivers->actualName = $request->input('actualName');
                if($Drivers->mobileNumber != $request->input('mobileNumber') AND $request->input('mobileNumber') != '') {
                    $action .= "mobileNumber: " . $Drivers->mobileNumber . " to " . $request->input('mobileNumber') . ", ";
                }
                $Drivers->mobileNumber = $request->input('mobileNumber');
                $Drivers->mobileNumber_someone_else = $request->input('mobileNumber_someone_else');
                $Drivers->nationality_id = $request->input('nationality_id');
                if($Drivers->iqama != $request->input('iqama') AND $request->input('iqama') != '') {
                    $action .= "iqama: " . $Drivers->iqama . " to " . $request->input('iqama') . ", ";
                }
                $Drivers->iqama = $request->input('iqama');
                // ASHRAF CODE
                 $Drivers->fuel_per_day = $request->input('fuel_per_day');
                 $Drivers->basic_salary = $request->input('basic_salary');
                 $Drivers->car_plateNumber = $request->input('car_plateNumber');
            //
            if ($request->input('iqamaExpireyDate') == "")
                $Drivers->iqamaExpireyDate = null;
            else
                $Drivers->iqamaExpireyDate = $request->input('iqamaExpireyDate');
            $Drivers->email_id = $request->input('email_id');
            if (Auth::user()->user_type_id == 1) {
                if($Drivers->job_id != $request->input('job_id') AND $request->input('job_id') != '') {
                    $action .= "job_id: " . $Drivers->job_id . " to " . $request->input('job_id') . ", ";
                }
                $Drivers->job_id = $request->input('job_id');
            }
            if ($request->input('dob') == "")
                $Drivers->dob = null;
            else
                $Drivers->dob = $request->input('dob');
            if (Auth::user()->user_type_id == 1 || session('Session_DriversJahiz') == 'yes'|| session('Session_DriversCarrefour') == 'yes'||session('Session_Drivers')=='yes') {
                if($Drivers->status_id != $request->input('status_id') AND $request->input('status_id') != '') {
                    $action .= "status_id: " . $Drivers->status_id . " to " . $request->input('status_id') . ", ";
                }
                $Drivers->status_id = $request->input('status_id');
            }
            if ($request->input('status_id') != 3) {
                $Drivers->termination_reason_id = null;
            } else {
                $Drivers->termination_reason_id = $request->input('termination_reason_id');
            }
            if ($request->input('interview_date') == "")
                $Drivers->interview_date = null;
            else
                $Drivers->interview_date = $request->input('interview_date');
            if ($request->input('start_date') == "")
                $Drivers->start_date = null;
            else
                $Drivers->start_date = $request->input('start_date');
            if ($request->input('licenseExpireyDate') == "")
                $Drivers->licenseExpireyDate = null;
            else
                $Drivers->licenseExpireyDate = $request->input('licenseExpireyDate');
            $Drivers->passportNo = $request->input('passportNo');
            if ($request->input('passportExpireyDate') == "")
                $Drivers->passportExpireyDate = null;
            else
                $Drivers->passportExpireyDate = $request->input('passportExpireyDate');
            $Drivers->bank_id = $request->input('bank_id');
            if($Drivers->accountNumber != $request->input('accountNumber') AND $request->input('accountNumber') != '') {
                $action .= "accountNumber: " . $Drivers->accountNumber . " to " . $request->input('accountNumber') . ", ";
            }
            $Drivers->accountNumber = $request->input('accountNumber');
            if($Drivers->account_owner_iqama != $request->input('account_owner_iqama') AND $request->input('account_owner_iqama') != '') {
                $action .= "account_owner_iqama: " . $Drivers->account_owner_iqama . " to " . $request->input('account_owner_iqama') . ", ";
            }
            $Drivers->account_owner_iqama = $request->input('account_owner_iqama');
            $Drivers->under_sopnsorship_id = $request->input('under_sopnsorship_id');
            $Drivers->ajeer_id = $request->input('ajeer_id');
            $Drivers->bander_car_id = $request->input('bander_car_id');
            if (Auth::user()->user_type_id == 1 || session('Session_DriversJahiz') == 'yes')
                $Drivers->driver_type_id = $request->input('driver_type_id');
            $Drivers->updated_by_id = Auth::user()->id;
            $old_id = $Drivers->vehicle_id;
            $new_id = $request->input('vehicle_id');
            $Drivers->vehicle_id = $new_id;
            $Drivers->updated_at = now();
            $success = $Drivers->save();
            // To remove the previous vehicle from driver
            $user_id = Auth::user()->id;
            if(!empty($old_id)) {
                DB::update("update vehicles set current_status = 'availabe', vehicle_expiry_date = '', updated_by = '$user_id', updated_at = NOW() where id = '$old_id'");
            }
            // To add the new vehicle to driver
            if(!empty($new_id)) {
                $city = DB::select("SELECT lkp_city.id as city_id FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id WHERE drivers.vehicle_id = '$new_id'");
                $city_id = $city[0]->city_id;
                DB::update("update vehicles set current_status = 'delegeted', updated_by = '$user_id', updated_at = NOW(), vehicle_expiry_date = '$request->vehicle_expiry_date', city_id = '$city_id' where id = '$new_id'");
                if($old_id != $new_id)
                    $action .= "vehicle_id: " . $old_id . " to " . $new_id . ", ";
            }
            // Update vehicle expiry date
            if($success) {
                $driver_job_id = $Drivers->job_id;
                $warehouse_id = $Drivers->warehouseId;
                $made_by = Auth::user()->name;
                if($action != '') {
                    $ids = array();
                    $ids[] = $id;
                    $msg = "<b>$made_by</b> updated the driver ($driver_job_id) with these changes: $action";
                    HelperFunctionsController::add_log($msg, $warehouse_id, $ids);
                }
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->edit($id, $request->input('type_id'))->with('error', $e->getPrevious()->getMessage());
        }
        return $this->edit($id, $request->input('type_id'))->with('success', 'Done successfully');
    }

    public function BulkDriversUpdate(Request $request) {
        // $rules = [
        //     'drivers.*.mobileNumber' => ['nullable', 'regex:/^5\d{8}$/'],
        //     'drivers.*.accountNumber' => ['nullable', 'regex:/^966\d{9}$/'],
        //     'drivers.*.iqama' => ['nullable', 'regex:/^\d{10}$/'],
        //     'drivers.*.account_owner_iqama' => ['nullable', 'regex:/^\d{10}$/'],
        // ];

        // $messages = [
        //     'drivers.*.mobileNumber.regex' => 'The mobile number must be exactly 9 digits and start with 5.',
        //     'drivers.*.accountNumber.regex' => 'The account number must be exactly 12 digits and start with 966.',
        //     'drivers.*.iqama.regex' => 'The Iqama number must be exactly 10 digits.',
        //     'drivers.*.account_owner_iqama.regex' => 'The Iqama number must be exactly 10 digits.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        $log_ids = array();
        $made_by = Auth::user()->name;
        $user_id = Auth::user()->id;

        foreach ($request->drivers as $driverData) {
            $action = '';
            $driver = Drivers::find($driverData['driverId']);
            if ($driver) {

                if(isset($driverData['mobileNumber']) AND ($driverData['mobileNumber'] === -1 OR $driverData['mobileNumber'] > 0)) {
                    if ($driverData['mobileNumber'] === -1) {
                        $action .= "mobileNumber: " . $driver->mobileNumber . " to null, ";
                        $driver->mobileNumber = null;
                    } else {
                         $action .= "mobileNumber: " . $driver->mobileNumber . " to " . $driverData['mobileNumber'] . ", ";
                        $driver->mobileNumber = $driverData['mobileNumber'];
                    }
                }
                if(isset($driverData['iqama']) AND ($driverData['iqama'] === -1 OR $driverData['iqama'] > 0)) {
                    if ($driverData['iqama'] === -1) {
                        $action .= "iqama: " . $driver->iqama . " to null, ";
                        $driver->iqama = null;
                    } else {
                        $action .= "iqama: " . $driver->iqama . " to " . $driverData['iqama'] . ", ";
                        $driver->iqama = $driverData['iqama'];
                    }
                }

                if(isset($driverData['accountNumber']) AND ($driverData['accountNumber'] === -1 OR $driverData['accountNumber'] > 0)) {
                    if ($driverData['accountNumber'] === -1) {
                        $action .= "accountNumber: " . $driver->accountNumber . " to null, ";
                        $driver->accountNumber = null;
                    } else {
                        $action .= "accountNumber: " . $driver->accountNumber . " to " . $driverData['accountNumber'] . ", ";
                        $driver->accountNumber = $driverData['accountNumber'];
                    }
                }

                if(isset($driverData['account_owner_iqama']) AND ($driverData['account_owner_iqama'] === -1 OR $driverData['account_owner_iqama'] > 0)) {
                    if ($driverData['account_owner_iqama'] === -1) {
                        $action .= "account_owner_iqama: " . $driver->account_owner_iqama . " to null, ";
                        $driver->account_owner_iqama = null;
                    } else {
                        $action .= "account_owner_iqama: " . $driver->account_owner_iqama . " to " . $driverData['account_owner_iqama'];
                        $driver->account_owner_iqama = $driverData['account_owner_iqama'];
                    }
                }
                $driver->updated_at = now();
                $driver->updated_by_id = Auth::user()->id;
                $driver->save();
                $msg = "<b>$made_by</b> updated the driver (".$driverData['driverId'].") with these changes: $action";
                $log_ids[] = HelperFunctionsController::add_log($msg, '', $driver->job_id);
            }
        }
        if (count($log_ids) > 0) {
            $log_ids = json_encode($log_ids);
            $ref_no = Str::random(8);
            DB::insert("INSERT into tbl_supervisors_triggers (ref_no, log_ids, created_at, created_by) VALUES ('$ref_no', '$log_ids', NOW(), '$user_id')");
            $result = DB::select("SELECT * from tbl_supervisors_triggers order by id desc");
            $ref_no = $result[0]->ref_no;
            $created_at = $result[0]->created_at;
            generateAndSendPdf($ref_no, $created_at, $request->company, $request->period);
        }
        return response()->json(['message' => 'Drivers updated successfully.']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy($id)
    {
        if (Auth::user()->user_type_id == 1) {
            $Drivers = Drivers::find($id);
            // if(auth()->user()->id !== $Drivers->user_id){
            //    return redirect('/New-Portal/Drivers')->with('error','Unauthorized');
            // }
            if ($Drivers->logo != 'noImage.jpg') {
                Storage::delete('public/app/storage' . $Drivers->logo);
            }
            $Drivers->delete();
        }
        return redirect()->back()->with('success', 'Done successfully');
    }

    public function DriversPost(Request $request)
    {
        $IDs = '';
        $IDs_all = '';
        for ($i = 0; $i < 105; $i++) {
            if (!empty($request->input('IDs_all_' . $i)))
                $IDs_all .= $request->input('IDs_all_' . $i) . ",";
            if (!empty($request->input('ID_' . $i)))
                $IDs .= $request->input('ID_' . $i) . ",";
        }
        $IDs = substr($IDs, 0, strlen($IDs) - 1);
        $IDs_all = substr($IDs_all, 0, strlen($IDs_all) - 1);
        $sql = '';
        try {
            if ($IDs_all <> "") {
                $sql = "update drivers set status_id=1
        where status_id=5 and drivers.id in(" . $IDs_all . ") and not drivers.id in(0,$IDs)";
                DB::update("update drivers set status_id=1
        where status_id=5 and drivers.id in(" . $IDs_all . ") and not drivers.id in(0,$IDs)");
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', $sql . $e->getPrevious()->getMessage());
        }
        try {
            if ($IDs <> "")
                DB::update("update drivers set status_id=5,onhold_date='" . date("Y-m-d H:i:s") . "'
        where status_id<>5 and drivers.id in(" . $IDs . ")
         ");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', $e->getPrevious()->getMessage());
        }
        return redirect()->back()->with('success', 'Done successfully');
    }

    public function ResetPass($id)
    {
        $Driver = DB::select('SELECT * from drivers where id=' . $id)[0];
        return view('new_porttal.Drivers.ResetPass')->with(compact('Driver'))->with(compact('id'));
    }

    public function SaveResetPass(Request $request)
    {
        $Drivers = Drivers::find($request->input('id'));
        $Drivers->password = bcrypt($request->input('password'));
        $Drivers->save();
        return redirect()->back()->with('success', 'Done successfully');
    }

    public function Attachment($id)
    {
        $Driver = DB::select('SELECT id, fullName, job_id from drivers where id=' . $id)[0];

        $drivers_attachments = DB::table('drivers_attachments')
            ->select('driverId', 'Image_Identity', 'Image_Passport', 'Image_DrivingLicence',
                'Image_VehiclesRegistration', 'Image_JobContract', 'Image_PromissoryNote')
            ->where('driverId', '=', $id)
            ->first();
        return view('new_porttal.Drivers.Attachment')->with(compact('Driver'))->with(compact('drivers_attachments'));
    }

    public function SaveAttachment(Request $request)
    {
        if ($request->hasFile('Image_Identity')) {

            $validator = Validator::make($request->all(), [
                'Image_Identity' => 'mimes:jpeg,jpg',
            ]);
            if ($validator->fails()) {
                return redirect('/Attachment/' . $request->input('id'))->with('error', 'Image_Identity Upload JPG only');
            }

            $request->file('Image_Identity')->move('Attachment/Image_Identity/', $request->input('id') . '.jpg');
            DB::table('drivers_attachments')
                ->updateOrInsert(
                    ['driverId' => $request->input('id')],
                    ['Image_Identity' => '1']
                );

        }
        if ($request->hasFile('Image_Passport')) {

            $validator = Validator::make($request->all(), [
                'Image_Passport' => 'mimes:jpeg,jpg',
            ]);
            if ($validator->fails()) {
                return redirect('/Attachment/' . $request->input('id'))->with('error', 'Image_Passport Upload JPG only');
            }

            $request->file('Image_Passport')->move('Attachment/Image_Passport/', $request->input('id') . '.jpg');
            DB::table('drivers_attachments')
                ->updateOrInsert(
                    ['driverId' => $request->input('id')],
                    ['Image_Passport' => '1']
                );
        }
        if ($request->hasFile('Image_DrivingLicence')) {

            $validator = Validator::make($request->all(), [
                'Image_DrivingLicence' => 'mimes:jpeg,jpg',
            ]);
            if ($validator->fails()) {
                return redirect('/Attachment/' . $request->input('id'))->with('error', 'Image_DrivingLicence Upload JPG only');
            }

            $request->file('Image_DrivingLicence')->move('Attachment/Image_DrivingLicence/', $request->input('id') . '.jpg');
            DB::table('drivers_attachments')
                ->updateOrInsert(
                    ['driverId' => $request->input('id')],
                    ['Image_DrivingLicence' => '1']
                );
        }
        if ($request->hasFile('Image_VehiclesRegistration')) {

            $validator = Validator::make($request->all(), [
                'Image_VehiclesRegistration' => 'mimes:jpeg,jpg',
            ]);
            if ($validator->fails()) {
                return redirect('/Attachment/' . $request->input('id'))->with('error', 'Image_VehiclesRegistration Upload JPG only');
            }

            $request->file('Image_VehiclesRegistration')->move('Attachment/Image_VehiclesRegistration/', $request->input('id') . '.jpg');
            DB::table('drivers_attachments')
                ->updateOrInsert(
                    ['driverId' => $request->input('id')],
                    ['Image_VehiclesRegistration' => '1']
                );
        }
        if ($request->hasFile('Image_JobContract')) {

            $validator = Validator::make($request->all(), [
                'Image_JobContract' => 'mimes:jpeg,jpg',
            ]);
            if ($validator->fails()) {
                return redirect('/Attachment/' . $request->input('id'))->with('error', 'Image_JobContract Upload JPG only');
            }

            $request->file('Image_JobContract')->move('Attachment/Image_JobContract/', $request->input('id') . '.jpg');
            DB::table('drivers_attachments')
                ->updateOrInsert(
                    ['driverId' => $request->input('id')],
                    ['Image_JobContract' => '1']
                );
        }
        if ($request->hasFile('Image_PromissoryNote')) {

            $validator = Validator::make($request->all(), [
                'Image_PromissoryNote' => 'mimes:jpeg,jpg',
            ]);
            if ($validator->fails()) {
                return redirect('/Attachment/' . $request->input('id'))->with('error', 'Image_PromissoryNote Upload JPG only');
            }

            $request->file('Image_PromissoryNote')->move('Attachment/Image_PromissoryNote/', $request->input('id') . '.jpg');
            DB::table('drivers_attachments')
                ->updateOrInsert(
                    ['driverId' => $request->input('id')],
                    ['Image_PromissoryNote' => '1']
                );
        }
        //*********************************************************************************************************************
        //*********************************************************************************************************************
        return redirect('/Attachment/' . $request->input('id'))->with('success', 'Done successfully');
    }

//*************************************************************************************************************************
    public function DeleteAttachment($name, $id)
    {

        DB::update('update drivers_attachments  set ' . $name . '=null where driverId=' . $id);

        File::delete('Attachment/' . $name . '/' . $id . '.jpg');
        //$file_path = app_path().'\public\Attachment\''.$name.'\'. $id . '.jpg';
        //unlink($file_path);

        return $this->Attachment($id)->with('success', 'Delete successfully');
    }

    public function statement($id)
    {
        $Driver = DB::select('SELECT fullName from drivers where id=' . $id)[0];
        $statement = DB::select("select id,journal_period,TRIM(sum(credit))+0 as credit,TRIM(sum(debit))+0 as debit FROM
                        (
                        select if (period_start<>1,
                                        CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                        ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                                        CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                        ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                                         as journal_period,credit,debit,drivers.id
                        from journal
                        inner join drivers on drivers.id=journal.driverId
                        inner join warehouse on warehouse.id=drivers.warehouseId
                        inner join lkp_company on lkp_company.id=warehouse.companyId
                        where drivers.id=" . $id . ")a
                        GROUP BY journal_period,id
                        order by journal_period  ");
        return view('new_porttal.Drivers.statement')->with(compact('Driver'))->with(compact('statement'));
    }

    public function ClearancePrint($id, $print)
    {


        $Drivers = DB::select('select IFNULL(balance,0) as balance,fullName,iqama,driverId from(
                                        select SUM(IFNULL(credit,0))-SUM(IFNULL(debit,0)) as balance,fullName,iqama,drivers.id as driverId from journal
                                        INNER JOIN drivers on drivers.id=journal.driverId
                                        where driverId=' . $id . '
                                        )aa')[0];
        if ($print == '1') {
            if ($Drivers->balance >= 0 && $Drivers->iqama <> '') {
                DB::table('clearance')->insert(
                    [
                        'driverId' => $Drivers->driverId,
                        'iqama' => $Drivers->iqama,
                        'balance' => $Drivers->balance,
                        'createdby_id' => Auth::user()->id,
                        'created_at' => date("Y-m-d H:i:s"),
                    ]
                );
            } else return;
        }

        return view('Drivers.ClearancePrint')->with(compact('Drivers'))->with(compact('print'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversSettlementList($id)
    {
        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Driver = DB::select('SELECT drivers.id,fullName,warehouseName,driver_type_id,job_id from drivers
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers.id=' . $id)[0];
        $drivers_jahiz_clearing = DB::table('drivers_jahiz_clearing')
            ->select(DB::raw("drivers_jahiz_clearing.id as id, drivers_jahiz_clearing.driverId,companyName,warehouseName,job_id, drivers.fullName as fullName, fullName_ar, actualName,
             driver_type,Jahiz_Amount, Jahiz_Amount_Sign,Bander_Commission,clearing_type_id,bank,cash,ATM,paid_id,
              GROUP_CONCAT(CONCAT(year,'-',month,'_',COALESCE(week1,''),'_',COALESCE(week2,''),'_',COALESCE(week3,''),'_',COALESCE(week4,''),'_',COALESCE(weekAll,''),'_',COALESCE(amount_by_days,'')) SEPARATOR ';') as jahiz_montly,
            name,drivers_jahiz_clearing.created_at as created_at, drivers_jahiz_clearing.updated_at as updated_at"))
            ->leftJoin('drivers', 'drivers_jahiz_clearing.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('drivers_jahiz_montly', 'drivers_jahiz_montly.drivers_jahiz_clearing_id', '=', 'drivers_jahiz_clearing.id')
            ->leftJoin('lkp_jahiz_period', 'lkp_jahiz_period.id', '=', 'drivers_jahiz_montly.jahiz_period_id')
            ->leftJoin('lkp_month', 'lkp_month.id', '=', 'lkp_jahiz_period.month_id')
            ->leftJoin('lkp_driver_type', 'drivers_jahiz_clearing.driver_type_id', '=', 'lkp_driver_type.id')
            ->leftJoin('users', 'drivers_jahiz_clearing.updated_by_id', '=', 'users.id')
            ->where('drivers_jahiz_clearing.driverId', $id)
            ->groupBy('drivers_jahiz_clearing.id', 'drivers_jahiz_clearing.driverId', 'companyName', 'warehouseName', 'job_id', 'drivers.fullName', 'fullName_ar',
                'driver_type', 'Jahiz_Amount', 'Jahiz_Amount_Sign', 'Bander_Commission', 'clearing_type_id', 'bank', 'cash',
                'name', 'drivers_jahiz_clearing.created_at', 'drivers_jahiz_clearing.updated_at')
            ->orderBy('drivers_jahiz_clearing.updated_at', 'desc')
            ->offset(0)->limit(10)->get();
        return view('new_porttal.Drivers.DriversSettlementList')->with(compact('Driver'))
            ->with(compact('drivers_jahiz_clearing'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversSettlement($driverId, $jahiz_clearing_id)
    {
        $Driver = DB::select('SELECT drivers.id,fullName,warehouseId,warehouseName,driver_type_id,job_id from drivers
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers.id=' . $driverId)[0];

        $lkp_jahiz_period = DB::select("SELECT lkp_jahiz_period.id,year,month_id,month,CONCAT(year,'-',month) as ym
         from lkp_jahiz_period
         left join lkp_month on lkp_month.id=lkp_jahiz_period.month_id order by year desc,month_id desc");

        $drivers_jahiz_clearing = "";
        $drivers_jahiz_montly = "";


        if ($jahiz_clearing_id <> "0") {
            $drivers_jahiz_clearing = DB::select('select id, driverId,
             driver_type_id,TRIM(Jahiz_Amount)+0 as Jahiz_Amount, Jahiz_Amount_Sign,Bander_Commission,clearing_type_id,TRIM(bank)+0 as bank,TRIM(cash)+0 as cash,TRIM(ATM)+0 as ATM
             from drivers_jahiz_clearing where id=' . $jahiz_clearing_id)[0];

            $drivers_jahiz_montly = DB::select("select drivers_jahiz_montly.id, drivers_jahiz_montly.jahiz_period_id,CONCAT(year,'-',month) as ym,
            week1,week2,week3,week4,weekAll,
            week1_clearing_id,week1_dt,
            week2_clearing_id,week2_dt,
            week3_clearing_id,week3_dt,
            week4_clearing_id,week4_dt,
            weekAll_clearing_id,weekAll_dt,
            amount_by_days_clearing_id,amount_by_days_dt,amount_by_days_amount
              from drivers_jahiz_montly
            LEFT JOIN
            (
                select          jahiz_period_id,
                max(week1_clearing_id) as week1_clearing_id,max(week1_dt) as week1_dt,
                max(week2_clearing_id) as week2_clearing_id,max(week2_dt) as week2_dt,
                max(week3_clearing_id) as week3_clearing_id,max(week3_dt) as week3_dt,
                max(week4_clearing_id) as week4_clearing_id,max(week4_dt) as week4_dt,
                max(weekAll_clearing_id) as weekAll_clearing_id,max(weekAll_dt) as weekAll_dt,
                max(amount_by_days_clearing_id) as amount_by_days_clearing_id,max(amount_by_days_dt) as amount_by_days_dt,
                max(amount_by_days_amount) as amount_by_days_amount
                from(
                    select jahiz_period_id,
                CASE
                    WHEN week1 is not null THEN drivers_jahiz_clearing_id
                    ELSE null
                END week1_clearing_id,
                 CASE
                    WHEN week1 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week1_dt,
                CASE
                    WHEN week2 is not null THEN drivers_jahiz_clearing_id
                    ELSE null
                END week2_clearing_id,
                 CASE
                    WHEN week2 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week2_dt,
                CASE
                    WHEN week3 is not null THEN drivers_jahiz_clearing_id
                    ELSE null
                END week3_clearing_id,
                 CASE
                    WHEN week3 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week3_dt,
                CASE
                    WHEN week4 is not null THEN drivers_jahiz_clearing_id
                    ELSE null
                END week4_clearing_id,
                 CASE
                    WHEN week4 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week4_dt,
                CASE
                    WHEN weekAll is not null THEN drivers_jahiz_clearing_id
                    ELSE null
                END weekAll_clearing_id,
                 CASE
                    WHEN weekAll is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END weekAll_dt,
                CASE
                    WHEN amount_by_days is not null THEN drivers_jahiz_clearing_id
                    ELSE null
                END amount_by_days_clearing_id,
                 CASE
                    WHEN amount_by_days is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END amount_by_days_dt,
               CASE
                    WHEN amount_by_days is not null THEN amount_by_days
                    ELSE null
                END amount_by_days_amount

                from drivers_jahiz_montly
                where driverId=" . $driverId . "
                )aa
                    GROUP BY jahiz_period_id
                    )temp
                    on temp.jahiz_period_id=drivers_jahiz_montly.jahiz_period_id
                    LEFT JOIN lkp_jahiz_period on lkp_jahiz_period.id=drivers_jahiz_montly.jahiz_period_id
                    LEFT JOIN lkp_month ON lkp_month.id=lkp_jahiz_period.month_id
                    where drivers_jahiz_clearing_id=" . $jahiz_clearing_id);
        }
        return view('Drivers.DriversSettlement')->with(compact('Driver'))
            ->with(compact('lkp_jahiz_period'))
            ->with(compact('jahiz_clearing_id'))
            ->with(compact('drivers_jahiz_clearing'))
            ->with(compact('drivers_jahiz_montly'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversSettlementSave(Request $request)
    {
        //return  $request->input('bank').'*'.$request->input('cash');
        if ($request->input('Jahiz_Amount_Sign') == 1) $Sign = 1;
        elseif ($request->input('Jahiz_Amount_Sign') == 2) $Sign = -1;
        $amount = $Sign * floatval($request->input('Jahiz_Amount')) + floatval($request->input('Bander_Commission'));

        if ($request->input('clearing_type_id') == 1) $clearing = 1;
        elseif ($request->input('clearing_type_id') == 2) $clearing = -1;
        elseif ($request->input('clearing_type_id') == 3) $clearing = 0;
        $bank_cash = $clearing * (floatval($request->input('bank')) + floatval($request->input('cash')) + floatval($request->input('ATM')));


        if (number_format(floatval($amount), 2, '.', '') <> number_format(floatval($bank_cash), 2, '.', ''))
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/0")->with('error', $bank_cash . '***' . $amount . 'خطأ : المبلغ المسجل في جاهز + العمولة لايساوي السداد');

//----------------------------------------------------------------------------------------------------------------------------
        $sum_4week = 0;
        $sum_4weekANDall = 0;
        $sum_new = 0;
        for ($i = 1; $i <= $request->input('rownum'); $i++) {
            if ($request->input('jahiz_period_id_' . $i) <> '') {
                $sum_4week = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i));
                $sum_4weekANDall = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i)) + intval($request->input('weekAll_' . $i));

                $sum_new = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i)) + intval($request->input('weekAll_' . $i)) + intval($request->input('amount_by_days_' . $i));
                $sum_old = DB::table(DB::raw("(select
                sum(IFNULL(week1,0)+IFNULL(week2,0)+IFNULL(week3,0)+IFNULL(week4,0)+IFNULL(weekAll,0)+IFNULL(amount_by_days,0)) as SM
                from drivers_jahiz_montly
                where driverId=" . $request->input('driverId') .
                    " AND jahiz_period_id=" . $request->input('jahiz_period_id_' . $i) . ")a"))
                    ->first();
            }
        }
        if (isset($sum_old->SM)) $sum_old_SM = $sum_old->SM; else $sum_old_SM = 0;
        if ($sum_4week > 0 && intval($request->input('weekAll_' . $i)) > 0)
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/0")->with('error', 'خطأ :لم يتم التعديل لقد اخترت كل العمولة مع الاقساط ');
        if ($sum_4weekANDall > 0 && intval($request->input('amount_by_days_' . $i)) > 0)
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/0")->with('error', 'خطأ :لم يتم التعديل لقد اخترت الاقساط مع المبلغ بالايام ');
        if ($sum_new + intval($sum_old_SM) > 150)
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/0")->with('error', 'خطأ :لم يتم التعديل لان المبلغ اكبر من 150  :');
//----------------------------------------------------------------------------------------------------------------------------
        try {
            $imageName = '';
            if($request->hasFile('proof_file')) {
                $imageName = time().'.'.$request->proof_file->extension();
                $request->proof_file->move(storage_path('app/public/images'), $imageName);
            }
            $id = DB::table('drivers_jahiz_clearing')->insertGetId(
                [
                    'driverId' => $request->input('driverId'),
                    'driver_type_id' => $request->input('driver_type_id'),
                    'Jahiz_Amount' => $request->input('Jahiz_Amount'),
                    'Jahiz_Amount_Sign' => $request->input('Jahiz_Amount_Sign'),
                    'Bander_Commission' => $request->input('Bander_Commission'),
                    'clearing_type_id' => $request->input('clearing_type_id'),
                    'bank' => $request->input('bank'),
                    'cash' => $request->input('cash'),
                    'ATM' => $request->input('ATM'),
                    'created_by_id' => Auth::user()->id,
                    'updated_by_id' => Auth::user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    "proof_file"=>$imageName

                ]
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/0")->with('error', $e->getPrevious()->getMessage());
        }

        if ($request->input('driver_type_id') == 2) {
            for ($i = 1; $i <= $request->input('rownum'); $i++) {
                if ($request->input('jahiz_period_id_' . $i) <> '') {
                    $sum = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i)) + intval($request->input('weekAll_' . $i)) + intval($request->input('amount_by_days_' . $i));

                    if ($sum > 0 && $sum <= 150) {
                        DB::table('drivers_jahiz_montly')->insert(
                            [
                                'drivers_jahiz_clearing_id' => $id,
                                'driverId' => $request->input('driverId'),
                                'jahiz_period_id' => $request->input('jahiz_period_id_' . $i),
                                'week1' => $request->input('week1_' . $i),
                                'week2' => $request->input('week2_' . $i),
                                'week3' => $request->input('week3_' . $i),
                                'week4' => $request->input('week4_' . $i),
                                'weekAll' => $request->input('weekAll_' . $i),
                                'amount_by_days' => $request->input('amount_by_days_' . $i),
                                'updated_at' => date("Y-m-d H:i:s"),

                            ]
                        );
                    }
                }
            }
        }
        return redirect('/DriversSettlement/' . $request->input('driverId') . "/" . $id)->with('success', 'Done successfully');
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversSettlementUpdate(Request $request)
    {
        if ($request->input('Jahiz_Amount_Sign') == 1) $Sign = 1;
        elseif ($request->input('Jahiz_Amount_Sign') == 2) $Sign = -1;
        $amount = $Sign * floatval($request->input('Jahiz_Amount')) + floatval($request->input('Bander_Commission'));

        if ($request->input('clearing_type_id') == 1) $clearing = 1;
        elseif ($request->input('clearing_type_id') == 2) $clearing = -1;
        elseif ($request->input('clearing_type_id') == 3) $clearing = 0;
        $bank_cash = $clearing * (floatval($request->input('bank')) + floatval($request->input('cash')) + floatval($request->input('ATM')));


        if (number_format(floatval($amount), 2, '.', '') <> number_format(floatval($bank_cash), 2, '.', ''))
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/" . $request->input('jahiz_clearing_id'))->with('error', 'خطأ : المبلغ المسجل في جاهز + العمولة لايساوي السداد');

//----------------------------------------------------------------------------------------------------------------------------
        $sum_4week = 0;
        $sum_4weekANDall = 0;
        $sum_new = 0;
        for ($i = 1; $i <= $request->input('rownum'); $i++) {
            if ($request->input('jahiz_period_id_' . $i) <> '') {
                $sum_4week = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i));
                $sum_4weekANDall = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i)) + intval($request->input('weekAll_' . $i));

                $sum_new = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i)) + intval($request->input('weekAll_' . $i)) + intval($request->input('amount_by_days_' . $i));
                $sum_old = DB::table(DB::raw("(select
                sum(IFNULL(week1,0)+IFNULL(week2,0)+IFNULL(week3,0)+IFNULL(week4,0)+IFNULL(weekAll,0)+IFNULL(amount_by_days,0)) as SM
                from drivers_jahiz_montly
                where driverId=" . $request->input('driverId') .
                    " AND drivers_jahiz_clearing_id<>" . $request->input('jahiz_clearing_id') .
                    " AND jahiz_period_id=" . $request->input('jahiz_period_id_' . $i) . ")a"))
                    ->first();
            }
        }
        if (isset($sum_old->SM)) $sum_old_SM = $sum_old->SM; else $sum_old_SM = 0;
        if ($sum_4week > 0 && intval($request->input('weekAll_' . $i)) > 0)
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/" . $request->input('jahiz_clearing_id'))->with('error', 'خطأ :لم يتم التعديل لقد اخترت كل العمولة مع الاقساط ');
        if ($sum_4weekANDall > 0 && intval($request->input('amount_by_days_' . $i)) > 0)
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/" . $request->input('jahiz_clearing_id'))->with('error', 'خطأ :لم يتم التعديل لقد اخترت الاقساط مع المبلغ بالايام ');
        if ($sum_new + intval($sum_old_SM) > 150)
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/" . $request->input('jahiz_clearing_id'))->with('error', 'خطأ :لم يتم التعديل لان المبلغ اكبر من 150  :');
//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------
        try {
            $id = DB::table('drivers_jahiz_clearing')
                ->where('id', $request->input('jahiz_clearing_id'))
                ->update(
                    [
                        'driverId' => $request->input('driverId'),
                        'driver_type_id' => $request->input('driver_type_id'),
                        'Jahiz_Amount' => $request->input('Jahiz_Amount'),
                        'Jahiz_Amount_Sign' => $request->input('Jahiz_Amount_Sign'),
                        'Bander_Commission' => $request->input('Bander_Commission'),
                        'clearing_type_id' => $request->input('clearing_type_id'),
                        'bank' => $request->input('bank'),
                        'cash' => $request->input('cash'),
                        'ATM' => $request->input('ATM'),
                        'updated_by_id' => Auth::user()->id,
                        'updated_at' => date("Y-m-d H:i:s"),

                    ]
                );
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/DriversSettlement/' . $request->input('driverId') . "/" . $request->input('jahiz_clearing_id'))->with('error', $e->getPrevious()->getMessage());
        }
//----------------------------------------------------------------------------------------------------------------------------
        $IDs = "";
        if ($request->input('driver_type_id') == 2) {
            for ($i = 1; $i <= $request->input('rownum'); $i++) {
                if ($request->input('ID_' . $i) <> '') {
                    $IDs .= $request->input('ID_' . $i) . ",";
                }
            }
        }

        $IDs = substr($IDs, 0, strlen($IDs) - 1);

        if ($request->input('driver_type_id') == 3 || $IDs == "") {
            DB::delete("delete from drivers_jahiz_montly
                               where drivers_jahiz_clearing_id=" . $request->input('jahiz_clearing_id'));
        }

        if ($IDs <> "") {
            DB::delete("delete from drivers_jahiz_montly
                               where drivers_jahiz_clearing_id=" . $request->input('jahiz_clearing_id') . " AND id not in(" . $IDs . ")");
        }
//----------------------------------------------------------------------------------------------------------------------------
        if ($request->input('driver_type_id') == 2) {
            for ($i = 1; $i <= $request->input('rownum'); $i++) {
                if ($request->input('jahiz_period_id_' . $i) <> '') {
                    $sum = intval($request->input('week1_' . $i)) + intval($request->input('week2_' . $i)) + intval($request->input('week3_' . $i)) + intval($request->input('week4_' . $i)) + intval($request->input('weekAll_' . $i)) + intval($request->input('amount_by_days_' . $i));

                    if ($sum > 0 && $sum <= 150) {
                        DB::table('drivers_jahiz_montly')->updateOrInsert(
                            ['id' => $request->input('ID_' . $i)],
                            [
                                'drivers_jahiz_clearing_id' => $request->input('jahiz_clearing_id'),
                                'driverId' => $request->input('driverId'),
                                'jahiz_period_id' => $request->input('jahiz_period_id_' . $i),
                                'week1' => $request->input('week1_' . $i),
                                'week2' => $request->input('week2_' . $i),
                                'week3' => $request->input('week3_' . $i),
                                'week4' => $request->input('week4_' . $i),
                                'weekAll' => $request->input('weekAll_' . $i),
                                'amount_by_days' => $request->input('amount_by_days_' . $i),
                                'updated_at' => date("Y-m-d H:i:s"),

                            ]
                        );
                    }
                }
            }
        }
        return redirect('/DriversSettlement/' . $request->input('driverId') . "/" . $request->input('jahiz_clearing_id'))->with('success', 'Done successfully');
    }

    public function DriversSettlementDelete($driverId, $jahiz_clearing_id)
    {
        //return $driverId."--".$jahiz_clearing_id;
        DB::delete("delete from drivers_jahiz_montly
                               where drivers_jahiz_clearing_id=" . $jahiz_clearing_id);
        DB::delete("delete from drivers_jahiz_clearing
                               where id=" . $jahiz_clearing_id);
        return $this->DriversSettlementList($driverId);

    }

//***********************************************************************************************************************************
    public function statement_Jahiz($id)
    {

        $Driver = DB::select('SELECT fullName from drivers where id=' . $id)[0];
        $statement_SANED = DB::select("select drivers_saned_settlement.CollectionAmount,DeliveryPrice,DriverCredit,DriverDebit,SettledDate,
         drivers_saned_settlement.CollectionAmount-DeliveryPrice-DriverCredit+DriverDebit as SANED_amount
            FROM
                        drivers_saned_settlement
                        inner join drivers on drivers.job_id=drivers_saned_settlement.AMP_ID
                        where drivers.id=" . $id . " order by SettledDate desc limit 10 ");
        $statement_Bander = DB::select("select updated_at,
       CASE
                        WHEN Jahiz_Amount_Sign = 1 THEN Jahiz_Amount
                        WHEN Jahiz_Amount_Sign = 2 THEN Jahiz_Amount*-1

                    END
                    as Jahiz_Amount
            FROM
                        drivers_jahiz_clearing
                        where driverId=" . $id . " order by updated_at desc limit 10 ");
        return view('new_porttal.Drivers.statement_Jahiz')->with(compact('Driver'))
            ->with(compact('statement_SANED'))
            ->with(compact('statement_Bander'));
    }

//***********************************************************************************************************************************
    public function DriversAttend(Request $request)
    {
        $whereIn_array = array();

        $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
             inner join warehouse on warehouse.id=users_privilege.warehouseId
             where companyId=8
             AND user_id=' . Auth::user()->id);
        foreach ($users_privilege as $users_privilegee) {
            //return $users_privilegee->warehouseId;
            $whereIn_array[] = $users_privilegee->warehouseId;
        }
        if (count($whereIn_array) == 0) $whereIn_array[] = 0;
        //$Select_db->whereIn('warehouseId', $whereIn_array);


        $Drivers = DB::table('drivers')
            ->select('drivers.id as id', 'warehouseName', 'fullName',
                DB::raw("DATE_FORMAT(attendance_drivers.created_at, '%h:%i %p') as created_at"))
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('attendance_drivers', function ($join) {
                $join->on('attendance_drivers.driverId', '=', 'drivers.id')
                    ->whereRaw("CAST(attendance_drivers.created_at AS date) = '" . date("Y-m-d") . "'");

            })
            ->whereIn('warehouseId', $whereIn_array)
            ->whereRaw('status_id=1')
            ->orderBy('fullName', 'asc')
            ->get();
        // return $Drivers->toSql();

        if (isset($success))
            return view('Drivers.DriversAttend')->with(compact('Drivers'))->with('success', $success);
        elseif (isset($error))
            return view('Drivers.DriversAttend')->with(compact('Drivers'))->with('error', $error);
        else
            return view('Drivers.DriversAttend')->with(compact('Drivers'));

    }

    //***********************************************************************************************************************************
    public function DriversAttendSave(Request $request)
    {
        $whereIn_array = array();

        $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
             inner join warehouse on warehouse.id=users_privilege.warehouseId
             where companyId=8
             AND user_id=' . Auth::user()->id);
        foreach ($users_privilege as $users_privilegee) {
            //return $users_privilegee->warehouseId;
            $whereIn_array[] = $users_privilegee->warehouseId;
        }
        if (count($whereIn_array) == 0) $whereIn_array[] = 0;
        //$Select_db->whereIn('warehouseId', $whereIn_array);
//----------------------------------------------------------------------------------------------------------------------------
        $IDs = "";
        $IDs_array = array();
        for ($i = 1; $i <= 500; $i++) {
            if ($request->input('ID_' . $i) <> '') {
                $IDs .= $request->input('ID_' . $i) . ",";
                $IDs_array[] = $request->input('ID_' . $i);
            }
        }


        $IDs = substr($IDs, 0, strlen($IDs) - 1);
        if ($IDs == '') $IDs = '0';
        //return $IDs;


        DB::delete("delete from attendance_drivers
                               where driverId not in(" . $IDs . ")
                               AND driverId in(select id from drivers where warehouseId in(" . implode(',', $whereIn_array) . "))
                               AND CAST(created_at as date)='" . date("Y-m-d") . "'");


        if ($IDs <> '0') {
            $attendance_drivers = DB::select("select driverId from attendance_drivers
                               where driverId in(" . $IDs . ")
                               AND driverId in(select id from drivers where warehouseId in(" . implode(',', $whereIn_array) . "))
                               AND CAST(created_at as date)='" . date("Y-m-d") . "'");

            $attendance_drivers_array = array();
            foreach ($attendance_drivers as $attendance_driver) {
                $attendance_drivers_array[] = $attendance_driver->driverId;
            }
            for ($i = 0; $i < count($IDs_array); $i++) {
                if (!in_array($IDs_array[$i], $attendance_drivers_array)) {
                    DB::insert("insert into attendance_drivers(driverId,action_id,created_at)
                      values (" . $IDs_array[$i] . ",1,'" . date("Y-m-d H:i:s") . "')
                               ");
                }
            }
        }
//----------------------------------------------------------------------------------------------------------------------------


        return $this->DriversAttend($request)->with('success', 'Done successfully');
    }
}
function add_creditNote($driver, $request) {
    $daily_rent = round($driver->monthly_rent / 30, 2);
    $note = "Deduction for Absence ". $request->filter_date ." Plate: ".$driver->plate;
    DB::insert("INSERT INTO creditnotes (`driverId`, journal_date, `amount`, `note`, `createdby_id`, `updatedby_id`, `created_at`, `updated_at`) VALUES ('$driver->driverId', '$request->filter_date', '$daily_rent', '$note', '75', '75', NOW(), NOW())");
}
function delete_creditNote($driver, $request) {
    $daily_rent = round($driver->monthly_rent / 30, 2);
    $note = "Deduction for Absence ". $request->filter_date ." Plate: ".$driver->plate;
    DB::delete("DELETE FROM creditnotes where driverId = '$driver->driverId' AND `journal_date` = '$request->filter_date' AND amount = '$daily_rent' AND note = '$note'");
}

function add_driver_attendance_status($drivers, $request) {
    foreach ($drivers as &$driver) {
        $driver_attendance = DB::select("SELECT `id`, `status`, `date` FROM drivers_attendance Where `date` = '$request->filter_date' AND `vehicle_id` = '$driver->vehicle_id'");
        if (count($driver_attendance) > 0) {
            $driver->attendance_id = $driver_attendance[0]->id;
            $driver->status = $driver_attendance[0]->status;
            $driver->date = $driver_attendance[0]->date;
        } else {
            $driver->attendance_id = '';
            $driver->status = '';
            $driver->date = '';
        }
    }
    return $drivers;
}
function generate_response($drivers, $disabled)
{
    $response = '';
    foreach ($drivers as &$driver) {
        $vehicle_status = DB::select("SELECT current_status from vehicles where id = '$driver->vehicle_id'");
        if ($vehicle_status[0]->current_status == 'maintenance')
            continue;
        $present = $absent_excuse = $absent_no_excuse = '';
        if ($driver->status == 'present' || $driver->status == '') {
            $present = 'checked';
        } else if ($driver->status == 'absent with excuse') {
            $absent_excuse = 'checked';
        } else if ($driver->status == 'absent with no excuse') {
            $absent_no_excuse = 'checked';
        }
        $response .= '<tr>
        <td>'.$driver->companyName.'</td>
        <td>'.$driver->warehouseName.'</td>
        <td>'.$driver->job_id.'</td>
        <td>'.$driver->plate.'</td>
        <td>'.$driver->fullName.'</td>
        <td>'.$driver->name_en.'</td>
        <td style="display: flex; margin-left: 25px">
            <label class="radio-inline" style="padding-left: 0px !important"><input '.$disabled.' '.$present.' type="radio" class="rad" name="'.$driver->job_id.'" value="present" required />Present</label>
            <label class="radio-inline"><input '.$disabled.' '.$absent_excuse.' type="radio" name="'.$driver->job_id.'" class="rad" value="absent with excuse" required />Absent with Excuse</label>
            <label class="radio-inline"><input '.$disabled.' '.$absent_no_excuse.' type="radio" name="'.$driver->job_id.'" class="rad" value="absent with no excuse" required />Absent with No Excuse</label>
        </td>
        </tr>';
    }
    return $response;
}

function get_warehouse_previlage() {

    if (Auth::user()->user_type_id <> 1) {
        $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
        foreach ($users_privilege as $users_privilegee) {
            $whereIn_array[] = $users_privilegee->warehouseId;
        }
        if (count($whereIn_array) == 0) $whereIn_array[] = 0;
        $warehouse_clause_prev = " AND warehouse.id in(" . implode(",", $whereIn_array) . ")";
    } else {
        $warehouse_clause_prev = "";
    }
    return $warehouse_clause_prev;
}
