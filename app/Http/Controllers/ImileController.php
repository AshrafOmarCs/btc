<?php

namespace App\Http\Controllers;
use App\Journal;
use App\Warehouse;
use App\Packages_report;
use Illuminate\Support\Facades\Validator;
use App\Loan;
use App\NoonPack;
use Carbon\Carbon;
use App\Drivers;
use App\Temporary;
use DB;
use Auth;
use Illuminate\Http\Request;

class ImileController extends Controller
{
    //

    public function index(){
     
        //$driver = Drivers::findOrFail(1);
        // return response()->json($driver);
    
        // $path = Storage::path('/storage/journal/files/16468295275119.csv');
    
        $CSVfp = fopen('../public/storage/iMail/imile_04_0000.csv', "r");
        $count = 0;
        fgetcsv($CSVfp);
        if($CSVfp !== FALSE) {
            // setlocale( 'utf8');
          while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
            // dd($data);
           
            // print_r($data);
             // Loop over the data using $i as index pointer
                // echo $data[$i] . " I is equal to ".$i.  ". <br />\n";
                // retriving Driver's data than check if the Driver if its Exsist or not yet 
                  
                // $driver = Drivers::where('job_id',$data[1])->orWhere('fullName', $data[2])->get();
                //  dd($driver);
                $driver = Drivers::where('job_id',$data[0])->get();
                // dd($driver);
                if(count($driver)>0){
                    // prepare variables 
                    $journal_date = '2022-04-26';
                    $driver =  $driver->first();
                    $driver_id = $driver->id;
                    $warehouseId = $driver->warehouseId;
                    $driver_name = $data[1];
                    $credit = floatval($data[3]);
                    // $company = $data[8];
                    $debit = 0;
                    $journal_type_id = 6;
                  
                    $newLoan = new Loan();
                    $newLoan->driverId = $driver_id;
                    $newLoan->journal_date = $journal_date;
                    $newLoan->amount = $credit;
                    $newLoan->status_id = 5;
                    $newLoan->note = 'سلف نص راتب شهر April-26';
                    $newLoan->updated_usertypeid = 3;

                    $newLoan->createdby_id = Auth::user()->id;
                    $newLoan->updatedby_id = Auth::user()->id;
                    $newLoan->save();
                    // dd($newLoan);
                    //check if the the recored is exsist in journal 
                    //     $checkIfRecoredIsExsist = Journal::where([
                    //         ['driverId',$driver_id],
                    //         ['journal_date',$journal_date],
                    //         ['debit',0],
                    //         ['credit',$credit],
                    //         ['journal_type_id',$journal_type_id],
                    //     ])->get();
                        
                    //     if(count($checkIfRecoredIsExsist)>0){
                    //         ++$count;
                    //         // echo $count.' - ';
                    //         // print_r($data); 
                    //         echo '<br>';
                    //         // echo $data[2].', '.$data[13].', '.$driver_name.', priv recored Is Exsist <br>';
                    //     }else{
                    //         $recored = new Journal();
                    //         $recored->driverId = $driver_id;
                    //         $recored->journal_date = $journal_date; //date 
                    //         $recored->debit = '0';
                    //         $recored->credit = $credit;
                    //         $recored->journal_type_id = $journal_type_id;
                    //         $recored->createdby_id = Auth::user()->id;
                    //         $recored->updatedby_id = Auth::user()->id;
                    //         $recored->created_at = date('Y-m-d');
                    //         $recored->updated_at = date('Y-m-d');
                    //         // dd($recored);
                    //         $recored->save();
                    //     }
                    //     //  dd("$checkIfRecoredIsExsist");
                    //     // $recored = new Journal();
                    
                    // }else{
                    //     dd($data);
                    //     // $driver = new Drivers();
                    //     // $driver->warehouseId = 200;
                    //     // $driver->driver_type_id = 1;
                    //     // $driver->fullName = '';
                    //     // $driver->job_id = '';
                    //     // $driver->password = '';
                    //     // $driver->save();
                }else{
                   echo '<br> '.$data.' <br>';
                }
            }
        
              // dd('done');
           fclose($CSVfp);
           }
    }
        public function check()
        {
            # code...
            $users = array();
            $CSVfp = fopen('../public/storage/iMail/MostafaDriversData.csv', "r");
            $count = 0;
            $k = 1;
            if($CSVfp !== FALSE) {
                // setlocale( 'utf8');
                $new_drivers = array();
                fgetcsv($CSVfp);
                while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
                    // dd($data);
                    // print_r($data);
                    // Loop over the data using $i as index pointer
                    // echo $data[$i] . " I is equal to ".$i.  ". <br />\n";
                    // retriving Driver's data than check if the Driver if its Exsist or not yet          
                  
                    
                        // dd($data[0]);
                        $warehouse_id = Warehouse::where('id',$data[0])->get();
                        // dd($warehouse_id);
                        $warehouse_id = $warehouse_id->first();
                        // $warehouse_id = $data[0];
                        $driver = new Drivers();
                        // dd($warehouse_id);
                        // $warehousesids = 

                        $driver->warehouseId = $data[0];
                        $driver->driver_type_id =1;
                        $driver->fullName = $data[2];
                        $driver->job_id = $data[1];
                        $driver->fullName_ar = $warehouse_id->warehouseName;

                        $driver->mobileNumber =$data[5];
                        $driver->iqama = $data[3];
                        $driver->accountNumber = $data[4];
                        $driver->account_owner_iqama = $data[4];


                        $driver->save();
                        // dd($driver);
                        ++$k;
                        $new_drivers[] = $driver;
                        printf(json_encode($driver).'<br> Count #'.$k.'<br><br> ------------------------- <br>');
                   
                    // dd($k);

                    
            }
            
            // dd('done');
            fclose($CSVfp);
            }

        }

        public function uploader()
        {
            return view('Imile.index');
        }
        public function preview(Request $request)
        {
            # code...
            
            // dd($request->all());
            if($request->hasfile('csv')){
                
                $file = $request->csv;
                $tep = new Temporary();
                $safeName = 'imile_'.date("Y-m-d").'.csv';
                // dd($safeName);
                $fileSaved = \Storage::put('public/journal/imile/'.$safeName,\File::get($file));
                if($fileSaved == true){
                    $tep->path = 'storage/journal/imile/'.$safeName;
                    $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) ); // '2022-03-20';;
                    // $tep->journal_period = $request->journal_period; // '2022-03-20';;
                    // dd($tep->path);
                    $tep->save();
                    
                    $res = $this->hamdelTakerSalaries($tep->path);
                    dd($res);
                    // $payload = $this->prepareExcelData($tep->path);
                     
                    $grandTotal = array();
                    foreach($payload as $item){
                        $grandTotal[] = $item[3];
                    }
                    $extra = array('grandTotal'=>array_sum($grandTotal),'qty'=>count($payload),'file_id'=>$tep->id,'tem'=>$tep);
                    return view('Imile.preview',compact('payload','extra'));
                }else{
                  
                }
                // dd($fileSaved);
                // return redirect()->back()->withSuccess('File has been imported successfully ');
            }else{
                dd('noon');
            }
            // dd($request->all());
        }
        public function prepareExcelData($path)
        {
            # code...
            
            $CSVfp = fopen($path, "r");
            $count = 0;
            $recoreds = array();
            if($CSVfp !== FALSE) {
                // setlocale( 'utf8');
            // skip first row in csv
              fgetcsv($CSVfp);
              while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) {
                   // Check opening the file is OK!
                   $warehouse = Warehouse::where('warehouseName','LIKE',$data[0])->get();
                //  dd($data);

                   if(count($warehouse)>0){
                    $warehouse = $warehouse[0];
                    $warehouse_id = $warehouse->id;
                   }else{
                    
                
                    if( $data[0] == 'HBT-Supervisors'){
                      
                        $warehouse_id = 277;
                    }else{
                        // dd($data);
                        return 'Warehouse '.$data[0].' Is not Exsist Yet to BANDER SYSTEM DB';
                    }
                    // $sql = "SELECT * FROM `warehouse` WHERE `warehouseName` LIKE '".$data[0]."%' ";
                    // $response = DB::select($sql);
                    // dd($sql);
                   }
                    //    search by name prepare name 
                //    $item = $data[0];
                   $item = $data[2];
                   $name = strtok($item, '@');

                   $job_id = $data[1];
                   $job_id = strtok($job_id, '@'); 
                   $checkIfRecoredIsExsist = Drivers::where([
                    ['job_id',$job_id] 
                    // ['warehouseId',$warehouse_id]
                   ])->get();
                    //  dd($data);
                   if(count($checkIfRecoredIsExsist)>0){
                        // dd($checkIfRecoredIsExsist);
                        if(count($checkIfRecoredIsExsist)>1){
                            $data[] = 'more then one account';
                        }
                        $checkIfRecoredIsExsist = $checkIfRecoredIsExsist->first();
                        $data[2] = $checkIfRecoredIsExsist->fullName;
                        $data[1] = $checkIfRecoredIsExsist->job_id;
                        //dd($data);
                        $data[] = 'registered';
                        // $data[2] = 'No Name';
                            $recoreds[] = $data; 
                        //  dd($recoreds);
                   }else{
                       if($data[0] == null){
                        //dd('Dr');
                       }else{
                            $data[1] = $job_id;
                            $data[] = 'notRegistered';
                            $recoreds[] = $data;
                             
                       }
                   }
                //    dd($data);
            }
             return $recoreds;
            // dd('done');
            fclose($CSVfp);
        }
}
public function prepareExcelDataImile($path)
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
        $index = 2;
      while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) {
            // dd($data);
            // Check opening the file is OK!
            
            if($data[0] == '' || $data[1] == '' || $data[3] == '' || $data[5] == '' || $data[6] == '' || $data[7] == ''){
                return 'Not allowed Empty Cell, These Cells Are Empty (A'.$index.',B'.$index.',C'.$index.',D'.$index.',E'.$index.',F'.$index.',G'.$index.',H'.$index.')';
                // exit;
            }
            
            $warehouse_id = Warehouse::where('warehouseName','LIKE',$data[0])->get();
             
            if(count($warehouse_id)>0){
                 
            }else{ 
                 
                dd('The warehouse not exsist '.$data[0]);
                // return redirect()->back()->withErrors(['msg' => 'The warehouse not exsist '.$data[0]]); 
                // dd('The warehouse not exsist'.$data[0]);
            } 
            $warehouse_id = $warehouse_id->first();
            $checkIfRecoredIsExsist = Drivers::where([
                ['job_id',$data[1]]
            ])->get(); 
           if(count($checkIfRecoredIsExsist)>0){ 
                 
                if(count($checkIfRecoredIsExsist)>1){
                    $data[] = 'more then one account';
                }
                $checkIfRecoredIsExsist = $checkIfRecoredIsExsist->first();
                $data[1] = $checkIfRecoredIsExsist->job_id;
                $data[2] = $checkIfRecoredIsExsist->fullName; 
                
                 
                if($data[5] == 'salary'){
                    $data[5] = 'Salary';
                }else{
                    $data[5] = 'Per shipment';
                }
                $data[] = 'registered';
                 $recoreds[] = $data;  
                //  dd($recoreds);
           }else{  
               if($data[0] == null){
                 //dd('Dr');
               }else{
                if($data[5] == 'salary'){
                    $data[5] = 'Salary';
                }else{
                    $data[5] = 'Per shipment';
                }
                // dd($warehouse_id);
                // create driver
                $driver = new Drivers();
                $driver->warehouseId = $warehouse_id->id;
                $driver->driver_type_id =1;
                $driver->fullName = $data[2];
                $driver->job_id = $data[1];
                $driver->fullName_ar = $warehouse_id->warehouseName. ' ' .date("Y-m-d");
                $driver->save(); 
                $data[] = 'New DA';
                $recoreds[] = $data;
               }
           }
          $index = $index+1;
    }
    // dd($recoreds);
     return $recoreds;
    // dd('done');
    fclose($CSVfp);
}
}
public function confirmeInvoice(Request $request){

    $tep = Temporary::findOrFail($request->file_id);
    $payload = $this->prepareExcelDataImile($tep->path);
    // dd($payload);
    $tem = Temporary::where('id',$request->file_id)->get();
    $tem = $tem->first();
    // $file = Storage::get($tem->path);
    $file = $tem->path;
    $paramaters = array('file'=>$file,'journal_date'=>$request->journal_date,'journal_period'=>$tem->journal_period);
    // dd($paramaters);
    
    $res = $this->store_imile_method($paramaters); 
    return response()->json(['status'=>true],200);
    
}
public function store_method($array){
        
    $CSVfp = fopen($array['file'], "r");
    $count = 0;
    if($CSVfp !== FALSE) {
        // setlocale( 'utf8');
        fgetcsv($CSVfp);
      while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
    //    dd($data);
         // Loop over the data using $i as index pointer
            // echo $data[$i] . " I is equal to ".$i.  ". <br />\n";
            // retriving Driver's data than check if the Driver if its Exsist or not yet 
            $journal_date = date("Y-m-d", strtotime($array['journal_date']) ); // '2022-03-20';
            $driver = Drivers::where('job_id',$data[1])->get();
            // dd($journal_date);
            if(count($driver)>0){
                // prepare variables 

                // dd($data);
                $driver =  $driver->first();
                $driver_id = $driver->id;
                $warehouseId = $driver->warehouseId;
                $driver_name = $driver->fullName;
                $sum = $data[3];
                $recored = new Journal();
                $recored->driverId = $driver_id;
                $recored->journal_date = '2022-06-30'; //date 
                $recored->debit = '0';
                $recored->credit = $sum*9;
                $recored->journal_type_id = 6;
                $recored->createdby_id = Auth::user()->id;
                $recored->updatedby_id = Auth::user()->id;
                $recored->created_at = date('Y-m-d');
                $recored->updated_at = date('Y-m-d');
                $recored->save();

                // $sql = "SELECT SUM(No_of_TP) as 'No_of_TP'  FROM `packages_report` WHERE `driverId` = ".$driver_id." AND pakage_date BETWEEN '2022-06-02' and '2022-06-30' ORDER BY `packages_report`.`total_out_for_deliver` ASC";
                
                // $response = DB::select($sql);
                // dd($ );
                // $response =$response[0];
                // $response = 0;
                // dd($data[1]);
                // dd($response->No_of_TP);
                // $noon_pack = new NoonPack();
                // $noon_pack->period_id =  12;//intval( $array['journal_period'] );
                // $noon_pack->Location = $data[0];
                // $noon_pack->driverId = $driver_id;
                // $noon_pack->Emp_ID = $data[1];
                // $noon_pack->journal_date = $journal_date;
                // $noon_pack->name = $data[2];
                // $noon_pack->No_of_TouchPoint = $data[3];
                // $noon_pack->Remarks = $data[3]*8;
                // $noon_pack->save();
                // $checkIfpackageRepoert = DB::select("select * from packages_report where driverId =".$driver_id."  and pakage_date = '".$journal_date."'");
                // if(count($checkIfpackageRepoert)>0){
                //     $dateeee = $checkIfpackageRepoert[0]->pakage_date;
                //     $date = new Carbon($dateeee);
                //     // $currentDateTime = Carbon::now();
                //     $newDateTime = $date->subDays(1);
                //     $newDateTime = $newDateTime->toDateString();
                //     $checkIfpackageRepoert = DB::select("select * from packages_report where driverId =".$driver_id."  and pakage_date = '".$newDateTime."'");
                //     if(count($checkIfpackageRepoert)>0){
                //         $newDateTime = $date->subDays(2);
                //         $newDateTime = $newDateTime->toDateString();
                //         $checkIfpackageRepoert = DB::select("select * from packages_report where driverId =".$driver_id."  and pakage_date = '".$newDateTime."'");
                //         if(count($checkIfpackageRepoert)>0){
                //             dd('third condition fill Error line 382');
                //         }else{
                //             $sql_packages_report = "INSERT INTO packages_report (driverId,pakage_date,unit_cost,No_of_TP,updatedby_id,updated_usertypeid,journal_id) values (".$driver_id.",'".$newDateTime."',8,".$data[3].",".Auth::user()->id.",".Auth::user()->id.",".$recored->id.");";
                //         }
                //         // dd($checkIfpackageRepoert);
                //     }else{
                //         $sql_packages_report = "INSERT INTO packages_report (driverId,pakage_date,unit_cost,No_of_TP,updatedby_id,updated_usertypeid,journal_id) values (".$driver_id.",'".$newDateTime."',8,".$data[3].",".Auth::user()->id.",".Auth::user()->id.",".$recored->id.");";
                //     }
                //     // dd($newDateTime);
                // }else{
                //     $sql_packages_report = "INSERT INTO packages_report (driverId,pakage_date,unit_cost,No_of_TP,updatedby_id,updated_usertypeid,journal_id) values (".$driver_id.",'".$journal_date."',8,".$data[3].",".Auth::user()->id.",".Auth::user()->id.",".$recored->id.");";
                // }
                
                // dd($sql_packages_report);
                // $res = DB::select($sql_packages_report);
                // if($data[3] > $response->No_of_TP){
                //     // mothly report greater than 30 pack credite
                //     // insertinto journal credit 
                //     $sum = $data[3] - $response->No_of_TP;
                //     $recored = new Journal();
                //     $recored->driverId = $driver_id;
                //     $recored->journal_date = '2022-06-02'; //date 
                //     $recored->debit = '0';
                //     $recored->credit = $sum*8;
                //     $recored->journal_type_id = 4;
                //     $recored->createdby_id = Auth::user()->id;
                //     $recored->updatedby_id = Auth::user()->id;
                //     $recored->created_at = date('Y-m-d');
                //     $recored->updated_at = date('Y-m-d');
                //     $recored->save();
                // }
                // if($data[3] < $response->No_of_TP){
                //     // insertinto journal dibte
                //     // dd('Sheet '.$data[9] .', DB ' .$response->No_of_TP);
                //     $sum = $response->No_of_TP - $data[3];
                //     // dd($sum*8);
                //     $recored = new Journal();
                //     $recored->driverId = $driver_id;
                //     $recored->journal_date = '2022-06-02'; //date 
                //     $recored->debit = '0';
                //     $recored->credit = -$sum*8;
                //     $recored->journal_type_id = 4;
                //     $recored->createdby_id = Auth::user()->id;
                //     $recored->updatedby_id = Auth::user()->id;
                //     $recored->created_at = date('Y-m-d');
                //     $recored->updated_at = date('Y-m-d');
                //     $recored->save();
                //     // mothly report less than 30 pack credite
                // }
                //  dd("$checkIfRecoredIsExsist");
            }
        
    }
    
    // dd('done');
    fclose($CSVfp);
    }
}

public function confirme(Request $request)
{
    # code...
    // Insert new drivers 
    // insert into journal
    $tep = Temporary::findOrFail($request->file_id);
    // return $tep->path;
       
            $payload = $this->prepareExcelData($tep->path);
            
            foreach($payload as $item){
               
                $driver = Drivers::where('job_id',$item[1])->first();
                //    dd($driver);
                $this->store($driver,$item,$request->all());
            }
           return response()->json(['status'=>true],200);
      
        // dd($fileSaved);
        // return redirect()->back()->withSuccess('File has been imported successfully ');

    // dd($request->all());
}
public function storeDriver(Request $request)
{
    # code...
    // dd($request->all());
    // check if warehouse is exsist and get its id
    $warehouse_id = Warehouse::where('warehouseName','LIKE',$request->warehousename)->get();
    $warehouse_id = $warehouse_id->first();
    // dd($warehouse_id);
    if($warehouse_id != ''){
        $driver = new Drivers();
        $driver->warehouseId = $warehouse_id->id;
        $driver->driver_type_id =1;
        $driver->fullName = $request->driverName;
        $driver->job_id = $request->AMP;
        $driver->fullName_ar = $warehouse_id->warehouseName. ' ' .date("Y-m-d");
        $driver->save();

        $tep = Temporary::findOrFail($request->file_id);
        $payload = $this->prepareExcelData($tep->path);
        $grandTotal = array();
        foreach($payload as $item){
            $grandTotal[] = $item[3];
        }
        
        $extra = array('grandTotal'=>array_sum($grandTotal),'qty'=>count($payload),'file_id'=>$tep->id,'tem'=>$tep);
        return view('Imile.preview',compact('payload','extra'));          
    }else{
        return Redirect('import_excel/General-invoices')->withErrors(['msg' => 'the warehouse " '.$request->warehousename.' " is not inserted ']);
    }
}
public function storeImileDriver(Request $request)
{
    # code...
    // dd($request->all());
    // check if warehouse is exsist and get its id
    $warehouse_id = Warehouse::where('warehouseName','LIKE',$request->warehousename)->get();
    $warehouse_id = $warehouse_id->first();
    // dd($warehouse_id);
    if($warehouse_id != ''){
        $driver = new Drivers();
        $driver->warehouseId = $warehouse_id->id;
        $driver->driver_type_id =1;
        $driver->fullName = $request->driverName;
        $driver->job_id = $request->AMP;
        $driver->fullName_ar = $warehouse_id->warehouseName. ' ' .date("Y-m-d");
        $driver->save();

        $tep = Temporary::findOrFail($request->file_id);
        $payload = $this->prepareExcelDataImile($tep->path);
        $grandTotal = array();
        foreach($payload as $item){
            $grandTotal[] = $item[3];
        }
        $extra = array('grandTotal'=>array_sum($grandTotal),'qty'=>count($payload),'file_id'=>$tep->id,'tem'=>$tep);
        return view('ImileMonthly.preview',compact('payload','extra'));          
    }else{
        return Redirect('i-mile/preview')->withErrors(['msg' => 'the warehouse " '.$request->warehousename.' " is not inserted ']);
    }
}
public function store($driver,$payload,$inputs)
{  
    # code...
    $credit = number_format((float)$payload[3], 2, '.', '');
    // dd($inputs['journal_date']);
    // dd($inputs['journal_date']);
    $checkIfRecoredIsExsist = Journal::where([
        ['driverId',$driver->id],
        ['journal_date',$inputs['journal_date']],
        ['debit',0],
        ['credit',$credit],
        ['journal_type_id',6],
    ])->get();

    if(count($checkIfRecoredIsExsist)>0){
        // dd($checkIfRecoredIsExsist);
    }else{
        // dd('the journalis not exsist');
        $recored = new Journal();
        $recored->driverId = $driver->id;
        $recored->journal_date = $inputs['journal_date']; //date 
        $recored->debit = '0';
        $recored->credit = $credit;
        $recored->journal_type_id = 6;
        $recored->createdby_id = Auth::user()->id;
        $recored->updatedby_id = Auth::user()->id;
        $recored->created_at = date('Y-m-d');
        $recored->updated_at = date('Y-m-d');
        // dd($recored);
        $recored->save();
    }
    }
    public function imileManthly(){
        return view('ImileMonthly.index');
    }
    public function imileManthlyPreview(Request $request ){
         
        if($request->hasfile('csv')){
            $file = $request->csv;
            $tep = new Temporary();
            $safeName = 'imile_'.date("Y-m-d").'.csv';
            // dd($safeName);
            $fileSaved = \Storage::put('public/journal/imile/'.$safeName,\File::get($file));
            if($fileSaved == true){
                $tep->path = 'storage/app/public/journal/imile/'.$safeName;
                $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) ); // '2022-03-20';;
                // $tep->journal_period = $request->journal_period; // '2022-03-20';;
                $tep->save();
                $payload = $this->prepareExcelDataImile($tep->path); 
                // dd($payload);
                $grandTotal = array();
                foreach($payload as $item){
                    // dd($item);
                    $grandTotal[] = $item[3];
                }
                $extra = array('grandTotal'=>array_sum($grandTotal),'qty'=>count($payload),'file_id'=>$tep->id,'tem'=>$tep);
                // dd($payload);
                return view('ImileMonthly.preview',compact('payload','extra'));
            }else{
              
            }
            // dd($fileSaved);
            // return redirect()->back()->withSuccess('File has been imported successfully ');
        }else{
            dd('noon');
        }
    }
    public function validateFile(Request $request)
    {
        # code...
        // dd('Here');
         
        if($request->hasfile('csv')){
            
            // $extension = $extension->extension;
            
            if($request->file('csv')->getClientMimeType() != 'text/csv'){
                return "<span style='color:blue'>* Excel File Extenstion Should Be saved As 'CVS'<span>";
            }
             
            $file = $request->csv;
            $tep = new Temporary();
            $safeName = 'imile_'.date("Y-m-d").'.csv';
            // dd($safeName);
            $fileSaved = \Storage::put('public/journal/imile/'.$safeName,\File::get($file));
            if($fileSaved == true){
                $tep->path = url('storage/journal/imile/'.$safeName);
                $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) ); // '2022-03-20';;
                // $tep->journal_period = $request->journal_period; // '2022-03-20';;
                $tep->save();
                $CSVfp = fopen($tep->path, "r");
                    $count = 0;
                    $recoreds = array();
                    if($CSVfp !== FALSE) {
                    fgetcsv($CSVfp);
                    while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { 
                            
                            $warehouse_id = Warehouse::where('warehouseName','LIKE',$data[0])->get();  
                            if(count($warehouse_id)>0){
                                
                                $payload = $this->prepareExcelDataImile($tep->path); 
                                // dd($payload);
                                if(gettype($payload) == 'string'){
                                    // return $payload;
                                }else{
                                    
                                }
                                $grandTotal = array();
                                foreach($payload as $item){
                                    // dd($payload);
                                    $grandTotal[] = $item[3];
                                }
                                // dd($grandTotal);
                                $extra = array('grandTotal'=>array_sum($grandTotal),'qty'=>count($payload),'file_id'=>$tep->id,'tem'=>$tep);
                                return view('ImileMonthly.preview',compact('payload','extra'));          
                            }else{
                                return redirect()->back()->withErrors(['msg' => 'Please add warehouse ('.$data[0].') ']); 
                                dd('The warehouse <span style="color:green !important">'.$data[0].'</span> is not exsist');
                            }
                    } 
                    fclose($CSVfp);
                }
            }else{
              
            } 
        }else{
            dd('noon');
        }
    }
    public function store_imile_method($array){
        
        $CSVfp = fopen($array['file'], "r");
        $count = 0;
        if($CSVfp !== FALSE) {
            // setlocale( 'utf8');
            fgetcsv($CSVfp);
            $i = 0;
          while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
             
             // Loop over the data using $i as index pointer
                // echo $data[$i] . " I is equal to ".$i.  ". <br />\n";
                // retriving Driver's data than check if the Driver if its Exsist or not yet 
                $journal_date = date("Y-m-d", strtotime($array['journal_date']) ); // '2022-03-20';
                $driver = Drivers::where('job_id',$data[1])->get();
                // dd($journal_date);
                if(count($driver)>0){
                    // dd($data);
                    $payloadPerDay = 0;
                    if($data[4] == '' || $data[4] == 0){
                        $data[4] = 1; 
                    }
                    // dd($data); 
                    $payloadPerDay = floatval($data[7])/floatval($data[4]); 
                    
                    // payload per day =  amount / days ;
                    $driver =  $driver->first();
                    $driver_id = $driver->id;
                    $arrayss = array();
                    $month = date("Y-m",strtotime($journal_date));
                    // check if the recored exsist 
                    $checkJournalPayload =DB::table('journal')->where('journal_date','like','%'.$month.'%')->where('driverId',$driver_id)->get();
                    $total = array();
                    foreach($checkJournalPayload as $recored){
                        $total[] = $recored->credit;
                    }
                    if((int)array_sum($total) == (int)$data[7]){
                    }else{
                        // end of checking recoreds 
                        for($i=1;$i<=$data[4];$i++){ 
                            // insert into journal as a payload  
                            if($i<10){
                                $dateToStore = $month.'-0'.$i;
                            }else{
                                $dateToStore = $month.'-0'.$i;
                            } 
                            $warehouseId = $driver->warehouseId;
                            $driver_name = $driver->fullName; 
                            $arrayss[] = $payloadPerDay; 
                            $recored = new Journal();
                            $recored->driverId = $driver_id;
                            $recored->journal_date = $dateToStore; //date 
                            // $recored->debit = NULL;
                            if($i == 1){
                                // dd($arrayss);
                            }
                            $recored->credit = $payloadPerDay;
                            $recored->journal_type_id = 6;
                            $recored->createdby_id = Auth::user()->id;
                            $recored->updatedby_id = Auth::user()->id;
                            $recored->created_at = date('Y-m-d');
                            $recored->updated_at = date('Y-m-d');
                            $recored->save();
                        } 
                        // handle the date 
                        $packages_report = Packages_report::where([
                            ['driverId',$driver_id],
                            ['pakage_date',$journal_date]
                        ])->get();
                        if(count($packages_report)>0){
                            $packages_report = $packages_report->first();
                            $packages_report->No_of_TP = $packages_report->No_of_TP + $data[3]; 
                            $packages_report->save();
                        }else{
                            $packages_report = Packages_report::create([
                                'driverId'=>$driver_id,
                                'pakage_date'=>$journal_date,
                                'No_of_TP'=>$data[3],
                                'updatedby_id'=>Auth::user()->id,
                                'updated_usertypeid'=>2,
                                'journal_id'=>6
                            ]); 
                        }
                    }
                    
                     


                    // dd($packages_report);
                  
                 










                    // prepare variables  
                    // $driver =  $driver->first();
                    // $driver_id = $driver->id;
                    // $warehouseId = $driver->warehouseId;
                    // $driver_name = $driver->fullName;
                    // $sum = $data[3];
                    // $recored = new Journal();
                    // $recored->driverId = $driver_id;
                    // $recored->journal_date = '2022-06-30'; //date 
                    // $recored->debit = '0';
                    // $recored->credit = $sum*9;
                    // $recored->journal_type_id = 6;
                    // $recored->createdby_id = Auth::user()->id;
                    // $recored->updatedby_id = Auth::user()->id;
                    // $recored->created_at = date('Y-m-d');
                    // $recored->updated_at = date('Y-m-d');
                    // $recored->save();
                    // $sql = "SELECT SUM(No_of_TP) as 'No_of_TP'  FROM `packages_report` WHERE `driverId` = ".$driver_id." AND pakage_date BETWEEN '2022-06-02' and '2022-06-30' ORDER BY `packages_report`.`total_out_for_deliver` ASC";
                    
                    // $response = DB::select($sql);
                    // dd($ );
                    // $response =$response[0];
                    // $response = 0;
                    // dd($data[1]);
                    // dd($response->No_of_TP);
                    // $noon_pack = new NoonPack();
                    // $noon_pack->period_id =  12;//intval( $array['journal_period'] );
                    // $noon_pack->Location = $data[0];
                    // $noon_pack->driverId = $driver_id;
                    // $noon_pack->Emp_ID = $data[1];
                    // $noon_pack->journal_date = $journal_date;
                    // $noon_pack->name = $data[2];
                    // $noon_pack->No_of_TouchPoint = $data[3];
                    // $noon_pack->Remarks = $data[3]*8;
                    // $noon_pack->save();
                    // $checkIfpackageRepoert = DB::select("select * from packages_report where driverId =".$driver_id."  and pakage_date = '".$journal_date."'");
                    // if(count($checkIfpackageRepoert)>0){
                    //     $dateeee = $checkIfpackageRepoert[0]->pakage_date;
                    //     $date = new Carbon($dateeee);
                    //     // $currentDateTime = Carbon::now();
                    //     $newDateTime = $date->subDays(1);
                    //     $newDateTime = $newDateTime->toDateString();
                    //     $checkIfpackageRepoert = DB::select("select * from packages_report where driverId =".$driver_id."  and pakage_date = '".$newDateTime."'");
                    //     if(count($checkIfpackageRepoert)>0){
                    //         $newDateTime = $date->subDays(2);
                    //         $newDateTime = $newDateTime->toDateString();
                    //         $checkIfpackageRepoert = DB::select("select * from packages_report where driverId =".$driver_id."  and pakage_date = '".$newDateTime."'");
                    //         if(count($checkIfpackageRepoert)>0){
                    //             dd('third condition fill Error line 382');
                    //         }else{
                    //             $sql_packages_report = "INSERT INTO packages_report (driverId,pakage_date,unit_cost,No_of_TP,updatedby_id,updated_usertypeid,journal_id) values (".$driver_id.",'".$newDateTime."',8,".$data[3].",".Auth::user()->id.",".Auth::user()->id.",".$recored->id.");";
                    //         }
                    //         // dd($checkIfpackageRepoert);
                    //     }else{
                    //         $sql_packages_report = "INSERT INTO packages_report (driverId,pakage_date,unit_cost,No_of_TP,updatedby_id,updated_usertypeid,journal_id) values (".$driver_id.",'".$newDateTime."',8,".$data[3].",".Auth::user()->id.",".Auth::user()->id.",".$recored->id.");";
                    //     }
                    //     // dd($newDateTime);
                    // }else{
                    //     $sql_packages_report = "INSERT INTO packages_report (driverId,pakage_date,unit_cost,No_of_TP,updatedby_id,updated_usertypeid,journal_id) values (".$driver_id.",'".$journal_date."',8,".$data[3].",".Auth::user()->id.",".Auth::user()->id.",".$recored->id.");";
                    // }
                    
                    // dd($sql_packages_report);
                    // $res = DB::select($sql_packages_report);
                    // if($data[3] > $response->No_of_TP){
                    //     // mothly report greater than 30 pack credite
                    //     // insertinto journal credit 
                    //     $sum = $data[3] - $response->No_of_TP;
                    //     $recored = new Journal();
                    //     $recored->driverId = $driver_id;
                    //     $recored->journal_date = '2022-06-02'; //date 
                    //     $recored->debit = '0';
                    //     $recored->credit = $sum*8;
                    //     $recored->journal_type_id = 4;
                    //     $recored->createdby_id = Auth::user()->id;
                    //     $recored->updatedby_id = Auth::user()->id;
                    //     $recored->created_at = date('Y-m-d');
                    //     $recored->updated_at = date('Y-m-d');
                    //     $recored->save();
                    // }
                    // if($data[3] < $response->No_of_TP){
                    //     // insertinto journal dibte
                    //     // dd('Sheet '.$data[9] .', DB ' .$response->No_of_TP);
                    //     $sum = $response->No_of_TP - $data[3];
                    //     // dd($sum*8);
                    //     $recored = new Journal();
                    //     $recored->driverId = $driver_id;
                    //     $recored->journal_date = '2022-06-02'; //date 
                    //     $recored->debit = '0';
                    //     $recored->credit = -$sum*8;
                    //     $recored->journal_type_id = 4;
                    //     $recored->createdby_id = Auth::user()->id;
                    //     $recored->updatedby_id = Auth::user()->id;
                    //     $recored->created_at = date('Y-m-d');
                    //     $recored->updated_at = date('Y-m-d');
                    //     $recored->save();
                    //     // mothly report less than 30 pack credite
                    // }
                    //  dd("$checkIfRecoredIsExsist");
                // }else{
                //     $warehouse_id = Warehouse::where('warehouseName','LIKE',$data[0])->get();
                //     $warehouse_id = $warehouse_id->first();
                //     // dd($warehouse_id);
                //     if($warehouse_id != ''){
                //         $driver = new Drivers();
                //         $driver->warehouseId = $warehouse_id->id;
                //         $driver->driver_type_id =1;
                //         $driver->fullName = 'NO NAME';
                //         $driver->job_id = $data[1];
                //         $driver->fullName_ar = $warehouse_id->warehouseName. ' ' .date("Y-m-d");
                //         $driver->save(); 
                //         dd($driver->id);
                //     }
                }
            
        }
        
        // dd('done');
        fclose($CSVfp);
        }
    }
    function hamdelTakerSalaries($path){
            
            $CSVfp = fopen($path, "r");
            $count = 0;
            $recoreds = array();
            
            if($CSVfp !== FALSE) {
                // setlocale( 'utf8');
            // skip first row in csv
              fgetcsv($CSVfp);
            $array = [];
              while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) {
                  if($data[4] != ''){
                       $sql = "UPDATE `drivers` SET accountNumber ='".$data[4]."' ,account_owner_iqama=".$data[5]." WHERE job_id='".$data[3]."'";
                        DB::update($sql);
                  }else{
                      $sql = "UPDATE `drivers` SET accountNumber =NULL ,account_owner_iqama=NULL WHERE job_id='".$data[3]."'";
                        DB::update($sql);
                  }
                 
                  
              }
            dd('done');
             return $recoreds;
            // dd('done');
            fclose($CSVfp);
        }
        
        dd('hamdelTakerSalaries');
    }


}
