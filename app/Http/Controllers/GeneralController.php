<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;
use App\Journal;
use App\Exports\UsersExport;
use App\Exports\SalaryExport;
use App\Exports\SanedExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Drivers_saned_settlement;
use App\Drivers_jahiz_clearing;
use App\Drivers;
use Carbon\Carbon;
use DateTime;
use App\Temporary;
use DB;
use Auth;
use Illuminate\Http\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use Illuminate\Support\Facades\Storage;


class GeneralController extends Controller
{
    //
    public function trancaction_history(){
        return 'trancaction_history';
    }
    public function index(){
    
    //$driver = Drivers::findOrFail(1);
    // return response()->json($driver);

    // $path = Storage::path('/storage/journal/files/16468295275119.csv');

    $CSVfp = fopen('../public/storage/journal/files/16468295275119.csv', "r");
      
    if($CSVfp !== FALSE) {
       //setlocale( 'utf8');
      while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
        $recored = new Journal();
       
        for ($i = 0; $i < count($data); $i++) { // Loop over the data using $i as index pointer
            // echo $data[$i] . " I is equal to ".$i.  ". <br />\n";
            // retriving Driver's data than check if the Driver if its Exsist or not yet 
            $driver = Drivers::where('job_id',$data[2])->orWhere('fullName', $data[3])->get();
            if(count($driver)>0){
                $driver =  $driver->first();

                $driver_id = $driver->id;
                $warehouseId = $driver->warehouseId;
                $driver_name = $data[3];
                $credit = $data[6];
                $journal_date = date("Y-d-m", strtotime($data[7]));
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
                $recored->save();

            }else{
                dd("didn't found the driver in DB Filter was Job_id :".$data[2]." and FullName :".$data[3]);
                //we have to create an account in driver table than retravining the driver id 
            }
        }
    }
    
    dd('done');
    fclose($CSVfp);
    }
    }
    public function Transaction(){
        $data = array();
        $data[] = [
            [
                'hash'=>'',
                'warehouse'=>'',
                'job_id'=>'',
                'DriverId'=>'HAILU BEREKET HAILU GEBRU2',
                'id'=>12
            ],[
                'name'=>'Ashraf',
                'id'=>12
            ]
        ];
        dd($data);
        try {
            \DB::transaction(function ($data) {
                // do something
                \DB::transaction(function () use ($data) {
                    $tep = Temporary::create([
                        'psath'=>'Transaction',
                        'status'=>'migrated'
                    ]);
                });
            });
        } catch (\Exception $e) {
            return false;
        }
            
    }
    public function convertDate(){
        $date = '13-Mar 12:00 am';
        $newDate = date("h:i A", strtotime($date));
        dd($newDate);
    }
    public function testQuery()
    {
        # code...
        //get drivers loans from date - to date - distict journal_reqerds on drivers 
        $driver = array();
        // $allDrivers =  
        // $temp;$

        $EfferctedDrivers = "SELECT DISTINCT journal.driverId FROM journal join drivers on journal.driverId = drivers.id join warehouse on drivers.warehouseId = warehouse.id JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE journal_date BETWEEN '2022-02-01' and '2022-02-31' and lkp_company.id = 4";
        $EfferctedDrivers = \DB::select($EfferctedDrivers);
        
        // $eleuc = DB::table('journal')
        // ->join('drivers', 'journal.driverId', '=', 'drivers.id')
        // // ->join('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
        // // ->join('lkp_company', 'lkp_company.id', '=', 'warehouse.companyId')
        // ->where(
        //     ['lkp_company.id',4]
        // )
        // ->orWhereBetween('journal_date',['2022-02-01','2022-02-31'])
        // ->distinct()
        // ->get(['journal.driverId']);
        // dd($eleuc);
        // dd($eleuc);
        // exit;
        foreach($EfferctedDrivers as $EfferctedDriver){
            // getting driverinfo 
            
            $select_driver_data = Drivers::findOrFail($EfferctedDriver->driverId);
            // $jornal_daily_load->driverIdsss = 'ss';
            //  dd($select_driver_data);
            // getting sum debit froms db
            $select_total_driver_loans = "SELECT SUM(journal.debit) as debit FROM journal join drivers on journal.driverId = drivers.id join warehouse on drivers.warehouseId = warehouse.id JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE journal.driverId = ".$EfferctedDriver->driverId." AND journal.journal_type_id = 1 AND journal_date BETWEEN '2022-02-01' and '2022-02-31' and lkp_company.id = 4";
            $select_total_driver_loans = \DB::select($select_total_driver_loans);
            // getting sum credit froms db
            $select_total_driver_salaries = "SELECT SUM(journal.credit) as credit FROM journal join drivers on journal.driverId = drivers.id join warehouse on drivers.warehouseId = warehouse.id JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE journal.driverId = ".$EfferctedDriver->driverId." AND journal.journal_type_id = 6 AND journal_date BETWEEN '2022-02-01' and '2022-02-31' and lkp_company.id = 4";
            $select_total_driver_salaries = \DB::select($select_total_driver_salaries);
            $driver_financial_summary = [
                'debit'=>$select_total_driver_loans[0]->debit,
                'credit'=>$select_total_driver_salaries[0]->credit,
                'driver'=>$select_driver_data->fullName,
                'ID'=>$select_driver_data->job_id,
                'internal_ID'=>$select_driver_data->id
            ];
            dd($driver_financial_summary);
            
        }
        // dd($jornal_daily_loads);
    }
    public function retriveFromSANAD_newDrivers(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://saned.io/retrieveDriverInfo?sEcho=2&iColumns=1000&sColumns=%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C&iDisplayStart=0&iDisplayLength=1000&mDataProp_0=id&sSearch_0=&bRegex_0=false&bSearchable_0=true&mDataProp_1=username&sSearch_1=&bRegex_1=false&bSearchable_1=true&mDataProp_2=organization.name&sSearch_2=&bRegex_2=false&bSearchable_2=true&mDataProp_3=mobile&sSearch_3=&bRegex_3=false&bSearchable_3=true&mDataProp_4=name&sSearch_4=&bRegex_4=false&bSearchable_4=true&mDataProp_5=imei&sSearch_5=&bRegex_5=false&bSearchable_5=true&mDataProp_6=posSerialNumber&sSearch_6=&bRegex_6=false&bSearchable_6=true&mDataProp_7=terminalId&sSearch_7=&bRegex_7=false&bSearchable_7=true&mDataProp_8=online&sSearch_8=&bRegex_8=false&bSearchable_8=true&mDataProp_9=status&sSearch_9=&bRegex_9=false&bSearchable_9=true&mDataProp_10=ceased&sSearch_10=&bRegex_10=false&bSearchable_10=true&mDataProp_11=citcApprovalStatus&sSearch_11=&bRegex_11=false&bSearchable_11=true&mDataProp_12=citcApprovalStatus&sSearch_12=&bRegex_12=false&bSearchable_12=true&mDataProp_13=citcErrorCodes&sSearch_13=&bRegex_13=false&bSearchable_13=true&mDataProp_14=&sSearch_14=&bRegex_14=false&bSearchable_14=true&sSearch=&bRegex=false&_=1647948840679',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'cookie: JSESSIONID=2HHztpp0TMu0vv-acgXTfAJgr7letxBIUWWDq8KS.ip-172-31-26-48; AWSALB=bfLRh9xxzWZMOnI6cZSgyFd07jgAM7hm3f45rTr6tzdk4TuoOiCeoypfNgvd5Ew0P0jFPfn3g7p6mfqcYfhym9MSpPGyCV8laTe1LdeneDgmuPABW5KU9tqMHqjH6IahL7WW3D/aTmM/cJvKX/0piedSWd8V9zErRGH4NbqBJiXmN9tiH1Kfs3XkkAvdcQ==; AWSALBCORS=bfLRh9xxzWZMOnI6cZSgyFd07jgAM7hm3f45rTr6tzdk4TuoOiCeoypfNgvd5Ew0P0jFPfn3g7p6mfqcYfhym9MSpPGyCV8laTe1LdeneDgmuPABW5KU9tqMHqjH6IahL7WW3D/aTmM/cJvKX/0piedSWd8V9zErRGH4NbqBJiXmN9tiH1Kfs3XkkAvdcQ=='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        $payload = $response['aaData'];
          
        foreach($payload as $driver){
            dd($payload);
            $drivers = Drivers::where('job_id',$driver['id'])->get();
            
            if(count($drivers)>0){
                $drivers[0]->warehouseId = 204;
                $drivers[0]->save();
                // echo $driver['name'].' is Exsist <br>';
            }else{
                // dd($driver);
                // the driver is not registered in Bander Database
                $status;
                if($driver['status'] == true){
                    $status = 1;
                }else{
                    $status = 5;
                }
                $iqamaNo = (int) filter_var($driver['username'], FILTER_SANITIZE_NUMBER_INT);
                
                if($driver['mobile'] == 'deactivated'){
                    $newDriver = Drivers::create([
                    'warehouseId'=>204,
                    'fullName'=>$driver['name'],
                    // 'mobileNumber'=>'000000000',
                    'iqama'=>$iqamaNo,
                    'job_id'=>$driver['id'],
                    'status_id'=>$status,
                    'under_sopnsorship_id'=>2
                    ]);
                }else{
                    $newDriver = Drivers::create([
                    'warehouseId'=>204,
                    'fullName'=>$driver['name'],
                    'mobileNumber'=>$driver['mobile'],
                    'iqama'=>$iqamaNo,
                    'job_id'=>$driver['id'],
                    'status_id'=>$status,
                     'under_sopnsorship_id'=>2
                    ]);
                }
                echo ('the driver'.$driver['id'].'  inserted <br>');
            }
             
            // dd($driver['username']);
        }
        // 

        // return json_encode($response);

        // return view('testViews.index',compact('payload'));
        // {
        //     "id": 121932,
        //     "username": "2209526538",
        //     "imei": "fa5acd883f19f460",
        //     "password": "$2b$12$d0cCsR0KpDGwzMH50wL2euE/mTfd45LvnHnBr/MPiVux802Z/1X2m",
        //     "name": "ABDULBASHIR ABDULHALIM JOYAN",
        //     "mobile": "966538472388",
        //     "online": true,
        //     "status": true,
        //     "ceased": false,
        //     "netCollectionAmount": -6736.34,
        //     "organization": {
        //       "id": 20263,
        //       "name": "Bandar Jeddah",
        //       "email": "bandarjeddah@jahez.net",
        //       "address": "Jeddah",
        //       "phone": "966500089004",
        //       "active": true
        //     },
        //     "citcValidated": true,
        //     "citcApprovalStatus": "A"
        //   },
        
    }
    public function sanadStore(Request $request)
    {
        if($request->hasfile('csv')){
            $file = $request->csv;
            $tep = new Temporary();
            $fileExtension = $request->file('csv')->getClientOriginalExtension();
            if($fileExtension == 'csv')
                $safeName = time().rand(1111,9999).'.csv';
            else if($fileExtension == 'xls' || $fileExtension == 'xlsx')
                $safeName = time().rand(1111,9999).'.xlsx';
            $fileSaved = \Storage::put('public/importSANAD/files/'.$safeName,\File::get($file));
            if($fileSaved == true){
                $tep->path = 'storage/importSANAD/files/'.$safeName;
                $tep->save();
                $records = array();
                if($fileExtension == 'csv') {
                    $CSVfp = fopen(url('').'/'.$tep->path, "r");
                    if($CSVfp !== FALSE) {
                        $rows = HelperFunctionsController::readCsvData($CSVfp);
                        foreach($rows as $data) {
                            $driver = Drivers::where('job_id',$data[0])->first();
                            if ($driver !== null) {
                                $warehouseId = $driver->warehouseId;
                                $warehouse = DB::select("SELECT warehouseName from warehouse WHERE id = '$warehouseId'");
                                $date = str_replace('/', '-', $data[11]);
                                $date = date("Y-m-d", strtotime($date));
                                $data[11] = $date;
                                // $data[12] = $data[2]-$data[3]-$data[4]-$data[5]-$data[6]+$data[7]-$data[8]-$data[9];
                                $data[13] = $warehouse[0]->warehouseName;
                                $records[] = $data;
                            } else {
                                return redirect()->back()->with('error', 'Driver with ID('.$data[0].') does not exist');
                                break;
                            }
                        }
                    }
                } else if($fileExtension == 'xls' || $fileExtension == 'xlsx') {
                    $filePath = Storage::disk('public')->path('importSANAD/files/' . $safeName);
                    $records = array();
                    $rows = HelperFunctionsController::readExcelData($filePath, 13);
                    foreach($rows as $data) {
                        $driver = Drivers::where('job_id',$data[0])->first();
                        if ($driver !== null) {
                            $warehouseId = $driver->warehouseId;
                            $warehouse = DB::select("SELECT warehouseName from warehouse WHERE id = '$warehouseId'");
                            $date = str_replace('/', '-', $data[11]);
                            $date = date("Y-m-d", strtotime($date));
                            $data[11] = $date;
                            $data[12] = $data[2]-$data[3]-$data[4]-$data[5]-$data[6]+$data[7]-$data[8]-$data[9];
                            $data[13] = $warehouse[0]->warehouseName;
                            $records[] = $data;
                        } else {
                            return redirect()->back()->with('error', 'Driver with ID('.$data[0].') does not exist');
                            break;
                        }
                    }
                }
                return view('SANED.previewSanad')->with('records', $records)->with('path', $tep->path)->with('fileExtension', $fileExtension);
            } else {
                return redirect()->back()->with('error', 'error while storing file, please contact to support . ');
            }
        }
    }
    public function sanadImport(){
        return view('SANED.importSanad');
    }
    public function updateFile(Request $request)
    {
        $path = $request->path;
        $fileExtension = $request->fileExtension;
        if($fileExtension == 'xls' || $fileExtension == 'xlsx') {
            require_once(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
            $safeName = basename($path);
            $filePath = Storage::disk('public')->path('importSANAD/files/' . $safeName);
            $excelReader = PHPExcel_IOFactory::createReaderForFile($filePath);
            $excelObj = $excelReader->load($filePath);
            $worksheet = $excelObj->getSheet(0);
            $highestRow = $worksheet->getHighestRow();
            $highestRow = $worksheet->getHighestRow();
            for ($row = $highestRow; $row >= 1; $row--) {
                $cellValue = $worksheet->getCell('A' . $row)->getValue(); // Assuming column A contains data
                if (!empty($cellValue)) {
                    $actualHighestRow = $row;
                    break;
                }
            }
            $index = 2;
            for ($row = 2; $row <= $actualHighestRow; ++$row) {
                $data = array();
                $data[] = $worksheet->getCell('A' . $row)->getValue();
                $data[] = $worksheet->getCell('B' . $row)->getValue();
                $data[] = $worksheet->getCell('C' . $row)->getValue();
                $data[] = $worksheet->getCell('D' . $row)->getValue();
                $data[] = $worksheet->getCell('E' . $row)->getValue();
                $data[] = $worksheet->getCell('F' . $row)->getValue();
                $data[] = $worksheet->getCell('G' . $row)->getValue();
                $data[] = $worksheet->getCell('H' . $row)->getValue();
                $data[] = $worksheet->getCell('I' . $row)->getValue();
                $data[] = $worksheet->getCell('J' . $row)->getValue();
                $data[] = $worksheet->getCell('K' . $row)->getValue();
                $data[] = $worksheet->getCell('L' . $row)->getValue();
                $data[] = $worksheet->getCell('M' . $row)->getValue();
                if($data[0] != '') {
                    $date = str_replace('/', '-', $data[11]);
                    $date = date("Y-m-d", strtotime($date));
                    $check_if_recored_exsist = Drivers_saned_settlement::where([
                        ['AMP_ID',$data[0]],
                        ['SettledDate',$date]
                    ])->get();
                    if (count($check_if_recored_exsist) > 0){
                        // dd($check_if_recored_exsist);
                    } else {
                        //check if there is a realtion on drivers_jahiz_clearing table 
                        $oprator ;$amoutAfterModifying;
                        $driver_name = Drivers::where('job_id',$data[0])->first();
                        $data[12] = $data[2]-$data[3]-$data[4]-$data[5]-$data[6]+$data[7]-$data[8]-$data[9];
                        if($data[12] > 0 ){
                            $oprator = 1;
                            $amoutAfterModifying = $data[12];
                        }else{
                             
                            $oprator = 2;
                            $amoutAfterModifying = abs($data[12]);
                        }
                        $banderClearingData = Drivers_jahiz_clearing::where([
                            ['Jahiz_Amount',$amoutAfterModifying],
                            ['Jahiz_Amount_Sign',$oprator],
                            ['driverId',$driver_name->id]
                        ])->get();
                        $drivers_jahiz_clearing_paid_id;

                        $date_string = $data[11];
                        $date_string =  strtotime(str_replace("/", "-", $date_string));
                        
                        $new_date = date("Y-m-d  H:m:s", $date_string);
                         
                        if(count($banderClearingData)>0){
                            
                            $banderClearingData = $banderClearingData->first();
                            $banderClearingData->updated_at = $new_date;
                            $banderClearingData->created_at = $new_date;
                            $banderClearingData->save();
                            $drivers_jahiz_clearing_paid_id = $banderClearingData->id;
                            $recored = Drivers_saned_settlement::create([
                                'AMP_ID'=>$data[0],
                                'DriverName'=>$driver_name->fullName,
                                'CollectionAmount'=>$this->RemoveSpecialChar($data[2]),
                                'DeliveryPrice'=>$this->RemoveSpecialChar($data[3]),
                                'FreeOrderAmount'=>$this->RemoveSpecialChar($data[5]),
                                'DriverCredit'=>$this->RemoveSpecialChar($data[6])+$this->RemoveSpecialChar($data[9]),
                                'DriverDebit'=>$this->RemoveSpecialChar($data[7]),
                                'SettledDate'=> $date,
                                // 'drivers_jahiz_clearing_paid_id'=>$drivers_jahiz_clearing_paid_id,
                                'created_by_id'=>Auth::user()->id,
                            ]);
                        }else{
                            $recored = Drivers_saned_settlement::create([
                                'AMP_ID'=>$data[0],
                                'DriverName'=>$driver_name->fullName,
                                'CollectionAmount'=>$this->RemoveSpecialChar($data[2]),
                                'DeliveryPrice'=>$this->RemoveSpecialChar($data[3]),
                                'FreeOrderAmount'=>$this->RemoveSpecialChar($data[5]),
                                'DriverCredit'=>$this->RemoveSpecialChar($data[6])+$this->RemoveSpecialChar($data[9]),
                                'DriverDebit'=>$this->RemoveSpecialChar($data[7]),
                                'SettledDate'=> $date,
                                // 'NoOfDispatch'=>$data[2],
                                'created_by_id'=>Auth::user()->id,
                            ]);
                        }
                    }
                } else {
                    dd('its empty');
                }
            }
        } else if($fileExtension == 'csv') {
            $CSVfp = fopen(url('').'/'.$path, "r");
            if($CSVfp !== FALSE) {
              fgetcsv($CSVfp);
              while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) { // Check opening the file is OK!
                $recored = new Drivers_saned_settlement();
                for ($i = 0; $i < count($data); $i++) {
                    if($data[0] != '') {
                        $date = str_replace('/', '-', $data[11]);
                        $date = date("Y-m-d", strtotime($date));
                        $check_if_recored_exsist = Drivers_saned_settlement::where([
                            ['AMP_ID',$data[0]],
                            ['SettledDate',$date]
                        ])->get();
                        if(count($check_if_recored_exsist)>0){
                            // dd($check_if_recored_exsist);
                        }else{
                            
                            //check if there is a realtion on drivers_jahiz_clearing table 
                            $oprator ;$amoutAfterModifying;
                            $driver_name = Drivers::where('job_id',$data[0])->first();
                            
                            if($data[12] > 0 ){
                                $oprator = 1;
                                $amoutAfterModifying = $data[12];
                            }else{
                                 
                                $oprator = 2;
                                $amoutAfterModifying = abs($data[12]);
                            }
                             
                            //check if the clearness has done by Jahiz_Amount and Jahiz_Amount_Sign and driverId
                            $banderClearingData = Drivers_jahiz_clearing::where([
                                ['Jahiz_Amount',$amoutAfterModifying],
                                ['Jahiz_Amount_Sign',$oprator],
                                ['driverId',$driver_name->id]
                            ])->get();
                            $drivers_jahiz_clearing_paid_id;
    
                            $date_string = $data[11];
                            $date_string =  strtotime(str_replace("/", "-", $date_string));
                            
                            $new_date = date("Y-m-d  H:m:s", $date_string);
                             
                            if(count($banderClearingData)>0){
                                
                                $banderClearingData = $banderClearingData->first();
                                $banderClearingData->updated_at = $new_date;
                                $banderClearingData->created_at = $new_date;
                                $banderClearingData->save();
                                $drivers_jahiz_clearing_paid_id = $banderClearingData->id;
                                $recored = Drivers_saned_settlement::create([
                                    'AMP_ID'=>$data[0],
                                    'DriverName'=>$driver_name->fullName,
                                    'CollectionAmount'=>$this->RemoveSpecialChar($data[2]),
                                    'DeliveryPrice'=>$this->RemoveSpecialChar($data[3]),
                                    'FreeOrderAmount'=>$this->RemoveSpecialChar($data[5]),
                                    'DriverCredit'=>$this->RemoveSpecialChar($data[6])+$this->RemoveSpecialChar($data[9]),
                                    'DriverDebit'=>$this->RemoveSpecialChar($data[7]),
                                    'SettledDate'=> $date,
                                    // 'drivers_jahiz_clearing_paid_id'=>$drivers_jahiz_clearing_paid_id,
                                    'created_by_id'=>Auth::user()->id,
                                ]);
                            }else{
                                $recored = Drivers_saned_settlement::create([
                                    'AMP_ID'=>$data[0],
                                    'DriverName'=>$driver_name->fullName,
                                    'CollectionAmount'=>$this->RemoveSpecialChar($data[2]),
                                    'DeliveryPrice'=>$this->RemoveSpecialChar($data[3]),
                                    'FreeOrderAmount'=>$this->RemoveSpecialChar($data[5]),
                                    'DriverCredit'=>$this->RemoveSpecialChar($data[6])+$this->RemoveSpecialChar($data[9]),
                                    'DriverDebit'=>$this->RemoveSpecialChar($data[7]),
                                    'SettledDate'=> $date,
                                    // 'NoOfDispatch'=>$data[2],
                                    'created_by_id'=>Auth::user()->id,
                                ]);
                            }
                        }
                    } else {
                        dd('its empty');
                    }
                }
              }
              fclose($CSVfp);
            }
        }
        return redirect('DriversJahiz/import')->with('success', 'Saned Data Imported successfully');
    }
    function RemoveSpecialChar($str) {
    
        // Using str_replace() function
        // to replace the word
        $res = str_replace( array( '\'', '"',
        ',',';', '<', '>' ), '', $str);
        
        // Returning the result
        return $res;
    }
    public function salaries(){
        return Excel::download(new SalaryExport($request->SQL), 'SanadStcPay.xlsx');
    }
    public function getDriverData($driver_id)
    {
        # code...
        $payload = Drivers::where('id',$driver_id)->get();
        if(count($payload)>0){
            $payload = $payload->first();
             
            if($payload->driver_type_id ==''){
                return "Update Driver To Countinue ";
            }else{
                $inputsHtml = "<input type='text' disabled  class='form-control' id='Driver_name1' value='$payload->fullName'><input type='hidden' name='Driver_id' value='$payload->id'><input type='hidden' name='job_id' value='$payload->job_id'><input type='hidden' id='driver_type' value='$payload->driver_type_id'>";
            } 
            return $inputsHtml;  //response()->json(['da_id'=>$payload->id,'job_id'=>$payload->job_id,'da_name'=>$payload->fullName],200);
        }else{
            dd('its not there ');
        }
        
    }
    public function storeDocument(Request $request)
    {
        # code...
        $journal_date = date("Y-d-m"); 
        // dd($request->all());
        
        // $journal_date = $this->checkDate($journal_date,$request->job_id,$request->Driver_id);
        $paylaod = $this->storeJahiz_saned_Document($journal_date,$request);
        
        
        return $paylaod;
        //SettledDate 2021-06-16 
    }
    public function get_date($driverId, $journal_date) {
        $journal_date = DateTime::createFromFormat('Y-d-m', $journal_date);
        $journal_date = $journal_date->format('Y-m-d');
        $journal_date = date('Y-m-d', strtotime("-1 days", strtotime($journal_date)));
        $amount = 0.00;
        for ($i = 1; $i < 1000; $i++) {
            $check = DB::select("SELECT id from drivers_jahiz_clearing WHERE clearance_type IN ('Quittance', 'Bond Cancellation', 'Bandar Commission') AND `created_at` LIKE '%$journal_date%' AND `driverId` = '$driverId'");
            if(count($check) > 0){
                $journal_date = date('Y-m-d', strtotime("-1 days", strtotime($journal_date)));
                $amount += 0.01;
            } else {
                break;
            }
        }
        return array($journal_date, $amount);
    }
    public function storeJahiz_saned_Document($journal_date,$request)
    {
        $Driver_id = $request->Driver_id;
        $jahiz_period_ids = $request->jahiz_period_ids;
        # code...
        // dd($request->all());
        $documentTypeName = '';
        $amount; 
        $driver_type = Drivers::where('id',$request->Driver_id)->get();
        if(count($driver_type)>0){
            // dd($driver_type[0]);
            $saned = $request->saned;
            $bandar = $request->bandar;
            $admin = $request->admin;
            $totalAmount = $request->totalAmount;
            $clearance_type = '';
            switch ($request->documentType) {
                case 150: 
                    $documentTypeName = 'مخالصة';
                    $amount = 150;
                    $saned = 0;
                    $admin = 0;
                    $clearance_type = 'Quittance';
                    break;
                
                case 75: 
                    $documentTypeName = 'الغاء سند';
                    $amount = 75;
                    $saned = 0;
                    $admin = 0;
                    $clearance_type = 'Bond Cancellation';
                    break;
                case 'clearing': 
                    $documentTypeName = 'تصفية مطالبات متأخرة';
                    $amount = $bandar;
                    $clearance_type = 'Claim Clearance';
                    break;
                case 'bandar': 
                    $documentTypeName = 'عمولة بندر';
                    $amount = $totalAmount;
                    $saned = 0;
                    $admin = 0;
                    $clearance_type = 'Bandar Commission';
                    break;
            }
            if($request->documentType == 150 || $request->documentType == 75 || $request->documentType == 'bandar') {
                $response = array();
                $response = $this->get_date($request->Driver_id, $journal_date);
                $journal_date = $response[0];
                $saned = $response[1];
            }
            // dd($journal_date);
            
            if ($request->documentType != 'clearing') {
                $Drivers_saned_settlement = Drivers_saned_settlement::create([
                    'AMP_ID'=>$request->job_id,
                    'DriverName'=>$driver_type[0]->fullName. " - ".$documentTypeName,
                    'CollectionAmount'=>$saned,
                    'DeliveryPrice'=>0,
                    'FreeOrderAmount'=>0,
                    'DriverCredit'=>0,
                    'DriverDebit'=>0,
                    'SettledDate'=>$journal_date,
                    'NoOfDispatch'=>0,
                    'created_by_id'=>Auth::user()->id
                ]); 
            }
            $mytime = Carbon::now();
            // dd($admin);
            $imageName = '';
            if($request->hasFile('proof_file')) {
                $imageName = time().'.'.$request->proof_file->extension();
                $request->proof_file->move(storage_path('app/public/images'), $imageName);
            }
            $drivers_jahiz_clearing = Drivers_jahiz_clearing::create([
                "driverId"=>$request->Driver_id,
                "driver_type_id"=>$driver_type[0]->driver_type_id,
                "Jahiz_Amount"=>$saned,
                "clearing_type_id"=>1,
                "Jahiz_Amount_Sign"=>1,
                "administrative_fee"=>$admin,
                "clearance_type"=>$clearance_type,
                "Bander_Commission"=>$amount,
                "bank"=>$request->bank < 1 ? null : $request->bank,
                "cash"=>$request->cash < 1 ? null : $request->cash,
                "ATM"=>$request->atm < 1 ? null : $request->atm,
                "created_by_id"=>Auth::user()->id,
                "updated_by_id"=>Auth::user()->id,
                "updated_at"=>$journal_date." ".$mytime->toTimeString(),
                "created_at"=>$journal_date." ".$mytime->toTimeString(),
                "proof_file"=>$imageName
            ]);
            
            $drivers_jahiz_clearing_id = $drivers_jahiz_clearing->id;
            if($request->documentType == 'bandar' AND $driver_type[0]->driver_type_id == 2) {
                foreach($jahiz_period_ids as $jahiz_period_id) {
                    $clause = $values_clauese = $clauese = "";
                    if(isset($request->{"week1_".$jahiz_period_id}) AND $request->{"week1_".$jahiz_period_id} > 0) {
                        $week1 = $request->{"week1_".$jahiz_period_id};
                        $clauese .= "week1, ";
                        $values_clauese .= "'$week1', ";
                        $clause .= "week1 = '$week1', ";
                    }
                    if(isset($request->{"week2_".$jahiz_period_id}) AND $request->{"week2_".$jahiz_period_id} > 0) {
                        $week2 = $request->{"week2_".$jahiz_period_id};
                        $clauese .= "week2, ";
                        $values_clauese .= "'$week2', ";
                        $clause .= "week2 = '$week2', ";
                    }
                    if(isset($request->{"week3_".$jahiz_period_id}) AND $request->{"week3_".$jahiz_period_id} > 0) {
                        $week3 = $request->{"week3_".$jahiz_period_id};
                        $clauese .= "week3, ";
                        $values_clauese .= "'$week3', ";
                        $clause .= "week3 = '$week3', ";
                    }
                    if(isset($request->{"week4_".$jahiz_period_id}) AND $request->{"week4_".$jahiz_period_id} > 0) {
                        $week4 = $request->{"week4_".$jahiz_period_id};
                        $clauese .= "week4, ";
                        $values_clauese .= "'$week4', ";
                        $clause .= "week4 = '$week4', ";
                    }
                    if(isset($request->{"weekAll_".$jahiz_period_id}) AND $request->{"weekAll_".$jahiz_period_id} > 0) {
                        $weekAll = $request->{"weekAll_".$jahiz_period_id};
                        $clauese .= "weekAll, ";
                        $values_clauese .= "'$weekAll', ";
                        $clause .= "weekAll = '$weekAll', ";
                    }
                    if(isset($request->{"amount_by_days_".$jahiz_period_id}) AND $request->{"amount_by_days_".$jahiz_period_id} > 0) {
                        $amount_by_days = $request->{"amount_by_days_".$jahiz_period_id};
                        $clauese .= "amount_by_days, ";
                        $values_clauese .= "'$amount_by_days', ";
                        $clause .= "amount_by_days = '$amount_by_days', ";
                    }
                    if($clauese != '') {
                        $check = DB::select("SELECT * FROM drivers_jahiz_montly WHERE driverId = '$Driver_id' AND jahiz_period_id = '$jahiz_period_id'");
                        if(count($check) > 0)
                            DB::update("UPDATE drivers_jahiz_montly set $clause updated_at = NOW() WHERE driverId = '$Driver_id' AND jahiz_period_id = '$jahiz_period_id'");
                        else
                            DB::insert("INSERT INTO drivers_jahiz_montly (drivers_jahiz_clearing_id, driverId, jahiz_period_id, $clauese updated_at) VALUES ('$drivers_jahiz_clearing_id', '$Driver_id', '$jahiz_period_id', $values_clauese NOW())");
                    }
                }
            }
            // return array('drivers_jahiz_clearing'=>$drivers_jahiz_clearing,'drivers_saned_settlement'=>$Drivers_saned_settlement);
            return redirect()->back()->with('success', 'Data Added successfully');
        }else{
            return "Update Driver Type(Per shipment or subscription)<br>"."الرجاء تعديل نوع المندوب للمتابعة";
        }
         
        
    }
    public function checkDate($date,$job_id,$Driver_id)
    {
        # code... 
        // dd($date);
        $date = Carbon::createFromFormat('Y-d-m', $date);
        $date_stringDate= $date->toDateString();
        // dd($date_stringDate); 
        $Drivers_saned_settlement = Drivers_saned_settlement::where([
            ['AMP_ID',$job_id],
            ['SettledDate',$date_stringDate]  
        ])->get(); 
        $sql = "SELECT * FROM `drivers_jahiz_clearing` WHERE `driverId` = ".$Driver_id." and created_at LIKE '%".$date_stringDate."%'";
        $drivers_jahiz_clearing = DB::select($sql);  
        // dd(count($Drivers_saned_settlement)>0 || count($drivers_jahiz_clearing)>0);
        if(count($Drivers_saned_settlement)>0 || count($drivers_jahiz_clearing)>0){
            $date = $date->addDays(1); 
            $date_stringDate= $date->toDateString(); 
            $date_stringDate = Carbon::createFromFormat('Y-m-d', $date_stringDate)->format('Y-d-m'); 
            $res = $this->checkDate($date_stringDate,$job_id,$Driver_id);
            return $res;
        }else{
            return $date_stringDate;
        }
    }

     
}
