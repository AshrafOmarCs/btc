<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;
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
function get_table_body($totalAmount, $data, $SQL_final) {
    $body = [];

    $index = $i = $amount_total = 0 ;
    $check = $btn = 0;
    foreach($data as $row) {
        $index++;
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
            if($exported_by == Auth::user()->id OR Auth::user()->id == 73 OR Auth::user()->id == 15 OR Auth::user()->id == 1)
                $btn = "1";
            $color = 'orange';
            $disabled = '';
            $class = 'check-status';
        }
        else if($status == 'Paid') {
            $btn = "1";
            $color = 'Blue';
            $disabled = 'disabled';
            $class = '';
        }

        $amount_total += $row->amount;
        if ($disabled == 'disabled')
            $exported_name = '<span style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="">&nbsp;'.$status .'<span style="color: black !important">'.$exported_name.'</span></span>';
        else
            $exported_name = '<span style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="' . $row->id . '">&nbsp;'.$status .'<span style="color: black !important">'.$exported_name.'</span></span>';

        if ($row->status_id == "1") {
            $loan_status = '<span class="label label-warning">' . $row->loan_status . '</span>';
        } else if ($row->status_id == "2") {
            $loan_status = '<span class="label label-danger">' . $row->loan_status . '</span>';
        } else if ($row->status_id == "3") {
            $loan_status = '<span class="label label-primary">' . $row->loan_status . '</span>';
        } else if ($row->status_id == "4") {
            $loan_status = '<span class="label label-success">' . $row->loan_status . '</span>';
        } else if ($row->status_id == "5") {
            $loan_status = '<span class="label label-info">' . $row->loan_status . '</span>';
        }
        $action = '<span>';
        if ($row->status_id != "4") {
            $action .= '<a id=' . $row->id . ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>';
            $action .= '&nbsp;<a id=' . $row->id . ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>';
        } else {
            $action .= '&nbsp;<a onclick="revert_status(\'' . $row->id . '\', \'' . $row->fullName . '\', \'' . $row->job_id . '\', \'' . $row->amount . '\')" data-original-title="revert" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow revert"> <i class="fa fa-undo"></i> </a>';
        }
        $action .= '&nbsp;<a id=' . $row->id . ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';
        if ($row->status_id == "3" || $row->status_id == "5")
            $action .= '&nbsp;<button id=' . $row->id . ' type="button" class="btn btn-primary btn-xs updatePaid">Paid</button>';
        $action .= '</span>';
        if ($index == sizeof($data)) {
            $action .= '<input type="hidden" id="total_sum" value="'.$totalAmount.'">';
            $action .= '<input type="hidden" id="btn_final" value="'.$btn.'">';
            $action .= '<input type="hidden" id="check_final" value="'.$check.'">';
            $action .= '<input type="hidden" id="SQL_final" value="'.$SQL_final.'">';
        }

        if (Auth::user()->user_type_id == 1) {
            $checkbox = '<span style="text-align: center"><input class="check_status" name="ID_' . $i . '" type="checkbox" value="' . $row->id . '"></span>';
            $per_priod = '<span>'.$row->per_priod.'</span>';
            $cur_priod = '<span>'.$row->cur_priod.'</span>';
            if ($row->updated_usertypeid == "4") {
                $createdby_id = '<span></span>';
            } else {
                $createdby_id = '<span>'.$row->name.'</span>';
            }
            $body[] = [
                'created_at' => $row->created_at,
                'companyName' => $row->companyName,
                'warehouseName' => $row->warehouseName,
                'job_id' => $row->job_id,
                'fullName' => '<a href="javascript:driver(' . $row->driverId . ')">' . $row->fullName . '</a>',
                'checkbox' => $checkbox,
                'per_priod' => $per_priod,
                'cur_priod' => $cur_priod,
                'journal_date' => $row->journal_date,
                'journal_period' => $row->journal_period,
                'amount' => $row->amount,
                'exported_by' => $exported_name,
                'note' => $row->note,
                'loan_status' => $loan_status,
                'account_owner_iqama' => $row->account_owner_iqama,
                'accountNumber' => $row->accountNumber,
                'createdby_id' => $createdby_id,
                'updated_at' => $row->updated_at,
                'action' => $action,
            ];
        } else {
            $body[] = [
                'created_at' => $row->created_at,
                'companyName' => $row->companyName,
                'warehouseName' => $row->warehouseName,
                'job_id' => $row->job_id,
                'fullName' => '<a href="javascript:driver(' . $row->driverId . ')">' . $row->fullName . '</a>',
                'journal_date' => $row->journal_date,
                'amount' => $row->amount,
                'exported_by' => $exported_name,
                'note' => $row->note,
                'loan_status' => $loan_status,
                'account_owner_iqama' => $row->account_owner_iqama,
                'accountNumber' => $row->accountNumber,
                'action' => $action,
            ];
        }
    }
    return array($body, $amount_total, $btn, $check);
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
     public function approval($type, $reason, $id, $check) {
        $loan_id = array();
        $loan_id[] = $id;
        $made_by = Auth::user()->name;
        $user_by = Auth::user()->id;
        if($type == 'loan') {
            if ($check == 1) {
                DB::update("UPDATE loan set status = 'Ready', status_id = '5', exported_by = null, reverse_by = '$user_by' WHERE id = '$id'");
                DB::delete("DELETE FROM journal WHERE post_id = '$id'");
                $msg = "<b>$made_by</b> Reverted the loan from Paid to Ready with this Reason: " . $reason;
                HelperFunctionsController::add_log($msg, '', $loan_id);
                return 'Loan reverted successfully';
            } else {
                return 'Thanks for your action.';
            }
        } else if($type == 'saned') {
            if ($check == 1) {
                $drivers_saned_settlement_id = DB::select("SELECT paid_id from drivers_jahiz_clearing WHERE id = '$id'");
                $drivers_saned_settlement_id = $drivers_saned_settlement_id[0]->paid_id;
                DB::update("UPDATE drivers_jahiz_clearing set paid_by_id = null, paid_id = null, paid_dt = null WHERE id = '$id'");
                DB::update("UPDATE drivers_saned_settlement set drivers_jahiz_clearing_paid_id = null, paid_by_id = null, status = 'Ready', paid_dt = null, exported_by = null, reverse_by = '$user_by' WHERE id = '$drivers_saned_settlement_id'");
                $msg = "<b>$made_by</b> Reverted the saned from Paid to Ready with this Reason: " . $reason;
                HelperFunctionsController::add_log($msg, '', $loan_id);
                return 'Saned reverted successfully';    
            } else {
                return 'Thanks for your action.';
            }
        } else if($type == 'salary') {
            if ($check == 1) {
                $parts = explode("_", $id);
                $driverId = $parts[0];
                $start_date = $parts[1];
                $end_date = $parts[2];
                $salary = DB::select("SELECT id FROM journal WHERE journal_type_id = '2' AND journal_date BETWEEN '$start_date' AND '$end_date' AND driverId = '$driverId'");
                if(count($salary) != 1) {
                    return 'Something went wrong more than 1 record appearing.';
                    exit();
                }
                $salary_id = $salary[0]->id;
                DB::delete("DELETE FROM journal WHERE journal_type_id = '2' AND journal_date BETWEEN '$start_date' AND '$end_date' AND driverId = '$driverId'");
                DB::update("UPDATE journal set status = 'Ready', reverse_by = '$user_by', updated_at = NOW() WHERE journal_type_id = '6' AND journal_date BETWEEN '$start_date' AND '$end_date' AND driverId = '$driverId'");
                $msg = "<b>$made_by</b> Reverted the Salary from Paid to Ready with this Reason: " . $reason;
                HelperFunctionsController::add_log($msg, '', $salary_id);
                return 'Salary reverted successfully';
            } else {
                return 'Thanks for your action.';
            }
        }
     }
     public function loansRevert(Request $request) {
        $loan_id = array();
        $id = $loan_id[] = $request->loan_id;
        $reason = $request->reason;
        $made_by = Auth::user()->name;
        $user_by = Auth::user()->id;
        if ($user_by == 15) {
            DB::update("UPDATE loan set status = 'Ready', status_id = '5', exported_by = null, reverse_by = '$user_by' WHERE id = '$id'");
            DB::delete("DELETE FROM journal WHERE post_id = '$id'");
            $msg = "<b>$made_by</b> Reverted the loan from Paid to Ready with this Reason: " . $reason;
            HelperFunctionsController::add_log($msg, '', $loan_id);
            return redirect()->back()->with('success', 'Loan reverted successfully');    
        } else {
            $msg = "<b>$made_by</b> Requested to revert the loan from Paid to Ready with this Reason: " . $reason;
            HelperFunctionsController::add_log($msg, '', $loan_id);
            
            $subject = "Loan Reverse Request";
            $result = DB::select("SELECT drivers.fullName,drivers.job_id,loan.journal_date,warehouse.warehouseName,lkp_company.companyName,loan.amount FROM loan INNER JOIN drivers ON loan.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE loan.id='$id'");
            $yes = url("/approval/loan/" . $reason . "/" . $id . "/1");
            $no = url("/approval/loan/" . $reason . "/" . $id . "/0");
            $row = '<br><br>
            <table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid black; padding: 8px;">Driver</th>
                        <th style="border: 1px solid black; padding: 8px;">Job Id</th>
                        <th style="border: 1px solid black; padding: 8px;">Journal Date</th>
                        <th style="border: 1px solid black; padding: 8px;">Company</th>
                        <th style="border: 1px solid black; padding: 8px;">Warehouse</th>
                        <th style="border: 1px solid black; padding: 8px;">Amount</th>
                        <th style="border: 1px solid black; padding: 8px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color: #ffffff;">
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->fullName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->job_id.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->journal_date.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->companyName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->warehouseName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->amount.'</td>
                        <td style="border: 1px solid black; padding: 8px;"><a href="'.$yes.'" style="color: green">Accept</a> | <a href="'.$no.'" style="color: red">Reject</a></td>
                    </tr>
                </tbody>
            </table>
            ';
            $msg .= $row;
            $recipients = [
                'm.shehroze@btclogistic.com',
            ];
            $ccRecipients = [];
            $email_status = HelperFunctionsController::send_email($recipients, $ccRecipients, $msg, $subject);
            if($email_status == false) {
                return response()->json(['message' => 'Failed to send email.'], 500);
            } else {
                return redirect()->back()->with('success', 'Notification to Finance Manager sent successfully');
            }
        }
     }
    public function goToReady(Request $request) {
        $ACTION = $request->ACTION;
        $ready_statuss = $request->ready_statuss;
        $loan_ids = explode(",",$ready_statuss);
        $user = Auth::user();
        $user_id = $user->id;
        $amp_ids = array();
        if (password_verify($request->input('password'), $user->password)) {
            if($ACTION == 'PAID') {
                foreach($loan_ids as $loan_id) {
                    $loan = DB::select("SELECT * FROM loan WHERE id = '$loan_id'");
                    $driverId = $loan[0]->driverId;
                    $driver = HelperFunctionsController::getDriverData($driverId);
                    $amp_ids[] = $driver->job_id;
                    $journal_date = $loan[0]->journal_date;
                    $credit = $loan[0]->amount;
                    $note = $loan[0]->note;
                    if ($loan[0]->status == 'Paid') {
                        return redirect('/LoansShe')->with('error', "Selected loan(s) already paid");
                        exit();
                    } else {
                        DB::insert("INSERT INTO journal (driverId, journal_date, debit, note, status, journal_type_id, post_id, createdby_id, created_at, updatedby_id, updated_at) VALUES ('$driverId', '$journal_date', '$credit', '$note', 'Paid', '1', '$loan_id', '$user_id', NOW(), '$user_id', NOW())");
                        $journal_id = DB::getPdo()->lastInsertId();
                        DB::update("Update loan set status_id = '4', status = 'Paid', journal_id = '$journal_id', exported_by = '$user_id', updated_by = '$user_id', updated_at = NOW() where id = '$loan_id'");
                    }
                }
                if(count($loan_ids) > 0) {
                    $made_by = Auth::user()->name;
                    $amp_ids = implode(',', $amp_ids);
                    $msg = "<b>$made_by</b> updated the loan with driver amp_ids ('$amp_ids') to Paid";
                    HelperFunctionsController::add_log($msg, '', $loan_ids);
                }
                return redirect('/LoansShe')->with('success', "Status updated successfully");
            } else if($ACTION == 'DELETE') {
                $amp_ids = array();
                foreach($loan_ids as $loan_id) {
                    $loan = DB::select("SELECT * FROM loan WHERE id = '$loan_id'");
                    $driverId = $loan[0]->driverId;
                    $driver = HelperFunctionsController::getDriverData($driverId);
                    $amp_ids[] = $driver->job_id;
                    
                    $check = DB::select("select id FROM journal WHERE post_id = '$loan_id'");
                    if(count($check) > 0)
                        DB::delete("DELETE from journal WHERE post_id = '$loan_id'");
                    DB::delete("Delete from loan WHERE id = '$loan_id'");
                }
                if(count($loan_ids) > 0) {
                    $made_by = Auth::user()->name;
                    $amp_ids = implode(',', $amp_ids);
                    $msg = "<b>$made_by</b> deleted the loan with driver amp_ids ('$amp_ids').";
                    HelperFunctionsController::add_log($msg, '', $loan_ids);
                }
                return redirect('/LoansShe')->with('success', "Loan Deleted successfully");
            } else if($ACTION == 'READY') {
                $loanids = array();
                foreach($loan_ids as $loan_id) {
                    $loan = DB::select("SELECT * FROM loan WHERE id = '$loan_id'");
                    $driverId = $loan[0]->driverId;
                    $driver = HelperFunctionsController::getDriverData($driverId);
                    $loan = DB::select("SELECT status FROM loan WHERE id = '$loan_id'");
                    if($loan[0]->status == 'Onhold') {
                        $loanids[] = $loan_id;
                        $amp_ids[] = $driver->job_id;
                        DB::update("Update loan set status = 'Ready', exported_by = '0', reverse_by = '$user_id', updated_by = '$user_id', updated_at = NOW() where id = '$loan_id'");    
                    }
                }
                if(count($amp_ids) > 0) {
                    $made_by = Auth::user()->name;
                    $amp_ids = implode(',', $amp_ids);
                    $msg = "<b>$made_by</b> updated the loan with driver amp_ids ('$amp_ids') to Ready";
                    HelperFunctionsController::add_log($msg, '', $loanids);
                }
                return redirect('/LoansShe')->with('success', "Status updated successfully");
            }
        } else {
            // Password is incorrect
            return redirect('/LoansShe')->with('error', "Password is incorrect");
        }
    }
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
            $wher = " where lkp_company.status = 'active' AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
            $AND = " AND lkp_company.status = 'active' AND lkp_company.id in(" . implode(",", $whereIn_array) . ")";
        } else {
            $wher = "where id <> 6 AND lkp_company.status = 'active'";
            $AND = "";
        } 
        $lkp_company = DB::select("SELECT * from lkp_company $wher");
        $warehouse = DB::select('SELECT * from warehouse order by warehouseName');
        $lkp_loan_status = DB::select('SELECT * from lkp_loan_status ');
        $users = DB::select('SELECT id,name from users order by name');
        $lkp_user_type = DB::select('SELECT * from lkp_user_type'); 

        $Select_db = DB::table('loan')
            ->select('loan.export_attempt', 'loan.exported_by','loan.status','loan.id as id','loan.loan_type as loan_type', 'companyName', 'loan.driverId', 'fullName', 'warehouseName', 'job_id',
                DB::raw("iqama, account_owner_iqama,
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
                'loan.updatedby_id', 'export.name AS user_name', 'users.name', 'updated_usertypeid', 'user_type',
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
            ->leftJoin('users as export', 'loan.exported_by', '=', 'export.id')
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
                
                // dd($Select_db);
        $Select_sum = DB::table('loan')
            ->select(DB::raw("sum(amount) as amount"))
            ->leftJoin('drivers', 'loan.driverId', '=', 'drivers.id')
            ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_bank', 'drivers.bank_id', '=', 'lkp_bank.id')
            ->leftJoin('lkp_loan_status', 'loan.status_id', '=', 'lkp_loan_status.id')
            ->leftJoin('users', 'loan.updatedby_id', '=', 'users.id')
            ->leftJoin('lkp_user_type', 'loan.updated_usertypeid', '=', 'lkp_user_type.id')
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
                $Select_db->whereRaw('companyId in (' . implode(",", $request->filter_companyId) .')');
                $Select_sum->whereRaw('companyId in (' . implode(",", $request->filter_companyId) .')');
            }
            if (!empty($request->filter_warehouseId)) {
                $Select_db->whereRaw('warehouseId in (' . implode(",", $request->filter_warehouseId) .')');
                $Select_sum->whereRaw('warehouseId in (' . implode(",", $request->filter_warehouseId) .')');
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
                $Select_sum->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->whereRaw('loan.driverId=' . $request->filter_driverId);
                $Select_sum->whereRaw('loan.driverId=' . $request->filter_driverId);
            }
            if (!empty($request->filter_journal_date)) {
                $filter_journal_date = explode(" - ", $request->filter_journal_date);
                $Select_db->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(journal_date as date) between STR_TO_DATE('$filter_journal_date[0]','%d/%m/%Y') and STR_TO_DATE('$filter_journal_date[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_amount)) {
                $Select_db->whereRaw('amount=' . $request->filter_amount);
                $Select_sum->whereRaw('amount=' . $request->filter_amount);
            }
            if (!empty($request->filter_status_id)) {
                $Select_db->whereRaw('loan.status_id=' . $request->filter_status_id);
                $Select_sum->whereRaw('loan.status_id=' . $request->filter_status_id);
            }
            // ashraf condition for fuel loans
            // dd($request->filter_Loan_type);
            // dd($request->all());
            if (!empty($request->filter_Loan_type)) {
                if($request->filter_Loan_type == 'FL'){
                    $whereIn_array = array();
                    $whereIn_array = ['fuel_loan'];
                    // $Select_db->where('loan_type', 'fuel_loan'); 
                    $Select_db->whereRaw('loan.loan_type=' . '"fuel_loan"');
                    $Select_sum->whereRaw('loan.loan_type=' . '"fuel_loan"');

                }elseif($request->filter_Loan_type == 'PL'){
                    $whereIn_array = array();
                    $whereIn_array = ['personal_loan'];
                    $Select_db->whereRaw('loan.loan_type=' . '"personal_loan"');
                    $Select_sum->whereRaw('loan.loan_type=' . '"personal_loan"');
                    // $Select_db->whereIn('loan_type', $whereIn_array); 
                }
            }
            // ashraf condition for fuel loans
            if (!empty($request->filter_note)) {
                $Select_db->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
                $Select_sum->whereRaw("UPPER(note) LIKE '%" . strtoupper($request->filter_note) . "%'");
            }
            if (!empty($request->filter_updatedby_id)) {
                $Select_db->whereRaw('loan.updatedby_id=' . $request->filter_updatedby_id);
                $Select_sum->whereRaw('loan.updatedby_id=' . $request->filter_updatedby_id);
            }
            if (!empty($request->filter_updated_usertypeid)) {
                $Select_db->whereRaw('updated_usertypeid=' . $request->filter_updated_usertypeid);
                $Select_sum->whereRaw('updated_usertypeid=' . $request->filter_updated_usertypeid);
            }
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(loan.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(loan.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(loan.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(loan.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            } 
            if (isset($_REQUEST['search']['value']) && $_REQUEST['search']['value'] <> '') {
                $options = strtolower($_REQUEST['search']['value']);
                $Select_sum->whereRaw("(
                LOWER(`loan`.`created_at`) LIKE '%" . $options . "%'
                OR LOWER(
                    `lkp_company`.`companyName`
                ) LIKE '%" . $options . "%'
                OR LOWER(
                    `warehouse`.`warehouseName`
                ) LIKE '%" . $options . "%'
                OR LOWER(`drivers`.`job_id`) LIKE '%" . $options . "%'
                OR LOWER(`drivers`.`fullName`) LIKE '%" . $options . "%'
                OR LOWER(`balance`.`per_priod`) LIKE '%" . $options . "%'
                OR LOWER(`balance`.`cur_priod`) LIKE '%" . $options . "%'
                OR LOWER(`loan`.`journal_date`) LIKE '%" . $options . "%'
                OR LOWER(`loan`.`amount`) LIKE '%" . $options . "%'
                OR LOWER(`loan`.`note`) LIKE '%" . $options . "%'
                OR LOWER(
                    `lkp_loan_status`.`loan_status`
                ) LIKE '%" . $options . "%'
                OR LOWER(`lkp_bank`.`bank_name_en`) LIKE '%" . $options . "%'
                OR LOWER(`drivers`.`accountNumber`) LIKE '%" . $options . "%'
                OR LOWER(`users`.`name`) LIKE '%" . $options . "%'
                OR LOWER(`loan`.`updated_at`) LIKE '%" . $options . "%'
                OR LOWER(`loan`.`id`) LIKE '%" . $options . "%'
                )");
            } 
            $Select_sum = $Select_sum->first();
            // dd($Select_db->toSql());
            // return $Select_db->toSql();
             
             return  datatables()->of($Select_db)
                ->with('amount', '<b>' . $Select_sum->amount . '</b>')
                ->with('SQL', $Select_db->toSql())
                ->make(true);
            // dd($rea);
        }

       
        
        return view('Loans.index_she')->with(compact('lkp_loan_status'))
            ->with(compact('users'))->with(compact('lkp_user_type'))->with(compact('lkp_company'))->with(compact('warehouse'));
    }

    public function search(Request $request)
    {
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

            // if (Auth::user()->user_type_id != 1) {
            //     $users_privilege = DB::select('SELECT user_id, warehouseId FROM users_privilege WHERE user_id = ?', [Auth::user()->id]);
            //     $whereIn_array = [];
            //     foreach ($users_privilege as $users_privilegee) {
            //         $whereIn_array[] = $users_privilegee->warehouseId;
            //     }
            //     if (empty($whereIn_array)) {
            //         $whereIn_array[] = 0;
            //     }
            //     $Select_db = $Select_db->whereIn('warehouseId', $whereIn_array);
            // }


            if (!empty($request->filter_companyId)) {
                $Select_db->whereRaw('companyId=' . $request->filter_companyId);
            }
            if (is_array($request->filter_warehouseId) > 0) {
                $Select_db->whereRaw('warehouseId in(' . implode(",", $request->filter_warehouseId) .')');
            } else {
                if (Auth::user()->user_type_id != 1) {
                    $users_privilege = DB::select('SELECT user_id, warehouseId FROM users_privilege WHERE user_id = ?', [Auth::user()->id]);
                    $whereIn_array = [];
                    foreach ($users_privilege as $users_privilegee) {
                        $whereIn_array[] = $users_privilegee->warehouseId;
                    }
                    if (empty($whereIn_array)) {
                        $whereIn_array[] = 0;
                    }
                    $Select_db->whereRaw('warehouseId in(' . implode(",", $whereIn_array) .')');
                }
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
                $Select_db->whereRaw('loan.updatedby_id=' . $request->filter_updatedby_id);
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
            // dd("till here its fine ");
            $Select_dbb = clone $Select_db;
            if(Auth::user()->user_type_id==1)
                $columns = ['created_at', 'companyName', 'warehouseName', 'job_id', 'fullName', 'checkbox', 'per_priod', 'cur_priod', 'journal_date', 'journal_period', 'amount', 'exported_by', 'note', 'loan_status', 'account_owner_iqama', 'accountNumber', 'createdby_id', 'updated_at', 'action'];
            else
                $columns = ['created_at', 'companyName', 'warehouseName', 'job_id', 'fullName', 'journal_date', 'amount', 'exported_by', 'note', 'loan_status', 'account_owner_iqama', 'accountNumber', 'action'];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $Select_db = $Select_db->orderBy($order, $dir);

            $search = $request->input('search.value');
            if (!empty($search)) {
                $Select_db->orwhereRaw("companyName LIKE '%" . $search . "%'");
                $Select_db->orwhereRaw("warehouseName LIKE '%" . $search . "%'");
                $Select_db->orwhereRaw("fullName LIKE '%" . $search . "%'");
                $Select_db->orwhereRaw("journal_date LIKE '%" . $search . "%'");
                $Select_db->orwhereRaw("loan.note LIKE '%" . $search . "%'");
                $Select_db->orwhereRaw("account_owner_iqama LIKE '%" . $search . "%'");
                $Select_db->orwhereRaw("accountNumber LIKE '%" . $search . "%'");
                $Select_db->orwhereRaw("job_id LIKE '%" . $search . "%'");

                $sql = $Select_db->toSql();
                $payload = DB::select($sql);
                $totalAmount = 0;
                foreach ($payload as $row) {
                    $totalAmount += $row->amount;
                }
                $totalData = count($payload);
                $sql .= " LIMIT $start, $limit";
                $payload = DB::select($sql);
                $totalFiltered = $totalData;
            } else {
                // $rows = DB::select("SELECT COUNT(*) AS total_records FROM loan");
                // $totalData = $rows[0]->total_records;
                // $rows = DB::select("SELECT SUM(amount) AS total_amount FROM loan");
                // $totalAmount = $rows[0]->total_amount;
                
                // $rows = DB::select("SELECT COUNT(*) AS total_records FROM loan");
                // $totalData = $rows[0]->total_records;
                // $rows = DB::select("SELECT SUM(amount) AS total_amount FROM loan");
                // $totalAmount = $rows[0]->total_amount;
                // $payload = DB::select($sql);
                
                $totalAmount = 0;
                // foreach ($payload as $row) {
                //     $totalAmount += $row->amount;
                // }

                $sql = $Select_db->toSql();

                $sql .= " LIMIT 0, 1000";
                $payload = DB::select($sql);
                foreach ($payload as $row) {
                    $totalAmount += $row->amount;
                }
                $totalData = count($payload);
                $totalFiltered = $totalData;
            }
            $response = array();
            $responses = get_table_body($totalAmount, $payload, $Select_dbb->toSql());
            $response = $responses[0];
            $amount_total = $responses[1];
            $btn = $responses[2];
            $check = $responses[3];
            $jsonResponse = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $response,
            ];

            return response()->json($jsonResponse);
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

        $action = '';
        $Loans = Loans::find($id);
        // $Loans->warehouseId = $request->input('warehouseId');
        if($Loans->driverId != $request->input('driverId') AND $request->input('driverId') != '') {
            $action .= "driverId: " . $Loans->driverId . " to " . $request->input('driverId') . ", ";
        }
        $Loans->driverId = $request->input('driverId');
        if($Loans->journal_date != $request->input('journal_date') AND $request->input('journal_date') != '') {
            $action .= "journal_date: " . $Loans->journal_date . " to " . $request->input('journal_date') . ", ";
        }
        $Loans->journal_date = (empty($request->input('journal_date'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('journal_date'))->format('Y-m-d');
        if($Loans->amount != $request->input('amount') AND $request->input('amount') != '') {
            $action .= "amount: " . $Loans->amount . " to " . $request->input('amount') . ", ";
        }
        $Loans->amount = $request->input('amount');
        if($Loans->status_id != $request->input('status_id') AND $request->input('status_id') != '') {
            $action .= "status_id: " . $Loans->status_id . " to " . $request->input('status_id') . ", ";
        }
        $Loans->status_id = $request->input('status_id');
        if($Loans->note != $request->input('note') AND $request->input('note') != '') {
            $action .= "note: " . $Loans->note . " to " . $request->input('note') . ", ";
        }
        $Loans->note = $request->input('note');
        $Loans->updatedby_id = Auth::user()->id;
        $Loans->updated_usertypeid = Auth::user()->user_type_id;

        $success = $Loans->save();
        if($success) {
            if ($action != '') {
                $loan_id = $Loans->id;
                $made_by = Auth::user()->name;
                $msg = "<b>$made_by</b> updated the loan with id ($loan_id) with these changes: $action";
                HelperFunctionsController::add_log($msg);
            }
        }

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
            $loan_id = $id;
            $made_by = Auth::user()->name;
            $msg = "<b>$made_by</b> Deleted the loan with id ($loan_id)";
            HelperFunctionsController::add_log($msg);
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
        $loan_id = $request->input('loan_id');
        $made_by = Auth::user()->name;
        $msg = "<b>$made_by</b> Updated the loan ($loan_id) status_id from " .$Loans->status_id . " to Paid.";
        HelperFunctionsController::add_log($msg);
        $Loans->save();
        $journal_type_id = '';

        $loan = DB::select('SELECT * from loan where loan.id=' . $request->input('loan_id'))[0];
        if($loan->loan_type == 'fuel_loan'){
            $journal_type_id = 9;
        }else{
            $journal_type_id = 1;
        }

        try {
            DB::insert("insert into journal (status, driverId,journal_date,debit,credit,note,journal_type_id,post_id,
        createdby_id,updatedby_id,created_at,updated_at)
        values
        ('Paid', " . $loan->driverId . ",'" . $loan->journal_date . "'," . $loan->amount . ",null,'" . $loan->note . "',".$journal_type_id."," . $loan->id . ",
        " . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'
        )");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/LoanPaid/' . $request->input('loan_id'))->with('error', $e->getPrevious()->getMessage());
        }

        try {
            DB::update("UPDATE loan
    JOIN journal  ON (loan.id = journal.post_id and journal.journal_type_id=1)
    SET loan.status = 'Paid', loan.journal_id = journal.id
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
        $amps_arr = $loans_arr = array();
        $user_id = Auth::user()->id;

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
                            $loans_arr[] = $loan_IDs[$i];
                            $amps_arr[] = $AMP_IDs[$i];
                            DB::update("UPDATE loan SET status_id=4, exported_by = '$user_id', status = 'Paid', updated_at = NOW() where id = " . $loan_IDs[$i]);

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
        if(count($loans_arr) > 0) {
            $made_by = Auth::user()->name;
            $amp_ids = implode(',', $amps_arr);
            $msg = "<b>$made_by</b> updated the loan with driver amp_ids ('$amp_ids') to Paid";
            HelperFunctionsController::add_log($msg, '', $loans_arr);
        }
        return $this->LoansPaid($request)->with('success', 'Done successfully');
    }
//****************************************************************************************************************
//****************************************************************************************************************
}


