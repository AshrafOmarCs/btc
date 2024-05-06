<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Warehouse extends Model
{
    protected $table = "warehouse";
    public $timestamps = false;
    protected $fillable = [
        'warehouseName', 'companyId', 'cityId',
        'Saturday', 'Sunday', 'Monday', 'Tuesday',
        'Wednesday', 'Thursday', 'Friday',
        'created_at', 'updated_at'
    ];
     
    public function company(){
        return $this->belongsTo('App\lkp_company','companyId','id');
    }

    protected $hidden = ['created_at', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'latitude', 'longitude', 'updated_at'];

    public static function getWarehouseDriverAttendence($warehouseId=null)
    {
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouseId in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouseId in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }

        $where='';
        if (!empty($warehouseId))
            $where="AND drivers.warehouseId=".$warehouseId;

        $drivers = $drivers = DB::select("SELECT drivers.id as id,fullName,fullName_ar,mobileNumber,iqama,job_id,driver_status_en,status_id
                        FROM drivers
                        left Join warehouse on drivers.warehouseId=warehouse.id
                        left Join lkp_driver_status on drivers.status_id=lkp_driver_status.id
                        WHERE EXISTS
                    (SELECT 1 FROM packages_report
                      WHERE packages_report.driverId = drivers.id
                    AND packages_report.pakage_date = CURRENT_DATE())
                    ".$where."
                   AND drivers.status_id = 1
                    $AND
                   order by fullName");
        return $drivers;
    }

    public static function getCompanyDriverAttendence($warehouseList=null)
    {

        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouseId in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouseId in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }

        $where='';
        if (!empty($warehouseId))
            $where="AND drivers.warehouseId=".$warehouseId;
        $warehouseList=json_encode($warehouseList);
        $drivers = $drivers = DB::select("SELECT drivers.id as id,fullName,fullName_ar,mobileNumber,iqama,job_id,driver_status_en,status_id
                        FROM drivers
                        left Join warehouse on drivers.warehouseId=warehouse.id
                        left Join lkp_driver_status on drivers.status_id=lkp_driver_status.id
                        WHERE EXISTS
                    (SELECT 1 FROM packages_report
                      WHERE packages_report.driverId = drivers.id
                    AND packages_report.pakage_date = CURRENT_DATE())
                    AND FIND_IN_SET(drivers.warehouseId ,$warehouseList) > 0
                   AND drivers.status_id = 1
$AND
                   order by fullName");
        return $drivers;
    }

    public static function getAbsentDrivers($warehouseId=null)
    {
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouseId in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouseId in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }

        $where='';
        if (!empty($warehouseId))
            $where="AND drivers.warehouseId=".$warehouseId;
        $drivers = DB::select("SELECT drivers.id as id,fullName,fullName_ar,mobileNumber,iqama,job_id,driver_status_en,status_id
                        FROM drivers
                        left Join warehouse on drivers.warehouseId=warehouse.id
                        left Join lkp_driver_status on drivers.status_id=lkp_driver_status.id
                        WHERE NOT EXISTS
                    (SELECT 1 FROM packages_report
                      WHERE packages_report.driverId = drivers.id
                    AND packages_report.pakage_date = CURRENT_DATE())
                   ".$where."
                   AND drivers.status_id = 1
                   $AND
                   order by fullName");
        return $drivers;
    }

    public static function  getAllDrivers($warehouseId=null)
    {
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouseId in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouseId in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }

        if (!empty($warehouseId))
        {
            $drivers = Drivers::select('drivers.id as id', 'fullName', 'mobileNumber', 'iqama', 'job_id', 'driver_status_en', 'status_id')
                ->Join('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->Join('lkp_driver_status', 'drivers.status_id', '=', 'lkp_driver_status.id')
                ->where('warehouseId', $warehouseId)
                ->where('drivers.status_id', "1");
            if (Auth::user()->user_type_id <> 1)
                $drivers->whereIn('warehouseId', $whereIn_array);
           // $drivers->get();
        }
        else
        {
            $drivers = Drivers::select('drivers.id as id', 'fullName', 'mobileNumber', 'iqama', 'job_id', 'driver_status_en', 'status_id')
                ->Join('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->Join('lkp_driver_status', 'drivers.status_id', '=', 'lkp_driver_status.id')
                ->where('drivers.status_id', "1");
            if (Auth::user()->user_type_id <> 1)
                $drivers->whereIn('warehouseId', $whereIn_array);
            //$drivers->get();
        }


        return $drivers->get();
    }

    public static function driversHaveNoLoad($warehouseId=null)
    {

        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouseId in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouseId in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }

        $where='';
        if (!empty($warehouseId))
            $where="AND drivers.warehouseId=".$warehouseId;
        $drivers = DB::select("SELECT drivers.id as id,fullName,fullName_ar,mobileNumber,iqama,job_id,driver_status_en,status_id
                               FROM drivers
                               left Join warehouse on drivers.warehouseId=warehouse.id
                               left Join lkp_driver_status on drivers.status_id=lkp_driver_status.id
                               WHERE EXISTS
                                 (SELECT 1 FROM packages_report
                                  WHERE packages_report.driverId = drivers.id
                                  AND packages_report.pakage_date = CURRENT_DATE()
                                  AND packages_report.total_out_for_deliver=0
                                 )
                               ".$where."
                               AND drivers.status_id = 1
                               $AND
                               order by fullName");
        return $drivers;
    }
}

