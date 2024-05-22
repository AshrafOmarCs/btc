<?php

namespace App\Http\Controllers;

use App\Drivers;
use App\User;
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
use Maatwebsite\Excel\Facades\Excel;


class DashoardController extends Controller
{
    //
    public function index()  {

        return view("new_porttal.dashboards.index");
    }
    public function index_drivers(Request $request)  {
        $vehicles = DB::select("SELECT * from vehicles order by plate");
            // dd($users[0]);
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
                    $wher = " where lkp_company.id in(" . implode(",", $whereIn_array) . ")";
                    $AND = " AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
                } else {
                    $wher = ' where ' . $companyId;
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
                    //
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
                if (Route::getFacadeRoot()->current()->uri() == 'DriversJahiz')
                    $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
                else
                    $lkp_driver_type = DB::select('SELECT * from lkp_driver_type order by id');
                    // dd($lkp_driver_type);
            }

            //***********************************************************************************************************************
            //***********************************************************************************************************************
            elseif (request()->ajax()) {

                $Select_db = DB::table('drivers')
                    ->select('drivers.id as id', 'companyName', 'warehouseId', 'warehouseName', 'lkp_city.name_en', 'fullName', 'fullName_ar', 'mobileNumber', 'mobileNumber_someone_else', 'nationality_id', 'lkp_country.country_ar',
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
                if ($request->filter_Image_Identity <> "" || $request->filter_Image_Passport <> "" || $request->filter_Image_DrivingLicence <> "" || $request->filter_Image_VehiclesRegistration <> "" || $request->filter_Image_JobContract <> "" || $request->filter_Image_PromissoryNote <> "")
                    $Select_db->leftJoin('drivers_attachments', 'drivers.id', '=', 'drivers_attachments.driverId');
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
                // dd($lkp_company);
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
            elseif (Route::getFacadeRoot()->current()->uri() == 'New-Portal/Drivers') {
                $view = "index_drives";
                $users = Drivers::all();
            }
            elseif (Route::getFacadeRoot()->current()->uri() == 'New-Portal/DriversJahiz') {
                $view = "index_Jahiz";
                $users = Drivers::whereIn('driver_type_id', [2, 3])->get();
            }
            // return view('Drivers.' . $view)->with(compact('warehouse'))->with(compact('lkp_country'))
            //     ->with(compact('lkp_driver_status'))->with(compact('lkp_termination_reasons'))
            //     ->with(compact('lkp_bank'))->with(compact('lkp_yes_no'))->with(compact('lkp_company'))
            //     ->with(compact('lkp_driver_type'));
            $analatics = array('active'=>0,'Onhold'=>0,'Terminated'=>0,'wrongWarehouse'=>0);
            foreach ($users as $key => $value) {
                # code...
                switch ($value->status_id ) {
                    case 1:
                        # code...
                        $analatics['active'] = $analatics['active'] + 1;
                        break;
                    case 2:
                        # code...
                        $analatics['Onhold'] = $analatics['Onhold'] + 1;
                        break;
                    case 5:
                        # code...
                        $analatics['Onhold'] = $analatics['Onhold'] + 1;
                        break;
                    case 3:
                        # code...
                        $analatics['Terminated'] = $analatics['Terminated'] + 1;
                        break;
                    case 4:
                    # code...
                        $analatics['Terminated'] = $analatics['Terminated'] + 1;
                        break;
                    case 6:
                        # code...
                        $analatics['wrongWarehouse'] = $analatics['wrongWarehouse'] + 1;
                        break;
                    default:
                        # code...
                        dd($value);
                        dd("Error While fetching Data, Contact your Supervisor");
                        break;
                }

            }
        $lkp_jahiz_period = DB::select("SELECT lkp_jahiz_period.id,year,month_id,month,CONCAT(year,'-',month) as ym
        from lkp_jahiz_period
        left join lkp_month on lkp_month.id=lkp_jahiz_period.month_id order by year desc,month_id desc");
        return view("new_porttal.dashboards.".$view,compact('vehicles', 'warehouse','lkp_country','lkp_driver_status','lkp_termination_reasons','lkp_bank','lkp_yes_no','lkp_company','lkp_driver_type','analatics', 'lkp_jahiz_period'));
    }
    //
    public function drivers_save(Request $request) {
        $validator = Validator::make($request->all(), [
            'drivers_file' => 'required|file|max:2048', // max file size is 2MB
        ]);

        // Custom validation for file extension
        $validator->after(function ($validator) use ($request) {
            if ($request->hasFile('drivers_file')) {
                $file = $request->file('drivers_file');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['xlsx', 'xls', 'csv'];

                if (!in_array($extension, $allowedExtensions)) {
                    $validator->errors()->add('drivers_file', 'The file must be a file of type: xlsx, xls, csv.');
                }
            }
        });

        // Check if the validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::user()->id;
        $path = $request->file('drivers_file')->getRealPath();
        $data = Excel::toCollection(null, $path);
        // Assuming the data is in the first sheet
        $rows = $data->first();
        $rows->shift();
        foreach ($rows as $row) {
            print_r($row);
        }
        return back()->withSuccess("Drivers added successfully");
    }
}
