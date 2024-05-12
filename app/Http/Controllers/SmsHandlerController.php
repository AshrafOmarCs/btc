<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Route;
class SmsHandlerController extends Controller
{
    //
    public function sms_request($language,$opration_type){ 
        $msg ;
        $code; 
        if (isset($_GET['phone'])) {
            $RecepientNumber =  $_GET['phone'];
        } else {
            // Fallback behaviour goes here
        }

        // $RecepientNumber = Route::current()->getParameter('phone');
            // $RecepientNumber = $this->route('phone');

        // dd($RecepientNumber);
        if($language == 'ar'){
            $code = $this->generateNumericOTP(6);
            if($opration_type == 'OTP' || $opration_type == 'otp'){
                $msg = "عزيزي موظف شركة بندر, رمز التحقق لتسجيل الدخول هو:".$code.", الرجاء عدم مشاركة الرمز مع احد.";
            }
            if($opration_type == 'transaction' || $opration_type == 'Transactions'){
                $msg = "مرحبا, يمكنك تتبع شحناتك من خلال الرابط التالي: https://www.btclogistic.com, BTC";
            }
        }
        
        if($language == 'en'){
            $code = $this->generateNumericOTP(6);
            if($opration_type == 'OTP' || $opration_type == 'otp'){
                $msg = "Dear BTC Employee, Your verification code is ".$code." for login to BANDER System, Please don't share it.";
            }
            if($opration_type == 'transaction' || $opration_type == 'Transactions'){
                $msg = "Dear BTC valued Customer, You can track your order from the following link: https://www.btclogistic.com, BTC";
            }
        } 
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.yamamah.com/SendSMS',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "Username": "966539529559",
            "Password": "B213213@r",
            "Tagname": "btclogistic",
            "RecepientNumber": "'.$RecepientNumber.'",
            "VariableList": "",
            "ReplacementList": "",
            "Message": "'.$msg.'",
            "SendDateTime": 0,
            "EnableDR": false
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            )); 
        $response = curl_exec($curl);
        
        curl_close($curl);
        // echo $response; 
        $response = json_encode($response);
        if($response == false){
            return response()->json(['status'=>false,"payload"=>$response],200);
        }else{
            return response()->json(['status'=>true,"payload"=>$response],200);
        } 
    }
    public function generateNumericOTP($n) {
        //   dd($n);
        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468"; 
        $result = ""; 
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        } 
        // Return result
        return $result;
    } 
   public function sendSMS(){
        $data = array(
        "api_id" => "API85085034640",
        "api_password" =>"As@050987",
        "sms_type" => "T",
        "encoding" => "U",
        "sender_id" => "BTC.sa",
        "phonenumber" => "966539529559",
        "templateid" => "1973",
        "V1"=>"Ashraf",
        "V2"=>"8897"
      );
      $data_string = json_encode($data); 
      $ch =
      curl_init('https://rest.gateway.sa/api/SendSMS');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
      );
      $result = curl_exec($ch);
      dd($result);   
   }
}
