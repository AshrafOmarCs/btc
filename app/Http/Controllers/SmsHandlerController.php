<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsHandlerController extends Controller
{
    //
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
