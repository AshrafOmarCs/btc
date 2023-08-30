<?php

namespace App\Http\Controllers;

use App\Gaps;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class GapsController extends Controller
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
        
        $lkp_company = DB::select('SELECT * from lkp_company ');
        $warehouse = DB::select('SELECT * from warehouse order by warehouseName');
        $users = DB::select('SELECT id,name from users order by name');
       

        $Select_db = DB::table('gaps')
            ->select('gaps.id as id', 'gaps.driverId', 'fullName','companyName','warehouseName','job_id', 'fullName_ar', 'journal_date','package_count',
             'amount','note','gaps.updatedby_id','name',
                'gaps.created_at as created_at', 'gaps.updated_at as updated_at','journal_id','per_priod','cur_priod',
                DB::raw("
                if (period_start<>1,
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', period_start,
                ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', period_end),
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', period_start,
                ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', period_end))
                 as journal_period")
                )
            ->leftJoin('drivers', 'gaps.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('users', 'gaps.updatedby_id', '=', 'users.id')
            ->leftJoin(DB::raw("(SELECT 
            driverId, 
            TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,  
            TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod
           
            
           from
        
        (select driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
               date_format(journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
               date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
               date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m') AS cur_priod,
               date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod 
        from journal
        inner join drivers on drivers.id=journal.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
        group by driverId,per_priod,cur_priod,next_priod
        )balance"),
             'balance.driverId', '=', 'drivers.id');
            

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
                $Select_db->where('driverId', $request->filter_driverId);
            }
           if (!empty($request->filter_journal_date)) {
                $filter_journal_date = explode(" - ", $request->filter_journal_date);
                $Select_db->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_package_count)) {
                $Select_db->where('package_count', $request->filter_package_count);
            }

            if (!empty($request->filter_amount)) {
                $Select_db->where('amount', $request->filter_amount);
            }
           
            if (!empty($request->filter_note)) {
                $Select_db->whereRaw("UPPER(note) LIKE '%". strtoupper($request->filter_note)."%'"); 
            }   
            
            
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(gaps.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            } 
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(gaps.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }
            //$data = $Select_db->get();
            return datatables()->of($Select_db)->make(true);
        }

       // $data = $Select_db->get();

        return view('Gaps.index')->with(compact('users'))
        ->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Gaps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => ['required'],
           'journal_period' => ['required'],
           ]);
         
        $data = collect(DB::select("SELECT 
        driverId, 
        TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,  
        TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod,
        if (period_start<>1,CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'),'-', period_end),
                CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'),'-', period_end))as per_range,
                if (period_start<>1,CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', period_end),
                 CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'),'-', period_end))as cur_range
        
       from
    
    (select driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
           date_format(journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
           date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
           date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m') AS cur_priod,
           date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod 
    from journal
    inner join drivers on drivers.id=journal.driverId
    inner join warehouse on warehouse.id=drivers.warehouseId
    inner join lkp_company on lkp_company.id=warehouse.companyId
    group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
    where driverId=".$request->input('driverId')."
    group by driverId,per_priod,cur_priod,next_priod"))->first();

if ($request->input('journal_period')==1)
{  
$arr=explode('-',substr($data->per_range,12,21));    
if ($arr[2] ==31)$period_end=28;else $period_end=$arr[2]; 
$journal_date=$arr[0].'-'.$arr[1].'-'. $period_end;
      
}
elseif ($request->input('journal_period')==2)
{ 
    $journal_date=date('Y-m-d');
}
        $Gaps = new Gaps;
        $Gaps->driverId = $request->input('driverId');
        $Gaps->journal_date =$journal_date; 
        //( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        
        $Gaps->package_count = $request->input('package_count');
        $Gaps->amount = $request->input('amount');
        $Gaps->note = $request->input('note');
        $Gaps->updatedby_id = Auth::user()->id;
        $Gaps->createdby_id = Auth::user()->id;

        $Gaps->save();

        return redirect('/Gaps')->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Gaps = DB::table('gaps')
        ->select('gaps.id as id', 'driverId', 'fullName', 'fullName_ar', 'journal_date','package_count',
         'amount','note','gaps.updatedby_id','name',
            'gaps.created_at as created_at', 'gaps.updated_at as updated_at')
        ->leftJoin('drivers', 'gaps.driverId', '=', 'drivers.id')
        ->leftJoin('users', 'gaps.updatedby_id', '=', 'users.id')
        ->where('gaps.id', $id)
        ->first();

        return view('Gaps.show')->with('Gaps', $Gaps);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        
        $Gaps = DB::table('gaps')
        ->select('gaps.id as id', 'gaps.driverId', 'fullName', 'fullName_ar',
         DB::raw("DATE_FORMAT(journal_date,'%d/%m/%Y') as journal_date"),'amount','package_count','note',
            'gaps.created_at as created_at', 'gaps.updated_at as updated_at', DB::raw("ifnull(per_priod,0) as per_priod"),DB::raw("ifnull(cur_priod,0) as cur_priod"),
            DB::raw("if (period_start<>1,CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'),'-', period_end),
                CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'),'-', period_end))as per_range"),
                DB::raw("if (period_start<>1,CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', period_end),
                 CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'),'-', period_end))as cur_range"),
            DB::raw("
            if (period_start<>1,
            CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', period_start,
            ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', period_end),
            CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', period_start,
            ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', period_end))
             as journal_period")
            )
        ->leftJoin('drivers', 'gaps.driverId', '=', 'drivers.id')
        ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
        ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
        ->leftJoin(DB::raw("(SELECT 
            driverId, 
            TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,  
            TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod
           
            
           from
        
        (select driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
               date_format(journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
               date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
               date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m') AS cur_priod,
               date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod 
        from journal
        inner join drivers on drivers.id=journal.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
        group by driverId,per_priod,cur_priod,next_priod
        )balance"),
             'balance.driverId', '=', 'drivers.id')
        ->where('gaps.id', $id)
            ->first();
        return view('Gaps.edit')->with(compact('Gaps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => ['required'],
           'journal_period' => ['required'],
           ]);
         
        $data = collect(DB::select("SELECT 
        driverId, 
        TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,  
        TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod,
        if (period_start<>1,CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'),'-', period_end),
                CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'),'-', period_end))as per_range,
                if (period_start<>1,CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', period_end),
                 CONCAT(date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'), '-', period_start,' - ',date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m'),'-', period_end))as cur_range
        
       from
    
    (select journal.driverId as driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
           date_format(journal.journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
           date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
           date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day , '%Y-%m') AS cur_priod,
           date_format('".date("Y-m-d H:i:s")."' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod 
    from journal
    inner join drivers on drivers.id=journal.driverId
    inner join warehouse on warehouse.id=drivers.warehouseId
    inner join lkp_company on lkp_company.id=warehouse.companyId
   
    group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
    where driverId=".$request->input('driverId')."
    group by driverId,per_priod,cur_priod,next_priod"))->first();

if ($request->input('journal_period')==1)
{   
 
$arr=explode('-',substr($data->per_range,12,21));    
if ($arr[2] ==31)$period_end=28;else $period_end=$arr[2]; 
$journal_date=$arr[0].'-'.$arr[1].'-'. $period_end;
     
}
elseif ($request->input('journal_period')==2)
{ 
    $journal_date=date('Y-m-d');
}          

        $Gaps = Gaps::find($id);
        $Gaps->driverId = $request->input('driverId');
        $Gaps->journal_date = $journal_date;
        //( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $Gaps->package_count = $request->input('package_count');
        $Gaps->amount = $request->input('amount');
        $Gaps->note = $request->input('note');
        $Gaps->createdby_id = Auth::user()->id;

       
        $Gaps->save();

        return redirect('/Gaps')->with('success', 'Done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $Gaps = Gaps::find($id);
        
        $Gaps->delete();

        return redirect('/Gaps')->with('success', 'Done successfully');
    }

    public function GapsPost(Request $request)
    {
        $IDs='';
        for($i=0;$i<105;$i++)  
        {
        if(!empty($request->input('ID_'.$i)))     
        $IDs.=$request->input('ID_'.$i).",";
        }
        
        $IDs=substr($IDs,0,strlen($IDs)-1);
        try {
            DB::insert("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
            createdby_id,updatedby_id,created_at,updated_at)
    
    select driverId,journal_date,null,amount,note,4,id,".Auth::user()->id.",".Auth::user()->id.",
    '".date("Y-m-d H:i:s")."' as created_at,'".date("Y-m-d H:i:s")."' as updated_at
    from gaps
    where gaps.id in(".$IDs.")
     ");
    } catch(\Illuminate\Database\QueryException $e ) {
        return redirect('/Gaps')->with('error',   $e->getPrevious()->getMessage());
    }        
        
try {
    DB::update("UPDATE gaps 
JOIN journal  ON (gaps.id = journal.post_id and journal.journal_type_id=4)
SET gaps.journal_id = journal.id
where gaps.id in(".$IDs.")
");
} catch(\Illuminate\Database\QueryException $e ) {
    return redirect('/Gaps')->with('error',   $e->getPrevious()->getMessage());
}
        return redirect('/Gaps')->with('success', 'Done successfully');
    
    }
    
}
