<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Vehicle;
use App\Temporary;
use App\VehicleCheckup;
use Illuminate\Http\Request;


class VehiclesController extends Controller
{
    //
    public function index()
    {
        # code...
         
        $utilities = "SELECT * FROM `utilities`";
        $utilities = DB::select($utilities);
        $sql = "SELECT vehicle_models.name_en as 'vehicle_model',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer',vehicles.plate,vehicles.checkup_id,vehicles.id as 'vehicle_id',vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en as 'vehicle_opreator' FROM `vehicles` 
                JOIN vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
                JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
                JOIN lkp_city ON lkp_city.id = vehicles.city_id
                JOIN vehicle_opreators ON vehicle_opreators.id = vehicles.vehicle_opreater_id";
        $payload = DB::select($sql);
        // dd($payload);
        foreach ($payload as $key => $item) {
            # code...
            $item->CheckUpStatus = ''; 
            $query = "SELECT vehicle_utilities.id as 'vehicles_urility_id',vehicle_utilities.vehicle_id,vehicle_utilities.utlity_condition,utilities.name_en FROM `vehicle_utilities` JOIN utilities on utilities.id = vehicle_utilities.utlity_id WHERE vehicle_utilities.vehicle_id =".$item->vehicle_id." ";
            $query = DB::select($query);
            $html =''; 
            if(count($query)>0){
                foreach($query as $item2){ 
                    if(!empty($item2->name_en)){
                        $html = $html." <li>".$item2->name_en."| <span style='color: #0017ff;font-weight: bold;'>".$item2->utlity_condition."</span></li>";
                    } 
                }
                $html = $html. ' <button class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"  onclick="editAccessories('.$key.')">Edit <i class="fa fa-pencil"></i> </button>'; 
                $item->vehicle_utilities = $query; 
                $item->vehicle_utilities_html = $html;  
            }else{
                $html = $html. ' <button class="btnaction btn menu-icon vd_bd-blue vd_blue" onclick="addAccessories('.$key.')">Add Accessories </button>'; 
                $item->vehicle_utilities = NULL; 
                $item->vehicle_utilities_html = $html;
            }  
            if($item->checkup_id == ''){
                $item->images = '';
            }else{
                $sql = "SELECT vehicle_checks.*,users.name as 'uploadedBy' FROM `vehicle_checks` JOIN users ON users.id = vehicle_checks.created_by WHERE vehicle_id =".$item->vehicle_id." ORDER BY `vehicle_checks`.`created_at` DESC ";
                $sql = DB::select($sql); 
                
                if($sql[0]->created_by_type == 'suppervisor'){
                    $suppervisor = DB::select("select * from users where id=".$sql[0]->created_by."");
                    if(count($suppervisor)>0){ 
                        $suppervisor =  $suppervisor[0]->name.'<br> <span style="font-size: 10px; font-weight: bold;"> (Suppervisor) <span>'; 
                        $sql[0]->uploadedBy = $suppervisor;
                    } 
                }else{
                    $driver = "SELECT * FROM `drivers` where id =".$sql[0]->created_by." ";
                    $driver = DB::select($driver); 
                    if(count($driver)>0){
                        $driver =  'DA: '.$driver[0]->fullName; 
                        $sql[0]->uploadedBy = $driver;
                    }
                }
                if($sql[0]->approved_by != ''){
                    $approvedBy = DB::select("select * from users where id =".$sql[0]->approved_by." ");
                    if(count($approvedBy)>0){
                        $sql[0]->ApprovedBy = 'BTC-S: '.$approvedBy[0]->name; 
                    }else{
                        $sql[0]->ApprovedBy = 'Pending';
                    }
                }else{
                    $sql[0]->ApprovedBy = 'Pending';
                }
                $sql[0]->created_by;
                $item->images = $sql[0]; 
            }
        } 
        // $vehicle = Vehicle::where('','')->get(); 
        return view('vehicles.index',compact('payload','utilities'));
    }
    public function utilities(Request $request)
    {
        # code...
        dd($request->all());
        // get all utlities and v.utlities 
        $payload = array();
         
        $vUtilities = "SELECT `utlity_id` FROM `vehicle_utilities` WHERE `vehicle_id`=".$request->vehcile_id." ";
        
        $vUtilities = DB::select($vUtilities);
        $whereNotIn = '';
        
        foreach ($vUtilities as $key => $value) {
            # code...
            if($key == 0){
                $whereNotIn =  ''.$value->utlity_id;
            }else{
                $whereNotIn =  $whereNotIn.','.$value->utlity_id;
            } 
        }
        $utlity = "SELECT * FROM `utilities` WHERE id NOT IN (".$whereNotIn.")";
        $utlity = DB::select($utlity);
        $categories = json_decode($utlity[0]->category);
        foreach($utlity as $utlity12){ 
            $payload[] = [
                'name'=>$utlity12->name,
                'name_en'=>$utlity12->name_en,
                'conditions'=>json_decode($utlity12->category),
                'selected'=>NULL
            ];
        }
        // 
        // dd($payload);
        
        $sighnedUtlity = "SELECT vehicle_utilities.id,vehicle_utilities.utlity_id,vehicle_utilities.vehicle_id,utilities.name_en,utilities.name,vehicle_utilities.utlity_condition,utilities.category FROM `vehicle_utilities` JOIN utilities ON utilities.id = vehicle_utilities.utlity_id WHERE vehicle_utilities.vehicle_id  in (".$whereNotIn.")";
        $sighnedUtlity = DB::select($sighnedUtlity);  
        foreach ($sighnedUtlity as $key => $sighned) {
            # code... 
            
            $payload[] = [
                'name'=>$sighned->name,
                'name_en'=>$sighned->name_en,
                'conditions'=>json_decode($sighned->category),
                'selected'=>$sighned->utlity_condition
            ];
            
        } 
        $htmls = "";
        dd($payload); 
    }
    public function vaildate_checkup(Request $request)
    {
        # code...
        // dd($request->all());
        $images_array = [
            'front'=>'',
            'rear'=>'',
            'left'=>'',
            'right'=>'',
            'interior'=>'', 
        ];
          
        if(isset($request->left)){
            $images_array['left'] = $this->handleImages($request->left,$request->serialNumber,'left'); 
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle left side Image is Required ']); 
        }
        if(isset($request->right)){
            $images_array['right'] = $this->handleImages($request->right,$request->serialNumber,'right');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Right side Image is Required ']); 
        }
        if(isset($request->rear)){
            $images_array['rear'] = $this->handleImages($request->rear,$request->serialNumber,'rear');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Rear side Image is Required ']); 
        }
        if(isset($request->front)){
            $images_array['front'] = $this->handleImages($request->front,$request->serialNumber,'front');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Front side Image is Required ']); 
        }
        if(isset($request->interior)){
            $images_array['interior'] = $this->handleImages($request->interior,$request->serialNumber,'interior');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Interior Image is Required ']); 
        } 
        
        $Vehicle_checks = VehicleCheckup::create([
            'left_image'=>$images_array['left'],
            'right_image'=>$images_array['right'],
            'rear_image'=>$images_array['rear'],
            'front_image'=>$images_array['front'],
            'drivingWheel_image'=>$images_array['interior'],
            'otometer'=>$request->otometerRead,
            'vehicle_id'=>$request->vehicle_id,
            'delegation_type'=>$request->delegationType,
            'created_by'=>Auth::user()->id,
        ]);
        $vehicle = Vehicle::where('id',$request->vehicle_id)->get();
        $vehicle =$vehicle->first();
        $vehicle->checkup_id = $Vehicle_checks->id;
        $vehicle->save(); 
        return redirect('Vehicles/vehicle-checkup-utilities/'.$Vehicle_checks->id);
    }
    public function handleImages($data,$serialNumber,$side)
    {
        # code... 
            $file = $data; 
            $tep = new Temporary();
            $safeName = 'vehicle_'.$serialNumber.'_'.$side.'_'.date("Y-m-d").'.'.$data->extension();  
            $fileSaved = \Storage::put('public/vehicales/'.$serialNumber.'/'.$safeName,\File::get($file)); 
            if($fileSaved == true){
                $tep->path ='/storage/vehicales/'.$serialNumber.'/'.$safeName;
                $tep->journal_date = date("Y-m-d"); // '2022-03-20';;
                // $tep->journal_period = $request->journal_period; // '2022-03-20';;
                $tep->save(); 
                return $tep->path;
            }else{ 
            }  
    }
    public function vehicle_checkup_utilities($vehicle_id)
    {
        # code... 
        $VehicleCheckup = VehicleCheckup::where('id',$vehicle_id)->get();
        $VehicleCheckup = $VehicleCheckup->first();
        $sql = "SELECT * FROM `utilities`";
        $response = DB::select($sql); 
        $vehicle = "SELECT * FROM `vehicles` WHERE id = ".$VehicleCheckup->vehicle_id."";
        $vehicle = DB::select($vehicle); 
        // dd($vehicle);
        if(count($vehicle)>0){
            $vehicle = $vehicle[0]; 
        }else{
            $vehicle = NULL;
        }
        return view('vehicles.vehicleCheckupUtility',compact('response','vehicle','VehicleCheckup'));
        
    }
    public function ValidateUtlity(Request $request)
    {
        # code...
        // dd($request->vehicle_id);
        if($request->has('VU00')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU00'";
            $utlity = DB::select($utlity);  
            $utlity_id = $utlity[0]->id; 
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00; 
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query); 
            
        }
        if($request->has('VU01')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU01'";
            $utlity = DB::select($utlity);  
            $utlity_id = $utlity[0]->id; 
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00; 
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query); 
        }
        if($request->has('VU02')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU02'";
            $utlity = DB::select($utlity);  
            $utlity_id = $utlity[0]->id; 
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00; 
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query); 
        }
        if($request->has('VU03')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU03'";
            $utlity = DB::select($utlity);  
            $utlity_id = $utlity[0]->id; 
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00; 
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query); 
        }
        if($request->has('VU05')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU05'";
            $utlity = DB::select($utlity);  
            $utlity_id = $utlity[0]->id; 
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00; 
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query); 
        } 
        return redirect('Vehicles');
    }
    public function vehicle_requests()
    {
        # code...
        $sql = "SELECT requests.status,requests.created_at as 'request_issue_date',requests.created_by,request_types.name_en,vehicles.*,vehicle_checks.approved_by,vehicle_models.name_en as 'vName',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer_name',lkp_city.name_en as 'city_name',vehicle_opreators.name_en as 'opreatoers',drivers.fullName FROM `requests` JOIN request_types on request_types.id = requests.request_type_id JOIN vehicles ON vehicles.id = requests.vehicle_id JOIN vehicle_checks on vehicle_checks.id = requests.vehicle_check_id join vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id join lkp_city on lkp_city.id = vehicles.city_id JOIN vehicle_opreators on vehicle_opreators.id = vehicles.vehicle_opreater_id JOIN drivers on drivers.id = requests.vehicle_id";
        $payload = DB::select($sql); 
        return view('vehicles.requestCentral',compact('payload'));
    }
    public function mainpulate_utlities(){
        $payload = DB::select("Select * from vehicles");
        foreach($payload as $k=>$item){
            // dd($item->id);
            $payload_2 = DB::select("SELECT * FROM `utilities`");
            // dd($payload_2);
            foreach($payload_2 as $item2){ 
                // $categories = json_decode($utlity[0]->category);
                $sql = "INSERT INTO `vehicle_utilities`(`vehicle_id`, `utlity_id`, `utlity_condition`, `created_by`) VALUES (".$item->id.",".$item2->id.",'".json_decode($item2->category)[0]."',2)"; 
                $res = DB::insert($sql);
            }
            // get all utlity 
        }
        return $payload;
    }
}
