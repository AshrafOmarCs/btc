<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCityName($companyId)
    {

        $Select_db = DB::select("SELECT cityId as id,name_en as name from warehouse
        inner join lkp_city on lkp_city.id=warehouse.cityId
        where companyId=" . $companyId . "
        GROUP BY cityId,name_en
        order by name_en");
        return response()->json($Select_db, 200);
    }

    public function getWarehouse($cityId)
    {
        $Select_db = DB::select("SELECT id,warehouseName as name from warehouse
        where cityId=" . $cityId . " order by warehouseName");
        return response()->json($Select_db, 200);
    }
    public function getWarehouseByCompany($companyId)
    {
        $Select_db = DB::select("SELECT id,warehouseName as name from warehouse
        where companyId=" . $companyId . " order by warehouseName");
        return response()->json($Select_db, 200);
    }
    public function getWarehouseByCityCompany($cityId, $companyId)
    {
        $Select_db = DB::select("SELECT id,warehouseName as name from warehouse
        where cityId=" . $cityId . " AND companyId=" . $companyId . " order by warehouseName");
        return response()->json($Select_db, 200);
    }

    public function getWarehouseName($companyId)
    {
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = \Illuminate\Support\Facades\DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouse.id in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouse.id in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }

        $Select_db = DB::select("SELECT id,warehouseName as name from warehouse
        where companyId=" . $companyId . " $AND order by warehouseName");
        return response()->json($Select_db, 200);
    }
    public function getMultipleWarehouseName($companyId)
    {
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = \Illuminate\Support\Facades\DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouse.id in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouse.id in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }

        $Select_db = DB::select("SELECT id,warehouseName as name from warehouse
        where companyId in (" . $companyId . ") $AND order by warehouseName");
        return response()->json($Select_db, 200);
    }

    public function getPeriod($companyId)
    {

        $Select_db = DB::select("select journal_period as id,journal_period as name from(

            select journal_period FROM
            (
            select if (period_start<>1,
                            CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                            ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                            CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                            ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                             as journal_period
                from journal
                    inner join drivers on drivers.id=journal.driverId
                inner join warehouse on warehouse.id=drivers.warehouseId
                inner join lkp_company on lkp_company.id=warehouse.companyId
                where companyId=" . $companyId . ")a
            GROUP BY journal_period
            order by journal_period desc)n
            ");
        //where SUBSTRING(journal_period, 14, 10)<'" . date('Y-m-d') . "'
        return response()->json($Select_db, 200);
    }
    //***********************************************************************************************************************
    //********************************************************************************************************************
    public function getDriversJahizMontly($driverId, $jahiz_period_id)
    {

        $Select_db = DB::select("
                select
                max(week1) as week1,max(week1_dt) as week1_dt,
                max(week2) as week2,max(week2_dt) as week2_dt,
                max(week3) as week3,max(week3_dt) as week3_dt,
                max(week4) as week4,max(week4_dt) as week4_dt,
                max(weekAll) as weekAll,max(weekAll_dt) as weekAll_dt,
                max(amount_by_days) as amount_by_days,max(amount_by_days_dt) as amount_by_days_dt
                from(
                select
                CASE
                    WHEN week1 is not null THEN week1
                    ELSE null
                END week1,
                 CASE
                    WHEN week1 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week1_dt,
                CASE
                    WHEN week2 is not null THEN week2
                    ELSE null
                END week2,
                 CASE
                    WHEN week2 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week2_dt,
                CASE
                    WHEN week3 is not null THEN week3
                    ELSE null
                END week3,
                 CASE
                    WHEN week3 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week3_dt,
                CASE
                    WHEN week4 is not null THEN week4
                    ELSE null
                END week4,
                 CASE
                    WHEN week4 is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END week4_dt,
                CASE
                    WHEN weekAll is not null THEN weekAll
                    ELSE null
                END weekAll,
                 CASE
                    WHEN weekAll is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END weekAll_dt,
                 CASE
                    WHEN amount_by_days is not null THEN amount_by_days
                    ELSE null
                END amount_by_days,
                 CASE
                    WHEN amount_by_days is not null THEN DATE_FORMAT(updated_at, '%Y-%m-%d')
                    ELSE null
                END amount_by_days_dt


        from drivers_jahiz_montly
        where driverId=" . $driverId . "
        and jahiz_period_id=" . $jahiz_period_id . ")aa");


        return response()->json($Select_db, 200);
    }

//***********************************************************************************************************************
//********************************************************************************************************************
    public function getDays($Year, $month)
    {

        $cal_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $Year);

        $Days = array();
        for ($i = 1; $i <= $cal_days_in_month; $i++) {
            $Days[] = $i;
        }

        return response()->json($Days, 200);
    }
}
