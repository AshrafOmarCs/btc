<?php

namespace App\Http\Controllers;

use App\CreditNotes;
use I18N_Arabic;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Drivers;
use App\Http\Controllers\HelperFunctionsController;

class FleetCreditNotesController extends Controller
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
        $user_id = Auth::user()->id;
        if (Auth::user()->user_type_id <> 1) {
            $users_privilege = DB::select('SELECT DISTINCT companyId from users_privilege
            INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId where companyId<>6 AND user_id=' . Auth::user()->id);
            foreach ($users_privilege as $users_privilegee) {
                //echo $users_privilegee->warehouseId;
                $whereIn_array[] = $users_privilegee->companyId;
            }
            if (count($whereIn_array) == 0) $whereIn_array[] = 0;
            $wher = " where lkp_company.status = 'active' AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND lkp_company.status = 'active' AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "where id <> 6 AND lkp_company.status = 'active'";
            $AND = "";
        }
        $lkp_company = DB::select("SELECT * from lkp_company $wher");
        $warehouse = DB::select('SELECT * from warehouse order by warehouseName');
        $users = DB::select('SELECT id,name from users order by name');


        $Select_db = DB::table('creditnotes')
            ->select('creditnotes.id as id', 'creditnotes.driverId', 'invoice_number', 'companyName', 'warehouseName', 'job_id', 'fullName', 'fullName_ar', 'iqama', 'mobileNumber',
            'journal_date', 'lkp_fleetCreditNotes.name as creditType', 'sms_push_attempts.attempts',
                DB::raw("TRIM(amount)+0 as amount"), 'note', 'creditnotes.updatedby_id', 'users.name',
                'creditnotes.created_at as created_at', 'creditnotes.updated_at as updated_at', 'journal_id', 'per_priod', 'cur_priod',
                DB::raw("
                if (period_start<>1,
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                 as journal_period")
            )

            ->leftJoin('sms_push_attempts', 'creditnotes.id', '=', 'sms_push_attempts.parent_reference')
            ->leftJoin('lkp_fleetCreditNotes', 'creditnotes.type', '=', 'lkp_fleetCreditNotes.id')
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

        $Select_db->whereRaw('creditnotes.type is not null');
        $Select_sum->whereRaw('creditnotes.type is not null');

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

        return view('new_porttal.FleetCreditNotes.index')->with(compact('users'))
            ->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    public function create()
    {
        $types = DB::select("SELECT * FROM lkp_fleetCreditNotes");
        return view('new_porttal.FleetCreditNotes.create')->with('types', $types);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $this->validate($request, [
            'driverId' => ['required'],
            'amount' => ['required'],
            'journal_date' => ['required'],
            'type' => ['required'],
        ]);
        $driver_id = $request->input('driverId');
        $type = $request->input('type');
        $date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $check_creditNote = DB::select("SELECT * from creditnotes where driverId = '$driver_id' AND journal_date = '$date'");
        if (count($check_creditNote) > 0)
            return redirect('New-Portal/FleetCreditNotes')->with('error', 'You have already added CreditNote for selected date and driver');

        $CreditNotes = new CreditNotes;
        $CreditNotes->driverId = $request->input('driverId');
        $CreditNotes->type = $request->input('type');
        $CreditNotes->journal_date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $CreditNotes->amount = $request->input('amount');
        $CreditNotes->note = $request->input('note');
        $CreditNotes->updatedby_id = Auth::user()->id;
        $CreditNotes->createdby_id = Auth::user()->id;
        $CreditNotes->save();
        $user = Drivers::where('id', $driver_id)->get();
        $iqama = $user[0]->iqama;
        $mobile = $user[0]->mobileNumber;
        $amount = $request->input('amount');
        $amount = number_format((float)$amount, 2, '.', '');
        $type = DB::select("SELECT name_ar FROM lkp_fleetCreditNotes WHERE id = '$type'");
        $note = $type[0]->name_ar;
        $creditId = $CreditNotes->id;
        if ($iqama != null AND $mobile != null) {
            $plate = $request->input('vehicle_name');
            $msg = "عزيزي حامل الهوية $iqama نود افادتكم تقييد مبلغ $amount على المركبة $plate وهو عبارة عن $note برقم CN$creditId, لمزيد من المعلومات الرجاء الاتصال بالرقم التالي: 8001210090.";
            $response = HelperFunctionsController::send_sms($msg, $mobile, $request->getClientIp());
            if ($response == 'success') {
                $status = 'sent';
            } else {
                $status = 'faild_attempt';
            }
            DB::table('sms_push_attempts')->insertGetId([
                'parent_reference' => $creditId,
                'attempts' => 1,
                'provider' => 'Yamamah',
                'status' => $status,
                'mobile' => $mobile,
                'msg_body' => $msg,
                'created_by' => $user_id,
                'updated_by' => $user_id,
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }
        if ($request->hasFile('files')) {
            $files = array();
            $directory = storage_path('app/public/FleetCreditNotes');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            foreach ($request->file('files') as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move($directory, $filename);
                $files[] = $filename;
            }
            $proof_file = implode(',', $files);
            DB::update("UPDATE creditnotes set proof_file = '$proof_file' WHERE id = '$creditId'");
        }
        return redirect('New-Portal/FleetCreditNotes')->with('success', 'Done successfully');
    }

    public function show($id)
    {
        $types = DB::select("SELECT * FROM lkp_fleetCreditNotes");
        $CreditNotes = DB::table('creditnotes')
            ->select('creditnotes.id as id', 'invoice_number', 'driverId', 'fullName', 'fullName_ar', 'journal_date', 'lkp_fleetCreditNotes.name as fleetCredit',
                'amount', 'note', 'creditnotes.updatedby_id', 'user_created.name as name_created','user_updated.name as name_updated',
                'creditnotes.created_at as created_at', 'creditnotes.updated_at as updated_at')
            ->leftJoin('lkp_fleetCreditNotes', 'creditnotes.type', '=', 'lkp_fleetCreditNotes.id')
            ->leftJoin('drivers', 'creditnotes.driverId', '=', 'drivers.id')
            ->leftJoin('users as user_created', 'creditnotes.createdby_id', '=', 'user_created.id')
            ->leftJoin('users as user_updated', 'creditnotes.updatedby_id', '=', 'user_updated.id')
            ->where('creditnotes.id', $id)
            ->first();
        return view('new_porttal.FleetCreditNotes.show')->with('CreditNotes', $CreditNotes)->with('types', $types);
    }

    public function edit($id)
    {
        $types = DB::select("SELECT * FROM lkp_fleetCreditNotes");

        $vehicles = DB::select("SELECT DISTINCT vehicles.plate FROM delegations INNER JOIN vehicles ON delegations.vehicle_id=vehicles.id join creditnotes ON creditnotes.driverId = delegations.driverId WHERE creditnotes.id='$id'");
        $CreditNotes = DB::table('creditnotes')
            ->select('creditnotes.id as id', 'creditnotes.driverId', 'fullName', 'fullName_ar', 'creditnotes.type as creditType',
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
            ->leftJoin('lkp_fleetCreditNotes', 'creditnotes.type', '=', 'lkp_fleetCreditNotes.id')
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
        return view('new_porttal.FleetCreditNotes.edit')->with(compact('CreditNotes', 'types', 'vehicles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => ['required'],
            'journal_date' => ['required'],
        ]);
        $CreditNotes = CreditNotes::find($id);
        if ($request->hasFile('files')) {
            $files = array();
            $directory = storage_path('app/public/FleetCreditNotes');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            foreach ($request->file('files') as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move($directory, $filename);
                $files[] = $filename;
            }
            $CreditNotes->proof_file = implode(',', $files);
        }
        $CreditNotes->driverId = $request->input('driverId');
        $CreditNotes->type = $request->input('type');
        $CreditNotes->journal_date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        //(empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $CreditNotes->amount = $request->input('amount');
        $CreditNotes->note = $request->input('note');
        $CreditNotes->updatedby_id = Auth::user()->id;
        $CreditNotes->save();
        return redirect('New-Portal/FleetCreditNotes')->with('success', 'Done successfully');
    }

    public function destroy($id)
    {
        $CreditNotes = CreditNotes::find($id);
        $CreditNotes->delete();
        return redirect('New-Portal/FleetCreditNotes')->with('success', 'Done successfully');
    }

    public function CreditNotesPost(Request $request)
    {
        // Collect IDs
        $IDs = [];
        for ($i = 0; $i < 105; $i++) {
            if (!empty($request->input('ID_' . $i))) {
                $IDs[] = $request->input('ID_' . $i);
            }
        }

        // If no IDs are found, return an error message
        if (empty($IDs)) {
            return redirect()->back()->with('error', 'No IDs provided.');
        }
        // Insert into journal table
        DB::beginTransaction();
        if (isset($request->delete)) {
            DB::delete("DELETE FROM creditnotes WHERE id IN (" . implode(',', array_fill(0, count($IDs), '?')) . ")", $IDs);
        } else {
            try {
                DB::insert("
                    INSERT INTO journal (
                        driverId, journal_date, debit, credit, note, journal_type_id, post_id,
                        createdby_id, updatedby_id, created_at, updated_at
                    )
                    SELECT
                        driverId, journal_date, amount, NULL, note, 11, id, ?, ?, ?, ?
                    FROM creditnotes
                    WHERE creditnotes.id IN (" . implode(',', array_fill(0, count($IDs), '?')) . ")
                ", array_merge(
                    [Auth::user()->id, Auth::user()->id, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")],
                    $IDs
                ));

            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect()->back()->with('error', $e->getPrevious()->getMessage());
            }

            try {
                // Update creditnotes table
                DB::update("
                    UPDATE creditnotes
                    JOIN journal ON (creditnotes.id = journal.post_id AND journal.journal_type_id = 11)
                    SET creditnotes.journal_id = journal.id
                    WHERE creditnotes.id IN (" . implode(',', array_fill(0, count($IDs), '?')) . ")
                ", $IDs);
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect()->back()->with('error', $e->getPrevious()->getMessage());
            }
        }
        DB::commit();
        return redirect()->back()->with('success', 'Done successfully');
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

        return view('new_porttal.FleetCreditNotes.print')->with(compact('CreditNotes'))->with(compact('number_to_text'));
    }

    public function smsInfo($refNo) {
        $sms_push_attempts = DB::select("SELECT sms_push_attempts.*,users.name,drivers.fullName FROM `sms_push_attempts` JOIN creditnotes ON creditnotes.id = sms_push_attempts.parent_reference
        JOIN users on users.id = sms_push_attempts.created_by JOIN drivers on drivers.id = creditnotes.driverId WHERE sms_push_attempts.parent_reference='".$refNo."'");
        $extra_data = array("fullname"=>null,"claim_rererance"=>$refNo);

        if(count($sms_push_attempts)>0){
             foreach($sms_push_attempts as $sms_push_attempt){
                 $updated_by = DB::select("select * from users where id=".$sms_push_attempt->updated_by." ");
                 if(count($updated_by)>0){
                     $sms_push_attempt->updated_by = $updated_by[0]->name;
                 }else{
                 }
                $extra_data['fullname'] = $sms_push_attempt->fullName;
            }
        }
        return view("new_porttal.FleetCreditNotes.smsInfo",compact('sms_push_attempts','extra_data'));
    }
}
