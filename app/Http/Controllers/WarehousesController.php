<?php

namespace App\Http\Controllers;

use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WarehousesController extends Controller
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
        $where = array();
        if (!empty($request->filter_companyId))
            $where[] = 'lkp_company.id=' . $request->filter_companyId;
        else $where[] = 'lkp_company.id=1';
        if (!empty($request->filter_cityId))
            $where[] = 'lkp_city.id=' . $request->filter_cityId;
        if (!empty($request->filter_warehouseId))
            $where[] = 'warehouse.id=' . $request->filter_warehouseId;
        if (!empty($request->filter_under_noon_id))
            $where[] = 'under_noon_id=' . $request->filter_under_noon_id;
        $where2 = implode(" AND ", $where);
        if (count($where) > 0) $where2 = " and " . $where2;

        if (!empty($request->pakage_date)) $pakage_date = \DateTime::createFromFormat('d/m/Y', $request->pakage_date)->format('Y-m-d');
        else $pakage_date = date('Y-m-d');

        $lkp_company = DB::select('SELECT * from lkp_company WHERE status = "active"');
        $lkp_yes_no = DB::select('SELECT * from lkp_yes_no');

        $Select_db = DB::table('warehouse')
            ->select('warehouse.id as id', 'warehouseName', 'companyId', 'companyName', 'cityId', 'name_en',
                'total_out_for_deliver', 'total_no_touchpoint', 'no_of_deliverd', 'no_of_touch_point', 'attendence', 'attendwithnowork',
                'min_load', 'max_load', 'avg_load', DB::raw('TRIM(median_val)+0 as median_val'), 'total_drivers',
                'warehouse.created_at as created_at', 'latitude', 'longitude')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_city', 'warehouse.cityId', '=', 'lkp_city.id')
            ->leftJoin(DB::raw("(select drivers.warehouseId,
        sum(total_out_for_deliver) as total_out_for_deliver,
        sum(total_no_touchpoint) as total_no_touchpoint,
        sum(no_of_deliverd) as no_of_deliverd,
        sum(no_of_touch_point) as no_of_touch_point,
        sum(IF( attendence = 1 AND total_out_for_deliver >= 1, 1, 0 )) as attendence,
        sum(IF( attendence = 1 AND total_out_for_deliver < 1, 1, 0 )) as attendwithnowork,
        MIN(TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt))as min_load,
        max(TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt))as max_load,
        round(avg(TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt)))as avg_load


        from packages_report
        inner join drivers on drivers.id=packages_report.driverId
        where packages_report.pakage_date='" . $pakage_date . "'
        group by warehouseId)packages"),
                'packages.warehouseId', '=', 'warehouse.id')
            ->leftJoin(DB::raw("(select warehouseId,count(*) as total_drivers from drivers
        where drivers.status_id in(1,2)
        group by warehouseId)total"),
                'total.warehouseId', '=', 'warehouse.id')
            ->leftJoin(DB::raw("(SELECT warehouseId, AVG(val) as median_val
        FROM
        (
          SELECT warehouseId, val,
              (SELECT count(*) FROM packages_report t2 inner join drivers on drivers.id=t2.driverId  WHERE drivers.warehouseId = t3.warehouseId
               and  t2.pakage_date='" . $pakage_date . "'
              and TIMESTAMPDIFF(MINUTE,t2.created_at,t2.firstsave_dt) is not null
              ) as ct,
              seq,
              (SELECT count(*) FROM packages_report t2 inner join drivers on drivers.id=t2.driverId WHERE drivers.warehouseId < t3.warehouseId
               and  t2.pakage_date='" . $pakage_date . "'
               and TIMESTAMPDIFF(MINUTE,t2.created_at,t2.firstsave_dt) is not null
               ) as delta
            FROM (SELECT warehouseId, val, @rownum := @rownum + 1 as seq
                  FROM (SELECT warehouseId,TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt)as val FROM packages_report
                  inner join drivers on drivers.id=packages_report.driverId
                  where TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt) is not null
                  and  packages_report.pakage_date='" . $pakage_date . "'
                  ORDER BY warehouseId, TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt)) t1
                  ORDER BY warehouseId, seq
                ) t3 CROSS JOIN (SELECT @rownum := 0) x
            HAVING (ct%2 = 0 and seq-delta between floor((ct+1)/2) and floor((ct+1)/2) +1)
              or (ct%2 <> 0 and seq-delta = (ct+1)/2)
        ) T
        GROUP BY warehouseId
        )median_load"),
                'median_load.warehouseId', '=', 'warehouse.id')
            ->where('active_id', 1);


        if (!empty($request->filter_companyId)) {
            $Select_db->where('companyId', $request->filter_companyId);
        } else
            $Select_db->where('companyId', '1');
        if (!empty($request->filter_cityId)) {
            $Select_db->where('lkp_city.id', $request->filter_cityId);
        }
        if (!empty($request->filter_warehouseId)) {
            $Select_db->where('warehouse.id', $request->filter_warehouseId);
        }
        if (!empty($request->filter_under_noon_id)) {
            $Select_db->where('under_noon_id', $request->filter_under_noon_id);
        }

        $sum = DB::select("select
        sum(total_out_for_deliver) as total_out_for_deliver,
        sum(total_no_touchpoint) as total_no_touchpoint,
        sum(no_of_deliverd) as no_of_deliverd,
        sum(no_of_touch_point) as no_of_touch_point,
        sum(IF( attendence = 1 AND total_out_for_deliver >= 1, 1, 0 )) as attendence,
        sum(IF( attendence = 1 AND total_out_for_deliver < 1, 1, 0 )) as attendwithnowork,
        MIN(TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt))as min_load,
        max(TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt))as max_load,
        round(avg(TIMESTAMPDIFF(MINUTE,packages_report.created_at,packages_report.firstsave_dt)))as avg_load
        from packages_report
        inner join drivers on drivers.id=packages_report.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId and warehouse.active_id=1
        inner join lkp_company  on lkp_company.id=warehouse.companyId
        inner join lkp_city on lkp_city.id=warehouse.cityId
        where packages_report.pakage_date='" . $pakage_date . "'" . $where2 . "
        ")[0];
        $drivers = DB::select("select count(*) as total_drivers from drivers
        inner join warehouse on warehouse.id=drivers.warehouseId and warehouse.active_id=1
        inner join lkp_company  on lkp_company.id=warehouse.companyId
        inner join lkp_city on lkp_city.id=warehouse.cityId
        where status_id in(1,2) " . $where2)[0];

        $med = DB::select("SELECT TRIM(AVG(dd.val))+0 as median_val
        FROM (
        SELECT TIMESTAMPDIFF(MINUTE,d.created_at,d.firstsave_dt) as val, @rownum:=@rownum+1  as `row_number`, @total_rows:=@rownum
          FROM packages_report d
        inner join drivers on drivers.id=d.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId and warehouse.active_id=1
        inner join lkp_company  on lkp_company.id=warehouse.companyId
        inner join lkp_city on lkp_city.id=warehouse.cityId
        , (SELECT @rownum:=0) r
          WHERE TIMESTAMPDIFF(MINUTE,d.created_at,d.firstsave_dt) is NOT NULL
          -- put some where clause here
        and  d.pakage_date='" . $pakage_date . "'" . $where2 . "
          ORDER BY TIMESTAMPDIFF(MINUTE,d.created_at,d.firstsave_dt)

        ) as dd
        WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) )
        ")[0];
        if (request()->ajax()) {
//return $Select_db->toSql();
            //$data = $Select_db->get();
            return datatables()->of($Select_db)
                ->with('total_out_for_deliver', '<b>' . $sum->total_out_for_deliver . '</b>')
                ->with('total_no_touchpoint', '<b>' . $sum->total_no_touchpoint . '</b>')
                ->with('no_of_deliverd', '<b>' . $sum->no_of_deliverd . '</b>')
                ->with('no_of_touch_point', '<b>' . $sum->no_of_touch_point . '</b>')
                ->with('total_drivers', '<b>' . $drivers->total_drivers . '</b>')
                ->with('attendence', '<b>' . $sum->attendence . '</b>')
                ->with('attendwithnowork', '<b>' . $sum->attendwithnowork . '</b>')
                ->with('min_load', '<b>' . $sum->min_load . '</b>')
                ->with('max_load', '<b>' . $sum->max_load . '</b>')
                ->with('avg_load', '<b>' . $sum->avg_load . '</b>')
                ->with('median_val', '<b>' . $med->median_val . '</b>')
                ->make(true);
        }

        //$data = $Select_db->get();


        return view('Warehouses.index')->with(compact('lkp_company'))->with(compact('lkp_yes_no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $lkp_company = DB::select('SELECT * from lkp_company WHERE status = "active"');
        $lkp_active = DB::select('SELECT * from lkp_active');
        $lkp_city = DB::select('SELECT * from lkp_city');
        $lkp_yes_no = DB::select('SELECT * from lkp_yes_no');
        return view('Warehouses.create')->with(compact('lkp_company'))
            ->with(compact('lkp_city'))->with(compact('lkp_active'))->with(compact('lkp_yes_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'warehouseName' => ['required', 'string', 'max:255'],
            'companyId' => ['required'],
            'cityId' => ['required'],
        ]);

        $Warehouses = new Warehouse;
        $Warehouses->warehouseName = $request->input('warehouseName');
        $Warehouses->companyId = $request->input('companyId');
        $Warehouses->cityId = $request->input('cityId');
        $Warehouses->active_id = $request->input('active_id');

        $Warehouses->Saturday = $request->input('Saturday');
        $Warehouses->Sunday = $request->input('Sunday');
        $Warehouses->Monday = $request->input('Monday');
        $Warehouses->Tuesday = $request->input('Tuesday');
        $Warehouses->Wednesday = $request->input('Wednesday');
        $Warehouses->Thursday = $request->input('Thursday');
        $Warehouses->Friday = $request->input('Friday');
        $Warehouses->latitude = $request->input('latitude');
        $Warehouses->longitude = $request->input('longitude');
        $Warehouses->under_noon_id = $request->input('under_noon_id');
        $Warehouses->warehouse_unit_cost = $request->input('warehouse_unit_cost');

        $Warehouses->save();

        return redirect('/Warehouses')->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Select_db = DB::table('warehouse')
            ->select('warehouse.id as id', 'warehouseName', 'companyId', 'companyName', 'cityId', 'name_en', 'active_id', 'active_status',
                'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','lkp_yes_no.yes_no','warehouse_unit_cost',
                'warehouse.created_at as created_at', 'warehouse.updated_at as updated_at')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_city', 'warehouse.cityId', '=', 'lkp_city.id')
            ->leftJoin('lkp_active', 'warehouse.active_id', '=', 'lkp_active.id')
            ->leftJoin('lkp_yes_no', 'warehouse.under_noon_id', '=', 'lkp_yes_no.id')
            ->where('warehouse.id', $id);
        $Warehouses = $Select_db->first();

        return view('Warehouses.show')->with('Warehouses', $Warehouses);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lkp_company = DB::select('SELECT * from lkp_company WHERE status = "active"');
        $lkp_city = DB::select('SELECT * from lkp_city');
        $lkp_active = DB::select('SELECT * from lkp_active');
        $Warehouses = DB::select(DB::raw('SELECT * from warehouse where id=' . $id))[0];
        $lkp_yes_no = DB::select('SELECT * from lkp_yes_no');
        return view('Warehouses.edit')->with('Warehouses', $Warehouses)
            ->with(compact('lkp_company'))->with(compact('lkp_city'))->with(compact('lkp_active'))->with(compact('lkp_yes_no'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //'password' => ['required', 'string', 'min:8', 'confirmed'],
        $this->validate($request, [
            'warehouseName' => ['required', 'string', 'max:255'],
            'companyId' => ['required'],
            'cityId' => ['required'],
        ]);

        $Warehouses = Warehouse::find($id);
        $Warehouses->warehouseName = $request->input('warehouseName');
        $Warehouses->companyId = $request->input('companyId');
        $Warehouses->cityId = $request->input('cityId');
        $Warehouses->active_id = $request->input('active_id');

        $Warehouses->Saturday = $request->input('Saturday');
        $Warehouses->Sunday = $request->input('Sunday');
        $Warehouses->Monday = $request->input('Monday');
        $Warehouses->Tuesday = $request->input('Tuesday');
        $Warehouses->Wednesday = $request->input('Wednesday');
        $Warehouses->Thursday = $request->input('Thursday');
        $Warehouses->Friday = $request->input('Friday');
        $Warehouses->latitude = $request->input('latitude');
        $Warehouses->longitude = $request->input('longitude');
        $Warehouses->under_noon_id = $request->input('under_noon_id');
        $Warehouses->warehouse_unit_cost = $request->input('warehouse_unit_cost');
        $Warehouses->save();

        return redirect('/Warehouses')->with('success', 'Done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Warehouses = Warehouse::find($id);
        // if(auth()->user()->id !== $Warehouses->user_id){
        //    return redirect('/Warehouses')->with('error','Unauthorized');
        // }

        if ($Warehouses->logo != 'noImage.jpg') {
            Storage::delete('public/app/storage' . $Warehouses->logo);

        }

        $Warehouses->delete();

        return redirect('/Warehouses')->with('success', 'Done successfully');
    }

    public function MapWindow($id)
    {
        $Warehouse = DB::select(DB::raw('SELECT warehouse.id,companyName,warehouseName,latitude,longitude from warehouse
        inner join lkp_company on lkp_company.id=warehouse.companyId
        where warehouse.id=' . $id))[0];
        return view('Warehouses.MapWindow')->with(compact('Warehouse'));
    }

    public function MapWindowSave(Request $request)
    {

        DB::update("update warehouse set latitude=" . $request->input('lat-text') . ",
        longitude=" . $request->input('lon-text') . " where id=" . $request->input('id'));

        $Warehouse = DB::select(DB::raw('SELECT warehouse.id,companyName,warehouseName,latitude,longitude from warehouse
        inner join lkp_company on lkp_company.id=warehouse.companyId
        where warehouse.id=' . $request->input('id')))[0];

        return redirect('/MapWindow/' . $request->input('id'))->with(compact('Warehouse'))->with('success', 'Done successfully');
    }

}
