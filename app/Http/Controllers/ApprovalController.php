<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Page_privilege;
use App\lkp_company;
use App\User;
use App\Approved_record;

use Illuminate\Support\Facades\Validator;
use DB;
use Auth;

use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    //
    public function index()
    {
        # code...
        // $currentPath= Route::getFacadeRoot()->current()->uri();
        // get all priviled users 
        $users = Page_privilege::groupBy('user_id')->get();
        $allusers = User::all();
        // dd($allusers);
        $companies = array();
        foreach($users as $payload){
            // get distict user and company 
            $groupByCompanies = Page_privilege::groupBy('user_id','company_id')->get();

            // foreach companies and get ITS privilages 
            
            foreach($groupByCompanies as $groupByCompany){
                $conpanyPrivils = Page_privilege::where([
                    ['user_id',$groupByCompany->user_id],
                    ['company_id',$groupByCompany->company_id]
                ])->get();
                $privilegs = array();
                foreach($conpanyPrivils as $conpanyPrivil){
                    $privilegs[] = [
                        'privilege_description'=>$conpanyPrivil->privilege_description,
                        'privilege_id'=>$conpanyPrivil->id
                    ];
                }
                $companies[] = [
                    'user_id'=>$groupByCompany->user_id,
                    'userName'=>$groupByCompany->user->name,
                    'company_name'=> $conpanyPrivil->company->companyName,
                    'company_id'=> $conpanyPrivil->company_id,
                    'privilages'=>$privilegs
                ];
                
            }
            // dd($companies);
        }

        $lkp_company  = lkp_company::all();
        // dd($companies);
        return view('approval.index',compact('companies','lkp_company','users','allusers'));
    }
    public function update(Request $request)
    {
        # code...
        // "user_id" => "2"
        // "company_id" => "1"
        // "approveStatus" => "true"
        // "exportStatus" => "false"
        // return $request->payload['approveStatus'];
        // dd($request->payload['user_id']);
        if($request->payload['approveStatus'] == true){
            // check ig the user have privilage 
            $groupByCompanies = Page_privilege::where([
                ['user_id',$request->payload['user_id']],
                ['company_id',$request->payload['company_id']],
                ['privilege_description','Approve']
            ])->get();

            dd($groupByCompanies);
            if(count($groupByCompanies)>0){
            }else{
                Page_privilege::create([
                    'user_id'=>$request->payload['user_id'],
                    'company_id'=>$request->payload['company_id'],
                    'privilege_description'=>'Approve',
                    'granted_by'=>Auth::user()->id,
                ]);
            }
        }else{
            $groupByCompanies = Page_privilege::where([
                ['user_id',$request->payload['user_id']],
                ['company_id',$request->payload['company_id']],
                ['privilege_description','Approve']
            ])->get();

            if(count($groupByCompanies)>0){
                $groupByCompanies->first();
                $groupByCompanies->delete();
            }

            
        }

        if($request->payload['exportStatus'] == true){
            // dd('Equal true');
            $groupByCompanies = Page_privilege::where([
                ['user_id',$request->user_id],
                ['company_id',$request->company_id],
                ['privilege_description','Export']
            ])->get();
            
            if(count($groupByCompanies)>0){
            }else{
                Page_privilege::create([
                    'user_id'=>$request->payload['user_id'],
                    'company_id'=>$request->payload['company_id'],
                    'privilege_description'=>'Export',
                    'granted_by'=>Auth::user()->id,
                ]);
            }
        }else{
            $groupByCompanies = Page_privilege::where([
                ['user_id',$request->user_id],
                ['company_id',$request->company_id],
                ['privilege_description','Export']
            ])->get();
            if(count($groupByCompanies)>0){
                $groupByCompanies->first();
                $groupByCompanies->delete();
            }
            
        }

        return response()->json(['status'=>true,"payload"=>""],200);
    }
    protected function Validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => ['required'],
            'company_id' => ['required'],
        ]);
    }
    public function create(Request $request)
    {
        # code...
        $this->Validator($request->all())->validate();
        $Page_privilege = new Page_privilege();
        $Page_privilege->user_id = $request->user_id;
        $Page_privilege->company_id = $request->company_id;
        $Page_privilege->granted_by = Auth::user()->id;
        

       if($request->has('approveStatus') || $request->has('exportStatus')){
    
        if($request->has('approveStatus')){
            
             $groupByCompanies = Page_privilege::where([
                ['user_id',$request->user_id],
                ['company_id',$request->company_id],
                ['privilege_description','Approve']
            ])->get();
            
            if(count($groupByCompanies)>0){
            }else{
                
                $res = Page_privilege::create([
                    'user_id'=>$request->user_id,
                    'company_id'=>$request->company_id,
                    'privilege_description'=>'Approve',
                    'granted_by'=>Auth::user()->id
                ]);

                // dd($res);
            }
        }

        if($request->has('exportStatus')){
            $groupByCompanies = Page_privilege::where([
                ['user_id',$request->user_id],
                ['company_id',$request->company_id],
                ['privilege_description','Export']
            ])->get();
            
            if(count($groupByCompanies)>0){
            }else{
                Page_privilege::create([
                    'user_id'=>$request->user_id,
                    'company_id'=>$request->company_id,
                    'privilege_description'=>'Export',
                    'granted_by'=>Auth::user()->id
                ]);
            }
        }
       }else{
       }
       return redirect('Approval-Pages');
        // dd($request->all());
    }
    public function approveMethod($company_id,$period,$user_id)
    {
        # code...
        $this->approveValidator([
            'company_id'=>$company_id,
            'period'=>$period,
            'user_id'=>$user_id,
        ])->validate();

        if(isset($period)){
            $Period = explode(' - ',$period);
            // dd($Period);
            $from = $Period[0];
            $to = $Period[1];
            $sql = "Select approved_records.*,users.name ,users.department from approved_records join users on users.id = approved_records.user_id where approved_records.user_id=".$user_id."  and approved_records.company_id=".$company_id."  and approved_records.periodFrom LIKE '%".$from."%' and approved_records.periodTo LIKE '%".$to."%' ";
            $checkIfApproved = DB::select($sql);
            $var = $checkIfApproved;
            //  dd($var);
            if(count($checkIfApproved)>0){
            }else{
                
                $insertQuery = "INSERT INTO `approved_records`(`user_id`, `company_id`, `periodFrom`, `periodTo`, `status`) VALUES (".Auth::user()->id.",".$company_id.",'".$from."','".$to."', 'approved')";
 
                $result = DB::select($insertQuery);
                return redirect()->back();
            }
        }

        // dd($user_id);
    }
    protected function approveValidator(array $data)
    {
        return Validator::make($data, [
            'company_id' => ['required'],
            'period' => ['required'],
            'user_id' => ['required'],
        ]);
    }
}
