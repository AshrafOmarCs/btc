<?php

namespace App\Http\Controllers;
use DB;
use App\Outsourcepayment;
use Illuminate\Http\Request;

class outSourcePaymentController extends Controller
{
    //
    public function index()
    {
        # code...
        $lkp_company = DB::select("select * from lkp_company");
        $data = Outsourcepayment::all();
        //dd($data);
        return view('OutSourcePayments.index',compact('lkp_company','data'));
    }
    public function create()
    {
        # code...
    }
}
