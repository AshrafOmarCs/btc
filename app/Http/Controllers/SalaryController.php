<?php

namespace App\Http\Controllers;
use App\Salary_import_paid_detail;
use App\Salary;
use App\Page_privilege;
use App\Approved_record;

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

class SalaryController extends Controller
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
    public function index(Request $request)
    {
        // dd($returedValue['user_id']);
        // $does_have_per
        // dd(count($current_user_privilaged_permisions));

        // get the authrized users to approve and export 
        // check if Current user has permission 
        // check other approve status 

        
         
        $lkp_company = DB::select('SELECT * from lkp_company');
        
        // dd($request->filter_companyId);
        $from = 0;
        $to = 0;
        if (!empty($request->filter_companyId)) {
           
            $Period = explode(' - ',$request->filter_Period);
            $from = $Period[0];
            $to = $Period[1];
        }
        $where = array();
        if (!empty($request->filter_companyId)) {
            $where[] = 'lkp_company.id=' . $request->filter_companyId;
            $filter_companyId = $request->filter_companyId;
        } else {
            $where[] = 'lkp_company.id=0';
            $filter_companyId = 0;
        }
        if (!empty($request->filter_cityId)) {
            $where[] = 'lkp_city.id=' . $request->filter_cityId;
        }
        if (!empty($request->filter_warehouseId)) {
            $where[] = 'warehouse.id=' . $request->filter_warehouseId;
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
            drivers.id as driverId ,drivers.mobileNumber as mobileNumber ,companyName,name_en as city_name,warehouseName,fullName,drivers.job_id,IF(account_owner_iqama<>'',account_owner_iqama,iqama) as iqama,TRIM(account_owner_iqama) as account_owner_iqama,under_sopnsorship_id,bank_id,bank_name_en,TRIM(accountNumber) AS accountNumber,
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

                    // return($query);
                    if (!empty($request->filter_companyId)) {
                        //echo nl2br($query);
                        //exit;
                    }

                    //$Select_db = DB::select($query);

                    $Select_db = DB::table(DB::raw("(" . $query . ") as sub"));
        
                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect('/Salary')->with('error', $from . $to . $e->getPrevious()->getMessage());
                }

        //SUM********************************************************************************************************************
        //***********************************************************************************************************************
        $sum = DB::table(DB::raw("(" . $query . ") as sub"))
            ->select(DB::raw("
             count(*) AS CO,
             TRIM(sum(IFNULL(total_No_of_TP,0)))+0 as total_No_of_TP,
             TRIM(sum(IFNULL(No_of_TouchPoint,0)))+0 as No_of_TouchPoint,
             sum(IF(matching ='Yes',1,0)) as matching,
             TRIM(sum(IFNULL(GAP,0)))+0 as GAP,
             TRIM(sum(IFNULL(carried_down,0)))+0 as carried_down,
             TRIM(sum(IFNULL(credit_now,0)))+0 as credit_now,
             TRIM(sum(IFNULL(debit_now,0)))+0 as debit_now,
             TRIM(sum(IFNULL(Loan,0)))+0 as Loan,
             TRIM(sum(IFNULL(CreditNote,0)))+0 as CreditNote,
             TRIM(sum(IFNULL(IND,0)))+0 as IND,
             TRIM(sum(IFNULL(expected_salary,0)))+0 as expected_salary,
             TRIM(sum(IFNULL(paid_salary,0)))+0 as paid_salary,
             TRIM(sum(IFNULL(brought_down,0)))+0 as brought_down,
             sum(IF(matching_transaction ='Yes',1,0)) as matching_transaction
             "));

        //return $Select_db->toSql();

        if (request()->ajax()) {

            // $data = $Select_db;
            if ($from == 0) {
                return datatables()->of($Select_db)->with('salary_range', ' ')->make(true);
            } else {

                if (!empty($request->filter_PaidType)) {
                    if ($request->filter_PaidType == 'Paid') {
                        $Select_db->whereRaw("paid_salary>0 or brought_down<=0");
                        $sum->whereRaw("paid_salary>0 or brought_down<=0");
                    } else if ($request->filter_PaidType == 'Unpaid') {
                        $Select_db->whereRaw("paid_salary=0 and brought_down>0");
                        $sum->whereRaw("paid_salary=0 and brought_down>0");
                    } else if ($request->filter_PaidType == 'carried_down_plus') {
                        $Select_db->whereRaw("carried_down>0");
                        $sum->whereRaw("carried_down>0");
                    } else if ($request->filter_PaidType == 'carried_down_minus') {
                        $Select_db->whereRaw("carried_down<0");
                        $sum->whereRaw("carried_down<0");
                    } else if ($request->filter_PaidType == 'cumulative_total_plus') {
                        $Select_db->whereRaw("brought_down>0");
                        $sum->whereRaw("brought_down>0");
                    } else if ($request->filter_PaidType == 'cumulative_total_minus') {
                        $Select_db->whereRaw("brought_down<0");
                        $sum->whereRaw("brought_down<0");
                    }
                }

                $sum = $sum->first();
                return datatables()->of($Select_db)->with('salary_range',
                    '<b><font color="red">' . $from . '    ' . $to . '</font></b>')
                    ->with('Period', str_replace(' - ', '*', $request->filter_Period))
                    ->with('companyId', $request->filter_companyId)
                    ->with('total_No_of_TP', '<b>' . $sum->total_No_of_TP . '</b>')
                    //->with('total_No_of_TP', $Select_db->sum('total_No_of_TP'))
                    ->with('No_of_TouchPoint', '<b>' . $sum->No_of_TouchPoint . '</b>')
                    ->with('carried_down', '<b>' . $sum->carried_down . '</b>')
                    ->with('credit_now', '<b>' . $sum->credit_now . '</b>')
                    ->with('debit_now', '<b>' . $sum->debit_now . '</b>')
                    ->with('GAP', '<b>' . $sum->GAP . '</b>')
                    ->with('Loan', '<b>' . $sum->Loan . '</b>')
                    ->with('CreditNote', '<b>' . $sum->CreditNote . '</b>')
                    ->with('IND', '<b>' . $sum->IND . '</b>')
                    ->with('expected_salary', '<b>' . $sum->expected_salary . '</b>')
                    ->with('paid_salary', '<b>' . $sum->paid_salary . '</b>')
                    ->with('brought_down', '<b>' . $sum->brought_down . '</b>')
                    ->with('matching', '<b>' . $sum->matching . '</b>')
                    ->with('matching_transaction', '<b>' . $sum->matching_transaction . '</b>')
                    ->with('SQL', $query)
                    ->setTotalRecords($sum->CO)
                    ->make(true);
            }
        }
        //$data = $Select_db;
        // dd($request->all());
        return view('Salary.index')->with(compact('lkp_company'));
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

            $company = DB::select('SELECT * from lkp_company where id=' . $request->input('companyId'))[0];
            if ($company->period_start == "1") {
                //$from = date('Y-m', strtotime(date('Y-m') . ' -1 MONTH')) . "-01";
                //$to = date('Y-m', strtotime(date('Y-m') . ' -1 MONTH')) . "-31";
                // $last_day = date('Y-m', strtotime(date('Y-m') . ' -1 MONTH')) . "-28";
                $d = explode('-', $to);
                $last_day = cal_days_in_month(CAL_GREGORIAN, $d[1], $d[0]);
                $last_day = $d[0] . '-' . $d[1] . '-' . $last_day;
                //echo $last_day;
                //exit;
                //$last_day = $d[0] . '-' . $d[1] . '-' . '28';
            } else {
                //if (date('d') < $company->period_start) {
                //     $from = date('Y-m-d', strtotime(date('Y-m-' . $company->period_start) . ' -2 MONTH'));
                //    $to = date('Y-m-d', strtotime(date('Y-m-' . ($company->period_start - 1)) . ' -1 MONTH'));
                // } elseif (date('d') >= $company->period_start) {
                //     $from = date('Y-m-d', strtotime(date('Y-m-' . $company->period_start) . ' -1 MONTH'));
                //     $to = date('Y-m-d', strtotime(date('Y-m-' . ($company->period_start - 1))));
                // }
                // $last_day = $to;
                $last_day = $to;
            }

        }

        //$from='2020-03-21';
        // $to='2020-04-20';
        // $last_day = $to;

        $values = '';
        $k = 0;
        for ($i = 0; $i < 500; $i++) {
            //if ($request->has('ID_' . $i) && $request->input('paid_salary_' . $i) <> '') {
            if (!empty($request->input('ID_' . $i)) && !empty($request->input('paid_salary_' . $i))) {
                $k++;
                $values .= "(" . $request->input('ID_' . $i) . ",'" . $last_day . "'," . $request->input('paid_salary_' . $i) . ",
        null,null,2,null," . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'),";

                if (!empty($request->input('IND_' . $i)) && $request->input('IND_' . $i) > 0) {
                    $values .= "(" . $request->input('ID_' . $i) . ",'" . $last_day . "'," . $request->input('IND_' . $i) . ",
        null,null,5,null," . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'),";
                }


            }
        }
        $values = substr($values, 0, strlen($values) - 1);
        // dd("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
        // createdby_id,updatedby_id,created_at,updated_at)
        //       VALUES
        //        ".$values);
        //echo $values;
        //exit;
        if ($values <> '') {
            try {

                DB::insert("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
            createdby_id,updatedby_id,created_at,updated_at)
                  VALUES
                  " . $values);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/Salary')->with('error', $e->getPrevious()->getMessage());
            }
        }
        return redirect('/Salary')->with('success', 'Done successfully');
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

        $qq = DB::select("select date,DAYNAME(date) as dayname,journal_type,No_of_D as no_of_deliverd,No_of_TP as no_of_touch_point,unit_cost,credit,debit,IFNULL(credit,0)-IFNULL(debit,0) as Carried_Down
        from(
        select date_add('" . $from . "', interval row day) as date from
         (
            SELECT @row := @row + 1 as row FROM
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t,
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t2,
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t3,
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t4,
            (SELECT @row:=-1) r
         ) sequence
         where date_add('" . $from . "', interval row day) <= '" . $to . "')a
        left join journal on journal.journal_date =a.date and journal.driverId=" . $id . "
        left join lkp_journal_type on lkp_journal_type.id=journal.journal_type_id
        left join packages_report on packages_report.id=journal.post_id and journal_type_id=6
        order by date,journal_type");


        return view('Salary.show')->with(compact('from'))->with(compact('to'))
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
            return view('Salary.SalaryPaid')->with(compact('Paid_DB'))->with('success', $success);
        elseif (isset($error))
            return view('Salary.SalaryPaid')->with(compact('Paid_DB'))->with('error', $error);
        else
            return view('Salary.SalaryPaid')->with(compact('Paid_DB'));

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

       
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');
        
        $pieces = explode("_", $request->file('select_file')->getClientOriginalName());
        
        if (!is_numeric($pieces[1])) {
            $Paid_DB = array();
            return view('Salary.SalaryPaid')->with(compact('Paid_DB'))->with('error', 'Not Salary File');
        }
        //----------------------------------------------------------------------------------------------------------
       

        $Period = explode(' - ', $pieces[2]);
        $from = $Period[0];
        $to = $Period[1];
       
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

        for ($row = 2; $row <= $lastRow; $row++) {


            //$salary_IDs = explode("*", $worksheet->getCell('L' . $row)->getValue());
            $AMP_IDs = explode("*", $worksheet->getCell('I' . $row)->getValue());
            $bank_paid = explode("*", $worksheet->getCell('K' . $row)->getValue());


            for ($i = 0; $i < count($AMP_IDs); $i++) {


                try {

                    $Drivers = DB::select("SELECT id from drivers where job_id='" . $AMP_IDs[$i] . "'")[0];
                    
                    $journal = DB::table('journal')
                        ->select('journal.id as id')
                        ->where('driverId', '=', $Drivers->id)
                        ->where('journal_date', '=', $last_day)
                        ->where('journal_type_id', '=', 2)
                        ->first();
                        
                    // dd($journal);

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
                        $checkIfPaidDetailsIsExsist = Salary_import_paid_detail::where([
                            ['journal_id',$journal->id],
                            ['AMP_ID',$AMP_IDs[$i]],
                            ['account_owner_iqama',$worksheet->getCell('A' . $row)->getValue()],
                            ['accountNumber',$worksheet->getCell('B' . $row)->getValue()],
                            ['bank_sum',$worksheet->getCell('C' . $row)->getValue()]
                        ])->get();
                       
                        $values .= "(" . $id . ",
                             " . $journal_id . ",
                             '" . $AMP_IDs[$i] . "',
                             " . $worksheet->getCell('A' . $row)->getValue() . ",
                             '" . $worksheet->getCell('B' . $row)->getValue() . "',
                             " . $worksheet->getCell('C' . $row)->getValue() . ",
                             " . $worksheet->getCell('H' . $row)->getValue() . ",
                             " . $bank_paid[$i] . ",
                               1),";
                    } else {
                        $checkIfPaidDetailsIsExsist = Salary_import_paid_detail::where([
                            ['journal_id',$journal->id],
                            ['AMP_ID',$AMP_IDs[$i]],
                            ['account_owner_iqama',$worksheet->getCell('A' . $row)->getValue()],
                            ['accountNumber',$worksheet->getCell('B' . $row)->getValue()],
                            ['bank_sum',$worksheet->getCell('C' . $row)->getValue()]
                        ])->get();

                        if(count($checkIfPaidDetailsIsExsist)>0){
                        }else{
                            $values .= "(" . $id . ",
                            " . $journal->id . ",
                            '" . $AMP_IDs[$i] . "',
                            " . $worksheet->getCell('A' . $row)->getValue() . ",
                            '" . $worksheet->getCell('B' . $row)->getValue() . "',
                            " . $worksheet->getCell('C' . $row)->getValue() . ",
                            " . $worksheet->getCell('H' . $row)->getValue() . ",
                            " . $bank_paid[$i] . ",
                              0),";
                        }
                    }

                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect('/LoansPaid')->with('error', $e->getPrevious()->getMessage());
                }
            }


        }

        $values = substr($values, 0, strlen($values) - 1);

        // return $values;
        if ($values <> '') {
            try {
                DB::insert("insert  into salary_import_paid_details
                    (paid_master_id, journal_id,
                        AMP_ID, account_owner_iqama, accountNumber, bank_sum, CO,
                        bank_paid,paid)
                  VALUES
                  " . $values);
            } catch (\Illuminate\Database\QueryException $e) {
                return view('Salary.SalaryPaid')->with('error', $e->getPrevious()->getMessage());
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
            if($E_Signature['user_id'] == Auth::user()->id){
                dd($E_Signature);
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
                    <tr style='background-color: ".$color.";'>
                        <td> ".$E_Signature['user_name']." </td>
                        <td> ".$E_Signature['IsHavePermissionToExport']." </td>
                        <td> ". $E_Signature['ApprovalDate']."  
                        </td>
                    </tr>
                "; 
                
                }else{
                    $htmlCode = $htmlCode. "
                        <tr style='background-color: ".$color.";'>
                            <td> ".$E_Signature['user_name']." </td>
                            <td> ".$E_Signature['IsHavePermissionToExport']." </td>
                            <td> ". $E_Signature['ApprovalDate']."  
                            </td>
                        </tr>
                    "; 
                }
            }else{ 
                
                if($E_Signature['user_id'] == Auth::user()->id){
                    // dd($htmlCode);
                    $htmlCode = $htmlCode."
                        <tr  style='background-color: ".$color.";'>
                            <td > ".$E_Signature['user_name']." </td>
                            <td> ".$E_Signature['department']." </td>
                            <td> <a href='".url('Approve-invoice/'.$request->filter_companyId.'/'.$request->filter_Period.'/'.Auth::user()->id.' ')."' class='btn btn-sm btn-info' style='padding: 5px;
                            margin: 8px;'> Approve </a> </td>
                        </tr>
                    "; 
                   
                }else{
                    // dd($E_Signature);
                    // dd($E_Signature);
                    $htmlCode = $htmlCode."
                        <tr  style='background-color: ".$color.";'>
                            <td> ".$E_Signature['user_name']." </td>
                            <td> ".$E_Signature['department']." </td>
                            <td> Pending </td>
                        </tr>
                    ";
                    // dd($htmlCode);
                } 
                //  dd($htmlCode);
            }
        } 
        // dd($current_user);
       if($current_user == []){
            return response()->json(['status'=>true,"payload"=>$htmlCode,"itemsCount"=>count($E_Signatures)],200);
       }else{
            return response()->json(['status'=>true,"payload"=>$htmlCode,"data"=>$current_user,"itemsCount"=>count($current_user)],200);
       }
        
        // dd($E_Signatures);
    }

//****************************************************************************************************************
//****************************************************************************************************************
}
