<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Loan(Request $request)
    {
        $master = DB::select("select companyName,companyId,
                               sum(if(loan.status_id=1,1,0)) as Pending,
                               sum(if(loan.status_id=2,1,0)) as Rejected,
                               sum(if(loan.status_id=3,1,0)) as Approved,
                               sum(if(loan.status_id=4,1,0)) as Paid,
                               sum(if(loan.status_id=4,amount,0)) as Paid_amount,
                               sum(if(loan.status_id=5,1,0)) as Approved_by_Supervisor,
                               count(*) as CO
                               from
                               loan
                               INNER JOIN drivers on drivers.id=loan.driverId
                               INNER JOIN warehouse on warehouse.id=drivers.warehouseId
                               INNER JOIN lkp_company on lkp_company.id=warehouse.companyId
                               GROUP BY companyName,companyId
                               ORDER BY CO desc");
        $details = DB::select("select companyName,companyId,journal_period,
                                    sum(if(status_id=1,1,0)) as Pending,
                                    sum(if(status_id=2,1,0)) as Rejected,
                                    sum(if(status_id=3,1,0)) as Approved,
                                    sum(if(status_id=4,1,0)) as Paid,
                                    sum(if(status_id=4,amount,0)) as Paid_amount,
                                    sum(if(status_id=5,1,0)) as Approved_by_Supervisor,
                                    count(*) as CO
                                     from
                                    (
                                    select `loan`.`id` as `id`, `companyName`,companyId,   `journal_date`, `amount`,  `loan`.`status_id` as `status_id`,
                                                   if (period_start<>1,
                                                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                                    ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                                                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                                    ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                                                     as journal_period
                                    from `loan`
                                    left join `drivers` on `loan`.`driverId` = `drivers`.`id`
                                    left join `warehouse` on `drivers`.`warehouseId` = `warehouse`.`id`
                                    left join `lkp_company` on `warehouse`.`companyId` = `lkp_company`.`id`
                                    )a
                                    GROUP BY companyName,companyId,journal_period
                                    order by companyName,journal_period desc
                                    ");
        return view('Reports.Loan')->with(compact('master'))
            ->with(compact('details'));
    }

    public function Salary(Request $request)
    {
        $master = DB::select("
 select  companyName,companyId,
                                    TRIM(sum( CO))+0 as CO,
                                    TRIM(sum(Paid))+0 as Paid,
                                    TRIM(sum(credit))+0 as credit,
                                    TRIM(sum(debit))+0 as debit,
                                    TRIM(sum(Loan))+0 as Loan,
                                    TRIM(sum(Salary))+0 as Salary,
                                    TRIM(sum(CreditNote))+0 as CreditNote,
                                    TRIM(sum(Gaps_credit))+0 as Gaps_credit,
                                    TRIM(sum(Gaps_debit))+0 as Gaps_debit,
                                    TRIM(sum(Deduction))+0 as Deduction,
                                    TRIM(sum(Daily_Load))+0 as Daily_Load,
                                    TRIM(sum(Settlements_credit))+0 as Settlements_credit,
                                    TRIM(sum(Settlements_debit))+0 as Settlements_debit,
                                    TRIM(sum(Bank_Transfer))+0 as Bank_Transfer,
                                    TRIM(ROUND(sum(brought_down),2))+0 as brought_down,
                                    TRIM(ROUND(sum(IF(credit - debit > 0, credit - debit, 0)), 2)) + 0 AS brought_down_plus,
                                    TRIM(ROUND(sum(IF(credit - debit < 0, credit - debit, 0)), 2)) + 0 AS brought_down_minus,
                                    TRIM(ROUND(sum(carried_down),2))+0 as carried_down,
                                    TRIM(ROUND( sum(if(carried_down>0,carried_down,0)),2))+0 as carried_down_plus,
                                    TRIM(ROUND( sum(if(carried_down<0,carried_down,0)),2))+0 as carried_down_minus,
                                    TRIM(ROUND(sum(cumulative_total),2))+0 as cumulative_total,
                                    TRIM(ROUND( sum(if(cumulative_total>0,cumulative_total,0)),2))+0 as cumulative_total_plus,
                                    TRIM(ROUND( sum(if(cumulative_total<0,cumulative_total,0)),2))+0 as cumulative_total_minus
                                     from (
select  companyName,companyId,driverId,
                                    count(*) as CO,
                                    TRIM(sum(if (cumulative_total<=0,1,Paid)))+0 as Paid,
                                    TRIM(sum(credit))+0 as credit,
                                    TRIM(sum(debit))+0 as debit,
                                    TRIM(sum(Loan))+0 as Loan,
                                    TRIM(sum(Salary))+0 as Salary,
                                    TRIM(sum(CreditNote))+0 as CreditNote,
                                    TRIM(sum(Gaps_credit))+0 as Gaps_credit,
                                    TRIM(sum(Gaps_debit))+0 as Gaps_debit,
                                    TRIM(sum(Deduction))+0 as Deduction,
                                    TRIM(sum(Daily_Load))+0 as Daily_Load,
                                    TRIM(sum(Settlements_credit))+0 as Settlements_credit,
                                    TRIM(sum(Settlements_debit))+0 as Settlements_debit,
                                    TRIM(sum(Bank_Transfer))+0 as Bank_Transfer,
                                    TRIM(ROUND(sum(brought_down),2))+0 as brought_down,
                                    TRIM(ROUND(sum(carried_down),2))+0 as carried_down,
                                    TRIM(ROUND( sum(if(carried_down>0,carried_down,0)),2))+0 as carried_down_plus,
                                    TRIM(ROUND( sum(if(carried_down<0,carried_down,0)),2))+0 as carried_down_minus,
                                    TRIM(ROUND(sum(cumulative_total),2))+0 as cumulative_total,
                                    TRIM(ROUND( sum(if(cumulative_total>0,cumulative_total,0)),2))+0 as cumulative_total_plus,
                                    TRIM(ROUND( sum(if(cumulative_total<0,cumulative_total,0)),2))+0 as cumulative_total_minus
                                     from (
                                    select companyName,companyId,driverId,journal_period,brought_down,
                                    credit,debit,Loan,Salary,CreditNote,Gaps_credit,Gaps_debit,Deduction,Daily_Load,
                                    Settlements_credit,Settlements_debit,Bank_Transfer,Paid,
                                    IF(@prev_driverId = driverId ,@total ,0) AS carried_down,
                                    IF(@prev_driverId = driverId
                                             ,@total := @total + TRIM(brought_down)+0
                                             ,@total := TRIM(brought_down)+0) AS cumulative_total,
                                     @prev_driverId  := driverId  AS `id`
                                    from
                                    (
                                    select companyName,companyId,driverId,
                                    journal_period,
                                    sum(credit) as credit,
                                    sum(debit) as debit ,
                                    sum(credit-debit) AS brought_down,
                                    sum(if(journal_type_id=1,debit,0)) as Loan,
                                    sum(if(journal_type_id=2,debit,0)) as Salary,
                                    sum(if(journal_type_id=2,1,0)) as Paid,
                                    sum(if(journal_type_id=3,debit,0)) as CreditNote,
                                    sum(if(journal_type_id=4 AND credit>0,credit,0)) as Gaps_credit,
                                    sum(if(journal_type_id=4 AND credit<0,credit,0)*-1) as Gaps_debit,
                                    sum(if(journal_type_id=5,debit,0)) as Deduction,
                                    sum(if(journal_type_id=6,credit,0)) as Daily_Load,
                                    sum(if(journal_type_id=7,credit,0)) as Settlements_credit,
                                    sum(if(journal_type_id=7,debit,0)) as Settlements_debit,
                                    sum(if(journal_type_id=8,debit,0)) as Bank_Transfer
                                    FROM
                                    (
                                    select if (period_start<>1,
                                                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                                    ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                                                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                                    ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                                                     as journal_period,IFNULL(credit,0) as credit,IFNULL(debit,0) as debit,companyName,companyId,journal_type_id,driverId
                                        from journal
                                        inner join drivers on drivers.id=journal.driverId
                                        inner join warehouse on warehouse.id=drivers.warehouseId
                                        inner join lkp_company on lkp_company.id=warehouse.companyId
                                        where credit>0 or debit>0
                                        )a
                                    GROUP BY companyName,companyId,driverId,journal_period
                                     )x
                                    JOIN (select @total:=0,@prev_driverId:=NULL) AS t

                                    )y
                                     GROUP BY companyName,companyId,driverId

)z
                                     GROUP BY companyName,companyId
                                                                        order by companyName
      ");

        $details = DB::select("select  companyName,companyId,journal_period,
                                    count(*) as CO,
                                    TRIM(sum(if (cumulative_total<=0,1,Paid)))+0 as Paid,
                                    TRIM(sum(credit))+0 as credit,
                                    TRIM(sum(debit))+0 as debit,
                                    TRIM(sum(Loan))+0 as Loan,
                                    TRIM(sum(Salary))+0 as Salary,
                                    TRIM(sum(CreditNote))+0 as CreditNote,
                                    TRIM(sum(Gaps_credit))+0 as Gaps_credit,
                                    TRIM(sum(Gaps_debit))+0 as Gaps_debit,
                                    TRIM(sum(Deduction))+0 as Deduction,
                                    TRIM(sum(Daily_Load))+0 as Daily_Load,
                                    TRIM(sum(Settlements_credit))+0 as Settlements_credit,
                                    TRIM(sum(Settlements_debit))+0 as Settlements_debit,
                                    TRIM(sum(Bank_Transfer))+0 as Bank_Transfer,
                                    TRIM(ROUND(sum(brought_down),2))+0 as brought_down,
                                    TRIM(ROUND( sum(if(brought_down>0,brought_down,0)),2))+0 as brought_down_plus,
                                    TRIM(ROUND( sum(if(brought_down<0,brought_down,0)),2))+0 as brought_down_minus,
                                    TRIM(ROUND(sum(carried_down),2))+0 as carried_down,
                                    TRIM(ROUND( sum(if(carried_down>0,carried_down,0)),2))+0 as carried_down_plus,
                                    TRIM(ROUND( sum(if(carried_down<0,carried_down,0)),2))+0 as carried_down_minus,
                                    TRIM(ROUND(sum(cumulative_total),2))+0 as cumulative_total,
                                    TRIM(ROUND( sum(if(cumulative_total>0,cumulative_total,0)),2))+0 as cumulative_total_plus,
                                    TRIM(ROUND( sum(if(cumulative_total<0,cumulative_total,0)),2))+0 as cumulative_total_minus
                                     from (
                                    select companyName,companyId,driverId,journal_period,brought_down,
                                    credit,debit,Loan,Salary,CreditNote,Gaps_credit,Gaps_debit,Deduction,Daily_Load,
                                    Settlements_credit,Settlements_debit,Bank_Transfer,Paid,
                                    IF(@prev_driverId = driverId ,@total ,0) AS carried_down,
                                    IF(@prev_driverId = driverId
                                             ,@total := @total + TRIM(brought_down)+0
                                             ,@total := TRIM(brought_down)+0) AS cumulative_total,
                                     @prev_driverId  := driverId  AS `id`
                                    from
                                    (
                                    select companyName,companyId,driverId,
                                    journal_period,
                                    sum(credit) as credit,
                                    sum(debit) as debit ,
                                    sum(credit-debit) AS brought_down,
                                    sum(if(journal_type_id=1,debit,0)) as Loan,
                                    sum(if(journal_type_id=2,debit,0)) as Salary,
                                    sum(if(journal_type_id=2,1,0)) as Paid,
                                    sum(if(journal_type_id=3,debit,0)) as CreditNote,
                                    sum(if(journal_type_id=4 AND credit>0,credit,0)) as Gaps_credit,
                                    sum(if(journal_type_id=4 AND credit<0,credit,0)*-1) as Gaps_debit,
                                    sum(if(journal_type_id=5,debit,0)) as Deduction,
                                    sum(if(journal_type_id=6,credit,0)) as Daily_Load,
                                    sum(if(journal_type_id=7,credit,0)) as Settlements_credit,
                                    sum(if(journal_type_id=7,debit,0)) as Settlements_debit,
                                    sum(if(journal_type_id=8,debit,0)) as Bank_Transfer
                                    FROM
                                    (
                                    select if (period_start<>1,
                                                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                                    ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                                                    CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                                                    ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                                                     as journal_period,IFNULL(credit,0) as credit,IFNULL(debit,0) as debit,companyName,companyId,journal_type_id,driverId
                                        from journal
                                        inner join drivers on drivers.id=journal.driverId
                                        inner join warehouse on warehouse.id=drivers.warehouseId
                                        inner join lkp_company on lkp_company.id=warehouse.companyId
                                        where credit>0 or debit>0
                                        )a
                                    GROUP BY companyName,companyId,driverId,journal_period
                                     )x
                                    JOIN (select @total:=0,@prev_driverId:=NULL) AS t
                                    ORDER BY driverId,journal_period
                                    )y
                                     GROUP BY companyName,companyId,journal_period
                                                                        order by companyName,journal_period
                                   ");
        return view('Reports.Salary')->with(compact('master'))
            ->with(compact('details'));
    }

//*********************************************************************************************************************
    public function Attachment(Request $request)
    {
        if (Auth::user()->user_type_id <> 1) {

            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
                INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
                where  user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $wher = " where warehouse.id in(" . implode(",", $whereIn_array) . ")";

            }
        } else {
            $wher = "";
            $AND = "";
        }

        $master = DB::select("select companyName,companyId,count(*) AS CO,
                                        SUM(Image_Identity)AS Image_Identity,
                                        SUM(Image_Passport)AS Image_Passport,
                                        SUM(Image_DrivingLicence)AS Image_DrivingLicence,
                                        SUM(Image_VehiclesRegistration)AS Image_VehiclesRegistration,
                                        SUM(Image_JobContract)AS Image_JobContract,
                                        SUM(Image_PromissoryNote)AS Image_PromissoryNote
                                        from lkp_company
                                        INNER JOIN warehouse on warehouse.companyId=lkp_company.id
                                        INNER JOIN drivers on drivers.warehouseId=warehouse.id AND drivers.status_id=1
                                        LEFT JOIN drivers_attachments on drivers_attachments.driverId=drivers.id
                                           " . $wher . "
                                        GROUP BY companyName,companyId");
        $details = DB::select("select companyName,companyId,warehouseName,count(*) AS CO,
                                        SUM(Image_Identity)AS Image_Identity,
                                        SUM(Image_Passport)AS Image_Passport,
                                        SUM(Image_DrivingLicence)AS Image_DrivingLicence,
                                        SUM(Image_VehiclesRegistration)AS Image_VehiclesRegistration,
                                        SUM(Image_JobContract)AS Image_JobContract,
                                        SUM(Image_PromissoryNote)AS Image_PromissoryNote
                                        from lkp_company
                                        INNER JOIN warehouse on warehouse.companyId=lkp_company.id
                                        INNER JOIN drivers on drivers.warehouseId=warehouse.id AND drivers.status_id=1
                                        LEFT JOIN drivers_attachments on drivers_attachments.driverId=drivers.id
                                        " . $wher . "
                                        GROUP BY companyName,companyId,warehouseName
                                    ");
        return view('Reports.Attachment')->with(compact('master'))
            ->with(compact('details'));
    }

//***********************************************************************************************************************************
//*********************************************************************************************************************
    public function Jahiz(Request $request)
    {
        if (Auth::user()->user_type_id <> 1) {

            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
                INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
                where  user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $wher = " where warehouseId in(" . implode(",", $whereIn_array) . ")";
                $AND=" AND warehouse.id in(" . implode(",", $whereIn_array) . ")";

            }
        } else {
            $wher = "";
            $AND = "";
        }

        $master = DB::select("SELECT
                        CONCAT( YEAR, '-', MONTH ) AS ym,
                        saned_settlement_CO,
                        AMP_ID_CO,
                        SANED_amount_plus,
                        SANED_amount_minus,
                        PerShipment_CO,
                        PerShipment_Bander_Commission,
                        MonthlySalary_CO,
                        MonthlySalary_Amount,
                        MonthlySalary_Amount_150,
                        MonthlySalary_Amount_NOT_150
                    FROM
                        lkp_jahiz_period
                        LEFT JOIN lkp_month ON lkp_month.id = lkp_jahiz_period.month_id
                        LEFT JOIN (
                        SELECT
                            count(*) AS saned_settlement_CO,
                            count(
                            DISTINCT ( AMP_ID )) AS AMP_ID_CO,
                            SUM( CASE WHEN drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit > 0 THEN drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit END ) AS SANED_amount_plus,
                            SUM( CASE WHEN drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit < 0 THEN drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit END ) AS SANED_amount_minus,
                            SUM( CASE WHEN drivers_jahiz_clearing.driver_type_id = 3 THEN 1 ELSE 0 END ) PerShipment_CO,
                            SUM( CASE WHEN drivers_jahiz_clearing.driver_type_id = 3 THEN Bander_Commission ELSE 0 END ) PerShipment_Bander_Commission,
                            DATE_FORMAT( SettledDate, '%Y-%m' ) AS SettledDatee
                        FROM
                            drivers_saned_settlement
                            LEFT JOIN drivers_jahiz_clearing ON drivers_jahiz_clearing.id = drivers_saned_settlement.drivers_jahiz_clearing_paid_id
                            LEFT JOIN drivers on drivers.job_id=drivers_saned_settlement.AMP_ID
                        ".$wher."
                        GROUP BY
                            SettledDatee
                        ) drivers_saned_settlement ON drivers_saned_settlement.SettledDatee = CONCAT( YEAR, '-', MONTH )
                        LEFT JOIN (
                        SELECT
                            ym,
                            count(*) AS MonthlySalary_CO,
                            SUM( MonthlySalary_Amount ) AS MonthlySalary_Amount,
                            SUM( CASE WHEN MonthlySalary_Amount = 150 THEN 1 ELSE 0 END ) AS MonthlySalary_Amount_150,
                            SUM( CASE WHEN MonthlySalary_Amount <> 150 THEN 1 ELSE 0 END ) AS MonthlySalary_Amount_NOT_150
                        FROM
                            (
                            SELECT
                                driverId,
                                CONCAT( YEAR, '-', MONTH ) AS ym,
                                sum( IFNULL( week1, 0 )+ IFNULL( week2, 0 )+ IFNULL( week3, 0 )+ IFNULL( week4, 0 )+ IFNULL( weekAll, 0 )+ IFNULL( amount_by_days, 0 ) ) MonthlySalary_Amount
                            FROM
                                drivers_jahiz_montly
                                LEFT JOIN lkp_jahiz_period ON lkp_jahiz_period.id = drivers_jahiz_montly.jahiz_period_id
                                LEFT JOIN lkp_month ON lkp_month.id = lkp_jahiz_period.month_id
                                LEFT JOIN drivers on drivers.id=drivers_jahiz_montly.driverId
                                ".$wher."
                            GROUP BY
                                driverId,
                                ym
                            ) a
                        GROUP BY
                            ym
                        ) drivers_jahiz_montly ON drivers_jahiz_montly.ym = CONCAT( YEAR, '-', MONTH )
                    ORDER BY
                        YEAR DESC,
                        month_id DESC
                              ");
        $details = DB::select("SELECT
                           master_tb.ym,
                           warehouse_id,
                           warehouseName,
                           saned_settlement_CO,
                           AMP_ID_CO,
                           SANED_amount_plus,
                           SANED_amount_minus,
                           PerShipment_CO,
                           PerShipment_Bander_Commission,
                           MonthlySalary_CO,
                           MonthlySalary_Amount,
                           MonthlySalary_Amount_150,
                           MonthlySalary_Amount_NOT_150
                        FROM
                           (
                              SELECT
                                 CONCAT(YEAR, '-', MONTH) AS ym,
                                 warehouse_id,
                                 warehouseName
                              FROM
                                 (
                                    SELECT
                                       lkp_jahiz_period.id AS lkp_jahiz_period_id,
                                       YEAR,
                                       month_id,
                                       warehouse.id AS warehouse_id,
                                       warehouseName
                                    FROM
                                       lkp_jahiz_period,
                                       warehouse
                                    WHERE
                                       companyId = 6
                                     ".$AND."
                                     ) a
                              LEFT JOIN lkp_month ON lkp_month.id = a.month_id
                           ) master_tb
                        LEFT JOIN (
                           SELECT
                              DATE_FORMAT(SettledDate, '%Y-%m') AS SettledDatee,
                              warehouseId,
                              count(*) AS saned_settlement_CO,
                              count(DISTINCT(AMP_ID)) AS AMP_ID_CO,
                              SUM(
                                 CASE
                                 WHEN drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit > 0 THEN
                                    drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit
                                 END
                              ) AS SANED_amount_plus,
                              SUM(
                                 CASE
                                 WHEN drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit < 0 THEN
                                    drivers_saned_settlement.CollectionAmount - DeliveryPrice - DriverCredit + DriverDebit
                                 END
                              ) AS SANED_amount_minus,
                              SUM(CASE WHEN drivers_jahiz_clearing.driver_type_id = 3 THEN 1 ELSE 0 END) PerShipment_CO,
                              SUM(CASE WHEN drivers_jahiz_clearing.driver_type_id = 3 THEN Bander_Commission ELSE 0 END) PerShipment_Bander_Commission
                           FROM
                              drivers_saned_settlement
                           LEFT JOIN drivers_jahiz_clearing ON drivers_jahiz_clearing.id = drivers_saned_settlement.drivers_jahiz_clearing_paid_id
                           LEFT JOIN drivers ON drivers.job_id = drivers_saned_settlement.AMP_ID
                            ".$wher."
                           GROUP BY
                              warehouseId,
                              SettledDatee
                        ) drivers_saned_settlement ON drivers_saned_settlement.SettledDatee = master_tb.ym
                        AND drivers_saned_settlement.warehouseId = master_tb.warehouse_id
                        LEFT JOIN (
                           SELECT
                              ym,
                              warehouseId,
                              count(*) AS MonthlySalary_CO,
                              SUM(MonthlySalary_Amount) AS MonthlySalary_Amount,
                              SUM(CASE WHEN MonthlySalary_Amount = 150 THEN 1 ELSE 0 END) AS MonthlySalary_Amount_150,
                              SUM(CASE WHEN MonthlySalary_Amount <> 150 THEN 1 ELSE 0 END) AS MonthlySalary_Amount_NOT_150
                           FROM
                              (
                                 SELECT
                                    driverId,
                                    warehouseId,
                                    CONCAT(YEAR, '-', MONTH) AS ym,
                                    sum(
                                       IFNULL(week1, 0) + IFNULL(week2, 0) + IFNULL(week3, 0) + IFNULL(week4, 0) + IFNULL(weekAll, 0) + IFNULL(amount_by_days, 0)
                                    ) MonthlySalary_Amount
                                 FROM
                                    drivers_jahiz_montly
                                 LEFT JOIN lkp_jahiz_period ON lkp_jahiz_period.id = drivers_jahiz_montly.jahiz_period_id
                                 LEFT JOIN lkp_month ON lkp_month.id = lkp_jahiz_period.month_id
                                 LEFT JOIN drivers ON drivers.id = drivers_jahiz_montly.driverId
                                  ".$wher."
                                 GROUP BY
                                    driverId,
                                    warehouseId,
                                    ym
                              ) a
                           GROUP BY
                              ym,
                              warehouseId
                        ) drivers_jahiz_montly ON drivers_jahiz_montly.ym = master_tb.ym
                        AND drivers_jahiz_montly.warehouseId = master_tb.warehouse_id

                        ORDER BY
                           master_tb.ym DESC,warehouse_id
                                                            ");
        return view('Reports.Jahiz')->with(compact('master'))
            ->with(compact('details'));
    }

//***********************************************************************************************************************************
//***********************************************************************************************************************************
    public function ViewLoan(Request $request)
    {
        if ($request->id <> 'm') {
            $lkp_company = DB::select("select companyName from lkp_company where id=" . $request->id)[0];
            $companyName = $lkp_company->companyName;
        } else
            $companyName = 'All';
        return view('Reports.ViewLoan')
            ->with('m', $request->m)
            ->with('id', $request->id)
            ->with('type', $request->type)
            ->with(compact('companyName'));
    }

    public
    function ViewCreditNote(Request $request)
    {
        if ($request->id <> 'm') {
            $lkp_company = DB::select("select companyName from lkp_company where id=" . $request->id)[0];
            $companyName = $lkp_company->companyName;
        } else
            $companyName = 'All';
        return view('Reports.ViewCreditNote')
            ->with('m', $request->m)
            ->with('id', $request->id)
            ->with('type', $request->type)
            ->with(compact('companyName'));
    }

    public
    function ViewJournal(Request $request)
    {
        if ($request->id <> 'm') {
            $lkp_company = DB::select("select companyName from lkp_company where id=" . $request->id)[0];
            $companyName = $lkp_company->companyName;
        } else
            $companyName = 'All';
        return view('Reports.ViewJournal')
            ->with('m', $request->m)
            ->with('id', $request->id)
            ->with('type', $request->type)
            ->with('journal', $request->journal)
            ->with(compact('companyName'));
    }

    public
    function ViewSalary(Request $request)
    {
        if ($request->id <> 'm') {
            $lkp_company = DB::select("select companyName from lkp_company where id=" . $request->id)[0];
            $companyName = $lkp_company->companyName;
        } else
            $companyName = 'All';
        return view('Reports.ViewSalary')
            ->with('m', $request->m)
            ->with('id', $request->id)
            ->with('type', $request->type)
            ->with('journal', $request->journal)
            ->with(compact('companyName'));
    }
//***********************************************************************************************************************************
//*********************************************************************************************************************
    public function Claim(Request $request)
    {
        if (Auth::user()->user_type_id <> 1) {

            $whereIn_array = array();
            if (Auth::user()->user_type_id <> 1) {
                $users_privilege = DB::select('SELECT user_id,warehouseId from users_privilege
                INNER JOIN warehouse on warehouse.id=users_privilege.warehouseId
                where  user_id=' . Auth::user()->id);
                foreach ($users_privilege as $users_privilegee) {
                    //echo $users_privilegee->warehouseId;
                    $whereIn_array[] = $users_privilegee->warehouseId;
                }
                if (count($whereIn_array) == 0) $whereIn_array[] = 0;
                $wher = " where warehouse.id in(" . implode(",", $whereIn_array) . ")";

            }
        } else {
            $wher = "";
            $AND = "";
        }

        $master = DB::select("
                            select claim_status_id,status_txt,count(*) AS CO,
                            sum(Image_Identity_NOT) AS Image_Identity_NOT,
                            sum(Image_PromissoryNote_NOT) AS Image_PromissoryNote_NOT,
                            sum(bag_fee_NOT) AS bag_fee_NOT,
                            sum(Bander_Commission_NOT) AS Bander_Commission_NOT,
                            sum(IFNULL(bag_fee,0)) as bag_fee,
                            sum(IFNULL(Bander_Commission,0)) as Bander_Commission,
                            sum(amount) as amount
                             from(
                            SELECT
                               drivers_jahiz_claim.id AS id,
                            claim_status.claim_status_id,
                            status_txt,
                            amount,
                               claim_dt,

                               warehouseId,
                               warehouseName,
                               job_id,
                               fullName,
                               IFNULL(bag_fee, '') AS bag_fee,
                               IFNULL(drivers_jahiz_claim.Bander_Commission, '') AS Bander_Commission,
                            CASE  WHEN bag_fee is  null THEN 1  ELSE 0 END AS bag_fee_NOT,
                            CASE  WHEN drivers_jahiz_claim.Bander_Commission is  null THEN 1  ELSE 0 END AS Bander_Commission_NOT,
                            CASE  WHEN Image_Identity is  null THEN 1  ELSE 0 END AS Image_Identity_NOT,
                            CASE  WHEN Image_PromissoryNote is  null THEN 1  ELSE 0 END AS Image_PromissoryNote_NOT
                            FROM
                               `drivers_jahiz_claim`
                            LEFT JOIN `drivers` ON `drivers_jahiz_claim`.`driverId` = `drivers`.`id`
                            LEFT JOIN `warehouse` ON `drivers`.`warehouseId` = `warehouse`.`id`
                            LEFT JOIN drivers_attachments ON drivers.id=drivers_attachments.driverId
                            LEFT JOIN (
                               SELECT
                                  a.drivers_jahiz_claim_id,
                                  a.claim_status_id,
                                  status_txt,
                                  a.created_at
                               FROM
                                  drivers_jahiz_claim_reply AS a
                                  left Join lkp_claim_status on a.claim_status_id=lkp_claim_status.id
                               INNER JOIN (
                                  SELECT
                                     drivers_jahiz_claim_id,
                                     MAX(created_at) created_at
                                  FROM
                                     drivers_jahiz_claim_reply

                                  WHERE
                                     claim_status_id IS NOT NULL
                                  GROUP BY
                                     drivers_jahiz_claim_id
                               ) b ON a.drivers_jahiz_claim_id = b.drivers_jahiz_claim_id
                               AND a.created_at = b.created_at
                               WHERE
                                  a.claim_status_id IS NOT NULL
                            ) claim_status ON `claim_status`.`drivers_jahiz_claim_id` = `drivers_jahiz_claim`.`id`
                         ".$wher."
                            )a

                            GROUP BY claim_status_id,status_txt

                              ");
        $details = DB::select("select claim_status_id,status_txt,warehouseId,warehouseName,count(*) AS CO,
                        sum(Image_Identity_NOT) AS Image_Identity_NOT,
                        sum(Image_PromissoryNote_NOT) AS Image_PromissoryNote_NOT,
                        sum(bag_fee_NOT) AS bag_fee_NOT,
                        sum(Bander_Commission_NOT) AS Bander_Commission_NOT,
                        sum(IFNULL(bag_fee,0)) as bag_fee,
                        sum(IFNULL(Bander_Commission,0)) as Bander_Commission,
                        sum(amount) as amount
                         from(
                        SELECT
                           drivers_jahiz_claim.id AS id,
                        claim_status.claim_status_id,
                        status_txt,
                        amount,
                           claim_dt,

                           warehouseId,
                           warehouseName,
                           job_id,
                           fullName,
                           IFNULL(bag_fee, '') AS bag_fee,
                           IFNULL(drivers_jahiz_claim.Bander_Commission, '') AS Bander_Commission,
                        CASE  WHEN bag_fee is  null THEN 1  ELSE 0 END AS bag_fee_NOT,
                        CASE  WHEN drivers_jahiz_claim.Bander_Commission is  null THEN 1  ELSE 0 END AS Bander_Commission_NOT,
                        CASE  WHEN Image_Identity is  null THEN 1  ELSE 0 END AS Image_Identity_NOT,
                        CASE  WHEN Image_PromissoryNote is  null THEN 1  ELSE 0 END AS Image_PromissoryNote_NOT
                        FROM
                           `drivers_jahiz_claim`
                        LEFT JOIN `drivers` ON `drivers_jahiz_claim`.`driverId` = `drivers`.`id`
                        LEFT JOIN `warehouse` ON `drivers`.`warehouseId` = `warehouse`.`id`
                        LEFT JOIN drivers_attachments ON drivers.id=drivers_attachments.driverId
                        LEFT JOIN (
                           SELECT
                              a.drivers_jahiz_claim_id,
                              a.claim_status_id,
                              status_txt,
                              a.created_at
                           FROM
                              drivers_jahiz_claim_reply AS a
                              left Join lkp_claim_status on a.claim_status_id=lkp_claim_status.id
                           INNER JOIN (
                              SELECT
                                 drivers_jahiz_claim_id,
                                 MAX(created_at) created_at
                              FROM
                                 drivers_jahiz_claim_reply

                              WHERE
                                 claim_status_id IS NOT NULL
                              GROUP BY
                                 drivers_jahiz_claim_id
                           ) b ON a.drivers_jahiz_claim_id = b.drivers_jahiz_claim_id
                           AND a.created_at = b.created_at
                           WHERE
                              a.claim_status_id IS NOT NULL
                        ) claim_status ON `claim_status`.`drivers_jahiz_claim_id` = `drivers_jahiz_claim`.`id`
                        ".$wher."

                        )a

                        GROUP BY claim_status_id,status_txt,warehouseId,warehouseName

                                                            ");
        return view('Reports.Claim')->with(compact('master'))
            ->with(compact('details'));
    }
}
