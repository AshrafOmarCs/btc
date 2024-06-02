<?php

namespace App\Http\Controllers;

use App\DriversJahizClearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriversJahizClearingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!request()->ajax()) {
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
                $wher= ' where warehouse.id in('.implode(",",$whereIn_array).') ';
            }
            else
                $wher = ' where companyId=6 ';

            $warehouse = DB::select('SELECT * from warehouse '.$wher.' order by warehouseName ');
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
            $lkp_jahiz_period = DB::select("SELECT lkp_jahiz_period.id,year,month_id,month,CONCAT(year,'-',month) as ym
         from lkp_jahiz_period
         left join lkp_month on lkp_month.id=lkp_jahiz_period.month_id order by year desc,month_id desc");

            $lkp_clearing_type = DB::select('SELECT id,clearing_type from lkp_clearing_type  order by id ');

        }
//***********************************************************************************************************************
//***********************************************************************************************************************

        elseif (request()->ajax()) {

            $Select_db = DB::table('drivers_jahiz_clearing')
                ->select(DB::raw("drivers_jahiz_clearing.id as id, drivers_jahiz_clearing.driverId,warehouseName,job_id, drivers.fullName as fullName,
             driver_type,Bander_Commission,paid_id,drivers.account_owner_iqama, accountNumber,
             CASE WHEN Jahiz_Amount_Sign = 1 THEN Jahiz_Amount  END as Jahiz_Amount_plus,
             CASE WHEN Jahiz_Amount_Sign = 2 THEN Jahiz_Amount  END as Jahiz_Amount_minus,
             FLOOR(CASE WHEN clearing_type_id = 1 THEN bank END) as bank_plus,
             FLOOR(CASE WHEN clearing_type_id = 1 THEN cash END) as cash_plus,
             FLOOR(CASE WHEN clearing_type_id = 1 THEN ATM END) as ATM_plus,
             FLOOR(CASE WHEN clearing_type_id = 2 THEN bank END) as bank_minus,
             FLOOR(CASE WHEN clearing_type_id = 2 THEN cash END) as cash_minus,
              GROUP_CONCAT(CONCAT(year,'-',month,'_',COALESCE(week1,''),'_',COALESCE(week2,''),'_',COALESCE(week3,''),'_',COALESCE(week4,''),'_',COALESCE(weekAll,''),'_',COALESCE(amount_by_days,'')) SEPARATOR ';') as jahiz_montly,
             name,drivers_jahiz_clearing.created_at as created_at, drivers_jahiz_clearing.updated_at as updated_at"))
                ->leftJoin('drivers', 'drivers_jahiz_clearing.driverId', '=', 'drivers.id')
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('drivers_jahiz_montly', 'drivers_jahiz_montly.drivers_jahiz_clearing_id', '=', 'drivers_jahiz_clearing.id')
                ->leftJoin('lkp_jahiz_period', 'lkp_jahiz_period.id', '=', 'drivers_jahiz_montly.jahiz_period_id')
                ->leftJoin('lkp_month', 'lkp_month.id', '=', 'lkp_jahiz_period.month_id')
                ->leftJoin('lkp_driver_type', 'drivers_jahiz_clearing.driver_type_id', '=', 'lkp_driver_type.id')
                ->leftJoin('users', 'drivers_jahiz_clearing.updated_by_id', '=', 'users.id')
                ->groupBy('drivers_jahiz_clearing.id', 'drivers_jahiz_clearing.driverId', 'warehouseName', 'job_id', 'drivers.fullName',
                    'driver_type', 'Bander_Commission', 'drivers.account_owner_iqama', 'accountNumber',
                    'name', 'drivers_jahiz_clearing.created_at', 'drivers_jahiz_clearing.updated_at');

            $where = '';
            $fields = array();
            if (!empty($request->filter_jahiz_period_id)) {
                $fields[] = 'jahiz_period_id=' . $request->filter_jahiz_period_id;
            }
            if (!empty($request->filter_week1)) {
                $fields[] = 'week1=' . $request->filter_week1;
            }
            if (!empty($request->filter_week2)) {
                $fields[] = 'week2=' . $request->filter_week2;
            }
            if (!empty($request->filter_week3)) {
                $fields[] = 'week3=' . $request->filter_week3;
            }
            if (!empty($request->filter_week4)) {
                $fields[] = 'week4=' . $request->filter_week4;
            }
            if (!empty($request->filter_weekAll)) {
                $fields[] = 'weekAll=' . $request->filter_weekAll;
            }
            if (count($fields) > 0) {
                $where = ' where ' . implode(' AND ', $fields);
            }
            //return  $where;

            $Select_sum = DB::table('drivers_jahiz_clearing')
                ->select(DB::raw("
            sum(CASE WHEN Jahiz_Amount_Sign = 1 THEN IFNULL(Jahiz_Amount,0) END)+0 as Jahiz_Amount_plus,
            sum(CASE WHEN Jahiz_Amount_Sign = 2 THEN IFNULL(Jahiz_Amount,0) END)+0 as Jahiz_Amount_minus,
            sum(week1) as week1,
            sum(week2) as week2,
            sum(week3) as week3,
            sum(week4) as week4,
            sum(weekAll) as weekAll,
             sum(amount_by_days) as amount_by_days,
            sum(IFNULL(Bander_Commission,0))+0 as Bander_Commission,
            sum(CASE WHEN clearing_type_id = 1 THEN FLOOR(IFNULL(bank,0)) END)+0 as bank_plus,
            sum(CASE WHEN clearing_type_id = 1 THEN FLOOR(IFNULL(cash,0)) END)+0 as cash_plus,
            sum(CASE WHEN clearing_type_id = 1 THEN FLOOR(IFNULL(ATM,0)) END)+0 as ATM_plus,
            sum(CASE WHEN clearing_type_id = 2 THEN FLOOR(IFNULL(bank,0)) END)+0 as bank_minus,
            sum(CASE WHEN clearing_type_id = 2 THEN FLOOR(IFNULL(cash,0)) END)+0 as cash_minus
            "))
                ->leftJoin('drivers', 'drivers_jahiz_clearing.driverId', '=', 'drivers.id')
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
                ->leftJoin('lkp_driver_type', 'drivers_jahiz_clearing.driver_type_id', '=', 'lkp_driver_type.id')
                ->leftJoin('users', 'drivers_jahiz_clearing.updated_by_id', '=', 'users.id');
            if ($where == "")
                $Select_sum->leftJoin(DB::raw("(select      drivers_jahiz_clearing_id,
            sum(IFNULL(week1,0)) as week1,
            sum(IFNULL(week2,0)) as week2,
            sum(IFNULL(week3,0)) as week3,
            sum(IFNULL(week4,0)) as week4,
            sum(IFNULL(weekAll,0)) as weekAll,
            sum(IFNULL(amount_by_days,0)) as amount_by_days
            from drivers_jahiz_montly
            " . $where . "
            GROUP BY drivers_jahiz_clearing_id)drivers_jahiz_montly"), 'drivers_jahiz_montly.drivers_jahiz_clearing_id', '=', 'drivers_jahiz_clearing.id');
            else
                $Select_sum->join(DB::raw("(select      drivers_jahiz_clearing_id,
            sum(IFNULL(week1,0))+0 as week1,
            sum(IFNULL(week2,0))+0 as week2,
            sum(IFNULL(week3,0))+0 as week3,
            sum(IFNULL(week4,0))+0 as week4,
            sum(IFNULL(weekAll,0))+0 as weekAll,
             sum(IFNULL(amount_by_days,0))+0 as amount_by_days
            from drivers_jahiz_montly
            " . $where . "
            GROUP BY drivers_jahiz_clearing_id)drivers_jahiz_montly"), 'drivers_jahiz_montly.drivers_jahiz_clearing_id', '=', 'drivers_jahiz_clearing.id');


            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege  inner join warehouse on warehouse.id=users_privilege.warehouseId
                               where companyId=6 AND user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;

                $Select_db->whereRaw('warehouseId in('.implode(",", $whereIn_array) . ')');
                $Select_sum->whereRaw('warehouseId in('. implode(",", $whereIn_array) . ')');
            }

            if (!empty($request->filter_warehouseId)) {
                $Select_db->whereRaw('warehouseId=' . $request->filter_warehouseId);
                $Select_sum->whereRaw('warehouseId=' . $request->filter_warehouseId);
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
                $Select_sum->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driver_type_id)) {
                $Select_db->whereRaw('drivers_jahiz_clearing.driver_type_id=' . $request->filter_driver_type_id);
                $Select_sum->whereRaw('drivers_jahiz_clearing.driver_type_id=' . $request->filter_driver_type_id);
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->whereRaw('drivers_jahiz_clearing.driverId=' . $request->filter_driverId);
                $Select_sum->whereRaw('drivers_jahiz_clearing.driverId=' . $request->filter_driverId);
            }
            if (!empty($request->filter_Jahiz_Amount_Sign)) {
                $Select_db->whereRaw('drivers_jahiz_clearing.Jahiz_Amount_Sign=' . $request->filter_Jahiz_Amount_Sign);
                $Select_sum->whereRaw('drivers_jahiz_clearing.Jahiz_Amount_Sign=' . $request->filter_Jahiz_Amount_Sign);
            }
            if (!empty($request->filter_jahiz_period_id)) {
                $Select_db->whereRaw('drivers_jahiz_montly.jahiz_period_id=' . $request->filter_jahiz_period_id);

            }
            if (!empty($request->filter_week1)) {
                $Select_db->whereRaw('drivers_jahiz_montly.week1=' . $request->filter_week1);
            }
            if (!empty($request->filter_week2)) {
                $Select_db->whereRaw('drivers_jahiz_montly.week2=' . $request->filter_week2);
            }
            if (!empty($request->filter_week3)) {
                $Select_db->whereRaw('drivers_jahiz_montly.week3=' . $request->filter_week3);
            }
            if (!empty($request->filter_week4)) {
                $Select_db->whereRaw('drivers_jahiz_montly.week4=' . $request->filter_week4);
            }
            if (!empty($request->filter_weekAll)) {
                $Select_db->whereRaw('drivers_jahiz_montly.weekAll=' . $request->filter_weekAll);
            }

            if (!empty($request->filter_clearing_type_id)) {
                $Select_db->whereRaw('clearing_type_id=' . $request->filter_clearing_type_id);
                $Select_sum->whereRaw('clearing_type_id=' . $request->filter_clearing_type_id);
            }
            if (!empty($request->filter_bank)) {
                $Select_db->whereRaw("bank is not null ");
                $Select_sum->whereRaw("bank is not null");
            }
            if (!empty($request->filter_cash)) {
                $Select_db->whereRaw("cash is not null ");
                $Select_sum->whereRaw("cash is not null");
            }
            if (!empty($request->filter_ATM)) {
                $Select_db->whereRaw("ATM is not null ");
                $Select_sum->whereRaw("ATM is not null");
            }
            if ($request->filter_paid_id <> "") {
                if ($request->filter_paid_id == "1") {
                    $Select_db->whereRaw('paid_id is not null');
                    $Select_sum->whereRaw('paid_id is not null');
                }
                if ($request->filter_paid_id == "2") {
                    $Select_db->whereRaw('paid_id is  null');
                    $Select_sum->whereRaw('paid_id is  null');
                }
            }
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(drivers_jahiz_clearing.created_at as date) between STR_TO_DATE('$filter_created_at[0]',' % d /%m /%Y') and STR_TO_DATE('$filter_created_at[1]',' % d /%m /%Y')");
                $Select_sum->whereRaw("CAST(drivers_jahiz_clearing.created_at as date) between STR_TO_DATE('$filter_created_at[0]',' % d /%m /%Y') and STR_TO_DATE('$filter_created_at[1]',' % d /%m /%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(drivers_jahiz_clearing.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]',' % d /%m /%Y') and STR_TO_DATE('$filter_updated_at[1]',' % d /%m /%Y')");
                $Select_sum->whereRaw("CAST(drivers_jahiz_clearing.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]',' % d /%m /%Y') and STR_TO_DATE('$filter_updated_at[1]',' % d /%m /%Y')");
            }

            /* if(isset($_REQUEST['search']['value'])&&$_REQUEST['search']['value']<>'') {
                  $options = strtolower($_REQUEST['search']['value']);
                  $Select_sum->whereRaw("(
              LOWER(
                  `warehouse`.`warehouseName`
              ) LIKE ' % " . $options . " % '
              OR LOWER(`drivers`.`job_id`) LIKE ' % " . $options . " % '
              OR LOWER(`drivers`.`fullName`) LIKE ' % " . $options . " % '
              OR LOWER(`lkp_driver_type`.`driver_type`) LIKE ' % " . $options . " % '

             )");
              }
            */

            //return $Select_db->toSql();
            //return $Select_sum->toSql();
            $Select_sum = $Select_sum->first();
            return datatables()->of($Select_db)
                ->with('Jahiz_Amount_plus', ' <b>' . $Select_sum->Jahiz_Amount_plus . ' </b > ')
                ->with('Jahiz_Amount_minus', ' <b>' . $Select_sum->Jahiz_Amount_minus . ' </b > ')
                ->with('week1', ' <b>' . $Select_sum->week1 . ' </b > ')
                ->with('week2', ' <b>' . $Select_sum->week2 . ' </b > ')
                ->with('week3', ' <b>' . $Select_sum->week3 . ' </b > ')
                ->with('week4', ' <b>' . $Select_sum->week4 . ' </b > ')
                ->with('weekAll', ' <b>' . $Select_sum->weekAll . ' </b > ')
                ->with('amount_by_days', ' <b>' . $Select_sum->amount_by_days . ' </b > ')
                ->with('Bander_Commission', ' <b>' . $Select_sum->Bander_Commission . ' </b > ')
                ->with('bank_plus', ' <b>' . $Select_sum->bank_plus . ' </b > ')
                ->with('cash_plus', ' <b>' . $Select_sum->cash_plus . ' </b > ')
                ->with('ATM_plus', ' <b>' . $Select_sum->ATM_plus . ' </b > ')
                ->with('bank_minus', ' <b>' . $Select_sum->bank_minus . ' </b > ')
                ->with('cash_minus', ' <b>' . $Select_sum->cash_minus . ' </b > ')
                ->make(true);

            //return $Select_db->toSql();
            //return datatables()->of($Select_db)->make(true);
        }

        //$data = $Select_db->get();

        return view('new_porttal.DriversJahizClearing.index')
            ->with(compact('warehouse'))
            ->with(compact('lkp_driver_type'))
            ->with(compact('lkp_jahiz_period'))
            ->with(compact('lkp_clearing_type'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        $DriversJahizClearing = DB::table('drivers_jahiz_clearing')
            ->select('DriversJahizClearing . id as id', 'driverId', 'fullName', 'fullName_ar', 'DriversJahizClearing_date',
                'amount', 'note', 'DriversJahizClearing . status_id as status_id', 'DriversJahizClearing_status',
                'updatedby_id', 'name', 'updated_usertypeid', 'user_type',
                'DriversJahizClearing . created_at as created_at', 'DriversJahizClearing . updated_at as updated_at')
            ->leftJoin('drivers', 'DriversJahizClearing . driverId', ' = ', 'drivers . id')
            ->leftJoin('lkp_DriversJahizClearing_status', 'DriversJahizClearing . status_id', ' = ', 'lkp_DriversJahizClearing_status . id')
            ->leftJoin('users', 'DriversJahizClearing . updatedby_id', ' = ', 'users . id')
            ->leftJoin('lkp_updated_usertype', 'DriversJahizClearing . updated_usertypeid', ' = ', 'lkp_updated_usertype . id')
            ->where('DriversJahizClearing . id', $id)
            ->first();

        return view('DriversJahizClearing . show')->with('drivers_jahiz_clearing', $DriversJahizClearing);
    }


}
