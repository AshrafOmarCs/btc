<?php

namespace App\Http\Controllers;
use App\Drivers;
use App\VehicleCheckup;
use App\RequestModal;
use App\Assign_vehicle;
use App\Vehicle_checkUp_utlitie;
use Illuminate\Http\Request;
use Storage;
use DB;
Use \Carbon\Carbon;

class ApiController extends Controller
{
    // 
    function login(Request $request){
        // return $request->all();
         $msg = '';
        $drivers = Drivers::select('id','job_id','iqama','driver_data')->where('job_id',$request->job_id)->get();
         
        if(count($drivers)>0){
            // drivers exsist
            $drivers = Drivers::select('id','job_id','iqama','driver_data','fullName')->where([
                ['job_id',$request->job_id],
                ['iqama',$request->identity]
                ])->get(); 
            if(count($drivers)>0){
                // driver exsist and iqama is set  
                // check approval status switich case  
                switch($drivers[0]->driver_data){
                    case 'pending':
                        return response()->json(['status'=>true,'payload'=>$drivers[0],'code'=>201],200);
                        break; 
                    case 'applied' or 'approved':
                        return response()->json(['status'=>true,'payload'=>$drivers[0],'code'=>202],200);
                        break;
                }
            }else{
                // suppervisor should complete da data 
                if($request->language == 'en'){
                    $msg = "The Driver Identity/Iqama is not Match/Exsist in our records, Contact your Suppervisor for more information ";
                }
                if($request->language == 'ar'){
                    $msg = "رقم الهوية/الاقامة غير مطابقة لسجلاتنا, الرجاء التحقق والمحاولة مرة اخرى او التواصل مع المشرف االمباشر";
                }
                return response()->json(['status'=>false,'msg'=>$msg,'code'=>204],200);
            }
            // return response()->json(['status'=>true,'payload'=>$drivers,'code'=>202],200); 
            
        }else{
            // Drivers data is not exsist
            if($request->language == 'en'){
                    $msg = "The Driver Identity/Iqama is not Match/Exsist in our records, Contact your Suppervisor for more information ";
                }
                if($request->language == 'ar'){
                    $msg = "رقم المندوب التعريفي غير مطابقة لسجلاتنا, الرجاء التحقق والمحاولة مرة اخرى او التواصل مع المشرف االمباشر";
                } 
            return response()->json(['status'=>false,'msg'=>$msg,'code'=>204],200);
        }
    }
    
    function update_DA(Request $request){ 
        
        if($request->has('identity_file')){
            $base64_str = substr($request->identity_file, strpos($request->identity_file, ",")+1);
            $image = base64_decode($base64_str);
            Storage::put('public/Drivers/Application_Users/'.$request->driver_id.'/'.'identity_file.png', $image); 
        }else{
            dd('identity_file not exsit');
        }  
        if($request->has('drivingLicense_file')){
            $base64_str = substr($request->drivingLicense_file, strpos($request->drivingLicense_file, ",")+1);
            $image = base64_decode($base64_str);
            Storage::put('public/Drivers/Application_Users/'.$request->driver_id.'/'.'driving_licence.png', $image); 
        }else{
            dd('drivingLicense_file not exsit');
        }
        
        $driver = Drivers::where('id',$request->driver_id)->first();
        $driver->identity_version = $request->identity_version;
        
        $driver->email_id = $request->email;
        $driver->absher_no = $request->absher_number;
        $driver->driver_data = 'applied';
        // $driver->identity_file = $request->identity_version;
        // $driver->driving_licence_file = $request->identity_version;
        $driver->save();
        return response()->json(['status'=>true,'payload'=>$driver],200);
    }
    function getDriverVehicles($driver_id){
        $driver_data = DB::select("SELECT assign_vehicles.id,assign_vehicles.status,assign_vehicles.checkup_id,assign_vehicles.rejection_reason,vehicles.id as 'vehicle_id',vehicles.plate,vehicles.otometer,vehicles.color,vehicle_models.name_en as 'vehicle_models',vehicle_models.thumbnail,vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturers' FROM `assign_vehicles` JOIN vehicles ON vehicles.id = assign_vehicles.vehicle_id JOIN vehicle_models ON vehicles.vehicle_model_id = vehicle_models.id JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id WHERE assign_vehicles.status != 'done' and assign_vehicles.driver_id =".$driver_id."");
        //get valid delegation 
         
        $vehicle_utlities;
        if(count($driver_data)>0){
            foreach($driver_data as $items){
                // accessories 
                $vehicle_utlities = DB::select("SELECT vehicle_utilities.id,utilities.id as 'utility_id',utilities.name_en,utilities.category FROM `vehicle_utilities` JOIN utilities on utilities.id = vehicle_utilities.utlity_id WHERE vehicle_utilities.vehicle_id =".$items->vehicle_id."");
                $items->otometer = number_format($items->otometer);
                // dd($vehicle_utlities);
                if(count($vehicle_utlities)>0){
                    foreach($vehicle_utlities as $vehicle_utlity){
                        $vehicle_utlity->category = json_decode($vehicle_utlity->category); 
                    }
                } 
            }
        }else{
            return response()->json(['status'=>false,'payload'=>null,'utlities'=>null],200);
        }
    }
    function delegation_request(Request $request){ 
        
        // convert base64
        // dd($request->all());
        //  return response()->json(['status'=>true,'msg'=>$request->items],200);
        if($request->leftSide == null || $request->rightSide == null || $request->frontSide == null || $request->rearSide == null || $request->drivingWheel == null){
            return response()->json(['status'=>false,'msg'=>'Check-up images are required in order to continue'],200);
        }else{
            // Vehicle check 
            
        $vehicleCheckup = new VehicleCheckup();
            
            
        //     'right_image','rear_image','front_image','drivingWheel_image','otometer','vehicle_id','delegation_type',
        // 'left_image_approve','right_image_approve','front_image_approve','rear_image_approve',
        // 'interior_image_approve','rejection_reason','approved_by'
        
            $ldate = date('Y-m-d');
            $ldate = $ldate.'_DA_ID_'.$request->driver_id; 
            if($request->has('leftSide')){
                $base64_str = substr($request->leftSide, strpos($request->leftSide, ",")+1);
                $image = base64_decode($base64_str);
                Storage::put('public/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'leftSide_'.$ldate.'.png', $image);  
                $vehicleCheckup->left_image = 'storage/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'leftSide_'.$ldate.'.png';
                // return response()->json(['status'=>true,'payload'=>'Request Reference NO is : '],200);
            }else{
                return response()->json(['status'=>false,'msg'=>'The Left-Side is required'],200);
            } 
            
            if($request->has('rightSide')){
                $base64_str = substr($request->rightSide, strpos($request->rightSide, ",")+1);
                $image = base64_decode($base64_str);
                Storage::put('public/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'rightSide_'.$ldate.'.png', $image);  
                $vehicleCheckup->right_image = 'storage/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'rightSide_'.$ldate.'.png';
                // return response()->json(['status'=>true,'payload'=>'Request Reference NO is : '],200);
            }else{
                return response()->json(['status'=>false,'msg'=>'The Right-Side is required'],200);
            }
            
            if($request->has('frontSide')){
                $base64_str = substr($request->frontSide, strpos($request->frontSide, ",")+1);
                $image = base64_decode($base64_str);
                Storage::put('public/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'frontSide_'.$ldate.'.png', $image);  
                $vehicleCheckup->front_image = 'storage/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'frontSide_'.$ldate.'.png'; 
            }else{
                return response()->json(['status'=>false,'msg'=>'The Front-Side is required'],200);
            }
            
            if($request->has('rearSide')){
                $base64_str = substr($request->rearSide, strpos($request->rearSide, ",")+1);
                $image = base64_decode($base64_str);
                Storage::put('public/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'rearSide_'.$ldate.'.png', $image);  
                $vehicleCheckup->rear_image = 'storage/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'rearSide_'.$ldate.'.png';
                // return response()->json(['status'=>true,'payload'=>'Request Reference NO is : '],200);
            }else{
                return response()->json(['status'=>false,'msg'=>'The Rear-Side is required'],200);
            } 
            if($request->has('drivingWheel')){
                $base64_str = substr($request->drivingWheel, strpos($request->drivingWheel, ",")+1);
                $image = base64_decode($base64_str);
                Storage::put('public/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'drivingWheel_'.$ldate.'.png', $image);  
                $vehicleCheckup->drivingWheel_image = 'storage/Vehicles/checkups/'.$request->vehicle_id.'/'.date('Y-m-d').'/'.'drivingWheel_'.$ldate.'.png';
                // return response()->json(['status'=>true,'payload'=>'Request Reference NO is : '],200);
            }else{
                return response()->json(['status'=>false,'msg'=>'The Driving-Wheel is required'],200);
            }
            if($request->has('vehicle_id')){
                $vehicleCheckup->vehicle_id =$request->vehicle_id;
            }
            if($request->has('driver_id')){
                $vehicleCheckup->driver_id =$request->driver_id;
            }
            if($request->has('note')){
                $vehicleCheckup->note =$request->note;
            }
            if($request->has('delegation_type')){
                $vehicleCheckup->delegation_type =$request->delegation_type;
            }
            if($vehicleCheckup->save()){
                foreach($request->items as $item){
                    $Vehicle_checkUp_utlitie = new Vehicle_checkUp_utlitie();
                    $Vehicle_checkUp_utlitie->vehicle_utlity_id = $item['utility_id'];
                    $Vehicle_checkUp_utlitie->vehicle_check_id = $vehicleCheckup->id;
                    $Vehicle_checkUp_utlitie->utlity_condition = $item['value'];
                    $Vehicle_checkUp_utlitie->save();
                }
                // store request 
                $RequestModal = new RequestModal();
                $RequestModal->request_type_id = 1;
                $RequestModal->vehicle_id = $request->vehicle_id;
                $RequestModal->driverId = $request->driver_id;
                $RequestModal->vehicle_check_id = $vehicleCheckup->id;
                $RequestModal->created_by = $request->driver_id;
                $RequestModal->save();
                
                $Assign_vehicle = Assign_vehicle::where([
                        ['driver_id',$request->driver_id],
                        ['vehicle_id',$request->vehicle_id]
                    ])->get();
                
                if(count($Assign_vehicle)>0){
                    $Assign_vehicle = $Assign_vehicle->first();
                    if($Assign_vehicle->status == 'pending' || $Assign_vehicle->status =='rejected'){
                        $Assign_vehicle->status = 'sent';
                        $Assign_vehicle->checkup_id = $vehicleCheckup->id;
                        $Assign_vehicle->save();
                    }else{
                    }
                } 
                return response()->json(['status'=>true,'msg'=>'The request has been Sent '],200);
            }  
        } 
    }
    function getRejectedAccessory($checkup_id){
        $payload = Vehicle_checkUp_utlitie::where([
            ['approval','rejected'],
            ['vehicle_check_id',$checkup_id]
            ])->get();
        // dd($payload);
        $vehicleCheckUp = "SELECT * FROM `vehicle_checks` WHERE `id` =".$checkup_id."  ";
        $vehicleCheckUp = DB::select($vehicleCheckUp);
        
        $vehicle_id = $vehicleCheckUp;
        // dd($vehicle_id[0]->vehicle_id);
        $responsed_array = null;
        // get current status 
        foreach($payload as $k=>$item){
             $sql = "SELECT * FROM `utilities` where id=".$item->vehicle_utlity_id." ";
             $utilities = DB::select($sql); 
             $utilities[0]->category = json_decode($utilities[0]->category); 
             $responsed_array[] = $utilities[0]; 
        } 
        if($responsed_array == null){
            return response()->json(['status'=>true,'payload'=>''],200);
        }else{
            return response()->json(['status'=>true,'payload'=>$responsed_array],200);    
        }
        
        
        
    }
    public function UpdateRejectedAccessories(Request $request){
        $checkup_id = $request->checkup_id; 
        foreach($request->items as $accessory_id=>$items){
             
            $Vehicle_checkUp_utlitie = Vehicle_checkUp_utlitie::where([
                ['vehicle_utlity_id',$accessory_id],
                ['vehicle_check_id',$checkup_id]
                ])->first(); 
            $Vehicle_checkUp_utlitie->rejection_count = $Vehicle_checkUp_utlitie->rejection_count + 1;
            $Vehicle_checkUp_utlitie->utlity_condition = $items['value'];  
            $Vehicle_checkUp_utlitie->save(); 
        }
        // update request table 
        $requests_object = RequestModal::find($checkup_id);
        // dd($requests_object);
        $requests_object->status = 'reupoaded';
        $requests_object->save();
        $Assign_vehicle = Assign_vehicle::where('checkup_id',$checkup_id)->get();
        if(count($Assign_vehicle)>0){
            $Assign_vehicle[0]->status = 'sent'; 
            $Assign_vehicle[0]->save();
        }
        return response()->json(['status'=>true,'payload'=>$Vehicle_checkUp_utlitie],200);
    }
    function getRejectedImages($checkup_id){
        $getRejectedImages = VehicleCheckup::find($checkup_id);
        return response()->json(['status'=>true,'payload'=>$getRejectedImages],200);
        dd($getRejectedImages);
        
    }
    function reuploadCheckUpImages(Request $request){
        return response()->json(['status'=>true,'payload'=>$request->all()],200);
    }
}
