<?php

namespace App\Http\Controllers;

use App\Imports\ReportsImport;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImportExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        @$pakage_date = DB::select('select report_date from report_date where companyId=1 ORDER BY id DESC LIMIT 1')[0];
        $data = array();
        //$NOT_FOUND = array();
        //$NOT_WORKING = array();

        if (!empty($pakage_date)) {

            $data = DB::select("select * from (
select Location,Email,report.NoFD,report.No_of_CIR,report.NoFTP,report.Total_OFD,
fullName,job_id,no_of_deliverd,return_no_of_touch_point,ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) as no_of_touch_point,total_out_for_deliver,packageStatusId,status,
(
    CASE
        WHEN ifnull(report.NoFTP,0)>0 and report.NoFTP=ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 1
        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP>ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 2
        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP<ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 3
        WHEN ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0  THEN 4
        ELSE 5
    END) AS rank

 from report
inner join drivers on upper(SUBSTR(drivers.email_id,1,POSITION('@' IN drivers.email_id)-1))=upper(SUBSTR(report.Email,1,POSITION('@' IN report.Email)-1))
left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date->report_date . "'
left join lkp_package_status on lkp_package_status.id=packages_report.packageStatusId
)a order by packageStatusId,Location");

            //$NOT_FOUND = DB::select("select Location,Email,NoFD,NoFTP,Total_OFD
            //      from report where upper(SUBSTR(Email,1,POSITION('@' IN Email)-1)) not in(select upper(SUBSTR(email_id,1,POSITION('@' IN email_id)-1)) from drivers) order by Location");

            /* $NOT_WORKING = DB::select("select warehouseName,fullName,job_id,iqama,mobileNumber,driver_status_en
         from drivers
         inner join warehouse on warehouse.id=drivers.warehouseId
         inner join lkp_driver_status on drivers.status_id=lkp_driver_status.id
         where email_id not in(select Email from report)
         and drivers.status_id in(1,2,5)
         order by warehouseName,fullName");*/
        }
        return view('import_excel/import_excel')
            ->with(compact('data'))
            //->with(compact('NOT_FOUND'))
            //->with(compact('NOT_WORKING'))
            ->with(compact('pakage_date'));
    }


    function import(Request $request)
    {
        //set_time_limit(0);
        $pakage_date = \DateTime::createFromFormat('d/m/Y', $request->input('pakage_date'))->format('Y-m-d');

        if ($pakage_date>=date('Y-m-d'))
            return "Date not Correct";

        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);

        DB::delete('delete from report');

        //$path1 = $request->file('select_file')->store('temp');
        //$path=storage_path('app').'/'.$path1;
        //$data = Excel::import(new ReportsImport,$path);

        //$path = $request->file('select_file')->getRealPath();
        //$data = Excel::import(new ReportsImport, $path);

        $data = Excel::import(new ReportsImport, $request->file('select_file'));

        //if (POSITION('@' IN report.Email)=0,CONCAT(report.Email,'@gmail.com'),report.Email)
        DB::insert("INSERT INTO report(Location,Email,UserName,NoFD,No_of_CIR,NoFTP,Total_OFD,created_at,updated_at,flag)
        SELECT report.Location,
               if (POSITION('@' IN report.Email)=0,CONCAT(report.Email,'@gmail.com'),report.Email),
               report.UserName,
               maxgroup.NoFD,maxgroup.No_of_CIR,maxgroup.NoFTP,maxgroup.Total_OFD,report.created_at,report.updated_at,'1'
        FROM report
        inner JOIN (
        SELECT Email,sum(NoFD) as NoFD,sum(No_of_CIR) as No_of_CIR,sum(NoFTP) as NoFTP,sum(Total_OFD) as  Total_OFD, MAX(Total_OFD) AS max
        FROM report
        GROUP BY Email
        ) AS maxgroup ON (
        (report.Email = maxgroup.Email) AND (report.Total_OFD = maxgroup.max)
        )
        where report.Email is not null");

        DB::delete('delete from report where flag is null');
        //return 'aa';
        $check = DB::select("
            select count(*) as CO from(
select Location,Email,report.NoFD,report.NoFTP,report.Total_OFD,
fullName,job_id,no_of_deliverd,no_of_touch_point,total_out_for_deliver,
(
    CASE
        WHEN ifnull(report.NoFTP,0)>0 and report.NoFTP=ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) and report.NoFD=no_of_deliverd and report.Total_OFD=total_out_for_deliver THEN 1
        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP>ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 2
        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP<ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 3
        WHEN ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0  THEN 4
        ELSE 5
    END) AS rank

 from report
inner join drivers on upper(SUBSTR(drivers.email_id,1,POSITION('@' IN drivers.email_id)-1))=upper(SUBSTR(report.Email,1,POSITION('@' IN report.Email)-1))
left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date . "'
)a where rank=1
            ")[0];
        //return $check->CO;
        if (!$check->CO < 11) {
            DB::delete('delete from report');
            return redirect('/import_excel')->with('error', "Wrong Date - Less than 10 matching .......");
        } else {
            //******************************************************************************************************************
            //******************************************************************************************************************
            //******************************************************************************************************************
            DB::insert("insert into report_date (companyId,report_date,created_at)values(1,'" . $pakage_date . "','" . date("Y-m-d H:i:s") . "')");
            //-----------------------------------------------------------------------------------------------------------
            try {
                DB::update("update packages_report
                inner join
                    (
                     select drivers.id as driverId,Location,Email,report.NoFD,report.No_of_CIR,report.NoFTP,report.Total_OFD,
                       (
                    CASE
                        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP=ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 2
                        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP>ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 4
                        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP<ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 3
                        WHEN ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0  THEN 5
                        ELSE 6
                    END) AS rank,
                    (CASE
                        WHEN ifnull(report.NoFTP,0)>0 and report.NoFTP=ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 2
                        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP>ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 2
                        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 ) and report.NoFTP<ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0) THEN 1
                        WHEN not(ifnull(no_of_touch_point,0)+ifnull(return_no_of_touch_point,0)=0 )=0  THEN 2
                        ELSE 6
                    END) AS approve

                 from report
                inner join drivers on upper(SUBSTR(drivers.email_id,1,POSITION('@' IN drivers.email_id)-1))=upper(SUBSTR(report.Email,1,POSITION('@' IN report.Email)-1))
                left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date . "'
                    )report on report.driverId=packages_report.driverId
                    set
                    packages_report.No_of_D=report.NoFD,
                    packages_report.No_of_CIR=report.No_of_CIR,
                    packages_report.No_of_TP=report.NoFTP,
                    packages_report.Total_OFD=report.Total_OFD,
                    packages_report.packageStatusId=report.rank,
                    packages_report.approveStatusId=2
                where pakage_date ='" . $pakage_date . "' and approveStatusId=1");
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/import_excel')->with('error', '1'.$e->getPrevious()->getMessage());
            }
            DB::insert("insert into packages_report(driverId,attendence,pakage_date,packageStatusId,approveStatusId,updated_usertypeid,updatedby_id,No_of_D,No_of_CIR,No_of_TP,Total_OFD,created_at,updated_at,unit_cost)
            select drivers.id ,0,'" . $pakage_date . "',6,2,1," . Auth::user()->id . ",report.NoFD,report.No_of_CIR,report.NoFTP,report.Total_OFD,'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "',
            8
            from report
            inner join drivers on upper(SUBSTR(drivers.email_id,1,POSITION('@' IN drivers.email_id)-1))=upper(SUBSTR(report.Email,1,POSITION('@' IN report.Email)-1))
            inner join warehouse on warehouse.id=drivers.warehouseId
            left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date . "'
            where packages_report.driverId is null");

            $password = bcrypt('123456');

            $Drivers = DB::select("select Location,Email,UserName,NoFD,No_of_CIR,NoFTP,Total_OFD
            from report
            left  join drivers on SUBSTR(upper(email_id),1,POSITION('@' IN email_id)-1)=SUBSTR(upper(Email),1,POSITION('@' IN Email)-1)
            where drivers.id is null");
            $i = 0;
            foreach ($Drivers as $Driver) {


                $warehouse = collect(DB::select("Select id from warehouse where warehouseName='" . $Driver->Location . "' and companyId=1"))->first();


                if (empty($warehouse->id)) {

                    $Location = strtoupper(substr($Driver->Email, 0, 3));
                    $city = collect(DB::select("Select id from lkp_city where name_en='" . $Location . "'"))->first();
                    if (empty($city->id)) {
                        $city_id = DB::table('lkp_city')->insertGetId(['name_en' => $Location, 'name_ar' => $Location]);
                    } else {
                        $city_id = $city->id;
                    }


                    $warehouse_id = DB::table('warehouse')->insertGetId([
                        'warehouseName' => $Driver->Location,
                        'companyId' => '1',
                        'cityId' => $city_id,
                        'Saturday' => '9',
                        'Sunday' => '9',
                        'Monday' => '9',
                        'Tuesday' => '9',
                        'Wednesday' => '9',
                        'Thursday' => '9',
                        'Friday' => '9',
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ]);

                } else {
                    $warehouse_id = $warehouse->id;
                }

                $job_id = explode("@", strtoupper($Driver->Email));
                $fullName = explode("@", $Driver->UserName);


                $drivers = collect(DB::select("Select id from drivers where job_id='" . $job_id[0] . "'"))->first();

                if (empty($drivers->id)) {
                    $driverId = DB::table('drivers')->insertGetId([
                        'warehouseId' => $warehouse_id,
                        'fullName' => $fullName[0],
                        'email_id' => $Driver->Email,
                        'job_id' => $job_id[0],
                        'ops_name' => $Driver->UserName,
                        'status_id' => '1',
                        'password' => $password,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ]);
                } else {
                    $driverId = $drivers->id;
                }

                $dayname = \DateTime::createFromFormat('Y-m-d', $pakage_date)->format('l');
                $day = DB::select("SELECT " . $dayname . " as dayunitcost from drivers
            inner join warehouse on warehouse.id=drivers.warehouseId
            where drivers.id=" . $driverId)[0];


                DB::insert("
            insert into packages_report(driverId,attendence,pakage_date,packageStatusId,approveStatusId,updated_usertypeid,updatedby_id,
            No_of_D,No_of_CIR,No_of_TP,Total_OFD,created_at,updated_at,unit_cost)
            values(" . $driverId . ",0,'" . $pakage_date . "',7,2,1," . Auth::user()->id . "," . $Driver->NoFD . ",
            " . $Driver->No_of_CIR . "," . $Driver->NoFTP . "," . $Driver->Total_OFD . ",
            '" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "',8)
            ");
            }


            try {

                DB::insert("insert into journal (driverId,journal_date,journal_type_id,post_id,
                createdby_id,updatedby_id,created_at,updated_at,credit)

        select driverId,pakage_date,6,packages_report.id," . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "' as created_at,'" . date("Y-m-d H:i:s") . "' as updated_at,
        unit_cost* No_of_TP
        from packages_report
        inner join drivers on drivers.id=packages_report.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        where pakage_date ='" . $pakage_date . "'
        and companyId=1
        and packages_report.journal_id is null
        and packages_report.approveStatusId=2
        ");
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/import_excel')->with('error', '2'.$e->getPrevious()->getMessage());
            }


            try {
                DB::update("
        UPDATE packages_report
        JOIN journal  ON (packages_report.id = journal.post_id and journal.journal_type_id=6)
        inner join drivers on drivers.id=packages_report.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        SET packages_report.journal_id = journal.id
        where pakage_date ='" . $pakage_date . "'
        and packages_report.approveStatusId=2
        ");
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/import_excel')->with('error', '3'.$e->getPrevious()->getMessage());
            }
            //******************************************************************************************************************
            //******************************************************************************************************************
            //******************************************************************************************************************
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
