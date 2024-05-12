<?php

namespace App\Http\Controllers;
use DB;
use App\Exported_record;
use Illuminate\Http\Request;

class UnpaidSalaryController extends Controller
{
    //
    public function index()
    {
        # code...
        $lkp_company = DB::select("select * from lkp_company where lkp_company.status = 'active'");
        $Exported_records = DB::select("SELECT exported_records.*,lkp_company.companyName FROM `exported_records` 
        JOIN lkp_company ON lkp_company.id = exported_records.company_Id
        ");
        // dd($Exported_records);
        $total = 0;
        foreach($Exported_records as $Exported_record){
            $total = $Exported_record->edit_salary + $total;
        }
        // dd($total);
        $extra = array('total'=>$total);
        return view('unpaidSalary.index',compact('lkp_company','Exported_records','extra'));
    }
    public function destroy_unpaidTransaction($recored_id)
    {
        # code...
        $destroy = Exported_record::where('id',$recored_id)->first();
        $destroy->delete();
        
        return response()->json(['status'=>true,'massage'=>'Migration has been completed'],200);
        //  DB::select("select * from exported_records where id=".$recored_id." ");
        
        // $destroy = DB::select('select * from exported_records where id= '".$recored_id."' ');

        return $destroy;
    }
    public function destroy_unpaidTransactions(Request $request )
    {
        # code...
        $ids = $request->favorite;
        
        if(count($ids)>0){
            foreach($ids as $id){
                 
                $destroy = Exported_record::where('id',$id)->first();
                // dd($destroy);
                $destroy->delete();
            }
            return response()->json(["status"=>true,"msg"=>'Done successfully'],200);
        }else{
            return response()->json(["status"=>false,"msg"=>'No record selected '],200);
        }
    }
}
