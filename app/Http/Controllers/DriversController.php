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
    public function index(Request $request)
    {
        $users = Drivers::all();
        
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
        elseif (Route::getFacadeRoot()->current()->uri() == 'Drivers')
            $view = "index";
        elseif (Route::getFacadeRoot()->current()->uri() == 'DriversJahiz')
            $view = "index_Jahiz";
        return view('Drivers.' . $view)->with(compact('warehouse'))->with(compact('lkp_country'))
            ->with(compact('lkp_driver_status'))->with(compact('lkp_termination_reasons'))
            ->with(compact('lkp_bank'))->with(compact('lkp_yes_no'))->with(compact('lkp_company'))
            ->with(compact('lkp_driver_type'));
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
        $lkp_country = DB::select('SELECT * from lkp_country order by country_en');
        $lkp_driver_status = DB::select('SELECT * from lkp_driver_status');
        $lkp_termination_reasons = DB::select('SELECT * from lkp_termination_reasons');
        $lkp_bank = DB::select('SELECT * from lkp_bank');
        $lkp_yes_no = DB::select('SELECT * from lkp_yes_no');
        if ($type_id == 2)
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
        else
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type order by id');
        return view('Drivers.create')->with(compact('warehouse'))->with(compact('lkp_country'))
            ->with(compact('lkp_driver_status'))->with(compact('lkp_termination_reasons'))
            ->with(compact('lkp_bank'))->with(compact('lkp_yes_no'))->with(compact('lkp_driver_type'))
            ->with(compact('type_id'));
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
        $Drivers = new Drivers;
        $Drivers->warehouseId = $request->input('warehouseId');
        $Drivers->fullName = $request->input('fullName');
        $Drivers->fullName_ar = $request->input('fullName_ar');
        $Drivers->mobileNumber = $request->input('mobileNumber');
        $Drivers->mobileNumber_someone_else = $request->input('mobileNumber_someone_else');
        $Drivers->nationality_id = $request->input('nationality_id');
        $Drivers->iqama = $request->input('iqama');
        if ($request->input('iqamaExpireyDate_y') == "")
            $Drivers->iqamaExpireyDate = null;
        else
            $Drivers->iqamaExpireyDate = $request->input('iqamaExpireyDate_y') . "-" . $request->input('iqamaExpireyDate_m') . "-" . $request->input('iqamaExpireyDate_d');
        $Drivers->email_id = $request->input('email_id');
        if (session('Session_DriversCarrefour') == 'yes') {
            $d = DB::select("select max(CONVERT(SUBSTR(job_id, 11),UNSIGNED INTEGER))as MX from drivers where job_id like 'Carrefour_%'")[0];
            $Carrefour_ = (int)$d->MX;
            $Carrefour_++;
            $Drivers->job_id = 'Carrefour_' . $Carrefour_;
        } else $Drivers->job_id = $request->input('job_id');

        if ($request->input('dob_y') == "")
            $Drivers->dob = null;
        else
            $Drivers->dob = $request->input('dob_y') . "-" . $request->input('dob_m') . "-" . $request->input('dob_d');
        $Drivers->status_id = $request->input('status_id');
        if ($request->input('status_id') != 3) {
            $Drivers->termination_reason_id = null;
        } else {
            $Drivers->termination_reason_id = $request->input('termination_reason_id');
        }
        if ($request->input('interview_date_y') == "")
            $Drivers->interview_date = null;
        else
            $Drivers->interview_date = $request->input('interview_date_y') . "-" . $request->input('interview_date_m') . "-" . $request->input('interview_date_d');
        if ($request->input('start_date_y') == "")
            $Drivers->start_date = null;
        else
            $Drivers->start_date = $request->input('start_date_y') . "-" . $request->input('start_date_m') . "-" . $request->input('start_date_d');
        if ($request->input('licenseExpireyDate_y') == "")
            $Drivers->licenseExpireyDate = null;
        else
            $Drivers->licenseExpireyDate = $request->input('licenseExpireyDate_y') . "-" . $request->input('licenseExpireyDate_m') . "-" . $request->input('licenseExpireyDate_d');
        $Drivers->passportNo = $request->input('passportNo');
        if ($request->input('passportExpireyDate_y') == "")
            $Drivers->passportExpireyDate = null;
        else
            $Drivers->passportExpireyDate = $request->input('passportExpireyDate_y') . "-" . $request->input('passportExpireyDate_m') . "-" . $request->input('passportExpireyDate_d');
        $Drivers->bank_id = $request->input('bank_id');
        $Drivers->accountNumber = $request->input('accountNumber');
        $Drivers->account_owner_iqama = $request->input('account_owner_iqama');
        $Drivers->under_sopnsorship_id = $request->input('under_sopnsorship_id');
        $Drivers->ajeer_id = $request->input('ajeer_id');
        $Drivers->bander_car_id = $request->input('bander_car_id');
        $Drivers->driver_type_id = $request->input('driver_type_id');
        $Drivers->created_by_id = Auth::user()->id;
        $Drivers->updated_by_id = Auth::user()->id;
        $Drivers->save();

        if ($request->input('type_id') == 1)
            return redirect('/Drivers')->with('success', 'Done successfully');
        if ($request->input('type_id') == 2)
            return redirect('/DriversJahiz')->with('success', 'Done successfully');
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
            ->select('drivers.id as id', 'companyId', 'warehouseId', 'warehouseName', 'fullName', 'fullName_ar', 'mobileNumber', 'mobileNumber_someone_else', 'nationality_id', 'country_en',
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
        return view('Drivers.show')->with('Drivers', $Drivers);
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
        if ($type_id == 2)
            $warehouse = DB::select('SELECT * from warehouse where companyId=6 order by warehouseName');
        else
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
            ->select('drivers.id as id','fuel_per_day','basic_salary' ,'warehouseId', 'warehouseName', 'companyName', 'fullName', 'fullName_ar', 'mobileNumber', 'mobileNumber_someone_else', 'nationality_id', 'country_ar',
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
            ->where('drivers.id', $id)
            ->first();
        return view('Drivers.edit')->with('Drivers', $Drivers)->with(compact('lkp_country'))
            ->with(compact('lkp_driver_status'))->with(compact('lkp_termination_reasons'))
            ->with(compact('lkp_bank'))->with(compact('lkp_yes_no'))
            ->with(compact('warehouse'))->with(compact('lkp_driver_type'))
            ->with(compact('type_id'));
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
            $Drivers = Drivers::find($id);
            if (Auth::user()->user_type_id == 1)
                $Drivers->warehouseId = $request->input('warehouseId');
            if (Auth::user()->user_type_id == 1 || session('Session_DriversCarrefour') == 'yes')
                $Drivers->fullName = $request->input('fullName');
                $Drivers->fullName_ar = $request->input('fullName_ar');
                $Drivers->mobileNumber = $request->input('mobileNumber');
                $Drivers->mobileNumber_someone_else = $request->input('mobileNumber_someone_else');
                $Drivers->nationality_id = $request->input('nationality_id');
                $Drivers->iqama = $request->input('iqama');
                $Drivers->fuel_per_day = $request->input('fuel_per_day');
                $Drivers->basic_salary = $request->input('basic_salary');

            if ($request->input('iqamaExpireyDate_y') == "")
                $Drivers->iqamaExpireyDate = null;
            else
                $Drivers->iqamaExpireyDate = $request->input('iqamaExpireyDate_y') . "-" . $request->input('iqamaExpireyDate_m') . "-" . $request->input('iqamaExpireyDate_d');
            $Drivers->email_id = $request->input('email_id');
            if (Auth::user()->user_type_id == 1)
                $Drivers->job_id = $request->input('job_id');
            if ($request->input('dob_y') == "")
                $Drivers->dob = null;
            else
                $Drivers->dob = $request->input('dob_y') . "-" . $request->input('dob_m') . "-" . $request->input('dob_d');
            if (Auth::user()->user_type_id == 1 || session('Session_DriversJahiz') == 'yes'|| session('Session_DriversCarrefour') == 'yes'||session('Session_Drivers')=='yes')
                $Drivers->status_id = $request->input('status_id');
            if ($request->input('status_id') != 3) {
                $Drivers->termination_reason_id = null;
            } else {
                $Drivers->termination_reason_id = $request->input('termination_reason_id');
            }
            if ($request->input('interview_date_y') == "")
                $Drivers->interview_date = null;
            else
                $Drivers->interview_date = $request->input('interview_date_y') . "-" . $request->input('interview_date_m') . "-" . $request->input('interview_date_d');
            if ($request->input('start_date_y') == "")
                $Drivers->start_date = null;
            else
                $Drivers->start_date = $request->input('start_date_y') . "-" . $request->input('start_date_m') . "-" . $request->input('start_date_d');
            if ($request->input('licenseExpireyDate_y') == "")
                $Drivers->licenseExpireyDate = null;
            else
                $Drivers->licenseExpireyDate = $request->input('licenseExpireyDate_y') . "-" . $request->input('licenseExpireyDate_m') . "-" . $request->input('licenseExpireyDate_d');
            $Drivers->passportNo = $request->input('passportNo');
            if ($request->input('passportExpireyDate_y') == "")
                $Drivers->passportExpireyDate = null;
            else
                $Drivers->passportExpireyDate = $request->input('passportExpireyDate_y') . "-" . $request->input('passportExpireyDate_m') . "-" . $request->input('passportExpireyDate_d');
            $Drivers->bank_id = $request->input('bank_id');
            $Drivers->accountNumber = $request->input('accountNumber');
            $Drivers->account_owner_iqama = $request->input('account_owner_iqama');
            $Drivers->under_sopnsorship_id = $request->input('under_sopnsorship_id');
            $Drivers->ajeer_id = $request->input('ajeer_id');
            $Drivers->bander_car_id = $request->input('bander_car_id');
            if (Auth::user()->user_type_id == 1 || session('Session_DriversJahiz') == 'yes')
                $Drivers->driver_type_id = $request->input('driver_type_id');
            $Drivers->updated_by_id = Auth::user()->id;
            $Drivers->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->edit($id, $request->input('type_id'))->with('error', $e->getPrevious()->getMessage());
        }
        return $this->edit($id, $request->input('type_id'))->with('success', 'Done successfully');
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
            //    return redirect('/Drivers')->with('error','Unauthorized');
            // }
            if ($Drivers->logo != 'noImage.jpg') {
                Storage::delete('public/app/storage' . $Drivers->logo);
            }
            $Drivers->delete();
        }
        return redirect('/Drivers')->with('success', 'Done successfully');
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
            return redirect('/Drivers')->with('error', $sql . $e->getPrevious()->getMessage());
        }
        try {
            if ($IDs <> "")
                DB::update("update drivers set status_id=5,onhold_date='" . date("Y-m-d H:i:s") . "'
        where status_id<>5 and drivers.id in(" . $IDs . ")
         ");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/Drivers')->with('error', $e->getPrevious()->getMessage());
        }
        return redirect('/Drivers')->with('success', 'Done successfully');
    }

    public function ResetPass($id)
    {
        $Driver = DB::select('SELECT fullName from drivers where id=' . $id)[0];
        return view('Drivers.ResetPass')->with(compact('Driver'))->with(compact('id'));
    }

    public function SaveResetPass(Request $request)
    {
        $Drivers = Drivers::find($request->input('id'));
        $Drivers->password = bcrypt($request->input('password'));
        $Drivers->save();
        return redirect('/Drivers')->with('success', 'Done successfully');
    }

    public function Attachment($id)
    {
        $Driver = DB::select('SELECT id,fullName from drivers where id=' . $id)[0];

        $drivers_attachments = DB::table('drivers_attachments')
            ->select('driverId', 'Image_Identity', 'Image_Passport', 'Image_DrivingLicence',
                'Image_VehiclesRegistration', 'Image_JobContract', 'Image_PromissoryNote')
            ->where('driverId', '=', $id)
            ->first();


        return view('Drivers.Attachment')->with(compact('Driver'))->with(compact('drivers_attachments'));
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
        return view('Drivers.statement')->with(compact('Driver'))->with(compact('statement'));
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
            ->select(DB::raw("drivers_jahiz_clearing.id as id, drivers_jahiz_clearing.driverId,companyName,warehouseName,job_id, drivers.fullName as fullName, fullName_ar,
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
        return view('Drivers.DriversSettlementList')->with(compact('Driver'))
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
        // dd('DriversSettlementSave');
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
        return view('Drivers.statement_Jahiz')->with(compact('Driver'))
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
