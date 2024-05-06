<?php

namespace App\Http\Controllers;

use App\Settlements;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SettlementsController extends Controller
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


        $Select_db = DB::table('settlements')
            ->select('settlements.id as id', 'settlements.driverId', 'companyName', 'warehouseName', 'job_id', 'fullName', 'fullName_ar', 'journal_date',
                DB::raw("TRIM(debit)+0 as debit,TRIM(credit)+0 as credit"), 'note', 'settlements.updatedby_id', 'name',
                'settlements.created_at as created_at', 'settlements.updated_at as updated_at', 'journal_id', 'per_priod', 'cur_priod',
                DB::raw("
                if (period_start<>1,
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                 as journal_period")
            )
            ->leftJoin('drivers', 'settlements.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('users', 'settlements.updatedby_id', '=', 'users.id')
            ->leftJoin(DB::raw("(SELECT
            driverId,
            TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,
            TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod


           from

        (select driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
               date_format(journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m') AS cur_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod
        from journal
        inner join drivers on drivers.id=journal.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
        group by driverId,per_priod,cur_priod,next_priod
        )balance"),
                'balance.driverId', '=', 'drivers.id');

        $Select_sum = DB::table('settlements')
            ->select(DB::raw("TRIM(sum(debit))+0 as debit,TRIM(sum(credit))+0 as credit"))
            ->leftJoin('drivers', 'settlements.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('users', 'settlements.updatedby_id', '=', 'users.id')
            ->leftJoin(DB::raw("(SELECT
            driverId,
            TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,
            TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod


           from

        (select driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
               date_format(journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m') AS cur_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod
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
                $Select_db->where('settlements.driverId', $request->filter_driverId);
                $Select_sum->where('settlements.driverId', $request->filter_driverId);
            }
            if (!empty($request->filter_journal_date)) {
                $filter_journal_date = explode(" - ", $request->filter_journal_date);
                $Select_db->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_credit)) {
                $Select_db->where('credit', $request->filter_credit);
                $Select_sum->where('credit', $request->filter_credit);
            }
            if (!empty($request->filter_debit)) {
                $Select_db->where('debit', $request->filter_debit);
                $Select_sum->where('debit', $request->filter_debit);
            }
            if (!empty($request->filter_note)) {
                $Select_db->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
                $Select_sum->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
            }


            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(settlements.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(settlements.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(settlements.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(settlements.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_post)) {
                if ($request->filter_post == 1) {
                    $Select_db->whereRaw("journal_id is not null");
                    $Select_sum->whereRaw("journal_id is not null");
                } elseif ($request->filter_post == 2) {
                    $Select_db->whereRaw("journal_id is null");
                    $Select_sum->whereRaw("journal_id is null");
                }
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
            OR LOWER(`drivers`.`job_id`) LIKE '%" . $options . "%'
            OR LOWER(`drivers`.`fullName`) LIKE '%" . $options . "%'
            OR LOWER(`balance`.`per_priod`) LIKE '%" . $options . "%'
            OR LOWER(`balance`.`cur_priod`) LIKE '%" . $options . "%'
            OR LOWER(
                `settlements`.`journal_date`
            ) LIKE '%" . $options . "%'
            OR LOWER(`settlements`.`credit`) LIKE '%" . $options . "%'
            OR LOWER(`settlements`.`debit`) LIKE '%" . $options . "%'
            OR LOWER(`settlements`.`note`) LIKE '%" . $options . "%'
            OR LOWER(`users`.`name`) LIKE '%" . $options . "%'
            OR LOWER(`settlements`.`updated_at`) LIKE '%" . $options . "%'
            OR LOWER(`settlements`.`journal_id`) LIKE '%" . $options . "%'
            OR LOWER(`settlements`.`journal_id`) LIKE '%" . $options . "%'
     )");
            }

            $Select_sum = $Select_sum->first();
            return datatables()->of($Select_db)
                ->with('debit', '<b>' . $Select_sum->debit . '</b>')
                ->with('credit', '<b>' . $Select_sum->credit . '</b>')
                ->make(true);
        }

        //$data = $Select_db->get();

        return view('Settlements.index')->with(compact('users'))
            ->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Settlements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'amount' => ['required'],
            'journal_date' => ['required'],
        ]);


        DB::table('settlements')->insert(
            [
                'driverId' => $request->input('driverId'),
                'journal_date' => ( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d'),
                'credit' => $request->input('credit'),
                'debit' => $request->input('debit'),
                'note' => $request->input('note'),
                'updatedby_id' => Auth::user()->id,
                'createdby_id' => Auth::user()->id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),

            ]
        );
        /* $Settlements = new Settlements;
         $Settlements->driverId = $request->input('driverId');
         $Settlements->journal_date = $journal_date;
         //( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
         $Settlements->credit = $request->input('credit');
         $Settlements->debit = $request->input('debit');
         $Settlements->note = $request->input('note');
         $Settlements->updatedby_id = Auth::user()->id;
         $Settlements->createdby_id = Auth::user()->id;

         $Settlements->save();
        */
        return redirect('/Settlements')->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Settlements = DB::table('settlements')
            ->select('settlements.id as id', 'driverId', 'fullName', 'fullName_ar', 'journal_date',
                'credit', 'debit', 'note', 'settlements.updatedby_id', 'name',
                'settlements.created_at as created_at', 'settlements.updated_at as updated_at')
            ->leftJoin('drivers', 'settlements.driverId', '=', 'drivers.id')
            ->leftJoin('users', 'settlements.updatedby_id', '=', 'users.id')
            ->where('settlements.id', $id)
            ->first();

        return view('Settlements.show')->with('Settlements', $Settlements);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $Settlements = DB::table('settlements')
            ->select('settlements.id as id', 'settlements.driverId', 'fullName', 'fullName_ar',
                DB::raw("DATE_FORMAT(journal_date,'%d/%m/%Y') as journal_date"), 'credit', 'debit', 'note',
                'settlements.created_at as created_at', 'settlements.updated_at as updated_at', DB::raw("ifnull(per_priod,0) as per_priod"), DB::raw("ifnull(cur_priod,0) as cur_priod"),
                DB::raw("if (period_start<>1,CONCAT(date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', LPAD(period_start, 2, '0'),' - ',date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                CONCAT(date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'), '-', LPAD(period_start, 2, '0'),' - ',date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')))as per_range"),
                DB::raw("if (period_start<>1,CONCAT(date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m'), '-', LPAD(period_start, 2, '0'),' - ',date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                 CONCAT(date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m'), '-', LPAD(period_start, 2, '0'),' - ',date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m'),'-', LPAD(period_end, 2, '0')))as cur_range"),
                DB::raw("
            if (period_start<>1,
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                 as journal_period")
            )
            ->leftJoin('drivers', 'settlements.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin(DB::raw("(SELECT
            driverId,
            TRIM(sum( if( month_logged <= per_priod, credit-debit, 0 ) ))+0 AS per_priod,
            TRIM(sum( if( month_logged >= cur_priod, credit-debit, 0 ) ))+0 AS cur_priod


           from

        (select driverId,period_start,period_end,sum(IFNULL(credit,0)) as credit,sum(IFNULL(debit,0)) as debit,
               date_format(journal_date - interval period_start-1 day, '%Y-%m') AS month_logged,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day - INTERVAL 1 MONTH, '%Y-%m') AS per_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day , '%Y-%m') AS cur_priod,
               date_format('" . date("Y-m-d H:i:s") . "' - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m') AS next_priod
       from drivers
        left join journal on journal.driverId=drivers.id
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
        group by driverId,per_priod,cur_priod,next_priod
        )balance"),
                'balance.driverId', '=', 'drivers.id')
            ->where('settlements.id', $id)
            ->first();
        return view('Settlements.edit')->with(compact('Settlements'));
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
        $this->validate($request, [
            //'amount' => ['required'],
            'journal_date' => ['required'],
        ]);



        DB::table('settlements')
            ->where('id', $id)
            ->update([
                'driverId' => $request->input('driverId'),
                'journal_date' =>( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d'),
                'credit' => $request->input('credit'),
                'debit' => $request->input('debit'),
                'note' => $request->input('note'),
                'updatedby_id' => Auth::user()->id,
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

        /*$Settlements = Settlements::find($id);
        $Settlements->driverId = $request->input('driverId');
        $Settlements->journal_date = $journal_date;
        //( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $Settlements->credit = $request->input('credit');
        $Settlements->debit = $request->input('debit');
        $Settlements->note = $request->input('note');
        $Settlements->updatedby_id = Auth::user()->id;


        $Settlements->save();
        */

        return redirect('/Settlements')->with('success', 'Done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $Settlements = Settlements::find($id);

        $Settlements->delete();

        return redirect('/Settlements')->with('success', 'Done successfully');
    }

    public function SettlementsPost(Request $request)
    {
        $IDs = '';
        for ($i = 0; $i < 105; $i++) {
            if (!empty($request->input('ID_' . $i))) {
                $IDs .= $request->input('ID_' . $i) . ",";
            }
        }

        $IDs = substr($IDs, 0, strlen($IDs) - 1);
        try {
            DB::insert("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
            createdby_id,updatedby_id,created_at,updated_at)

    select driverId,journal_date,debit,credit,note,7,id," . Auth::user()->id . "," . Auth::user()->id . ",
    '" . date("Y-m-d H:i:s") . "' as created_at,'" . date("Y-m-d H:i:s") . "' as updated_at
    from settlements
    where settlements.id in(" . $IDs . ")
     ");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/Settlements')->with('error', $e->getPrevious()->getMessage());
        }

        try {
            DB::update("UPDATE settlements
JOIN journal  ON (settlements.id = journal.post_id and journal.journal_type_id=7)
SET settlements.journal_id = journal.id
where settlements.id in(" . $IDs . ")
");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/Settlements')->with('error', $e->getPrevious()->getMessage());
        }
        return redirect('/Settlements')->with('success', 'Done successfully');

    }

}
