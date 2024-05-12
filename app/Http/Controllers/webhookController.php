<?php

namespace App\Http\Controllers;
 use App\Webhook;
use Illuminate\Http\Request; 
use DB;
class webhookController extends Controller
{
    public function webhookHandler(Request $request){
    // We have access to the request body here
    // So, you can perform any logic with the data
    // In my own case, I will add the delay function 
     //this will delay the script for 50 seconds
      Webhook::create([
        'json_payload'=>json_encode($request->all())
        ]);
    return response()->json('ok'); 
   }
   function updateVehicles(){
       $sql = "SELECT drivers.*,warehouse.cityId FROM `drivers` JOIN warehouse on warehouse.id = drivers.warehouseId WHERE drivers.vehicle_id is NOT null";
       $results = DB::select($sql);
       foreach($results as $result){ 
           $sql = "UPDATE `vehicles` SET `city_id`=".$result->cityId." WHERE id=".$result->vehicle_id."";
           $response = DB::update($sql); 
       } 
   }
   public function print_webhook(){
       $responses = Webhook::all();
       foreach($responses as $response){
           $response->json_payload = json_decode($response->json_payload);
       }
       dd($responses);
        
   }

}
