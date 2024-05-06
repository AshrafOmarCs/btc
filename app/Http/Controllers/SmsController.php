<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    //
    function index() {
      $data = array(
        "api_id" => "API85085034640",
        "api_password" =>"As@050987",
        "sms_type" => "T",
        "encoding" => "U",
        "sender_id" => "BTC.sa",
        "phonenumber" => "966539529559",
        "templateid" => "1973",
        "V1"=>"Ashraf",
        "V2"=>"908866"
      );
      $data_string = json_encode($data);
      // dd($data_string);
      $ch =
      curl_init('http://api.smsala.com/api/SendSMS');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
      );
      $result = curl_exec($ch);
      dd($result); 


      // return view("checkSmsApi");

}
public function otp_compare(Request $request){
  dd($request->all());
}
}
