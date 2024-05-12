<?php

namespace App\Http\Controllers;
use App\Warehouse;
use App\Drivers_jahiz_claim;
use App\Drivers_jahiz_claim_reply;
use Carbon\Carbon;
use App\Drivers;
use DB;
use Illuminate\Http\Request;

class supervisorController extends Controller
{
    public function index()
    {
        # code...store
        $cities = Warehouse::where('companyId',6)->get();
        // dd($cities);
        return view('syinc.index',compact('cities'));
    }
    public function store(Request $request)
    {
        # code...
        
        // dd($request->warehouse_id);
        $url = $request->URL;
        $Cookie = $request->Cookie;
        $warehouse_id = $request->warehouse_id;
        // $url = json_decode($url, true);
        // dd($warehouse_id);
        return $this->retive($url,$Cookie,$warehouse_id);
    }
    
    public function retive($url,$Cookie,$warehouse_id){
        $extra= array("active_da_qty"=>0,"da_total"=>"","percentage"=>"");
        
        // dd($extra['active_da_qty']);
        $return_payload = "
                <tr>
                    <th colspan='3' style='background-color:#ffe3e3'>Active Drivers Qty: <span id='total_active_da'></span> out of <span id='total_das'></span> is Active  </th>
                    <th colspan='2' style='background-color:#ffe3e3'><span id='percentage'></span> is Active </th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Driver</th>
                    <th>AMP_ID</th>
                    <th>Registration status</th>
                    <th>Jahiz status</th> 
                </tr> "; 
        $response = json_decode($url, true);
        // dd($response);
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => $url,
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'GET',
        // CURLOPT_HTTPHEADER => array(
        //     $Cookie
        //   ),
        // ));
        // $response = curl_exec($curl);
        // print_r($response);
        // exit;
        // curl_close($curl);
        // $response = json_decode($response, true);
        
        
        $payload = $response;
       
         $status = '';
        foreach($payload as $count=>$driver){
            
            if($driver['status'] == 1){
                $extra['active_da_qty'] = $extra['active_da_qty'] + 1;
                $status = "<span style='color:green'>Active</span>";
            }else{
                $status = "<span style='color:red'>Inactive</span>";
            }
            
            $iteem = $payload[1];
            // dd($this->slug($iteem['name']));
            $registration_status = ""; 
            // dd($driver['id']);
            $drivers = Drivers::where('job_id',$driver['id'])->get();
            // dd($drivers);
            if(count($drivers)>0){
                $drivers[0]->warehouseId = $warehouse_id;
                $drivers[0]->save();
                $registration_status = "<span style='color:blue'>Registered</span>";
                // echo $driver['name'].' is Exsist <br>';
            }else{
                $registration_status = "<span style='color:orange'>New Driver</span> ";
                // dd($driver);
                // the driver is not registered in Bander Database
                $status;
                if($driver['status'] == true){
                    $status = 1;
                }else{
                    $status = 5;
                }
                $iqamaNo = (int) filter_var($driver['username'], FILTER_SANITIZE_NUMBER_INT);
                 
                if($driver['mobile'] == 'deactivated'){
                    $newDriver = Drivers::create([
                    'warehouseId'=>$warehouse_id,
                    'fullName'=>$driver['name'],
                    // 'mobileNumber'=>'000000000',
                    'iqama'=>$iqamaNo,
                    'job_id'=>$driver['id'],
                    'status_id'=>$status,
                    'under_sopnsorship_id'=>2
                    ]);
                }else{
                    if(!isset($driver['name'])){
                        $driver['name'] = 'No Name'; 
                    }
                    $newDriver = Drivers::create([
                        'warehouseId'=>$warehouse_id,
                        'fullName'=>$driver['name'],
                        'mobileNumber'=>$driver['mobile'],
                        'iqama'=>$iqamaNo,
                        'job_id'=>$driver['id'],
                        'status_id'=>$status,
                        'under_sopnsorship_id'=>2
                    ]);
                } 
            }
                if(isset($driver['name']) ){  
                }else{
                    $driver['name'] = 'No Name';
                }
                $return_payload= $return_payload."  
                <tr>
                    <td style='border: solid 1px grey; text-align: center;'>".++$count."</td>
                    <td style='border: solid 1px grey; text-align: center;'>".$driver['name']."</td>
                    <td style='border: solid 1px grey; text-align: center;'>".$driver['id']."</td>
                    <td style='border: solid 1px grey; text-align: center;'>".$registration_status."</td>
                    <td style='border: solid 1px grey; text-align: center;'>".$status."</td>
                </tr>"; 
                $extra['da_total'] = $count;
        }
        // (value/total value)×100%
        $extra['percentage'] = round(($extra['active_da_qty']/$extra['da_total'])*100,2);
        
        // dd($extra);
        
            
        return view('syinc.syin_drivers',compact('return_payload','extra'));
    }
    public function syicJahizClaims(){
        // call getDrivers method
        $drivers = $this->getDrivers(204);  
        dd($drivers);
        // foreach($drivers as $driver){
        //     if($driver['AMP_ID'] == '41888'){
        //         dd($driver);
        //     }
        // }
        // dd($drivers);
        //paginate drivers 100 per request
        //loop drivers  
        $this->getDriverClaims($drivers);
        // dd($drivers);
        // call checkJahizClaims 
    }
    public function getDrivers($BrachID){
        $driversAfterSyinc = array();
        $drivers = Drivers::where([
                ['warehouseId',$BrachID]
            ])->get();
        $tem = '';
         $html_code = "
            <table>
                <tr >
                    <th  style='border: 1px solid #fce3a4;'>Driver Name</th>
                    <th  style='border: 1px solid #fce3a4;'>Driver AMP</th>
                    <th  style='border: 1px solid #fce3a4;'>Driver Status</th>
                    <th  style='border: 1px solid #fce3a4;'>clearance amount</th>
                    <th  style='border: 1px solid #fce3a4;'> Note </th>
                </tr>
            
            ";
        foreach($drivers as $i=>$driver){
            $status = '';
            if($driver->status_id == 2 ){
                $status = 'اجازة';
            }
            if($driver->status_id == 3 ){
                $status = 'فصل';
            }
            if($driver->status_id == 4 ){
                $status = 'استقال';
            }
            if($driver->status_id == 5 ){
                $status = 'On Hold';
            }
            if($driver->status_id == 6 ){
                $status = 'المستودع خاطى';
            }
            $tem = "<tr>
                <td style='border: 1px solid #fce3a4;'>".$driver->fullName."</td>
                 <td  style='border: 1px solid #fce3a4;'>".$driver->job_id."</td> 
                 <td  style='border: 1px solid #fce3a4;'>".$status."</td> 
                 <td  style='border: 1px solid #fce3a4;'><span style='color:red'>0.00</span> SAR</td> 
                 <td  style='border: 1px solid #fce3a4;'> </td> 
            </tr>";
             $html_code = $html_code .' '.$tem;
             
             $tem = '';
             
        }
        $html_code = $html_code." 
            </table>
            ";
        //     echo($html_code);
        // exit;
        // prepare Drivers table 
        if(count($drivers)>0){
            foreach($drivers as $driver){
                
                $tem = [
                    'AMP_ID'=>$driver->job_id,
                    'status'=>'pending',  // pending ,synced 
                    'count'=>0  ,  //defualt is zero
                    'claimAmount'=>null,
                    'btc_id'=>$driver->id
                    ];
                $driversAfterSyinc[] = $tem;
            }
            return $driversAfterSyinc;
        }else{
            return 0;
        }
    }
    public function getDriverClaims($payload){
        // dd($payload);
        // this function require live cookie 
        $Cookie = "Cookie:JSESSIONID=w-QTdxjP0VjLiaRDMlfZ4Lra1UWKSpa2Y_4Hn6c4.ip-172-31-26-48; cf_clearance=gLmRtGv.KzbuKl3YkqGtP1p2Hyy1GCFMHuhvk89ru2E-1688991430-0-160; _cfuvid=sVQOu7czsjvS3c93V0QLCSM.oYQltFB.A_ovUJe1MaI-1688991436292-0-604800000; __cf_bm=i37GgjKsLh_IGLwe7Qci2EwPMvcgB3liw391R5uIbwE-1688992894-0-AYX2dvJwyjXjq8zv/uSvaPec2mvXM893Aaa9Zed9P7DZV9lZHZRHw0K6OeR2mTQkojL1u4uCVc2UoU36wZYiT4w=; AWSALB=jPs5wLewYaTNlA5dV7sSYdhcLOzQORIrjxbti4pr3IfEDl3ApXYXQ9IIHz1IPHHsniIzHgMQ0/YYo6C3I88v5aZAtPQOC6jlGkv060qzYv6NwFbmGnoW81cbRfZ5E4U+fI2dQIm+FEu61NisYFz58F4HMjqUPHMZAXvC/+SnHoCmu9XIk+fn7Zyc2hZfvA==; AWSALBCORS=jPs5wLewYaTNlA5dV7sSYdhcLOzQORIrjxbti4pr3IfEDl3ApXYXQ9IIHz1IPHHsniIzHgMQ0/YYo6C3I88v5aZAtPQOC6jlGkv060qzYv6NwFbmGnoW81cbRfZ5E4U+fI2dQIm+FEu61NisYFz58F4HMjqUPHMZAXvC/+SnHoCmu9XIk+fn7Zyc2hZfvA==";
        // dd($payload);
        $clims = array();
        for($i=200;$i<=300;$i++){
            $driverItem = $payload[$i];
            try{
                $curl = curl_init();
                $driver_id = $driverItem['AMP_ID'];
                // $driver_id = 190134;
                $totalAmounts = array();
                // dd($driver_id);
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://saned.io/payment/RetrievePayment?sEcho=2&iColumns=33&sColumns=%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C&iDisplayStart=0&iDisplayLength=3000&mDataProp_0=&sSearch_0=&bRegex_0=false&bSearchable_0=true&mDataProp_1=dispatchId&sSearch_1=&bRegex_1=false&bSearchable_1=true&mDataProp_2=referenceId&sSearch_2=&bRegex_2=false&bSearchable_2=true&mDataProp_3=driverId&sSearch_3='.$driver_id.'&bRegex_3=false&bSearchable_3=true&mDataProp_4=driverUserName&sSearch_4=&bRegex_4=false&bSearchable_4=true&mDataProp_5=driverName&sSearch_5=&bRegex_5=false&bSearchable_5=true&mDataProp_6=collectionAmount&sSearch_6=&bRegex_6=false&bSearchable_6=true&mDataProp_7=distance&sSearch_7=&bRegex_7=false&bSearchable_7=true&mDataProp_8=price&sSearch_8=&bRegex_8=false&bSearchable_8=true&mDataProp_9=driverDebitAmount&sSearch_9=&bRegex_9=false&bSearchable_9=true&mDataProp_10=driverCreditAmount&sSearch_10=&bRegex_10=false&bSearchable_10=true&mDataProp_11=isFreeOrder&sSearch_11=&bRegex_11=false&bSearchable_11=true&mDataProp_12=dispatchTime&sSearch_12=&bRegex_12=false&bSearchable_12=true&mDataProp_13=subscriber&sSearch_13=&bRegex_13=false&bSearchable_13=true&mDataProp_14=driverPaidOrganization&sSearch_14=&bRegex_14=false&bSearchable_14=true&mDataProp_15=driverPaidOrganizationDate&sSearch_15=&bRegex_15=false&bSearchable_15=true&mDataProp_16=organizationSettled&sSearch_16=&bRegex_16=false&bSearchable_16=true&mDataProp_17=organizationSettledDate&sSearch_17=&bRegex_17=false&bSearchable_17=true&mDataProp_18=driverSettled&sSearch_18=false&bRegex_18=false&bSearchable_18=true&mDataProp_19=driverSettledDate&sSearch_19=&bRegex_19=false&bSearchable_19=true&mDataProp_20=organization&sSearch_20=&bRegex_20=false&bSearchable_20=true&mDataProp_21=paymentId&sSearch_21=&bRegex_21=false&bSearchable_21=true&mDataProp_22=totalCollectionAmount&sSearch_22=&bRegex_22=false&bSearchable_22=true&mDataProp_23=totalDriverDebitOrgAmount&sSearch_23=&bRegex_23=false&bSearchable_23=true&mDataProp_24=totalDriverCreditAmount&sSearch_24=&bRegex_24=false&bSearchable_24=true&mDataProp_25=totalDeliveryPrice&sSearch_25=&bRegex_25=false&bSearchable_25=true&mDataProp_26=totalDriverCreditTipsAmount&sSearch_26=&bRegex_26=false&bSearchable_26=true&mDataProp_27=netAmount&sSearch_27=&bRegex_27=false&bSearchable_27=true&mDataProp_28=totalFreeOrders&sSearch_28=&bRegex_28=false&bSearchable_28=true&mDataProp_29=totalFreeOrdersAmount&sSearch_29=&bRegex_29=false&bSearchable_29=true&mDataProp_30=totalDriverDebitAmount&sSearch_30=&bRegex_30=false&bSearchable_30=true&mDataProp_31=manualDispatchCount&sSearch_31=&bRegex_31=false&bSearchable_31=true&mDataProp_32=viewedCount&sSearch_32=&bRegex_32=false&bSearchable_32=true&sSearch=&bRegex=false&bulkEditMethod=&bulkAction=&settledDate=false&_=1688993431738',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    $Cookie
                  ),
                ));
    
                $response = curl_exec($curl);
        
                curl_close($curl);
                $response = json_decode($response, true);
                 
                if($response['iTotalRecords'] == 0){
                    $sql = "SELECT drivers_jahiz_claim.* FROM `drivers_jahiz_claim` JOIN drivers ON drivers.id = drivers_jahiz_claim.driverId WHERE drivers.job_id = '".$driver_id."'";
                    $driver_response = DB::select($sql);
                    echo $i . '- Driver '.$driverItem['AMP_ID'].', Saned Amount: 0.00 <br>' ;
                    if(count($driver_response)>0){ 
                        DB::update("UPDATE `drivers_jahiz_claim` SET`amount`=0 WHERE id =".$driver_response[0]->id." ");
                    }else{
                        continue;
                    }
                    
                }else{
                $jsonResponse = $response['aaData'];
                // dd($jsonResponse);
                // print_r($jsonResponse);
                // exit;
                // $deiver_id ;
                foreach($jsonResponse as $driver){
                    // dd($jsonResponse);
                    $amount = $driver['collectionAmount'];
                    $price =  $driver['price'];
                    $credit =  $driver['driverCreditAmount'];
                    $freeOrders =  $driver['isFreeOrder'];
                    $debit =  $driver['driverDebitAmount'];
                    $total = $amount-$price-$credit-$freeOrders+$debit;
                    $totalAmounts[] = $total;
                    
                } 
                $totalAmount = array_sum($totalAmounts); 
                echo $i . '- Driver '.$driverItem['AMP_ID'].', Saned Amount: '.$totalAmount.'<br>' ;
                if($totalAmount >0 ){
                    $driver_ress = DB::select("SELECT * FROM `drivers` WHERE `job_id` LIKE '".$driver_id."'");
                    
                    $claims = DB::select("SELECT * FROM `drivers_jahiz_claim` WHERE driverId =".$driver_ress[0]->id."");
                    if(count($claims)>0){
                        // claim is exsit  
                        DB::update("UPDATE `drivers_jahiz_claim` SET `amount`= ".$totalAmount." WHERE `id` =".$claims[0]->id." ");
                        if($claims[0]->amount == $totalAmount){
                        }else{
                            $msg = "Amount Updated from ".$claims[0]->amount." To $totalAmount";
                            $sql = "SELECT * FROM `drivers_jahiz_claim_reply` WHERE `drivers_jahiz_claim_id` = ".$claims[0]->id."  and claim_status_id=18 ORDER BY `drivers_jahiz_claim_reply`.`id` DESC";
                            $claims_repy_res = DB::select($sql);
                            if(count($claims_repy_res)>0){ 
                                DB::update("UPDATE `drivers_jahiz_claim_reply` SET `reply_txt`='".$msg."' where id=".$claims_repy_res[0]->id." ");
                            }else{
                               DB::insert("INSERT INTO `drivers_jahiz_claim_reply`(`drivers_jahiz_claim_id`, `reply_txt`, `claim_status_id`, `created_by_id`) VALUES (".$claims[0]->id.",'".$msg."',18,2)"); 
                            } 
                        }
                    }else{
                        // Create new claim 
                        $date = Carbon::now()->toDateString();
                        DB::insert("INSERT INTO `drivers_jahiz_claim`(`driverId`, `amount`, `claim_dt`,`created_by_id`, `updated_by_id`) VALUES (".$driver_ress[0]->id.",".$totalAmount.",'".$date."',2,2)"); 
                    }
                } else{
                    
                }
                
                
                
                $totalAmounts = null;
                // dd($totalAmount);
                $driverItem['claimAmount'] = $totalAmount;
                
                // $this->checkClaims($totalAmount,$driverItem['btc_id']);
                // dd($totalAmount);
                }

                // dd($driverItem);
            } catch (Throwable $e) {
                // dd('error');
                $driverItem['count'] = $driverItem['count']+1;
                // return false;
            }
        }
        // dd($payload);
    }
    public function checkClaims($amount,$driver_id){
        dd($amount.$driver_id);
        // Global Vars
        $driverPrivClaims = Drivers_jahiz_claim::where('driverId',$driver_id)->get();
        dd($driverPrivClaims);
        $date = Carbon::now()->toDateString();
        
                if(count($driverPrivClaims)>0){
                    $driverPrivClaims = $driverPrivClaims->first();
                    // insert new amount 
                    $num = floatval($driverPrivClaims->amount);
                    $num2 = floatval($amount);
                    $result = $num - $num2;
                     
                    // echo floatval($driverPrivClaims->amount). ' - ' .floatval($amount). ' = '. $result .', <br>' ;
                    $msg = '';
                     
                   
                        
                        //  check if the amount and driver is in DB ;
                        $checkDriversCliams = Drivers_jahiz_claim::where([
                            ['driverId',$driver_id],
                            ['amount',$amount]
                            ])->get();
                        if(count($checkDriversCliams)>0){
                            $checkDriversCliams = $checkDriversCliams->first();
                            $msg = 'تم تحديث المبلغ الى  '.$amount;
                        }else{
                            $msg = 'تم تحديث السجل - المبلغ يساوي مبلغ جاهز';
                        }
                    
                 
                    $driverPrivClaims->amount = $amount;
                    $driverPrivClaims->updated_by_id = 2;
                    $driverPrivClaims->updated_at = Carbon::now()->timestamp;
                    $driverPrivClaims->save();
                    //  dd($driverPrivClaims->id);
                     // insert the comment 
                     $check_if_replyExsist = Drivers_jahiz_claim_reply::where([
                         ['drivers_jahiz_claim_id',$driverPrivClaims->id],
                         ['claim_status_id',18],
                         ['updated_at', 'like', '%' . $date . '%']
                         ])->get();
                        //  dd(count($check_if_replyExsist));
                         
                         if(count($check_if_replyExsist)>0){
                             
                         }else{
                            //  $newReply = Drivers_jahiz_claim_reply::create([
                            //      'drivers_jahiz_claim_id'=>$driverPrivClaims->id,
                            //      'reply_txt'=>$msg,
                            //      'claim_status_id'=>18,
                            //      'created_by_id'=>2,
                            //  ]);
                         }
                     
                     
                    // dd($newReply);
                }else{
                    $driverPrivClaims = $driverPrivClaims->first();
                    // check if the amount > 0 or < 0 
                    if($amount > 0 ){
                        $insertedDrivers_jahiz_claim = Drivers_jahiz_claim::create([
                            'driverId'=>$driver_id,
                            'amount'=>$amount,
                            'created_by_id'=>2,
                            'updated_by_id'=>2
                            ]);
                        $msg = 'تمت الاضافة';
                        // dd($insertedDrivers_jahiz_claim);
                        // $newReply = Drivers_jahiz_claim_reply::create([
                        //      'drivers_jahiz_claim_id'=>$insertedDrivers_jahiz_claim->id,
                        //      'reply_txt'=>$msg,
                        //      'claim_status_id'=>18,
                        //      'created_by_id'=>2,
                        //  ]);
                        
                        // The amout ! equal zero and driver has no claims 
                        // Insert new claim 
                    }else{
                        // the amount equal zero or less and the driver has no Claims yet 
                    }
                }
    }
    public function exprt_clearance_to_excel(){
        $drivers = $this->getDrivers(201);  
        $this->getDriverClaimsToExcel($drivers); 
    }
    
     public function getDriverClaimsToExcel($payload){
        
        $drivers_summery_to_excels = array();
        $Cookie = "cookie: _cfuvid=hdR6zediwJu5TthCUw8eioM53inAcUWM2JblBRAjdXM-1680080649942-0-604800000; __cf_bm=XjBxv_6ngA0t6bYyNl3U7xcnB2SCXXIVmEZGuNxlRR4-1680161964-0-AeXvsZHQjO0b9yj9QAViuZMhkPxnHHueeq+i6cRlBiooEmpCpmNzDqn4ui0CYftXd55ou+LGgcZW28O8rc571iQ=; JSESSIONID=3g_pq2IM-xksDDHTwRAbB9aTSLovsYOZ5ZuFVAyz.ip-172-31-26-48; AWSALB=8gJEzzVLIynKwYkHg7csnUJs7wvIPbBEscNJAt+lIXQQmxURtRzEMpB+hjOOaNo4FUgOEPp0nFqGfWoiLboF/Gk+OVsrdR/Pd0LOW20B4jLIdtjwv0F6gFBXFBUCLKlw/ilE3gaO5KdsuWtdcTExt0x0XW16hfy0n5NNlrtB5XR5AXUg2ee15kW95MbE5A==; AWSALBCORS=8gJEzzVLIynKwYkHg7csnUJs7wvIPbBEscNJAt+lIXQQmxURtRzEMpB+hjOOaNo4FUgOEPp0nFqGfWoiLboF/Gk+OVsrdR/Pd0LOW20B4jLIdtjwv0F6gFBXFBUCLKlw/ilE3gaO5KdsuWtdcTExt0x0XW16hfy0n5NNlrtB5XR5AXUg2ee15kW95MbE5A==";
        
        $clims = array();
        for($i=1600;$i<=1700;$i++){
            $driverItem = $payload[$i];
            try{
                $curl = curl_init();
                $driver_id = $driverItem['AMP_ID'];
                // $driver_id = 182018;
                $totalAmounts = array();
                // dd($driver_id);
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://www.saned.io/payment/RetrievePayment?sEcho=2&iColumns=33&sColumns=,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,&iDisplayStart=0&iDisplayLength=3000&mDataProp_0=&sSearch_0=&bRegex_0=false&bSearchable_0=true&mDataProp_1=dispatchId&sSearch_1=&bRegex_1=false&bSearchable_1=true&mDataProp_2=referenceId&sSearch_2=&bRegex_2=false&bSearchable_2=true&mDataProp_3=driverId&sSearch_3='.$driver_id.'&bRegex_3=false&bSearchable_3=true&mDataProp_4=driverUserName&sSearch_4=&bRegex_4=false&bSearchable_4=true&mDataProp_5=driverName&sSearch_5=&bRegex_5=false&bSearchable_5=true&mDataProp_6=collectionAmount&sSearch_6=&bRegex_6=false&bSearchable_6=true&mDataProp_7=distance&sSearch_7=&bRegex_7=false&bSearchable_7=true&mDataProp_8=price&sSearch_8=&bRegex_8=false&bSearchable_8=true&mDataProp_9=driverDebitAmount&sSearch_9=&bRegex_9=false&bSearchable_9=true&mDataProp_10=driverCreditAmount&sSearch_10=&bRegex_10=false&bSearchable_10=true&mDataProp_11=isFreeOrder&sSearch_11=&bRegex_11=false&bSearchable_11=true&mDataProp_12=dispatchTime&sSearch_12=&bRegex_12=false&bSearchable_12=true&mDataProp_13=subscriber&sSearch_13=&bRegex_13=false&bSearchable_13=true&mDataProp_14=driverPaidOrganization&sSearch_14=&bRegex_14=false&bSearchable_14=true&mDataProp_15=driverPaidOrganizationDate&sSearch_15=&bRegex_15=false&bSearchable_15=true&mDataProp_16=organizationSettled&sSearch_16=&bRegex_16=false&bSearchable_16=true&mDataProp_17=organizationSettledDate&sSearch_17=&bRegex_17=false&bSearchable_17=true&mDataProp_18=driverSettled&sSearch_18=false&bRegex_18=false&bSearchable_18=true&mDataProp_19=driverSettledDate&sSearch_19=&bRegex_19=false&bSearchable_19=true&mDataProp_20=organization&sSearch_20=&bRegex_20=false&bSearchable_20=true&mDataProp_21=paymentId&sSearch_21=&bRegex_21=false&bSearchable_21=true&mDataProp_22=totalCollectionAmount&sSearch_22=&bRegex_22=false&bSearchable_22=true&mDataProp_23=totalDriverDebitOrgAmount&sSearch_23=&bRegex_23=false&bSearchable_23=true&mDataProp_24=totalDriverCreditAmount&sSearch_24=&bRegex_24=false&bSearchable_24=true&mDataProp_25=totalDeliveryPrice&sSearch_25=&bRegex_25=false&bSearchable_25=true&mDataProp_26=totalDriverCreditTipsAmount&sSearch_26=&bRegex_26=false&bSearchable_26=true&mDataProp_27=netAmount&sSearch_27=&bRegex_27=false&bSearchable_27=true&mDataProp_28=totalFreeOrders&sSearch_28=&bRegex_28=false&bSearchable_28=true&mDataProp_29=totalFreeOrdersAmount&sSearch_29=&bRegex_29=false&bSearchable_29=true&mDataProp_30=totalDriverDebitAmount&sSearch_30=&bRegex_30=false&bSearchable_30=true&mDataProp_31=manualDispatchCount&sSearch_31=&bRegex_31=false&bSearchable_31=true&mDataProp_32=viewedCount&sSearch_32=&bRegex_32=false&bSearchable_32=true&sSearch=&bRegex=false&bulkEditMethod=&bulkAction=&settledDate=false&_=1680162181681',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    $Cookie
                  ),
                ));
    
                $response = curl_exec($curl);
                
                curl_close($curl);
                $response = json_decode($response, true);
                // dd($response);
                $jsonResponse = $response['aaData'];
                // dd($jsonResponse);
                // print_r($jsonResponse);
                // exit;
                // $deiver_id ;
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
                
                echo $i . '- Driver '.$driverItem['AMP_ID'].', Saned Amount: '.$totalAmount.'<br>' ;
                $totalAmounts = null;
                // dd($totalAmount);
                $driverItem['claimAmount'] = $totalAmount;
                // $this->checkClaims($totalAmount,$driverItem['btc_id']);
                
                // dd($driverItem);
            } catch (Throwable $e) {
                $driverItem['count'] = $driverItem['count']+1;
                // return false;
            }
        }
        // dd($payload);
    }
    
}
