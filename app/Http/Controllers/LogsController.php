<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Controllers\HelperFunctionsController;
use DateTime;

class LogsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index_old(Request $request)
    {
        $logs = DB::select("SELECT tbl_events_log.*, users.name from tbl_events_log join users on tbl_events_log.done_by = users.id order by done_at DESC");
        return view('EventLogs.index')->with('logs', $logs);
    }
    
    public function index(Request $request)
    {
        $Select_db = DB::table('tbl_events_log')
        ->select('tbl_events_log.*', 'users.name', DB::raw('JSON_UNQUOTE(tbl_events_log.loan_ids) as decoded_loan_ids'))
        ->leftJoin('users', 'tbl_events_log.done_by', '=', 'users.id');

        
        if (request()->ajax()) {
            if (!empty($request->filter_type)) {
                $Select_db->whereRaw("action LIKE '%" . strtoupper($request->filter_type) . "%'");
            }
            if (!empty($request->filter_text)) {
                $Select_db->whereRaw("action LIKE '%" . strtoupper($request->filter_text) . "%'");
            }
            if (!empty($request->filter_done_at)) {
                $filter_done_at = explode(" - ", $request->filter_done_at);
                $Select_db->whereRaw("CAST(done_at as date) between STR_TO_DATE('$filter_done_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_done_at[1]','%d/%m/%Y')");
            }
             return  datatables()->of($Select_db)->make(true);
        }
        
        return view('EventLogs.index');
    }
    
    public function search(Request $request)
    {
        $filter_type = $request->filter_type;
        $filter_text = $request->filter_text;
        $filter_done_at = $request->filter_done_at;
        
        $clause_type = $clause_text = $clause_doneAt = "";
        if($filter_type != '') {
            $clause_type = " AND tbl_events_log.action like '%$filter_type%'";
        }
        if($filter_text != '') {
            $clause_text = " AND tbl_events_log.action like '%$filter_text%'";
        }
        if($filter_done_at != '') {
            $dateParts = explode(" - ", $filter_done_at);
            $startDate = DateTime::createFromFormat('d/m/Y', $dateParts[0])->format('Y-m-d') . " 00:00:00";
            $endDate = DateTime::createFromFormat('d/m/Y', $dateParts[1])->format('Y-m-d') . " 23:59:59";
            $clause_doneAt = " AND tbl_events_log.done_at between '$startDate' AND '$endDate'";
        }
        $logs = DB::select("SELECT tbl_events_log.*, users.name from tbl_events_log join users on tbl_events_log.done_by = users.id WHERE 1 = 1 $clause_type $clause_text $clause_doneAt order by done_at DESC");

        echo get_logs_table_body($logs);
        // echo ':::';
    }
    
    public function get(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $property = DB::select("SELECT btc_properties.*, lkp_properties_category.name as cat_name, lkp_properties_status.status FROM btc_properties INNER JOIN lkp_properties_category ON btc_properties.property_id=lkp_properties_category.id INNER JOIN lkp_properties_status ON btc_properties.status_id=lkp_properties_status.id WHERE btc_properties.id = '$id'");
        $categories = DB::select('SELECT * from lkp_properties_category');
        $status = DB::select('SELECT * from lkp_properties_status');
        $branches = DB::select("SELECT DISTINCT branches FROM btc_properties ORDER BY name");
        return view('PropertyIssuance.edit')->with('branches', $branches)->with('categories', $categories)->with('type', $type)->with('status', $status)->with('property', $property);
    }
    
    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $type = $request->type;
        $name = $request->name;
        $id = $request->id;
        $property_id = $request->property_id;
        $description = $request->description;
        $price = $request->price;
        $status_id = $request->status_id;
        DB::update("UPDATE btc_properties set property_id = '$property_id', name = '$name', description = '$description', price = '$price', status_id = '$status_id', updated_by = '$user_id', updated_at = NOW() WHERE id = '$id'");
        return redirect('Properties/index')->with('success', "Data Updated successfully");
    }
    public function delete($id)
    {
        DB::delete("DELETE FROM tbl_events_log WHERE id = '$id'");
        return redirect()->back()->with('success', "Data DELETED successfully");
    }
    
}

function get_logs_table_body($logs) {
    $no = 0;
    $response = '';
    foreach($logs as $log) {
        $response .= '<tr>
        <td>'.++$no.'</td>
        <td>'.$log->action.'</td>
        <td>'.$log->loan_ids.'</td>
        <td>'.$log->name.'</td>
        <td>'.$log->done_at.'</td>
        <td>
        </td>
        </tr>';
    }
    return $response;
}
