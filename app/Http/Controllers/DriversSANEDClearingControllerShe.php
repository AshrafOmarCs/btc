<?php

namespace App\Http\Controllers;

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
    $body = '';
    $i = $saned_total = $bander_total = $dispatch_total = $bander_com_total = $bank_total1 = $cash_total1 = $bank_total2 = $cash_total2 = $atm_total = 0 ;
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
        $body .= '<td>'.$row->SettledDate.'</td>';
        $body .= '<td>'.$row->warehouseName.'</td>';
        $body .= '<td>'.$row->AMP_ID.'</td>';
        $body .= '<td><a href="javascript:driver(' . $row->driverId . ')">' . $row->DriverName . '</a></td>';
        if (!$row->drivers_jahiz_clearing_paid_id)
        {
            if(Auth::user()->user_type_id==1 && session('Post_29')==1)
            {
                $body .= '<td><center><input type="hidden" name="drivers_jahiz_clearing_id_' . $i . '" value="' . $row->drivers_jahiz_clearing_id . '">' .
                        '<input class="flat-red" name="ID_' . $i . '" type="checkbox" value="' . $i . '"></center></td>';
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
        $body .= '<td class="table-cell-load">'.$row->bank_plus.'</td>';
        $bank_total1 += $row->bank_plus;
        $body .= '<td class="table-cell-load">'.$row->cash_plus.'</td>';
        $cash_total1 += $row->cash_plus;
        if (Auth::user()->user_type_id == 1)
        {
            $body .= '<td class="table-cell-load">'.$row->ATM_plus.'</td>';
            $atm_total += $row->ATM_plus;
        }
        $body .= '<td class="table-cell-touchpoint">'.$row->bank_minus.'</td>';
        $bank_total2 += $row->bank_minus;
        $body .= '<td class="table-cell-touchpoint">'.$row->cash_minus.'</td>';
        $cash_total2 += $row->cash_minus;
        $body .= '</tr>';
    }
    $response['body'] = $body;
    $response['saned_total'] = $saned_total;
    $response['bander_total'] = $bander_total;
    $response['dispatch_total'] = $dispatch_total;
    $response['bander_com_total'] = $bander_com_total;
    $response['bank_total1'] = $bank_total1;
    $response['cash_total1'] = $cash_total1;
    $response['atm_total'] = $atm_total;
    $response['bank_total2'] = $bank_total2;
    $response['cash_total2'] = $cash_total2;
    $response['check'] = $check;
    $response['btn'] = $btn;

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
                ->select(DB::raw("drivers_saned_settlement.exported_by, drivers_saned_settlement.status, drivers_saned_settlement.id,AMP_ID,DriverName,SettledDate,
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
                $Select_db->whereRaw('warehouseId=' . $request->filter_warehouseId);
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
            echo $Select_db->toSql();;
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
        if (password_verify($request->input('password'), $user->password)) {
            foreach($settlement_ids as $settlement_id) {
                DB::update("Update drivers_saned_settlement set status = 'Ready', exported_by = '0', updated_by = '$user_id', updated_at = NOW() where id = '$settlement_id'");
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
        for ($i = 0; $i < 1000; $i++) {
            if (!empty($request->input('ID_' . $i))) {
                //$IDs .= $request->input('ID_' . $i) . ",";

                try {
                    DB::update(" UPDATE drivers_saned_settlement
                    SET drivers_jahiz_clearing_paid_id = " . $request->input('drivers_jahiz_clearing_id_' . $i) . ",
                        paid_dt='" . $date . "',
                        paid_by_id=" . Auth::user()->id . "
                    where id =" . $request->input('ID_' . $i));


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


        return redirect('/DriversSANEDClearingShe')->with('success', 'Done successfully');

    }
}
