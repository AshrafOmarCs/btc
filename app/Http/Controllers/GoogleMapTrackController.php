<?php

namespace App\Http\Controllers;

use App\GoogleMapTrack;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GoogleMapTrackController extends Controller
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
        if ($request->input('tracking_date') == "")
            $tracking_date = date('Y-m-d');
        else $tracking_date =\DateTime::createFromFormat('d/m/Y', $request->input('tracking_date'))->format('Y-m-d');
        //$tracking_date='2020-02-26';

        $where="";
//        if ($request->input('filter_userId') <> "")
//            $where=" AND users.id=".$request->input('filter_userId')." ";
        if ($request->input('filter_userId') <> "")
            $where=" users.id=".$request->input('filter_userId')." and ";


        $filter_userId=$request->input('filter_userId');


        $lkp_company = DB::select('SELECT * from lkp_company ');

        $warehouses = DB::select("SELECT companyId,warehouseName,latitude,longitude from warehouse
        where  latitude is not null and longitude is not null order by  companyId");


        $users = DB::select("SELECT id,name from users where user_type_id in(2,3) order by name");

        /*$polygons = DB::select("
         select userId,name,
         GROUP_CONCAT(CONCAT('\n[',latitude,',',longitude,',\'',DATE_FORMAT(location_history.created_at, '%H:%i'),'\']') ORDER BY location_history.created_at ASC) as polygon
         from location_history
        LEFT JOIN users ON users.IdentityNo = location_history.userId
         where userType in(2,3)
         and location_history.created_at between '$tracking_date 07:30:00' and '$tracking_date 14:59:59'
         GROUP BY userId,name");*/


        //For Old Table
//        $polygons = DB::select("select userId,name,latitude,longitude,HM,min(ROUND(distance_in_km,2)) as distance_in_km
//from
//(
//select userId,name,warehouseName,b.latitude as w_latitude,b.longitude as w_longitude,
//         a.latitude,a.longitude,DATE_FORMAT(a.timestamp, '%H:%i') as HM,
//ST_Distance_Sphere(
//    point(b.Longitude, b.Latitude),
//    point(a.Longitude, a.Latitude)
//)* .001   AS distance_in_km
//
//         from location_supervisors a
//         LEFT JOIN users ON users.IdentityNo = a.userId
//         LEFT JOIN users_privilege ON users_privilege.user_id=users.id
//         LEFT JOIN warehouse b ON b.id=users_privilege.warehouseId
//         where userType in(2,3)
//         ".$where."
//         and a.timestamp between '$tracking_date 07:30:00' and '$tracking_date 17:59:59'
//         )w
//GROUP BY userId,name,latitude,longitude,HM
//ORDER BY userId,HM");




        $polygons = DB::select("select userId,name,latitude,longitude,HM,min(ROUND(distance_in_km,2)) as distance_in_km
from
(
select userId,name,warehouseName,b.latitude as w_latitude,b.longitude as w_longitude,
         a.latitude,a.longitude,DATE_FORMAT(a.timestamp, '%H:%i') as HM,
ST_Distance_Sphere(
    point(b.longitude, b.latitude),
    point(a.longitude, a.latitude)
)* .001   AS distance_in_km

         from location_supervisors a
         LEFT JOIN users ON users.id = a.userId
         LEFT JOIN users_privilege ON users_privilege.user_id=users.id
         LEFT JOIN warehouse b ON b.id=users_privilege.warehouseId
         where
         ".$where."
          a.timestamp between '$tracking_date 07:30:00' and '$tracking_date 17:59:59'
         )w
GROUP BY userId,name,latitude,longitude,HM
ORDER BY userId,HM");


        $tracking_date=\DateTime::createFromFormat('Y-m-d', $tracking_date)->format('d/m/Y');

        return view('GoogleMapTrack.index')->with(compact('warehouses'))
            ->with(compact('users'))
            ->with(compact('filter_userId'))
            ->with(compact('lkp_company'))
            ->with(compact('polygons'))
            ->with(compact('tracking_date'));
    }


}
