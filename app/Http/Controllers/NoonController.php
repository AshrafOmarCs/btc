<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Journal;
use App\Warehouse;
use App\NoonPack;
use Storage;
use App\Drivers;
use Carbon;
use App\Temporary;
use DB;
use Auth;

class NoonController extends Controller
{
    //
    public function store_method($array){
        
        $CSVfp = fopen($array['file'], "r");
        $count = 0;
        if($CSVfp !== FALSE) {
            // setlocale( 'utf8');
            fgetcsv($CSVfp);
          while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
           
             // Loop over the data using $i as index pointer
                // echo $data[$i] . " I is equal to ".$i.  ". <br />\n";
                // retriving Driver's data than check if the Driver if its Exsist or not yet 
                $journal_date = date("Y-m-d", strtotime($array['journal_date']) ); // '2022-03-20';
                $driver = Drivers::where('job_id',$data[2])->get();
                
                if(count($driver)>0){
                    // prepare variables 
                    
                    $driver =  $driver->first();
                    $driver_id = $driver->id;
                    $warehouseId = $driver->warehouseId;
                    $driver_name = $data[3];
                    $credit = $data[13];
                    $company = $data[8];
                    $debit = 0;
                    $journal_type_id = 6;
                    $sql = "SELECT SUM(No_of_TP) as 'No_of_TP'  FROM `packages_report` WHERE `driverId` = ".$driver_id." AND pakage_date BETWEEN '2022-05-21' and '2022-06-20' ORDER BY `packages_report`.`total_out_for_deliver` ASC";
                    $response = DB::select($sql);
                    $response =$response[0]; 
                    
                    // dd($data);
                    // dd($response->No_of_TP);
                    $noon_pack = new NoonPack();
                    $noon_pack->period_id =  13;//intval( $array['journal_period'] );
                    $noon_pack->Location = $data[0];
                    $noon_pack->driverId = $driver_id;
                    $noon_pack->UserName = $data[1];
                    $noon_pack->Emp_ID = $data[2];
                    $noon_pack->name = $data[3];
                    $noon_pack->No_of_Delivered = $data[6];
                    $noon_pack->No_of_TouchPoint = $data[9];
                    $noon_pack->No_of_CIR = $data[7];
                    $noon_pack->Remarks = $data[9]*8;
                    $noon_pack->save();
                    
                    if($data[9] > $response->No_of_TP){
                        // mothly report greater than 30 pack credite
                        // insertinto journal credit 
                        $sum = $data[9] - $response->No_of_TP;
                        $recored = new Journal();
                        $recored->driverId = $driver_id;
                        $recored->journal_date = '2022-07-20'; //date 
                        $recored->debit = '0';
                        $recored->credit = $sum*8;
                        $recored->journal_type_id = 4;
                        $recored->createdby_id = Auth::user()->id;
                        $recored->updatedby_id = Auth::user()->id;
                        $recored->created_at = date('Y-m-d');
                        $recored->updated_at = date('Y-m-d');
                        $recored->save();
                    }
                    if($data[9] < $response->No_of_TP){
                        // insertinto journal dibte
                        // dd('Sheet '.$data[9] .', DB ' .$response->No_of_TP);
                        $sum = $response->No_of_TP - $data[9];
                        // dd($sum*8);
                        $recored = new Journal();
                        $recored->driverId = $driver_id;
                        $recored->journal_date = '2022-05-23'; //date 
                        $recored->debit = '0';
                        $recored->credit = -$sum*8;
                        $recored->journal_type_id = 4;
                        $recored->createdby_id = Auth::user()->id;
                        $recored->updatedby_id = Auth::user()->id;
                        $recored->created_at = date('Y-m-d');
                        $recored->updated_at = date('Y-m-d');
                        $recored->save();
                        // mothly report less than 30 pack credite
                    }
                    //  dd("$checkIfRecoredIsExsist");
            }
            
        }
        
        // dd('done');
        fclose($CSVfp);
        }
        }
        public function noonView()
        {
            # code...
            $journal_periods = DB::select("SELECT * FROM `lkp_journal_period` WHERE `period_from_dt` like '2022%'");
            // dd($journal_periods);
            return view('imports.noonIndex',compact('journal_periods'));
        }
        public function store(Request $request)
        {
            # code...
            //  dd($request->all());
            if($request->hasfile('csv')){
                $file = $request->csv;
                $tep = new Temporary();
                $safeName = 'Noon_'.date("Y-m-d").'.csv';
                // dd($safeName);
                $fileSaved = \Storage::put('public/journal/noon/'.$safeName,\File::get($file));
                if($fileSaved == true){
                    $tep->path = 'storage/journal/noon/'.$safeName;
                    $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) ); // '2022-03-20';;
                    $tep->journal_period = $request->journal_period; // '2022-03-20';;
                    $tep->save();
                    $payload = $this->prepareExcelData($tep->path);

                    $grandTotal = array();
                    foreach($payload as $item){
                        $grandTotal[] = $item[13];
                    }
                    //  dd($tep->journal_date);
                    $extra = array('grandTotal'=>array_sum($grandTotal),'qty'=>count($payload),'file_id'=>$tep->id,'tem'=>$tep);
                     
                    return view('alerts.confirm_noon_report',compact('payload','extra'));
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
            // dd($path);
            $CSVfp = fopen($path, "r");
            $count = 0;
            $recoreds = array();
            if($CSVfp !== FALSE) {
                // setlocale( 'utf8');
            // skip first row in csv
              fgetcsv($CSVfp);
              while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) {

                   // Check opening the file is OK!
                   $checkIfRecoredIsExsist = Drivers::where('job_id',$data[2])->get();
                   if(count($checkIfRecoredIsExsist)>0){
                        $data[] = 'registered';
                        $recoreds[] = $data;
                   }else{
                       if($data[0] == null){
                         //dd('Dr');
                       }else{
                        $data[] = 'notRegistered';
                        $recoreds[] = $data;
                       }
                   }
            }
            // dd($recoreds);

             return $recoreds;
            // dd('done');
            fclose($CSVfp);
        }
        }
    public function confirm(Request $request)
    {
        # code...
        // dd($request->all());
        $tem = Temporary::where('id',$request->file_id)->get();
        $tem = $tem->first();
        // $file = Storage::get($tem->path);
        $file = $tem->path;
        $paramaters = array('file'=>$file,'journal_date'=>$tem->journal_date,'journal_period'=>$tem->journal_period);
        
        $this->store_method($paramaters);
        // dd($file);


        return response()->json(['payload'=>$tem,'status'=>true],200);
        
    }
}
