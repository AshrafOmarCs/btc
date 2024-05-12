<?php

namespace App\Http\Controllers;

use App\GoogleMapAttend;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GoogleMapAttendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function index(Request $request)
    {
        if ($request->input('tracking_date') == "")
            $tracking_date = date('Y-m-d');
        else $tracking_date = \DateTime::createFromFormat('d/m/Y', $request->input('tracking_date'))->format('Y-m-d');
        //$tracking_date='2020-02-26';
        //$tracking_date=date('Y-m-d');
        //$tracking_date='2020-03-11';
        $lkp_company = DB::select('SELECT * from lkp_company WHERE lkp_company.status = "active"');
        $warehouses = DB::select("SELECT companyId,warehouseName,latitude,longitude from warehouse
        where  latitude is not null and longitude is not null order by  companyId");
        $polygons = DB::select("select userId,name,latitude,longitude,HM,min(ROUND(distance_in_km,2)) as distance_in_km
                    from
                    (
                    select userId,name,warehouseName,b.latitude as w_latitude,b.longitude as w_longitude,
                             a.latitude,a.longitude,DATE_FORMAT(a.timestamp, '%H:%i') as HM,
                    ST_Distance_Sphere(
                        point(b.Longitude, b.Latitude),
                        point(a.Longitude, a.Latitude)
                    )* .001   AS distance_in_km
                         from location_supervisors a
                         LEFT JOIN users ON users.id = a.userId
                         LEFT JOIN users_privilege ON users_privilege.user_id=users.id
                         LEFT JOIN warehouse b ON b.id=users_privilege.warehouseId
                         where users.active_id=1
                         and a.timestamp between '$tracking_date 07:00:00' and '$tracking_date 20:00:00'
                         )w
                        GROUP BY userId,name,latitude,longitude,HM
                        ORDER BY userId,HM");
        $NOT_FOUND = DB::select("select users.id as userId,users.name from users
                         where users.user_type_id in(2,3)
                         and users.active_id=1
                        and users.id not in(select userId from location_supervisors where
                         location_supervisors.timestamp between '$tracking_date 07:00:00' and '$tracking_date 20:00:00'
                        )
                        ORDER BY name
                        ");
        //and a.timestamp between '$tracking_date 07:00:00' and '$tracking_date 20:00:00'
        $tracking_date = \DateTime::createFromFormat('Y-m-d', $tracking_date)->format('d/m/Y');
        return view('GoogleMapAttend.index')->with(compact('warehouses'))
            ->with(compact('lkp_company'))
            ->with(compact('polygons'))
            ->with(compact('NOT_FOUND'))
            ->with(compact('tracking_date'));
    }
}
