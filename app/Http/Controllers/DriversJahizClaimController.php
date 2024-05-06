<?php

namespace App\Http\Controllers;

use App\DriversJahizClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;

class DriversJahizClaimController extends Controller
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
            $lkp_claim_status = DB::select('SELECT lkp_claim_status.id,user_type_id,
             concat(user_type," » ",status_txt) as status_txt from lkp_claim_status
                       left join lkp_claim_status_user on lkp_claim_status_user.id=lkp_claim_status.user_type_id');

        }
//***********************************************************************************************************************
//***********************************************************************************************************************
        elseif (request()->ajax()) {
            DB::statement('SET SESSION group_concat_max_len = 5555555');
            $Select_db = DB::table('drivers_jahiz_claim')
                ->select(DB::raw("drivers_jahiz_claim.id as id, amount,claim_dt, note,warehouseName,
                DATE_FORMAT(drivers.lastSettlementDate, '%Y-%m-%d') AS lastSettlementDate,job_id,fullName,drivers_jahiz_claim.driverId,
                 driver_type,drivers_jahiz_claim.created_at as created_at, drivers_jahiz_claim.updated_at as updated_at,
                 IFNULL(bag_fee,'') as bag_fee,IFNULL(drivers_jahiz_claim.Bander_Commission,'') as Bander_Commission,
                 GROUP_CONCAT(CONCAT(ifnull(reply_txt,''),'__',name,'__',DATE_FORMAT(drivers_jahiz_claim_reply.created_at,'%Y-%m-%d %H:%i'),'__',ifnull(status_txt,'')) ORDER BY drivers_jahiz_claim_reply.created_at DESC SEPARATOR ';;') as drivers_jahiz_claim_reply"))
                ->leftJoin('drivers', 'drivers_jahiz_claim.driverId', '=', 'drivers.id')
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_driver_type', 'drivers.driver_type_id', '=', 'lkp_driver_type.id')
                ->leftJoin('drivers_jahiz_claim_reply', 'drivers_jahiz_claim_reply.drivers_jahiz_claim_id', '=', 'drivers_jahiz_claim.id')
                ->leftJoin('lkp_claim_status', 'drivers_jahiz_claim_reply.claim_status_id', '=', 'lkp_claim_status.id')
                ->leftJoin('users', 'drivers_jahiz_claim_reply.created_by_id', '=', 'users.id');
            $Select_db->selectRaw("NULLIF(IFNULL(Monthly_Salary.p_month,0)+IFNULL(Per_Shipment.p_month,0),0) as per_priod,
                                                NULLIF(IFNULL(Monthly_Salary.c_month,0)+IFNULL(Per_Shipment.c_month,0),0) as cur_priod,
                                                DATEDIFF(NOW(),jahiz_clearing_updated_at) as Last_Clear,
                                                Jahiz_Amount,SANED_amount,DATEDIFF(NOW(),SANED_SettledDate) as SANED_SettledDate,
                                                DATEDIFF(NOW(),drivers.created_at) as created_at2");
            $Select_db->groupBy(DB::raw('id,amount,claim_dt,note,warehouseName,job_id,fullName,drivers_jahiz_claim.driverId,driver_type,drivers_jahiz_claim.created_at,
                                              drivers_jahiz_claim.updated_at,per_priod,cur_priod,Last_Clear,Jahiz_Amount,SANED_amount,SANED_SettledDate,created_at2'));
            $Select_db->leftJoin(DB::raw("(SELECT driverId,
            sum(CASE
                WHEN CONCAT(year,'-',month)= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m') THEN IFNULL(week1,0)+IFNULL(week2,0)+IFNULL(week3,0)+IFNULL(week4,0)+IFNULL(weekAll,0)+IFNULL(amount_by_days,0)
            END) p_month,
            sum(CASE
                WHEN CONCAT(year,'-',month)= DATE_FORMAT(NOW() , '%Y-%m') THEN IFNULL(week1,0)+IFNULL(week2,0)+IFNULL(week3,0)+IFNULL(week4,0)+IFNULL(weekAll,0)+IFNULL(amount_by_days,0)
            END) c_month
            from drivers_jahiz_montly
            LEFT JOIN lkp_jahiz_period on lkp_jahiz_period.id=drivers_jahiz_montly.jahiz_period_id
            LEFT JOIN lkp_month on lkp_month.id=lkp_jahiz_period.month_id
            where CONCAT(year,'-',month) in(DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m'),DATE_FORMAT(NOW() , '%Y-%m'))
            GROUP BY driverId
                )Monthly_Salary"),
                'Monthly_Salary.driverId', '=', 'drivers.id');
            $Select_db->leftJoin(DB::raw("(select driverId,
                sum(CASE
                    WHEN DATE_FORMAT(updated_at , '%Y-%m')= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')  THEN IFNULL(Bander_Commission,0)
                END) p_month,
                sum(CASE
                    WHEN DATE_FORMAT(updated_at , '%Y-%m')= DATE_FORMAT(NOW() , '%Y-%m')  THEN IFNULL(Bander_Commission,0)
                END) c_month
                 from drivers_jahiz_clearing
                where
                 driver_type_id = 3
                AND DATE_FORMAT(updated_at , '%Y-%m') in(DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m'),DATE_FORMAT(NOW() , '%Y-%m'))
                GROUP BY driverId
                )Per_Shipment"),
                'Per_Shipment.driverId', '=', 'drivers.id');
            $Select_db->leftJoin(DB::raw("(SELECT a.driverId,
                    CASE
                        WHEN Jahiz_Amount_Sign = 1 THEN a.Jahiz_Amount
                        WHEN Jahiz_Amount_Sign = 2 THEN a.Jahiz_Amount*-1
                    END
                    as Jahiz_Amount,
                    a.updated_at as jahiz_clearing_updated_at
                    FROM drivers_jahiz_clearing a
                    INNER JOIN (
                        SELECT driverId, MAX(updated_at) updated_at
                        FROM drivers_jahiz_clearing
                        GROUP BY driverId
                    ) b ON a.driverId = b.driverId AND a.updated_at = b.updated_at
                )tb_jahiz_amount"),
                'tb_jahiz_amount.driverId', '=', 'drivers.id');
            $Select_db->leftJoin(DB::raw("(SELECT a.AMP_ID,a.CollectionAmount-a.DeliveryPrice-a.DriverCredit+a.DriverDebit as SANED_amount, a.SettledDate as SANED_SettledDate
                        FROM drivers_saned_settlement a
                        INNER JOIN (
                            SELECT AMP_ID, MAX(SettledDate) SettledDate
                            FROM drivers_saned_settlement
                            GROUP BY AMP_ID
                        ) b ON a.AMP_ID = b.AMP_ID AND a.SettledDate = b.SettledDate
                )drivers_saned_settlement"),
                'drivers_saned_settlement.AMP_ID', '=', 'drivers.job_id');

            $Select_db->leftJoin(DB::raw("(select a.drivers_jahiz_claim_id,a.claim_status_id,a.created_at from
            drivers_jahiz_claim_reply as a
            INNER JOIN (
                            SELECT drivers_jahiz_claim_id, MAX(created_at) created_at
                FROM drivers_jahiz_claim_reply
                where claim_status_id is not null
                GROUP BY drivers_jahiz_claim_id
            )b ON a.drivers_jahiz_claim_id = b.drivers_jahiz_claim_id AND a.created_at = b.created_at
            where a.claim_status_id is not null
            )claim_status"),
                'claim_status.drivers_jahiz_claim_id', '=', 'drivers_jahiz_claim.id');
            if ($request->filter_Image_Identity <> "" || $request->filter_Image_Passport <> "" || $request->filter_Image_DrivingLicence <> "" || $request->filter_Image_VehiclesRegistration <> "" || $request->filter_Image_JobContract <> "" || $request->filter_Image_PromissoryNote <> "")
                $Select_db->leftJoin('drivers_attachments', 'drivers.id', '=', 'drivers_attachments.driverId');


            $Select_sum = DB::table('drivers_jahiz_claim')
                ->select(DB::raw("sum(amount) AS amount"))
                ->leftJoin('drivers', 'drivers_jahiz_claim.driverId', '=', 'drivers.id')
                ->leftJoin('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
                ->leftJoin('lkp_driver_type', 'drivers.driver_type_id', '=', 'lkp_driver_type.id')
                ->leftJoin(DB::raw("(select a.drivers_jahiz_claim_id,a.claim_status_id,a.created_at from
                    drivers_jahiz_claim_reply as a
                    INNER JOIN (
                                    SELECT drivers_jahiz_claim_id, MAX(created_at) created_at
                        FROM drivers_jahiz_claim_reply
                        where claim_status_id is not null
                        GROUP BY drivers_jahiz_claim_id
                    )b ON a.drivers_jahiz_claim_id = b.drivers_jahiz_claim_id AND a.created_at = b.created_at
                    where a.claim_status_id is not null
                    )claim_status"),
                    'claim_status.drivers_jahiz_claim_id', '=', 'drivers_jahiz_claim.id');
            if ($request->filter_Image_Identity <> "" || $request->filter_Image_Passport <> "" || $request->filter_Image_DrivingLicence <> "" || $request->filter_Image_VehiclesRegistration <> "" || $request->filter_Image_JobContract <> "" || $request->filter_Image_PromissoryNote <> "")
                $Select_sum->leftJoin('drivers_attachments', 'drivers.id', '=', 'drivers_attachments.driverId');


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
                $Select_sum->whereRaw('warehouseId in(' . implode(",", $whereIn_array) . ')');
            }
            if (!empty($request->filter_warehouseId)) {
                $Select_db->whereRaw('warehouseId=' . $request->filter_warehouseId);
                $Select_sum->whereRaw('warehouseId=' . $request->filter_warehouseId);
            }
            if (!empty($request->filter_job_id)) {
                $Select_db->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
                $Select_sum->whereRaw("UPPER(job_id) LIKE '%" . strtoupper($request->filter_job_id) . "%'");
            }
            if (!empty($request->filter_driver_type_id)) {
                $Select_db->whereRaw('drivers.driver_type_id=' . $request->filter_driver_type_id);
                $Select_sum->whereRaw('drivers.driver_type_id=' . $request->filter_driver_type_id);
            }
            if (!empty($request->filter_driverId)) {
                $Select_db->whereRaw('drivers_jahiz_claim.driverId=' . $request->filter_driverId);
                $Select_sum->whereRaw('drivers_jahiz_claim.driverId=' . $request->filter_driverId);
            }
            if (!empty($request->filter_claim_dt)) {
                $filter_claim_dt = explode(" - ", $request->filter_claim_dt);
                $Select_db->whereRaw("CAST(drivers_jahiz_claim.claim_dt as date) between STR_TO_DATE('$filter_claim_dt[0]','%d/%m/%Y') and STR_TO_DATE('$filter_claim_dt[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(drivers_jahiz_claim.claim_dt as date) between STR_TO_DATE('$filter_claim_dt[0]','%d/%m/%Y') and STR_TO_DATE('$filter_claim_dt[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_lastSettlementDate)) {
                $filter_lastSettlementDate = explode(" - ", $request->filter_lastSettlementDate);
                $Select_db->whereRaw("CAST(drivers.lastSettlementDate as date) between STR_TO_DATE('$filter_lastSettlementDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_lastSettlementDate[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(drivers.lastSettlementDate as date) between STR_TO_DATE('$filter_lastSettlementDate[0]','%d/%m/%Y') and STR_TO_DATE('$filter_lastSettlementDate[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_claim_status_id)) {
                $Select_db->whereRaw('claim_status.claim_status_id=' . $request->filter_claim_status_id);
                $Select_sum->whereRaw('claim_status.claim_status_id=' . $request->filter_claim_status_id);
            }
            if ($request->filter_Image_PromissoryNote == "1") {
                $Select_db->whereRaw("Image_PromissoryNote is not null");
                $Select_sum->whereRaw("Image_PromissoryNote is not null");
            } elseif ($request->filter_Image_PromissoryNote == "2") {
                $Select_db->whereRaw("Image_PromissoryNote is  null");
                $Select_sum->whereRaw("Image_PromissoryNote is  null");
            }
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(drivers_jahiz_claim.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(drivers_jahiz_claim.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(drivers_jahiz_claim.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
                $Select_sum->whereRaw("CAST(drivers_jahiz_claim.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }
            //return $Select_db->toSql();
            $Select_sum = $Select_sum->first();
            return datatables()->of($Select_db)
                ->with('amount', '<b>' . $Select_sum->amount . '</b>')
                ->filterColumn('drivers_jahiz_claim_reply', function ($query, $keyword) {
                    $keywords = trim($keyword);
                    $query->whereRaw("CONCAT(ifnull(reply_txt,''),'__',ifnull(status_txt,'')) like ?", ["%{$keywords}%"]);
                })
                ->with('SQL', $Select_db->toSql())
                ->make(true);
            //return $Select_db->toSql();
            //return datatables()->of($Select_db)->make(true);
        }
        //$data = $Select_db->get();
        return view('DriversJahizClaim.index')
            ->with(compact('warehouse'))
            ->with(compact('lkp_driver_type'))
            ->with(compact('lkp_claim_status'));
    }
    //******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaim($id)
    {
        $Driver = DB::select('SELECT drivers.id,fullName,warehouseName,driver_type_id,job_id from drivers
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers.id=' . $id)[0];
        $drivers_jahiz_claim = DB::table('drivers_jahiz_claim')->select(DB::raw("id,TRIM(amount)+0 as amount,
        DATE_FORMAT(claim_dt,'%d/%m/%Y') as claim_dt,note"))
            ->where('driverId', $id)
            ->first();
        return view('DriversJahizClaim.DriversClaim')->with(compact('Driver'))
            ->with(compact('drivers_jahiz_claim'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimSave(Request $request)
    {
        $drivers_jahiz_claim = DB::table('drivers_jahiz_claim')->select('id')
            ->where('driverId', $request->input('driverId'))
            ->first();
        try {
            if (isset($drivers_jahiz_claim->id)) {
                DB::table('drivers_jahiz_claim')
                    ->where('id', $drivers_jahiz_claim->id)
                    ->update([
                        'amount' => $request->input('amount'),
                        'claim_dt' => (empty($request->input('claim_dt'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('claim_dt'))->format('Y-m-d'),
                        'note' => $request->input('note'),
                        'updated_by_id' => Auth::user()->id,
                        'updated_at' => date("Y-m-d H:i:s"),
                    ]);
            } else {
                DB::table('drivers_jahiz_claim')->insert(
                    [
                        'driverId' => $request->input('driverId'),
                        'amount' => $request->input('amount'),
                        'claim_dt' => (empty($request->input('claim_dt'))) ? null : \DateTime::createFromFormat('d/m/Y', $request->input('claim_dt'))->format('Y-m-d'),
                        'note' => $request->input('note'),
                        'created_by_id' => Auth::user()->id,
                        'updated_by_id' => Auth::user()->id,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ]
                );
            }
        } catch (Exception $e) {
            return $this->DriversClaim($request->input('driverId'))->with('error', $e->getPrevious()->getMessage());
        }
        //return $request->input('driverId');
        return $this->DriversClaim($request->input('driverId'))->with('success', 'Done successfully');
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimDelete($id, Request $request)
    {


        if (isset($request->success)) {
            return view('DriversJahizClaim.DriversClaimDeleted')
                ->with(compact('id'))
                ->with('success', 'Delete successfully');
        }
        else
            return view('DriversJahizClaim.DriversClaimDeleted')
                ->with(compact('id'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimDeleteAction(Request $request)
    {
        $drivers_jahiz_claim_id = $request->input('drivers_jahiz_claim_id');
        //return $drivers_jahiz_claim_id;
       if (session('Delete_27') == 1) {
            DB::table('drivers_jahiz_claim_reply')->where('drivers_jahiz_claim_id', '=', $drivers_jahiz_claim_id)->delete();
            DB::table('drivers_jahiz_claim')->where('id', '=', $drivers_jahiz_claim_id)->delete();
        }

        //return redirect('/DriversJahizClaim')->with('success', 'Done successfully');
        //return view('DriversJahizClaim.DriversClaimDeleted/')->with('success', 'Delete successfully');

        $request = new Request([
            'success' => 'Delete successfully',
            'drivers_jahiz_claim_id' => $drivers_jahiz_claim_id,
        ]);
        return $this->DriversClaimDelete($drivers_jahiz_claim_id, $request);
    }

    //********************************************************************************************************************************
    public function DriversClaimReply($id, Request $request)
    {
        $Driver = DB::select('SELECT drivers.id,fullName,warehouseName,driver_type_id,job_id,
       drivers_jahiz_claim.id as drivers_jahiz_claim_id
       from drivers
        inner join drivers_jahiz_claim on drivers_jahiz_claim.driverId=drivers.id
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers_jahiz_claim.id=' . $id)[0];
        /*$drivers_jahiz_claim = DB::table('drivers_jahiz_claim')->select(DB::raw("id,TRIM(amount)+0 as amount,
        DATE_FORMAT(claim_dt,'%d/%m/%Y') as claim_dt,note"))
            ->where('driverId', $id)
            ->first();
        */
        if ($request->drivers_jahiz_claim_reply_id <> '') {
            $drivers_jahiz_claim_reply = DB::select('SELECT reply_txt
       from drivers_jahiz_claim_reply
        where id=' . $request->drivers_jahiz_claim_reply_id)[0];
            $reply_txt = $drivers_jahiz_claim_reply->reply_txt;
            //return $reply_txt;
        } else $reply_txt = '-1';
        if ($request->success <> '')
            return view('DriversJahizClaim.DriversClaimReply')
                ->with(compact('reply_txt'))
                ->with(compact('Driver'))
                ->with('success', 'Done successfully');
        else
            return view('DriversJahizClaim.DriversClaimReply')
                ->with(compact('reply_txt'))
                ->with(compact('Driver'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimReplySave(Request $request)
    {
        $drivers_jahiz_claim_id = $request->input('drivers_jahiz_claim_id');
        try {
            $drivers_jahiz_claim_reply_id = DB::table('drivers_jahiz_claim_reply')->insertGetId(
                [
                    'drivers_jahiz_claim_id' => $request->input('drivers_jahiz_claim_id'),
                    'reply_txt' => $request->input('reply_txt'),
                    'created_by_id' => Auth::user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ]
            );
            DB::update("update drivers_jahiz_claim set updated_at='" . date("Y-m-d H:i:s") . "' where id=" . $request->input('drivers_jahiz_claim_id'));
        } catch (Exception $e) {
            return redirect('/DriversJahizClaim')->with('error', $e->getPrevious()->getMessage());
        }
        //return redirect('/DriversJahizClaim')->with('success', 'Done successfully');
        //return $drivers_jahiz_claim_reply_id;
        // $request = new \Illuminate\Http\Request();
        //$request->replace(['success' => 'Done successfully']);
        //$request->replace(['drivers_jahiz_claim_reply_id' => $drivers_jahiz_claim_reply_id]);
        $request = new Request([
            'success' => 'Done successfully',
            'drivers_jahiz_claim_reply_id' => $drivers_jahiz_claim_reply_id,
        ]);
        return $this->DriversClaimReply($drivers_jahiz_claim_id, $request);
    }

    //********************************************************************************************************************************
    public function DriversClaimBag($id)
    {
        $Driver = DB::select('SELECT drivers.id,fullName,warehouseName,driver_type_id,job_id,
       drivers_jahiz_claim.id as drivers_jahiz_claim_id
       from drivers
        inner join drivers_jahiz_claim on drivers_jahiz_claim.driverId=drivers.id
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers_jahiz_claim.id=' . $id)[0];
        $drivers_jahiz_claim = DB::select('SELECT bag_fee
            from drivers_jahiz_claim
            where id=' . $id)[0];
        if (isset($success))
            return view('DriversJahizClaim.DriversClaimBag')
                ->with(compact('drivers_jahiz_claim'))
                ->with(compact('Driver'))
                ->with('success', 'Done successfully');
        else
            return view('DriversJahizClaim.DriversClaimBag')
                ->with(compact('drivers_jahiz_claim'))
                ->with(compact('Driver'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimBagSave(Request $request)
    {
        $drivers_jahiz_claim_id = $request->input('drivers_jahiz_claim_id');
        try {
            DB::update("update drivers_jahiz_claim set bag_fee='" . $request->input('bag_fee') . "' where id=" . $request->input('drivers_jahiz_claim_id'));
        } catch (Exception $e) {
            return redirect('/DriversJahizClaim')->with('error', $e->getPrevious()->getMessage());
        }
        return $this->DriversClaimBag($drivers_jahiz_claim_id)->with('success', 'Done successfully');;
    }

//********************************************************************************************************************************
    public function DriversClaimCommission($id)
    {
        $Driver = DB::select('SELECT drivers.id,fullName,warehouseName,driver_type_id,job_id,
       drivers_jahiz_claim.id as drivers_jahiz_claim_id
       from drivers
        inner join drivers_jahiz_claim on drivers_jahiz_claim.driverId=drivers.id
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers_jahiz_claim.id=' . $id)[0];
        $drivers_jahiz_claim = DB::select('SELECT Bander_Commission
            from drivers_jahiz_claim
            where id=' . $id)[0];
        if (isset($success))
            return view('DriversJahizClaim.DriversClaimCommission')
                ->with(compact('drivers_jahiz_claim'))
                ->with(compact('Driver'))
                ->with('success', 'Done successfully');
        else
            return view('DriversJahizClaim.DriversClaimCommission')
                ->with(compact('drivers_jahiz_claim'))
                ->with(compact('Driver'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimCommissionSave(Request $request)
    {
        $drivers_jahiz_claim_id = $request->input('drivers_jahiz_claim_id');
//return  $drivers_jahiz_claim_id;
        try {
            DB::update("update drivers_jahiz_claim set Bander_Commission='" . $request->input('Bander_Commission') . "' where id=" . $request->input('drivers_jahiz_claim_id'));
        } catch (Exception $e) {
            return redirect('/DriversJahizClaim')->with('error', $e->getPrevious()->getMessage());
        }
        return $this->DriversClaimCommission($drivers_jahiz_claim_id)->with('success', 'Done successfully');;
    }

//********************************************************************************************************************************
    public function DriversClaimDate($id)
    {
        $Driver = DB::select('SELECT drivers.id,fullName,warehouseName,driver_type_id,job_id,
       drivers_jahiz_claim.id as drivers_jahiz_claim_id
       from drivers
        inner join drivers_jahiz_claim on drivers_jahiz_claim.driverId=drivers.id
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers_jahiz_claim.id=' . $id)[0];
        $drivers_jahiz_claim = DB::select('SELECT claim_dt
            from drivers_jahiz_claim
            where id=' . $id)[0];
        if (isset($success))
            return view('DriversJahizClaim.DriversClaimDate')
                ->with(compact('drivers_jahiz_claim'))
                ->with(compact('Driver'))
                ->with('success', 'Done successfully');
        else
            return view('DriversJahizClaim.DriversClaimDate')
                ->with(compact('drivers_jahiz_claim'))
                ->with(compact('Driver'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimDateSave(Request $request)
    {
        $drivers_jahiz_claim_id = $request->input('drivers_jahiz_claim_id');
//return  $drivers_jahiz_claim_id;
        try {
            DB::update("update drivers_jahiz_claim set claim_dt='" . $request->input('claim_dt') . "' where id=" . $request->input('drivers_jahiz_claim_id'));
        } catch (Exception $e) {
            return redirect('/DriversJahizClaim')->with('error', $e->getPrevious()->getMessage());
        }
        return $this->DriversClaimDate($drivers_jahiz_claim_id)->with('success', 'Done successfully');;
    }
//********************************************************************************************************************************
//********************************************************************************************************************************
    public function DriversClaimStatus($id, Request $request)
    {

        if (Auth::user()->id == 14)
            $user_type_idd = 2;
        elseif (Auth::user()->id == 18)
            $user_type_idd = 3;
        else
            $user_type_idd = 1;
        $lkp_claim_status = DB::select('SELECT id,user_type_id,status_txt from lkp_claim_status where user_type_id=' . $user_type_idd);

        $Driver = DB::select('SELECT drivers.id,fullName,warehouseName,driver_type_id,job_id,
       drivers_jahiz_claim.id as drivers_jahiz_claim_id
       from drivers
        inner join drivers_jahiz_claim on drivers_jahiz_claim.driverId=drivers.id
         left join warehouse on warehouse.id=drivers.warehouseId
         where drivers_jahiz_claim.id=' . $id)[0];
        /*$drivers_jahiz_claim = DB::table('drivers_jahiz_claim')->select(DB::raw("id,TRIM(amount)+0 as amount,
        DATE_FORMAT(claim_dt,'%d/%m/%Y') as claim_dt,note"))
            ->where('driverId', $id)
            ->first();
        */

        if ($request->drivers_jahiz_claim_reply_id <> '') {

            $drivers_jahiz_claim_reply = DB::select('SELECT reply_txt,status_txt
               from drivers_jahiz_claim_reply
               left join lkp_claim_status on lkp_claim_status.id=drivers_jahiz_claim_reply.claim_status_id
                where drivers_jahiz_claim_reply.id=' . $request->drivers_jahiz_claim_reply_id)[0];
            $reply_txt = $drivers_jahiz_claim_reply->reply_txt;
            $status_txt = $drivers_jahiz_claim_reply->status_txt;
            //return $status_txt;
        } else {
            $reply_txt = '-1';
            $status_txt = '-1';
        }
        if ($request->success <> '')
            return view('DriversJahizClaim.DriversClaimStatus')
                ->with(compact('reply_txt'))
                ->with(compact('status_txt'))
                ->with(compact('Driver'))
                ->with(compact('lkp_claim_status'))
                ->with('success', 'Done successfully');
        else
            return view('DriversJahizClaim.DriversClaimStatus')
                ->with(compact('reply_txt'))
                ->with(compact('status_txt'))
                ->with(compact('Driver'))
                ->with(compact('lkp_claim_status'));
    }
//******************************************************************************************************************************
//******************************************************************************************************************************
    public function DriversClaimStatusSave(Request $request)
    {
        $drivers_jahiz_claim_id = $request->input('drivers_jahiz_claim_id');
        try {
            $drivers_jahiz_claim_reply_id = DB::table('drivers_jahiz_claim_reply')->insertGetId(
                [
                    'drivers_jahiz_claim_id' => $request->input('drivers_jahiz_claim_id'),
                    'claim_status_id' => $request->input('claim_status_id'),
                    'reply_txt' => $request->input('reply_txt'),
                    'created_by_id' => Auth::user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ]
            );
            DB::update("update drivers_jahiz_claim set updated_at='" . date("Y-m-d H:i:s") . "' where id=" . $request->input('drivers_jahiz_claim_id'));
        } catch (Exception $e) {
            return redirect('/DriversJahizClaim')->with('error', $e->getPrevious()->getMessage());
        }
        $request = new Request([
            'success' => 'Done successfully',
            'drivers_jahiz_claim_reply_id' => $drivers_jahiz_claim_reply_id,
        ]);
        return $this->DriversClaimStatus($drivers_jahiz_claim_id, $request);
    }
    //*************************************************************************************************************************
//*************************************************************************************************************************
    public function ExportClaim(Request $request)
    {
//return $request->SQL;
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'المدينة')
            ->setCellValueExplicit('B1', 'الاسم')
            ->setCellValueExplicit('C1', 'الجنسية')
            ->setCellValue('D1', 'الايدي')
            ->setCellValue('E1', 'المبلغ')
            ->setCellValue('F1', 'العمولة')
            ->setCellValue('G1', 'رسوم الشنطة')
            ->setCellValue('H1', 'اتعاب المحامي ورسوم النشر')
            ->setCellValue('I1', 'المجموع');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);


        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);



        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle("E1:I1")
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '33FF99')
                ),
                'font' => array(
                    'color' => array('rgb' => '000000'),
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )

            )
        );



//return $request->SQL;
        $Select_db = DB::select($request->SQL);
        $rowCount = 2;
        foreach ($Select_db as $Select_dbdb) {
            $total=floatval($Select_dbdb->amount)+floatval($Select_dbdb->Bander_Commission)+ floatval($Select_dbdb->bag_fee)+900;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $rowCount, $Select_dbdb->warehouseName, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $rowCount, $Select_dbdb->fullName, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('C' . $rowCount, '', PHPExcel_Cell_DataType::TYPE_STRING)
                ->SetCellValue('D' . $rowCount, $Select_dbdb->job_id)
                ->SetCellValue('E' . $rowCount, $Select_dbdb->amount)
                ->SetCellValue('F' . $rowCount, $Select_dbdb->Bander_Commission)
                ->SetCellValue('G' . $rowCount, $Select_dbdb->bag_fee)
                ->SetCellValue('H' . $rowCount, '900')
                ->SetCellValue('I' . $rowCount, $total);

            //$objPHPExcel->getActiveSheet()->getStyle("A$rowCount:H$rowCount")->getFont()->setSize(14);


            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:D$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle("E$rowCount:I$rowCount")
                ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:I$rowCount")->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    ),
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    )
                )
            );
            //$objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(24);
            $rowCount++;

        }


        $objPHPExcel->setActiveSheetIndex(0);
        $date = date("Y-m-d H-i-s");
        $fileName = 'ClaimExcel_' . $date . '-' . Auth::user()->id . '.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


        //return(public_path() . '/SANEDSettledExcel/' . $fileName);
        $objWriter->save('php://output');
        exit;
    }
}
