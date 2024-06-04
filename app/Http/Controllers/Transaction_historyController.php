<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Transaction_historyController extends Controller
{
    //
    public function index(){
        return view('new_porttal.TrancactionHistory.index');
    }
    public function search(Request $request){
        $array1; $array2; $array3;

        if($request->amp_id == ''  && $request->account_number == '' && $request->id_no == ''){
            return ('its Empty');
        } else {
            if ($request->trancation_type == 'all') {
                $array1 = $this->getSalariesHistory($request);
                $array2 = $this->getLoansHistory($request);
                $array3 = $this->getJahizHistory($request);
                $result = array_merge($array1, $array2, $array3);
                return $result;
            } else if ($request->trancation_type == 'salaries') {
                return $array1 = $this->getSalariesHistory($request);
            } else if ($request->trancation_type == 'loans') {
                return $array1 = $this->getLoansHistory($request);
            } else if ($request->trancation_type == 'jahiz') {
                return $array1 = $this->getJahizHistory($request);
            }
        }
    }

    public function getSalariesHistory($data){
        $response = array();
        $amp_clause = $account_number_clause = $id_no_clause = $date_clause = '';
        if($data->amp_id != ''){
            $amp_clause = "AND salary_import_paid_details.AMP_ID ='$data->amp_id'";
        }
        if($data->account_number != ''){
            $account_number_clause = " AND  salary_import_paid_details.account_owner_iqama =$data->account_number ";
        }
        if($data->id_no != ''){
            $id_no_clause =  " AND salary_import_paid_details.accountNumber ='$data->id_no'";
        }
        if($data->selected_date != ''){
            $str = explode("/", $data->selected_date);
            $s_date = $str[0];
            $e_date = $str[1];
            $date_clause = " AND salary_import_paid_master.create_at >= '$s_date' AND salary_import_paid_master.create_at <= '$e_date'";

        }

        $sql = "SELECT salary_import_paid_details.AMP_ID, salary_import_paid_details.account_owner_iqama,salary_import_paid_details.accountNumber,salary_import_paid_details.bank_sum,salary_import_paid_details.CO,salary_import_paid_details.bank_paid,salary_import_paid_details.paid,salary_import_paid_master.create_at,drivers.fullName,drivers.job_id,warehouse.warehouseName,lkp_company.companyName FROM `salary_import_paid_details`
                JOIN salary_import_paid_master ON salary_import_paid_master.id = salary_import_paid_details.paid_master_id
                JOIN drivers ON drivers.job_id = salary_import_paid_details.AMP_ID
                JOIN warehouse ON warehouse.id = drivers.warehouseId
                JOIN lkp_company ON lkp_company.id = warehouse.companyId
                where 1 = 1 $amp_clause $account_number_clause $id_no_clause $date_clause";
        $response = DB::select($sql);
        if(count($response)>0){
            foreach ($response as &$record) {
                $record->type = 'Salary';
            }
            return $response;
        }else{
            return $response;
        }
    }
    public function getLoansHistory($data){
        $response = array();
        $amp_clause = $account_number_clause = $id_no_clause = $date_clause = '';
        if($data->amp_id != ''){
            $amp_clause = "AND loan_import_paid_details.AMP_ID ='$data->amp_id' ";
        }
        if($data->account_number != ''){
            $account_number_clause = " AND   loan_import_paid_details.account_owner_iqama =$data->account_number ";
        }
        if($data->id_no != ''){
            $id_no_clause =  " AND loan_import_paid_details.accountNumber ='$data->id_no' ";
        }
        if($data->selected_date != ''){
            $str = explode("/", $data->selected_date); //just to split start date and end date from string
            $s_date = $str[0];
            $e_date = $str[1];
            $date_clause = " AND loan_import_paid_master.create_at >= '$s_date' AND loan_import_paid_master.create_at <= '$e_date'";
        }
        $sql = "SELECT drivers.fullName, loan_import_paid_details.AMP_ID, loan_import_paid_details.account_owner_iqama,loan_import_paid_details.accountNumber,loan_import_paid_details.bank_sum,loan_import_paid_details.CO,loan_import_paid_details.bank_paid,loan_import_paid_details.paid,loan_import_paid_master.create_at,drivers.job_id,warehouse.warehouseName,lkp_company.companyName FROM loan_import_paid_details JOIN loan_import_paid_master ON loan_import_paid_master.id = loan_import_paid_details.paid_master_id JOIN drivers ON loan_import_paid_details.AMP_ID = drivers.job_id JOIN warehouse ON warehouse.id = drivers.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE 1 = 1 $amp_clause $account_number_clause $id_no_clause $date_clause";
        $response = DB::select($sql);
        if(count($response)>0){
            foreach ($response as &$record) {
                $record->type = 'Loan';
            }
            return $response;
        }else{
            return $response;
        }
    }

    public function getJahizHistory($data){
        $response = array();
        $amp_clause = $account_number_clause = $id_no_clause = $date_clause = '';
        if($data->amp_id != ''){
            $amp_clause = "AND drivers_saned_import_paid_details.AMP_ID ='$data->amp_id' ";
        }
        if($data->account_number != ''){
            $account_number_clause = " AND   drivers_saned_import_paid_details.account_owner_iqama =$data->account_number ";
        }
        if($data->id_no != ''){
            $id_no_clause =  " AND drivers_saned_import_paid_details.accountNumber ='$data->id_no' ";
        }
        if($data->selected_date != ''){
            $str = explode("/", $data->selected_date);
            $s_date = $str[0];
            $e_date = $str[1];
            $date_clause = " AND drivers_saned_import_paid_master.create_at >= '$s_date' AND drivers_saned_import_paid_master.create_at <= '$e_date'";
        }
        $sql = "SELECT drivers.fullName, drivers_saned_import_paid_details.AMP_ID,drivers_saned_import_paid_details.account_owner_iqama,drivers_saned_import_paid_details.accountNumber,drivers_saned_import_paid_details.bank_minus_plus as bank_sum,drivers_saned_import_paid_details.CO,drivers_saned_import_paid_details.bank_paid,drivers_saned_import_paid_details.paid,drivers_saned_import_paid_master.create_at,drivers.job_id,warehouse.warehouseName,lkp_company.companyName FROM drivers_saned_import_paid_details JOIN drivers_saned_import_paid_master ON drivers_saned_import_paid_master.id = drivers_saned_import_paid_details.paid_master_id JOIN drivers ON drivers_saned_import_paid_details.AMP_ID = drivers.job_id JOIN warehouse ON warehouse.id = drivers.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE 1 = 1 $amp_clause $account_number_clause $id_no_clause $date_clause";        $response = DB::select($sql);
        if(count($response)>0){
            foreach ($response as &$record) {
                $record->type = 'Jahiz';
            }
            return $response;
        }else{
            return $response;
        }

    }
}

