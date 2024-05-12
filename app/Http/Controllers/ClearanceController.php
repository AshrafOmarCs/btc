<?php

namespace App\Http\Controllers;

use App\Clearance;
use DB;
use Illuminate\Http\Request;

class ClearanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $lkp_company = DB::select("SELECT * from lkp_company WHERE status = 'active'");
        $warehouse = DB::select('SELECT * from warehouse order by warehouseName');

        $Select_db = DB::table('clearance')
            ->select(DB::raw("clearance.id as id, driverId,companyName,warehouseName,job_id, drivers.fullName as fullName, fullName_ar,
            clearance.iqama,balance,
            clearance.createdby_id,name,
                clearance.created_at as created_at"))
            ->leftJoin('drivers', 'clearance.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('users', 'clearance.createdby_id', '=', 'users.id');


        if (request()->ajax()) {
            if (!empty($request->filter_companyId)) {
                $Select_db->where('companyId', $request->filter_companyId);
            }
            if (!empty($request->filter_warehouseId)) {
                $Select_db->where('warehouseId', $request->filter_warehouseId);
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->where('clearance.driverId', $request->filter_driverId);
            }
            if (!empty($request->filter_iqama)) {
                $Select_db->where('iqama', $request->filter_iqama);
            }
            if (!empty($request->filter_balance)) {
                $Select_db->where('balance', $request->filter_balance);
            }


            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(clearance.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }

            return datatables()->of($Select_db)->make(true);
        }

        //$data = $Select_db->get();

        return view('Clearance.index')->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        $Clearance = DB::table('clearance')
            ->select('clearance.id as id', 'driverId', 'fullName', 'fullName_ar', 'clearance_date',
                'amount', 'note', 'clearance.status_id as status_id', 'clearance_status',
                'updatedby_id', 'name', 'updated_usertypeid', 'user_type',
                'clearance.created_at as created_at', 'clearance.updated_at as updated_at')
            ->leftJoin('drivers', 'clearance.driverId', '=', 'drivers.id')
            ->leftJoin('lkp_clearance_status', 'clearance.status_id', '=', 'lkp_clearance_status.id')
            ->leftJoin('users', 'clearance.updatedby_id', '=', 'users.id')
            ->leftJoin('lkp_updated_usertype', 'clearance.updated_usertypeid', '=', 'lkp_updated_usertype.id')
            ->where('clearance.id', $id)
            ->first();

        return view('Clearance.show')->with('Clearance', $Clearance);
    }


}
