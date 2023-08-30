<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class JournalController extends Controller
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
        $lkp_journal_type = DB::select('SELECT * from lkp_journal_type ');
        $users = DB::select('SELECT id,name from users order by name');

          $Select_db = DB::table('journal')
            ->select(DB::raw("journal.id as id, driverId,companyName,warehouseName,job_id, drivers.fullName as fullName, fullName_ar, journal_date,
             TRIM(debit)+0 as debit,TRIM(credit)+0 as credit,note, journal.journal_type_id as journal_type_id,journal_type,post_id,
            journal.updatedby_id,
                journal.created_at as created_at, journal.updated_at as updated_at"))
            ->leftJoin('drivers', 'journal.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_journal_type', 'journal.journal_type_id', '=', 'lkp_journal_type.id')
            ->leftJoin('users', 'journal.updatedby_id', '=', 'users.id');

        $Select_sum = DB::table('journal')
            ->select(DB::raw("TRIM(sum(debit))+0 as debit,TRIM(sum(credit))+0 as credit"))
            ->leftJoin('drivers', 'journal.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_journal_type', 'journal.journal_type_id', '=', 'lkp_journal_type.id')
            ->leftJoin('users', 'journal.updatedby_id', '=', 'users.id');


        if (request()->ajax()) {
            if (!empty($request->filter_companyId)) {
                $Select_db->where('companyId', $request->filter_companyId);
                $Select_sum->where('companyId', $request->filter_companyId);
            }
            if (!empty($request->filter_Gap_Plus_Minus)) {
                if($request->filter_Gap_Plus_Minus==4.1) {
                    $Select_db->whereRaw('credit>0');
                    $Select_sum->whereRaw('credit>0');
                }
                elseif($request->filter_Gap_Plus_Minus==4.2) {
                    $Select_db->whereRaw('credit<0');
                    $Select_sum->whereRaw('credit<0');
                }
                elseif($request->filter_Gap_Plus_Minus==7.1) {
                    $Select_db->whereRaw('credit>0');
                    $Select_sum->whereRaw('credit>0');
                }
                elseif($request->filter_Gap_Plus_Minus==7.2) {
                    $Select_db->whereRaw('debit>0');
                    $Select_sum->whereRaw('debit>0');
                }
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
                $Select_db->where('journal.driverId', $request->filter_driverId);
                $Select_sum->where('journal.driverId', $request->filter_driverId);
            }
           if (!empty($request->filter_journal_date)) {
                $filter_journal_date = explode(" - ", $request->filter_journal_date);
                $Select_db->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_debit)) {
                $Select_db->where('debit', $request->filter_debit);
                $Select_sum->where('debit', $request->filter_debit);
            }
            if (!empty($request->filter_credit)) {
                $Select_db->where('credit', $request->filter_credit);
                $Select_sum->where('credit', $request->filter_credit);
            }
            if (!empty($request->filter_note)) {
                $Select_db->whereRaw("UPPER(note) LIKE '%". strtoupper($request->filter_note)."%'");
                $Select_sum->whereRaw("UPPER(note) LIKE '%". strtoupper($request->filter_note)."%'");
            }
            if (!empty($request->filter_journal_type_id)) {
                $Select_db->where('journal_type_id', $request->filter_journal_type_id);
                $Select_sum->where('journal_type_id', $request->filter_journal_type_id);
            }

            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(journal.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(journal.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(journal.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(journal.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }

            if(isset($_REQUEST['search']['value'])&&$_REQUEST['search']['value']<>'') {
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
            OR LOWER(`journal`.`journal_date`) LIKE '%" . $options . "%'
            OR LOWER(`journal`.`debit`) LIKE '%" . $options . "%'
            OR LOWER(`journal`.`credit`) LIKE '%" . $options . "%'
            OR LOWER(`journal`.`note`) LIKE '%" . $options . "%'
            OR LOWER(
                `lkp_journal_type`.`journal_type`
            ) LIKE '%" . $options . "%'
            OR LOWER(`journal`.`created_at`) LIKE '%" . $options . "%'
           )");
            }

            $Select_sum = $Select_sum->first();
            return datatables()->of($Select_db)
                ->with('debit', '<b>' . $Select_sum->debit . '</b>')
                ->with('credit', '<b>' . $Select_sum->credit . '</b>')
                ->make(true);
        }

        //$data = $Select_db->get();

        return view('Journal.index')->with(compact('lkp_journal_type'))->with(compact('users'))
        ->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        $Journal = DB::table('journal')
        ->select('journal.id as id', 'driverId', 'fullName', 'fullName_ar', 'journal_date',
             'amount','note', 'journal.status_id as status_id','journal_status',
            'updatedby_id','name','updated_usertypeid','user_type',
                'journal.created_at as created_at', 'journal.updated_at as updated_at')
            ->leftJoin('drivers', 'journal.driverId', '=', 'drivers.id')
            ->leftJoin('lkp_journal_status', 'journal.status_id', '=', 'lkp_journal_status.id')
            ->leftJoin('users', 'journal.updatedby_id', '=', 'users.id')
            ->leftJoin('lkp_updated_usertype', 'journal.updated_usertypeid', '=', 'lkp_updated_usertype.id')
            ->where('journal.id', $id)
            ->first();

        return view('Journal.show')->with('Journal', $Journal);
    }





}
