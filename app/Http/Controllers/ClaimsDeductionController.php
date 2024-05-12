<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;


function make_buttons($drivers, $city_id) {
    $today = date("Y-m-d");

    $records = count($drivers);
    $division = 100;
    $numButtons = ceil($records / $division);
    $response = "";
    for ($i = 0; $i < $numButtons; $i++) {
      $start = ($i * $division) + 1;
      $end = min(($i + 1) * $division, $records);
      $sync_status = DB::select("SELECT id FROM `drivers_jahiz_claim_sync_status` WHERE city_id = '$city_id' AND start_position = '$start' AND end_position = '$end' AND `date` = '$today'");
      if(count($sync_status)>0){
        $color = 'green';
        $disabled = 'disabled';
        $fa_icon = 'check';
      } else {
        $color = 'red';
        $disabled = '';
        $fa_icon = 'times';
      }
      $response .= "<div class='col-md-2' style='margin-top: 20px; '>
                        <button $disabled onclick='show_drivers($city_id,$start,$end)' class='btn btn-info btn-small' style='width: 100%; height: 100px'>$start-$end <i style='color: $color;' class='fa fa-$fa_icon'></i></button>
                    </div>";
    }
    return $response;
}


function getDriverClaims($payload, $request){
    $today = date("Y-m-d");
    $makeResponse = '';
    $url1 = $request->url1;
    $url2 = $request->url2;
    $cookie = $request->filter_cookie;
    $start = $counter = 0;
    $Cookie = 'Cookie:'.$cookie;
    $clims = $driverIds = array();
    for($start; $start < sizeof($payload); $start++){
        $driverItem = $payload[$start];
        $driverId = $driverItem->id;
        $driverIds[] = $driverId;
        $clearing_date = DB::select("SELECT created_at FROM `drivers_jahiz_clearing` WHERE `driverId` = '$driverId' order by id DESC");
        if(count($clearing_date) > 0)
            $last_set_date = $clearing_date[0]->created_at;
        else
            $last_set_date = 'N/A';
        $counter += 1;
        $makeResponse .= '<tr><td>'.$counter.'</td><td>'.$driverItem->AMP_ID.'</td><td>'.$driverItem->fullName.'</td><td>'.$last_set_date.'</td>';
        try{
            $curl = curl_init();
            $driver_id = $driverItem->AMP_ID;
            $totalAmounts = array();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url1.$driver_id.$url2,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',

              CURLOPT_HTTPHEADER => array(
                                  $Cookie,
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
                'Referer: https://www.btcdmins.com',

                'Cookie: enable-cookies=1',

              ),
            ));

            $response = curl_exec($curl);
    
            curl_close($curl);
                            print_r($response);
                            dd($Cookie);
            $response = json_decode($response, true);
            

            if($response == null){
                $makeResponse = '<tr><td colspan="6">Something went wrong. Try again</td></tr>';
                return $makeResponse;
                break;
            } else if($response['iTotalRecords'] == 0){
                $makeResponse .= '<td>0</td><td>0</td></tr>';
                
                $sql = "SELECT drivers_jahiz_claim.* FROM `drivers_jahiz_claim` JOIN drivers ON drivers.id = drivers_jahiz_claim.driverId WHERE drivers.job_id = '".$driver_id."'";
                $driver_response = DB::select($sql);
                // echo $start . '- Driver '.$driverItem->AMP_ID.', Saned Amount: 0.00 <br>' ;
                if(count($driver_response)>0){ 
                    DB::update("UPDATE `drivers_jahiz_claim` SET`amount`=0 WHERE id =".$driver_response[0]->id." ");
                }else{
                    continue;
                }
            } else {
                $jsonResponse = $response['aaData'];
                foreach($jsonResponse as $driver){
                    $amount = $driver['collectionAmount'];
                    $price =  $driver['price'];
                    $credit =  $driver['driverCreditAmount'];
                    $freeOrders =  $driver['isFreeOrder'];
                    $debit =  $driver['driverDebitAmount'];
                    $total = $amount-$price-$credit-$freeOrders+$debit;
                    $totalAmounts[] = $total;
                } 
                $totalAmount = array_sum($totalAmounts); 
                // echo $start . '- Driver '.$driverItem->AMP_ID.', Saned Amount: '.$totalAmount.'<br>' ;
            
                if($totalAmount > 1){
                    $driver_ress = DB::select("SELECT * FROM `drivers` WHERE `job_id` LIKE '".$driver_id."'");
                    
                    $claims = DB::select("SELECT * FROM `drivers_jahiz_claim` WHERE driverId =".$driver_ress[0]->id."");
                    if(count($claims)>0){
                        // claim is exsit  
                        DB::update("UPDATE `drivers_jahiz_claim` SET `amount`= ".$totalAmount." WHERE `id` =".$claims[0]->id." ");
                        if(round((float)$claims[0]->amount, 2) == round((float)$totalAmount, 2)){
                            // echo 'yup';
                        } else {
                            $msg = "Amount Updated from ".$claims[0]->amount." To $totalAmount";
                            $sql = "SELECT * FROM `drivers_jahiz_claim_reply` WHERE `drivers_jahiz_claim_id` = ".$claims[0]->id."  and claim_status_id=18 ORDER BY `drivers_jahiz_claim_reply`.`id` DESC";
                            $claims_repy_res = DB::select($sql);
                            if(count($claims_repy_res)>0){ 
                                DB::update("UPDATE `drivers_jahiz_claim_reply` SET `reply_txt`='".$msg."' where id=".$claims_repy_res[0]->id." ");
                            } else {
                              DB::insert("INSERT INTO `drivers_jahiz_claim_reply`(`drivers_jahiz_claim_id`, `reply_txt`, `claim_status_id`, `created_by_id`) VALUES (".$claims[0]->id.",'".$msg."',18,2)"); 
                            } 
                        }
                    }else{
                        // Create new claim 
                        $date = Carbon::now()->toDateString();
                        DB::insert("INSERT INTO `drivers_jahiz_claim`(`driverId`, `amount`, `claim_dt`,`created_by_id`, `updated_by_id`) VALUES (".$driver_ress[0]->id.",".$totalAmount.",'".$date."',2,2)"); 
                    }
                } else{
                    $driver_ress = DB::select("SELECT * FROM `drivers` WHERE `job_id` LIKE '".$driver_id."'");
                    $claims = DB::select("SELECT * FROM `drivers_jahiz_claim` WHERE driverId =".$driver_ress[0]->id."");
                    if(count($claims)>0){
                        DB::select("DELETE FROM `drivers_jahiz_claim_reply` WHERE `drivers_jahiz_claim_id` = ".$claims[0]->id.""); 
                        DB::select("DELETE FROM `drivers_jahiz_claim` WHERE id =".$claims[0]->id.""); 
                    }
                }
                $totalAmounts = null;
                $driverItem->claimAmount = $totalAmount;
                
                $sync_amount = DB::select("SELECT amount FROM `drivers_jahiz_claim` WHERE `driverId` = '$driverId'");
                if(count($sync_amount) > 0)
                    $total_amount = $sync_amount[0]->amount;
                else
                    $total_amount = 'N/A';
                $color = $colorr = '';
                if((int)$totalAmount > 200) {
                    $color = 'red';
                }
                if((int)$total_amount > 200) {
                    $colorr = 'red';
                }
                $makeResponse .= '<td style="color: '.$color.'">'.$totalAmount.'</td><td style="color: '.$colorr.'">'.$total_amount.'</td></tr>';
            
            }
        } catch (Throwable $e) {
            // dd('error');
            $driverItem->count = $driverItem->count+1;
            // return false;
        }
    }
    $user_id = Auth::user()->id;
    $start = $request->start;
    $end = $request->end;
    $city_id = $request->warehouse_id;
    $claims = DB::SELECT("SELECT * FROM `drivers_jahiz_claim` WHERE `amount` < '1' AND driverId in(" . implode(",", $driverIds) . ")");
    foreach ($claims as $claim) {
        $id = $claim->id;
        DB::delete("DELETE FROM `drivers_jahiz_claim_reply` WHERE `drivers_jahiz_claim_id` = '$id'");
        DB::delete("DELETE FROM `drivers_jahiz_claim` WHERE id = '$id'");
    }
    

    DB::insert("INSERT INTO `drivers_jahiz_claim_sync_status`(`city_id`, `start_position`, `end_position`, `date`,`created_at`, `created_by`) VALUES ('$city_id', '$start', '$end', NOW(), NOW(), '$user_id')");
    return $makeResponse;

}


function make_table_body($drivers) {
    $response = '';
    $no = $total = 0;
    foreach($drivers as $driver) {
        $remaining = (int)$driver->credit_total - (int)$driver->debit_total;
        
        
        if($remaining <= -50){ 
            $last_settelment_date =DB::select("SELECT * FROM `journal` where driverId=".$driver->driverId." and journal_type_id=6 ORDER BY `journal`.`journal_date` DESC");
            if(count($last_settelment_date)>0){
                $last_settelment_date = $last_settelment_date[0]; 
                $last_settelment_date = $last_settelment_date->journal_date;
            }else{
                $last_settelment_date = "<span>NULL</span>";
            }
            $total += $remaining;
            $response .= "<tr>";
            $response .= "<td>".++$no."</td>";
            $response .= "<td>".$driver->companyName."</td>";
            $response .= "<td>".$driver->warehouseName."</td>";
            $response .= "<td>".$driver->name_en.'</td>';
            $response .= "<td>".$driver->job_id."</td>";
            $response .= "<td>".$driver->fullName.'</td>';
            $response .= "<td>".$driver->mobileNumber."</td>";
            $response .= "<td>".$driver->iqama."</td>";
            $response .= "<td>".$last_settelment_date."</td>";
            $response .= "<td style='text-align: right;'>".$remaining."</td>";
            $response .= '<td>        
            <a id="'.$driver->driverId.'" data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement" title="Statement"> <i class="fa fa-bars"></i> </a>
            </td>';
            $response .= "</tr>";
        }else{  
        }
    }
    return array($response, $total);
}
class ClaimsDeductionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getJournalPeriod($companyId){
        $sql = "SELECT * FROM `lkp_journal_period` where companyId =".$companyId." ";
        $lkp_journal_period = DB::select($sql);
        $html = '';
        foreach($lkp_journal_period as $item){
             
            $html=$html." <option value='".$item->id."'> ".$item->period_from_dt.' - '.$item->period_to_dt." </option>";
        }
         
        return response()->json(['lkp_journal_period'=>$lkp_journal_period,'htmlContent'=>$html]);
    }
    public function index() {
        $user_id = Auth::user()->id;
        // dd($user_id);
        if (Auth::user()->user_type_id <> 1) {
            $lkp_company  = DB::select("SELECT distinct lkp_company.id,lkp_company.companyName FROM `users_privilege` JOIN warehouse ON warehouse.id = users_privilege.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE users_privilege.user_id = '$user_id' AND lkp_company.id <> 6");
        } else {
            $lkp_company  = DB::select("SELECT id, companyName FROM `lkp_company` WHERE lkp_company.id <> 6 AND status = 'active'");
        }
        return view('ClaimsDeduction.index')->with('lkp_company', $lkp_company);
    }

        public function search(Request $request) {
             
            $company_caluse = $warehouse_clause = '';
            $company_id = $request->filter_companyId;
            $warehouse_id = $request->filter_warehouseId;

            if($company_id > 0)
                $company_caluse = " AND lkp_company.id = $company_id";
            if($warehouse_id > 0)
                $warehouse_clause = " AND warehouse.id = $warehouse_id";
                $Period = explode(' - ',$request->filter_dateTo);
                
                $from = $Period[0];
                $request->filter_dateTo = $Period[1];
                $dateElements = explode('-', $request->filter_dateTo);
                if($dateElements[2] >=30 || $dateElements[2] >=31 ){
                    $request->filter_dateTo=$dateElements[0].'-'.$dateElements[1].'-'.cal_days_in_month(CAL_GREGORIAN,$dateElements[1],$dateElements[0]); 
                }  
                 $sql = "SELECT drivers.id as driverId, drivers.mobileNumber, drivers.iqama, drivers.job_id, drivers.fullName,lkp_city.name_en,lkp_company.companyName,warehouse.warehouseName,(
                    SELECT SUM(journal.credit) FROM journal WHERE journal_date BETWEEN '$request->filter_dateFrom' AND '$request->filter_dateTo' AND drivers.id=journal.driverId) AS credit_total,(
                    SELECT SUM(journal.debit) FROM journal WHERE journal_date BETWEEN '$request->filter_dateFrom' AND '$request->filter_dateTo' and drivers.id=journal.driverId) AS debit_total FROM drivers 
                    INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id WHERE 1 = 1 $company_caluse $warehouse_clause";
                //  dd($sql);
            $drivers = DB::select($sql);
            $response = make_table_body($drivers);
             
            echo $response[0];
            exit;
            echo ':::';
            echo number_format($response[1]);
            return $response;
        }
        
        public function index_jahiz() {
            $user_id = Auth::user()->id;
            $cities  = DB::select("SELECT id, warehouseName FROM `warehouse` WHERE companyId = 6");
            return view('ClaimsDeduction.index_jahiz')->with('cities', $cities);
        }
        public function search_jahiz(Request $request) {
            $city_id = $request->filter_cityId;
            $drivers = DB::select("SELECT fullName, warehouseId from drivers WHERE warehouseId = '$city_id' order by id");
            $response = make_buttons($drivers, $city_id);
            return $response;
        }
        public function search_jahiz_drivers(Request $request) {
            $warehouse_id = $request->warehouse_id;
            $start = $request->start;
            $end = $request->end;
            
            $drivers_buttons = DB::select("SELECT fullName, warehouseId, job_id as AMP_ID from drivers WHERE warehouseId = $warehouse_id order by id");
            
            $drivers = DB::select("SELECT id,fullName, warehouseId, job_id as AMP_ID from drivers WHERE warehouseId = $warehouse_id order by id LIMIT $start,100");
            echo $response = getDriverClaims($drivers, $request);
            echo ':::';
            echo $response = make_buttons($drivers_buttons, $warehouse_id);
        }
        
}