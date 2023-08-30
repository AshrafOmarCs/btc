<?php

namespace App\Http\Controllers;

use App\Loans;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PHPExcel_IOFactory;

function get_user_name($user_id)
{
    $row = DB::select("SELECT name from users WHERE id = '$user_id'");
    return $row[0]->name;
}
function get_table_body($data) {
    $body = '';
    $i = $amount_total = 0 ;
    $check = $btn = 0;
    foreach($data as $row) {
        $exported_by = $row->exported_by;
        $exported_name = '';
        if ($exported_by > 0)
            $exported_name = '(' . get_user_name($exported_by).')';
        $status = $row->status;
        $color = '';
        $disabled = '';
        $class = '';
        if($status == 'Ready') {
            $check = 1;
            $color = 'green';
            $disabled = 'disabled';
            $class = '';
        }
        else if($status == 'Onhold'){
            if($exported_by == Auth::user()->id OR Auth::user()->id == 73 OR Auth::user()->id == 15)
                $btn = "1";
            $color = 'orange';
            $disabled = '';
            $class = 'check-status';
        }
        else if($status == 'Paid') {
            $color = 'Blue';
            $disabled = 'disabled';
            $class = '';
        }
        
        $body .= '<tr>';
        $body .= '<td>'.$row->created_at.'</td>';
        $body .= '<td>'.$row->companyName.'</td>';
        $body .= '<td>'.$row->warehouseName.'</td>';
        $body .= '<td>'.$row->job_id.'</td>';
        $body .= '<td><a href="javascript:driver(' . $row->driverId . ')">' . $row->fullName . '</a></td>';

        $body .= '<td>'.$row->per_priod.'</td>';
        $body .= '<td>'.$row->cur_priod.'</td>';
        $body .= '<td>'.$row->journal_date.'</td>';
        $body .= '<td>'.$row->journal_period.'</td>';
        $body .= '<td>'.$row->amount.'</td>';
        $amount_total += $row->amount;
        if ($disabled == 'disabled')
            $body .= '<td style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="">&nbsp;'.$status .'<span style="color: black !important">'.$exported_name.'</span></td>';
        else
            $body .= '<td style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="' . $row->id . '">&nbsp;'.$status .'<span style="color: black !important">'.$exported_name.'</span></td>';
        $body .= '<td>'.$row->note.'</td>';
        if ($row->status_id == "1") {
            $body .= '<td><span class="label label-warning">' . $row->loan_status . '</span></td>';
        } else if ($row->status_id == "2") {
            $body .= '<td><span class="label label-danger">' . $row->loan_status . '</span></td>';
        } else if ($row->status_id == "3") {
            $body .= '<td><span class="label label-primary">' . $row->loan_status . '</span></td>';
        } else if ($row->status_id == "4") {
            $body .= '<td><span class="label label-success">' . $row->loan_status . '</span></td>';
        } else if ($row->status_id == "5") {
            $body .= '<td><span class="label label-info">' . $row->loan_status . '</span></td>';
        }

        $body .= '<td>'.$row->account_owner_iqama.'</td>';
        $body .= '<td>'.$row->accountNumber.'</td>';
        if ($row->updated_usertypeid == "4") {
            $body .= '<td></td>';
        } else {
            $body .= '<td>'.$row->name.'</td>';
        }

        
        $body .= '<td>'.$row->updated_at.'</td>';
        $body .= '<td>';
        if ($row->status_id != "4") {
            $body .= '<a id=' . $row->id . ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>';
            $body .= '&nbsp;<a id=' . $row->id . ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>';
        }
        $body .= '&nbsp;<a id=' . $row->id . ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';
        if ($row->status_id == "3" || $row->status_id == "5")
            $body .= '&nbsp;<button id=' . $row->id . ' type="button" class="btn btn-primary btn-xs updatePaid">Paid</button>';
        $body .= '</td>';
        $body .= '</tr>';
        $i++;
    }
    $response['body'] = $body;
    $response['amount_total'] = $amount_total;
    $response['check'] = $check;
    $response['btn'] = $btn;

    return $response;

}



class LoansSheController extends Controller
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
    public function goToReady(Request $request) {
        $ready_statuss = $request->ready_statuss;
        $loan_ids = explode(",",$ready_statuss);
        $user = Auth::user(); // Assuming you're using Laravel's built-in authentication
        $user_id = $user->id;
        if (password_verify($request->input('password'), $user->password)) {
            foreach($loan_ids as $loan_id) {
                DB::update("Update loan set status = 'Ready', exported_by = '0', updated_by = '$user_id', updated_at = NOW() where id = '$loan_id'");
            }
            return redirect('/LoansShe')->with('success', "Status updated successfully");
        } else {
            // Password is incorrect
            return redirect('/LoansShe')->with('error', "Password is incorrect");
        }
    }
    public function index(Request $request)
    {
        if (request()->ajax()) {
            // die;
            $Select_db = DB::table('loan')
            ->select('loan.exported_by','loan.status','loan.id as id','loan.loan_type as loan_type', 'companyName', 'loan.driverId', 'fullName', 'warehouseName', 'job_id',
                DB::raw("account_owner_iqama,
                CASE
                    WHEN
                    account_owner_iqama IS NOT NULL
                    AND account_owner_iqama REGEXP '^[0-9]+$'
                    AND LENGTH(account_owner_iqama) = 10
                    AND SUBSTR(account_owner_iqama, 1, 1) in('1','2')
                    THEN 'Yes'
                    ELSE 'No'
                END AS account_owner_iqama_check,
                CASE
                    WHEN
                    accountNumber IS NOT NULL
                    AND accountNumber REGEXP '^[0-9]+$'
                    AND LENGTH(accountNumber) = 12
                    AND SUBSTR(accountNumber, 1, 3) =('966')
                    THEN 'Yes'
                    ELSE 'No'
                END AS accountNumber_check
                "), 'journal_date',
                'amount', 'note', 'loan.status_id as status_id', 'loan_status', 'bank_name_en', 'accountNumber',
                'loan.updatedby_id', 'name', 'updated_usertypeid', 'user_type',
                'loan.created_at as created_at', 'loan.updated_at as updated_at', 'per_priod', 'cur_priod',
                DB::raw("
                if (period_start<>1,
                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                    ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                    ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                    as journal_period")
            )
            ->leftJoin('drivers', 'loan.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_bank', 'drivers.bank_id', '=', 'lkp_bank.id')
            ->leftJoin('lkp_loan_status', 'loan.status_id', '=', 'lkp_loan_status.id')
            ->leftJoin('users', 'loan.createdby_id', '=', 'users.id')
            ->leftJoin('lkp_user_type', 'loan.createdby_id', '=', 'lkp_user_type.id')
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
            }
        

            if (!empty($request->filter_companyId)) {
                $Select_db->whereRaw('companyId=' . $request->filter_companyId);
            }
            if (!empty($request->filter_warehouseId)) {
                $Select_db->whereRaw('warehouseId=' . $request->filter_warehouseId);
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->whereRaw('loan.driverId=' . $request->filter_driverId);
            }
            if (!empty($request->filter_journal_date)) {
                $filter_journal_date = explode(" - ", $request->filter_journal_date);
                $Select_db->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_amount)) {
                $Select_db->whereRaw('amount=' . $request->filter_amount);
            }
            if (!empty($request->filter_status_id)) {
                $Select_db->whereRaw('loan.status_id=' . $request->filter_status_id);
            }
            if (!empty($request->filter_Loan_type)) {
                if($request->filter_Loan_type == 'FL'){
                    $whereIn_array = array();
                    $whereIn_array = ['fuel_loan'];
                    // $Select_db->where('loan_type', 'fuel_loan'); 
                    $Select_db->whereRaw('loan.loan_type=' . '"fuel_loan"');

                }elseif($request->filter_Loan_type == 'PL'){
                    $whereIn_array = array();
                    $whereIn_array = ['personal_loan'];
                    $Select_db->whereRaw('loan.loan_type=' . '"personal_loan"');
                    // $Select_db->whereIn('loan_type', $whereIn_array); 
                }
            }
            // ashraf condition for fuel loans
            if (!empty($request->filter_note)) {
                $Select_db->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
                $Select_sum->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
            }
            if (!empty($request->filter_updatedby_id)) {
                $Select_db->whereRaw('updatedby_id=' . $request->filter_updatedby_id);
            }
            if (!empty($request->filter_updated_usertypeid)) {
                $Select_db->whereRaw('updated_usertypeid=' . $request->filter_updated_usertypeid);
            }
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(loan.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(loan.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }
            $data = $Select_db->get();
            $response = get_table_body($data);
            echo $response['body'];
            echo ':::';
            echo $response['amount_total'];
            echo ':::';
            echo $response['check'];
            echo ':::';
            echo $response['btn'];
            echo ':::';
            echo $Select_db->toSql();
        } else {
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
            $lkp_loan_status = DB::select('SELECT * from lkp_loan_status ');
            $users = DB::select('SELECT id,name from users order by name');
            $lkp_user_type = DB::select('SELECT * from lkp_user_type'); 
            return view('Loans.index_she')->with(compact('lkp_loan_status'))
                ->with(compact('users'))->with(compact('lkp_user_type'))->with(compact('lkp_company'))->with(compact('warehouse'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Auth::user()->user_type_id <> 1) {
            $AND = " AND id=5 ";
        } else {
            $AND = "";
        }
        $lkp_loan_status = DB::select("SELECT * from lkp_loan_status where id<>4" . $AND);

        
        return view('Loans.create')->with(compact('lkp_loan_status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //return ( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $this->validate($request, [
            'driverId' => ['required'],
            'amount' => ['required'],
            'journal_date' => ['required'],
        ]);
        $driver_id = $request->input('driverId');
        $date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $check_loan = DB::select("SELECT * from loan where driverId = '$driver_id' AND journal_date = '$date'");
        if (count($check_loan) > 0)
            return redirect('/Loans')->with('error', 'You have already added loan for selected date and driver');

        $Loans = new Loans;
        $Loans->driverId = $request->input('driverId');
        $Loans->journal_date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        // ( empty($request->input('journal_date')))?null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $Loans->amount = $request->input('amount');
        $Loans->status_id = $request->input('status_id');
        $Loans->note = $request->input('note');
        $Loans->createdby_id = Auth::user()->id;
        $Loans->created_usertypeid = Auth::user()->user_type_id;
        $Loans->updatedby_id = Auth::user()->id;
        $Loans->updated_usertypeid = Auth::user()->user_type_id;

        $Loans->save();

        return redirect('/Loans')->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Loans = DB::table('loan')
            ->select('loan.id as id', 'driverId', 'fullName', 'fullName_ar', 'journal_date',
                'amount', 'note', 'loan.status_id as status_id', 'loan_status',
                'loan.updatedby_id', 'user_created.name as name_created', 'user_updated.name as name_updated', 'updated_usertypeid', 'user_type',
                'loan.created_at as created_at', 'loan.updated_at as updated_at')
            ->leftJoin('drivers', 'loan.driverId', '=', 'drivers.id')
            ->leftJoin('lkp_loan_status', 'loan.status_id', '=', 'lkp_loan_status.id')
            ->leftJoin('users as user_created', 'loan.createdby_id', '=', 'user_created.id')
            ->leftJoin('users as user_updated', 'loan.updatedby_id', '=', 'user_updated.id')
            ->leftJoin('lkp_user_type', 'loan.updated_usertypeid', '=', 'lkp_user_type.id')
            ->where('loan.id', $id)
            ->first();

        return view('Loans.show')->with('Loans', $Loans);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $lkp_loan_status = DB::select('SELECT * from lkp_loan_status where id<>4');
        $Loans = DB::table('loan')
            ->select('loan.id as id', 'loan.driverId as driverId', 'fullName', 'fullName_ar',
                DB::raw("DATE_FORMAT(journal_date,'%d/%m/%Y') as journal_date"), 'amount', 'note', 'loan.status_id as status_id', 'loan_status',
                'loan.created_at as created_at', 'loan.updated_at as updated_at', DB::raw("ifnull(per_priod,0) as per_priod"), DB::raw("ifnull(cur_priod,0) as cur_priod"),
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
            ->leftJoin('drivers', 'loan.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_loan_status', 'loan.status_id', '=', 'lkp_loan_status.id')
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
            ->where('loan.id', $id)
            ->first();
        return view('Loans.edit')->with(compact('Loans'))->with(compact('lkp_loan_status'));
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


        $Loans = Loans::find($id);
        // $Loans->warehouseId = $request->input('warehouseId');
        $Loans->driverId = $request->input('driverId');
        $Loans->journal_date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        $Loans->amount = $request->input('amount');
        $Loans->status_id = $request->input('status_id');
        $Loans->note = $request->input('note');
        $Loans->updatedby_id = Auth::user()->id;
        $Loans->updated_usertypeid = Auth::user()->user_type_id;

        $Loans->save();

        return redirect('/Loans/' . $id . '/edit')->with('success', 'Done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->user_type_id == 1) {
            $Loans = Loans::find($id);
            // if(auth()->user()->id !== $Loans->user_id){
            //    return redirect('/Loans')->with('error','Unauthorized');
            // }

            if ($Loans->logo != 'noImage.jpg') {
                Storage::delete('public/app/storage' . $Loans->logo);

            }

            $Loans->delete();
        }
        return redirect('/Loans')->with('success', 'Done successfully');
    }


    public function updatePaid($id)
    {

        $loan = DB::select('SELECT fullName from loan
        inner join drivers on drivers.id =loan.driverId
        where loan.id=' . $id)[0];
        return view('Loans.updatePaid')->with(compact('id'))->with(compact('loan'));
    }

    public function updatePaidSave(Request $request)
    {


        //$this->validate($request, [
//
        //   'paid_image' => 'required|image|mimes:jpeg,png,jpg,',
        //]);

        //if ($request->hasFile('paid_image')) {

        //    $filenameWithExtention = $request->file('paid_image')->getClientOriginalName();
        //$fileName = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
        //    $extension = $request->file('paid_image')->getClientOriginalExtension();
        //   $fileNameStore = $request->input('loan_id') . '.' . $extension;
        //    try {
        //        $path = $request->file('paid_image')->move(base_path() . '/public/doc/paid_image/', $fileNameStore);
        //   } catch (Exception $e) {
        //       return redirect('/Loans')->with('error', $e->getMessage());
        //   }

        //}


        $Loans = Loans::find($request->input('loan_id'));
        $Loans->status_id = 4;
        //$Loans->paid_image = $fileNameStore;
        $Loans->save();
        $journal_type_id = '';

        $loan = DB::select('SELECT * from loan where loan.id=' . $request->input('loan_id'))[0];
        if($loan->loan_type == 'fuel_loan'){
            $journal_type_id = 9;
        }else{
            $journal_type_id = 1;
        }

        try {
            DB::insert("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
        createdby_id,updatedby_id,created_at,updated_at)
        values
        (" . $loan->driverId . ",'" . $loan->journal_date . "'," . $loan->amount . ",null,'" . $loan->note . "',".$journal_type_id."," . $loan->id . ",
        " . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'
        )");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/LoanPaid/' . $request->input('loan_id'))->with('error', $e->getPrevious()->getMessage());
        }

        try {
            DB::update("UPDATE loan
    JOIN journal  ON (loan.id = journal.post_id and journal.journal_type_id=1)
    SET loan.journal_id = journal.id
    where loan.id =" . $request->input('loan_id')
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/LoanPaid/' . $request->input('loan_id'))->with('error', $e->getPrevious()->getMessage());
        }


        return redirect('/LoanPaid/' . $request->input('loan_id'))->with('success', 'Done successfully');
    }
    //****************************************************************************************************************
    //****************************************************************************************************************
    public function LoansPaid(Request $request)
    {
        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Paid_DB = \Illuminate\Support\Facades\DB::table(DB::raw("(SELECT
           loan_import_paid_details.account_owner_iqama,
           loan_import_paid_details.accountNumber,
           loan_import_paid_details.bank_sum,
           GROUP_CONCAT(loan.id SEPARATOR ';') AS id,
           GROUP_CONCAT(drivers.job_id SEPARATOR ';') AS AMP_ID,
           GROUP_CONCAT(drivers.fullName SEPARATOR ';') AS fullName,
           GROUP_CONCAT(loan.journal_date SEPARATOR';') AS journal_date,
           GROUP_CONCAT(loan.status_id SEPARATOR';') AS status_id,
           GROUP_CONCAT(loan.amount SEPARATOR ';') AS loan_amount,
           GROUP_CONCAT(drivers.id SEPARATOR ';') AS driverId,
           GROUP_CONCAT(warehouseName SEPARATOR ';') AS warehouseName,
           GROUP_CONCAT(companyName SEPARATOR ';') AS companyName,
           GROUP_CONCAT(loan.updated_at SEPARATOR ';') AS updated_at
        FROM
           `loan`
        LEFT JOIN `drivers` ON `loan`.`driverId` = `drivers`.`id`
        LEFT JOIN `warehouse` ON `drivers`.`warehouseId` = `warehouse`.`id`
        LEFT JOIN `lkp_company` ON `warehouse`.`companyId` = `lkp_company`.`id`
        INNER JOIN loan_import_paid_details ON loan_import_paid_details.loan_id = loan.id
        AND paid_master_id = (SELECT MAX(id) FROM loan_import_paid_master)
        GROUP BY
           loan_import_paid_details.account_owner_iqama,
           loan_import_paid_details.accountNumber,
           loan_import_paid_details.bank_sum) as sub"))->get();
        if (isset($success))
            return view('Loans.LoansPaid')->with(compact('Paid_DB'))->with('success', $success);
        elseif (isset($error))
            return view('Loans.LoansPaid')->with(compact('Paid_DB'))->with('error', $error);
        else
            return view('Loans.LoansPaid')->with(compact('Paid_DB'));

    }
    //****************************************************************************************************************
    //****************************************************************************************************************
    /**
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \Illuminate\Validation\ValidationException
     */
    public function LoansPaidSave(Request $request)
    {

        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);

        
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');

        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();


        $date = date("Y-m-d H:i:s");

        $id = DB::table('loan_import_paid_master')->insertGetId(
            ['user_id' => Auth::user()->id,
                'fileName' => $request->file('select_file')->getClientOriginalName(),
                'create_at' => $date]

        );

        $values = '';

        for ($row = 2; $row <= $lastRow; $row++) {
            //return $worksheet->getCell('A' . $row)->getValue();
            $Select_db = DB::table(DB::raw("(select SUM(amount) as Loan_amount

                                    from loan
                                    where id in(" . str_replace('*', ',', $worksheet->getCell('L' . $row)->getValue()) . ")
                                    ) as sub"))
                ->first();

                
            $loan_IDs = explode("*", $worksheet->getCell('L' . $row)->getValue());
            $AMP_IDs = explode("*", $worksheet->getCell('I' . $row)->getValue());
            $bank_paid = explode("*", $worksheet->getCell('K' . $row)->getValue());


            if (floatval($Select_db->Loan_amount) == floatval($worksheet->getCell('C' . $row)->getValue())) {
                for ($i = 0; $i < count($loan_IDs); $i++) {

                    $values .= "(" . $id . ",
                             " . $loan_IDs[$i] . ",
                             '" . $AMP_IDs[$i] . "',
                             " . $worksheet->getCell('A' . $row)->getValue() . ",
                             '" . $worksheet->getCell('B' . $row)->getValue() . "',
                             " . $worksheet->getCell('C' . $row)->getValue() . ",
                             " . $worksheet->getCell('H' . $row)->getValue() . ",
                             " . $bank_paid[$i] . ",
                               1),";

                    try {

                        $loan = DB::select('SELECT * from loan where loan.id=' . $loan_IDs[$i])[0];
                        $journal_type_id = '';
                        if($loan->loan_type == 'fuel_loan'){
                            $journal_type_id = 9;
                        }else{
                            $journal_type_id = 1;
                        }
                        if ($loan->status_id <> 4) {
                            DB::update(" UPDATE loan SET status_id=4, status = 'Paid' where id = " . $loan_IDs[$i]);

                            DB::insert("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
                             createdby_id,updatedby_id,created_at,updated_at)
                            values
                            (" . $loan->driverId . ",'" . $loan->journal_date . "'," . $loan->amount . ",null,'" . $loan->note . "',".$journal_type_id."," . $loan->id . ",
                            " . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'
                            )");

                            DB::update("UPDATE loan
                            JOIN journal  ON (loan.id = journal.post_id and journal.journal_type_id=1 or journal.journal_type_id = 9)
                            SET loan.journal_id = journal.id
                            where loan.id =" . $loan_IDs[$i]);
                        }

                    } catch (\Illuminate\Database\QueryException $e) {
                        return redirect('/LoansPaid')->with('error', $e->getPrevious()->getMessage());
                    }
                }
            } else {
                for ($i = 0; $i < count($loan_IDs); $i++) {
                    $values .= "(" . $id . ",
                             " . $loan_IDs[$i] . ",
                             '" . $AMP_IDs[$i] . "',
                             " . $worksheet->getCell('A' . $row)->getValue() . ",
                             '" . $worksheet->getCell('B' . $row)->getValue() . "',
                             " . $worksheet->getCell('C' . $row)->getValue() . ",
                             " . $worksheet->getCell('H' . $row)->getValue() . ",
                             " . $bank_paid[$i] . ",
                               0),";
                }
            }

        }

        $values = substr($values, 0, strlen($values) - 1);

        //return $values;
        if ($values <> '') {
            try {

                DB::insert("insert  into loan_import_paid_details
                    (paid_master_id, loan_id,
                        AMP_ID, account_owner_iqama, accountNumber, bank_sum, CO,
                        bank_paid,paid)
                  VALUES
                  " . $values);
            } catch (\Illuminate\Database\QueryException $e) {
                return view('Loans.LoansPaid')->with('error', $e->getPrevious()->getMessage());
            }
        }
        return $this->LoansPaid($request)->with('success', 'Done successfully');
    }
//****************************************************************************************************************
//****************************************************************************************************************
}
