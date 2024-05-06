<?php

namespace App\Http\Controllers;
use App\Company;
use App\Drivers;
use App\Expense;
use App\Expense_type;
Use Carbon;

use App\Expense_catogery;
use App\Sub_catogery;
use DateTime;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    //
    public function index()
    {
        # code...
        $tem_sub = array();
        $tem_array = array();
        $lkp_company = Company::all();
        $expense_types = Expense_type::all();
        $expenses = Expense::all();

        // get bander cars 
        $banderCars = Drivers::where('vehicle_id','!=','')->get();
        $recoreds = array();
        if(count($banderCars)>0){
            $query = '';
            foreach($banderCars as $banderCar){
                // get Allowded expenses
                $allowded_expenses = json_decode($banderCar->vehicle->grantred_expenses);
                
                
                if(count($allowded_expenses)>0){
                    $query = '(';
                    foreach($allowded_expenses as $k=>$allowded_expense){
                        // dd($allowded_expense);
                        
                        if($k == 0){
                            $query =$query . $allowded_expense;
                        }else{
                            $query =$query . ','.$allowded_expense;
                        }
                    }
                    $query =$query . ')';
                    // dd($query);
                }
                
                $transaction_date = '';
                $sqlQuery = 
                $driverExpenses = Expense::where([
                    ['reciver_Id',$banderCar->id],
                ])->orderBy('journal_date', 'DESC')->get();
                
                if(count($driverExpenses)>0){
                    $current_date = Carbon\Carbon::now();
                    $driverExpenses = $driverExpenses[0];
                    // dd($current_date->toDateString());
                    $transaction_date = $driverExpenses->journal_date;
                    $transaction_date = $current_date->diff($transaction_date);
                    // dd($transaction_date->days);
                    // dd($driverExpenses[0]);
                }
                
                $expense_types = Expense_type::where('company_id',$banderCar->warehouse->companyId)->get();
                // get expense amount 
 
                //  fill data 
                $payload = array(
                    "company_id"=>$banderCar->warehouse->company->id,
                    "companyName"=>$banderCar->warehouse->company->companyName,
                    "warehouse"=>$banderCar->warehouse->warehouseName,
                    "stcpayAccount"=>$banderCar->accountNumber,
                    "stcpayIqama"=>$banderCar->account_owner_iqama,
                    "Journal_date"=>"NULL",
                    "AMP_ID"=>$banderCar->job_id,
                    "driver_id"=>$banderCar->id,
                    "balance"=>"",
                    "lastTransactionDate"=>$transaction_date,
                    "Amount_due"=>"0.00",
                    "requestButton"=>"",
                    "status"=>"",
                    "paid_at"=>""
                );
                // dd($payload);
                $recoreds[] = $payload;
            }
            
            
        }

        dd($recoreds);
        // $Companies = Expense::groupBy('company_id')->get();
        // foreach($Companies as $k=>$company){
        //     // company name is I-mile 
        //     $company_expenses = Expense::where([
        //         ['company_id',$company->company_id]
        //     ])->get();
            
        //     //bring all company_expenses 
        //     foreach($company_expenses as $company_expense){
        //         $expenses = Expense::where([
        //             ['company_id',$company_expense->company_id],
        //             ['expense_type_id',$company_expense->expense_type_id]
        //         ])->get();
        //         // return Expense Name 

        //     }
        // }
        // dd($company_expenses);
        
        // foreach($records as $record){
        //     $checkSubCatogery = Sub_catogery::where([
        //         ['expense_catogery_id',$record->id]
        //     ])->get();
            
        //     if(count($checkSubCatogery)>0){
        //         foreach($checkSubCatogery as $item){
        //             $tem_sub['id'] = $item->id;
        //             $tem_sub['expense_name'] = $item->expense_name;
        //             $tem_sub['amount'] = $item->amount;
        //             $tem_sub['html_btns'] = '<button>TST</button>';
        //             $record['sub_catogeries'] = $tem_sub;
        //         }
        //     }
        //     $tem_array[] = $tem_sub;
        // }
        // dd($tem_sub);
        // dd($lkp_company);
        return view('Expenses.master_index',compact('lkp_company','expenses'));
    }

    public function filter_expenses(Request $request)
    {
        # code...

        dd($request->all());
    }
    public function index_sub()
    {
        # code...
        return 'hit Expenses-sub-Categories';
    }
    public function expenses_types()
    {
        # code...
        $payload = Expense_type::all();
        $lkp_company = Company::all();
        $expense_types = Expense_type::paginate(100);
        // dd($Expense_type);
        
        return view('Expenses.index',compact('payload','lkp_company','expense_types'));
        dd($request->all());
    }
    public function getExpenses(Request $request)
    {
        # code...
        dd($request->all());
    }
}
