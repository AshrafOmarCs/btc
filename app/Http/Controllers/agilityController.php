<?php

namespace App\Http\Controllers;
use App\Temporary;
use App\Journal;
use App\Drivers;

use Auth;

use Illuminate\Http\Request;

class agilityController extends Controller
{
    //
    public function index(){
     
        $CSVfp = fopen('../public/storage/agility/agility.csv', "r");
        $count = 0;
        fgetcsv($CSVfp);
        if($CSVfp !== FALSE) {
            // setlocale( 'utf8');

          while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
            
            
             // Loop over the data using $i as index pointer
                // echo $data[$i] . " I is equal to ".$i.  ". <br />\n";
                // retriving Driver's data than check if the Driver if its Exsist or not yet 
                // dd($data);
                // $driver = Drivers::where('job_id',$data[1])->orWhere('fullName', $data[2])->get();
                //  dd($driver);
                $driver = Drivers::where('job_id',$data[1])->get();
                // dd($driver);
                if(count($driver)>0){
                    
                    // prepare variables 
                    $journal_date = '2022-03-31';
                    $driver =  $driver->first();
                    $driver_id = $driver->id;
                    $warehouseId = $driver->warehouseId;
                    $driver_name = $data[2];
                    $credit = floatval($data[5]);
                    // $company = $data[8];
                    $debit = 0;
                    $journal_type_id = 6;
                    
                    //check if the the recored is exsist in journal 
                    $checkIfRecoredIsExsist = Journal::where([
                        ['driverId',$driver_id],
                        ['journal_date',$journal_date],
                        ['debit',0],
                        ['credit',$credit],
                        ['journal_type_id',$journal_type_id],
                    ])->get();
                    
                    if(count($checkIfRecoredIsExsist)>0){
                        ++$count;
                        // echo $count.' - ';
                        // print_r($data); 
                        echo '<br>';
                        // echo $data[2].', '.$data[13].', '.$driver_name.', priv recored Is Exsist <br>';
                    }else{
                        $recored = new Journal();
                        $recored->driverId = $driver_id;
                        $recored->journal_date = $journal_date; //date 
                        $recored->debit = '0';
                        $recored->credit = $credit;
                        $recored->journal_type_id = $journal_type_id;
                        $recored->createdby_id = Auth::user()->id;
                        $recored->updatedby_id = Auth::user()->id;
                        $recored->created_at = date('Y-m-d');
                        $recored->updated_at = date('Y-m-d');
                        // dd($recored);
                        $recored->save();
                    }
                    //  dd("$checkIfRecoredIsExsist");
                    // $recored = new Journal();
                
                }else{
                    $driver = new Drivers();
                    $driver->warehouseId = $data[0];
                    $driver->driver_type_id = 1;
                    $driver->fullName = $data[2];
                    $driver->job_id = $data[1];
                    // $driver->password = '';
                    // $driver->save();
                    // dd($driver);
                }   
            }
        
              // dd('done');
           fclose($CSVfp);
           }
    }

}
