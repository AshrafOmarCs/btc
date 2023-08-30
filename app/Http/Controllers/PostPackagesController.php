<?php

namespace App\Http\Controllers;
use DB;
use App\PostPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PostPackagesController extends Controller
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
        
        $lkp_company = DB::select('SELECT * from lkp_company');
        

        if (empty($request->filter_pakage_date)&&empty($request->filter_companyId)){
            $request->filter_companyId=-1;
            $pakage_date=""; 
            $day_count="0";
        }
        else
        {
            $filter_pakage_date = explode(" - ", $request->filter_pakage_date);     
            $pakage_date= "where CAST(pakage_date as date) between STR_TO_DATE('$filter_pakage_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_pakage_date[1]','%d/%m/%Y')";  
            

            $date = str_replace('/', '-', $filter_pakage_date[0]);
            $from_date=date('Y-m-d', strtotime($date));
            
            
            $date = str_replace('/', '-', $filter_pakage_date[1]);
            $to_date=date('Y-m-d', strtotime($date));
            
            $from_date = strtotime($from_date);
            $to_date = strtotime($to_date);
            $datediff = $to_date - $from_date;
            $day_count=round($datediff / (60 * 60 * 24))+1; 
           
        }


        $Select_db = DB::table('warehouse')
        ->select('warehouse.id as id', 'warehouseName','companyId','companyName','calculation_method_id','cityId','name_en',
        'no_of_deliverd','no_of_touch_point','CostBy_no_of_deliverd',
        DB::raw("CONCAT(companyId,',',warehouse.id,',','\'".$request->filter_pakage_date."\'') as CostBy_no_of_touch_point_html"),
        'CostBy_no_of_touch_point',
        
        DB::raw("'".$day_count."' as day_count"))
        ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
        ->leftJoin('lkp_city', 'warehouse.cityId', '=', 'lkp_city.id')
        ->leftJoin(DB::raw("(select drivers.warehouseId,
        sum(no_of_deliverd) as no_of_deliverd,
        sum(no_of_touch_point) as no_of_touch_point,
        sum(CASE DAYNAME(pakage_date)
        WHEN 'Saturday' THEN warehouse.Saturday
        WHEN 'Sunday' THEN warehouse.Sunday
        WHEN 'Monday' THEN warehouse.Monday
        WHEN 'Tuesday' THEN warehouse.Tuesday
        WHEN 'Wednesday' THEN warehouse.Wednesday
        WHEN 'Thursday' THEN warehouse.Thursday
        WHEN 'Friday' THEN warehouse.Friday
        END * no_of_deliverd )CostBy_no_of_deliverd,
        sum(CASE DAYNAME(pakage_date)
        WHEN 'Saturday' THEN warehouse.Saturday
        WHEN 'Sunday' THEN warehouse.Sunday
        WHEN 'Monday' THEN warehouse.Monday
        WHEN 'Tuesday' THEN warehouse.Tuesday
        WHEN 'Wednesday' THEN warehouse.Wednesday
        WHEN 'Thursday' THEN warehouse.Thursday
        WHEN 'Friday' THEN warehouse.Friday
        END * no_of_touch_point )CostBy_no_of_touch_point
        from packages_report
        inner join drivers on drivers.id=packages_report.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        ".$pakage_date."
        and packages_report.journal_id is null
        and packages_report.approveStatusId=2
        group by warehouseId)packages"),
              'packages.warehouseId', '=', 'warehouse.id');

       
        if (request()->ajax()) {
             
           if (!empty($request->filter_companyId)) {
                $Select_db->where('companyId', $request->filter_companyId);
            }
            if (!empty($request->filter_cityId)) {
                $Select_db->where('cityId', $request->filter_cityId);
            }
            if (!empty($request->filter_warehouseId)) {
                $Select_db->where('warehouse.id', $request->filter_warehouseId);
            }   
            //$Select_db->orderByRaw('no_of_touch_point DESC');  
            $data = $Select_db->get();
            return datatables()->of($data)->make(true);
        }
    
        //$Select_db->orderByRaw('no_of_touch_point DESC');
    
    $data = $Select_db->get();
    
        return view('PostPackages.index')->with(compact('lkp_company'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        
        $filter_pakage_date = explode(" - ", $request->input('filter_pakage_date'));     
        $pakage_date= "where CAST(pakage_date as date) between STR_TO_DATE('$filter_pakage_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_pakage_date[1]','%d/%m/%Y')";  
        
        $warehouse_ids='';
        $warehouses = DB::select('SELECT id from warehouse where companyId='.$request->input('filter_companyId'));
        foreach ($warehouses as $warehouse) {
        if(!empty($request->input('warehouseId_'.$warehouse->id)))     
        $warehouse_ids.=$warehouse->id.",";
        }
        $warehouse_ids=substr($warehouse_ids,0,strlen($warehouse_ids)-1);
        


        try {
        DB::insert("insert into journal (driverId,journal_date,debit,note,journal_type_id,post_id,
        createdby_id,updatedby_id,created_at,updated_at,credit)

select driverId,pakage_date,null,null,6,id,".Auth::user()->id.",".Auth::user()->id.",'".date("Y-m-d H:i:s")."' as created_at,'".date("Y-m-d H:i:s")."' as updated_at,
CASE calculation_method_id
        WHEN 1     THEN CostBy_no_of_touch_point
        WHEN 2     THEN CostBy_no_of_deliverd
        END amount
from(
select packages_report.id,packages_report.driverId,calculation_method_id,
pakage_date,
CASE DAYNAME(pakage_date)
        WHEN 'Saturday'  THEN warehouse.Saturday
        WHEN 'Sunday'    THEN warehouse.Sunday
        WHEN 'Monday'    THEN warehouse.Monday
        WHEN 'Tuesday'   THEN warehouse.Tuesday
        WHEN 'Wednesday' THEN warehouse.Wednesday
        WHEN 'Thursday'  THEN warehouse.Thursday
        WHEN 'Friday'    THEN warehouse.Friday
        end * no_of_deliverd CostBy_no_of_deliverd,
CASE DAYNAME(pakage_date)
        WHEN 'Saturday'  THEN warehouse.Saturday
        WHEN 'Sunday'    THEN warehouse.Sunday
        WHEN 'Monday'    THEN warehouse.Monday
        WHEN 'Tuesday'   THEN warehouse.Tuesday
        WHEN 'Wednesday' THEN warehouse.Wednesday
        WHEN 'Thursday'  THEN warehouse.Thursday
        WHEN 'Friday'    THEN warehouse.Friday
        end * no_of_touch_point CostBy_no_of_touch_point
from packages_report
inner join drivers on drivers.id=packages_report.driverId
inner join warehouse on warehouse.id=drivers.warehouseId
inner join lkp_company on lkp_company.id=warehouse.companyId
".$pakage_date."
and warehouse.id in(".$warehouse_ids.")
and packages_report.journal_id is null
and packages_report.approveStatusId=2
)a
    ");
} catch(\Illuminate\Database\QueryException $e ) {
    return redirect('/PostPackages')->with('error',   $e->getPrevious()->getMessage());
}

try {
    DB::update("
UPDATE packages_report 
JOIN journal  ON (packages_report.id = journal.post_id and journal.journal_type_id=6)
inner join drivers on drivers.id=packages_report.driverId
inner join warehouse on warehouse.id=drivers.warehouseId
inner join lkp_company on lkp_company.id=warehouse.companyId
SET packages_report.journal_id = journal.id
".$pakage_date."
and warehouse.id in(".$warehouse_ids.")
");
} catch(\Illuminate\Database\QueryException $e ) {
    return redirect('/PostPackages')->with('error',   $e->getPrevious()->getMessage());
}
        return redirect('/PostPackages')->with('success', 'Done successfully');
    }

   
    public function PostPackagesWindow(Request $request)
    {
        
        $company = DB::select('SELECT companyName,warehouseName,calculation_method_id from warehouse
        inner join lkp_company on lkp_company.id=warehouse.companyId
        where warehouse.id='.$request->input('warehouseId'))[0];
        
        $filter_pakage_date = explode(" - ", $request->input('date'));     
        $pakage_date= "where CAST(pakage_date as date) between STR_TO_DATE('$filter_pakage_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_pakage_date[1]','%d/%m/%Y')";      
        $date=$request->input('date');


    $qq=DB::select("select pakage_date,DAYNAME(pakage_date) as dayname,drivers.fullName,
total_out_for_deliver,
total_no_touchpoint,
no_of_deliverd,
no_of_touch_point,
unit_cost,
CASE DAYNAME(pakage_date)
        WHEN 'Saturday' THEN warehouse.Saturday
        WHEN 'Sunday' THEN warehouse.Sunday
        WHEN 'Monday' THEN warehouse.Monday
        WHEN 'Tuesday' THEN warehouse.Tuesday
        WHEN 'Wednesday' THEN warehouse.Wednesday
        WHEN 'Thursday' THEN warehouse.Thursday
        WHEN 'Friday' THEN warehouse.Friday
        END * no_of_deliverd CostBy_no_of_deliverd,
CASE DAYNAME(pakage_date)
        WHEN 'Saturday' THEN warehouse.Saturday
        WHEN 'Sunday' THEN warehouse.Sunday
        WHEN 'Monday' THEN warehouse.Monday
        WHEN 'Tuesday' THEN warehouse.Tuesday
        WHEN 'Wednesday' THEN warehouse.Wednesday
        WHEN 'Thursday' THEN warehouse.Thursday
        WHEN 'Friday' THEN warehouse.Friday
        END * no_of_touch_point CostBy_no_of_touch_point
from packages_report
inner join drivers on drivers.id=packages_report.driverId
inner join warehouse on warehouse.id=drivers.warehouseId
".$pakage_date."
and packages_report.journal_id is null
and packages_report.approveStatusId=2
and drivers.warehouseId=".$request->input('warehouseId')."
order by pakage_date
");
    
return view('PostPackages.PostPackagesWindow')->with(compact('qq'))->with(compact('company'))->with(compact('date'));

}
}
