<?php

namespace App\Http\Controllers;

use App\UsersMenu;
use App\WarehouseDrivers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class WarehouseDriversController extends Controller
{
    protected $menu = 14;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id, $name, Request $request)
    {
        $dt = $request->dt;

        $UsersMenu = DB::table('drivers')
            ->select('drivers.id as id', 'fullName', 'fullName_ar', 'job_id',
                'total_out_for_deliver', 'total_no_touchpoint',
                'no_of_deliverd', 'no_of_touch_point', 'attendence', 'packageStatusId', 'approveStatusId', 'load_time'
            )
            ->leftJoin(DB::raw("(SELECT packages_report.driverId,total_out_for_deliver,total_no_touchpoint,
            no_of_deliverd,no_of_touch_point,attendence,packageStatusId,approveStatusId,
            TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt) as load_time
            FROM packages_report
            inner join drivers on drivers.id=packages_report.driverId
            where drivers.warehouseId=" . $id . "
            and packages_report.pakage_date='" . $dt . "'
            )packages"),
                function ($join) {
                    $join->on('drivers.id', '=', 'packages.driverId');
                })
            ->where('drivers.warehouseId', $id)
            ->whereIn('drivers.status_id', ['1', '2'])
            ->orderBy('fullName', 'ASC')
            ->get();
        $dt = $request->dt;
        return view('new_porttal.Warehouses.warehouseDrivers')->with(compact('UsersMenu'))->with(compact('id'))->with(compact('name'))->with(compact('dt'));
    }

    public function store(Request $request)
    {
        $date = \DateTime::createFromFormat('d/m/Y', $request->input("dt"))->format('Y-m-d');


        $dayname = \DateTime::createFromFormat('d/m/Y', $request->input("dt"))->format('l');
        $day = DB::select("SELECT " . $dayname . " as dayunitcost from  warehouse
        where id=" . $request->input("warehouseId"))[0];

        $UsersMenu = DB::select("select * from drivers where warehouseId=" . $request->input("warehouseId") . " and status_id in(1,2)");
        foreach ($UsersMenu as $User_Menu) {

            if (!empty($request->input("attendence_$User_Menu->id"))) $attendence = 1; else $attendence = 0;
            if (!empty($request->input("packageStatusId_$User_Menu->id"))) $packageStatusId = 2; else $packageStatusId = 1;

            if ($request->input("attendence_$User_Menu->id")) {

                if (empty($request->input("total_out_for_deliver_$User_Menu->id"))) $total_out_for_deliver = 0;
                else $total_out_for_deliver = $request->input("total_out_for_deliver_$User_Menu->id");


                if (empty($request->input("total_no_touchpoint_$User_Menu->id"))) $total_no_touchpoint = 0;
                else $total_no_touchpoint = $request->input("total_no_touchpoint_$User_Menu->id");

                if (empty($request->input("no_of_deliverd_$User_Menu->id"))) $no_of_deliverd = 0;
                else $no_of_deliverd = $request->input("no_of_deliverd_$User_Menu->id");

                if (empty($request->input("no_of_touch_point_$User_Menu->id"))) $no_of_touch_point = 0;
                else $no_of_touch_point = $request->input("no_of_touch_point_$User_Menu->id");


                try {

                    DB::insert("INSERT INTO packages_report (driverId,total_out_for_deliver,total_no_touchpoint,
                    no_of_deliverd,no_of_touch_point,attendence,pakage_date,packageStatusId,unit_cost,updatedby_id,updated_usertypeid,
                    created_at,updated_at)
                    VALUES (" . $User_Menu->id . ",
                    " . $total_out_for_deliver . ",
                    " . $total_no_touchpoint . ",
                    " . $no_of_deliverd . ",
                    " . $no_of_touch_point . ",
                    " . $attendence . ",
                    '" . $date . "',
                    " . $packageStatusId . ",
                    " . $day->dayunitcost . ",
                    " . Auth::user()->id . ",
                    " . Auth::user()->user_type_id . ",
                    '" . date("Y-m-d H:i:s") . "',
                    '" . date("Y-m-d H:i:s") . "'
                    )ON DUPLICATE KEY UPDATE
                    total_out_for_deliver=" . $total_out_for_deliver . ",
                    total_no_touchpoint=" . $total_no_touchpoint . ",
                    no_of_deliverd=" . $no_of_deliverd . ",
                    no_of_touch_point=" . $no_of_touch_point . ",
                    attendence=" . $attendence . ",
                    packageStatusId=" . $packageStatusId . ",
                    unit_cost=" . $day->dayunitcost . ",
                    updatedby_id=" . Auth::user()->id . ",
                    updated_usertypeid=" . Auth::user()->user_type_id . ",
                    updated_at='" . date("Y-m-d H:i:s") . "'
                    ");
                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect('/CreditNotes')->with('error', $e->getPrevious()->getMessage());
                }
            }
            DB::insert("update packages_report set attendence=" . $attendence . " where driverId=" . $User_Menu->id . "
                and pakage_date='" . $date . "'");
        }

        return redirect('/Warehouses')->with('success', 'Done successfully');


    }

}
