<?php

namespace App\Http\Controllers;

use App\Packages;
use DateTime;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PackagesController extends Controller
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
        $lkp_company = DB::select('SELECT * from lkp_company where lkp_company.status = "active"');
        $warehouse = DB::select('SELECT * from warehouse order by warehouseName');
        $lkp_package_status = DB::select('SELECT * from lkp_package_status ');
        $lkp_packageapprovestatus = DB::select('SELECT * from lkp_packageapprovestatus ');
        $Select_db = DB::table('packages_report')
            ->select('packages_report.id as id', 'driverId', 'job_id', 'fullName', 'fullName_ar', 'companyName', 'warehouseName', 'total_out_for_deliver',
                'total_no_touchpoint', 'no_of_deliverd', 'no_of_touch_point', 'return_no_of_deliverd', 'return_no_of_touch_point', 'attendence', 'pakage_date', 'packageStatusId',
                'lkp_package_status.status', 'approveStatusId', 'approvestatus', 'packages_report.updatedby_id', 'name', 'updated_usertypeid', 'user_type', 'journal_id',
                'packages_report.created_at as created_at', 'packages_report.updated_at as updated_at', 'No_of_D', 'No_of_CIR', 'No_of_TP', 'Total_OFD', 'damage')
            ->leftJoin('drivers', 'packages_report.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_package_status', 'packages_report.packageStatusId', '=', 'lkp_package_status.id')
            ->leftJoin('lkp_packageapprovestatus', 'packages_report.approveStatusId', '=', 'lkp_packageapprovestatus.id')
            ->leftJoin('users', 'packages_report.updatedby_id', '=', 'users.id')
            ->leftJoin('lkp_user_type', 'packages_report.updated_usertypeid', '=', 'lkp_user_type.id');

        $Select_sum = DB::table('packages_report')
            ->select(DB::raw("sum(total_out_for_deliver)as total_out_for_deliver"), DB::raw("sum(total_no_touchpoint)as total_no_touchpoint"),
                DB::raw("sum(no_of_deliverd)as no_of_deliverd"),
                DB::raw("sum(return_no_of_touch_point)as return_no_of_touch_point"),
                DB::raw("sum(no_of_touch_point)as no_of_touch_point"), DB::raw("sum(attendence)as attendence"),
                DB::raw("sum(IFNULL(No_of_D,0))as No_of_D"),
                DB::raw("sum(IFNULL(No_of_CIR,0))as No_of_CIR"),
                DB::raw("sum(No_of_TP)as No_of_TP"), DB::raw("sum(Total_OFD)as Total_OFD"))
            ->leftJoin('drivers', 'packages_report.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_package_status', 'packages_report.packageStatusId', '=', 'lkp_package_status.id')
            ->leftJoin('lkp_packageapprovestatus', 'packages_report.approveStatusId', '=', 'lkp_packageapprovestatus.id')
            ->leftJoin('users', 'packages_report.updatedby_id', '=', 'users.id')
            ->leftJoin('lkp_user_type', 'packages_report.updated_usertypeid', '=', 'lkp_user_type.id');
        if (request()->ajax()) {
            if (!empty($request->filter_companyId)) {
                $Select_db->where('companyId', $request->filter_companyId);
                $Select_sum->where('companyId', $request->filter_companyId);
            }
            if (!empty($request->filter_warehouseId)) {
                $Select_db->where('warehouseId', $request->filter_warehouseId);
                $Select_sum->where('warehouseId', $request->filter_warehouseId);
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
                $Select_sum->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->where('driverId', $request->filter_driverId);
                $Select_sum->where('driverId', $request->filter_driverId);
            }
            if (!empty($request->filter_total_out_for_deliver)) {
                $Select_db->whereRaw("total_out_for_deliver = " . strtoupper($request->filter_total_out_for_deliver));
                $Select_sum->whereRaw("total_out_for_deliver = " . strtoupper($request->filter_total_out_for_deliver));
            }
            if (!empty($request->filter_total_no_touchpoint)) {
                $Select_db->whereRaw("total_no_touchpoint = " . strtoupper($request->filter_total_no_touchpoint));
                $Select_sum->whereRaw("total_no_touchpoint = " . strtoupper($request->filter_total_no_touchpoint));
            }
            if (!empty($request->filter_no_of_deliverd)) {
                $Select_db->whereRaw("no_of_deliverd = " . strtoupper($request->filter_no_of_deliverd));
                $Select_sum->whereRaw("no_of_deliverd = " . strtoupper($request->filter_no_of_deliverd));
            }
            if (!empty($request->filter_no_of_touch_point)) {
                $Select_db->whereRaw("no_of_touch_point = " . strtoupper($request->filter_no_of_touch_point));
                $Select_sum->whereRaw("no_of_touch_point = " . strtoupper($request->filter_no_of_touch_point));
            }
            if (!empty($request->filter_attendence)) {
                $Select_db->where('attendence', $request->filter_attendence);
                $Select_sum->where('attendence', $request->filter_attendence);
            }
            if (!empty($request->filter_pakage_date)) {
                $filter_pakage_date = explode(" - ", $request->filter_pakage_date);
                $Select_db->whereRaw("CAST(pakage_date as date) between STR_TO_DATE('$filter_pakage_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_pakage_date[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(pakage_date as date) between STR_TO_DATE('$filter_pakage_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_pakage_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_packageStatusId)) {
                $Select_db->where('packageStatusId', $request->filter_packageStatusId);
                $Select_sum->where('packageStatusId', $request->filter_packageStatusId);
            }
            if (!empty($request->filter_approveStatusId)) {
                $Select_db->where('approveStatusId', $request->filter_approveStatusId);
                $Select_sum->where('approveStatusId', $request->filter_approveStatusId);
            }
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(packages_report.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(packages_report.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(packages_report.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(packages_report.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }
            if (isset($_REQUEST['search']['value']) && $_REQUEST['search']['value'] <> '') {
                $options = strtolower($_REQUEST['search']['value']);
                $Select_sum->whereRaw("(
            LOWER(
                `lkp_company`.`companyName`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `warehouse`.`warehouseName`
            ) LIKE '%" . $options . "%'
            OR LOWER(`drivers`.`fullName`) LIKE '%" . $options . "%'
            OR LOWER(`drivers`.`job_id`) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`pakage_date`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`total_out_for_deliver`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`total_no_touchpoint`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`no_of_deliverd`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`return_no_of_touch_point`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`no_of_touch_point`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`attendence`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`Total_OFD`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`No_of_D`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`No_of_CIR`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `packages_report`.`No_of_TP`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `lkp_package_status`.`status`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `lkp_packageapprovestatus`.`approvestatus`
            ) LIKE '%" . $options . "%'
            OR LOWER(
                `lkp_user_type`.`user_type`
            ) LIKE '%" . $options . "%'
            OR LOWER(`users`.`name`) LIKE '%" . $options . "%'
            OR LOWER(`packages_report`.`id`) LIKE '%" . $options . "%'
            )");
            }
            //return $Select_db->toSql();
            $Select_sum = $Select_sum->first();
            return datatables()->of($Select_db)
                ->with('total_out_for_deliver', '<b>' . $Select_sum->total_out_for_deliver . '</b>')
                ->with('total_no_touchpoint', '<b>' . $Select_sum->total_no_touchpoint . '</b>')
                ->with('no_of_deliverd', '<b>' . $Select_sum->no_of_deliverd . '</b>')
                ->with('return_no_of_touch_point', '<b>' . $Select_sum->return_no_of_touch_point . '</b>')
                ->with('no_of_touch_point', '<b>' . $Select_sum->no_of_touch_point . '</b>')
                ->with('attendence', '<b>' . $Select_sum->attendence . '</b>')
                ->with('No_of_D', '<b>' . $Select_sum->No_of_D . '</b>')
                ->with('No_of_CIR', '<b>' . $Select_sum->No_of_CIR . '</b>')
                ->with('No_of_TP', '<b>' . $Select_sum->No_of_TP . '</b>')
                ->with('Total_OFD', '<b>' . $Select_sum->Total_OFD . '</b>')
                ->make(true);
        }
        //$data = $Select_db->get();
        return view('Packages.index')->with(compact('lkp_package_status'))->with(compact('lkp_packageapprovestatus'))
            ->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $lkp_package_status = DB::select('SELECT * from lkp_package_status ');
        $lkp_packageapprovestatus = DB::select('SELECT * from lkp_packageapprovestatus ');
        return view('Packages.create')->with(compact('lkp_package_status'))->with(compact('lkp_packageapprovestatus'));
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
        //    'PackagesName' => ['required', 'string', 'max:255'],
        //   'companyId' => ['required'],
        //   'cityId' => ['required'],
        //   ]);
        $dayname = DateTime::createFromFormat('d/m/Y', $request->input('pakage_date'))->format('l');
        $day = DB::select("SELECT " . $dayname . " as dayunitcost from drivers
        inner join warehouse on warehouse.id=drivers.warehouseId
        where drivers.id=" . $request->input('driverId'))[0];
        $Packages = new Packages;
        $Packages->driverId = $request->input('driverId');
        $Packages->total_out_for_deliver = $request->input('total_out_for_deliver');
        $Packages->total_no_touchpoint = $request->input('total_no_touchpoint');
        $Packages->no_of_deliverd = $request->input('no_of_deliverd');
        $Packages->no_of_touch_point = $request->input('no_of_touch_point');
        $Packages->unit_cost = $request->input('unit_cost');
        $Packages->No_of_TP = $request->input('No_of_TP');
        $Packages->attendence = $request->input('attendence');
        $Packages->pakage_date = (empty($request->input('pakage_date'))) ? null : DateTime::createFromFormat('d/m/Y', $request->input('pakage_date'))->format('Y-m-d');
        $Packages->packageStatusId = $request->input('packageStatusId');
        $Packages->approveStatusId = $request->input('approveStatusId');

        $Packages->updatedby_id = Auth::user()->id;
        $Packages->updated_usertypeid = Auth::user()->user_type_id;
        $Packages->save();
        return redirect('/Packages')->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function show($id)
    {
        $Packages = DB::table('packages_report')
            ->select('packages_report.id as id', 'driverId', 'fullName', 'fullName_ar', 'total_out_for_deliver',
                'total_no_touchpoint', 'no_of_deliverd', 'no_of_touch_point', 'attendence', 'attend_status',
                DB::raw("DATE_FORMAT(pakage_date,'%d/%m/%Y') as pakage_date"), 'packageStatusId', 'status',
                'approveStatusId', 'approvestatus', 'packages_report.created_at as created_at', 'packages_report.updated_at as updated_at')
            ->leftJoin('drivers', 'packages_report.driverId', '=', 'drivers.id')
            ->leftJoin('lkp_package_status', 'packages_report.packageStatusId', '=', 'lkp_package_status.id')
            ->leftJoin('lkp_packageapprovestatus', 'packages_report.approveStatusId', '=', 'lkp_packageapprovestatus.id')
            ->leftJoin('lkp_attendence', 'packages_report.attendence', '=', 'lkp_attendence.id')
            ->where('packages_report.id', $id)
            ->first();
        return view('Packages.show')->with('Packages', $Packages);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function edit($id)
    {
        $lkp_package_status = DB::select('SELECT * from lkp_package_status ');
        $lkp_packageapprovestatus = DB::select('SELECT * from lkp_packageapprovestatus ');
        $Packages = DB::table('packages_report')
            ->select('packages_report.id as id', 'driverId', 'fullName', 'fullName_ar', 'total_out_for_deliver',
                'total_no_touchpoint', 'no_of_deliverd', 'no_of_touch_point','unit_cost', 'attendence',
                DB::raw("DATE_FORMAT(pakage_date,'%d/%m/%Y') as pakage_date"), 'packageStatusId', 'approveStatusId')
            ->leftJoin('drivers', 'packages_report.driverId', '=', 'drivers.id')
            ->where('packages_report.id', $id)
            ->first();
        return view('Packages.edit')->with(compact('Packages'))->with(compact('lkp_package_status'))->with(compact('lkp_packageapprovestatus'));
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
        //'password' => ['required', 'string', 'min:8', 'confirmed'],
        //$this->validate($request, [
        //     'PackagesName' => ['required', 'string', 'max:255'],
        //     'companyId' => ['required'],
        //     'cityId' => ['required'],
        //     ]);
        $dayname = DateTime::createFromFormat('d/m/Y', $request->input('pakage_date'))->format('l');
        $day = DB::select("SELECT " . $dayname . " as dayunitcost from drivers
        inner join warehouse on warehouse.id=drivers.warehouseId
        where drivers.id=" . $request->input('driverId'))[0];
        $Packages = Packages::find($id);
        // $Packages->warehouseId = $request->input('warehouseId');
        $Packages->driverId = $request->input('driverId');
        $Packages->total_out_for_deliver = $request->input('total_out_for_deliver');
        $Packages->total_no_touchpoint = $request->input('total_no_touchpoint');
        $Packages->no_of_deliverd = $request->input('no_of_deliverd');
        $Packages->no_of_touch_point = $request->input('no_of_touch_point');
        $Packages->attendence = $request->input('attendence');
        $Packages->pakage_date = (empty($request->input('pakage_date'))) ? null : DateTime::createFromFormat('d/m/Y', $request->input('pakage_date'))->format('Y-m-d');
        $Packages->packageStatusId = $request->input('packageStatusId');
        $Packages->approveStatusId = $request->input('approveStatusId');
        $Packages->unit_cost = $request->input('unit_cost');
        $Packages->No_of_TP = $request->input('No_of_TP');
        $Packages->updatedby_id = Auth::user()->id;
        $Packages->updated_usertypeid = Auth::user()->user_type_id;
        $Packages->save();
        return redirect('/Packages')->with('success', 'Done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy($id)
    {
        $Packages = Packages::find($id);
        $Packages->delete();
        return redirect('/Packages')->with('success', 'Done successfully');
    }
}
