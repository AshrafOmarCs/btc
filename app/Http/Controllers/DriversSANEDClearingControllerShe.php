<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;

use App\DriversSANEDClearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function get_user_name($user_id)
{
    $row = DB::select("SELECT name from users WHERE id = '$user_id'");
    return $row[0]->name;
}
function get_table_body($data) {
    // dd($data);
    $body = '';
    $jahiz_ids = $ids = array();
    $i = $saned_total = $bander_total = $dispatch_total = $bander_com_total = $administrative_fee = $bank_total1 = $cash_total1 = $bank_total2 = $cash_total2 = $atm_total = 0 ;
    $check = $btn = 0;
    foreach($data as $row) {
        $ids[] = $row->id;
        $jahiz_ids[] = $row->drivers_jahiz_clearing_id;
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
        if(isset($row->export_attempt) AND $row->export_attempt > 0)
            $row->export_attempt = $row->export_attempt;
        else
            $row->export_attempt = 0;
        $body .= '<tr>';
        $body .= '<td>'.$row->SettledDate.'</td>';
        $body .= '<td>'.$row->warehouseName.'</td>';
        $body .= '<td>'.$row->AMP_ID.'</td>';
        $body .= '<td><a href="javascript:driver(' . $row->driverId . ')">' . $row->DriverName . '</a></td>';
        if (!$row->drivers_jahiz_clearing_paid_id)
        {
            if(Auth::user()->user_type_id==1 && session('Post_29')==1)
            {
                $body .= '<td><center><input type="hidden" name="drivers_jahiz_clearing_id_' . $i . '" value="' . $row->drivers_jahiz_clearing_id . '">' .
                        '<input class="flat-red" name="ID_' . $i . '" type="checkbox" value="' . $row->id . '"></center></td>';
            } else
            {
                $body .= '<td><span class="label label-warning">No</span></td>';
            }
        } else {
            $body .= '<td><span class="label label-success">Yes</span></td>';
        }
        
        if ($row->SANED_amount == null) {
            $body .= '<td></td>';
        } else if ($row->SANED_amount !== $row->Jahiz_Amount) {
            $saned_total += $row->SANED_amount;
            $body .= '<td class="red_color">' . $row->SANED_amount . '</td>';   
        } else {
            $body .= '<td>'.$row->SANED_amount.'</td>';
            $saned_total += $row->SANED_amount;
        }
        
        if ($row->Jahiz_Amount == null) {
            $body .= '<td></td>';
        } else if ($row->SANED_amount != $row->Jahiz_Amount) {
            $bander_total += $row->Jahiz_Amount;
            $body .= '<td class="red_color">' . $row->Jahiz_Amount . '</td>';
        } else {
            $bander_total += $row->Jahiz_Amount;
            $body .= '<td>'.$row->Jahiz_Amount.'</td>';
        }
        if(Auth::user()->user_type_id==1 && session('Post_29')==1) {
            if ($disabled == 'disabled')
                $body .= '<td style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="">&nbsp;'.$status .'<span style="color: black !important">'.$exported_name.'</span></td>';
            else
                $body .= '<td style="color:'.$color.';"><input '.$disabled.' class="'.$class.'" name="ID_' . $i . '" type="checkbox" value="' . $row->id . '">&nbsp;'.$status .'<span style="color: black !important">'.$exported_name.'</span></td>';
        } else
            $body .= '<td>'.$status.'</td>';
        $body .= '<td><center><div class="circle">'.$row->export_attempt.'</div></center></td>';
        $body .= '<td>'.$row->updated_at.'</td>';
        $body .= '<td>'.$row->driver_type.'</td>';
        $body .= '<td>'.$row->account_owner_iqama.'</td>';
        $body .= '<td>'.$row->accountNumber.'</td>';
        if ($row->driver_type_id == null) {
            $dispatch_total += $row->NoOfDispatch;
            $body .= '<td>'.$row->NoOfDispatch.'</td>';
        } else if ($row->driver_type_id != 3) {
            $body .= '<td></td>';
        } else if ($row->NoOfDispatch * 2 != $row->Bander_Commission) {
            $dispatch_total += $row->NoOfDispatch;
            $body .= '<td><span class="red_color">' . $row->NoOfDispatch . '</span></td>';
        } else {
            $dispatch_total += $row->NoOfDispatch;
            $body .= '<td>'.$row->NoOfDispatch.'</td>';
        }
        if ($row->driver_type_id == 3) {
            if ($row->NoOfDispatch * 2 != $row->Bander_Commission) {
                $bander_com_total += $row->Bander_Commission;
                $body .= '<td><span class="red_color">' . $row->Bander_Commission . '</span></td>';
            } else {
                $bander_com_total += $row->Bander_Commission;
                $body .= '<td>'.$row->Bander_Commission.'</td>';
            }
        } else {
            $bander_com_total += $row->Bander_Commission;
            $body .= '<td>'.$row->Bander_Commission.'</td>';
        }
        $administrative_fee += $row->administrative_fee;
        $body .= '<td>'.$row->administrative_fee.'</td>';
        if($row->clearance_type != '')
            $body .= '<td>'.$row->clearance_type.'</td>';
        else
            $body .= '<td>Clearance</td>';
        $atm_eye = $bank_eye = '';
        if($row->bank_plus > 0 AND $row->proof_file != '') {
            $bank_eye = '<a style="margin-left: 8px;font-size:14px;" href="/storage/images/'.$row->proof_file.'" target="_blank"><i class="fa fa-eye"></i></a>';
        }
        if($row->ATM_plus > 0 AND $row->proof_file != '') {
            $atm_eye = '<a style="margin-left: 8px;font-size:14px;" href="/storage/images/'.$row->proof_file.'" target="_blank"><i class="fa fa-eye"></i></a>';
        }
        $body .= '<td class="table-cell-load">'.$row->bank_plus . $bank_eye .'</td>';
        $bank_total1 += $row->bank_plus;
        $body .= '<td class="table-cell-load">'.$row->cash_plus.'</td>';
        $cash_total1 += $row->cash_plus;
        if (Auth::user()->user_type_id == 1)
        {
            $body .= '<td class="table-cell-load">'.$row->ATM_plus. $atm_eye .'</td>';
            $atm_total += $row->ATM_plus;
        }
        $body .= '<td class="table-cell-touchpoint">'.$row->bank_minus.'</td>';
        $bank_total2 += $row->bank_minus;
        $body .= '<td class="table-cell-touchpoint">'.$row->cash_minus.'</td>';
        if (!$row->drivers_jahiz_clearing_paid_id) {
            $body .= '<td></td>';
        } else {
            // $body .= '<td></td>';
            $body .= '<td><a onclick="revert_status(\'' . $row->drivers_jahiz_clearing_paid_id . '\', \'' . $row->DriverName . '\', \'' . $row->AMP_ID . '\', \'' . $row->SANED_amount . '\')" data-original-title="revert" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow revert"> <i class="fa fa-undo"></i> </a></td>';
        }
        $cash_total2 += $row->cash_minus;
        $body .= '</tr>';
        $i++;
    }
    $response['body'] = $body;
    $response['saned_total'] = $saned_total;
    $response['bander_total'] = $bander_total;
    $response['dispatch_total'] = $dispatch_total;
    $response['bander_com_total'] = $bander_com_total;
    $response['administrative_fee'] = $administrative_fee;
    $response['bank_total1'] = $bank_total1;
    $response['cash_total1'] = $cash_total1;
    $response['atm_total'] = $atm_total;
    $response['bank_total2'] = $bank_total2;
    $response['cash_total2'] = $cash_total2;
    $response['check'] = $check;
    $response['btn'] = $btn;
    $response['ids'] = implode(",", $ids);
    $response['jahiz_ids'] = implode(",", $jahiz_ids);
    return $response;
}

class DriversSANEDClearingControllerShe extends Controller
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
    public function applySettlement(Request $request) {
        $reason = $request->reason;
        $total = $request->total;
        $ids = $request->ids;
        $jahiz_ids = $request->jahiz_ids;
        $table = $request->table;
        $module = $request->module;
        $period = $request->period;
        $made_by = Auth::user()->name;
        $user_by = Auth::user()->id;
        $check = DB::select("SELECT * FROM tbl_actions WHERE table_name = '$table' AND ids = '$ids' AND module = '$module'");
        if(count($check) > 0) {
            return redirect()->back()->with('error', 'Request for Settlement already sent to Finance Manager');
        } else {
            $imageName = time().'.'.$request->prof_file->extension();
            $request->prof_file->move(storage_path('app/public/paid/saned'), $imageName);
            DB::insert("INSERT INTO tbl_actions (table_name, module, period, ids, jahiz_ids, created_at, created_by, prof_file) VALUES ('$table', '$module', '$period', '$ids', '$jahiz_ids', NOW(), '$user_by', '$imageName')");
            $msg = "<b>$made_by</b> Requested for Saned settlement";
            $ids = explode(',', $ids);
            HelperFunctionsController::add_log($msg, $jahiz_ids, $ids);
            return redirect()->back()->with('success', 'Request for Settlement sent to Finance Manager successfully');
        }
    }
    public function sanedRevert(Request $request) {
        $saned_id = array();
        $id = $saned_id[] = $request->saned_id;
        $reason = $request->reason;
        $made_by = Auth::user()->name;
        $user_by = Auth::user()->id;
        if ($user_by == 15) {
            DB::update("UPDATE drivers_jahiz_clearing set paid_by_id = null, paid_id = null, paid_dt = null WHERE id = '$id'");
            $drivers_saned_settlement_id = DB::select("SELECT paid_id from drivers_jahiz_clearing WHERE id = '$id'");
            $drivers_saned_settlement_id = $drivers_saned_settlement_id[0]->paid_id;
            DB::update("UPDATE drivers_saned_settlement set drivers_jahiz_clearing_paid_id = null, paid_by_id = null, status = 'Ready', paid_dt = null, exported_by = null, reverse_by = '$user_by' WHERE id = '$drivers_saned_settlement_id'");
            $msg = "<b>$made_by</b> Reverted the saned from Paid to Ready with this Reason: " . $reason;
            HelperFunctionsController::add_log($msg, '', $saned_id);
            return redirect()->back()->with('success', 'Saned reverted successfully');    
        } else {
            $msg = "<b>$made_by</b> Requested to revert the saned from Paid to Ready with this Reason: " . $reason;
            HelperFunctionsController::add_log($msg, '', $saned_id);
            
            $subject = "Saned Reverse Request";
            $result = DB::select("SELECT drivers.fullName,drivers.job_id,drivers_jahiz_clearing.paid_dt,warehouse.warehouseName,lkp_company.companyName,drivers_jahiz_clearing.Jahiz_Amount FROM drivers_jahiz_clearing INNER JOIN drivers ON drivers_jahiz_clearing.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE drivers_jahiz_clearing.id='$id'");
            $yes = url("/approval/saned/" . $reason . "/" . $id . "/1");
            $no = url("/approval/saned/" . $reason . "/" . $id . "/0");
            $row = '<br><br>
            <table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid black; padding: 8px;">Driver</th>
                        <th style="border: 1px solid black; padding: 8px;">Job Id</th>
                        <th style="border: 1px solid black; padding: 8px;">Paid Date</th>
                        <th style="border: 1px solid black; padding: 8px;">Company</th>
                        <th style="border: 1px solid black; padding: 8px;">Warehouse</th>
                        <th style="border: 1px solid black; padding: 8px;">Jahiz Amount</th>
                        <th style="border: 1px solid black; padding: 8px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color: #ffffff;">
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->fullName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->job_id.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->paid_dt.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->companyName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->warehouseName.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$result[0]->Jahiz_Amount.'</td>
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
    public function index(Request $request)
    {   
        
        if (!request()->ajax()) {
            
            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
                INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
                where companyId=6 AND user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $wher = ' where warehouse.id in(' . implode(",", $whereIn_array) . ') ';
            } else
                $wher = ' where companyId=6 ';
            $warehouse = DB::select('SELECT * from warehouse ' . $wher . ' order by warehouseName ');
            $lkp_driver_type = DB::select('SELECT * from lkp_driver_type where id in(2,3) order by id');
            $lkp_jahiz_period = DB::select("SELECT lkp_jahiz_period.id,year,month_id,month,CONCAT(year,'-',month) as ym
         from lkp_jahiz_period
         left join lkp_month on lkp_month.id=lkp_jahiz_period.month_id order by year desc,month_id desc");

            $lkp_clearing_type = DB::select('SELECT id,clearing_type from lkp_clearing_type  order by id ');
            return view('DriversSANEDClearing.index_she')
                ->with(compact('warehouse'))
                ->with(compact('lkp_driver_type'))
                ->with(compact('lkp_jahiz_period'))
                ->with(compact('lkp_clearing_type'));
        }
//***********************************************************************************************************************
//***********************************************************************************************************************

        elseif (request()->ajax()) {
            
            $Select_db = DB::table('drivers_saned_settlement')
                ->select(DB::raw("drivers_saned_settlement.export_attempt, drivers_saned_settlement.exported_by, drivers_saned_settlement.status, drivers_saned_settlement.id,AMP_ID,DriverName,SettledDate,
                CASE
                    WHEN COALESCE (a.driver_type_id, b.driver_type_id, c.driver_type_id) =3 OR
                    COALESCE (a.driver_type_id, b.driver_type_id, c.driver_type_id) is NULL
                      THEN NoOfDispatch
                END AS NoOfDispatch
                ,
                drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit AS SANED_amount,
                drivers_saned_settlement.drivers_jahiz_clearing_paid_id ,drivers.id as driverId,
                COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id ) AS driver_type_id,
                driver_type,
                COALESCE ( a.id,b.id,c.id ) AS drivers_jahiz_clearing_id,
                warehouseName,job_id, drivers.fullName as fullName,

             COALESCE (a.Bander_Commission,b.Bander_Commission,c.Bander_Commission) Bander_Commission,
             COALESCE (a.paid_id,b.paid_id,c.paid_id) AS paid_id,
             drivers.account_owner_iqama,
             drivers.accountNumber,
             CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END AS Jahiz_Amount,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN COALESCE(a.bank,b.bank,c.bank) END) AS bank_plus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN COALESCE(a.cash,b.cash,c.cash) END) AS cash_plus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 1 THEN COALESCE(a.ATM,b.ATM,c.ATM) END) AS ATM_plus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 2 THEN COALESCE(a.bank,b.bank,c.bank) END) AS bank_minus,
             FLOOR(CASE WHEN COALESCE(a.clearing_type_id,b.clearing_type_id,c.clearing_type_id) = 2 THEN COALESCE(a.cash,b.cash,c.cash) END) AS cash_minus,
             COALESCE (a.proof_file,b.proof_file,c.proof_file) AS proof_file,
             COALESCE (a.clearance_type,b.clearance_type,c.clearance_type) AS clearance_type,
             COALESCE (a.administrative_fee,b.administrative_fee,c.administrative_fee) AS administrative_fee,
             COALESCE (a.created_at,b.created_at,c.created_at) AS created_at,
             COALESCE (a.updated_at,b.updated_at,c.updated_at) AS updated_at "))
                ->leftJoin('drivers', 'drivers_saned_settlement.AMP_ID', '=', 'drivers.job_id')
                ->leftJoin('drivers_jahiz_clearing AS a', function ($join) {
                    $join->on('a.id', '=', 'drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->whereNotNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id');
                })
                ->leftJoin('drivers_jahiz_clearing AS b', function ($join) {
                    $join->on('b.driverId', '=', 'drivers.id')
                        ->whereNull('a.id')
                        ->whereNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->on('b.id', '=', DB::raw('
                        (
                            select min(id)
                            from drivers_jahiz_clearing
                            where drivers_jahiz_clearing.driverId=drivers.id
                            AND drivers_jahiz_clearing.updated_at >=drivers_saned_settlement.SettledDate
                            AND drivers_jahiz_clearing.paid_id IS NULL
                            AND  drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit=
	                        CASE
                                WHEN Jahiz_Amount_Sign = 1 THEN
                                Jahiz_Amount
                                WHEN Jahiz_Amount_Sign = 2 THEN
                                Jahiz_Amount *- 1
                            END
                        )'));
                })
                ->leftJoin('drivers_jahiz_clearing AS c', function ($join) {
                    $join->on('c.driverId', '=', 'drivers.id')
                        ->whereNull('a.id')
                        ->whereNull('b.id')
                        ->whereNull('drivers_saned_settlement.drivers_jahiz_clearing_paid_id')
                        ->whereRaw('CASE
                           WHEN c.Jahiz_Amount_Sign = 1 THEN
                              c.Jahiz_Amount
                           WHEN c.Jahiz_Amount_Sign = 2 THEN
                              c.Jahiz_Amount *- 1
                           END
                        not in(select drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit from drivers_saned_settlement
                        where drivers_saned_settlement.AMP_ID=drivers.job_id
                        AND c.updated_at >= drivers_saned_settlement.SettledDate
                        AND drivers_jahiz_clearing_paid_id is null)')
                        ->on('c.id', '=', DB::raw('
                        (
                            select min(id)
                            from drivers_jahiz_clearing
                            where drivers_jahiz_clearing.driverId=drivers.id
                            AND drivers_jahiz_clearing.updated_at >=drivers_saned_settlement.SettledDate
                            AND drivers_jahiz_clearing.paid_id IS NULL
                            AND  drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit<>
	                        CASE
                                WHEN Jahiz_Amount_Sign = 1 THEN
                                Jahiz_Amount
                                WHEN Jahiz_Amount_Sign = 2 THEN
                                Jahiz_Amount *- 1
                            END
                        )'));
                })
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_driver_type', DB::raw("COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id )"), '=', 'lkp_driver_type.id');
            // echo ($Select_db->tosql());
            // exit;
            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege  inner join warehouse on warehouse.id=users_privilege.warehouseId
                               where companyId=6 AND user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $Select_db->whereRaw('warehouseId in(' . implode(",", $whereIn_array) . ')');
            }

            if (!empty($request->filter_warehouseId)) {
                $Select_db->whereRaw('warehouseId in(' . implode(",", $request->filter_warehouseId) . ')');
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(AMP_ID) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->whereRaw('drivers.id=' . $request->filter_driverId);
            }

            if (!empty($request->filter_clearing_type_id)) {
                $Select_db->whereRaw('(COALESCE (a.clearing_type_id,b.clearing_type_id,c.clearing_type_id)=' . $request->filter_clearing_type_id . ' or COALESCE ( a.id,b.id,c.id ) is null) ');

            }
            if (!empty($request->filter_bank)) {
                $Select_db->whereRaw("(COALESCE (a.bank,b.bank,c.bank) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
            }
            if (!empty($request->filter_cash)) {
                $Select_db->whereRaw("(COALESCE (a.cash,b.cash) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
            }
            if (!empty($request->filter_driver_type_id)) {
                $Select_db->whereRaw("COALESCE ( a.driver_type_id,b.driver_type_id,c.driver_type_id )=".$request->filter_driver_type_id);
            }
            if (!empty($request->filter_ATM)) {
                $Select_db->whereRaw("(COALESCE (a.ATM,b.ATM,c.ATM) is not null or COALESCE ( a.id,b.id,c.id ) is null) ");
            }
            if ($request->filter_paid_id <> "") {
                if ($request->filter_paid_id == "1") {
                    $Select_db->whereRaw("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is not null ");
                }
                if ($request->filter_paid_id == "2") {
                    $Select_db->whereRaw("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is  null ");
                }
            }
            if ($request->filter_Equal <> "") {
                if ($request->filter_Equal == "1") {
                    $Select_db->whereRaw("drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit=CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END ");
                }
                if ($request->filter_Equal == "2") {
                    $Select_db->whereRaw("drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit<>ifnull(CASE
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 1 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount)
             WHEN COALESCE (a.Jahiz_Amount_Sign,b.Jahiz_Amount_Sign,c.Jahiz_Amount_Sign) = 2 THEN
             COALESCE (a.Jahiz_Amount,b.Jahiz_Amount,c.Jahiz_Amount) *- 1
             END,0) ");
                }
            }
            if (!empty($request->filter_SettledDate)) {
                $filter_SettledDate = explode(" - ", $request->filter_SettledDate);
                $Select_db->whereRaw("CAST(drivers_saned_settlement.SettledDate as date) between STR_TO_DATE('$filter_SettledDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_SettledDate[1]','%d/%m/%Y')");
            }

            $Select_db->whereRaw("CAST(drivers_saned_settlement.SettledDate as date) >= STR_TO_DATE('01/10/2021','%d/%m/%Y')");
            $Select_dbb = clone $Select_db;
            $Select_db->orderBy('drivers_saned_settlement.SettledDate', 'desc');
            $data = $Select_db->get();
            
            $response = get_table_body($data);
            echo $response['body'];
            echo ':::';
            echo round($response['saned_total'], 2);
            echo ':::';
            echo round($response['bander_total'], 2);
            echo ':::';
            echo $response['dispatch_total'];
            echo ':::';
            echo $response['bander_com_total'];
            echo ':::';
            echo $response['bank_total1'];
            echo ':::';
            echo $response['cash_total1'];
            echo ':::';
            echo $response['atm_total'];
            echo ':::';
            echo $response['bank_total2'];
            echo ':::';
            echo $response['cash_total2'];
            echo ':::';
            echo $response['check'];
            echo ':::';
            echo $response['btn'];
            echo ':::';
            echo $Select_dbb->toSql();
            echo ':::';
            echo $response['administrative_fee'];
            echo ':::';
            echo $response['ids'];
            echo ':::';
            echo $response['jahiz_ids'];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        $DriversSANEDClearing = DB::table('drivers_jahiz_clearing')
            ->select('DriversSANEDClearing.id as id', 'driverId', 'fullName', 'fullName_ar', 'DriversSANEDClearing_date',
                'amount', 'note', 'DriversSANEDClearing.status_id as status_id', 'DriversSANEDClearing_status',
                'updatedby_id', 'name', 'updated_usertypeid', 'user_type',
                'DriversSANEDClearing.created_at as created_at', 'DriversSANEDClearing.updated_at as updated_at')
            ->leftJoin('drivers', 'DriversSANEDClearing.driverId', '=', 'drivers.id')
            ->leftJoin('lkp_DriversSANEDClearing_status', 'DriversSANEDClearing.status_id', '=', 'lkp_DriversSANEDClearing_status.id')
            ->leftJoin('users', 'DriversSANEDClearing.updatedby_id', '=', 'users.id')
            ->leftJoin('lkp_updated_usertype', 'DriversSANEDClearing.updated_usertypeid', '=', 'lkp_updated_usertype.id')
            ->where('DriversSANEDClearing.id', $id)
            ->first();

        return view('DriversSANEDClearing.show')->with('drivers_jahiz_clearing', $DriversSANEDClearing);
    }

    public function goToReady(Request $request) {
        $ready_statuss = $request->ready_statuss;
        $settlement_ids = explode(",",$ready_statuss);
        $user = Auth::user(); // Assuming you're using Laravel's built-in authentication
        $user_id = $user->id;
        $made_by = Auth::user()->name;
        $amp_ids = array();
        if (password_verify($request->input('password'), $user->password)) {
            foreach($settlement_ids as $settlement_id) {
                DB::update("Update drivers_saned_settlement set status = 'Ready', exported_by = '0', reverse_by = '$user_id', updated_by = '$user_id', updated_at = NOW() where id = '$settlement_id'");
                $driver = DB::select("SELECT AMP_ID from drivers_saned_settlement WHERE id = '$settlement_id'");
                $amp_ids[] = $driver[0]->AMP_ID;
            }
            if(count($amp_ids) > 0) {
                $amp_ids = implode(',', $amp_ids);
                $msg = "<b>$made_by</b> updated the saned settlement with driver amp_ids ('$amp_ids') to paid";
                HelperFunctionsController::add_log($msg, '', $settlement_ids);
            }
            return redirect('/DriversSANEDClearingShe')->with('success', "Status updated successfully");
        } else {
            // Password is incorrect
            return redirect('/DriversSANEDClearingShe')->with('error', "Password is incorrect");
        }
    }
    public function DriversSANEDClearingPost(Request $request)
    {
        
        $date = date("Y-m-d H:i:s");
        $amp_ids = $sanedids = array();
        for ($i = 0; $i < 1000; $i++) {
            if (!empty($request->input('ID_' . $i))) {
                //$IDs .= $request->input('ID_' . $i) . ",";

                try {
                    DB::update(" UPDATE drivers_saned_settlement
                    SET drivers_jahiz_clearing_paid_id = " . $request->input('drivers_jahiz_clearing_id_' . $i) . ",
                        paid_dt='" . $date . "',
                        paid_by_id=" . Auth::user()->id . ",
                        status = 'Paid',
                        exported_by = " . Auth::user()->id . "
                    where id =" . $request->input('ID_' . $i));
                    $sanedid = $request->input('ID_' . $i);
                    $sanedids[] = $sanedid;
                    $driver = DB::select("SELECT AMP_ID from drivers_saned_settlement WHERE id = '$sanedid'");
                    $amp_ids[] = $driver[0]->AMP_ID;

                    DB::update(" UPDATE drivers_jahiz_clearing
                    SET paid_id = " . $request->input('ID_' . $i) . ",
                        paid_dt='" . $date . "',
                        paid_by_id=" . Auth::user()->id . "
                    where id =" . $request->input('drivers_jahiz_clearing_id_' . $i));

                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect('/DriversSANEDClearingShe')->with('error', $e->getPrevious()->getMessage());
                }

            }
        }

        //return  $UPDATE;
        if(count($amp_ids) > 0) {
            $made_by = Auth::user()->name;
            $amp_ids = implode(',', $amp_ids);
            $msg = "<b>$made_by</b> updated the saned settlement with driver amp_ids ('$amp_ids') to paid";
            HelperFunctionsController::add_log($msg, '', $sanedids);
        }

        return redirect('/DriversSANEDClearingShe')->with('success', 'Done successfully');

    }
}
