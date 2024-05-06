<?php

namespace App\Http\Controllers;

use App\GoogleMapUser;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GoogleMapUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */

    public function index(Request $request)
    {

        if ($request->input('tracking_date') == "")
            $tracking_date =  date("d/m/Y", strtotime( '-30 days' ) )." - ".date('d/m/Y');
        else $tracking_date =$request->input('tracking_date');

        $date = explode(" - ",$tracking_date);
        $from =\DateTime::createFromFormat('d/m/Y', $date[0])->format('Y-m-d');
        $to =\DateTime::createFromFormat('d/m/Y', $date[1])->format('Y-m-d');

        $where="";
        if ($request->input('filter_userId') <> "")
            $where=" userId=".$request->input('filter_userId')." AND ";
        else
            $where=" ";

        //Log::info($where);

        $earlier = new \DateTime($from);
        $later = new \DateTime($to);

        $diff = $later->diff($earlier)->format("%a");

        if($diff>35)
            return 'ERROR: Date Range More Than 35';


//return $where;
        $filter_userId=$request->input('filter_userId');


        $lkp_company = DB::select('SELECT * from lkp_company ');

        $warehouses = DB::select("SELECT companyId,warehouseName,latitude,longitude from warehouse
        where  latitude is not null and longitude is not null order by  companyId");

        $users = DB::select("SELECT id,name from users where user_type_id in(2,3) order by name");
        $polygons=array();



        $polygons = DB::select("select * FROM
(
select date_add('$from', interval row day) as userId from
         (
            SELECT @row := @row + 1 as row FROM
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t,
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t2,
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t3,
            (select 0 union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 6 union all select 7 union all select 8 union all select 9) t4,
            (SELECT @row:=-1) r
         ) sequence
         where date_add('$from', interval row day) <= '$to')a
left join (
select userId as userId2, name,latitude,longitude,HM,min(ROUND(distance_in_km,2)) as distance_in_km
from
(
select userId,DATE_FORMAT(a.timestamp, \"%Y-%m-%d\") as name,warehouseName,b.latitude as w_latitude,b.longitude as w_longitude,
         a.latitude,a.longitude,DATE_FORMAT(a.timestamp, '%H:%i') as HM,
ST_Distance_Sphere(
    point(b.Longitude, b.Latitude),
    point(a.Longitude, a.Latitude)
)* .001   AS distance_in_km

         from location_supervisors a
         LEFT JOIN users ON users.id = a.userId
         LEFT JOIN users_privilege ON users_privilege.user_id=users.id
         LEFT JOIN warehouse b ON b.id=users_privilege.warehouseId
         where
         ".$where."
          DATE_FORMAT(a.timestamp, \"%H:%i:%s\") between '07:00:00' and '20:00:00'
         and DATE_FORMAT(a.timestamp, \"%Y-%m-%d\") between '$from' and '$to'
         )w

GROUP BY userId,name,latitude,longitude,HM
)b
on b.name= a.userId
ORDER BY userId,HM");



        //$tracking_date=\DateTime::createFromFormat('Y-m-d', $tracking_date)->format('d/m/Y');

        return view('GoogleMapUser.index')->with(compact('warehouses'))
            ->with(compact('users'))
            ->with(compact('filter_userId'))
            ->with(compact('lkp_company'))
            ->with(compact('polygons'))
            ->with(compact('tracking_date'));
    }


}
