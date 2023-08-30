<?php

namespace App\Http\Controllers;
use App\Company;
use App\Warehouse;
use App\Journal;
use App\Loan;
use App\Users_privilege;
use Auth;
use App\Drivers;
use DateTime;
Use Carbon;
use Illuminate\Http\Request;

class fuelLoanController extends Controller
{
    //
    public function index(Request $request)
    {
        // Variabes decleartion
        $method = $request->method();

        $weekly_amount = 0.00;
        $grandTotal = 0.00;
        $DriversList = array(); 
        $lkp_company ;
        $btns = '( ';
        # code...
        // check user privilage 
        if (Auth::user()->user_type_id == 1) {
             if ($request->isMethod('post')) {
                //
                //  dd($request->all());
                if($request->filter_warehouseId2 != ''){
                    
                    $drivers = Drivers::where([
                        ['driver_type_id',2],
                        ['fuel_per_day','!=',''],
                        ['status_id',1], 
                        ['warehouseId',$request->filter_warehouseId2]
                    ])->get(); 
                }else{
                    if($request->filter_companyId2 == 'all'){
                        // company filtler 
                        $drivers = Drivers::where([
                            ['driver_type_id',2],
                            ['fuel_per_day','!=',''],
                            ['status_id',1], 
                        ])->get();
                    }else{
                        // company filtler 
                        $drivers = Drivers::join('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')->where([
                            ['driver_type_id',2],
                            ['fuel_per_day','!=',''],
                            ['status_id',1],
                            ['warehouse.companyId',$request->filter_companyId2]
                        ])->get();
                    } 
                }
                
                
                // dd($drivers);
            }else{
                 $drivers = Drivers::where([
                    ['driver_type_id',2],
                    ['fuel_per_day','!=',''],
                    ['status_id',1], 
                ])->get();
            }
           
            $lkp_company = Company::all();
            // dd($drivers);
           
        }else{
            
            
            $Users_privileges = Users_privilege::where('user_id',Auth::user()->id)->get();
            
            // $user_companies =
            $whereConditions = array();
            foreach($Users_privileges as $k=>$Users_privilege){
                if($k == 0){
                    $whereConditions[] = $Users_privilege->warehouseId  ;
                }else{
                    $whereConditions[] = $Users_privilege->warehouseId  ;
                }
            }
            
 
            // filter by warehouse and company 
            
             if (empty($request->filter_Year)) {
                
                 
             }
            // $whereConditions = $whereConditions.']';
            
            $whereHouses = Warehouse::select('id','companyId')->whereIn('id',$whereConditions)->groupBy('companyId')->get();
            // dd($whereHouses);
            if(count($whereHouses)>1){
                // dd($whereHouses);
                $companiesArray = array();
                foreach($whereHouses as $whereHouse){
                    $companiesArray[] = $whereHouse->companyId;
                }
                $lkp_company = Company::whereIn('id',$companiesArray)->get();
                
                
                
                
                
                if ($request->isMethod('post')) {
                //
                //  dd($request->all());
                if($request->filter_warehouseId2 != ''){
                    
                    // $drivers = Drivers::where([
                    //     ['driver_type_id',2],
                    //     ['fuel_per_day','!=',''],
                    //     ['status_id',1] 
                    // ])->get(); 
                    
                    $drivers = Drivers::where([
                        ['driver_type_id',2],
                        ['fuel_per_day','!=',''],
                        ['status_id',1],
                        ['warehouseId',$request->filter_warehouseId2]
                    ])->get(); 
                }else{
                    if($request->filter_companyId2 == 'all'){
                        // company filtler 
                        $drivers = Drivers::where([
                            ['driver_type_id',2],
                            ['fuel_per_day','!=',''],
                            ['status_id',1], 
                        ])->get();
                    }else{
                        // company filtler 
                        $drivers = Drivers::join('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')->where([
                            ['driver_type_id',2],
                            ['fuel_per_day','!=',''],
                            ['status_id',1],
                            ['warehouse.companyId',$request->filter_companyId2]
                        ])->get();
                    } 
                }
                
                
                // dd($drivers);
            }else{
                 $drivers = Drivers::where([
                    ['driver_type_id',2],
                    ['fuel_per_day','!=',''],
                    ['status_id',1], 
                ])->get();
            }
            
            
                $drivers = $drivers->whereIn('warehouseId',$whereConditions);
            }else{
                
                $whereHouses = $whereHouses->first();
                // dd('$whereHouses');
                $lkp_company = Company::where('id',$whereHouses->companyId)->get();
                // dd($lkp_company);
                $drivers = Drivers::where([
                    ['driver_type_id',2],
                    ['fuel_per_day','!=',''],
                    ['status_id',1] ,
                    ['warehouseId',$whereHouses->id] 
                ])->get();
                // dd($drivers); 

            }
            // $companies = Company::whereIn('',$whereConditions)
            // dd($whereConditions);
        }   
        // dd($drivers) ;   
        
        // end check privailage 


        
        // get drivers who desirve feul loans 
        

        // check if the driver is not null 
        if(count($drivers)>0){
            foreach($drivers as $k=>$driver){
                // get driver supervisor
                $superviors = Warehouse::getWarehouseSupervisor($driver->warehouseId);
                $supervisors_cell = '<td style="color: #0b4279; font-weight: bold; padding: 10px; ">';
                foreach($superviors as $k=>$supervior){
                    // get driver supervisor
                    // dd($supervior);
                    if($k == 0){
                        $supervisors_cell = $supervisors_cell.'  
                        '.$supervior['name'].' <br>
                        '.$supervior['number'].' 
                    '; 
                    }else{
                        $supervisors_cell = $supervisors_cell.' <hr>
                        '.$supervior['name'].' <br>
                        '.$supervior['number'].' 
                        '; 
                    }
                    
                }
                $supervisors_cell = $supervisors_cell.'</td>';
                 
                
                // $superviors_tam;
                 
                
                // end supervisor 
                $weekly_amount = $driver->fuel_per_day*6;
                
                // dd($weekly_amount);
                // dd($drivers);
                $lastFuelExpenseDetails = $this->getLastTransactionDate($driver->id);
                //  dd($lastFuelExpenseDetails);
                // Request Button 
                if($lastFuelExpenseDetails['lastTransactionInDays'] >6 || $lastFuelExpenseDetails['status'] == 'hasNoHistory'){

                    // desirve Fuel Expense
                    // dd($lastFuelExpenseDetails);
                    $btns2 = "<a class='btn btn-sm btn-primary' id='btn".$driver->id."' onclick='confirmDilag(".$driver->id.")' >Confirm  </a>  ";

                    $btns = "
                    <span style='float: left; font-size: 9px;'>".$driver->fuel_per_day." Per Day</span>
                            <h3 style='margin-right: 38px;'> <h2 style='margin: 0;margin-right: 8px !important;font-size: 23px;'>".$weekly_amount." SAR</h2> <span style='font-size: 11px; float: left;'>For</span></h3>
                            <input type='number' name='' disabled id='' value='6'><span style='float: right;'> Day/s</span>
                    ";
                    // fill data 
                    $currentDate = date('Y-m-d');
                    
                    $mytime = Carbon\Carbon::now()->format('d-m-Y'); 
                    $DriversList[$driver->id] = array(
                        "id"=>$driver->id,
                        "company_id"=>$driver->warehouse->company->id,
                        "companyName"=>$driver->warehouse->company->companyName,
                        "warehouse"=>$driver->warehouse->warehouseName,
                        "stcpayAccount"=>$driver->accountNumber,
                        "stcpayIqama"=>$driver->account_owner_iqama, 
                        "driverName"=>$driver->fullName, 
                        "AMP_ID"=>$driver->job_id,
                        "driver_id"=>$driver->id,
                        "journal_date"=>$currentDate,
                        "driverStatus"=>$driver->statusString->driver_status_en,
                        "lastTransactionInDays"=>$lastFuelExpenseDetails['lastTransactionInDays'],
                        "lastTransactionDate"=>$lastFuelExpenseDetails['lastTransactionDate'],
                        "Amount_due"=>$weekly_amount,
                        "supervisors"=>$supervisors_cell,
                        "requestButton"=>$btns,
                        'btns2'=>$btns2,
                        "RequestStatus"=>"",
                    );
                    $grandTotal = $grandTotal+ $weekly_amount;
                }else{
                    //Not desirve Fuel Expense

                }
            }
             
             
        }
        

        $summary = array('total'=>$grandTotal);


        return view('Loans_fuel.index',compact('DriversList','lkp_company','summary'));
        
    }
    public function test(Request $request)
    {
        dd($$request->all());
        # code...
    }
    public function storeAll(Request $request){
        return $request->all();
    }
    public function getLastTransactionDate($driver_id)
    {
        $drivrejournalHistory = Loan::where([
            ['driverId',$driver_id],
            ['loan_type','fuel_loan']
        ])->orderBy('journal_date', 'DESC')->get();
        // dd($drivrejournalHistory);
        if(count($drivrejournalHistory)>0){
            // user have privs fuel loans 
            $current_date = Carbon\Carbon::now();
            $drivrejournalHistory = $drivrejournalHistory[0];
            // dd($current_date->toDateString());
            $transaction_date = $drivrejournalHistory->journal_date;
            $transaction_date = $current_date->diff($transaction_date);
            $transaction_date = $transaction_date->days;
            // dd($transaction_date);
            return array('lastTransactionInDays'=>$transaction_date,'lastTransactionDate'=>$drivrejournalHistory->journal_date,'status'=>'hasHistory'); 
            // $transaction_date->days;
        }else{
            return array('lastTransactionInDays'=>6,'lastTransactionDate'=>'','status'=>'hasNoHistory'); 
            // user doesn't have fuel loans 
        }
       
        # code...
    }
    public function store(Request $request)
    {
        # code...
        //  dd($request->all());
        $loan_id = Loan::create([
            'driverId'=>$request->driverId,
            'journal_date'=>$request->journal_date,
            'amount'=>$request->Amount_due,
            'status_id'=>5,
            'loan_type'=>'fuel_loan',
            'note'=>'Fuel Expense |  مصروف محروقات ', 
            'createdby_id'=>Auth::user()->id, 
            // 'updated_usertypeid'=>Auth::user()->id, 
            'created_usertypeid'=>Auth::user()->id
        ]);
        // dd($loan_id);
        return response()->json(["payload"=>$loan_id,'status'=>true],200);
    }
}
