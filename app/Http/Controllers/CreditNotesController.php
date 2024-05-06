<?php

namespace App\Http\Controllers;

use App\CreditNotes;
use I18N_Arabic;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditNotesController extends Controller
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

        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT DISTINCT companyId from users_privilege
            INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId where companyId<>6 AND user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->companyId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where lkp_company.id in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "";
            $AND = "";
        }
        $lkp_company = DB::select("SELECT * from lkp_company $wher");
        $warehouse = DB::select('SELECT * from warehouse order by warehouseName');
        $users = DB::select('SELECT id,name from users order by name');


        $Select_db = DB::table('creditnotes')
            ->select('creditnotes.id as id', 'creditnotes.driverId', 'invoice_number', 'companyName', 'warehouseName', 'job_id', 'fullName', 'fullName_ar', 'journal_date',
                DB::raw("TRIM(amount)+0 as amount"), 'note', 'creditnotes.updatedby_id', 'name',
                'creditnotes.created_at as created_at', 'creditnotes.updated_at as updated_at', 'journal_id', 'per_priod', 'cur_priod',
                DB::raw("
                if (period_start<>1,
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                 as journal_period")
            )
            ->leftJoin('drivers', 'creditnotes.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('users', 'creditnotes.createdby_id', '=', 'users.id')
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

        $Select_sum = DB::table('creditnotes')
            ->select(DB::raw("TRIM(sum(amount))+0 as amount"))
            ->leftJoin('drivers', 'creditnotes.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('users', 'creditnotes.updatedby_id', '=', 'users.id')
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

        $whereIn_array = array();
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege where user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->warehouseId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $Select_db->whereIn('warehouseId', $whereIn_array);
            $Select_sum->whereIn('warehouseId', $whereIn_array);
        }

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
                $Select_db->where('creditnotes.driverId', $request->filter_driverId);
                $Select_sum->where('creditnotes.driverId', $request->filter_driverId);
            }
            if (!empty($request->filter_journal_date)) {
                $filter_journal_date = explode(" - ", $request->filter_journal_date);
                $Select_db->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_amount)) {
                $Select_db->where('amount', $request->filter_amount);
                $Select_sum->where('amount', $request->filter_amount);
            }
            if (!empty($request->filter_invoice_number)) {
                $Select_db->where('invoice_number', $request->filter_invoice_number);
                $Select_sum->where('invoice_number', $request->filter_invoice_number);
            }

            if (!empty($request->filter_note)) {
                $Select_db->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
                $Select_sum->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
            }


            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(creditnotes.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(creditnotes.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(creditnotes.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(creditnotes.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
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
                `creditnotes`.`journal_date`
            ) LIKE '%" . $options . "%'
            OR LOWER(`creditnotes`.`amount`) LIKE '%" . $options . "%'
            OR LOWER(`creditnotes`.`invoice_number`) LIKE '%" . $options . "%'
            OR LOWER(`creditnotes`.`note`) LIKE '%" . $options . "%'
            OR LOWER(`users`.`name`) LIKE '%" . $options . "%'
            OR LOWER(`creditnotes`.`updated_at`) LIKE '%" . $options . "%'
            OR LOWER(`creditnotes`.`journal_id`) LIKE '%" . $options . "%'
            OR LOWER(`creditnotes`.`updated_at`) LIKE '%" . $options . "%'
     )");
            }

            $Select_sum = $Select_sum->first();
            return datatables()->of($Select_db)
                ->with('amount', '<b>' . $Select_sum->amount . '</b>')
                ->make(true);
        }

        //$data = $Select_db->get();

        return view('CreditNotes.index')->with(compact('users'))
            ->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CreditNotes.create');
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
            'driverId' => ['required'],
            'amount' => ['required'],
            'journal_date' => ['required'],
        ]);


        /* $data = DB::select("select drivers.id,CreditNote_Letter,invoice_number from drivers
                                 INNER JOIN warehouse on warehouse.id=drivers.warehouseId
                                 INNER JOIN lkp_company on lkp_company.id=warehouse.companyId
                                 LEFT JOIN
                                 (
                                   select companyId,max(invoice_number)  AS invoice_number from creditnotes
                                   INNER JOIN drivers on drivers.id=creditnotes.driverId
                                   INNER JOIN warehouse on warehouse.id=drivers.warehouseId
                                   group by companyId
                                 )c on c.companyId=warehouse.companyId
                                 where drivers.id=" . $request->input('driverId'))[0];

         if (!empty($data->CreditNote_Letter)) {
             $invoice_number = substr($data->invoice_number, 2, -1);
             $invoice_number = $invoice_number + 1;
             $invoice_number = str_pad($invoice_number, 4, '0', STR_PAD_LEFT);
             $invoice_number = 'CR' . $invoice_number . $data->CreditNote_Letter;
         */
        $CreditNotes = new CreditNotes;
        $CreditNotes->driverId = $request->input('driverId');
        $CreditNotes->journal_date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        // (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $CreditNotes->amount = $request->input('amount');
        // $CreditNotes->invoice_number = $invoice_number;
        $CreditNotes->note = $request->input('note');
        $CreditNotes->updatedby_id = Auth::user()->id;
        $CreditNotes->createdby_id = Auth::user()->id;

        $CreditNotes->save();

        return redirect('/CreditNotes')->with('success', 'Done successfully');
        // } else
        //    return redirect('/CreditNotes')->with('error', 'Please complete company data');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $CreditNotes = DB::table('creditnotes')
            ->select('creditnotes.id as id', 'invoice_number', 'driverId', 'fullName', 'fullName_ar', 'journal_date',
                'amount', 'note', 'creditnotes.updatedby_id', 'user_created.name as name_created','user_updated.name as name_updated',
                'creditnotes.created_at as created_at', 'creditnotes.updated_at as updated_at')
            ->leftJoin('drivers', 'creditnotes.driverId', '=', 'drivers.id')
            ->leftJoin('users as user_created', 'creditnotes.createdby_id', '=', 'user_created.id')
            ->leftJoin('users as user_updated', 'creditnotes.updatedby_id', '=', 'user_updated.id')
            ->where('creditnotes.id', $id)
            ->first();

        return view('CreditNotes.show')->with('CreditNotes', $CreditNotes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $CreditNotes = DB::table('creditnotes')
            ->select('creditnotes.id as id', 'creditnotes.driverId', 'fullName', 'fullName_ar',
                DB::raw("DATE_FORMAT(journal_date,'%d/%m/%Y') as journal_date"), 'amount', 'note',
                'creditnotes.created_at as created_at', 'creditnotes.updated_at as updated_at', DB::raw("ifnull(per_priod,0) as per_priod"), DB::raw("ifnull(cur_priod,0) as cur_priod"),
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
            ->leftJoin('drivers', 'creditnotes.driverId', '=', 'drivers.id')
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
        from journal
        inner join drivers on drivers.id=journal.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        group by driverId,month_logged,cur_priod,next_priod,period_start,period_end)a
        group by driverId,per_priod,cur_priod,next_priod
        )balance"),
                'balance.driverId', '=', 'drivers.id')
            ->where('creditnotes.id', $id)
            ->first();
        return view('CreditNotes.edit')->with(compact('CreditNotes'));
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
            'amount' => ['required'],
            'journal_date' => ['required'],
        ]);


        $CreditNotes = CreditNotes::find($id);
        $CreditNotes->driverId = $request->input('driverId');
        $CreditNotes->journal_date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        //(empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $CreditNotes->amount = $request->input('amount');
        $CreditNotes->note = $request->input('note');
        $CreditNotes->updatedby_id = Auth::user()->id;


        $CreditNotes->save();

        return redirect('/CreditNotes')->with('success', 'Done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $CreditNotes = CreditNotes::find($id);

        $CreditNotes->delete();

        return redirect('/CreditNotes')->with('success', 'Done successfully');
    }

    public function CreditNotesPost(Request $request)
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

    select driverId,journal_date,amount,null,note,3,id," . Auth::user()->id . "," . Auth::user()->id . ",
    '" . date("Y-m-d H:i:s") . "' as created_at,'" . date("Y-m-d H:i:s") . "' as updated_at
    from creditnotes
    where creditnotes.id in(" . $IDs . ")
     ");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/CreditNotes')->with('error', $e->getPrevious()->getMessage());
        }

        try {
            DB::update("UPDATE creditnotes
JOIN journal  ON (creditnotes.id = journal.post_id and journal.journal_type_id=3)
SET creditnotes.journal_id = journal.id
where creditnotes.id in(" . $IDs . ")
");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/CreditNotes')->with('error', $e->getPrevious()->getMessage());
        }
        return redirect('/CreditNotes')->with('success', 'Done successfully');

    }

    public function CreditNotesPrint($id)
    {

        $CreditNotes = DB::select('select fullName,job_id,TRIM(amount)+0 as amount,invoice_number,companyFullName_en,companyFullName_ar,TaxNumber,CreditNote_Letter from creditnotes
                       INNER JOIN drivers on drivers.id=creditnotes.driverId
                       INNER JOIN warehouse on warehouse.id=drivers.warehouseId
                       INNER JOIN lkp_company on lkp_company.id=warehouse.companyId
                       where creditnotes.id=' . $id)[0];


        error_reporting(E_STRICT);
        $time_start = microtime(true);
        require(app_path() . '/Libraries/I18N/Arabic.php');
        $Arabic = new I18N_Arabic('Numbers');
        $number_to_text = $Arabic->money2str($CreditNotes->amount, 'SAR', 'ar');

        return view('CreditNotes.print')->with(compact('CreditNotes'))->with(compact('number_to_text'));
    }
}
