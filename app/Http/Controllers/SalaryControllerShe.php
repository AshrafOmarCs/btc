<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperFunctionsController;
use App\Salary;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PHPExcel_IOFactory;
use App\Page_privilege;
use DateTime;

function get_daily_load($driverId, $from, $to) {
    $daily_load = DB::select("SELECT SUM(credit) as daily_load FROM `journal` WHERE `driverId` = '$driverId' AND `journal_type_id` = '6' AND `journal_date` BETWEEN '$from' AND '$to'");
    return $daily_load[0]->daily_load;
}
function get_journal_status($driverId, $from, $to) {
    $response = array('', '');
    $journal_status = DB::select("SELECT status, exported_by, export_attempt FROM `journal` WHERE `driverId` = '$driverId' AND `journal_type_id` = '6' AND `journal_date` BETWEEN '$from' AND '$to'");
    if(count($journal_status) > 0){
        $response[0] = $journal_status[0]->status;
        $response[1] = $journal_status[0]->exported_by;
        $response[2] = $journal_status[0]->export_attempt;
    }
    else {
        $journal_status = DB::select("SELECT status, exported_by, export_attempt FROM `journal` WHERE `driverId` = '$driverId' AND `journal_type_id` = '7' AND `journal_date` BETWEEN '$from' AND '$to' LIMIT 0,1");
        if(count($journal_status) > 0) {
            $response[0] = $journal_status[0]->status;
            $response[1] = $journal_status[0]->exported_by;
            $response[2] = $journal_status[0]->export_attempt;
        }
    }
    return $response;
}
function get_user_name($user_id)
{
    $row = DB::select("SELECT name from users WHERE id = '$user_id'");
    return $row[0]->name;
}
function make_salary_table_body($records) {
    $response = "";
    $check = $btn = 0;
    $i = $pack_total = $final_pack_total = $match_total = $gap_total = $days_total = $c_down_total = $day_load_total = $credit_total = $debit_total = $loan_total = $cn_total = $ind_total = $exp_salary_total = $paid_salary_total = $t_total = $brought_total = 0;
    foreach($records as $record) {
        $exported_by = $record->exported_by;
        $exported_name = '';
        if ($exported_by > 0)
            $exported_name = '(' . get_user_name($exported_by) . ')';

        $pack_total += $record->total_No_of_TP;
        if($record->No_of_TouchPoint > 0)
            $final_pack_total += $record->No_of_TouchPoint;
        if($record->GAP > 0)
            $gap_total +=$record->GAP;
        $days_total += $record->daycount;
        $credit_total += $record->credit_now;
        $debit_total += $record->debit_now;
        if($record->Loan != '')
            $loan_total += $record->Loan;
        if($record->CreditNote != '')
            $cn_total += $record->CreditNote;
        if($record->IND != '')
            $ind_total += $record->IND;
        $exp_salary_total += $record->expected_salary;

        $day_load_total += $record->day_loaded;

        $response .= '<tr>';
        $response .= '<td>'.$record->warehouseName.'</td>';
        $response .= '<td><a href="javascript:driver(' . $record->driverId . ')">'.$record->fullName.'</a></td>';
        $response .= '<td>'.$record->job_id.'</td>';
        $response .= '<td>'.$record->total_No_of_TP.'</td>';
        // $response .= '<td>'.$record->No_of_TouchPoint.'</td>';
        // if ($record->matching == "Yes") {
        //     $response .= '<td><span class="label label-success">' . $record->matching . '</span></td>';
        //     $match_total++;
        // } else if ($record->matching == "No") {
        //     $response .= '<td><span class="label label-danger">' . $record->matching . '</span></td>';
        // }
        // $response .= '<td>'.$record->GAP.'</td>';
        $response .= '<td>'.$record->daycount.'</td>';
        if ($record->carried_down > 0) {
            $c_down_total += $record->carried_down;
            $response .= '<td><span class="Font-Green">' . $record->carried_down . '</span></td>';
        } else if ($record->carried_down < 0)  {
            $c_down_total += $record->carried_down;
            $response .= '<td><span class="Font-Red">' . $record->carried_down . '</span></td>';
        } else $response .= '<td></td>';
        $response .= '<td class="Font-Green">'.$record->day_loaded.'</td>';
        $response .= '<td class="Font-Green">'.$record->credit_now.'</td>';
        $response .= '<td class="Font-Red">'.$record->debit_now.'</td>';
        $disabled = '';
        $color = '';
        $disabled = '';
        $class = '';
        if($record->journal_status == 'Ready') {
            $check = 1;
            $color = 'green';
            $disabled = 'disabled';
            $class = '';
        }
        else if($record->journal_status == 'Onhold'){
            $disabled = 'disabled';
            if($exported_by == Auth::user()->id OR Auth::user()->id == 73 OR Auth::user()->id == 15)
            {
                $btn = "1";
                $disabled = '';
            }
            $color = 'orange';
            $class = 'check-status';
        }
        else if($record->journal_status == 'Paid') {
            $color = 'Blue';
            $disabled = 'disabled';
            $class = '';
        }
        if ($disabled == 'disabled')
            $response .= '<td style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="">&nbsp;'.$record->journal_status.'<span style="color: black !important">'.$exported_name.'</span></td>';
        else
            $response .= '<td style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="' . $record->driverId . '">&nbsp;'.$record->journal_status.'<span style="color: black !important">'.$exported_name.'</span></td>';

        $response .= '<td><center><div class="circle">'.$record->export_attempt.'</div></center></td>';
        $response .= '<td>'.$record->Loan.'</td>';
        $response .= '<td>'.$record->CreditNote.'</td>';
        // if ($record->IND)
        //     $response .= '<td>'. $record->IND.'</td>';
        // else {
        //     if ($record->under_sopnsorship_id == "1") {
        //         $response .= '<td><input name="IND_' . $i . '" type="hidden" class="form-control" style="width:25px" value=""></td>';
        //     } else $response .= '<td></td>';
        // }
        $response .= '<td>'.$record->expected_salary.'</td>';
        if (!$record->paid_salary)
            $response .= '<td class="dt-nowrap"><input name="paid_salary_' . $i . '" type="text" class="form-control" style="width:50px" value="' . $record->edit_salary . '">' .
                '&nbsp;<input class="flat-red" name="ID_' . $i . '" type="checkbox" value="' . $record->driverId . '"></td>';
        else
            $response .= '<td>'.$record->paid_salary.'</td>';
        // if ($record->matching_transaction == "Yes") {
        //     $response .= '<td><span class="label label-success">' . $record->matching_transaction . '</span><b>' . $record->amount . '</b></td>';
        // } else if ($record->matching_transaction == "No") {
        //     $response .= '<td><span class="label label-danger">' . $record->matching_transaction . '</span><b>' . $record->amount . '</b></td>';
        // } else if ($record->matching_transaction == "Null") {
        //     $response .= '<td><span class="label label-warning">' . $record->matching_transaction . '</span><b>' . $record->amount . '</b></td>';
        // }
        if ($record->brought_down > 0) {
            $brought_total += $record->brought_down;
            $response .= '<td><span class="Font-Green">' . $record->brought_down . '</span></td>';
        } else if ($record->brought_down < 0)  {
            $brought_total += $record->brought_down;
            $response .= '<td><span class="Font-Red">' . $record->brought_down . '</span></td>';
        } else $response .= '<td></td>';
        $revert = '';
        $response .= '<td>
        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">Action
            </button>
            <ul class="dropdown-menu">';
            if ($record->paid_salary) {
                $revert = '<li><a onclick="revert_status(\'' . $record->driverId . '\', \'' . $record->fullName . '\', \'' . $record->job_id . '\', \'' . $record->day_loaded . '\')" data-original-title="revert" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow revert"> Revert </a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                ';
            }
            $response .= $revert.'
            <li><a id=' . $record->driverId . ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> View </a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a id=' . $record->driverId . ' data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement"> Statement </a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            </ul>
        </div></td>';

        $response .= '<td style="display: none;">'.$record->bank_name_en.'</td>';
        $response .= '<td style="display: none;">'.$record->accountNumber.'</td>';
        $response .= '<td style="display: none;">'.$record->driverId.'</td>';
        $response .= '<td style="display: none;">'.$record->iqama.'</td>';

        $response .= '</tr>';
        $i++;
    }
    $responses = [];
    $responses['body'] = $response;
    $responses['pack_total'] = $pack_total;
    $responses['final_pack_total'] = $final_pack_total;
    $responses['match_total'] = $match_total;
    $responses['gap_total'] = $gap_total;
    $responses['days_total'] = $days_total;
    $responses['c_down_total'] = $c_down_total;
    $responses['day_load_total'] = $day_load_total;
    $responses['credit_total'] = $credit_total;
    $responses['debit_total'] = $debit_total;
    $responses['loan_total'] = $loan_total;
    $responses['cn_total'] = $cn_total;
    $responses['ind_total'] = $ind_total;
    $responses['exp_salary_total'] = $exp_salary_total;
    $responses['paid_salary_total'] = $paid_salary_total;
    $responses['t_total'] = $t_total;
    $responses['brought_total'] = $brought_total;
    $responses['check'] = $check;
    $responses['btn'] = $btn;
    return $responses;
}
function get_settlement_credit_debit($driverId, $from, $to) {
    $result = DB::select("SELECT sum(credit) as set_credit, sum(debit) as set_debit FROM settlements WHERE driverId = '$driverId' AND journal_date BETWEEN '$from' and '$to'");
    if(count($result) > 0) {
        // dd();
        return [$result[0]->set_credit ?? '', $result[0]->set_debit ?? ''];
    } else {
        return array(['', '']);
    }
}
function make_salary_table_body_supervisors($records) {
    $response = "";
    foreach($records as $record) {
        $response .= '<tr>';
        $response .= '<td>'.$record->warehouseName.'</td>';
        $response .= '<td><a href="javascript:driver(' . $record->driverId . ')">'.$record->fullName.'</a></td>';
        $response .= '<td>'.$record->job_id.'</td>';
        $response .= '<td>'.$record->total_No_of_TP.'</td>';
        $response .= '<td>'.$record->daycount.'</td>';

        if ($record->carried_down > 0) {
            $response .= '<td><span class="Font-Green">' . $record->carried_down . '</span></td>';
        } else if ($record->carried_down < 0)  {
            $response .= '<td><span class="Font-Red">' . $record->carried_down . '</span></td>';
        } else $response .= '<td></td>';
        $response .= '<td>'.$record->Loan.'</td>';
        $response .= '<td>'.$record->CreditNote.'</td>';
        $response .= '<td>'.$record->set_credit.'</td>';
        $response .= '<td>'.$record->set_debit.'</td>';
        $response .= '<td class="Font-Green">'.$record->credit_now.'</td>';
        $response .= '<td class="Font-Red">'.$record->debit_now.'</td>';
        $response .= '<td>'.$record->expected_salary.'</td>';


        $readonly1 = $readonly = 'readonly style="cursor: not-allowed;"';
        $style2 = $style3 = $style1 = $style = '';
        if($record->iqama == '') {
            $readonly = '';
            $style = "class='red'";
        }
        if($record->mobileNumber == '') {
            $readonly1 = '';
            $style1 = "class='red'";
        }
        if($record->accountNumber == '') {
            $style2 = "class='red'";
        }
        if($record->account_owner_iqama == '') {
            $style3 = "class='red'";
        }
        $response .= '<td><input type="number" pattern="^5\d{9}$" onchange="validateAndSubmit(' . $record->driverId . ', 1, this)" '.$readonly1. $style1 .' name="mobileNumber" value="'.$record->mobileNumber.'"></td>';
        $response .= '<td><input type="number" onchange="validateAndSubmit(' . $record->driverId . ', 2, this)" '.$readonly. $style .' name="iqama" value="'.$record->iqama.'"></td>';
        $response .= '<td><input type="number" pattern="^966\d{12}$" onchange="validateAndSubmit(' . $record->driverId . ', 3, this)" '.$style2.' name="accountNumber" value="'.$record->accountNumber.'"></td>';
        $response .= '<td><input type="number" onchange="validateAndSubmit(' . $record->driverId . ', 4, this)" '.$style3.' name="account_owner_iqama" value="'.$record->account_owner_iqama.'"></td>';

        $response .= '</tr>';
    }
    $responses = [];
    $responses['body'] = $response;
    return $responses;
}


class SalaryControllerShe extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     * @throws \Exception
     */

     public function salaryRevert(Request $request) {
        $driverId = array();
        $driverId = $driverId[] = $request->driverId;
        $reason = $request->reason;
        $job_id = $request->job_id;

        $from_to = $request->from_to;
        $date_parts = explode(" - ", $from_to);
        $start_date = $date_parts[0];
        $end_date = $date_parts[1];

        $made_by = Auth::user()->name;
        $user_by = Auth::user()->id;
        $salary = DB::select("SELECT id, debit, journal_date FROM journal WHERE journal_type_id = '2' AND journal_date BETWEEN '$start_date' AND '$end_date' AND driverId = '$driverId'");
        if(count($salary) != 1) {
            return redirect()->back()->with('error', 'Something went wrong more than 1 record appearing.');
            exit();
        }
        $salary_id = $salary[0]->id;
        $amount = $salary[0]->debit;
        $journal_date = $salary[0]->journal_date;
        if ($user_by == 15) {
            DB::delete("DELETE FROM journal WHERE journal_type_id = '2' AND journal_date BETWEEN '$start_date' AND '$end_date' AND driverId = '$driverId'");
            DB::update("UPDATE journal set status = 'Ready', reverse_by = '$user_by', updated_at = NOW() WHERE journal_type_id = '6' AND journal_date BETWEEN '$start_date' AND '$end_date' AND driverId = '$driverId'");
            $msg = "<b>$made_by</b> Reverted the Salary from Paid to Ready with this Reason: " . $reason;
            HelperFunctionsController::add_log($msg, '', $salary_id);
            return redirect()->back()->with('success', 'Salary reverted successfully');
        } else {
            $msg = "<b>$made_by</b> Requested to revert the Salary from Paid to Ready with this Reason: " . $reason;
            HelperFunctionsController::add_log($msg, '', $salary_id);

            $subject = "Salary Reverse Request";
            $result = DB::select("SELECT drivers.fullName,drivers.job_id,warehouse.warehouseName,lkp_company.companyName FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE drivers.id='$driverId'");
            $driverId .= "_".$start_date."_".$end_date;
            $yes = url("/approval/salary/" . $reason . "/" . $driverId . "/1");
            $no = url("/approval/salary/" . $reason . "/" . $driverId . "/0");
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
                        <td style="border: 1px solid black; padding: 8px;">'.$journal_date.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->companyName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->warehouseName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$amount.'</td>
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
        $ready_statuss = $request->ready_statuss;
        $driver_ids = explode(",",$ready_statuss);
        $Period = explode(' - ', $request->from_to);
        $from = $Period[0];
        $to = $Period[1];
        $to = explode("-",$to);
        if($to[2] == 30 || $to[2] == 31) {
            $month = $to[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
            $to = $to[0] . "-" . $to[1] . "-" . $days;
        } else {
            $to = $Period[1];
        }
        $user = Auth::user(); // Assuming you're using Laravel's built-in authentication
        $user_id = $user->id;
        $journal_ids = $amp_ids = array();
        if (password_verify($request->input('password'), $user->password)) {
            foreach($driver_ids as $driver_id) {
                $driver = HelperFunctionsController::getDriverData($driver_id);
                $amp_ids[] = $driver->job_id;
                $journals = DB::select("SELECT id FROM journal where driverId = '$driver_id' AND journal_date BETWEEN '$from' AND '$to'"); //checkmate
                foreach($journals as $journal) {
                    $journal_ids[] = $journal->id;
                }
                DB::update("Update journal set status = 'Ready', exported_by = '0', reverse_by = '$user_id', updatedby_id = '$user_id', updated_at = NOW() where driverId = '$driver_id' AND journal_date BETWEEN '$from' AND '$to'");
            }
            if(count($journal_ids) > 0) {
                $made_by = Auth::user()->name;
                $amp_ids = implode(',', $amp_ids);
                $msg = "<b>$made_by</b> reversed the journal with driver amp_ids ('$amp_ids') fronm Onhold to Ready";
                HelperFunctionsController::add_log($msg, '', $journal_ids);
            }

            return redirect('/Salary_she')->with('success', "Status updated successfully");
        } else {
            // Password is incorrect
            return redirect('/Salary_she')->with('error', "Password is incorrect");

            // return response()->json(['message' => 'Password is incorrect'], 401);
        }
    }

    public function index(Request $request)
    {
        $lkp_company = DB::select("SELECT * from lkp_company WHERE id <> 6 AND status = 'active'");
        $from = 0;
        $to = 0;
        if (!empty($request->filter_companyId)) {
            $Period = explode(' - ', $request->filter_Period);
            $from = $Period[0];
            $to = $Period[1];

            $to = explode("-",$to);
            if($to[2] == 30 || $to[2] == 31) {
                $month = $to[1];
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
                $to = $to[0] . "-" . $to[1] . "-" . $days;
            } else {
                $to = $Period[1];
            }

            // dd($to);

        }

        $where = array();
        if (!empty($request->filter_companyId)) {
            $where[] = 'lkp_company.id=' . $request->filter_companyId;
            $filter_companyId = $request->filter_companyId;
        } else {
            $where[] = 'lkp_company.id=0';
            $filter_companyId = 0;
        }
        if (!empty($request->filter_cityId) AND $request->filter_cityId != 'All') {
            $where[] = 'lkp_city.id=' . $request->filter_cityId;
        }
        if (is_array($request->filter_warehouseId) > 0) {
            $where[] = 'warehouse.id in(' . implode(",", $request->filter_warehouseId) . ")";
        }
        if (empty($request->filter_PaidType)) {
            $where[] = "(total_No_of_TP >0 or No_of_TouchPoint >0 or credit_now<>0)";
        } else {
            $where[] = "(debit_now<>0 or credit_now<>0 or paid_salary<>0)";
        }
        if ($request->filter_paid_id <> "") {
            if ($request->filter_paid_id == "1") {
                $where[] = 'TRIM(ROUND(paid_salary,2))+0 >0';
            }
            if ($request->filter_paid_id == "2") {
                $where[] = 'TRIM(ROUND(paid_salary,2))+0 =0';
            }
        }
        $where2 = implode(" AND ", $where);
        if (count($where) > 0) {
            $where2 = " where " . $where2;
        }
        try {
            $query = "select
                drivers.id as driverId,companyName,name_en as city_name,warehouseName,fullName,drivers.job_id,IF(account_owner_iqama<>'',account_owner_iqama,iqama) as iqama,TRIM(account_owner_iqama) as account_owner_iqama,under_sopnsorship_id,bank_id,bank_name_en,TRIM(accountNumber) AS accountNumber,
                TRIM(ROUND(credit_now,2))+0 as credit_now,
                NULLIF(TRIM(debit_now)+0,0) as debit_now,
                NULLIF(TRIM(ROUND(carried_down,2))+0,0) as carried_down,
                TRIM(ROUND(IFNULL(credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0),0),2))+0 as expected_salary,
                TRIM(ROUND(if(credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0)>0,credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0),''),2))+0 as edit_salary,
                TRIM(ROUND(paid_salary,2))+0 as paid_salary,
                NULLIF(TRIM(Loan)+0,0) as Loan,
                NULLIF(TRIM(CreditNote)+0,0) as CreditNote,
                TRIM(IND)+0 as IND,
                TRIM(if(IFNULL(IND,0)>0,IND,if(under_sopnsorship_id=1,0,0)))+0 as IND2,

                TRIM(ROUND(IFNULL(credit_now-debit_now+carried_down-paid_salary-IFNULL(IND,0),0),2))+0 as brought_down,
                daycount,
                TRIM(IFNULL(if(lkp_company.calculation_method_id=1,total_No_of_TP,total_No_of_D),0)+IFNULL(GAP/warehouse.Sunday,0))+0 as total_No_of_TP,
                No_of_TouchPoint,
                IF(IFNULL(if(lkp_company.calculation_method_id=1,total_No_of_TP,total_No_of_D),0)+IFNULL(GAP/warehouse.Sunday,0)=IFNULL(No_of_TouchPoint,0),'Yes','No') as matching,
                NULLIF(TRIM(GAP)+0,0) as GAP,
                CASE
                WHEN bank_transaction.amount is null THEN 'Null'
                WHEN IF(paid_salary is not null,paid_salary,
                TRIM(IFNULL(IFNULL(credit_now,0)-IFNULL(debit_now,0)+IFNULL(carried_down,0)-if(under_sopnsorship_id=1,0,0),0))+0
                )=IFNULL(bank_transaction.amount,0) THEN 'Yes'
                ELSE 'No'
                END matching_transaction,
                IFNULL(TRIM(bank_transaction.amount)+0,' ') as amount

                 from drivers
                 inner join warehouse on drivers.warehouseId=warehouse.id
                 inner join lkp_city on warehouse.cityId=lkp_city.id
                 inner join lkp_company on warehouse.companyId=lkp_company.id
                 left join lkp_bank on lkp_bank.id=drivers.bank_id
                LEFT JOIN
                     (
                        select driverId,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id<>2,IFNULL(credit, 0),0))as credit_now,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id<>2 and journal_type_id<>5 and journal_type_id<>8,IFNULL(debit, 0),0))as debit_now,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=2,IFNULL(debit, 0),0))as paid_salary,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=1,IFNULL(debit, 0),0))as Loan,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=3,IFNULL(debit, 0),0))as CreditNote,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=5,IFNULL(debit, 0),0))as IND,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=6 ,1,0))as daycount,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=4,IFNULL(credit, 0),0)) as GAP,
                        sum(IF(journal_date < '" . $from . "',IFNULL(credit, 0)- IFNULL(debit, 0),0)) as carried_down
                        from journal
                        group by driverId
                           )journal_now on  journal_now.driverId=drivers.id

                LEFT JOIN
                     (
                        select driverId,sum(IFNULL(No_of_TP, 0))  as total_No_of_TP,sum(IFNULL(No_of_D, 0))  as total_No_of_D
                        from packages_report
                        where pakage_date BETWEEN '" . $from . "' AND '" . $to . "'
                        group by driverId
                     )pack on pack.driverId=drivers.id
                 LEFT JOIN
                     (
                        select driverId,sum(IFNULL(if(lkp_company.calculation_method_id=1,No_of_TouchPoint,No_of_Delivered),0)) as No_of_TouchPoint
                        from noon_pack
                        inner JOIN lkp_journal_period on lkp_journal_period.id=noon_pack.period_id
                        INNER JOIN lkp_company on lkp_company.id=lkp_journal_period.companyId
                        where lkp_journal_period.companyId=" . $filter_companyId . "
                         and lkp_journal_period.period_from_dt='" . $from . "' and lkp_journal_period.period_to_dt='" . $to . "'
                        group by driverId
                     )noon_pack on  noon_pack.driverId=drivers.id
                 left JOIN
                        (
                        select amount,driverId from bank_transaction
                        inner JOIN lkp_journal_period on lkp_journal_period.id=bank_transaction.period_id and lkp_journal_period.companyId=1
                        and lkp_journal_period.period_from_dt='" . $from . "' and lkp_journal_period.period_to_dt='" . $to . "'
                        )bank_transaction on bank_transaction.driverId = drivers.id
                 " . $where2;

             $query1 = "select
                drivers.id as driverId,companyName,name_en as city_name,warehouseName,fullName,drivers.job_id, iqama,TRIM(account_owner_iqama) as account_owner_iqama,under_sopnsorship_id,bank_id,bank_name_en,TRIM(accountNumber) AS accountNumber,
                TRIM(ROUND(credit_now,2))+0 as credit_now,
                NULLIF(TRIM(debit_now)+0,0) as debit_now,
                NULLIF(TRIM(ROUND(carried_down,2))+0,0) as carried_down,
                TRIM(ROUND(IFNULL(credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0),0),2))+0 as expected_salary,
                TRIM(ROUND(if(credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0)>0,credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0),''),2))+0 as edit_salary,
                TRIM(ROUND(paid_salary,2))+0 as paid_salary,
                NULLIF(TRIM(Loan)+0,0) as Loan,
                NULLIF(TRIM(CreditNote)+0,0) as CreditNote,
                TRIM(IND)+0 as IND,
                TRIM(if(IFNULL(IND,0)>0,IND,if(under_sopnsorship_id=1,0,0)))+0 as IND2,

                TRIM(ROUND(IFNULL(credit_now-debit_now+carried_down-paid_salary-IFNULL(IND,0),0),2))+0 as brought_down,
                daycount,
                TRIM(IFNULL(if(lkp_company.calculation_method_id=1,total_No_of_TP,total_No_of_D),0)+IFNULL(GAP/warehouse.Sunday,0))+0 as total_No_of_TP,
                No_of_TouchPoint,
                IF(IFNULL(if(lkp_company.calculation_method_id=1,total_No_of_TP,total_No_of_D),0)+IFNULL(GAP/warehouse.Sunday,0)=IFNULL(No_of_TouchPoint,0),'Yes','No') as matching,
                NULLIF(TRIM(GAP)+0,0) as GAP,
                CASE
                WHEN bank_transaction.amount is null THEN 'Null'
                WHEN IF(paid_salary is not null,paid_salary,
                TRIM(IFNULL(IFNULL(credit_now,0)-IFNULL(debit_now,0)+IFNULL(carried_down,0)-if(under_sopnsorship_id=1,0,0),0))+0
                )=IFNULL(bank_transaction.amount,0) THEN 'Yes'
                ELSE 'No'
                END matching_transaction,
                IFNULL(TRIM(bank_transaction.amount)+0,' ') as amount

                 from drivers
                 inner join warehouse on drivers.warehouseId=warehouse.id
                 inner join lkp_city on warehouse.cityId=lkp_city.id
                 inner join lkp_company on warehouse.companyId=lkp_company.id
                 left join lkp_bank on lkp_bank.id=drivers.bank_id
                LEFT JOIN
                     (
                        select driverId,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id<>2,IFNULL(credit, 0),0))as credit_now,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id<>2 and journal_type_id<>5 and journal_type_id<>8,IFNULL(debit, 0),0))as debit_now,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=2,IFNULL(debit, 0),0))as paid_salary,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=1,IFNULL(debit, 0),0))as Loan,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=3,IFNULL(debit, 0),0))as CreditNote,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=5,IFNULL(debit, 0),0))as IND,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=6 ,1,0))as daycount,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=4,IFNULL(credit, 0),0)) as GAP,
                        sum(IF(journal_date < '" . $from . "',IFNULL(credit, 0)- IFNULL(debit, 0),0)) as carried_down
                        from journal
                        group by driverId
                           )journal_now on  journal_now.driverId=drivers.id

                LEFT JOIN
                     (
                        select driverId,sum(IFNULL(No_of_TP, 0))  as total_No_of_TP,sum(IFNULL(No_of_D, 0))  as total_No_of_D
                        from packages_report
                        where pakage_date BETWEEN '" . $from . "' AND '" . $to . "'
                        group by driverId
                     )pack on pack.driverId=drivers.id
                 LEFT JOIN
                     (
                        select driverId,sum(IFNULL(if(lkp_company.calculation_method_id=1,No_of_TouchPoint,No_of_Delivered),0)) as No_of_TouchPoint
                        from noon_pack
                        inner JOIN lkp_journal_period on lkp_journal_period.id=noon_pack.period_id
                        INNER JOIN lkp_company on lkp_company.id=lkp_journal_period.companyId
                        where lkp_journal_period.companyId=" . $filter_companyId . "
                         and lkp_journal_period.period_from_dt='" . $from . "' and lkp_journal_period.period_to_dt='" . $to . "'
                        group by driverId
                     )noon_pack on  noon_pack.driverId=drivers.id
                 left JOIN
                        (
                        select amount,driverId from bank_transaction
                        inner JOIN lkp_journal_period on lkp_journal_period.id=bank_transaction.period_id and lkp_journal_period.companyId=1
                        and lkp_journal_period.period_from_dt='" . $from . "' and lkp_journal_period.period_to_dt='" . $to . "'
                        )bank_transaction on bank_transaction.driverId = drivers.id
                 " . $where2;

            // $Select_db = DB::table(DB::raw("(" . $query . ") as sub"));

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', $from . $to . $e->getPrevious()->getMessage());
        }
        if ($from == 0) {
            return view('new_porttal.Salary.index')->with(compact('lkp_company'));
        } else {
            // check records in packages_report and insert
            $journals_type_6 = DB::select("SELECT journal.driverId FROM journal INNER JOIN drivers ON journal.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE lkp_company.id = '$filter_companyId' AND journal_date BETWEEN ? AND ? AND journal_type_id = 6 AND credit is not null", [$from, $to]);
            $drivers_ids = array_map(function($journal) {
                return $journal->driverId;
            }, $journals_type_6);
            if (count($drivers_ids) > 0) {
                // All drivers except daily load
                $journals_not_type_6 = DB::select("SELECT journal.driverId FROM journal INNER JOIN drivers ON journal.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE lkp_company.id = '$filter_companyId' AND journal.journal_date BETWEEN ? AND ? AND journal.driverId NOT IN (" . implode(",", $drivers_ids) . ") GROUP BY journal.driverId", [$from, $to]);
                if (count($journals_not_type_6) > 0) {
                    foreach ($journals_not_type_6 as $journal) {
                        $driverId = $journal->driverId;
                        // new start
                        $journals_previous = DB::select("SELECT sum(journal.credit) as credit_sum, sum(journal.debit) as debit_sum FROM journal INNER JOIN drivers ON journal.driverId=drivers.id WHERE journal.journal_date BETWEEN ? AND ? AND journal.driverId = '$driverId'", ['2018-01-01', $from]);
                        if (($journals_previous[0]->credit_sum - $journals_previous[0]->debit_sum) > 0) {
                            $check = DB::SELECT("SELECT * FROM packages_report WHERE driverId = '$driverId' AND pakage_date = '$from'");
                            if (count($check) > 0) {} else {
                                DB::insert("INSERT INTO packages_report (driverId, pakage_date, created_at, updated_at, updatedby_id, updated_usertypeid, No_of_TP) VALUES (?, ?, NOW(), NOW(), 75, 1, 1)", [$driverId, $from]);
                            }
                        }
                    }
                }
            }
            // end
            $records = DB::select($query);
            foreach($records as $record) {
                $record->day_loaded = get_daily_load($record->driverId, $from, $to);
                $result_arr = get_journal_status($record->driverId, $from, $to);
                $record->journal_status = $result_arr[0];
                $record->exported_by = $result_arr[1];
                if(isset($result_arr[2]) AND $result_arr[2] > 0)
                    $record->export_attempt = $result_arr[2];
                else
                    $record->export_attempt = 0;
            }
            $responses = [];
            $responses = make_salary_table_body($records);
            echo $responses['body'];
            echo ':::';
            echo $responses['pack_total'];
            echo ':::';
            echo $responses['final_pack_total'];
            echo ':::';
            echo $responses['match_total'];
            echo ':::';
            echo $responses['gap_total'];
            echo ':::';
            echo $responses['days_total'];
            echo ':::';
            echo $responses['c_down_total'];
            echo ':::';
            echo $responses['day_load_total'];
            echo ':::';
            echo $responses['credit_total'];
            echo ':::';
            echo $responses['debit_total'];
            echo ':::';
            echo $responses['loan_total'];
            echo ':::';
            echo $responses['cn_total'];
            echo ':::';
            echo $responses['ind_total'];
            echo ':::';
            echo $responses['exp_salary_total'];
            echo ':::';
            echo $responses['paid_salary_total'];
            echo ':::';
            echo $responses['t_total'];
            echo ':::';
            echo $responses['brought_total'];
            echo ':::';
            echo $from . ' - ' . $to;
            // echo '<b><font color="red">' . $from . '    ' . $to . '</font></b>';
            echo ':::';
            echo $from . '*' . $to;
            // echo str_replace(' - ', '*', $request->filter_Period);
            echo ':::';
            echo $request->filter_companyId;
            echo ':::';
            echo $query1;
            echo ':::';
            echo $responses['check'];
            echo ':::';
            echo $responses['btn'];
        }

    }
    // For supervisors
    public function Salaries(Request $request) {
        $user_id = Auth::user()->id;
        if (Auth::user()->user_type_id <> 1) {
            $lkp_company  = DB::select("SELECT DISTINCT lkp_company.id,lkp_company.companyName FROM `users_privilege` JOIN warehouse ON warehouse.id = users_privilege.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE users_privilege.user_id = '$user_id' AND lkp_company.id <> 6 AND lkp_company.status = 'active'");
        } else {
            $lkp_company  = DB::select("SELECT id, companyName FROM `lkp_company` WHERE lkp_company.id <> 6 AND lkp_company.status = 'active'");
        }
        $from = 0;
        $to = 0;
        if (!empty($request->filter_companyId)) {
            $Period = explode(' - ', $request->filter_Period);
            $from = $Period[0];
            $to = $Period[1];

            $to = explode("-",$to);
            if($to[2] == 30 || $to[2] == 31) {
                $month = $to[1];
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
                $to = $to[0] . "-" . $to[1] . "-" . $days;
            } else {
                $to = $Period[1];
            }

            // dd($to);

        }

        $where = array();
        if (!empty($request->filter_companyId)) {
            $where[] = 'lkp_company.id=' . $request->filter_companyId;
            $filter_companyId = $request->filter_companyId;
        } else {
            $where[] = 'lkp_company.id=0';
            $filter_companyId = 0;
        }
        if (!empty($request->filter_cityId) AND $request->filter_cityId != 'All') {
            $where[] = 'lkp_city.id=' . $request->filter_cityId;
        }
        if (is_array($request->filter_warehouseId) > 0) {
            $where[] = 'warehouse.id in(' . implode(",", $request->filter_warehouseId) . ")";
        }
        if (empty($request->filter_PaidType)) {
            $where[] = "(total_No_of_TP >0 or No_of_TouchPoint >0 or credit_now<>0)";
        } else {
            $where[] = "(debit_now<>0 or credit_now<>0 or paid_salary<>0)";
        }
        if ($request->filter_paid_id <> "") {
            if ($request->filter_paid_id == "1") {
                $where[] = 'TRIM(ROUND(paid_salary,2))+0 >0';
            }
            if ($request->filter_paid_id == "2") {
                $where[] = 'TRIM(ROUND(paid_salary,2))+0 =0';
            }
        }
        $where2 = implode(" AND ", $where);
        if (count($where) > 0) {
            $where2 = " where " . $where2;
        }
        try {
            $query = "select
                drivers.id as driverId,mobileNumber,companyName,name_en as city_name,warehouseName,fullName,drivers.job_id, iqama, TRIM(account_owner_iqama) as account_owner_iqama,under_sopnsorship_id,bank_id,bank_name_en,TRIM(accountNumber) AS accountNumber,
                TRIM(ROUND(credit_now,2))+0 as credit_now,
                NULLIF(TRIM(debit_now)+0,0) as debit_now,
                NULLIF(TRIM(ROUND(carried_down,2))+0,0) as carried_down,
                TRIM(ROUND(IFNULL(credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0),0),2))+0 as expected_salary,
                TRIM(ROUND(if(credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0)>0,credit_now-debit_now+carried_down-if(under_sopnsorship_id=1,0,0),''),2))+0 as edit_salary,
                TRIM(ROUND(paid_salary,2))+0 as paid_salary,
                NULLIF(TRIM(Loan)+0,0) as Loan,
                NULLIF(TRIM(CreditNote)+0,0) as CreditNote,
                TRIM(IND)+0 as IND,
                TRIM(if(IFNULL(IND,0)>0,IND,if(under_sopnsorship_id=1,0,0)))+0 as IND2,


                TRIM(ROUND(IFNULL(credit_now-debit_now+carried_down-paid_salary-IFNULL(IND,0),0),2))+0 as brought_down,
                daycount,
                TRIM(IFNULL(if(lkp_company.calculation_method_id=1,total_No_of_TP,total_No_of_D),0)+IFNULL(GAP/warehouse.Sunday,0))+0 as total_No_of_TP,
                No_of_TouchPoint,
                IF(IFNULL(if(lkp_company.calculation_method_id=1,total_No_of_TP,total_No_of_D),0)+IFNULL(GAP/warehouse.Sunday,0)=IFNULL(No_of_TouchPoint,0),'Yes','No') as matching,
                NULLIF(TRIM(GAP)+0,0) as GAP,
                CASE
                WHEN bank_transaction.amount is null THEN 'Null'
                WHEN IF(paid_salary is not null,paid_salary,
                TRIM(IFNULL(IFNULL(credit_now,0)-IFNULL(debit_now,0)+IFNULL(carried_down,0)-if(under_sopnsorship_id=1,0,0),0))+0
                )=IFNULL(bank_transaction.amount,0) THEN 'Yes'
                ELSE 'No'
                END matching_transaction,
                IFNULL(TRIM(bank_transaction.amount)+0,' ') as amount

                 from drivers
                 inner join warehouse on drivers.warehouseId=warehouse.id
                 inner join lkp_city on warehouse.cityId=lkp_city.id
                 inner join lkp_company on warehouse.companyId=lkp_company.id
                 left join lkp_bank on lkp_bank.id=drivers.bank_id
                LEFT JOIN
                     (
                        select driverId,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id<>2,IFNULL(credit, 0),0))as credit_now,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id<>2 and journal_type_id<>5 and journal_type_id<>8,IFNULL(debit, 0),0))as debit_now,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=2,IFNULL(debit, 0),0))as paid_salary,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=1,IFNULL(debit, 0),0))as Loan,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=3,IFNULL(debit, 0),0))as CreditNote,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=5,IFNULL(debit, 0),0))as IND,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=6 ,1,0))as daycount,
                        sum(IF(journal_date BETWEEN '" . $from . "' AND '" . $to . "' AND journal_type_id=4,IFNULL(credit, 0),0)) as GAP,
                        sum(IF(journal_date < '" . $from . "',IFNULL(credit, 0)- IFNULL(debit, 0),0)) as carried_down
                        from journal
                        group by driverId
                           )journal_now on  journal_now.driverId=drivers.id

                LEFT JOIN
                     (
                        select driverId,sum(IFNULL(No_of_TP, 0))  as total_No_of_TP,sum(IFNULL(No_of_D, 0))  as total_No_of_D
                        from packages_report
                        where pakage_date BETWEEN '" . $from . "' AND '" . $to . "'
                        group by driverId
                     )pack on pack.driverId=drivers.id
                 LEFT JOIN
                     (
                        select driverId,sum(IFNULL(if(lkp_company.calculation_method_id=1,No_of_TouchPoint,No_of_Delivered),0)) as No_of_TouchPoint
                        from noon_pack
                        inner JOIN lkp_journal_period on lkp_journal_period.id=noon_pack.period_id
                        INNER JOIN lkp_company on lkp_company.id=lkp_journal_period.companyId
                        where lkp_journal_period.companyId=" . $filter_companyId . "
                         and lkp_journal_period.period_from_dt='" . $from . "' and lkp_journal_period.period_to_dt='" . $to . "'
                        group by driverId
                     )noon_pack on  noon_pack.driverId=drivers.id
                 left JOIN
                        (
                        select amount,driverId from bank_transaction
                        inner JOIN lkp_journal_period on lkp_journal_period.id=bank_transaction.period_id and lkp_journal_period.companyId=1
                        and lkp_journal_period.period_from_dt='" . $from . "' and lkp_journal_period.period_to_dt='" . $to . "'
                        )bank_transaction on bank_transaction.driverId = drivers.id
                 " . $where2;

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', $from . $to . $e->getPrevious()->getMessage());
        }
        if ($from == 0) {
            return view('new_porttal.Salary.index_supervisors')->with(compact('lkp_company'));
        } else {
            // check records in packages_report and insert
            $journals_type_6 = DB::select("SELECT journal.driverId FROM journal INNER JOIN drivers ON journal.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE lkp_company.id = '$filter_companyId' AND journal_date BETWEEN ? AND ? AND journal_type_id = 6 AND credit is not null", [$from, $to]);
            $drivers_ids = array_map(function($journal) {
                return $journal->driverId;
            }, $journals_type_6);
            if (count($drivers_ids) > 0) {
                // All drivers except daily load
                $journals_not_type_6 = DB::select("SELECT journal.driverId FROM journal INNER JOIN drivers ON journal.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE lkp_company.id = '$filter_companyId' AND journal.journal_date BETWEEN ? AND ? AND journal.driverId NOT IN (" . implode(",", $drivers_ids) . ") GROUP BY journal.driverId", [$from, $to]);
                if (count($journals_not_type_6) > 0) {
                    foreach ($journals_not_type_6 as $journal) {
                        $driverId = $journal->driverId;
                        // new start
                        $journals_previous = DB::select("SELECT sum(journal.credit) as credit_sum, sum(journal.debit) as debit_sum FROM journal INNER JOIN drivers ON journal.driverId=drivers.id WHERE journal.journal_date BETWEEN ? AND ? AND journal.driverId = '$driverId'", ['2018-01-01', $from]);
                        if (($journals_previous[0]->credit_sum - $journals_previous[0]->debit_sum) > 0) {
                            $check = DB::SELECT("SELECT * FROM packages_report WHERE driverId = '$driverId' AND pakage_date = '$from'");
                            if (count($check) > 0) {} else {
                                DB::insert("INSERT INTO packages_report (driverId, pakage_date, created_at, updated_at, updatedby_id, updated_usertypeid, No_of_TP) VALUES (?, ?, NOW(), NOW(), 75, 1, 1)", [$driverId, $from]);
                            }
                        }
                    }
                }
            }
            // end
            $records = DB::select($query);
            foreach($records as $record) {
                $credit_debit = get_settlement_credit_debit($record->driverId, $from, $to);
                $record->set_credit = $credit_debit[0];
                $record->set_debit = $credit_debit[1];
            }
            $responses = [];
            $responses = make_salary_table_body_supervisors($records);
            echo $responses['body'];
            echo ':::';
            echo $from . '*' . $to;
            // echo str_replace(' - ', '*', $request->filter_Period);
            echo ':::';
            echo $request->filter_companyId;
            echo ':::';
            echo $query;
            echo ':::';
            echo $responses['check'];
            echo ':::';
            echo $responses['btn'];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $from = 0;
        $to = 0;
        if (!empty($request->input('companyId'))) {
            $Period = explode('*', $request->input('Period'));
            $from = $Period[0];
            $to = $Period[1];
            $to = explode("-",$to);
            if($to[2] == 30 || $to[2] == 31) {
                $month = $to[1];
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
                $to = $to[0] . "-" . $to[1] . "-" . $days;
            } else {
                $to = $Period[1];
            }
            $company = DB::select('SELECT * from lkp_company where id=' . $request->input('companyId'))[0];
            if ($company->period_start == "1") {
                $d = explode('-', $to);
                $last_day = cal_days_in_month(CAL_GREGORIAN, $d[1], $d[0]);
                $last_day = $d[0] . '-' . $d[1] . '-' . $last_day;
            } else {
                $last_day = $to;
            }

        }

        $values = '';
        $k = 0;
        $status = 'Paid';
        $journal_ids = $amp_ids = array();
        for ($i = 0; $i < 500; $i++) {
            if (!empty($request->input('ID_' . $i)) && !empty($request->input('paid_salary_' . $i))) {
                $k++;
                $values .= "(" . $request->input('ID_' . $i) . ",'" . $last_day . "'," . $request->input('paid_salary_' . $i) . ",
                null,null,2,null," . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "','" . $status . "'),";
                $driver = HelperFunctionsController::getDriverData($request->input('ID_' . $i));
                $amp_ids[] = $driver->job_id;
                $affectedRows = DB::update("UPDATE journal set status = '$status' WHERE driverId = ". $request->input('ID_' . $i));
                if ($affectedRows > 0) {
                    $ids = DB::table('journal')
                    ->where('driverId', $request->input('ID_' . $i))
                    ->pluck('id')
                    ->toArray();
                    $journal_ids = array_merge($journal_ids, $ids);
                }
                if (!empty($request->input('IND_' . $i)) && $request->input('IND_' . $i) > 0) {
                    $values .= "(" . $request->input('ID_' . $i) . ",'" . $last_day . "'," . $request->input('IND_' . $i) . ",
                    null,null,5,null," . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'),";
                }


            }
        }
        if(count($amp_ids) > 0) {
            $made_by = Auth::user()->name;
            $amp_ids = implode(',', $amp_ids);
            $msg = "<b>$made_by</b> updated the journal with driver amp_ids ('$amp_ids') to Paid";
            HelperFunctionsController::add_log($msg, '', $journal_ids);
        }
        $values = substr($values, 0, strlen($values) - 1);
        // echo $values;
        // exit;
        if ($values <> '') {
            try {
                DB::insert("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
                createdby_id,updatedby_id,created_at,updated_at, status)
                  VALUES
                  " . $values);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('error', $e->getPrevious()->getMessage());
            }
        }
        return redirect()->back()->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param $Period
     * @return Application|Factory|Response|View
     */
    public function SalaryShow(int $id, $Period)
    {
        $from = 0;
        $to = 0;

        $P = explode('*', $Period);
        $from = $P[0];
        $to = $P[1];
        $to = explode("-",$to);
        if($to[2] == 30 || $to[2] == 31) {
            $month = $to[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
            $to = $to[0] . "-" . $to[1] . "-" . $days;
        } else {
            $to = $P[1];
        }

        // dd($to);

        $company = DB::select("SELECT TRIM(bank_transaction.amount)+0 as amount,period_start,period_end,companyName,warehouseName,fullName,calculation_method_id from drivers
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        left JOIN
        ( select amount,job_id from bank_transaction
        inner JOIN lkp_journal_period ON lkp_journal_period.id = bank_transaction.period_id
        AND lkp_journal_period.period_from_dt = '" . $from . "'
        AND lkp_journal_period.period_to_dt = '" . $to . "'
        )bank_transaction  ON upper(bank_transaction.job_id) = upper(drivers.job_id)
        where drivers.id=" . $id)[0];


        //if ($company->period_start == "1") {
        //$from = date('Y-m', strtotime(date('Y-m') . ' -1 MONTH')) . "-01";
        // $to = date('Y-m-d', strtotime('last day of previous month'));
        // } else {
        //if (date('d') < $company->period_start) {
        //    $from = date('Y-m-d', strtotime(date('Y-m-' . $company->period_start) . ' -2 MONTH'));
        //    $to = date('Y-m-d', strtotime(date('Y-m-' . ($company->period_start - 1)) . ' -1 MONTH'));
        //} elseif (date('d') >= $company->period_start) {
        //   $from = date('Y-m-d', strtotime(date('Y-m-' . $company->period_start) . ' -1 MONTH'));
        //    $to = date('Y-m-d', strtotime(date('Y-m-' . ($company->period_start - 1))));
        //}
        //}

        //$from='2020-03-21';
        //$to='2020-04-20';

        $Carried_Down = DB::select("select
        sum(IFNULL(credit, 0)) as credit,sum(IFNULL(debit, 0)) as debit,sum(IFNULL(credit, 0))- sum(IFNULL(debit, 0)) as carried_down
        from journal
        WHERE journal_date < '" . $from . "' and driverId=" . $id)[0];
        //   dd($Carried_Down);

        $qq = DB::select("SELECT post_id, journal.createdby_id, journal.note,a.date,DAYNAME(a.date) AS dayname,journal_type,No_of_D AS no_of_deliverd,No_of_TP AS no_of_touch_point,unit_cost,credit,debit,IFNULL(credit,0)-IFNULL(debit,0) AS Carried_Down FROM (
            SELECT date_add('" . $from . "', INTERVAL seq DAY) AS date FROM (
            SELECT @ROW :=@ROW+1 AS seq FROM (
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t,(
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t2,(
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t3,(
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t4,(
            SELECT @ROW :=-1) r ORDER BY seq) sequence WHERE date_add('" . $from . "', INTERVAL seq DAY) <= '" . $to . "') a LEFT JOIN journal ON journal.journal_date=a.date AND journal.driverId=" . $id . " LEFT JOIN lkp_journal_type ON lkp_journal_type.id=journal.journal_type_id LEFT JOIN packages_report ON packages_report.id=journal.post_id
            AND journal_type_id=6 ORDER BY date,journal_type");
        foreach($qq as $q) {
            $q->created_by = "";
            if($q->createdby_id > 0) {
                $user = DB::select("SELECT name from users where id = " .$q->createdby_id);
                $q->created_by = $user[0]->name;
            }
        }

        return view('new_porttal.Salary.show')->with(compact('from'))->with(compact('to'))
            ->with(compact('company'))
            ->with(compact('Carried_Down'))
            ->with(compact('qq'));
    }

    public function SalaryShowNew(int $id, $Period)
    {
        $from = 0;
        $to = 0;

        $P = explode('*', $Period);
        $from = $P[0];
        $to = $P[1];
        $to = explode("-",$to);
        if($to[2] == 30 || $to[2] == 31) {
            $month = $to[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
            $to = $to[0] . "-" . $to[1] . "-" . $days;
        } else {
            $to = $P[1];
        }

        // dd($to);

        $company = DB::select("SELECT TRIM(bank_transaction.amount)+0 as amount,period_start,period_end,companyName,warehouseName,fullName,calculation_method_id from drivers
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        left JOIN
        ( select amount,job_id from bank_transaction
        inner JOIN lkp_journal_period ON lkp_journal_period.id = bank_transaction.period_id
        AND lkp_journal_period.period_from_dt = '" . $from . "'
        AND lkp_journal_period.period_to_dt = '" . $to . "'
        )bank_transaction  ON upper(bank_transaction.job_id) = upper(drivers.job_id)
        where drivers.id=" . $id)[0];


        //if ($company->period_start == "1") {
        //$from = date('Y-m', strtotime(date('Y-m') . ' -1 MONTH')) . "-01";
        // $to = date('Y-m-d', strtotime('last day of previous month'));
        // } else {
        //if (date('d') < $company->period_start) {
        //    $from = date('Y-m-d', strtotime(date('Y-m-' . $company->period_start) . ' -2 MONTH'));
        //    $to = date('Y-m-d', strtotime(date('Y-m-' . ($company->period_start - 1)) . ' -1 MONTH'));
        //} elseif (date('d') >= $company->period_start) {
        //   $from = date('Y-m-d', strtotime(date('Y-m-' . $company->period_start) . ' -1 MONTH'));
        //    $to = date('Y-m-d', strtotime(date('Y-m-' . ($company->period_start - 1))));
        //}
        //}

        //$from='2020-03-21';
        //$to='2020-04-20';

        $Carried_Down = DB::select("select
        sum(IFNULL(credit, 0)) as credit,sum(IFNULL(debit, 0)) as debit,sum(IFNULL(credit, 0))- sum(IFNULL(debit, 0)) as carried_down
        from journal
        WHERE journal_date < '" . $from . "' and driverId=" . $id)[0];
        //   dd($Carried_Down);

        $qq = DB::select("SELECT post_id, journal.createdby_id, journal.note,a.date,DAYNAME(a.date) AS dayname,journal_type,No_of_D AS no_of_deliverd,No_of_TP AS no_of_touch_point,unit_cost,credit,debit,IFNULL(credit,0)-IFNULL(debit,0) AS Carried_Down FROM (
            SELECT date_add('" . $from . "', INTERVAL seq DAY) AS date FROM (
            SELECT @ROW :=@ROW+1 AS seq FROM (
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t,(
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t2,(
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t3,(
            SELECT 0 UNION ALL
            SELECT 1 UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9) t4,(
            SELECT @ROW :=-1) r ORDER BY seq) sequence WHERE date_add('" . $from . "', INTERVAL seq DAY) <= '" . $to . "') a LEFT JOIN journal ON journal.journal_date=a.date AND journal.driverId=" . $id . " LEFT JOIN lkp_journal_type ON lkp_journal_type.id=journal.journal_type_id LEFT JOIN packages_report ON packages_report.id=journal.post_id
            AND journal_type_id=6 ORDER BY date,journal_type");
        foreach($qq as $q) {
            $q->created_by = "";
            if($q->createdby_id > 0) {
                $user = DB::select("SELECT name from users where id = " .$q->createdby_id);
                $q->created_by = $user[0]->name;
            }
        }

        return view('new_porttal.Salary.show_new')->with(compact('from'))->with(compact('to'))
            ->with(compact('company'))
            ->with(compact('Carried_Down'))
            ->with(compact('qq'));
    }

    //****************************************************************************************************************
    //****************************************************************************************************************
    public function SalaryPaid(Request $request)
    {
        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Paid_DB = \Illuminate\Support\Facades\DB::table(DB::raw("(SELECT
           salary_import_paid_details.account_owner_iqama,
           salary_import_paid_details.accountNumber,
           salary_import_paid_details.bank_sum,
           GROUP_CONCAT(journal.id SEPARATOR ';') AS id,
           GROUP_CONCAT(drivers.job_id SEPARATOR ';') AS AMP_ID,
           GROUP_CONCAT(drivers.fullName SEPARATOR ';') AS fullName,
           GROUP_CONCAT(journal.journal_date SEPARATOR';') AS journal_date,
           GROUP_CONCAT(salary_import_paid_details.paid SEPARATOR';') AS paid,
           GROUP_CONCAT(journal.debit SEPARATOR ';') AS salary_amount,
           GROUP_CONCAT(drivers.id SEPARATOR ';') AS driverId,
           GROUP_CONCAT(warehouseName SEPARATOR ';') AS warehouseName,
           GROUP_CONCAT(companyName SEPARATOR ';') AS companyName,
           GROUP_CONCAT(journal.updated_at SEPARATOR ';') AS updated_at
        FROM
           journal
        LEFT JOIN `drivers` ON `journal`.`driverId` = `drivers`.`id`
        LEFT JOIN `warehouse` ON `drivers`.`warehouseId` = `warehouse`.`id`
        LEFT JOIN `lkp_company` ON `warehouse`.`companyId` = `lkp_company`.`id`
        INNER JOIN salary_import_paid_details ON salary_import_paid_details.journal_id = journal.id
        AND paid_master_id = (SELECT MAX(id) FROM salary_import_paid_master)
        where journal_type_id=2
        GROUP BY
           salary_import_paid_details.account_owner_iqama,
           salary_import_paid_details.accountNumber,
           salary_import_paid_details.bank_sum) as sub"))->get();
        if (isset($success))
            return view('Salary.SalaryPaidShe')->with(compact('Paid_DB'))->with('success', $success);
        elseif (isset($error))
            return view('Salary.SalaryPaidShe')->with(compact('Paid_DB'))->with('error', $error);
        else
            return view('Salary.SalaryPaidShe')->with(compact('Paid_DB'));

    }
    //****************************************************************************************************************
    //****************************************************************************************************************
    /**
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \Illuminate\Validation\ValidationException
     */
    public function SalaryPaidSave(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);

        $user_id = Auth::user()->id;

        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');

        $pieces = explode("_", $request->file('select_file')->getClientOriginalName());

        if (!is_numeric($pieces[1])) {
            $Paid_DB = array();
            return view('Salary.SalaryPaidShe')->with(compact('Paid_DB'))->with('error', 'Not Salary File');
        }
        //----------------------------------------------------------------------------------------------------------


        $Period = explode(' - ', $pieces[2]);
        $from = $Period[0];
        $to = $Period[1];
        $to = explode("-",$to);
        if($to[2] == 30 || $to[2] == 31) {
            $month = $to[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
            $to = $to[0] . "-" . $to[1] . "-" . $days;
        } else {
            $to = $Period[1];
        }
        $company = DB::select('SELECT * from lkp_company where id=' . $pieces[1])[0];
        if ($company->period_start == "1") {
            $d = explode('-', $to);
            $last_day = cal_days_in_month(CAL_GREGORIAN, $d[1], $d[0]);
            $last_day = $d[0] . '-' . $d[1] . '-' . $last_day;

        } else {

            $last_day = $to;
        }


        //return $last_day;
        //----------------------------------------------------------------------------------------------------------

        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();


        $date = date("Y-m-d H:i:s");
        $id = DB::table('salary_import_paid_master')->insertGetId(
            ['user_id' => Auth::user()->id,
                'fileName' => $request->file('select_file')->getClientOriginalName(),
                'create_at' => $date]

        );

        $values = '';
        $journalId = '';
        $journal_ids = $amp_ids = array();
        for ($row = 2; $row <= $lastRow; $row++) {


            //$driverIds = explode("*", $worksheet->getCell('L' . $row)->getValue());
            $AMP_IDs = explode("*", $worksheet->getCell('I' . $row)->getValue());
            $bank_paid = explode("*", $worksheet->getCell('K' . $row)->getValue());
            for ($i = 0; $i < count($AMP_IDs); $i++) {
                if($AMP_IDs[$i] == '')
                    continue;
                try {
                    $Drivers = DB::select("SELECT id from drivers where job_id='" . $AMP_IDs[$i] . "'")[0];
                    $driver_id = $Drivers->id;
                    $amp_ids[] = $AMP_IDs[$i];
                    $journals = DB::select("SELECT id FROM journal where driverId = '$driver_id' AND `journal_type_id` IN ('6', '7') AND `journal_date` BETWEEN '$from' AND '$to'");
                    foreach($journals as $journal) {
                        $journal_ids[] = $journal->id;
                    }

                    DB::update("Update journal set status = 'Paid', exported_by = '$user_id', updatedby_id = '$user_id', updated_at = NOW() where driverId = '$driver_id' AND `journal_type_id` IN ('6', '7') AND `journal_date` BETWEEN '$from' AND '$to'");
                    $journal = DB::table('journal')
                        ->select('journal.id as id')
                        ->where('driverId', '=', $Drivers->id)
                        ->where('journal_date', '=', $last_day)
                        ->where('journal_type_id', '=', 2)
                        ->first();

                    if (empty($journal->id)) {
                        $journal_id = DB::table('journal')->insertGetId(
                            [
                                'driverId' => $Drivers->id,
                                'journal_date' => $last_day,
                                'debit' => $bank_paid[$i],
                                'journal_type_id' => 2,
                                'createdby_id' => Auth::user()->id,
                                'updatedby_id' => Auth::user()->id,
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s")
                            ]
                        );

                        $values .= "(" . $id . ",
                             " . $journal_id . ",
                             '" . $AMP_IDs[$i] . "',
                             " . $worksheet->getCell('A' . $row)->getValue() . ",
                             '" . $worksheet->getCell('B' . $row)->getValue() . "',
                             " . $worksheet->getCell('C' . $row)->getValue() . ",
                             " . $worksheet->getCell('H' . $row)->getValue() . ",
                             " . $bank_paid[$i] . ",
                              1),";

                        $journalId = $journal_id;
                    } else {
                        $values .= "(" . $id . ",
                             " . $journal->id . ",
                             '" . $AMP_IDs[$i] . "',
                             " . $worksheet->getCell('A' . $row)->getValue() . ",
                             '" . $worksheet->getCell('B' . $row)->getValue() . "',
                             " . $worksheet->getCell('C' . $row)->getValue() . ",
                             " . $worksheet->getCell('H' . $row)->getValue() . ",
                             " . $bank_paid[$i] . ",
                              0),";
                        $journalId = $journal->id;
                    }

                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect('/LoansPaid')->with('error', $e->getPrevious()->getMessage());
                }
            }

        }
        if(count($journal_ids) > 0) {
            $made_by = Auth::user()->name;
            $amp_ids = implode(',', $amp_ids);
            $msg = "<b>$made_by</b> updated the journal with driver amp_ids ('$amp_ids') to Paid";
            HelperFunctionsController::add_log($msg, '', $journal_ids);
        }
        $values = substr($values, 0, strlen($values) - 1);

        //return $values;
        if ($values <> '') {
            try {

                DB::insert("insert  into salary_import_paid_details
                    (paid_master_id, journal_id,
                        AMP_ID, account_owner_iqama, accountNumber, bank_sum, CO,
                        bank_paid,paid)
                  VALUES
                  " . $values);
            } catch (\Illuminate\Database\QueryException $e) {
                return view('Salary.SalaryPaidShe')->with('error', $e->getPrevious()->getMessage());
            }
        }
        return $this->SalaryPaid($request)->with('success', 'Done successfully');
    }
    public function CheckPermisions(Request $request)
    {
        # code...
        // return $request->all();
        $E_Signatures = array();
        $current_user = [];
        $tem = $this->getPermsionsDetails($request->all(),Auth::user()->id);
        $period = $request->filter_Period;

        $Period = explode(' - ', $period);
        $from = $Period[0];
        $to = $Period[1];
        $to = explode("-",$to);
        if($to[2] == 30 || $to[2] == 31) {
            $month = $to[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
            $to = $to[0] . "-" . $to[1] . "-" . $days;
        } else {
            $to = $Period[1];
        }
        $WhosPrivilageToApprove = Page_privilege::where([
            ['company_id',$request->filter_companyId],
            ['privilege_description','Approve']
        ])->get();
        $DidAllEmpApprovedInvoice = "
                                    Select approved_records.*,users.name ,users.department from approved_records
                                    join users on users.id = approved_records.user_id
                                    where approved_records.user_id = '15' AND approved_records.company_id=".$request->filter_companyId." and approved_records.periodFrom LIKE '%".$from."%' and approved_records.periodTo LIKE '%".$to."%'
                                    ";
        // dd(count($DidAllEmpApprovedInvoice));

        // dd($sql);
        $DidAllEmpApprovedInvoice = DB::select($DidAllEmpApprovedInvoice);
        $var = $DidAllEmpApprovedInvoice;

        // if(count($DidAllEmpApprovedInvoice) == count($WhosPrivilageToApprove)){
        if(count($DidAllEmpApprovedInvoice) > 0){
             $tem['Does_all_approve'] = true;
        }else{
            $tem['Does_all_approve'] = false;
        }

        // dd($tem);
        if($tem != NULL){
            $E_Signatures[] = $tem;
        }


        $usersWhoHavePriveliges = Page_privilege::where([
            ['company_id',$request->filter_companyId],
            ['user_id','!=',Auth::user()->id]
        ])->get();

        if(count($usersWhoHavePriveliges)>0){
            foreach($usersWhoHavePriveliges as $usersWhoHavePrivelige){
                $E_Signatures[] = $this->getPermsionsDetails($request->all(),$usersWhoHavePrivelige->user->id);
                // dd($E_Signatures);
            }
        }

        $htmlCode = "";
        $E_Signatures = array_map("unserialize", array_unique(array_map("serialize", $E_Signatures)));
        // dd($E_Signatures);
        foreach($E_Signatures as $k=>$E_Signature){
            // dd($input);
            // dd($E_Signature);
            if($E_Signature['user_id'] == Auth::user()->id){
                // dd($E_Signature);
                $current_user = $E_Signature;
                // return $current_user;
            }

            // dd('E_Signature');
            if($k%2 == 0){
                $color = '#fff';
            }else{
                $color = '#d3a45924';
            }
            // dd($E_Signature['ApprovalDate']);
            if($E_Signature['DidUserApproveThisInvoice'] == true){
                // APPROVEED INVOICES
                // Check who approved it current user
                if($E_Signature['IsHavePermissionToExport'] == true){
                    $htmlCode = $htmlCode. "
                    <tr style='max-height: 45px;'>
                        <td> ".$E_Signature['user_name']." </td>
                        <td > ".$E_Signature['department']." </td>
                        <td> ". $E_Signature['ApprovalDate']."
                        </td>
                    </tr>
                ";

                }else{
                    $htmlCode = $htmlCode. "
                        <tr style='max-height: 45px;'>
                            <td> ".$E_Signature['user_name']." </td>
                             <td > ".$E_Signature['department']." </td>
                            <td> ". $E_Signature['ApprovalDate']."
                            </td>
                        </tr>
                    ";
                }
            }else{

                if($E_Signature['user_id'] == Auth::user()->id){
                    // dd($htmlCode);
                    $htmlCode = $htmlCode."
                        <tr  style='max-height: 45px;text-align: center;'>
                            <td > ".$E_Signature['user_name']." </td>
                            <td > ".$E_Signature['department']." </td>
                            <td> <a href='".url('Approve-invoice/'.$request->filter_companyId.'/'.$from.' - '.$to.'/'.Auth::user()->id.' ')."' class='btn btn-sm btn-info' style='padding: 5px;
                            margin: 8px;'> Approve </a> </td>
                        </tr>
                    ";

                }else{
                    // dd($E_Signature);
                    // dd($E_Signature);
                    $htmlCode = $htmlCode."
                        <tr  style='max-height: 45px;text-align: center;'>
                            <td> ".$E_Signature['user_name']." </td>
                            <td> Pending </td>
                        </tr>
                    ";
                    // dd($htmlCode);
                }
                //  dd($htmlCode);
            }
        }
        // dd(['status'=>true,"payload"=>$htmlCode,"itemsCount"=>count($E_Signatures)]);
        // dd($current_user);
       if($current_user == []){
            return response()->json(['status'=>true,"payload"=>$htmlCode,"itemsCount"=>count($E_Signatures)],200);
       }else{
            return response()->json(['status'=>true,"payload"=>$htmlCode,"data"=>$current_user,"itemsCount"=>count($current_user)],200);
       }

        // dd($E_Signatures);
    }
    public function getPermsionsDetails($args,$user_id){
        $user = array();
        $export = false;
        $approve = false;
        $didApprove = false;
        $approveDate = false;
        $user_name = '';
        $user_dept = '';
        $company_id = $args['filter_companyId'];
        // dd($company_id);
        $period = $args['filter_Period'];

        $current_user_privilaged_permisions = Page_privilege::where([
            ['company_id',$company_id],
            ['user_id',$user_id]
        ])->get();
        // dd($current_user_privilaged_permisions);
        // check if user has permition
        foreach($current_user_privilaged_permisions as $item){
            // dd($item);
            switch ($item->privilege_description) {
                case 'Approve':
                    # code...
                    $approve = true;
                    break;
                case 'Export':
                    # code...
                    $export = true;
                    break;

                default:
                    # code...
                    break;
            }
        }
        // dd('20222222');
        // check if user approve the invoice
       $var = '';

        if(isset($args['filter_Period'])){
            $Period = explode(' - ',$period);
            $from = $Period[0];
            $to = $Period[1];
            $to = explode("-",$to);
            if($to[2] == 30 || $to[2] == 31) {
                $month = $to[1];
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[0]);
                $to = $to[0] . "-" . $to[1] . "-" . $days;
            } else {
                $to = $Period[1];
            }
            $sql = "Select approved_records.*,users.name ,users.department from approved_records join users on users.id = approved_records.user_id where approved_records.user_id=".$user_id."  and approved_records.company_id=".$company_id."  and approved_records.periodFrom LIKE '%".$from."%' and approved_records.periodTo LIKE '%".$to."%' ";
            // dd($sql);
            $checkIfApproved = DB::select($sql);
            $var = $checkIfApproved;
            // dd($checkIfApproved);
            if(count($checkIfApproved)>0){
                $didApprove = true;
                $approveDate = $checkIfApproved[0]->created_at;
            }
        }else{
        }
         if($approve == false && $approve == false){

         }else{
            // dd($didApprove);
            $user = [
                'user_id'=>$user_id,
                'user_name'=>$current_user_privilaged_permisions[0]->user->name,
                'department'=>$current_user_privilaged_permisions[0]->user->department,
                'IsHavePermissionToExport'=>$export,
                'IsHavePermissionToApprove'=>$approve,
                'DidUserApproveThisInvoice'=>$didApprove,
                'ApprovalDate'=>$approveDate,
            ];
         }
        if(count($user)){
            return $user;
        }

        //
    }
//****************************************************************************************************************
//****************************************************************************************************************
}
