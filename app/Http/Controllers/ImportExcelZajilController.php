<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Reports_zajil;
use App\Imports\ReportsImport_zajil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImportExcelZajilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        @$pakage_date = DB::select('select report_date from report_date where companyId=6 ORDER BY id DESC LIMIT 1')[0];
        $data = array();
        //$NOT_FOUND = array();
        // $NOT_WORKING = array();

        if (!empty($pakage_date)) {

            $data = DB::select("select * from (
select Location,name,report_zajil.NoFD,report_zajil.Total_OFD,
fullName,job_id,no_of_deliverd,no_of_touch_point,total_out_for_deliver,packageStatusId,status,
(
    CASE
        WHEN report_zajil.NoFD=no_of_deliverd THEN 1
        WHEN not(no_of_deliverd=0 or no_of_deliverd is null) and report_zajil.NoFD>no_of_deliverd THEN 2
        WHEN not(no_of_deliverd=0 or no_of_deliverd is null) and report_zajil.NoFD<no_of_deliverd THEN 3
        WHEN no_of_deliverd=0  THEN 4
        ELSE 5
    END) AS rank

 from report_zajil
left join drivers on upper(drivers.fullName)=upper(report_zajil.name)
left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date->report_date . "'
left join lkp_package_status on lkp_package_status.id=packages_report.packageStatusId
)a order by packageStatusId,Location");

            //$NOT_FOUND = DB::select("select Location,name,Total_OFD,NoFD
            //                      from report_zajil
            // where upper(report_zajil.name) not in(select upper(drivers.fullName) from drivers) order by Location");

            /* $NOT_WORKING = DB::select("select warehouseName,fullName,job_id,iqama,mobileNumber,driver_status_en
         from drivers
         inner join warehouse on warehouse.id=drivers.warehouseId
         inner join lkp_driver_status on drivers.status_id=lkp_driver_status.id
         where email_id not in(select Email from report)
         and drivers.status_id in(1,2,5)
         order by warehouseName,fullName");*/
        }
        return view('import_excel/import_excel_zajil')
            ->with(compact('data'))
            // ->with(compact('NOT_FOUND'))
            //->with(compact('NOT_WORKING'))
            ->with(compact('pakage_date'));
    }


    function import(Request $request)
    {
        $pakage_date = \DateTime::createFromFormat('d/m/Y', $request->input('pakage_date'))->format('Y-m-d');


        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);

        DB::delete('delete from report_zajil');

        //$path1 = $request->file('select_file')->store('temp');
        //$path=storage_path('app').'/'.$path1;
        //$data = Excel::import(new ReportsImport,$path);

        //$path = $request->file('select_file')->getRealPath();
        //$data = Excel::import(new ReportsImport, $path);

        $data = Excel::import(new ReportsImport_zajil, $request->file('select_file'));

        $check = DB::select("select name,Total_OFD,NoFD from report_zajil order by id");

        $values = '';
        foreach ($check as $checkk) {
            if (substr($checkk->name, -3) <> '-PP')
                $Location = $checkk->name;
            else {
                $values .= "('" . $Location . "','" . $checkk->name . "','" . $checkk->Total_OFD . "','" . $checkk->NoFD . "',
             '" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'),";
            }
        }

        $values = substr($values, 0, strlen($values) - 1);
        if ($values <> '') {
            DB::insert("insert into report_zajil (Location,name,Total_OFD,NoFD,created_at,updated_at)
                  VALUES
                  " . $values);
        }
        DB::delete('delete from report_zajil where Location is null');

        /**
         * $check = DB::select("
         * select count(*) as CO from(
         * select Location,Email,report.NoFD,report.NoFTP,report.Total_OFD,
         * fullName,job_id,no_of_deliverd,no_of_touch_point,total_out_for_deliver,
         * (
         * CASE
         * WHEN report.NoFTP=no_of_touch_point and report.NoFD=no_of_deliverd and report.Total_OFD=total_out_for_deliver THEN 1
         * WHEN not(no_of_touch_point=0 or no_of_touch_point is null) and report.NoFTP>no_of_touch_point THEN 2
         * WHEN not(no_of_touch_point=0 or no_of_touch_point is null) and report.NoFTP<no_of_touch_point THEN 3
         * WHEN no_of_touch_point=0  THEN 4
         * ELSE 5
         * END) AS rank
         *
         * from report
         * inner join drivers on upper(SUBSTR(drivers.email_id,1,POSITION('@' IN drivers.email_id)-1))=upper(SUBSTR(report.Email,1,POSITION('@' IN report.Email)-1))
         * left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date . "'
         * )a where rank=1
         * ")[0];**/
        //return $check->CO;
        $CO = 20;
        if ($CO < 11) {
            // DB::delete('delete from report_zajil');
            // return redirect('/import_excel_zajil')->with('error', "Wrong Date");
        } else {
            //******************************************************************************************************************
            //******************************************************************************************************************
            //******************************************************************************************************************
            DB::insert("insert into report_date (companyId,report_date,created_at)values(6,'" . $pakage_date . "','" . date("Y-m-d H:i:s") . "')");
            //-----------------------------------------------------------------------------------------------------------

            try {
                DB::update("update packages_report
                inner join
                    (
                     select drivers.id as driverId,Location,name,report_zajil.NoFD,report_zajil.Total_OFD,
                       (
                    CASE
                        WHEN not(no_of_deliverd=0 or no_of_deliverd is null) and report_zajil.NoFD=no_of_deliverd THEN 2
                        WHEN not(no_of_deliverd=0 or no_of_deliverd is null) and report_zajil.NoFD>no_of_deliverd THEN 4
                        WHEN not(no_of_deliverd=0 or no_of_deliverd is null) and report_zajil.NoFD<no_of_deliverd THEN 3
                        WHEN no_of_deliverd=0  THEN 5
                        ELSE 6
                    END) AS rank,
                    (CASE
                        WHEN report_zajil.NoFD=no_of_deliverd THEN 2
                        WHEN not(no_of_deliverd=0 or no_of_deliverd is null) and report_zajil.NoFD>no_of_deliverd THEN 2
                        WHEN not(no_of_deliverd=0 or no_of_deliverd is null) and report_zajil.NoFD<no_of_deliverd THEN 1
                        WHEN no_of_deliverd=0  THEN 2
                        ELSE 6
                    END) AS approve
                from report_zajil
                inner join drivers on upper(drivers.fullName)=upper(report_zajil.name)
                left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date . "'
                    )report_zajil on report_zajil.driverId=packages_report.driverId
                    set
                    packages_report.No_of_D=report_zajil.NoFD,
                    packages_report.Total_OFD=report_zajil.Total_OFD,
                    packages_report.packageStatusId=report_zajil.rank,
                    packages_report.approveStatusId=2
                where pakage_date ='" . $pakage_date . "' and approveStatusId=1");
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/import_excel_zajil')->with('error', $e->getPrevious()->getMessage());
            }

            DB::insert("insert into packages_report(driverId,attendence,pakage_date,packageStatusId,approveStatusId,updated_usertypeid,No_of_D,Total_OFD,created_at,updated_at,unit_cost)
            select drivers.id ,0,'" . $pakage_date . "',6,2,2,report_zajil.NoFD,report_zajil.Total_OFD,'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "',
            CASE DAYNAME('" . $pakage_date . "')
        WHEN 'Saturday' THEN warehouse.Saturday
        WHEN 'Sunday' THEN warehouse.Sunday
        WHEN 'Monday' THEN warehouse.Monday
        WHEN 'Tuesday' THEN warehouse.Tuesday
        WHEN 'Wednesday' THEN warehouse.Wednesday
        WHEN 'Thursday' THEN warehouse.Thursday
        WHEN 'Friday' THEN warehouse.Friday
        END unit_cost
            from report_zajil
            inner join drivers on upper(drivers.fullName)=upper(report_zajil.name)
            inner join warehouse on warehouse.id=drivers.warehouseId
            left join packages_report on packages_report.driverId=drivers.id and packages_report.pakage_date='" . $pakage_date . "'
            where packages_report.driverId is null");

            $password = bcrypt('123456');
            $job_id = 0;

            $Emp_id = collect(DB::select("select max(TRIM(substr(job_id,6))+0) as job_id from drivers
                inner join warehouse on warehouse.id=drivers.warehouseId where companyId=6
            and job_id like 'zajil%'"))->first();


            //$job_id= substr($Emp_id->job_id,5,strlen($Emp_id->job_id) - 1)+1;
            $job_id = $Emp_id->job_id + 1;
            //return  $job_id;


            $Drivers = DB::select("select Location,name,NoFD,Total_OFD
            from report_zajil where upper(report_zajil.name) not in(select upper(drivers.fullName) from drivers
                inner join warehouse on warehouse.id=drivers.warehouseId where companyId=6)");
            $i = 0;
            foreach ($Drivers as $Driver) {

                $warehouse = collect(DB::select("Select id from warehouse where excel_name='" . $Driver->Location . "'"))->first();


                if (empty($warehouse->id)) {

                    $city = collect(DB::select("Select id from lkp_city where name_en='" . $Driver->Location . "'"))->first();
                    if (empty($city->id)) {
                        $city_id = DB::table('lkp_city')->insertGetId(['name_en' => $Driver->Location, 'name_ar' => $Driver->Location]);
                    } else {
                        $city_id = $city->id;
                    }

                    $warehouse_id = DB::table('warehouse')->insertGetId([
                        'warehouseName' => $Driver->Location,
                        'companyId' => '6',
                        'cityId' => $city_id,
                        'excel_name' => $Driver->Location,
                        'Saturday' => '10',
                        'Sunday' => '10',
                        'Monday' => '10',
                        'Tuesday' => '10',
                        'Wednesday' => '10',
                        'Thursday' => '10',
                        'Friday' => '10',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                } else {
                    $warehouse_id = $warehouse->id;
                }


                $driverId = DB::table('drivers')->insertGetId([
                    'warehouseId' => $warehouse_id,
                    'fullName' => $Driver->name,
                    'email_id' => '-',
                    'job_id' => 'zajil' . $job_id,
                    'status_id' => '1',
                    'password' => $password,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);

                $job_id++;

                $dayname = \DateTime::createFromFormat('Y-m-d', $pakage_date)->format('l');
                $day = DB::select("SELECT " . $dayname . " as dayunitcost from drivers
            inner join warehouse on warehouse.id=drivers.warehouseId
            where drivers.id=" . $driverId)[0];


                DB::insert("
            insert into packages_report(driverId,attendence,pakage_date,packageStatusId,approveStatusId,updated_usertypeid,
            No_of_D,Total_OFD,created_at,updated_at,unit_cost)
            values(" . $driverId . ",0,'" . $pakage_date . "',7,2,1," . $Driver->NoFD . "," . $Driver->Total_OFD . ",
            '" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "','" . $day->dayunitcost . "')
            ");
            }


            try {
                DB::insert("insert into journal (driverId,journal_date,debit,note,journal_type_id,post_id,
                createdby_id,updatedby_id,created_at,updated_at,credit)

        select driverId,pakage_date,null,null,6,id," . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "' as created_at,'" . date("Y-m-d H:i:s") . "' as updated_at,
        CASE calculation_method_id
                WHEN 1     THEN CostBy_no_of_touch_point
                WHEN 2     THEN CostBy_no_of_deliverd
                END amount
        from(
        select packages_report.id,packages_report.driverId,calculation_method_id,
        pakage_date,
        CASE DAYNAME(pakage_date)
                WHEN 'Saturday'  THEN warehouse.Saturday
                WHEN 'Sunday'    THEN warehouse.Sunday
                WHEN 'Monday'    THEN warehouse.Monday
                WHEN 'Tuesday'   THEN warehouse.Tuesday
                WHEN 'Wednesday' THEN warehouse.Wednesday
                WHEN 'Thursday'  THEN warehouse.Thursday
                WHEN 'Friday'    THEN warehouse.Friday
                end * No_of_D CostBy_no_of_deliverd,
        CASE DAYNAME(pakage_date)
                WHEN 'Saturday'  THEN warehouse.Saturday
                WHEN 'Sunday'    THEN warehouse.Sunday
                WHEN 'Monday'    THEN warehouse.Monday
                WHEN 'Tuesday'   THEN warehouse.Tuesday
                WHEN 'Wednesday' THEN warehouse.Wednesday
                WHEN 'Thursday'  THEN warehouse.Thursday
                WHEN 'Friday'    THEN warehouse.Friday
                end * No_of_TP CostBy_no_of_touch_point
        from packages_report
        inner join drivers on drivers.id=packages_report.driverId
        inner join warehouse on warehouse.id=drivers.warehouseId
        inner join lkp_company on lkp_company.id=warehouse.companyId
        where pakage_date ='" . $pakage_date . "'
        and companyId=6
        and packages_report.journal_id is null
        and packages_report.approveStatusId=2
        )a
            ");
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/import_excel_zajil')->with('error', $e->getPrevious()->getMessage());
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
                return redirect('/import_excel_zajil')->with('error', $e->getPrevious()->getMessage());
            }
            //******************************************************************************************************************
            //******************************************************************************************************************
            //******************************************************************************************************************
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
