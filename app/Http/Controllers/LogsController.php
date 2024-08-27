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

function get_log_table_body($payload)
{
    $data = [];
    $no = 0;
    foreach ($payload as $k=>$item) {
        // <li>
        //     <a id="'.$item->id.'" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view dropdown-item" href="#">View</a>
        // </li>
        $action = '<div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">
            Action
            </button>
            <ul class="dropdown-menu">
                <li>
                    <hr class="dropdown-divider">
                </li>
            </ul>
        </div>';
        $data[] = [
            'id' => ++$no,
            'action' => $item->action,
            'decoded_loan_ids' => $item->decoded_loan_ids,
            'name' => $item->name,
            'done_at' => $item->done_at,
            'actions' => $action,
        ];
    }
    return $data;
}
class LogsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $sql = "SELECT tbl_events_log.*, users.name, JSON_UNQUOTE(tbl_events_log.loan_ids) AS decoded_loan_ids FROM tbl_events_log LEFT JOIN users ON tbl_events_log.done_by = users.id WHERE 1 = 1";
            if (!empty($request->filter_type)) {
                $sql .= " AND action LIKE '%" . strtoupper($request->filter_type) . "%'";
            }
            if (!empty($request->filter_text)) {
                $sql .= " AND action LIKE '%" . strtoupper($request->filter_text) . "%'";
            }
            if (!empty($request->filter_done_at)) {
                $filter_done_at = explode(" - ", $request->filter_done_at);
                $sql .= " AND CAST(done_at as date) between STR_TO_DATE('$filter_done_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_done_at[1]','%d/%m/%Y')";
            }

            $payload = DB::select($sql);
            $totalData = count($payload);

            $columns = ['id', 'action', 'loan_ids', 'name', 'done_at'];
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $search = $request->input('search.value');
            if (!empty($search)) {
                $search_sql = $sql . " AND (tbl_events_log.action LIKE '%$search%'
                    OR loan_ids LIKE '%$search%'
                    OR users.name LIKE '%$search%'
                    OR tbl_events_log.done_at LIKE '%$search%')";
                $filtered_payload = DB::select($search_sql);
                $totalFiltered = count($filtered_payload);

                $search_sql .= " ORDER BY tbl_events_log.id $dir LIMIT $start, $limit";
                $payload = DB::select($search_sql);
            } else {
                $totalFiltered = $totalData;
                $sql .= " ORDER BY $order $dir LIMIT $start, $limit";
                $payload = DB::select($sql);
            }
            $response = array();
            $response = get_log_table_body($payload);
            $jsonResponse = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $response,
            ];
            return response()->json($jsonResponse);
        }
        return view('new_porttal.EventLogs.index');
    }
    public function index_dd(Request $request)
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

        return view('new_porttal.EventLogs.index');
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

