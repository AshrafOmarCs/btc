<?php

namespace App\Http\Controllers;
use App\Company;
use App\Packages_report;
use App\Journal;
use App\Warehouse;
use App\Drivers;
use App\Driver_state;
use App\Driver_type;
use App\City;
use DB;
use App\Temporary;
use Auth;
use Illuminate\Http\Request;

class Import_DA_DailyloadController extends Controller
{
    //
    public function storeFile($request)
    {
        # code...
        if($request->hasfile('myFile')){
            // read file before storing 
            $file = $request->myFile; 
            $safeName = 'uploaded_Dailload_File_at_by_EmpID_'.Auth::user()->id.'_'.date("Y-m-d").'.csv';
            $fileSaved = \Storage::put('public/journal/dailyReports/'.$safeName,\File::get($file)); 

            $checkTemFile = Temporary::where([
                ['path','storage/journal/dailyReports/'.$safeName],
                ['journal_date',date("Y-m-d")]
            ])->get();
            
            if(count($checkTemFile)>0){
                $tep= $checkTemFile->first(); 
            }else{ 
                $tep = new Temporary(); 
            } 
            // $safeName = 'imile_'.date("Y-m-d").'.csv';

             
            if($fileSaved == true){
                $tep->path = 'storage/journal/dailyReports/'.$safeName;
                $tep->journal_date = date("Y-m-d"); 
                $tep->save(); 
                $res = $this->convertCsvToArray($tep->path,$tep->id); 
                return $res; 
            }else{
            }
            // dd($fileSaved);
            // return redirect()->back()->withSuccess('File has been imported successfully ');
        }else{
            dd('noon');
        }
        
    }
    public function validte(Request $request)
    {
        # code...
         
        $filePath = '';
        $cities =  City::all();
        $companies = Company::all();
        $res = $this->storeFile($request); 
        // dd($res[0]);
        if(count($res)>0){
            $filePath = $res[0];
            $filePath = $filePath['filePath'];
            $file_id = $res[0]; 
            $file_id = $file_id['file_id'];
        }
        $res = array_unique(array_column($res, 'hub_name'));
        
        $Result = $this->checkWarehoses($res); 
        if(count($Result['payload'])>0){ 
            // New warehouse exsist 
            $options = array('step'=>'Check-warehouse','processBar'=>33,'filePath'=>$filePath,'file_id'=>$file_id); 
            // dd($options['filePath']);
            return view('dailyload.index',compact('options','cities','companies','Result'));
            // $this->guideSteps('Check-warehouse',$Result);
        }else{
            // checkDA Method 
            // $notes = [
            //     0 =>'12',
            //     1 =>'', 
            // ]; 
            return redirect('Import_DA_Dailyload/Check-DA/'.$file_id);
            return array('status'=>true,'filePath'=>$filePath,'file_id'=>$file_id,'AA'=>'AA');
        } 
        // dd($request->all());
    }
    public function guideSteps($stepNumber,$payload = array())
    {
        # code...
         
        $cities =  City::all();
        $companies = Company::all();
        // dd($cities);
        switch($stepNumber){
            case 'initialize':
                # code...
                $options = array('step'=>'initialize','processBar'=>0); 
                return view('dailyload.index',compact('options','cities','companies'));
                break;
            case 'Check-warehouse':
                # code... 
                 
                break;
            case 'check-DA':
                # code...
                $Driver_states = Driver_state::all();
                $Driver_types = Driver_type::all();
                // dd($Driver_states);
                $options = array('step'=>'check-DA','processBar'=>30,'driver_states'=>$Driver_states,'driverTypes'=>$Driver_types); 
                return view('dailyload.index',compact('options','cities','companies'));
                 
                break;
            case 'preview-recoreds':
                # code...
                $options = array('step'=>'preview-recoreds','processBar'=>95); 
                return view('dailyload.index',compact('options','cities','companies')); 
                
                break;
            default:
                # code...
                break;
        }
        dd($stepNumber);
    }
    public function convertCsvToArray($path,$file_id)
    {
        # code...
         
        $CSVfp = fopen($path, "r");
        $count = 0;
        $recoreds = array();
        if($CSVfp !== FALSE) {
            // setlocale( 'utf8');
        // skip first row in csv
        fgetcsv($CSVfp);
        //   fgetcsv($CSVfp); 
        while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) {
            
            if($data[0] == '' || $data[1] == '' || $data[2] == '' || $data[3] == '' || $data[4] == '' || $data[5] == ''){
                continue; 
            }
            
            $recoreds[] =[
                'hub_name'=>$data[0],
                'amp'=>$data[1],
                'daName'=>$data[2],
                'did'=>$data[3],
                'Reverse_picked'=>$data[4],
                'Total_no_TP'=>$data[3]+$data[3],
                'journal_date'=>$data[6],
                'filePath'=>$path,
                'file_id'=>$file_id
            ];

        }
       
        // dd($recoreds);
        return $recoreds;
        // dd('done');
        fclose($CSVfp);
    }
    }
    function csvToArray($filename = '', $delimiter = ',')
    {
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
    }
    public function checkWarehoses($res)
    {
        # code...
        $payload = array();
        foreach ($res as $k => $item) {
            # code...
            
            $warehouse_id = Warehouse::where([
                ['warehouseName','LIKE',$item],
                ['Saturday','!=','']
            ])->get();  
            if(count($warehouse_id)>0){  
            }else{
                $payload[] =  $item;
            } 
        } 
        $finalReturnedData = ['total_warehouse_qty'=>count($res),'unregistered_warehouse_qty'=>count($payload),'registered_warehoses'=>count($res) - count($payload),'payload'=>$payload];
        // dd($finalReturnedData['total_warehouse_qty']);
        return $finalReturnedData;
        
    }
    public function StoreWarehose(Request $request)
    {
        # code...
        // return response()->json(['request'=>$request->all()],200);
        $warehouse_id = Warehouse::where([
            ['warehouseName','LIKE',$request->warehoseName]
        ])->get();  
        if(count($warehouse_id)>0){ 
            $warehouse_id = $warehouse_id->first();
            $warehouse_id->Saturday =$request->delivery_price;
            $warehouse_id->Sunday =$request->delivery_price;
            $warehouse_id->Monday =$request->delivery_price;
            $warehouse_id->Tuesday =$request->delivery_price;
            $warehouse_id->Wednesday =$request->delivery_price;
            $warehouse_id->Thursday =$request->delivery_price;
            $warehouse_id->Friday =$request->delivery_price;
            $warehouse_id->save();
        }else{
            $response = Warehouse::create([
                'warehouseName'=>$request->warehoseName,
                'companyId'=>$request->companyID,
                'cityId'=>$request->cityID,
                'active_id'=>$request->status_id,
                'Saturday'=>$request->delivery_price,
                'Sunday'=>$request->delivery_price,
                'Monday'=>$request->delivery_price,
                'Tuesday'=>$request->delivery_price,
                'Wednesday'=>$request->delivery_price,
                'Thursday'=>$request->delivery_price,
                'Friday'=>$request->delivery_price
            ]); 
        }  
        
        // dd($response['status']);
        $res = $this->convertCsvToArray($request->filePath,$request->file_id); 
        $res = array_unique(array_column($res, 'hub_name')); 
        $Result = $this->checkWarehoses($res); 
        if(count($Result['payload'])>0){
            $response = array('status'=>true,'currentIndex'=>$request->currentIndex,'filePath'=>$request->filePath,'file_id'=>$request->file_id,'DoneAddingWarehouse'=>false);
            return response()->json($response,200);
        }else{
            $response = array('status'=>true,'currentIndex'=>$request->currentIndex,'filePath'=>$request->filePath,'file_id'=>$request->file_id,'DoneAddingWarehouse'=>true);
            return response()->json($response,200);
        }
    }
    public function getDataByWarehouseName($warehouseName)
    {
        # code...
        $sql = "SELECT warehouse.warehouseName,warehouse.Saturday as 'deliveryPrice',warehouse.id as 'warehouse_id',lkp_city.name_en as 'city_name',lkp_city.id as 'city_id',lkp_company.companyName as 'company_name',warehouse.companyId as 'company_id' FROM `warehouse` JOIN lkp_city on lkp_city.id = warehouse.cityId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE warehouse.warehouseName LIKE '%".$warehouseName."%'";
        $query = DB::select($sql);
        
        if(count($query)>0){
            return $query[0];
        }else{
            return $query;
            return 'error';
        }
        
    }
    public function check_drivers_jquery(Request $request)
    {
        # code... 
        
        $payload = $this->check_drivers($request->filePath,$request->file_id);
        // dd($payload);
        return response()->json($payload,200);
    }
    public function check_drivers($filePath,$file_id)
    {
        # code...
        $res = $this->convertCsvToArray($filePath,$file_id); 
        $unregisted_driver = array();
        $registed_driver = array(); 
        $unpricedWarehouse = array(); 
        $extraData; 
        foreach ($res as $key => $item) {
            $check_driver_if_exsist = Drivers::where(
                [
                    ['job_id',$item['amp']],
                    ['driver_type_id','!=','NULL']
                ]  
            )->get();

            if(count($check_driver_if_exsist)>0){
                $check_driver_if_exsist = $check_driver_if_exsist->first();
                // dd($check_driver_if_exsist->id);
                $item['driver_type'] = $check_driver_if_exsist->driver_type->driver_type;
                $item['driver_id'] = $check_driver_if_exsist->id;
                $item['basic_salary'] = $check_driver_if_exsist->basic_salary;
                $item['dayRate'] = $check_driver_if_exsist->basic_salary/26;
                $item['fuel_per_day'] = $check_driver_if_exsist->fuel_per_day;
                $item['dayRate'] = number_format((float)$item['dayRate'], 2, '.', '');
                $extraData = $this->getDataByWarehouseName($item['hub_name']);
                $item['extraDate'] = $extraData; 
                
                $registed_driver[] = $item;
                $delivery_price = $item['extraDate']; 
                if(!isset($delivery_price->deliveryPrice)){
                    // dd($extraData);
                }else{
                    $item['delivery_price'] = $delivery_price->deliveryPrice;
                    $delivery_price = $delivery_price->deliveryPrice;
                }
                 
                if($item['extraDate']->deliveryPrice == ''){ 
                    $unpricedWarehouse[] = $item['extraDate'];
                }
                
                // return response()->json($unregisted_driver,200);
            }else{
                $check_driver_if_exsist_sec = Drivers::where(
                    [
                        ['job_id',$item['amp']]
                    ]  
                )->get();
                if(count($check_driver_if_exsist_sec)>0){
                    $item['DaStatus'] = true;
                }else{
                    $item['DaStatus'] = false;
                }
                // dd($check_driver_if_exsist);
                // $registed_driver[] = $item;
                
                $extraData = $this->getDataByWarehouseName($item['hub_name']);
                $item['extraDate'] = $extraData;
                
                // dd($item);
                $unregisted_driver[] = $item;  
            }
            // dd($item);
        }  
        // dd($unregisted_driver);
        $final  = array();
        
        foreach ($unpricedWarehouse as $current) {
            if ( ! in_array($current, $final)) {
                $final[] = $current;
            }
        } 
        
        
        // dd($unpricedWarehouse);
        if(count($unregisted_driver)>0 ){ 
            $payload = array('status'=>true,'file_info'=>['filePath'=>$filePath,'file_id'=>$file_id],'registeredDA'=>$registed_driver,'unregisteredDA'=>$unregisted_driver,'quntity'=>['qtyRegisteredDA'=>count($registed_driver),'qtyUnregisteredDA'=>count($unregisted_driver),'totalDA'=>count($registed_driver)+count($unregisted_driver)]);
            // dd($payload);
        }else{
            // dd('this is hate here ');
            $payload = array('status'=>false,'basic_inforamtion'=>['filePath'=>$filePath,'file_id'=>$file_id],'registeredDA'=>$registed_driver,'quntity'=>['qtyRegisteredDA'=>count($registed_driver),'qtyUnregisteredDA'=>'0','totalDA'=>count($registed_driver)]);
        } 
        if(count($final)>0){ 
            return array('status'=>true,'final'=>$final,'payload'=>'');
            // return view('dailyload.warehouse',compact('final'));
        }else{
            // dd($payload);
            return array('status'=>true,'final'=>'','payload'=>$payload);
        } 

    }
    public function Check_DA($file_id)
    {
        # code...
        // dd('Check_DA');

        $Driver_states = Driver_state::all();
        $Driver_types = Driver_type::all();
        $cities =  City::all();
        $companies = Company::all();
        $getTemp = Temporary::where('id',$file_id)->get();
        if(count($getTemp)>0){
            $getTemp = $getTemp->first();
        }
        $payload = $this->check_drivers($getTemp->path,$file_id);
        $payload = $payload['payload'];
        // dd($payload['unregisteredDA']);
        if(isset($payload['unregisteredDA'])){
            $res = array_unique(array_column($payload['unregisteredDA'], 'amp','index')); 
            $fetch = array();
            foreach($res as $k=>$resa){ 
                $fetch[] = $payload['unregisteredDA'][$k]; 
            }
            if(count($fetch)>0){
                $payload['unregisteredDA'] = $fetch;
            } 
        }
        if(isset($payload['unregisteredDA'])){
            $options = array('step'=>'check-DA','processBar'=>66,'driver_states'=>$Driver_states,'driverTypes'=>$Driver_types,'file_id'=>$file_id); 
        }else{
            return redirect('/Import_DA_Dailyload/Check-DA/preview-file/'.$file_id);
        } 
        return view('dailyload.index',compact('options','cities','companies','payload')); 
    }
    function updateWarehouse(Request $request){ 
        $Warehouse = Warehouse::where('id',$request->warehouse_id)->get();
        if(count($Warehouse)>0){
            $Warehouse = $Warehouse->first();
            $Warehouse->Saturday = $request->deliveryPrice;
            $Warehouse->Sunday = $request->deliveryPrice;
            $Warehouse->Monday = $request->deliveryPrice;
            $Warehouse->Tuesday = $request->deliveryPrice;
            $Warehouse->Thursday = $request->deliveryPrice;
            $Warehouse->Friday = $request->deliveryPrice;
            $Warehouse->Wednesday = $request->deliveryPrice;
            $Warehouse->save();
            // dd($Warehouse);
            return response()->json(['status'=>true],200);
        }else{
            return response()->json(['status'=>false],200);
            // return 'empty';
        } 
    }
    public function storeDriver(Request $request)
    {
        # code...
        $payload = $request->payload;
        //  dd($payload['driver_type_id']);
        $salary = floatval($payload['basic_salary']);
        $fuel = floatval($payload['fuel_per_day']);
        if($salary == 0){
            $salary = null;
        }
        if($fuel == 0){
            $fuel = null;
        }
        $check_if_driver_exsist = Drivers::where([
            ['job_id',$payload['job_id']]
        ])->get();
        if(count($check_if_driver_exsist)>0){
            $check_if_driver_exsist = $check_if_driver_exsist->first();
            $check_if_driver_exsist->driver_type_id = $payload['driver_type_id'];
            $check_if_driver_exsist->basic_salary = $salary;
            $check_if_driver_exsist->fuel_per_day = $fuel;
            $check_if_driver_exsist->save();
        }else{
            $res = Drivers::create([
                'job_id'=>$payload['job_id'],
                'fullName'=>$payload['fullName'],
                'warehouseId'=>$payload['warehouseId'],
                'status_id'=>1,
                'driver_type_id'=>$payload['driver_type_id'],
                'basic_salary'=>$salary,
                'fuel_per_day'=>$fuel,
                'created_by_id '=>Auth::user()->id
            ]);
        }
        
        // dd($res);
        return response()->json(['status'=>true],200);
    }
    public function preview_file($file_id)
    {
        # code... 
        // dd('Check-DA/preview-file');
        $getTemp = Temporary::where('id',$file_id)->get();
        if(count($getTemp)>0){
            $getTemp = $getTemp->first(); 
        }
         
        $payload = $this->check_drivers($getTemp->path,$file_id);
        // dd($payload);
        $payload2 = $payload;
        $payload = $payload['payload'];

        $unspacifyDA = array();
        //  dd($payload2);
        if(isset($payload2['payload']['registeredDA'])){
            $options = array('step'=>'preview-recoreds','processBar'=>95); 
           
            foreach($payload2['payload']['registeredDA'] as $k=>$registeredDA){
                 
                $extraDate = $registeredDA['extraDate'];
                $registeredDA['warehouseName'] = $extraDate->warehouseName;
                $registeredDA['city_name'] = $extraDate->city_name;
                $registeredDA['deliveryPrice'] = $extraDate->deliveryPrice; 
                $registeredDA['company_name'] = $extraDate->company_name; 
                $driver = Drivers::where('job_id',$registeredDA['amp'])->get();
                // dd($driver);
                if(count($driver)>0){
                    $driver = $driver->first();
                    $registeredDA['driver_type_id'] = $driver->driver_type_id;
                    $registeredDA['basic_salary'] = $driver->basic_salary;
                    $registeredDA['fuel_per_day'] = $driver->fuel_per_day;
                    if($registeredDA['driver_type_id'] == 1 || $registeredDA['driver_type_id'] == 3){

                    }
                    if($registeredDA['driver_type_id'] == '' || $registeredDA['driver_type_id'] == null){ 
                        
                            $unspacifyDA[] = $registeredDA;  
                         
                    }
                    if($registeredDA['driver_type_id'] == 2 &&  ($registeredDA['dayRate'] == 0 || $registeredDA['dayRate'] == null)){ 
                            $unspacifyDA[] = $registeredDA;  
                    }
                    // return $unspacifyDA; 
                }
                // dd($registeredDA['amp']);
            }
            // dd($unspacifyDA);
            if(count($unspacifyDA)>0){
                // dd($unspacifyDA);
                $returnedData = array($file_id);
                $Driver_types = Driver_type::all();
                
                 
                    $res = array_unique(array_column($unspacifyDA, 'amp','index')); 
                    $fetch = array();
                    foreach($res as $k=>$resa){ 
                        $fetch[] = $unspacifyDA[$k]; 
                    }
                    if(count($fetch)>0){
                        $unspacifyDA = $fetch;
                    } 
                    
                return view('dailyload.drivers',compact('unspacifyDA','returnedData','Driver_types'));

            }else{
                // dd($payload);
                return view('dailyload.index',compact('options','payload')); 
            }
        }else{
            // dd('imre');
            $final = $payload2['final'];
            $returnedData = array($getTemp->path,$file_id);
            // dd($returnedData[0]);
            return view('dailyload.warehouse',compact('final','returnedData'));
        } 
       
    }
    public function storewarehouse(Request $request)
    {
        # code...
        $payload = $this->check_drivers($request->file_path,$request->file_id);
        // dd($payload);
        $final = $payload['final'];
        foreach($request->warehouseDeliverPrice as $k=>$item){ 
            $Warehouse = Warehouse::where('id',$final[$k]->warehouse_id)->get();
            
            if(count($Warehouse)>0){
                $Warehouse = $Warehouse->first();
                $Warehouse->Saturday = $item;
                $Warehouse->Sunday = $item;
                $Warehouse->Monday = $item;
                $Warehouse->Tuesday = $item;
                $Warehouse->Thursday = $item;
                $Warehouse->Friday = $item;
                $Warehouse->Wednesday = $item;
                $Warehouse->save();
            }
        } 
        return redirect('/Import_DA_Dailyload/Check-DA/preview-file/'.$request->file_id);
    }
    public function bulk_drivers(Request $request)
    {
        # code...
        // $driver = Drivers::find();
        // dd($driver);
        $driver_ids = $request->driver_id;
        $driverTypes = $request->driverTypes;
        $basic_Salaries = $request->basic_Salary;
        $fuelPerDays = $request->fuelPerDay;

        foreach ($driver_ids as $key => $driver) {
            # code...
            // requeust contain driverTypes,basic_Salary,driver_id,fuelPerDay,file_id
            $driver = Drivers::where('id',$driver)->first();
            $driver->driver_type_id = $driverTypes[$key] ;
            if($fuelPerDays[$key] == null){ 
            }else{
                $driver->fuel_per_day = $fuelPerDays[$key] ;
            }
            if($basic_Salaries[$key] == null){ 
            }else{
                $driver->basic_salary = $basic_Salaries[$key] ;
            }
            $driver->save(); 
        }

        return redirect('/Import_DA_Dailyload/Check-DA/preview-file/'.$request->file_id);
        
        
    }
    public function store_invoice(Request $request)
    {
        # code... 
        // dd($request->all());
        
        $salaries = $request->netSalary;
        $amps = $request->amp;
        $number_of_tp = $request->totalPack;
        $journal_dates = $request->journal_date; 

        foreach ($request->amp as $key => $AMP) {
            $date = date('Y-m-d', strtotime($request->journal_date[$key])); 
            # code...
            if($AMP == ''){
                
            }else{
                
            } 
            $check_journal = Journal::where([
                ['driverId',$request->DA_ids[$key]],
                ['journal_date',$date],
                ['journal_type_id',6]
            ])->get();
            
            if(count($check_journal)>0){
            }else{
                $journal = Journal::create([
                    'driverId'=>$request->DA_ids[$key],
                    'journal_date'=>$date,
                    'journal_type_id'=>6,
                    'credit'=>$salaries[$key],
                    'createdby_id'=>Auth::user()->id ,
                    'updatedby_id'=>Auth::user()->id 
                ]);

                $check_packages_report = Packages_report::where([
                    ['driverId',$request->DA_ids[$key]],
                    ['pakage_date',$date]
                ])->get(); 
                if(count($check_packages_report)>0){
                    $check_packages_report = $check_packages_report->first();
                    $check_packages_report->No_of_TP = $request->totalPack[$key];
                    $check_packages_report->updatedby_id = Auth::user()->id;
                    $check_packages_report->save();
                }else{
                    $packages_report = Packages_report::create([
                        'driverId'=>$request->DA_ids[$key],
                        'pakage_date'=>$date,
                        'No_of_TP'=>$request->totalPack[$key],
                        'updatedby_id'=>Auth::user()->id,
                        'updated_usertypeid'=>Auth::user()->id,
                        'journal_id'=>$journal->id
                    ]);
                }
            }
            // dd($AMP);
        }
        return redirect('Salary');
    }
    public function bulk_da(Request $request)
    {
        # code...
         
        $AMPS = $request->job_id;
        //  fullName,warehouseId,driverTypes,salary,fuelPerday
        foreach($AMPS as $key=>$AMP){
            $driver = Drivers::where('job_id',$AMP)->get();
            if(count($driver)>0){
                $driver = $driver->first();
                $driver->driver_type_id = $request->driverTypes[$key];
                $driver->fullName = $request->fullName[$key];
                $driver->warehouseId = $request->warehouseId[$key];
                $driver->basic_salary = $request->salary[$key];
                $driver->fuel_per_day = $request->fuelPerday[$key];
                $driver->save(); 
            }else{
                $driver = new Drivers();
                $driver->job_id = $AMP;
                $driver->driver_type_id = $request->driverTypes[$key];
                $driver->fullName = $request->fullName[$key];
                $driver->warehouseId = $request->warehouseId[$key];
                $driver->basic_salary = $request->salary[$key];
                $driver->fuel_per_day = $request->fuelPerday[$key];
                $driver->save(); 
            } 
        }
        return redirect('/Import_DA_Dailyload/Check-DA/'.$request->file_id);

    }
}
