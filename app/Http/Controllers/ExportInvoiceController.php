<?php

namespace App\Http\Controllers;
use I18N_Arabic;
use App\ExportInvoice;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ExportInvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index(Request $request)
    {
        $lkp_journal_period = DB::select("SELECT id,CONCAT(period_from_dt,' - ',period_to_dt) AS period
        from lkp_journal_period where companyId=1 order by period_from_dt DESC");

        $where = array();

        if (!empty($request->filter_Period)) {
            $where[] = 'period_id=' . $request->filter_Period;
        }

        $where2 = implode(" AND ", $where);
        if (count($where) > 0) {
            $where2 = " where " . $where2;
        }

        $query = "select a.New_warehouseId,New_warehouseName,under_noon_id,a.period_id,period,
                SUM(No_of_TouchPoint) as No_of_TouchPoint,
                invoice_number,invoice_sequence_no,
                TRIM(unit_cost)+0 as unit_cost,CONCAT(TRIM(vat)+0,'%') as vat,
                TRIM(ROUND(SUM(No_of_TouchPoint)*unit_cost,2))+0 as amount,
                TRIM(ROUND(SUM(No_of_TouchPoint)*unit_cost*vat/100,2))+0 as vat_amount,
                TRIM(ROUND((SUM(No_of_TouchPoint)*unit_cost)+(SUM(No_of_TouchPoint)*unit_cost*vat/100),2))+0 as total_amount,
                print FROM
                (
                select
                IF(under_noon_id=1,0,warehouseId) AS New_warehouseId,
                IF(under_noon_id=1,'Noon',warehouseName) AS New_warehouseName,
                under_noon_id,period_id,CONCAT(period_from_dt,' - ',period_to_dt) AS period,No_of_TouchPoint,
                IF(period_from_dt>='2020-07-21',1,0) AS print
                from noon_pack
                INNER JOIN lkp_journal_period on lkp_journal_period.id=noon_pack.period_id
                INNER JOIN drivers on drivers.id=noon_pack.driverId
                INNER JOIN warehouse on warehouse.id=drivers.warehouseId
                WHERE lkp_journal_period.companyId=1
                )a
                LEFT JOIN export_inov on export_inov.New_warehouseId=a.New_warehouseId AND export_inov.period_id=a.period_id
                GROUP BY New_warehouseId,New_warehouseName,under_noon_id,period_id,period
                ORDER BY period DESC,New_warehouseName";


        $Select_db = DB::table(DB::raw("(" . $query . ") as sub"));

        $sum = DB::table(DB::raw("(" . $query . ") as sub"))
            ->select(DB::raw("
             count(*) AS CO,
             TRIM(sum(IFNULL(No_of_TouchPoint,0)))+0 as No_of_TouchPoint,
            TRIM(ROUND(sum(IFNULL(amount,0)),2))+0 as amount,
            TRIM(ROUND(sum(IFNULL(vat_amount,0)),2))+0 as vat_amount,
            TRIM(ROUND(sum(IFNULL(total_amount,0)),2))+0 as total_amount
             "));

        if (request()->ajax()) {
            if (!empty($request->filter_Period)) {
                $Select_db->where('period_id', $request->filter_Period);
                $sum->where('period_id', $request->filter_Period);
            }

            if (isset($_REQUEST['search']['value']) && $_REQUEST['search']['value'] <> '') {
                $options = strtolower($_REQUEST['search']['value']);
                $sum->whereRaw("(
            LOWER( `period`) LIKE '%" . $options . "%'
            OR LOWER(`New_warehouseName`) LIKE '%" . $options . "%'
            OR LOWER(`No_of_TouchPoint`) LIKE '%" . $options . "%'
             OR LOWER(`invoice_number`) LIKE '%" . $options . "%'
            )");
            }
            $sum = $sum->first();
            return datatables()->of($Select_db)
                ->with('No_of_TouchPoint', '<b>' . $sum->No_of_TouchPoint . '</b>')
                ->with('amount', '<b>' . $sum->amount . '</b>')
                ->with('vat_amount', '<b>' . $sum->vat_amount . '</b>')
                ->with('total_amount', '<b>' . $sum->total_amount . '</b>')
                ->setTotalRecords($sum->CO)
                ->make(true);
        }

        return view('ExportInvoice.index')->with(compact('lkp_journal_period'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */

    public function ExportInvoicePrint($New_warehouseId, $period_id)
    {


        $export_inov = collect(DB::select("select invoice_sequence_no from export_inov where New_warehouseId=" . $New_warehouseId .
            " AND period_id=" . $period_id))->first();
        if (!$export_inov) {
            $lkp_company = collect(DB::select("select company_unit_cost,company_vat from lkp_company where id=1"))->first();
            $vat=$lkp_company->company_vat;

            $export_inov_max = collect(DB::select("select max(invoice_sequence_no) as invoice_sequence_no from export_inov
            where New_warehouseId=" . $New_warehouseId))->first();
            $invoice_sequence_no = $export_inov_max->invoice_sequence_no + 1;
            $invoice_sequence_no = str_pad($invoice_sequence_no, 3, '0', STR_PAD_LEFT);
            if ($New_warehouseId <> '0') {
                $warehouse = collect(DB::select("select warehouseName,warehouse_unit_cost from warehouse where companyId=1 AND id=" . $New_warehouseId))->first();
                $invoice_number = strtoupper($warehouse->warehouseName).'/INV'.$invoice_sequence_no;
                $unit_cost=$warehouse->warehouse_unit_cost;
            }
            else {
                $unit_cost=$lkp_company->company_unit_cost;
                $invoice_number = 'INV' . $invoice_sequence_no;
            }
            DB::table('export_inov')->insert(
                [
                    'New_warehouseId' => $New_warehouseId,
                    'period_id' => $period_id,
                    'invoice_number' => $invoice_number,
                    'invoice_sequence_no' => $invoice_sequence_no,
                    'unit_cost' => $unit_cost,
                    'vat' => $vat,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),

                ]
            );
        }

        $data = DB::select("
                select a.New_warehouseId,New_warehouseName,under_noon_id,a.period_id,period,SUM(No_of_TouchPoint) as No_of_TouchPoint,invoice_number,invoice_sequence_no,
                TRIM(unit_cost)+0 as unit_cost,CONCAT(TRIM(vat)+0,'%') as vat,
                TRIM(ROUND(SUM(No_of_TouchPoint)*unit_cost,2))+0 as amount,
                TRIM(ROUND(SUM(No_of_TouchPoint)*unit_cost*vat/100,2))+0 as vat_amount,
                TRIM(ROUND((SUM(No_of_TouchPoint)*unit_cost)+(SUM(No_of_TouchPoint)*unit_cost*vat/100),2))+0 as total_amount
                FROM
                (
                select
                IF(under_noon_id=1,0,warehouseId) AS New_warehouseId,
                IF(under_noon_id=1,'Noon',warehouseName) AS New_warehouseName,
                under_noon_id,period_id,CONCAT(period_from_dt,' - ',period_to_dt) AS period,No_of_TouchPoint from noon_pack
                INNER JOIN lkp_journal_period on lkp_journal_period.id=noon_pack.period_id
                INNER JOIN drivers on drivers.id=noon_pack.driverId
                INNER JOIN warehouse on warehouse.id=drivers.warehouseId
                WHERE lkp_journal_period.companyId=1
                and period_id=".$period_id."
                )a
                LEFT JOIN export_inov on export_inov.New_warehouseId=a.New_warehouseId AND export_inov.period_id=a.period_id
                where a.New_warehouseId=".$New_warehouseId."
                GROUP BY New_warehouseId,New_warehouseName,under_noon_id,period_id,period
                ORDER BY period DESC,New_warehouseName
        ")[0];

        error_reporting(E_STRICT);
        require(app_path() . '/Libraries/I18N/Arabic.php');
        $Arabic = new I18N_Arabic('Numbers');
        $number_to_text = $Arabic->money2str($data->total_amount, 'SAR', 'ar');



        return view('ExportInvoice.print')->with(compact('data'))->with(compact('number_to_text'));
    }


}
