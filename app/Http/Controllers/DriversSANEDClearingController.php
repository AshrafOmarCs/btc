<?php

namespace App\Http\Controllers;

use App\DriversSANEDClearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriversSANEDClearingController extends Controller
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
                $wher = ' where warehouse.id in(' . implode(",", $whereIn_array) . ') ';
            } else
                $wher = ' where companyId=6 ';
            $warehouse = DB::select('SELECT * from warehouse ' . $wher . ' order by warehouseName ');
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
            $lkp_jahiz_period = DB::select("SELECT lkp_jahiz_period.id,year,month_id,month,CONCAT(year,'-',month) as ym
         from lkp_jahiz_period
         left join lkp_month on lkp_month.id=lkp_jahiz_period.month_id order by year desc,month_id desc");

            $lkp_clearing_type = DB::select('SELECT id,clearing_type from lkp_clearing_type  order by id ');

        }
//***********************************************************************************************************************
//***********************************************************************************************************************

        elseif (request()->ajax()) {

            $Select_db = DB::table('drivers_saned_settlement')
                ->select(DB::raw("drivers_saned_settlement.id,AMP_ID,DriverName,SettledDate,
                CASE
                    WHEN COALESCE (a.driver_type_id, b.driver_type_id, c.driver_type_id) =3 OR
                    COALESCE (a.driver_type_id, b.driver_type_id, c.driver_type_id) is NULL
                      THEN NoOfDispatch
                END AS NoOfDispatch
                ,
                drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit AS SANED_amount,
                drivers_saned_settlement.drivers_jahiz_clearing_paid_id ,drivers.id as driverId,
                COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id ) AS driver_type_id,
                driver_type,
                COALESCE ( a.id,b.id,c.id ) AS drivers_jahiz_clearing_id,
                warehouseName,job_id, drivers.fullName as fullName,

             COALESCE (a.Bander_Commission,b.Bander_Commission,c.Bander_Commission) Bander_Commission,
             COALESCE (a.paid_id,b.paid_id,c.paid_id) AS paid_id,
             drivers.account_owner_iqama,
             drivers.accountNumber,
             CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END AS Jahiz_Amount,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN COALESCE(a.bank,b.bank,c.bank) END) AS bank_plus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN COALESCE(a.cash,b.cash,c.cash) END) AS cash_plus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN COALESCE(a.ATM,b.ATM,c.ATM) END) AS ATM_plus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 2 THEN COALESCE(a.bank,b.bank,c.bank) END) AS bank_minus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 2 THEN COALESCE(a.cash,b.cash,c.cash) END) AS cash_minus,
             COALESCE (a.created_at,b.created_at,c.created_at) AS created_at,
             COALESCE (a.updated_at,b.updated_at,c.updated_at) AS updated_at "))
                ->leftJoin('drivers', 'drivers_saned_settlement.AMP_ID', '=', 'drivers.job_id')
                ->leftJoin('drivers_jahiz_clearing AS a', function ($join) {
                    $join->on('a.id', '=', 'drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->whereNotNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id');
                })
                ->leftJoin('drivers_jahiz_clearing AS b', function ($join) {
                    $join->on('b.driverId', '=', 'drivers.id')
                        ->whereNull('a.id')
                        ->whereNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->on('b.updated_at', '=', DB::raw('
                        (
                            select min(updated_at)
                            from drivers_jahiz_clearing
                            where drivers_jahiz_clearing.driverId=drivers.id
                            AND drivers_jahiz_clearing.updated_at >=drivers_saned_settlement.SettledDate
                            AND drivers_jahiz_clearing.paid_id IS NULL
                            AND  drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit=
	                        CASE
                                WHEN Jahiz_Amount_Sign = 1 THEN
                                Jahiz_Amount
                                WHEN Jahiz_Amount_Sign = 2 THEN
                                Jahiz_Amount *- 1
                            END
                        )'));
                })
                ->leftJoin('drivers_jahiz_clearing AS c', function ($join) {
                    $join->on('c.driverId', '=', 'drivers.id')
                        ->whereNull('a.id')
                        ->whereNull('b.id')
                        ->whereNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->whereRaw('CASE
                           WHEN c.Jahiz_Amount_Sign = 1 THEN
                              c.Jahiz_Amount
                           WHEN c.Jahiz_Amount_Sign = 2 THEN
                              c.Jahiz_Amount *- 1
                           END
                        not in(select drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit from drivers_saned_settlement
                        where drivers_saned_settlement.AMP_ID=drivers.job_id
                        AND c.updated_at >= drivers_saned_settlement.SettledDate
                        AND drivers_jahiz_clearing_paid_id is null)')
                        ->on('c.updated_at', '=', DB::raw('
                        (
                            select min(updated_at)
                            from drivers_jahiz_clearing
                            where drivers_jahiz_clearing.driverId=drivers.id
                            AND drivers_jahiz_clearing.updated_at >=drivers_saned_settlement.SettledDate
                            AND drivers_jahiz_clearing.paid_id IS NULL
                            AND  drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit<>
	                        CASE
                                WHEN Jahiz_Amount_Sign = 1 THEN
                                Jahiz_Amount
                                WHEN Jahiz_Amount_Sign = 2 THEN
                                Jahiz_Amount *- 1
                            END
                        )'));
                })
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_driver_type', DB::raw("COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id )"), '=', 'lkp_driver_type.id');

//return  $request->filter_week1;
            $Select_sum = DB::table('drivers_saned_settlement')
                ->select(DB::raw("
                sum(drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit)+0 AS SANED_amount,
                sum(CASE
                    WHEN COALESCE (a.driver_type_id, b.driver_type_id, c.driver_type_id) =3 OR
                    COALESCE (a.driver_type_id, b.driver_type_id, c.driver_type_id) is NULL
                      THEN NoOfDispatch
                END) AS NoOfDispatch,
            sum(CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END)+0
                    as Jahiz_Amount,
            sum(IFNULL(COALESCE (a.Bander_Commission,b.Bander_Commission,c.Bander_Commission),0))+0 as Bander_Commission,
            sum(CASE WHEN COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN FLOOR(IFNULL(COALESCE (a.bank,b.bank,c.bank),0)) END)+0 as bank_plus,
            sum(CASE WHEN COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN FLOOR(IFNULL(COALESCE (a.cash,b.cash,c.cash),0)) END)+0 as cash_plus,
            sum(CASE WHEN COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN FLOOR(IFNULL(COALESCE (a.ATM,b.ATM,c.ATM),0)) END)+0 as ATM_plus,
            sum(CASE WHEN COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 2 THEN FLOOR(IFNULL(COALESCE (a.bank,b.bank,c.bank),0)) END)+0 as bank_minus,
            sum(CASE WHEN COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 2 THEN FLOOR(IFNULL(COALESCE (a.cash,b.cash,c.cash),0)) END)+0 as cash_minus
            "))
                ->leftJoin('drivers', 'drivers_saned_settlement.AMP_ID', '=', 'drivers.job_id')
                ->leftJoin('drivers_jahiz_clearing AS a', function ($join) {
                    $join->on('a.id', '=', 'drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->whereNotNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id');
                })
                ->leftJoin('drivers_jahiz_clearing AS b', function ($join) {
                    $join->on('b.driverId', '=', 'drivers.id')
                        ->whereNull('a.id')
                        ->whereNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->on('b.updated_at', '=', DB::raw('
                        (
                            select min(updated_at)
                            from drivers_jahiz_clearing
                            where drivers_jahiz_clearing.driverId=drivers.id
                            AND drivers_jahiz_clearing.updated_at >=drivers_saned_settlement.SettledDate
                            AND drivers_jahiz_clearing.paid_id IS NULL
                            AND  drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit=
	                        CASE
                                WHEN Jahiz_Amount_Sign = 1 THEN
                                Jahiz_Amount
                                WHEN Jahiz_Amount_Sign = 2 THEN
                                Jahiz_Amount *- 1
                            END
                        )'));
                })
                ->leftJoin('drivers_jahiz_clearing AS c', function ($join) {
                    $join->on('c.driverId', '=', 'drivers.id')
                        ->whereNull('a.id')
                        ->whereNull('b.id')
                        ->whereNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->whereRaw('CASE
                           WHEN c.Jahiz_Amount_Sign = 1 THEN
                              c.Jahiz_Amount
                           WHEN c.Jahiz_Amount_Sign = 2 THEN
                              c.Jahiz_Amount *- 1
                           END
                        not in(select drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit from drivers_saned_settlement
                        where drivers_saned_settlement.AMP_ID=drivers.job_id
                        AND c.updated_at >= drivers_saned_settlement.SettledDate
                        AND drivers_jahiz_clearing_paid_id is null)')
                        ->on('c.updated_at', '=', DB::raw('
                        (
                            select min(updated_at)
                            from drivers_jahiz_clearing
                            where drivers_jahiz_clearing.driverId=drivers.id
                            AND drivers_jahiz_clearing.updated_at >=drivers_saned_settlement.SettledDate
                            AND drivers_jahiz_clearing.paid_id IS NULL
                            AND  drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit<>
	                        CASE
                                WHEN Jahiz_Amount_Sign = 1 THEN
                                Jahiz_Amount
                                WHEN Jahiz_Amount_Sign = 2 THEN
                                Jahiz_Amount *- 1
                            END
                        )'));
                })
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_driver_type', DB::raw("COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id )"), '=', 'lkp_driver_type.id');


            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege  inner join warehouse on warehouse.id=users_privilege.warehouseId
                               where companyId=6 AND user_id=' . Auth::user()->id);
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
                $Select_db->whereRaw("UPPER(AMP_ID) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
                $Select_sum->whereRaw("UPPER(AMP_ID) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->whereRaw('drivers.id=' . $request->filter_driverId);
                $Select_sum->whereRaw('drivers.id=' . $request->filter_driverId);
            }

            if (!empty($request->filter_clearing_type_id)) {
                $Select_db->whereRaw('(COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id)=' . $request->filter_clearing_type_id . ' or COALESCE ( a.id,b.id,c.id ) is null) ');
                $Select_sum->whereRaw('(COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id)=' . $request->filter_clearing_type_id . ' or COALESCE ( a.id,b.id,c.id ) is null) ');

            }
            if (!empty($request->filter_bank)) {
                $Select_db->whereRaw("(COALESCE (a.bank,b.bank,c.bank) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
                $Select_sum->whereRaw("(COALESCE (a.bank,b.bank,c.bank) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
            }
            if (!empty($request->filter_cash)) {
                $Select_db->whereRaw("(COALESCE (a.cash,b.cash) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
                $Select_sum->whereRaw("(COALESCE (a.cash,b.cash) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
            }
            if (!empty($request->filter_driver_type_id)) {
                $Select_db->whereRaw("COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id )=".$request->filter_driver_type_id);
                $Select_sum->whereRaw("COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id )=".$request->filter_driver_type_id);
            }
            if (!empty($request->filter_ATM)) {
                $Select_db->whereRaw("(COALESCE (a.ATM,b.ATM,c.ATM) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
                $Select_sum->whereRaw("(COALESCE (a.ATM,b.ATM,c.ATM) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
            }
            if ($request->filter_paid_id <> "") {
                if ($request->filter_paid_id == "1") {
                    $Select_db->whereRaw("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is not null ");
                    $Select_sum->whereRaw("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is not null ");
                }
                if ($request->filter_paid_id == "2") {
                    $Select_db->whereRaw("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is  null ");
                    $Select_sum->whereRaw("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is  null ");
                }
            }
            if ($request->filter_Equal <> "") {
                if ($request->filter_Equal == "1") {
                    $Select_db->whereRaw("drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit=CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END ");
                    $Select_sum->whereRaw("drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit=CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END ");
                }
                if ($request->filter_Equal == "2") {
                    $Select_db->whereRaw("drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit<>ifnull(CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END,0) ");
                    $Select_sum->whereRaw("drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit<>ifnull(CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END,0) ");
                }
            }
            if (!empty($request->filter_SettledDate)) {
                $filter_SettledDate = explode(" - ", $request->filter_SettledDate);
                $Select_db->whereRaw("CAST(drivers_saned_settlement.SettledDate as date) between STR_TO_DATE('$filter_SettledDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_SettledDate[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(drivers_saned_settlement.SettledDate as date) between STR_TO_DATE('$filter_SettledDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_SettledDate[1]','%d/%m/%Y')");
            }

            $Select_db->whereRaw("CAST(drivers_saned_settlement.SettledDate as date) >= STR_TO_DATE('01/10/2021','%d/%m/%Y')");
            $Select_sum->whereRaw("CAST(drivers_saned_settlement.SettledDate as date) >= STR_TO_DATE('01/10/2021','%d/%m/%Y')");
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
                ->with('SANED_amount', '<b>' . $Select_sum->SANED_amount . '</b>')
                ->with('Jahiz_Amount', '<b>' . $Select_sum->Jahiz_Amount . '</b>')
                ->with('Bander_Commission', '<b>' . $Select_sum->Bander_Commission . '</b>')
                ->with('bank_plus', '<b>' . $Select_sum->bank_plus . '</b>')
                ->with('cash_plus', '<b>' . $Select_sum->cash_plus . '</b>')
                ->with('ATM_plus', '<b>' . $Select_sum->ATM_plus . '</b>')
                ->with('bank_minus', '<b>' . $Select_sum->bank_minus . '</b>')
                ->with('cash_minus', '<b>' . $Select_sum->cash_minus . '</b>')
                ->with('NoOfDispatch', '<b>' . $Select_sum->NoOfDispatch . '</b>')
                ->with('SQL', $Select_db->toSql())
                ->filterColumn('SANED_amount', function ($query, $keyword) {
                    $keywords = trim($keyword);
                    $query->whereRaw("drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit like ?", ["%{$keywords}%"]);
                })
                ->filterColumn('Jahiz_Amount', function ($query, $keyword) {
                    $keywords = trim($keyword);
                    $query->whereRaw("CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END like ?", ["%{$keywords}%"]);
                })
                ->make(true);

            //return $Select_db->toSql();
            //return datatables()->of($Select_db)->make(true);
        }

        //$data = $Select_db->get();

        return view('DriversSANEDClearing.index')
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

        $DriversSANEDClearing = DB::table('drivers_jahiz_clearing')
            ->select('DriversSANEDClearing.id as id', 'driverId', 'fullName', 'fullName_ar', 'DriversSANEDClearing_date',
                'amount', 'note', 'DriversSANEDClearing.status_id as status_id', 'DriversSANEDClearing_status',
                'updatedby_id', 'name', 'updated_usertypeid', 'user_type',
                'DriversSANEDClearing.created_at as created_at', 'DriversSANEDClearing.updated_at as updated_at')
            ->leftJoin('drivers', 'DriversSANEDClearing.driverId', '=', 'drivers.id')
            ->leftJoin('lkp_DriversSANEDClearing_status', 'DriversSANEDClearing.status_id', '=', 'lkp_DriversSANEDClearing_status.id')
            ->leftJoin('users', 'DriversSANEDClearing.updatedby_id', '=', 'users.id')
            ->leftJoin('lkp_updated_usertype', 'DriversSANEDClearing.updated_usertypeid', '=', 'lkp_updated_usertype.id')
            ->where('DriversSANEDClearing.id', $id)
            ->first();

        return view('DriversSANEDClearing.show')->with('drivers_jahiz_clearing', $DriversSANEDClearing);
    }

    public function DriversSANEDClearingPost(Request $request)
    {

        $date = date("Y-m-d H:i:s");
        for ($i = 0; $i < 1000; $i++) {
            if (!empty($request->input('ID_' . $i))) {
                //$IDs .= $request->input('ID_' . $i) . ",";

                try {
                    DB::update(" UPDATE drivers_saned_settlement
                    SET drivers_jahiz_clearing_paid_id = " . $request->input('drivers_jahiz_clearing_id_' . $i) . ",
                        paid_dt='" . $date . "',
                        paid_by_id=" . Auth::user()->id . "
                    where id =" . $request->input('ID_' . $i));


                    DB::update(" UPDATE drivers_jahiz_clearing
                    SET paid_id = " . $request->input('ID_' . $i) . ",
                        paid_dt='" . $date . "',
                        paid_by_id=" . Auth::user()->id . "
                    where id =" . $request->input('drivers_jahiz_clearing_id_' . $i));

                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect('/DriversSANEDClearing')->with('error', $e->getPrevious()->getMessage());
                }

            }
        }

        //return  $UPDATE;


        return redirect('/DriversSANEDClearing')->with('success', 'Done successfully');

    }
}
