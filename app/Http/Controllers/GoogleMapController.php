<?php

namespace App\Http\Controllers;

use App\GoogleMap;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class GoogleMapController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lkp_company = DB::select('SELECT * from lkp_company ');
        
        $warehouses=DB::select("SELECT companyId,warehouseName,latitude,longitude from warehouse 
        where  latitude is not null and longitude is not null order by  companyId");


        
        return view('GoogleMap.index')->with(compact('warehouses'))
        ->with(compact('lkp_company'));
    }

   
}
