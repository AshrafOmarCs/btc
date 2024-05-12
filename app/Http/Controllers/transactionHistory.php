<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use App\Transcation_history;
use Illuminate\Http\Request;

class transactionHistory extends Controller
{
    public function getWarehouse(Request $request){
        // return $request->all();
        if($request->company_id == 0){
            // if the company id is NOT set
            return 0;
        }else{
             // if the company id is set
             if(isset($request->city_id)){
                //  dd('city is set');
                  $sql = "SELECT id,warehouseName FROM `warehouse` WHERE companyId= ".$request->company_id." and cityId=".$request->city_id."  ORDER BY warehouseName ASC";
             }else{
                //  dd('warehouse not 0 and city is not set');
                  $sql = "SELECT id,warehouseName FROM `warehouse` WHERE companyId= ".$request->company_id."  ORDER BY warehouseName ASC";
             }
        }
        
        
        // prepare html response 
        
        // return $sql;
        $waregouses = DB::select($sql);
        
        $options = '<option value="0" selected disabled>Select Warehouse (Optional)</option>';
        foreach($waregouses as $waregouse){ 
            $tem = "<option value=".$waregouse->id.">".$waregouse->warehouseName."</option> ";
            $options = $options.' '.$tem;
        }
        return $options;
        
        // return $waregouses;
    }
    public function index(){
        $lkp_company  = DB::select('SELECT * from lkp_company where lkp_company.status = "active"');
        // $transaction_histories = Transcation_history::all();
        $transaction_histories = DB::select("SELECT salary_import_paid_details.*,drivers.fullName,drivers.id as 'driverInteralID',warehouse.warehouseName,salary_import_paid_master.fileName,salary_import_paid_master.create_at as 'fileDate',journal.journal_date,lkp_journal_type.journal_type,lkp_city.name_en as 'cityName' from salary_import_paid_details
        JOIN  drivers ON drivers.job_id = salary_import_paid_details.AMP_ID
        JOIN  warehouse ON warehouse.id = drivers.warehouseId  
        JOIN salary_import_paid_master on salary_import_paid_master.id = salary_import_paid_details.paid_master_id  
        join journal ON journal.id = salary_import_paid_details.journal_id
        JOIN lkp_journal_type ON lkp_journal_type.id = journal.journal_type_id
        JOIN lkp_city ON lkp_city.id = warehouse.cityId
        ORDER BY `salary_import_paid_details`.`paid_master_id` DESC");
        
        // $projectName= $transaction_histories[0]->fileName;
        foreach($transaction_histories as $k=>$transaction_history){
            $pieces = explode("_", $transaction_history->fileName);
            $pieces = $pieces[0];
            $transaction_histories[$k]->projectName = $pieces;
            // dd($transaction_histories[$k]);
        }
        
        $payload = array('projectName'=>$pieces);
        return view('history.index',compact('lkp_company','transaction_histories','payload'));
    }
    public function LoadHistory($driver_id){
        $transaction_histories = DB::select("SELECT salary_import_paid_details.*,drivers.fullName,drivers.id as 'driverInteralID',warehouse.warehouseName,salary_import_paid_master.fileName,salary_import_paid_master.create_at as 'fileDate',journal.journal_date,lkp_journal_type.journal_type  from salary_import_paid_details
        JOIN  drivers ON drivers.job_id = salary_import_paid_details.AMP_ID
        JOIN  warehouse ON warehouse.id = drivers.warehouseId  
        JOIN salary_import_paid_master on salary_import_paid_master.id = salary_import_paid_details.paid_master_id  
        join journal ON journal.id = salary_import_paid_details.journal_id
        JOIN lkp_journal_type ON lkp_journal_type.id = journal.journal_type_id
        WHERE drivers.id = ".$driver_id."
        ORDER BY `salary_import_paid_details`.`paid_master_id` DESC");
        $elemet ='' ;
        foreach($transaction_histories as $k=>$transaction_history){
            $pieces = explode("_", $transaction_history->fileName);
            $pieces = $pieces[0];
            $transaction_histories[$k]->projectName = $pieces;
            // dd($transaction_history);
            $result = $k%2 == 0;
            if($result == true){
                $result = ' ';
            }else{
                $result = ' background-color: #ecf0f56b; ';
            }
            // dd($result);
            $tem = "
            <tr style='text-align: center;font-size: 15px;".$result."'>
                <td>".++$k."</td>
                <td>".$transaction_history->projectName."</td>
                <td>".$transaction_history->journal_date."</td>
                <td>".$transaction_history->journal_type."</td>
                <td>".$transaction_history->bank_paid."</td>
                <td>
                <span style='font-weight: 600;color: #337ab7;'>".$transaction_history->accountNumber."</span><hr style='margin: 2px 0;'>
                <span style='font-weight: 600;color: #00a65a;'>".$transaction_history->account_owner_iqama." </span>
                </td>
                <td>
                    <button class='btn btn-dark'>Excel File</button>
                </td>
            </tr>";
            
            $elemet = $elemet.' '.$tem;
        }
        $driverData = DB::select("select * from where id=".$driver_id." ");
         $driverData = $driverData[0];
        $payload = array('driverData'=>$driverData,'data'=>$elemet);
        return $payload;
        
    }
    public function getCities($company_id,$city_id){
        
        $sql = "SELECT warehouse.id  as 'warehouse_id',lkp_city.* FROM `warehouse` 
            JOIN lkp_city on lkp_city.id = warehouse.cityId 
            WHERE warehouse.companyId =".$company_id." ORDER BY lkp_city.name_en ASC;";
        $cities = DB::select($sql);
        $options = '<option value="0" selected disabled>Select City (Optional)</option>';
        foreach($cities as $city){
             if($city_id == $city->id){
                  $tem = "<option value=".$city->id." selected >".$city->name_en."</option> ";
             }else{
                  $tem = "<option value=".$city->id.">".$city->name_en."</option> ";
             }
           
            $options = $options.' '.$tem;
        }
        return $options;
    }
    public function excuteTransactionFilter(Request $request){
        $inputs = $request->all();
        // dd($inputs['filter_companyId']);
        // dd($request->all());
        $where = ' ';
        if($request->filter_companyId == 0){
        }else{
            
            $where = 'WHERE warehouse.companyId ='.$request->filter_companyId;
           
            if($request->filter_cityId != null){
                $where = $where . " AND lkp_city.id =".$request->filter_cityId." ";
            }
             if($request->filter_warehouseId != null){
                $where = $where . " AND warehouse.id =".$request->filter_warehouseId." ";
            }
            if($request->filter_journal_date != null){
                // prepare journal format ' From '
                    $values = explode(" - ", $request->filter_journal_date);
                    $from = $values[0];
                    $_stockupdate= Carbon::parse($from)->format('Y-m-d'); 
                    $ymd_from = $_stockupdate;
                // end of 
                
                // prepare journal date TO
                    $to = $values[1];
                    $to = Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d');
                // end of 
                
                // Conditions where journal between 
               
                $where = $where . "AND journal_date BETWEEN '".$ymd_from."' AND '".$to."'";
            }
             
            if($request->payment_journal_date != null){
                // dd($request->payment_journal_date);
                
                // prepare journal format ' From '
                    $values = explode(" - ",$request->payment_journal_date);
                    $from = $values[0];
                    $_stockupdate= Carbon::parse($from)->format('Y-m-d'); 
                    $ymd_from = $_stockupdate;
                // end of 
                
                // prepare journal date TO
                    $to = $values[1];
                    $to = Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d');
                // end of 
                
                $where = $where . " AND salary_import_paid_master.created_at between '".$ymd_from."' AND '".$to."'";
            }
        }
        $sql = "SELECT salary_import_paid_details.*,drivers.fullName,drivers.id as 'driverInteralID',warehouse.warehouseName,salary_import_paid_master.fileName,salary_import_paid_master.create_at as 'fileDate',journal.journal_date,lkp_journal_type.journal_type,lkp_city.name_en as 'cityName'  from salary_import_paid_details
                JOIN drivers ON drivers.job_id = salary_import_paid_details.AMP_ID
                JOIN warehouse ON warehouse.id = drivers.warehouseId
                JOIN salary_import_paid_master on salary_import_paid_master.id = salary_import_paid_details.paid_master_id
                join journal ON journal.id = salary_import_paid_details.journal_id
                JOIN lkp_journal_type ON lkp_journal_type.id = journal.journal_type_id
                JOIN lkp_city ON lkp_city.id = warehouse.cityId
                ".$where." 
                ORDER BY `salary_import_paid_details`.`paid_master_id` DESC limit 100";
        $lkp_company  = DB::select('SELECT * from lkp_company where lkp_company.status = "active"');
        
        $transaction_histories = DB::select($sql);
        if(count($transaction_histories)>0){
        foreach($transaction_histories as $k=>$transaction_history){
            $pieces = explode("_", $transaction_history->fileName);
            $pieces = $pieces[0];
            $transaction_histories[$k]->projectName = $pieces;
        }
         $payload = array('projectName'=>$pieces);
          return view('history.index',compact('lkp_company','transaction_histories','payload','inputs'));
        }else{
            $payload = array('projectName'=>'');
            return view('history.index',compact('lkp_company','transaction_histories','payload','inputs'));
        }
       
        
        return $transaction_histories;
        return $request->all();
    }
    public function loansHistory(){
        $lkp_company  = DB::select('SELECT * from lkp_company where lkp_company.status = "active"');
        // $transaction_histories = Transcation_history::all();
        $transaction_histories = DB::select("SELECT loan_import_paid_details.*,drivers.fullName,drivers.id as 'driverInteralID',warehouse.warehouseName,loan_import_paid_master.fileName,loan_import_paid_master.create_at as 'fileDate' ,loan.journal_date as 'journal_date', lkp_loan_status.loan_status as 'journal_type',lkp_city.name_en as 'cityName' FROM `loan_import_paid_details` JOIN drivers ON drivers.job_id = loan_import_paid_details.AMP_ID JOIN warehouse ON warehouse.id = drivers.warehouseId JOIN loan_import_paid_master on loan_import_paid_master.id = loan_import_paid_details.paid_master_id JOIN loan ON loan.id = loan_import_paid_details.loan_id JOIN lkp_loan_status ON lkp_loan_status.id = loan.status_id JOIN lkp_city ON lkp_city.id = warehouse.cityId");
        
        // $projectName= $transaction_histories[0]->fileName;
        foreach($transaction_histories as $k=>$transaction_history){
            $pieces = explode("_", $transaction_history->fileName);
            $pieces = $pieces[0];
            $transaction_histories[$k]->projectName = $pieces;
            // dd($transaction_histories[$k]);
        }
        
        $payload = array('projectName'=>$pieces);
        return view('history.index_loans',compact('lkp_company','transaction_histories','payload'));
    }
    public function jahizHistory(){
        
        return 'loansHistory';
    }
}
