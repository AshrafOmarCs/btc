<?php

namespace App\Http\Controllers;

use App\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        } else {
            $wher = "";
            $AND = "";
        }
        $totalUsers = DB::select("SELECT (SELECT COUNT(*) FROM drivers $wher ) as totalDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=4 $AND) as totalResignedDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=1  $AND) as totalActiveDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=5  $AND) as totalOnHoldDrivers,
                                        (SELECT COUNT(*) FROM drivers where status_id=3  $AND) as totalTerminatedDrivers,
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
        $lkp_company = DB::select('SELECT * from lkp_company ');
        $app_version = DB::table('app_version')->first();
        //dd($totalUsers[0]->totalDrivers);
        return view('home', compact('totalUsers', 'drivers', 'lkp_company', 'app_version'));
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
