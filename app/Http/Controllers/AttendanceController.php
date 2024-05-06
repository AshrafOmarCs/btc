<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AttendanceController extends Controller
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
     * @throws \Exception
     */
    public function index(Request $request)
    {
        DB::statement('SET SESSION group_concat_max_len = 5555555');
        if (empty($request->filter_Year)) {
            $Year = date('Y');
        } else {
            $Year = $request->filter_Year;
        }
        if (empty($request->filter_Month)) {
            $Month = date('n');
        } else {
            $Month = $request->filter_Month;
        }
        $d = new \DateTime($Year . '-' . $Month . '-23');
        $Last_Day = $d->format('t');
        if ($Year == date('Y') && $Month == date('n'))
            $Last_Day = date('d');
        $query = "SELECT
     users.id AS id,
     users.name AS name,
     IdentityNo,
     phone,
     email,
     user_type_id,
     lkp_user_type.user_type AS user_type_name,
     users.active_id,
     active_status,";
        for ($i = 1; $i <= 31; $i++)
            $query .= "A_$i,";
        $query .= " GROUP_CONCAT(
          CONCAT(
              warehouseName
          ) SEPARATOR ', '
     ) AS warehouses
FROM
     users
LEFT JOIN lkp_user_type ON users.user_type_id = lkp_user_type.id
LEFT JOIN lkp_active ON users.active_id = lkp_active.id
LEFT JOIN users_privilege ON users_privilege.user_id = users.id
LEFT JOIN lkp_privilege_type ON lkp_privilege_type.id = users_privilege.privilage_type_id
LEFT JOIN warehouse ON warehouse.id = users_privilege.warehouseId
LEFT JOIN
(
select ";
        for ($i = 1; $i <= 31; $i++)
            $query .= "MAX(if( DT = $i, MIN_DT, null )) AS A_$i,";
        $query .= "
userId
from
(SELECT userId,DATE_FORMAT(attendance_supervisors.created_at, '%d') AS DT, DATE_FORMAT(min(attendance_supervisors.created_at), '%H:%i') AS MIN_DT
FROM attendance_supervisors
Where attendance_supervisors.action_id = 1
AND attendance_supervisors.created_at between '$Year-$Month-01 00:00:01' and '$Year-$Month-31 23:59:59'
group by userId, DATE_FORMAT(attendance_supervisors.created_at, '%d')
)a
group by userId
)temp ON temp.userId=users.id
where user_type_id IN(2,3)
and users.active_id=1
GROUP BY
     users.id,
     users.name,
     IdentityNo,
     phone,
     email,
     user_type_id,
     lkp_user_type.user_type,
     users.active_id,
     active_status
order by users.name";

        //return $query;
        $Select_db = DB::select($query);
        if (request()->ajax()) {
            return datatables()->of($Select_db)
                ->with('year_month', '<b><font color="red">' . $Year . '-' . $Month . '</font></b>')
                ->with('Last_Day', $Last_Day)
                ->make(true);
        }
        return view('Attendance.index');
    }

    //****************************************************************************************************************
    //****************************************************************************************************************
    public function AttendanceDrivers(Request $request)
    {

        if (empty($request->filter_Year)) {
            $Year = date('Y');
        } else {
            $Year = $request->filter_Year;
        }
        if (empty($request->filter_Month)) {
            $Month = date('n');
        } else {
            $Month = $request->filter_Month;
        }
        $d = new \DateTime($Year . '-' . $Month . '-23');
        $Last_Day = $d->format('t');
        if ($Year == date('Y') && $Month == date('n'))
            $Last_Day = date('d');

        $where = '';
        $whereIn_array = array();
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
            INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
            where companyId=8 AND user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;

            $where .= ' AND warehouseId in(' . implode(",", $whereIn_array) . ') ';
            $wher = ' where warehouse.id in(' . implode(",", $whereIn_array) . ') ';
        } else {
            if (!empty($request->filter_warehouseId)) {
                $where .= ' AND warehouseId=' . $request->filter_warehouseId . ' ';
            }
            $wher = ' where companyId=8 ';
        }

        if (!empty($request->filter_status_id)) {
            if($request->filter_status_id=='1')
            $where .= ' AND status_id=1 ';
            else if($request->filter_status_id=='2')
                $where .= ' AND status_id<>1 ';
        }

        if (!empty($request->filter_bander_car_id)) {
            $where .= ' AND bander_car_id=' . $request->filter_bander_car_id . ' ';
        }

        $warehouse = DB::select('SELECT * from warehouse ' . $wher . ' order by warehouseName ');


        $query = "SELECT
        warehouseName,";
        for ($i = 1; $i <= 31; $i++)
            $query .= "A_$i,";
        $query .= " fullName,status_id,bander_car_id
            FROM
               drivers
            INNER JOIN warehouse on warehouse.id=drivers.warehouseId


            LEFT JOIN (
               SELECT ";
        for ($i = 1; $i <= 31; $i++)
            $query .= "MAX(if( DT = $i, MIN_DT, null )) AS A_$i,";
        $query .= "
        driverId
        FROM
         (
         SELECT
            driverId,
            DATE_FORMAT(created_at, '%d') AS DT,
            DATE_FORMAT(min(created_at), '%H:%i') AS MIN_DT
         FROM
            attendance_drivers
         WHERE
           action_id = 1
         AND created_at BETWEEN '$Year-$Month-01 00:00:01' and '$Year-$Month-31 23:59:59'
            GROUP BY
                        driverId,
                        DATE_FORMAT(created_at, '%d')
                  ) a
               GROUP BY
                  driverId
            ) temp ON temp.driverId = drivers.id
            where companyId=8
            " . $where . "
            ORDER BY warehouseName";

        //return $query;
        $Select_db = DB::select($query);
        if (request()->ajax()) {
            return datatables()->of($Select_db)
                ->with('year_month', '<b><font color="red">' . $Year . '-' . $Month . '</font></b>')
                ->with('Last_Day', $Last_Day)
                ->with('filter_Day', $request->filter_Day)
                ->make(true);
        }
        return view('Attendance.AttendanceDrivers')->with('warehouse', $warehouse);
    }
//*****************************************************************************************************************
//*****************************************************************************************************************

}
