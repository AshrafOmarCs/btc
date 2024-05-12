<?php

namespace App\Http\Controllers;

use App\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $whereIn_array = array();
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where warehouseId in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND warehouseId in(" . implode(",", $whereIn_array) . ")";
            $total_veh_vlause = "INNER JOIN drivers ON vehicles.id=drivers.vehicle_id $wher";

        } else {
            $wher = "";
            $AND = "";
            $total_veh_vlause = "";
        }
        $today = date("Y-m-d");
        $delegatedTotalAttendanceVehicles = DB::select("SELECT id FROM `vehicles` WHERE `current_status` = 'delegeted' AND `maintenance_status` IS NULL");
        $delegatedTotalAttendanceVehicles = count($delegatedTotalAttendanceVehicles);
        
        $delegatedAttendanceVehicles = DB::select("SELECT vehicles.id FROM vehicles INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON drivers.vehicle_id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id WHERE vehicles.maintenance_status IS NULL AND drivers_attendance.date='$today' $AND");
        $delegatedAttendanceVehicles = count($delegatedAttendanceVehicles);
        
        // $delegatedNoAttendanceVehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id WHERE vehicles.maintenance_status is null $AND AND vehicles.id NOT IN (SELECT vehicle_id FROM drivers_attendance WHERE date = '$today')");
        // $delegatedNoAttendanceVehicles = count($delegatedNoAttendanceVehicles);
        $delegatedNoAttendanceVehicles =$delegatedTotalAttendanceVehicles - $delegatedAttendanceVehicles;

        $delegatedAttendanceExcuseVehicles = DB::select("SELECT vehicles.id FROM vehicles INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON drivers.vehicle_id=drivers_attendance.vehicle_id WHERE drivers_attendance.`status`='absent with excuse' AND drivers_attendance.date = '$today' $AND");
        $delegatedAttendanceExcuseVehicles = count($delegatedAttendanceExcuseVehicles);
        $delegatedAttendanceNoExcuseVehicles = DB::select("SELECT vehicles.id FROM vehicles INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON drivers.vehicle_id=drivers_attendance.vehicle_id WHERE drivers_attendance.`status`='absent with no excuse' AND drivers_attendance.date = '$today' $AND");
        $delegatedAttendanceNoExcuseVehicles = count($delegatedAttendanceNoExcuseVehicles);
        
        $maintenanceVehicles = DB::select("SELECT vehicles.id FROM vehicles INNER JOIN drivers ON vehicles.id=drivers.vehicle_id WHERE vehicles.maintenance_status IS NOT NULL $AND");
        $maintenanceVehicles = count($maintenanceVehicles);
        $totalUsers = DB::select("SELECT (SELECT COUNT(*) FROM drivers $wher ) as totalDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=4 $AND) as totalResignedDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=1  $AND) as totalActiveDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=5  $AND) as totalOnHoldDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=3  $AND) as totalTerminatedDrivers,
                                        (SELECT COUNT(*) FROM vehicles $total_veh_vlause) as totalVehicles,
                                        (SELECT COUNT(*) FROM vehicles WHERE current_status = 'availabe' AND vehicle_opreater_id <> 5) as totalVehiclesAvailable,
                                        (SELECT COUNT(*) FROM vehicles WHERE vehicle_opreater_id = 5) as totalVehiclesRented,
                                        (SELECT COUNT(*) FROM vehicles WHERE current_status = 'damaged') as damgedVehicles,
                                        (SELECT COUNT(*) FROM vehicles WHERE (maintenance_status is not null OR current_status = 'maintenance')) as maintenanceVehicles,
                                        (SELECT COUNT(*) FROM users where user_type_id=3) as totalSupervisors,
                                        (SELECT COUNT(*) FROM users where user_type_id=2) as totalAreaManagers,
                                        (SELECT COUNT(*) FROM users where user_type_id=1) as totalAdmins,
                                        (SELECT COUNT(*) FROM users where (user_type_id=2) AND (active_id=1)) as totalActiveAreaManagers,
                                        (SELECT COUNT(*) FROM users where (user_type_id=2) AND (active_id=0)) as totalUnActiveAreaManagers,
                                        (SELECT COUNT(*) FROM users where (user_type_id=3) AND (active_id=1)) as totalActiveSupervisors,
                                        (SELECT COUNT(*) FROM users where (user_type_id=3) AND (active_id=0)) as totalUnActiveSupervisors");


        $presentDrivers = Warehouse::getWarehouseDriverAttendence();
        $absentDrivers = Warehouse::getAbsentDrivers();
        $allDrivers = Warehouse::getAllDrivers();
        $driversNoLoad = Warehouse::driversHaveNoLoad();
        $presentLoadedDrivers = sizeof($presentDrivers) - sizeof($driversNoLoad);

        $drivers = [
            'totalDrivers' => sizeof($allDrivers),
            'presentDrivers' => sizeof($presentDrivers),
            'presentLoadedDrivers' => $presentLoadedDrivers,
            'driversHaveNoLoad' => sizeof($driversNoLoad),
            'absentDrivers' => sizeof($absentDrivers)
        ];
        $lkp_company = DB::select('SELECT * from lkp_company WHERE lkp_company.status = "active"');
        $app_version = DB::table('app_version')->first();
        //dd($totalUsers[0]->totalDrivers);
        return view('home', compact('totalUsers', 'drivers', 'lkp_company', 'app_version', 'delegatedAttendanceVehicles', 'delegatedNoAttendanceVehicles', 'delegatedAttendanceExcuseVehicles', 'delegatedAttendanceNoExcuseVehicles', 'maintenanceVehicles'));
    }
    
    public function vehicles_info(Request $request){
        $today = date("Y-m-d");
        $type = $request->type;
        $title = $request->title;
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where drivers.warehouseId in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND drivers.warehouseId in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }
        if ($type == 'total') {
            $small = "The following vehicles are total vehicles with respect to city.";
            if (Auth::user()->user_type_id <> 1)
                $information = DB::select("SELECT lkp_city.id, lkp_city.name_en AS city_name,COUNT(vehicles.id) AS vehicle_count FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id $wher GROUP BY lkp_city.name_en");
            else
                $information = DB::select("SELECT lkp_city.id, lkp_city.name_en AS city_name,COUNT(vehicles.id) AS vehicle_count FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id GROUP BY lkp_city.name_en");
        } else if ($type == 'available') {
            $small = "The following vehicles are available/idol vehicles with respect to city.";
            $information = DB::select("SELECT vehicles.current_status, lkp_city.id, lkp_city.name_en AS city_name,COUNT(vehicles.id) AS vehicle_count FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'availabe' AND vehicle_opreater_id <> 5 $AND GROUP BY lkp_city.name_en");
            
        }  else if ($type == 'rented') {
            $small = "The following vehicles are Rentel vehicles with respect to city.";
            $information = DB::select("SELECT vehicles.current_status, lkp_city.id, lkp_city.name_en AS city_name,COUNT(vehicles.id) AS vehicle_count FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicle_opreater_id = 5 $AND GROUP BY lkp_city.name_en");
            
        } else if ($type == 'done_attendance') {
            $small = "The following vehicles are done with attendance vehicles with respect to warehouse.";
            $information = DB::select("SELECT vehicles.current_status,lkp_city.id,lkp_city.name_en AS city_name,COUNT(DISTINCT vehicles.id) AS vehicle_count,warehouse.warehouseName,lkp_company.companyName,GROUP_CONCAT(DISTINCT users.`name`) AS user_names FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN users INNER JOIN users_privilege ON users.id=users_privilege.user_id AND warehouse.id=users_privilege.warehouseId WHERE drivers_attendance.date='$today' $AND AND users_privilege.user_id NOT IN (69,70,8) AND users.active_id=1 GROUP BY vehicles.current_status,lkp_city.id,lkp_city.name_en,warehouse.warehouseName,lkp_company.companyName");
            
        } else if ($type == 'pending_attendance') {
            $small = "The following vehicles are pending with attendance vehicles with respect to warehouse.";
            $information = DB::select("SELECT vehicles.current_status,lkp_city.id,lkp_city.name_en AS city_name,COUNT(DISTINCT vehicles.id) AS vehicle_count,warehouse.warehouseName,lkp_company.companyName, GROUP_CONCAT(DISTINCT users.`name`) AS user_names FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN users INNER JOIN users_privilege ON users.id=users_privilege.user_id AND warehouse.id=users_privilege.warehouseId WHERE vehicles.maintenance_status is null $AND AND vehicles.id NOT IN (SELECT vehicle_id FROM drivers_attendance WHERE date = '$today') AND users_privilege.user_id NOT IN (69,70,8) AND users.active_id=1 GROUP BY vehicles.current_status,lkp_city.id,lkp_city.name_en,warehouse.warehouseName,lkp_company.companyName");
            
        } else if ($type == 'present') {
            $small = "The following vehicles are present vehicles with respect to warehouse.";
            $information = DB::select("SELECT vehicles.current_status,lkp_city.id,lkp_city.name_en AS city_name,COUNT(DISTINCT vehicles.id) AS vehicle_count,warehouse.warehouseName,lkp_company.companyName, GROUP_CONCAT(DISTINCT users.`name`) AS user_names FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN users INNER JOIN users_privilege ON users.id=users_privilege.user_id AND warehouse.id=users_privilege.warehouseId WHERE drivers_attendance.date='$today' and drivers_attendance.`status` = 'present' $AND AND users_privilege.user_id NOT IN (69,70,8) AND users.active_id=1 GROUP BY vehicles.current_status,lkp_city.id,lkp_city.name_en,warehouse.warehouseName,lkp_company.companyName");
            
        } else if ($type == 'absent_ex') {
            $small = "The following vehicles are absent with excuse vehicles with respect to warehouse.";
            $information = DB::select("SELECT vehicles.current_status,lkp_city.id,lkp_city.name_en AS city_name,COUNT(DISTINCT vehicles.id) AS vehicle_count,warehouse.warehouseName,lkp_company.companyName, GROUP_CONCAT(DISTINCT users.`name`) AS user_names FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN users INNER JOIN users_privilege ON users.id=users_privilege.user_id AND warehouse.id=users_privilege.warehouseId WHERE drivers_attendance.date='$today' and drivers_attendance.`status` = 'absent with excuse' $AND AND users_privilege.user_id NOT IN (69,70,8) AND users.active_id=1 GROUP BY vehicles.current_status,lkp_city.id,lkp_city.name_en,warehouse.warehouseName,lkp_company.companyName");
            
        } else if ($type == 'absent_no_ex') {
            $small = "The following vehicles are absent with no any excuse vehicles with respect to warehouse.";
            $information = DB::select("SELECT vehicles.current_status,lkp_city.id,lkp_city.name_en AS city_name,COUNT(DISTINCT vehicles.id) AS vehicle_count,lkp_company.companyName, GROUP_CONCAT(DISTINCT users.`name`) AS user_names, warehouse.warehouseName FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN users INNER JOIN users_privilege ON users.id=users_privilege.user_id AND warehouse.id=users_privilege.warehouseId WHERE drivers_attendance.date='$today' and drivers_attendance.`status` = 'absent with no excuse' $AND AND users_privilege.user_id NOT IN (69,70,8) AND users.active_id=1 GROUP BY vehicles.current_status,lkp_city.id,lkp_city.name_en,warehouse.warehouseName,lkp_company.companyName");
            
        } else if ($type == 'maintenance') {
            $small = "The following vehicles are in maintenance and delegated - maintenance vehicles with respect to city.";
            $information = DB::select("SELECT vehicles.current_status, lkp_city.id, lkp_city.name_en AS city_name,COUNT(vehicles.id) AS vehicle_count FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'maintenance' OR vehicles.maintenance_status is not null GROUP BY lkp_city.name_en");
            
        } else if ($type == 'maintenance_') {
            $small = "The following vehicles are in maintenance and delegated - maintenance vehicles with respect to city.";
            $information = DB::select("SELECT vehicles.current_status, lkp_city.id, lkp_city.name_en AS city_name,COUNT(vehicles.id) AS vehicle_count FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id JOIN drivers ON vehicles.id=drivers.vehicle_id WHERE vehicles.maintenance_status is not null $AND GROUP BY lkp_city.name_en");
            
        } else if ($type == 'damaged') {
            $small = "The following vehicles are damaged vehicles with respect to city.";
            $information = DB::select("SELECT vehicles.current_status, lkp_city.id, lkp_city.name_en AS city_name,COUNT(vehicles.id) AS vehicle_count FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'damaged' $AND GROUP BY lkp_city.name_en");
            
        }
        // dd($information);
        return view('Home.vehicle_info', compact('information', 'type', 'title', 'small'));
    }

    public function getDailyRecords($warehouseId)
    {
        $presentDrivers = Warehouse::getWarehouseDriverAttendence($warehouseId);
        $absentDrivers = Warehouse::getAbsentDrivers($warehouseId);
        $allDrivers = Warehouse::getAllDrivers($warehouseId);
        $driversNoLoad = Warehouse::driversHaveNoLoad($warehouseId);
        $presentLoadedDrivers = sizeof($presentDrivers) - sizeof($driversNoLoad);

        $reports = [
            'totalDrivers' => sizeof($allDrivers),
            'presentDrivers' => sizeof($presentDrivers),
            'presentLoadedDrivers' => $presentLoadedDrivers,
            'driversHaveNoLoad' => sizeof($driversNoLoad),
            'absentDrivers' => sizeof($absentDrivers)
        ];
        return response()->json(['message' => 'success', 'reports' => $reports], 200);
    }

    public function getDailyCompanyRecords($companyId)
    {
        $warehouses = Warehouse::where('companyId', $companyId)->select('id')->get();
        $warehouseList = array();
        $i = 0;
        foreach ($warehouses as $warehouse) {
            $warehouseList[$i] = $warehouse->id;
            $i++;
        }

        $presentDrivers = Warehouse::getCompanyDriverAttendence($warehouseList);

        return response()->json(['message' => 'success', 'warehouseList' => $warehouseList], 200);

    }
}
