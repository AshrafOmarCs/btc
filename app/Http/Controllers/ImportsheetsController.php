<?php

namespace App\Http\Controllers;
use App\Journal;
use App\Drivers;
use App\Temporary;
use Carbon;
use Auth;
use Illuminate\Http\Request;

class ImportsheetsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('importExcel.index');
    }
    public function store(Request $request){
        
        if($request->hasfile('csv')){
            
            $file = $request->csv;
            $tep = new Temporary();
            $safeName = time().rand(1111,9999).'.csv';
            // dd($safeName);
            $fileSaved = \Storage::put('public/journal/files/'.$safeName,\File::get($file));
            if($fileSaved == true){
                $tep->path = 'storage/journal/files/'.$safeName;
                $tep->save();
                $this->updateFile($tep);
                // return redirect()->back()->with('success', '');
            }else{
                // return redirect()->back()->with('error', 'error while storing file, please contact to support . ');
            }
            // dd($fileSaved);
            return redirect()->back()->withSuccess('File has been imported successfully ');
        }
    }
    public function updateFile($collection){
        //$driver = Drivers::findOrFail(1);
        // return response()->json($driver); 
         
        $CSVfp = fopen('../public/'.$collection->path, "r");
        // dd($CSVfp);
        if($CSVfp !== FALSE) {
          //setlocale( 'utf8');
          fgetcsv($CSVfp);
          while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
            // dd(date("Y-d-m", strtotime($data[7])));
            $recored = new Journal();
            for ($i = 0; $i < count($data); $i++) { // Loop over the data using $i as index pointer
                echo $data[3] ." <br />";
                // retriving Driver's data than check if the Driver if its Exsist or not yet 
                $driver = Drivers::where('job_id',$data[2])->orWhere('fullName', $data[3])->get();
                if(count($driver)>0){
                    $driver =  $driver->first();
                    $driver_id = $driver->id;
                    $warehouseId = $driver->warehouseId;
                    $driver_name = $data[3];
                    $credit = $data[6];
                    $journal_date =$data[7] ;//date("Y-d-m", strtotime($data[7]));
                    $company = $data[8];
                    $debit = 0;
                    $journal_type_id = 0;
                    if($journal_type_id == 0){
                        $journal_type_id = 6;
                    }else{
                        // $journal_type_id = 6;
                    }
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
                }else{
                    dd("didn't found the driver in DB Filter was Job_id :".$data[2]." and FullName :".$data[3]); 
                    // we have to create an account in driver table than retravining the driver id 

                }
            }
        }
        fclose($CSVfp);
        }
    }
    public function storeFile(){
        return 'storeFile';
    }
    public function unLinkFile(){
        return 'unLinkFile';
    }

}
