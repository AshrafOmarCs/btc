<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;
use Auth;
use App\Vehicle;
use App\Temporary;
use App\Delegation;
use App\Drivers;
use App\Assign_vehicle;
use App\RequestModal;
use App\Vehicle_checkUp_utlitie;
use App\VehicleCheckup;
use Illuminate\Http\Request;
use DB;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Writer_Excel2007;
use Carbon\Carbon;


class VehiclesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function VehicleReport(Request $request) {
        $date = $request->date;
        $type = $request->type;
        $toDay = date("Y-m-d");

        $cities = DB::select("SELECT DISTINCT city_id, lkp_city.name_en  FROM vehicles JOIN lkp_city on vehicles.city_id = lkp_city.id");
        $rowCount = 2;
        $total_avl = $total_mnt = $total_dam = $total_del = 0;
        $html = '';
        if ($date == $toDay) {
            $table = "vehicles";
            $column = "current_status";
            $date_clause = "";
            $checkup_clause = " AND checkup_id is NULL";
        } else {
            $table = "drivers_attendance";
            $column = "status";
            $date_clause = " AND date = '$date'";
            $checkup_clause = "";
        }
        foreach ($cities as $city) {
            $city_id = $city->city_id;

            $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column = 'maintenance' $date_clause");
            $maint_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;

            $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column = 'availabe' $checkup_clause $date_clause");
            $avail_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;

            $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column = 'damaged'  $date_clause"); //$checkup_clause
            $dam_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;
            if ($date == $toDay) {
                $delg_vehicles = DB::select("SELECT count(vehicles.id) AS veh_count FROM vehicles INNER JOIN delegations ON vehicles.checkup_id=delegations.checkup_id WHERE current_status NOT IN ('damaged', 'maintenance') AND delegations.status = 'valid' AND city_id = '$city_id'");
                $delg_count = !empty($delg_vehicles) ? $delg_vehicles[0]->veh_count : 0;
                $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column NOT IN ('maintenance', 'damaged')");
                $avail_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;
                $avail_count = $avail_count - $delg_count;

                // $delg_vehicles = DB::select("SELECT count(vehicles.id) AS veh_count FROM vehicles INNER JOIN delegations ON vehicles.checkup_id=delegations.checkup_id WHERE current_status !='damaged' AND delegations.status = 'valid' AND city_id = '$city_id'");
                // $delg_count = !empty($delg_vehicles) ? $delg_vehicles[0]->veh_count : 0;

            } else {
                $delg_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' and status in ('absent with no excuse', 'present', 'missed attendance') $date_clause");
                $delg_count = !empty($delg_vehicles) ? $delg_vehicles[0]->veh_count : 0;
            }
            $total_avl += $avail_count;
            $total_mnt += $maint_count;
            $total_dam += $dam_count;
            $total_del += $delg_count;
            $total = $avail_count + $maint_count + $dam_count + $delg_count;
            $html .= "<tr>
            <td>".$city->name_en."</td>
            <td>".$avail_count."</td>
            <td>".$maint_count."</td>
            <td>".$dam_count."</td>
            <td>".$delg_count."</td>
            <td>".$total."</td>
            </tr>";
        }
        $total = $total_avl + $total_mnt + $total_dam + $total_del;
        $html .= "<tr style='background-color: #7CCBDC;'>
            <td>Total</td>
            <td>".$total_avl."</td>
            <td>".$total_mnt."</td>
            <td>".$total_dam."</td>
            <td>".$total_del."</td>
            <td>".$total."</td>
            </tr>";
        echo $html;
    }
    public function download_vehicles_report(Request $request)
    {
        $date = $request->date;
        $type = $request->type;
        $toDay = date("Y-m-d");
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'City')
            ->setCellValueExplicit('B1', 'Available')
            ->setCellValueExplicit('C1', 'Maintenance')
            ->setCellValueExplicit('D1', 'Damaged')
            ->setCellValueExplicit('E1', 'Delegated')
            ->setCellValueExplicit('F1', 'Total');

        // $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(37.89);
        // $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);


        $cities = DB::select("SELECT DISTINCT city_id, lkp_city.name_en  FROM vehicles JOIN lkp_city on vehicles.city_id = lkp_city.id");
        $total_avl = $total_mnt = $total_dam = $total_del = 0;
        $table = $toDay == $date ? "vehicles" : "drivers_attendance";
        $column = $toDay == $date ? "current_status" : "status";
        $date_clause = $toDay == $date ? "" : " AND date = '$date'";
        $checkup_clause = $toDay == $date ? " AND checkup_id is NULL" : "";

        // if ($toDay == $date) {
        //     $table = "vehicles";
        //     $column = "current_status";
        //     $date_clause = "";
        //     $checkup_clause = " AND checkup_id is NULL";
        // } else {
        //     $table = "drivers_attendance";
        //     $column = "status";
        //     $date_clause = " AND date = '$date'";
        //     $checkup_clause = "";
        // }
        $rowCount = 2;
        foreach ($cities as $city) {
            $city_id = $city->city_id;

            $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column = 'maintenance' $date_clause");
            $maint_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;

            $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column = 'availabe' $checkup_clause $date_clause");
            $avail_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;

            $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column = 'damaged' $checkup_clause $date_clause");
            $dam_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;
            if ($date == $toDay) {
                $delg_vehicles = DB::select("SELECT count(vehicles.id) AS veh_count FROM vehicles INNER JOIN delegations ON vehicles.checkup_id=delegations.checkup_id WHERE current_status NOT IN ('damaged', 'maintenance') AND delegations.status = 'valid' AND city_id = '$city_id'");
                $delg_count = !empty($delg_vehicles) ? $delg_vehicles[0]->veh_count : 0;

                $count_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' AND $column NOT IN ('maintenance', 'damaged')");
                $avail_count = !empty($count_vehicles) ? $count_vehicles[0]->veh_count : 0;
                $avail_count = $avail_count - $delg_count;
            } else {
                $delg_vehicles = DB::select("SELECT count(id) as veh_count from $table WHERE city_id = '$city_id' and status in ('absent with no excuse', 'present', 'missed attendance') $date_clause");
                $delg_count = !empty($delg_vehicles) ? $delg_vehicles[0]->veh_count : 0;
            }
            $total_avl += $avail_count;
            $total_mnt += $maint_count;
            $total_dam += $dam_count;
            $total_del += $delg_count;

            $objPHPExcel->setActiveSheetIndex(0)
                ->SetCellValue('A' . $rowCount, $city->name_en)
                ->SetCellValue('B' . $rowCount, $avail_count)
                ->SetCellValue('C' . $rowCount, $maint_count)
                ->SetCellValue('D' . $rowCount, $dam_count)
                ->SetCellValue('E' . $rowCount, $delg_count)
                ->SetCellValue('F' . $rowCount, $avail_count + $maint_count + $dam_count + $delg_count);
            $rowCount++;
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->SetCellValue('A' . $rowCount, 'Total')
                ->SetCellValue('B' . $rowCount, $total_avl)
                ->SetCellValue('C' . $rowCount, $total_mnt)
                ->SetCellValue('D' . $rowCount, $total_dam)
                ->SetCellValue('E' . $rowCount, $total_del)
                ->SetCellValue('F' . $rowCount, $total_avl + $total_mnt + $total_dam + $total_del);

        $objPHPExcel->setActiveSheetIndex(0);
        $date = date("Y-m-d H-i-s");
        $fileName = 'Vehicle Report_' . $date . '-' . Auth::user()->id . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    public function download_vehicles_report_old(Request $request)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Available')
            ->setCellValueExplicit('H1', 'Maintenance')
            ->setCellValueExplicit('Q1', 'Delegated')
            ->setCellValueExplicit('A2', 'City')
            ->setCellValueExplicit('B2', 'Count')

            ->setCellValueExplicit('H2', 'City')
            ->setCellValueExplicit('I2', 'Count')

            ->setCellValueExplicit('P2', 'City')
            ->setCellValueExplicit('Q2', 'Warehouse')
            ->setCellValueExplicit('R2', 'Count')
            ;

        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);


        DB::statement('SET SESSION group_concat_max_len = 5555555');
        $Select_db = DB::select("SELECT lkp_city.name_en,COUNT(vehicles.id) as vehicles_count FROM vehicles INNER JOIN lkp_city ON vehicles.city_id=lkp_city.id WHERE current_status='availabe' GROUP BY lkp_city.name_en");
        $rowCount = 3;
        foreach ($Select_db as $Select_dbdb) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->SetCellValue('A' . $rowCount, $Select_dbdb->name_en)
                ->SetCellValue('B' . $rowCount, $Select_dbdb->vehicles_count);
            $rowCount++;
        }
        $Select_db = DB::select("SELECT lkp_city.name_en,COUNT(vehicles.id) as vehicles_count FROM vehicles INNER JOIN lkp_city ON vehicles.city_id=lkp_city.id WHERE current_status='maintenance' or maintenance_status = 1 GROUP BY lkp_city.name_en");
        $rowCount = 3;
        foreach ($Select_db as $Select_dbdb) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->SetCellValue('H' . $rowCount, $Select_dbdb->name_en)
                ->SetCellValue('I' . $rowCount, $Select_dbdb->vehicles_count);
            $rowCount++;
        }
        $Select_db = DB::select("SELECT * from warehouse order by warehouseName");
        $rowCount = 3;
        foreach ($Select_db as $Select_dbdb) {
            $warehouse_id = $Select_dbdb->id;
            $result = DB::select("SELECT lkp_city.name_en,warehouse.warehouseName,count(drivers.vehicle_id) AS vehicles_count FROM lkp_city INNER JOIN warehouse ON lkp_city.id=warehouse.cityId INNER JOIN drivers ON drivers.warehouseId=warehouse.id INNER JOIN vehicles ON drivers.vehicle_id=vehicles.id WHERE warehouse.id='$warehouse_id' AND maintenance_status IS NULL");
            if ($result[0]->vehicles_count > 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->SetCellValue('P' . $rowCount, $result[0]->name_en)
                    ->SetCellValue('Q' . $rowCount, $result[0]->warehouseName)
                    ->SetCellValue('R' . $rowCount, $result[0]->vehicles_count);
                $rowCount++;
            }
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $date = date("Y-m-d H-i-s");
        $fileName = 'Vehicle Report_' . $date . '-' . Auth::user()->id . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }


    public function report_index()
    {
        $user_id = Auth::user()->id;
        if (Auth::user()->user_type_id <> 1) {
            $lkp_company  = DB::select("SELECT distinct lkp_company.id,lkp_company.companyName FROM `users_privilege` JOIN warehouse ON warehouse.id = users_privilege.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE users_privilege.user_id = '$user_id' AND lkp_company.id <> 6 AND lkp_company.status = 'active'");
        } else {
            $lkp_company  = DB::select("SELECT id, companyName FROM `lkp_company` WHERE lkp_company.id <> 6 AND lkp_company.status = 'active'");
        }
        $lkp_city  = DB::select("SELECT * FROM `lkp_city`");

        $vehicles  = DB::select("SELECT id, plate FROM `vehicles` order by plate");
        return view('vehicles.report')->with('lkp_company', $lkp_company)->with('lkp_city', $lkp_city)->with('vehicles', $vehicles);

    }
    function report_search(Request $request) {
        $company_id = $request->filter_companyId;
        $warehouse_id = $request->filter_warehouseId;
        $city_id = $request->filter_cityId;

        $type = $request->filter_type;
        $vehicle_id = $request->filter_vehicleId;
        $current_status = $request->filter_status;
        $str = explode("/", $request->filter_date); //just to split start date and end date from string
        $start_date = $str[0];
        $end_date = $str[1];
        $dateArray = array();
        $currentDate = strtotime($start_date);
        $endDate = strtotime($end_date);
        while ($currentDate <= $endDate) {
            $dateArray[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }
        $response = make_header($dateArray);
        $response .= ':::';
        $body_response = make_body($dateArray, $city_id, $company_id, $warehouse_id, $type, $vehicle_id, $current_status, $type);
        $response .= $body_response[0];
        $response .= ':::';
        $response .= $body_response[1];

        return $response;
    }

    public function edit_vehicle(Request $request)
    {

        $vehicle = DB::select("SELECT * FROM vehicles where `id` = '$request->vehicle_id'");
        $vehicle_models = DB::select("SELECT * FROM vehicle_models");
        if($vehicle[0]->current_status == 'availabe')
            $vehicle_opreators = DB::select("SELECT * FROM vehicle_opreators");
        else
            $vehicle_opreators = DB::select("SELECT * FROM vehicle_opreators WHERE id <> '5'");

        $cities = DB::select("SELECT * FROM lkp_city");
        $maintenance_statuses = DB::select("SELECT * FROM lkp_vehicles_maintenance");
        $companies = DB::select("SELECT * FROM lkp_company WHERE rent_check = 1 AND status = 'active'");

        return view('new_porttal.vehicles.vehicle_edit')->with('vehicle', $vehicle)->with('vehicle_models', $vehicle_models)->with('vehicle_opreators', $vehicle_opreators)
        ->with('cities', $cities)->with('maintenance_statuses', $maintenance_statuses)->with('companies', $companies);

    }
    public function update_vehicle(Request $request)
    {
        $otometer = $extraOtometerCharge = $freeExtraOtometer = $checkup_id = $amount_of_endurance = NULL;
        $columns = "";
        $maintenance_location_clause = "maintenance_location = '$request->maintenance_location'";

        if ($request->otometer != ''){
            $columns .= ", otometer = '$request->otometer'";
        }
        if ($request->extraOtometerCharge != ''){
            $columns .= ", extraOtometerCharge = '$request->extraOtometerCharge'";

        }
        if ($request->freeExtraOtometer != ''){
            $columns .= ", freeExtraOtometer = '$request->freeExtraOtometer'";

        }
        if ($request->checkup_id != ''){
            $columns .= ", checkup_id = '$request->checkup_id'";

        }
        if ($request->amount_of_endurance != ''){
            $columns .= ", amount_of_endurance = '$request->amount_of_endurance'";
        }
        $columns .= ", allowed_fuel_price = ''";
        if ($request->allowed_fuel_price != ''){
            $columns .= ", allowed_fuel_price = '$request->allowed_fuel_price'";
        }
        $user_id = Auth::user()->id;

        $maintenance_status = 'maintenance_status = NULL';
        if ($request->maintenance_status != '')
            $maintenance_status = "maintenance_status = '$request->maintenance_status'";
        else
            $maintenance_location_clause = "maintenance_location = ''";
        $current_status = "";
        if (!empty($request->current_status))
            $current_status = ",current_status = '$request->current_status'";
        $vehicle_expiry_date = '';
        if (!empty($request->vehicle_expiry_date))
            $vehicle_expiry_date = ",vehicle_expiry_date = '$request->vehicle_expiry_date'";
        if ($request->current_status == 'availabe' || $request->current_status == 'damaged')
            $maintenance_location_clause = "maintenance_location = ''";


        DB::update("UPDATE vehicles set fuel_tag = '$request->fuel_tag', rent_type = '$request->rent_type', rent_individual = '$request->rent_individual', rent_company_id = '$request->rent_company_id', plate = '$request->plate' $columns,registertion_type = '$request->registertion_type', vehicle_model_id = '$request->vehicle_model_id',
        vehicle_opreater_id = '$request->vehicle_opreater_id',SNno = '$request->SNno', city_id = '$request->city_id',
        body_number = '$request->body_number',color = '$request->color',insurance_type = '$request->insurance_type', feulType = '$request->feulType',
         vehicle_registration_expire_date = '$request->vehicle_registration_expire_date', recive_date = '$request->recive_date'
        $current_status $vehicle_expiry_date, $maintenance_location_clause, $maintenance_status, updated_by = '$user_id', updated_at = NOW() where `id` = '$request->vehicle_id'");
        $vehicle = DB::select("SELECT * FROM vehicles where `id` = '$request->vehicle_id'");
        $vehicle_models = DB::select("SELECT * FROM vehicle_models");
        $vehicle_opreators = DB::select("SELECT * FROM vehicle_opreators");
        $cities = DB::select("SELECT * FROM lkp_city");
        $maintenance_statuses = DB::select("SELECT * FROM lkp_vehicles_maintenance");
        $companies = DB::select("SELECT * FROM lkp_company WHERE rent_check = 1 AND status = 'active'");


        return view('new_porttal.vehicles.vehicle_edit')->with('vehicle', $vehicle)->with('vehicle_models', $vehicle_models)->with('vehicle_opreators', $vehicle_opreators)
        ->with('cities', $cities)->with('maintenance_statuses', $maintenance_statuses)->with('companies', $companies)->with('success', 'Updated successfully');
    }

    public function index($city_name = null, $type = null, $companyName = null, $warehouseName = null)
    {
        # code...
        $company_clause = $warehouse_clause = '';
        $today = new DateTime(); // Current date
        $toDay = date("Y-m-d");

        $utilities = "SELECT * FROM `utilities`";
        $cities = DB::select("SELECT * FROM lkp_city");
        $manufacturers = DB::select("SELECT * FROM vehicle_manufacturers");
        $models = DB::select("SELECT * FROM vehicle_models order by manufacturer_date, name_en");
        $operators = DB::select("SELECT * FROM vehicle_opreators");
        $companies = DB::select("SELECT * FROM lkp_company WHERE status = 'active'");
        if($type == 'done_attendance' || $type == 'pending_attendance' || $type == 'present' || $type == 'absent_ex' || $type == 'absent_no_ex')
        {
            $company_clause = "AND lkp_company.companyName = '$companyName'";
            $warehouse_clause = "AND warehouse.warehouseName = '$warehouseName'";
        }


        $utilities = DB::select($utilities);
        $vehicleIds = $vehicles = array();
        $where = "";
        if ($type == 'available') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'availabe' AND vehicles.vehicle_opreater_id <> 5 AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'rented') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.vehicle_opreater_id = 5 AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'done_attendance') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE drivers_attendance.date='$toDay' AND lkp_city.name_en = '$city_name' $company_clause $warehouse_clause");

        } else if ($type == 'pending_attendance') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE lkp_city.name_en = '$city_name' $company_clause $warehouse_clause AND vehicles.id NOT IN (SELECT vehicle_id FROM drivers_attendance WHERE date = '$toDay')");

        } else if ($type == 'present') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE lkp_city.name_en = '$city_name' $company_clause $warehouse_clause AND drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'present'");

        } else if ($type == 'absent_ex') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'absent with excuse' AND lkp_city.name_en = '$city_name' $company_clause $warehouse_clause");

        } else if ($type == 'absent_no_ex') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'absent with no excuse' AND lkp_city.name_en = '$city_name' $company_clause $warehouse_clause");

        } else if ($type == 'maintenance') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'maintenance' OR vehicles.maintenance_status is not null AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'maintenance_') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.maintenance_status is not null AND lkp_city.name_en = '$city_name' ");

        } else if ($type == 'damaged') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'damaged' AND lkp_city.name_en = '$city_name'");

        }
        if(count($vehicles) > 0) {
            foreach ($vehicles as $vehicle) {
                $vehicleIds[] = $vehicle->id;
            }
            $where = " where vehicles.id in(" . implode(",", $vehicleIds) . ")";
        }
        $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.rent_type, vehicles.rent_company_id, vehicles.rent_individual, vehicles.maintenance_location,
        vehicles.vehicle_expiry_date, vehicle_models.name_en as 'vehicle_model',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer',vehicles.plate,
        vehicles.checkup_id,vehicles.id as 'vehicle_id',vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,
        vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en as 'vehicle_opreator' FROM `vehicles`
                JOIN vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
                JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
                JOIN lkp_city ON lkp_city.id = vehicles.city_id
                JOIN vehicle_opreators ON vehicle_opreators.id = vehicles.vehicle_opreater_id $where";
        // $payload = DB::select($sql);
        if(count($vehicles) > 0) {
            $payload = DB::select($sql);
            // $payload = DB::table(DB::raw("($sql) as subquery"));
        } else
            $payload = DB::table(DB::raw("($sql) as subquery"))->paginate(10);
        foreach ($payload as $key => $item) {
            # code...
            $item->CheckUpStatus = '';
            $query = "SELECT vehicle_utilities.id as 'vehicles_urility_id',vehicle_utilities.vehicle_id,vehicle_utilities.utlity_condition,utilities.name_en FROM `vehicle_utilities` JOIN utilities on utilities.id = vehicle_utilities.utlity_id WHERE vehicle_utilities.vehicle_id =".$item->vehicle_id." ";
            $query = DB::select($query);
            $html ='';
            if(count($query)>0){
                foreach($query as $item2){
                    if(!empty($item2->name_en)){
                        $html = $html." <li>".$item2->name_en."| <span style='color: #0017ff;font-weight: bold;'>".$item2->utlity_condition."</span></li>";
                    }
                }
                $html = $html. ' <button class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"  onclick="editAccessories('.$item->vehicle_id.')">Edit <i class="fa fa-pencil"></i> </button>';
                $item->vehicle_utilities = $query;
                $item->vehicle_utilities_html = $html;
            }else{
                $html = $html. ' <button class="btnaction btn menu-icon vd_bd-blue vd_blue" onclick="editAccessories('.$item->vehicle_id.')">Add Accessories </button>';
                $item->vehicle_utilities = NULL;
                $item->vehicle_utilities_html = $html;
            }
            // if($item->checkup_id == ''){
            if ('' == '') {
                $item->images = '';
            }else{
                $sql = "SELECT vehicle_checks.*,users.name as 'uploadedBy' FROM `vehicle_checks` JOIN users ON users.id = vehicle_checks.created_by WHERE vehicle_id =".$item->vehicle_id." ORDER BY `vehicle_checks`.`created_at` DESC ";
                $sql = DB::select($sql);

                if($sql[0]->created_by_type == 'suppervisor'){
                    $suppervisor = DB::select("select * from users where id=".$sql[0]->created_by."");
                    if(count($suppervisor)>0){
                        $suppervisor =  $suppervisor[0]->name.'<br> <span style="font-size: 10px; font-weight: bold;"> (Suppervisor) <span>';
                        $sql[0]->uploadedBy = $suppervisor;
                    }
                }else{
                    $driver = "SELECT * FROM `drivers` where id =".$sql[0]->created_by." ";
                    $driver = DB::select($driver);
                    if(count($driver)>0){
                        $driver =  'DA: '.$driver[0]->fullName;
                        $sql[0]->uploadedBy = $driver;
                    }
                }
                if($sql[0]->admin_approve_by != ''){
                    $approvedBy = DB::select("select * from users where id =".$sql[0]->admin_approve_by." ");
                    if(count($approvedBy)>0){
                        $sql[0]->ApprovedBy = 'BTC-S: '.$approvedBy[0]->name;
                    }else{
                        $sql[0]->ApprovedBy = 'Pending';
                    }
                }else{
                    $sql[0]->ApprovedBy = 'Pending';
                }
                $sql[0]->created_by;
                $item->images = $sql[0];

            }
            if ($item->vehicle_expiry_date != '') {
                $item->expiry_days = HelperFunctionsController::today_to_future($item->vehicle_expiry_date);
            } else {
                $item->expiry_days = 0;
            }
            $delegation_info = get_vehicle_info($item->vehicle_id);
            $item->delegation_info = $delegation_info;
            $fuel_data = get_fuel_details($item->vehicle_id, $item->allowed_fuel_price, $item->fuel_check);
            $item->fuel_data = $fuel_data;
            $check_oil = DB::select("select * from vehicles_oil where status is null AND vehicle_id = ".$item->vehicle_id);
            $item->oil_data = '';
            if (count($check_oil) == 0)
                $item->oil_data = '';
            else if (count($check_oil) > 1 && $item->oil_check != 1)
                $item->oil_data = '<button style="color: black !important; background-color: red;" class="btnaction btn menu-icon vd_bd-red vd_red" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button>';
            else
                $item->oil_data = '<button class="btnaction btn menu-icon vd_bd-yellow vd_yellow" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button>';
        }
        // $vehicle = Vehicle::where('','')->get();
        if(count($vehicles) > 0 OR $city_name != '')
            return view('vehicles.new_index',compact('payload','utilities', 'cities', 'operators', 'manufacturers', 'models', 'operators', 'companies'));
        else
            return view('new_porttal.vehicles.index',compact('payload','utilities', 'cities', 'operators', 'manufacturers', 'models', 'operators', 'companies'));
    }
    // public function utilities(Request $request)
    // {
    //     dd($request);
    // }
    public function search(Request $request)
    {
        $toDay = date("Y-m-d");
        $today = new DateTime(); // Current date
        $city_id = $request->filter_cityId;
        $company_id = $request->filter_companyId;
        $warehouse_id = $request->filter_warehouseId;
        $type = $request->type;
        $status = $request->filter_status;
        $delegation_status = $request->filter_delegation;
        $vehicle_opreater_id = $request->filter_vehicle_opreaterId;
        $filter_vehicle_manufecturerId = $request->filter_vehicle_manufecturerId;
        $filter_modelId = $request->filter_modelId;
        $filter_otometer = $request->filter_otometer;
        $filter_otometer_value = $request->filter_otometer_value;

        $city_name = $request->city_name;
        $type = $request->type;

        $company_clause = "";
        if (!empty($request->filter_companyId)) {
            $company_clause = 'AND lkp_company.id in (' . implode(",", $request->filter_companyId) .')';
        }
        $warehouse_clause = "";
        if (!empty($request->filter_warehouseId)) {
            $warehouse_clause = 'AND warehouse.id in (' . implode(",", $request->filter_warehouseId) .')';
        }

        $city_clause = "";
        if ($city_id > 0)
            $city_clause = "AND vehicles.city_id = $city_id";
        $status_clause = "";
        // if ($status == 'maintenance')
        //     $status_clause = "AND (vehicles.current_status = '$status' OR vehicles.maintenance_status = '1')";
        if ($status != '')
            $status_clause = "AND vehicles.current_status = '$status'";
        $delegation_clause = "";
        if ($delegation_status == '1')
            $delegation_clause = "AND delegations.status = 'valid'";
        else if ($delegation_status == '0') {
            $IDs = DB::select("SELECT GROUP_CONCAT(vehicle_id) as vehicles FROM `delegations` WHERE `status` = 'valid'");
            $delegation_clause = "AND vehicles.id NOT IN (".$IDs[0]->vehicles.")";
        }
        $operator_clause = "";
        if ($vehicle_opreater_id > 0)
            $operator_clause = "AND vehicles.vehicle_opreater_id = $vehicle_opreater_id";


        $manufecturer_clause = "";
        if (!empty($filter_vehicle_manufecturerId)) {
            $manufecturer_clause = 'AND vehicle_models.vehicle_manufacturer_id in (' . implode(",", $filter_vehicle_manufecturerId) .')';
        }
        $model_clause = "";
        if (!empty($filter_modelId)) {
            $model_clause = 'AND vehicles.vehicle_model_id in (' . implode(",", $filter_modelId) .')';
        }

        $otometer_clause = "";
        if ($filter_otometer != '' AND $filter_otometer_value != '')
            $otometer_clause = "AND vehicles.otometer $filter_otometer $filter_otometer_value";


        $vehicleIds = $vehicles = array();
        $AND = "";
        if ($type == 'available') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'availabe' AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'done_attendance') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'pending_attendance') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id WHERE lkp_city.name_en = '$city_name' AND vehicles.id NOT IN (SELECT vehicle_id FROM drivers_attendance WHERE date = '$toDay')");

        } else if ($type == 'present') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'present'");

        } else if ($type == 'absent_ex') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'absent with excuse' AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'absent_no_ex') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'absent with no excuse' AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'maintenance') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'maintenance' AND lkp_city.name_en = '$city_name'");

        } else if ($type == 'damaged') {
            $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'damaged' AND lkp_city.name_en = '$city_name'");

        }
        if(count($vehicles) > 0) {
            foreach ($vehicles as $vehicle) {
                $vehicleIds[] = $vehicle->id;
            }
            $AND = " AND vehicles.id in(" . implode(",", $vehicleIds) . ")";
        }
        if ($company_id > 0) {
            $sql = "SELECT delegations.`status` AS delegation_status,ending_date,vehicles.oil_check,vehicles.allowed_fuel_price,vehicles.fuel_check,vehicles.vehicle_expiry_date,
            vehicles.maintenance_location,vehicle_models.name_en AS vehicle_model,vehicle_models.manufacturer_date,vehicle_manufacturers.name_en AS vehicle_manufacturer,
            vehicles.plate,vehicles.checkup_id,vehicles.id AS vehicle_id,vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,
            vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,
            vehicle_opreators.name_en AS vehicle_opreator FROM vehicles JOIN vehicle_models ON vehicle_models.id=vehicles.vehicle_model_id
            JOIN vehicle_manufacturers ON vehicle_manufacturers.id=vehicle_models.vehicle_manufacturer_id JOIN lkp_city ON lkp_city.id=vehicles.city_id
            JOIN vehicle_opreators ON vehicle_opreators.id=vehicles.vehicle_opreater_id LEFT JOIN delegations ON delegations.checkup_id=vehicles.checkup_id INNER
            JOIN drivers ON delegations.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id
                WHERE 1 = 1 $company_clause $warehouse_clause $city_clause $AND $status_clause $delegation_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause";
        } else {
            $sql = "SELECT delegations.status as delegation_status, ending_date, vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.vehicle_expiry_date,
            vehicles.maintenance_location, vehicle_models.name_en as 'vehicle_model',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer',vehicles.plate,
            vehicles.checkup_id,vehicles.id as 'vehicle_id',vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,
            vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en as 'vehicle_opreator' FROM `vehicles`
            JOIN vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
            JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
            JOIN lkp_city ON lkp_city.id = vehicles.city_id
            JOIN vehicle_opreators ON vehicle_opreators.id = vehicles.vehicle_opreater_id
            Left Join delegations on delegations.checkup_id = vehicles.checkup_id
                WHERE 1 = 1 $city_clause $AND $status_clause $delegation_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause";
        }
        $payload = DB::select($sql);
        $totalData = count($payload);

        // $columns = ['no', 'plate', 'fuel_data', 'oil_data', 'vehicle_expiry_date', 'name_en', 'vehicle_manufacturer', 'vehicle_model', 'vehicle_opreator', 'color', 'vehicle_registration_expire_date', 'vehicle_utilities_html', 'otometer', 'registertion_type', 'current_status', 'delegation_status', 'maintenance_location', 'response1', 'response2'];
        $columns = ['no', 'plate', 'name_en', 'vehicle_manufacturer', 'vehicle_model', 'vehicle_opreator', 'color', 'otometer', 'registertion_type', 'current_status', 'delegation_status', 'response1', 'response2'];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $search = $request->input('search.value');
        if (!empty($search)) {
            $sql .= " AND delegations.status LIKE '%$search%' OR plate LIKE '%$search%' OR vehicle_expiry_date LIKE '%$search%' OR vehicle_manufacturers.name_en LIKE '%$search%' OR vehicle_models.name_en LIKE '%$search%' OR vehicle_opreators.name_en LIKE '%$search%'
            OR color LIKE '%$search%' OR vehicle_registration_expire_date LIKE '%$search%' OR otometer LIKE '%$search%' OR registertion_type LIKE '%$search%' OR current_status LIKE '%$search%' OR maintenance_location LIKE '%$search%' ORDER BY vehicles.id $dir LIMIT $start, $limit";
            $payload = DB::select($sql);
            $totalFiltered = count($payload);
        } else {
            $totalFiltered = $totalData;
            $sql .= " ORDER BY $order $dir LIMIT $start, $limit";
            $payload = DB::select($sql);
        }
        foreach ($payload as $key => $item) {
            $item->CheckUpStatus = '';
            $query = "SELECT vehicle_utilities.id as 'vehicles_urility_id',vehicle_utilities.vehicle_id,vehicle_utilities.utlity_condition,utilities.name_en FROM `vehicle_utilities` JOIN utilities on utilities.id = vehicle_utilities.utlity_id WHERE vehicle_utilities.vehicle_id =".$item->vehicle_id." ";
            $query = DB::select($query);

            if (count($query) > 0) {
                $item->vehicle_utilities = $query;
            } else {
                $item->vehicle_utilities = NULL;
            }
            if ($item->checkup_id == '') {
                $item->images = '';
            } else {
                $sql = "SELECT vehicle_checks.* FROM `vehicle_checks` WHERE id =".$item->checkup_id." ORDER BY `vehicle_checks`.`created_at` DESC ";
                $sql = DB::select($sql);
                $item->images = $sql[0]->left_image . ':::';
                $item->images .= $sql[0]->right_image . ':::';
                $item->images .= $sql[0]->rear_image . ':::';
                $item->images .= $sql[0]->front_image . ':::';
                $item->images .= $sql[0]->drivingWheel_image;
            }
            if ($item->ending_date != '') {
                $days = $item->expiry_days = HelperFunctionsController::today_to_future($item->ending_date);
                $item->expiry_days = $days + 1;
            } else {
                $item->expiry_days = '';
            }
            $delegation_info = get_vehicle_info($item->vehicle_id);
            $item->delegation_info = $delegation_info;
            $fuel_data = get_fuel_details($item->vehicle_id, $item->allowed_fuel_price, $item->fuel_check);
            $item->fuel_data = $fuel_data;
            $check_oil = DB::select("select * from vehicles_oil where status is null AND vehicle_id = ".$item->vehicle_id);
            $item->oil_data = '';
            if (count($check_oil) == 0)
                $item->oil_data = '';
            else if (count($check_oil) > 1 && $item->oil_check != 1) {
                $item->oil_data = '<button style="color: black !important; background-color: red;" class="btnaction btn menu-icon vd_bd-red vd_red" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
            } else {
                $item->oil_data = '<button class="btnaction btn menu-icon vd_bd-yellow vd_yellow" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
            }
            if ($item->delegation_status == 'valid' AND $toDay < $item->ending_date) {
            } else {
                $underProcess = DB::select("SELECT requests.vehicle_id FROM assign_vehicles INNER JOIN requests ON assign_vehicles.checkup_id=requests.vehicle_check_id WHERE assign_vehicles.`status` NOT IN ('done','finished') AND requests.vehicle_id = " . $item->vehicle_id);
                if (count($underProcess) > 0) {
                    $item->delegation_status = 'Under Process';
                }
            }

        }
        $response = array();

        $response = get_vehicle_table_body($payload, $city_name);
        $jsonResponse = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $response,
        ];

        return response()->json($jsonResponse);
    }

    public function vehicleInfo(Request $request) {
        $plate = $request->plate;
        $vehile = DB::select("SELECT ending_date from vehicles join delegations ON delegations.vehicle_id = vehicles.id where plate = '$plate' and delegations.status = 'valid'");
        $total_utility = $maintenance_days = $working_days = $total = $days = "N/A";
        if (count($vehile) > 0) {
            $days = HelperFunctionsController::today_to_future($vehile[0]->ending_date) . ' days';
        }
        echo $days . ':::';
        $vehile = DB::select("SELECT ending_date from vehicles join delegations ON delegations.vehicle_id = vehicles.id where plate = '$plate'");
        if (count($vehile) > 0)
            $total = count($vehile);
        echo $total . ':::';
        $vehile = DB::select("SELECT vehicles.id from vehicles join drivers_attendance ON drivers_attendance.vehicle_id = vehicles.id where plate = '$plate' AND drivers_attendance.status = 'present'");
        if (count($vehile) > 0)
            $working_days = count($vehile);
        echo $working_days . ':::';
        $vehile = DB::select("SELECT vehicles.id from vehicles join drivers_attendance ON drivers_attendance.vehicle_id = vehicles.id where plate = '$plate' AND drivers_attendance.status = 'maintenance'");
        if (count($vehile) > 0)
            $maintenance_days = count($vehile);
        echo $maintenance_days . ':::';
        $vehile = DB::select("SELECT vehicles.id from vehicles join vehicle_utilities ON vehicle_utilities.vehicle_id = vehicles.id where plate = '$plate'");
        if (count($vehile) > 0)
            $total_utility = count($vehile);
        echo $total_utility . ':::';


    }
    public function historyVehicle(Request $request) {
        $vehicle_id = $request->vehicle_id;
        $delegations = DB::select("SELECT DATE_FORMAT(starting_date, '%Y-%m') AS `year_month`, COUNT(*) AS del_count FROM delegations WHERE vehicle_id = ? GROUP BY `year_month` ORDER BY `year_month` ", [$vehicle_id]);

        foreach ($delegations as $delegation) {
            $date = $delegation->year_month;
            $drivers = DB::select("SELECT COUNT(DISTINCT driverId) AS driver_count FROM delegations WHERE vehicle_id = ? AND DATE_FORMAT(starting_date, '%Y-%m') = ?", [$vehicle_id, $date]);
            $delegation->driver_count = $drivers[0]->driver_count ?? 0;
            $firstDay = Carbon::parse($date . '-01')->startOfMonth()->toDateString();
            $lastDay = Carbon::parse($date . '-01')->endOfMonth()->toDateString();
            $delegation->firstDay = $firstDay;
            $delegation->lastDay = $lastDay;
        }

        return view('new_porttal.vehicles.historyVehicle')->with('results', $delegations)->with('vehicle_id', $vehicle_id);
    }
    public function historyVehicleDrivers(Request $request) {
        $vehicle_id = $request->vehicle_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $delegations = DB::select("SELECT drivers.fullName,drivers.job_id,delegations.starting_date,delegations.ending_date FROM delegations INNER JOIN drivers ON delegations.driverId=drivers.id
        WHERE starting_date BETWEEN '$start_date' AND '$end_date' AND delegations.vehicle_id='$vehicle_id' ORDER BY delegations.id DESC");
        $html = '<table id="customer_data" class="table table-bordered table-striped table-responsive"><thead><th>Name</th><th>Job ID</th><th>Delegation Start</th><th>Delegation Finish</th></thead><tbody>';
        $check = true;
        foreach ($delegations as $delegation) {
            $star = '';
            if($check == true)
                $star = '<i title="current delegation" class="fa fa-star" style="color: green;"></i>';
            $check = false;
            $html .= "<tr>";
            $html .= "<td>$star $delegation->fullName</td>";
            $html .= "<td>$delegation->job_id</td>";
            $html .= "<td>$delegation->starting_date</td>";
            $html .= "<td>$delegation->ending_date</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";
        return $html;
    }


    public function delegatedVehicles(Request $request)
    {
        $toDay = date("Y-m-d");
        if (!request()->ajax()) {
            $utilities = "SELECT * FROM `utilities`";
            $cities = DB::select("SELECT * FROM lkp_city");
            $manufacturers = DB::select("SELECT * FROM vehicle_manufacturers");
            $models = DB::select("SELECT * FROM vehicle_models order by manufacturer_date, name_en");
            $operators = DB::select("SELECT * FROM vehicle_opreators");
            $companies = DB::select("SELECT * FROM lkp_company WHERE status = 'active'");
            return view('new_porttal.vehicles.delegatedVehicles',compact('utilities', 'cities', 'operators', 'manufacturers', 'models', 'companies'));
        }
        $Select_db = DB::table('delegations')
        ->select('delegations.id', 'delegations.vehicle_id', 'delegations.checkup_id', 'delegations.status', 'delegations.returning_checkup_id', 'delegations.reference_no', 'delegations.starting_date',
        'delegations.ending_date', 'drivers.fullName', 'drivers.iqama', 'drivers.mobileNumber', 'vehicles.plate', 'warehouse.warehouseName', 'lkp_city.name_en')
        ->join('vehicle_checks', 'delegations.checkup_id', '=', 'vehicle_checks.id')
        ->join('vehicles', 'vehicles.checkup_id', '=', 'vehicle_checks.id')
        ->join('vehicle_models', 'vehicles.vehicle_model_id', '=', 'vehicle_models.id')
        ->join('drivers', 'delegations.driverId', '=', 'drivers.id')
        ->join('warehouse', 'drivers.warehouseId', '=', 'warehouse.id')
        ->join('lkp_company', 'lkp_company.id', '=', 'warehouse.companyId')
        ->join('lkp_city', 'warehouse.cityId', '=', 'lkp_city.id');
        // $Select_db->whereRaw("ending_date >= '$toDay'");
        $Select_db->whereRaw("delegations.status = 'valid'");

        if ($request->delegation_status == 'expired') {
            $Select_db->whereRaw("ending_date < '$toDay'");
        } else if ($request->delegation_status == 'valid')
            $Select_db->whereRaw("ending_date >= '$toDay'");
        if ($request->filter_companyId > 0) {
            $Select_db->whereRaw("lkp_company.id = " . $request->filter_companyId);
        }
        if ($request->filter_warehouseId > 0) {
            $Select_db->whereRaw("warehouse.id = " . $request->filter_warehouseId);
        }
        if ($request->filter_cityId > 0) {
            $Select_db->whereRaw("lkp_city.id = " . $request->filter_cityId);
        }
        if ($request->filter_vehicle_opreaterId > 0) {
            $Select_db->whereRaw("vehicles.vehicle_opreater_id = " . $request->filter_vehicle_opreaterId);
        }
        if ($request->filter_modelId > 0) {
            $Select_db->whereRaw("vehicles.vehicle_model_id = " . $request->filter_modelId);
        }
        if ($request->filter_vehicle_manufecturerId > 0) {
            $Select_db->whereRaw("vehicle_models.vehicle_manufacturer_id = " . $request->filter_vehicle_manufecturerId);
        }
        $filter_otometer = $request->filter_otometer;
        $filter_otometer_value = $request->filter_otometer_value;

        if ($filter_otometer != '' AND $filter_otometer_value != '') {
            $Select_db->whereRaw("vehicles.otometer $filter_otometer $filter_otometer_value");
        }
        $sql = $Select_db->toSql();
        $payload = DB::select($sql);
        $totalData = count($payload);

        $columns = ['delegations.id', 'plate', 'delegations.reference_no', 'reference_no', 'name_en', 'warehouseName', 'fullName', 'iqama', 'iqama', 'mobileNumber', 'starting_date', 'delegations.ending_date', 'ending_date', 'delegations.status'];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $search = $request->input('search.value');
        if (!empty($search)) {
            $sql .= " AND plate LIKE '%$search%' OR reference_no LIKE '%$search%' OR lkp_city.name_en LIKE '%$search%' OR warehouseName LIKE '%$search%' OR fullName LIKE '%$search%'
            OR iqama LIKE '%$search%' OR mobileNumber LIKE '%$search%' OR starting_date LIKE '%$search%' OR ending_date LIKE '%$search%'";
            $payload = DB::select($sql);
            $totalFiltered = count($payload);
            $sql .= " ORDER BY delegations.id $dir LIMIT $start, $limit";
            $payload = DB::select($sql);
        } else {
            $totalFiltered = $totalData;
            // dd($sql);
            $sql .= " ORDER BY $order $dir LIMIT $start, $limit";
            $payload = DB::select($sql);
        }

        $response = array();
        $response = get_delegated_table_body($payload);
        $jsonResponse = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $response,
        ];
        return response()->json($jsonResponse);
    }

    public function updateDelegation(Request $request) {
        $id = $request->id;
        $ref_no = $request->ref_no;
        $iqama = $request->iqama;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        // $delegation = DB::select("SELECT * from delegations join drivers ON delegations.driverId = drivers.id WHERE delegations.id = '$id'");
        // $iqama = $delegation[0]->iqama;
        // $ending_date = $delegation[0]->ending_date;
        // $tmm_delegation = DB::select("SELECT * from tbl_tmm_delegation WHERE iqama = '$iqama' AND end_date = '$ending_date'");
        // $start_date = $tmm_delegation[0]->start_date;
        // $tm_reference_no = $tmm_delegation[0]->reference_no;

        $delegation = DB::select("SELECT reference_no, starting_date, ending_date, iqama, job_id from delegations join drivers ON delegations.driverId = drivers.id WHERE delegations.id = '$id'");
        $dIqama = $delegation[0]->iqama;
        $job_id = $delegation[0]->job_id;
        $made_by = Auth::user()->name;
        if ($dIqama != $iqama) {
            DB::update("UPDATE drivers set iqama = '$iqama' WHERE job_id = '$job_id'");
            $action = "<b>$made_by</b> updated driver iqama from : " . $dIqama . " to " . $iqama . ", ";
            HelperFunctionsController::add_log($action, '', $job_id);
        }
        $action = "<b>$made_by</b> updated delegation with these changes: ";
        if ($delegation[0]->reference_no != $ref_no)
            $action .= "reference_no from : " . $delegation[0]->reference_no . " to " . $ref_no . ", ";
        if ($delegation[0]->starting_date != $start_date)
            $action .= "starting_date from : " . $delegation[0]->starting_date . " to " . $start_date . ", ";
        if ($delegation[0]->ending_date != $end_date)
            $action .= "ending_date from : " . $delegation[0]->ending_date . " to " . $end_date . ", ";
        $chk = DB::update("UPDATE delegations set reference_no = '$ref_no', starting_date = '$start_date', ending_date = '$end_date' WHERE id = '$id'");
        if($chk) {
            HelperFunctionsController::add_log($action, '', $id);
            return back()->with('success', 'Data updated successfully');
        } else
            return back()->with('error', 'Something went wrong');
    }

    public function getImages(Request $request) {
        $check_id = $request->id;
        $rear_image = $left_image = $right_image = $drivingWheel_image = $front_image = asset('images/no_imag.jpg');
        $images = DB::select("SELECT * from vehicle_checks WHERE id = '$check_id'");
        if (count($images) > 0) {
            $rear_image = $images[0]->rear_image;
            $left_image = $images[0]->left_image;
            $right_image = $images[0]->right_image;
            $drivingWheel_image = $images[0]->drivingWheel_image;
            $front_image = $images[0]->front_image;
        }
        return "<tr>
            <td>
                Front-side
            </td>
             <td>
                <img style='cursor: pointer; width: 200px' onclick='imageModal(this)' src=".url($front_image).">
            </td>
            <td>
                Back-side
            </td>
             <td>
                <img style='cursor: pointer; width: 200px' onclick='imageModal(this)' src=".url($rear_image).">
            </td>
        </tr>
        <tr>
            <td>
                Left-side
            </td>
             <td>
                <img style='cursor: pointer; width: 200px' onclick='imageModal(this)' src=".url($left_image).">
            </td>
            <td>
                Right-side
            </td>
             <td>
                <img style='cursor: pointer; width: 200px' onclick='imageModal(this)' src=".url($right_image).">
            </td>
        </tr>
        <tr>
            <td>
                Interior Image
            </td>
             <td>
                <img style='cursor: pointer; width: 200px' onclick='imageModal(this)' src=".url($drivingWheel_image).">
            </td>
        </tr>";
    }

    // public function search_old(Request $request)
    // {
    //     $toDay = date("Y-m-d");
    //     $today = new DateTime(); // Current date
    //     $city_id = $request->filter_cityId;
    //     $company_id = $request->filter_companyId;
    //     $warehouse_id = $request->filter_warehouseId;
    //     $type = $request->type;
    //     $status = $request->filter_status;
    //     $vehicle_opreater_id = $request->filter_vehicle_opreaterId;
    //     $filter_vehicle_manufecturerId = $request->filter_vehicle_manufecturerId;
    //     $filter_modelId = $request->filter_modelId;
    //     $filter_otometer = $request->filter_otometer;
    //     $filter_otometer_value = $request->filter_otometer_value;

    //     $city_name = $request->city_name;
    //     $type = $request->type;

    //     $company_clause = "";
    //     if ($company_id > 0)
    //         $company_clause = "AND lkp_company.id = $company_id";
    //     $warehouse_clause = "";
    //     if ($warehouse_id > 0)
    //         $warehouse_clause = "AND warehouse.id = $warehouse_id";

    //     $city_clause = "";
    //     if ($city_id > 0)
    //         $city_clause = "AND vehicles.city_id = $city_id";
    //     $status_clause = "";
    //     if ($status != '')
    //         $status_clause = "AND vehicles.current_status = '$status'";
    //     if ($status == 'maintenance')
    //         $status_clause = "AND (vehicles.current_status = '$status' OR vehicles.maintenance_status = '1')";
    //     $operator_clause = "";
    //     if ($vehicle_opreater_id > 0)
    //         $operator_clause = "AND vehicles.vehicle_opreater_id = $vehicle_opreater_id";


    //     $manufecturer_clause = "";
    //     if ($filter_vehicle_manufecturerId > 0)
    //         $manufecturer_clause = "AND vehicle_models.vehicle_manufacturer_id = $filter_vehicle_manufecturerId";
    //     $model_clause = "";
    //     if ($filter_modelId > 0)
    //         $model_clause = "AND vehicles.vehicle_model_id = $filter_modelId";
    //     $otometer_clause = "";
    //     if ($filter_otometer != '' AND $filter_otometer_value != '')
    //         $otometer_clause = "AND vehicles.otometer $filter_otometer $filter_otometer_value";


    //     $vehicleIds = $vehicles = array();
    //     $AND = "";
    //     if ($type == 'available') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'availabe' AND lkp_city.name_en = '$city_name'");

    //     } else if ($type == 'done_attendance') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' AND lkp_city.name_en = '$city_name'");

    //     } else if ($type == 'pending_attendance') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id WHERE lkp_city.name_en = '$city_name' AND vehicles.id NOT IN (SELECT vehicle_id FROM drivers_attendance WHERE date = '$toDay')");

    //     } else if ($type == 'present') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'present'");

    //     } else if ($type == 'absent_ex') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'absent with excuse' AND lkp_city.name_en = '$city_name'");

    //     } else if ($type == 'absent_no_ex') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN drivers_attendance ON vehicles.id=drivers_attendance.vehicle_id WHERE drivers_attendance.date='$toDay' and drivers_attendance.`status` = 'absent with no excuse' AND lkp_city.name_en = '$city_name'");

    //     } else if ($type == 'maintenance') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'maintenance' AND lkp_city.name_en = '$city_name'");

    //     } else if ($type == 'damaged') {
    //         $vehicles = DB::select("SELECT vehicles.id FROM lkp_city JOIN vehicles ON lkp_city.id=vehicles.city_id WHERE vehicles.current_status = 'damaged' AND lkp_city.name_en = '$city_name'");

    //     }
    //     if(count($vehicles) > 0) {
    //         foreach ($vehicles as $vehicle) {
    //             $vehicleIds[] = $vehicle->id;
    //         }
    //         $AND = " AND vehicles.id in(" . implode(",", $vehicleIds) . ")";
    //     }
    //     if ($company_id > 0) {
    //         $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.vehicle_expiry_date,vehicles.maintenance_location,vehicle_models.name_en AS vehicle_model,vehicle_models.manufacturer_date,vehicle_manufacturers.name_en AS vehicle_manufacturer,vehicles.plate,vehicles.checkup_id,vehicles.id AS vehicle_id,vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,
            // vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en AS vehicle_opreator FROM vehicles
            // JOIN vehicle_models ON vehicle_models.id=vehicles.vehicle_model_id JOIN vehicle_manufacturers ON vehicle_manufacturers.id=vehicle_models.vehicle_manufacturer_id JOIN lkp_city ON lkp_city.id=vehicles.city_id JOIN vehicle_opreators ON vehicle_opreators.id=vehicles.vehicle_opreater_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id
    //             WHERE 1 = 1 $company_clause $warehouse_clause $city_clause $AND $status_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause";
    //     } else {
    //         $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.vehicle_expiry_date, vehicles.maintenance_location, vehicle_models.name_en as 'vehicle_model',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer',vehicles.plate,vehicles.checkup_id,vehicles.id as 'vehicle_id',vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,
                // vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en as 'vehicle_opreator' FROM `vehicles`
    //                 JOIN vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
    //                 JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
    //                 JOIN lkp_city ON lkp_city.id = vehicles.city_id
    //                 JOIN vehicle_opreators ON vehicle_opreators.id = vehicles.vehicle_opreater_id
    //                 WHERE 1 = 1 $city_clause $AND $status_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause order by vehicles.id";
    //     }
    //     $payload = DB::select($sql);
    //     foreach ($payload as $key => $item) {
    //         $item->CheckUpStatus = '';
    //         $query = "SELECT vehicle_utilities.id as 'vehicles_urility_id',vehicle_utilities.vehicle_id,vehicle_utilities.utlity_condition,utilities.name_en FROM `vehicle_utilities` JOIN utilities on utilities.id = vehicle_utilities.utlity_id WHERE vehicle_utilities.vehicle_id =".$item->vehicle_id." ";
    //         $query = DB::select($query);
    //         $html ='';
    //         if(count($query)>0){
    //             foreach($query as $item2){
    //                 if(!empty($item2->name_en)){
    //                     $html = $html." <li>".$item2->name_en."| <span style='color: #0017ff;font-weight: bold;'>".$item2->utlity_condition."</span></li>";
    //                 }
    //             }
    //             $html = $html. ' <button class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"  onclick="editAccessories('.$item->vehicle_id.')">Edit <i class="fa fa-pencil"></i> </button>';
    //             $item->vehicle_utilities = $query;
    //             $item->vehicle_utilities_html = $html;
    //         }else{
    //             $html = $html. ' <button class="btnaction btn menu-icon vd_bd-blue vd_blue" onclick="editAccessories('.$item->vehicle_id.')">Add Accessories </button>';
    //             $item->vehicle_utilities = NULL;
    //             $item->vehicle_utilities_html = $html;
    //         }
    //         if($item->checkup_id == ''){
    //             $item->images = '';
    //         }else{
    //             $sql = "SELECT vehicle_checks.*,users.name as 'uploadedBy' FROM `vehicle_checks` JOIN users ON users.id = vehicle_checks.created_by WHERE vehicle_id =".$item->vehicle_id." ORDER BY `vehicle_checks`.`created_at` DESC ";
    //             $sql = DB::select($sql);

    //             if($sql[0]->created_by_type == 'suppervisor'){
    //                 $suppervisor = DB::select("select * from users where id=".$sql[0]->created_by."");
    //                 if(count($suppervisor)>0){
    //                     $suppervisor =  $suppervisor[0]->name.'<br> <span style="font-size: 10px; font-weight: bold;"> (Suppervisor) <span>';
    //                     $sql[0]->uploadedBy = $suppervisor;
    //                 }
    //             }else{
    //                 $driver = "SELECT * FROM `drivers` where id =".$sql[0]->created_by." ";
    //                 $driver = DB::select($driver);
    //                 if(count($driver)>0){
    //                     $driver =  'DA: '.$driver[0]->fullName;
    //                     $sql[0]->uploadedBy = $driver;
    //                 }
    //             }
    //             if($sql[0]->admin_approve_by != ''){
    //                 $approvedBy = DB::select("select * from users where id =".$sql[0]->admin_approve_by." ");
    //                 if(count($approvedBy)>0){
    //                     $sql[0]->ApprovedBy = 'BTC-S: '.$approvedBy[0]->name;
    //                 }else{
    //                     $sql[0]->ApprovedBy = 'Pending';
    //                 }
    //             }else{
    //                 $sql[0]->ApprovedBy = 'Pending';
    //             }
    //             $sql[0]->created_by;
    //             $item->images = $sql[0];
    //         }
    //         if ($item->vehicle_expiry_date != '') {
    //         $date1 = new DateTime($item->vehicle_expiry_date);
    //         $interval = $date1->diff($today);
    //         $days = $interval->format('%a');
    //         $item->expiry_days = $days;
    //         } else {
    //             $item->expiry_days = 0;
    //         }
    //         $delegation_info = get_vehicle_info($item->vehicle_id);
    //         $item->delegation_info = $delegation_info;
    //         $fuel_data = get_fuel_details($item->vehicle_id, $item->allowed_fuel_price, $item->fuel_check);
    //         $item->fuel_data = $fuel_data;
    //         $check_oil = DB::select("select * from vehicles_oil where status is null AND vehicle_id = ".$item->vehicle_id);
    //         $item->oil_data = '';
    //         if (count($check_oil) == 0)
    //             $item->oil_data = '';
    //         else if (count($check_oil) > 1 && $item->oil_check != 1) {
    //             $item->oil_data = '<button style="color: black !important; background-color: red;" class="btnaction btn menu-icon vd_bd-red vd_red" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
    //         } else {
    //             $item->oil_data = '<button class="btnaction btn menu-icon vd_bd-yellow vd_yellow" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
    //         }
    //     }
    //     $response = get_vehicle_table_body_old($payload, $city_name);
    //     return $response;
    // }
    public function utilitiesUpdate(Request $request) {
        $user_id = Auth::user()->id;
        $vehicleId = $request->vehicle_id;
        $utilities = DB::select("SELECT * From utilities");
        foreach($utilities as $utility) {
            $utlity_id = $utility->id;
            if(isset($request->$utlity_id) AND $request->$utlity_id != '') {
                $utlity_condition = $request->$utlity_id;
                $check = DB::select("SELECT vehicle_id from vehicle_utilities WHERE vehicle_id = '$vehicleId' AND utlity_id = '$utlity_id'");
                if(count($check) > 0)
                    DB::update("UPDATE vehicle_utilities set utlity_condition = '$utlity_condition' , updated_at = NOW(), updated_by = '$user_id' WHERE vehicle_id = '$vehicleId' AND utlity_id = '$utlity_id'");
                else
                    DB::insert("INSERT into vehicle_utilities (vehicle_id, utlity_id, utlity_condition, created_at, created_by) VALUES ('$vehicleId', '$utlity_id', '$utlity_condition', NOW(), '$user_id')");
            }
        }
        return redirect()->back()->with('success', 'Vehicle utilities updated successfully');
    }
    public function utilities(Request $request)
    {
        # code...
        // dd($request->all());
        // get all utlities and v.utlities
        $payload = array();
        $vehicleId = $request->vehcile_id;
        $utilities = DB::select("SELECT * From utilities");
        $response = '<div class="row">';
        foreach($utilities as $utility) {
            $utility_id = $utility->id;
            $vehicle_utility = DB::select("SELECT * From vehicle_utilities WHERE utlity_id = '$utility_id' AND vehicle_id='$vehicleId'");

            $response .= '<div class="col-lg-6">
                            <b>'.$utility->name_en.'</b><br>';
                            // dd(gettype($utility->category));
                            foreach(json_decode($utility->category) as $category) {
                                $checked = '';
                                if(isset($vehicle_utility[0]->utlity_condition) AND $category == $vehicle_utility[0]->utlity_condition)
                                    $checked = 'checked';
                                $response .= '<label class="radio-inline">
                                  <input type="radio" name="'.$utility->id.'" '.$checked.' value="'.$category.'">'.$category.'
                                </label>';
                            }
                            $response .= '
                        </div>';
        }
        $response .= '</div>';
        return $response;

        $vUtilities = "SELECT `utlity_id` FROM `vehicle_utilities` WHERE `vehicle_id`=".$request->vehcile_id." ";

        $vUtilities = DB::select($vUtilities);
        $whereNotIn = '';

        foreach ($vUtilities as $key => $value) {
            # code...
            if($key == 0){
                $whereNotIn =  ''.$value->utlity_id;
            }else{
                $whereNotIn =  $whereNotIn.','.$value->utlity_id;
            }
        }
        $utlity = "SELECT * FROM `utilities` WHERE id NOT IN (".$whereNotIn.")";
        $utlity = DB::select($utlity);
        $categories = json_decode($utlity[0]->category);
        foreach($utlity as $utlity12){
            $payload[] = [
                'name'=>$utlity12->name,
                'name_en'=>$utlity12->name_en,
                'conditions'=>json_decode($utlity12->category),
                'selected'=>NULL
            ];
        }
        // dd($payload);

        $sighnedUtlity = "SELECT vehicle_utilities.id,vehicle_utilities.utlity_id,vehicle_utilities.vehicle_id,utilities.name_en,utilities.name,vehicle_utilities.utlity_condition,utilities.category FROM `vehicle_utilities` JOIN utilities ON utilities.id = vehicle_utilities.utlity_id WHERE vehicle_utilities.vehicle_id  in (".$whereNotIn.")";
        $sighnedUtlity = DB::select($sighnedUtlity);
        foreach ($sighnedUtlity as $key => $sighned) {
            # code...
            $payload[] = [
                'name'=>$sighned->name,
                'name_en'=>$sighned->name_en,
                'conditions'=>json_decode($sighned->category),
                'selected'=>$sighned->utlity_condition
            ];

        }
        $htmls = "";
        dd($payload);
    }
    public function vaildate_checkup(Request $request)
    {
        # code...
        // dd($request->all());
        $images_array = [
            'front'=>'',
            'rear'=>'',
            'left'=>'',
            'right'=>'',
            'interior'=>'',
        ];

        if(isset($request->left)){
            $images_array['left'] = $this->handleImages($request->left,$request->serialNumber,'left');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle left side Image is Required ']);
        }
        if(isset($request->right)){
            $images_array['right'] = $this->handleImages($request->right,$request->serialNumber,'right');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Right side Image is Required ']);
        }
        if(isset($request->rear)){
            $images_array['rear'] = $this->handleImages($request->rear,$request->serialNumber,'rear');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Rear side Image is Required ']);
        }
        if(isset($request->front)){
            $images_array['front'] = $this->handleImages($request->front,$request->serialNumber,'front');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Front side Image is Required ']);
        }
        if(isset($request->interior)){
            $images_array['interior'] = $this->handleImages($request->interior,$request->serialNumber,'interior');
        }else{
            return redirect()->back()->withErrors(['msg' => 'The Vehicle Interior Image is Required ']);
        }

        $Vehicle_checks = VehicleCheckup::create([
            'left_image'=>$images_array['left'],
            'right_image'=>$images_array['right'],
            'rear_image'=>$images_array['rear'],
            'front_image'=>$images_array['front'],
            'drivingWheel_image'=>$images_array['interior'],
            'otometer'=>$request->otometerRead,
            'vehicle_id'=>$request->vehicle_id,
            'delegation_type'=>$request->delegationType,
            'created_by'=>Auth::user()->id,
        ]);
        $vehicle = Vehicle::where('id',$request->vehicle_id)->get();
        $vehicle =$vehicle->first();
        $vehicle->checkup_id = $Vehicle_checks->id;
        $vehicle->save();
        return redirect('Vehicles/vehicle-checkup-utilities/'.$Vehicle_checks->id);
    }
    public function handleImages($data,$serialNumber,$side)
    {
        # code...
            $file = $data;
            $tep = new Temporary();
            $safeName = 'vehicle_'.$serialNumber.'_'.$side.'_'.date("Y-m-d").'.'.$data->extension();
            $fileSaved = \Storage::put('public/vehicales/'.$serialNumber.'/'.$safeName,\File::get($file));
            if($fileSaved == true){
                $tep->path ='/storage/vehicales/'.$serialNumber.'/'.$safeName;
                $tep->journal_date = date("Y-m-d"); // '2022-03-20';;
                // $tep->journal_period = $request->journal_period; // '2022-03-20';;
                $tep->save();
                return $tep->path;
            }else{
            }
    }
    public function vehicle_checkup_utilities($vehicle_id)
    {
        # code...
        $VehicleCheckup = VehicleCheckup::where('id',$vehicle_id)->get();
        $VehicleCheckup = $VehicleCheckup->first();
        $sql = "SELECT * FROM `utilities`";
        $response = DB::select($sql);
        $vehicle = "SELECT * FROM `vehicles` WHERE id = ".$VehicleCheckup->vehicle_id."";
        $vehicle = DB::select($vehicle);
        // dd($vehicle);
        if(count($vehicle)>0){
            $vehicle = $vehicle[0];
        }else{
            $vehicle = NULL;
        }
        return view('vehicles.vehicleCheckupUtility',compact('response','vehicle','VehicleCheckup'));

    }
    public function ValidateUtlity(Request $request)
    {
        # code...
        // dd($request->vehicle_id);
        if($request->has('VU00')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU00'";
            $utlity = DB::select($utlity);
            $utlity_id = $utlity[0]->id;
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00;
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query);

        }
        if($request->has('VU01')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU01'";
            $utlity = DB::select($utlity);
            $utlity_id = $utlity[0]->id;
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00;
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query);
        }
        if($request->has('VU02')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU02'";
            $utlity = DB::select($utlity);
            $utlity_id = $utlity[0]->id;
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00;
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query);
        }
        if($request->has('VU03')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU03'";
            $utlity = DB::select($utlity);
            $utlity_id = $utlity[0]->id;
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00;
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query);
        }
        if($request->has('VU05')){
            $utlity = "SELECT * FROM `utilities` WHERE `code` = 'VU05'";
            $utlity = DB::select($utlity);
            $utlity_id = $utlity[0]->id;
            $checkup_id = $request->checkup_id;
            $condition = $request->VU00;
            $query = "INSERT INTO `vehicle_utilities`( `vehicle_id`, `utlity_id`, `utlity_condition`,created_by) VALUES (".$request->vehicle_id.",".$utlity_id.",'".$condition."',".Auth::user()->id.")";
            $query = DB::select($query);
        }
        return redirect('Vehicles');
    }
    public function vehicle_requests()
    {
        # code...
        $companies = DB::select("SELECT * FROM lkp_company WHERE id != 6 AND status = 'active'");
        $rTypes = DB::select("SELECT * FROM request_types");
        $cities = DB::select("SELECT DISTINCT city_id, lkp_city.name_en  FROM vehicles JOIN lkp_city on vehicles.city_id = lkp_city.id");

        $sql = "SELECT requests.id as 'requests_id', requests.status,requests.created_at as 'request_issue_date',requests.created_by,requests.supporvisor_identity_approve,
        requests.vehicle_check_id,request_types.name_en,vehicles.*,vehicle_checks.admin_approve_by,vehicle_models.name_en as 'vName',vehicle_models.manufacturer_date,
        vehicle_manufacturers.name_en as 'vehicle_manufacturer_name',lkp_city.name_en as 'city_name',vehicle_opreators.name_en as 'opreatoers',drivers.fullName,drivers.job_id,
        drivers.id as 'driver_id',drivers.driver_data, assign_vehicles.id as assignId, assign_vehicles.note, assign_vehicles.status as 'assiment_status' FROM `requests`
            JOIN request_types on request_types.id = requests.request_type_id
            JOIN vehicles ON vehicles.id = requests.vehicle_id
            JOIN vehicle_checks on vehicle_checks.id = requests.vehicle_check_id
            join vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
            JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
            join lkp_city on lkp_city.id = vehicles.city_id
            JOIN vehicle_opreators on vehicle_opreators.id = vehicles.vehicle_opreater_id
            JOIN drivers on drivers.id = requests.driverId
            JOIN assign_vehicles ON assign_vehicles.checkup_id = requests.vehicle_check_id
            WHERE assign_vehicles.status NOT IN ('done', 'finished')
            ";
        $payload = DB::select($sql);

        if(count($payload)>0){
            foreach($payload as $k=>$item){
                $images = '';
                if ($item->checkup_id > 0) {
                    $sql = "SELECT vehicle_checks.* FROM `vehicle_checks` WHERE id =".$item->checkup_id;
                    $sql = DB::select($sql);
                    $images = $sql[0]->left_image . ':::';
                    $images .= $sql[0]->right_image . ':::';
                    $images .= $sql[0]->rear_image . ':::';
                    $images .= $sql[0]->front_image . ':::';
                    $images .= $sql[0]->drivingWheel_image;
                }
                $created_by = $item->driver_id;
                $companySql = DB::select("SELECT warehouse.companyId FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id WHERE drivers.id='$created_by'");
                if(count($companySql) > 0)
                    $item->createdCompanyId = $companySql[0]->companyId;
                else
                    $item->createdCompanyId = 1;
                $item->vehicleExtraInfo = '<a onclick="vehicleExtraInfo('."'".$images."'".",'".$item->plate."','".$item->name_en."','".$item->vehicle_manufacturer_name."','".$item->manufacturer_date."','".$item->vName."','".$item->opreatoers."','".$item->SNno."','".$item->body_number."','".$item->freeExtraOtometer."','','".$item->extraOtometerCharge."','".$item->otometer."','".$item->registertion_type."','".$item->current_status."','".$item->color."','".$item->vehicle_registration_expire_date."')".'"
                data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';

                if($item->supporvisor_identity_approve == 0){
                } else {
                    // dd($item->supporvisor_identity_approve);
                }
                $checkIfRejected = Vehicle_checkUp_utlitie::where([
                    ['vehicle_check_id',$item->vehicle_check_id]
                    ,['approval','rejected']
                    ])->get();

                if(count($checkIfRejected)>0){
                    // has been rejected
                    $item->urlityAbpprovalStatus = 'Rejected';
                }else{
                    $item->urlityAbpprovalStatus = 'Pending';
                }
                // supporvisor_identity_approve
            }
        }
        // dd($payload);
        return view('vehicles.requestCentral',compact('payload', 'companies', 'rTypes', 'cities'));
    }
    public function searchRequest(Request $request) {
        $company_clause = "";
        if (!empty($request->filter_companyId)) {
            $company_clause = 'AND lkp_company.id = ' . $request->filter_companyId;
        }
        $warehouse_clause = "";
        if (!empty($request->filter_warehouseId)) {
            $warehouse_clause = 'AND warehouse.id = ' . $request->filter_warehouseId;
        }
        $city_id = $request->filter_cityId;
        $city_clause = "";
        if ($city_id > 0) {
            $city_clause = "AND vehicles.city_id = $city_id";
        }
        $job_id = $request->filter_job_id;
        $jobId_clause = "";
        if ($job_id != '') {
            $jobId_clause = "AND drivers.job_id = '$job_id'";
        }

        $status_id = $request->filter_status_id;
        $status_clause = "";
        if ($status_id != '') {
            $status_clause = "AND assign_vehicles.status = '$status_id'";
        }
        $request_type = $request->filter_request_id;
        $request_clause = "";
        if ($request_type != '') {
            $request_clause = "AND request_types.id = '$request_type'";
        }

        $sql = "SELECT requests.id as 'requests_id', requests.status,requests.created_at as 'request_issue_date',requests.created_by,requests.supporvisor_identity_approve,requests.vehicle_check_id,
        request_types.name_en,vehicles.*,vehicle_checks.admin_approve_by,vehicle_models.name_en as 'vName',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer_name',
        lkp_city.name_en as 'city_name',vehicle_opreators.name_en as 'opreatoers',drivers.fullName,drivers.job_id,drivers.id as 'driver_id',drivers.driver_data, assign_vehicles.id as assignId, assign_vehicles.note, assign_vehicles.status as 'assiment_status' FROM `requests`
            JOIN request_types on request_types.id = requests.request_type_id
            JOIN vehicles ON vehicles.id = requests.vehicle_id
            JOIN vehicle_checks on vehicle_checks.id = requests.vehicle_check_id
            join vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
            JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
            join lkp_city on lkp_city.id = vehicles.city_id
            JOIN vehicle_opreators on vehicle_opreators.id = vehicles.vehicle_opreater_id
            JOIN drivers on drivers.id = requests.driverId
			JOIN warehouse on drivers.warehouseId = warehouse.id
			JOIN lkp_company on warehouse.companyId = lkp_company.id
            JOIN assign_vehicles ON assign_vehicles.checkup_id = requests.vehicle_check_id
            WHERE 1 = 1 $company_clause $warehouse_clause $city_clause $jobId_clause $status_clause $request_clause";
        $payload = DB::select($sql);

        if (count($payload) > 0) {
            foreach ($payload as $k => $item) {
                if ($item->supporvisor_identity_approve == 0) {
                } else {
                    // dd($item->supporvisor_identity_approve);
                }
                $checkIfRejected = Vehicle_checkUp_utlitie::where([
                    ['vehicle_check_id',$item->vehicle_check_id]
                    ,['approval','rejected']
                    ])->get();

                if (count($checkIfRejected) > 0) {
                    // has been rejected
                    $item->urlityAbpprovalStatus = 'Rejected';
                } else {
                    $item->urlityAbpprovalStatus = 'Pending';
                }
                // supporvisor_identity_approve
            }
            return get_vRequest_tblBody($payload);
        }
        return '<tr><td colspan="12"><center>No Record Found!</center></td></tr>';
    }
    public function saveNote(Request $request) {
        $assignId = $request->assignId;
        $note = $request->note;
        $chk = DB::update("UPDATE assign_vehicles set note = '$note' WHERE id = '$assignId'");
        if($chk)
            return 'good';
        else
            return 'bad';
    }
    function confirmapproval($request_id, $mobileNumber, $dob, $email, $iqama) {
        $driver = Drivers::find($request_id);
        $driver->driver_data = 'approved';
        $driver->mobileNumber = $mobileNumber;
        $driver->dob = $dob;
        $driver->email_id = $email;
        $driver->iqama = $iqama;
        $driver->save();
        return response()->json(["status"=>true,"payload"=>""],200);
    }
    function rejectApproval($request_id){
        $driver = Drivers::find($request_id);
        $driver->driver_data = 'pending';
        $driver->save();
        return response()->json(["status"=>true,"payload"=>""],200);
    }
    public function approval_review($driver_id){
        $drivers = "SELECT drivers.id,drivers.fullName,drivers.job_id,drivers.mobileNumber,drivers.driver_data,drivers.dob,drivers.email_id,drivers.iqama,drivers.identityProof,drivers.licence_no,drivers.licenseProof,warehouse.warehouseName,lkp_company.companyName FROM `drivers` JOIN warehouse on warehouse.id = drivers.warehouseId JOIN lkp_company on lkp_company.id = warehouse.companyId where drivers.id =".$driver_id." ";
        $drivers = DB::select($drivers);
        return response()->JSON(['status'=>true,'payload'=>$drivers[0]],200);
    }
    public function getCheckUp($checkUp_id){
        $vehicle_utlity_preview = array();
        // get current condition

        // get check-up condition

        // make array
        // vheicle check and utlities
        $checkUp = "SELECT vehicle_checks.* FROM `vehicle_checks` WHERE id=".$checkUp_id." ";
        $checkUp = DB::select($checkUp);

        $checkup_utlities = "SELECT vehicle_check_utlities.*,vehicle_check_utlities.vehicle_utlity_id as 'utlity_id',utilities.name,utilities.name_en FROM `vehicle_check_utlities` JOIN utilities ON utilities.id = vehicle_check_utlities.vehicle_utlity_id WHERE vehicle_check_utlities.vehicle_check_id = ".$checkUp_id." ";
        // dd($checkup_utlities);
        $checkup_utlities = DB::select($checkup_utlities);
        //  dd($checkup_utlities);
        $accssorieTable = '';
        foreach($checkup_utlities as $k=>$checkup_utlitiy){

            $prive_checkUp = "SELECT * FROM `vehicle_utilities` WHERE vehicle_id=".$checkUp[0]->vehicle_id." and utlity_id=".$checkup_utlitiy->vehicle_utlity_id." ";
            // dd($prive_checkUp);
            $prive_checkUp = DB::select($prive_checkUp);

             $vehicle_utlity_preview[$k] = array(
                 'id'=>$checkup_utlitiy->id,
                 'utlity_id'=>$checkup_utlitiy->utlity_id,
                 'vehicle_utlity_id'=>$checkup_utlitiy->utlity_id,
                 'name'=>$checkup_utlitiy->name,
                 'name_en'=>$checkup_utlitiy->name_en,
                 'current_status'=>$prive_checkUp[0]->utlity_condition,
                 'checkup_status'=>$checkup_utlitiy->utlity_condition,
                 'approval_status'=>strtoupper($checkup_utlities[$k]->approval),
                 'htmlContent'=>'',
                 'rejection_count'=>$checkup_utlities[$k]->rejection_count,
                 'actionBtn'=>''
                 );
        }

        foreach($vehicle_utlity_preview as $k=>$vehicle_utlity_previewItem){

            if($vehicle_utlity_previewItem['checkup_status'] == $vehicle_utlity_previewItem['current_status']){
                $html = "
            <tr>
                <td>".$vehicle_utlity_previewItem['name_en']."</td>
                <td style='color:blue'>".$vehicle_utlity_previewItem['current_status']."</td>
                <td style='color:blue'>".$vehicle_utlity_previewItem['checkup_status']."</td>
                <td> ".$vehicle_utlity_previewItem['rejection_count']." </td>
                <td> ".$vehicle_utlity_previewItem['approval_status']." </td>
                <td>
                ";
                 if($vehicle_utlity_previewItem['approval_status'] == 'APPROVED'){
                     $html = $html."
                    <input type='checkbox' disabled '>";
                 }else{
                     $html = $html."
                    <input type='checkbox' value='".$vehicle_utlity_previewItem['utlity_id']."'>";
                 }
                $html = $html."
                </td>
            </tr>
            ";
            }else{
                // dd($vehicle_utlity_previewItem);
                $options = '';
                $utility = DB::select("SELECT * FROM utilities WHERE id = " . $vehicle_utlity_previewItem['utlity_id']);
                foreach(json_decode($utility[0]->category) as $category) {
                    $selected = '';
                    if ($vehicle_utlity_previewItem['checkup_status'] == $category)
                        $selected = 'selected';
                    $options .= "<option value='$category' $selected>$category</option>";
                }

                // ".$vehicle_utlity_previewItem['checkup_status']."
                $html = "
            <tr>
                <td>".$vehicle_utlity_previewItem['name_en']."</td>
                <td style='color:red'>".$vehicle_utlity_previewItem['current_status']."</td>
                <td style='color:red'><select name='utility[]' onchange='updateUtility(". $vehicle_utlity_previewItem['id'].", this.value)'>".$options."</select></td>
                <td> ".$vehicle_utlity_previewItem['rejection_count']." </td>
                <td> ".$vehicle_utlity_previewItem['approval_status']." </td>
                <td>";
                 if($vehicle_utlity_previewItem['approval_status'] == 'APPROVED'){
                     $html = $html."
                    <input type='checkbox' disabled '>";
                 }else{
                     $html = $html."
                    <input type='checkbox' value='".$vehicle_utlity_previewItem['utlity_id']."'>";
                 }
                $html = $html."
                </td>
            </tr>
            ";
            }
            $accssorieTable = $accssorieTable.' '.$html;
        }

        // dd($accssorieTable);


        $prive_checkUp = DB::select("SELECT * FROM `vehicles` WHERE checkup_id is not null AND id=".$checkUp[0]->vehicle_id);

        $prive_checkup_utlities = '';

        if(count($prive_checkUp)>0) {
            $prive_checkUp = $prive_checkUp[0]->checkup_id;
            $checkUpPrev = DB::select("SELECT vehicle_checks.* FROM `vehicle_checks` WHERE id='$prive_checkUp'");
            $checkUpPrev = $checkUpPrev[0];
        } else {
            $prive_checkUp = null;
            $checkUpPrev = '';
        }
        $payload = [
                'checkUpPrev'=>$checkUpPrev,
                'checkUp'=>$checkUp[0],
                'privCheckUp'=>$prive_checkUp[0],
                'checkUp_utlities'=>$vehicle_utlity_preview,
                'accssorieTable'=>$accssorieTable
        ];
        return response()->json(['status'=>true,'data'=>$payload],200);
    }
    function updateUtility(Request $request) {
        $id = $request->id;
        $utlity_condition = $request->utlity_condition;
        $chk = DB::update("UPDATE vehicle_check_utlities set utlity_condition = '$utlity_condition' WHERE id = '$id'");
        if ($chk)
            echo 'good';
        else
            echo 'bad';
    }
    function accessoriesHandler(Request $request) {
        // dd($request->payload['action']);

        if($request->payload['action'] == 'approve') {
            $payload = Assign_vehicle::where(
                'checkup_id',$request->payload['check_id']
                )->get();

            if(count($payload)>0) {
                $payload = $payload[0];
                $RequestModal = RequestModal::where('vehicle_check_id',$request->payload['check_id'])->get();
                $RequestModal = $RequestModal->first();
                $RequestModal->status = 'supervisor_approved_utlities';
                $RequestModal->save();
                $payload->rejection_reason = null;
                $payload->status = 'utlity_accepted';
                $payload->save();
            }
            $vehicle_id = $payload->vehicle_id;
            $supervisor_id = $payload->created_by;
            $vehicleObject = DB::select("SELECT plate from vehicles WHERE id = '$vehicle_id'");
            $plate = $vehicleObject[0]->plate;
            $msg = "Vehicle(".$plate.") accessories approved successfully";
            $msg_arr = "تم اعتماد اكسسوارات المركبة(".$plate.")بنجاح";
            onesignal($supervisor_id, $msg, $msg_arr);
            $driver_id = $payload->driver_id;
            onesignal($driver_id, $msg, $msg_arr);

            $payload = Vehicle_checkUp_utlitie::where('vehicle_check_id',$request->payload['check_id'])->get();
            foreach($payload as $k=>$item){
                // $payload
                $item->approval = 'approved';
                $item->updated_by = Auth::user()->id;
                $item->save();
                $utl_id = $item->vehicle_utlity_id;
                $utl_cond = $item->utlity_condition;
                DB::update("UPDATE vehicle_utilities set utlity_condition = '$utl_cond', updated_at = NOW(), updated_by = ".AUTH::user()->id." WHERE vehicle_id = '$vehicle_id' AND utlity_id = '$utl_id'");

                // return response()->json(['status'=>true,"payload"=>$item],200);
            }
        } else {
            $RequestModal = RequestModal::where('vehicle_check_id',$request->payload['check_id'])->get();
            $RequestModal = $RequestModal->first();
            $RequestModal->status = 'rejected';
            $RequestModal->save();
            $vehicle_checkUp_utlities = Vehicle_checkUp_utlitie::where('vehicle_check_id',$request->payload['check_id'])->get();
            // dd($vehicle_checkUp_utlities);
            foreach($vehicle_checkUp_utlities as $k=>$vehicle_checkUp_utlitie){
                $vehicle_checkUp_utlitie;
                foreach($request->payload['items'] as $k=>$items){
                    if($items == $vehicle_checkUp_utlitie->vehicle_utlity_id){
                        $vehicle_checkUp_utlitie->approval = 'rejected';
                        $vehicle_checkUp_utlitie->rejection_count = $vehicle_checkUp_utlitie->rejection_count+1;
                        $vehicle_checkUp_utlitie->save();
                        continue;
                    }
                }
            }
            // signal here to driver as well supervisor
            $assign_vehicle = Assign_vehicle::where('checkup_id',$request->payload['check_id'])->get();
            if(count($assign_vehicle)>0){
                $assign_vehicle[0]->status = 'utlity_rejected';
                if($request->payload['rejction_reason'] == null)
                    $assign_vehicle[0]->rejection_reason = $request->payload['rejction_reason'];
                else
                    $assign_vehicle[0]->rejection_reason = null;

                $assign_vehicle[0]->save();
            }
            // $request->payload['check_id']

            $supervisor_id = $RequestModal->created_by;
            $vehicle_id = $RequestModal->vehicle_id;
            $vehicleObject = DB::select("SELECT plate from vehicles WHERE id = '$vehicle_id'");
            $plate = $vehicleObject[0]->plate;
            $msg = "Unfortunately, Vehicle(".$plate.") accessories are Rejected";
            $msg_arr = "تم رفض اعتماد بعض الإكسسوارات المركبة(".$plate.") الرجاء إعادة المحاولة مرة أخرى";
            onesignal($supervisor_id, $msg, $msg_arr);
            $driver_id = $RequestModal->driverId;
            onesignal($driver_id, $msg, $msg_arr);
        }
    }
    function checkUpImageHandler(Request $request){
        $check_id = $request->payload['check_id'];
        $vehicleCheckup = VehicleCheckup::find($check_id);

        $images_status = [
            'front'=>true,
            'rear'=>true,
            'right'=>true,
            'left'=>true,
            'interior'=>true
            ];
        if($request->payload['action'] == 'reject'){
            // rejected check-up
            $rejected_images = $request->payload['items'];
            foreach($rejected_images as $k=>$rejected_image){

                switch ($rejected_image) {
                  case 'front':
                      $images_status['front'] = false;
                    echo('front');
                    break;
                  case 'rear':
                      $images_status['rear'] = false;

                    echo('rear');
                    break;
                  case 'right':
                      $images_status['right'] = false;

                    echo('right');
                    break;
                  case 'left':
                      $images_status['left'] = false;

                    echo('left');
                    break;
                    case 'interior':

                        $images_status['interior'] = false;

                    echo('interior');
                    break;
                }
                // echo $rejected_image."<br>";
            }
        }else{
            // approved  check-up
        }
        $flag = false;
        foreach($images_status as $k=>$image){
            if($image == false){
                $flag = true;
            }
        }
        $RequestModal = RequestModal::where('vehicle_check_id',$request->payload['check_id'])->get();
        if($flag == true){
            $RequestModal = $RequestModal->first();
            $RequestModal->status = 'rejected';
            $RequestModal->save();
        }else{
            $RequestModal = $RequestModal->first();
            $RequestModal->status = 'supervisor_approved_images';
            $RequestModal->save();
        }
        // check if admin or suppervisor then excute
        $user = 'suppervisor';
        if($user == 'suppervisor'){

            $vehicleCheckup->front_image_approve = $images_status['front'];
            $vehicleCheckup->rear_image_approve = $images_status['rear'];
            $vehicleCheckup->right_image_approve = $images_status['right'];
            $vehicleCheckup->left_image_approve = $images_status['left'];
            $vehicleCheckup->interior_image_approve = $images_status['interior'];
            $vehicleCheckup->rejection_reason = $request->payload['rejction_reason'];
            $vehicleCheckup->otometer = $request->payload['Otometer_Read'];
            $vehicleCheckup->suppervisor_approve_by	= Auth::user()->id;
            $vehicleCheckup->suppervisor_approve_at = date('Y-m-d H:i:s');
            $vehicleCheckup->save();
            $otomter = $request->payload['Otometer_Read'];
            $vehicle_id = $request->payload['vehicle_id'];


            $assign_vehicle = Assign_vehicle::where('checkup_id',$request->payload['check_id'])->get();
            $vehicle_id = $assign_vehicle[0]->vehicle_id;
            $driver_id = $assign_vehicle[0]->driver_id;
            $supervisor_id = $assign_vehicle[0]->created_by;

            $vehicleObject = DB::select("SELECT plate from vehicles WHERE id = '$vehicle_id'");
            $plate = $vehicleObject[0]->plate;
            if(count($assign_vehicle)>0){
                if($flag == true){
                    $assign_vehicle[0]->status = 'image_rejected';
                    $reason = $request->payload['rejction_reason'];
                    $msg = "Unfortunately, Vehicle(".$plate.") Images are rejected, Reason(".$reason.")";
                    $msg_arr = "تم رفض بعض صور المركبة(".$plate.") بسبب(".$reason."), الرجاء اعادة المحاولة مرة اخرى";
                    onesignal($supervisor_id, $msg, $msg_arr);
                    onesignal($driver_id, $msg, $msg_arr);
                } else {
                    $check_user = DB::select("SELECT drivers.*,warehouse.companyId FROM `drivers` JOIN warehouse on warehouse.id = drivers.warehouseId WHERE drivers.id=".$assign_vehicle[0]->driver_id);
                    if (count($check_user) > 0) {
                        if($check_user[0]->companyId ==18) { // if the user is supervisor
                            $assign_vehicle[0]->status = 'finished';
                            $assign_vehicle[0]->save();
                            $all_vehicle_recoreds = Assign_vehicle::where([
                                    ['vehicle_id',$assign_vehicle[0]->vehicle_id]
                                ])->get();
                            foreach($all_vehicle_recoreds as $all_vehicle_recored){
                                $all_vehicle_recored->status = 'finished';
                                $all_vehicle_recored->save();
                            }
                            // end_Delegation
                            $valid_delegation = Delegation::where([
                                ['vehicle_id',$assign_vehicle[0]->vehicle_id],
                                ['status','valid']
                            ])->get();
                            // dd($valid_delegation);
                            // DB::select("SELECT * FROM `assign_vehicles` where `vehicle_id`=".$assign_vehicle[0]->vehicle_id." ");

                            foreach($valid_delegation as $valid_deleg) {
                                $valid_deleg->status = "completed";
                                $valid_deleg->returning_checkup_id = $check_id;
                                $valid_deleg->return_otometer_read_timesamp = now();
                                $valid_deleg->ending_date = now();
                                $valid_deleg->return_otometer_read = $otomter;
                                $valid_deleg->save();
                            }
                            DB::update("UPDATE vehicles set otometer = '$otomter', checkup_id = '$check_id' WHERE id = '$vehicle_id'");
                            $msg = "Vehicle(".$plate.") delegation completed successfully";
                            $msg_arr = "تم إكمال تفويض المركبة(".$plate.") بنجاح";
                            onesignal($supervisor_id, $msg, $msg_arr);
                            onesignal($driver_id, $msg, $msg_arr);
                        } else {
                            $assign_vehicle[0]->status = 'done';
                            DB::update("UPDATE vehicles set checkup_id = '$check_id', otometer = '$otomter' WHERE id = '$vehicle_id'");
                            $msg = "Vehicle(".$plate.") images are approved please complete the procedure with your supervisor";
                            $msg_arr = "تم اعتماد بيانات تسليم المركبة (".$plate."), الرجاء اكمال الإجراءات مع المسؤول الميداني";
                            onesignal($driver_id, $msg, $msg_arr);
                            $msg = "Vehicle(".$plate.") images are approved please complete the procedure with your driver";
                            $msg_arr = "تم اعتماد بيانات تسليم المركبة (".$plate."), الرجاء اكمال الإجراءات مع المندوب ";
                            onesignal($supervisor_id, $msg, $msg_arr);

                            $checkup_id = DB::SELECT("SELECT * FROM vehicle_checks WHERE driver_id = '$driver_id' ORDER BY `created_at` DESC");
                            $checkup_id = $checkup_id[0];

                            date_default_timezone_set('Asia/Riyadh');
                            $date = date('Y-m-d', time());
                            $chk = DB::select("SELECT id FROM delegations WHERE checkup_id = " . $checkup_id->id . " AND driverId = " . $checkup_id->driver_id . " AND vehicle_id = " . $checkup_id->vehicle_id);
                            if (count($chk) > 0) {} else {
                                $deligetion = Delegation::create([
                                    'reference_no' => $request->payload['reference_no'],
                                    'driverId'     => $checkup_id->driver_id,
                                    'status'       => 'valid',
                                    'checkup_id'   => $checkup_id->id,
                                    'vehicle_id'   => $checkup_id->vehicle_id,
                                    'otometer_read'=> $otomter,
                                    'created_by_type'=>'supervisor_web',
                                    'created_by'   => AUTH::user()->id
                                ]);
                            }
                            $assin_vehicle= Assign_vehicle::where('checkup_id',$checkup_id->id)->first();
                            $assin_vehicle->status = 'done';
                            $assin_vehicle->delegation_id = $deligetion->id;
                            $assin_vehicle->save();
                        }
                    }
                }

                if($request->payload['rejction_reason'] == null)
                    $assign_vehicle[0]->rejection_reason = $request->payload['rejction_reason'];
                else
                    $assign_vehicle[0]->rejection_reason = null;

                $assign_vehicle[0]->save();

                // dd($assign_vehicle);
            }
        }
        // dd($vehicleCheckup);
        return response()->json(['status'=>true,'payload'=>'[]'],200);
    }
    public function create_delegation(Request $request){
        dd($request->all());
    }
    public function VehicleOil()
    {
        return view('vehicles.oil_save');
    }

    // public function VehicleOilSave(Request $request)
    // { //Import drivers
    //     $note = "half salary till 15-11-2023";
    //     $status = 5;
    //     $date =  "2023-11-19";
    //     $createdby_id = $updatedby_id = 75;

    //     require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
    //     $tmpfname = $request->file('select_file');

    //     $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    //     $excelObj = $excelReader->load($tmpfname);
    //     $worksheet = $excelObj->getSheet(0);
    //     $lastRow = $worksheet->getHighestRow();
    //     for ($row = 1; $row <= $lastRow; $row++) {
    //         $job_id = $worksheet->getCell('B' . $row)->getValue();
    //         $warehouse = $worksheet->getCell('A' . $row)->getValue();
    //         $driver = DB::select("SELECT drivers.id from drivers where job_id = '$job_id'");
    //         if(count($driver) > 0) {

    //         } else {
    //             $warehouse = DB::select("SELECT id from warehouse where warehouseName = '$warehouse'");
    //             $warehouseId = $warehouse[0]->id;
    //             if($warehouseId > 0)
    //                 DB::insert("INSERT INTO drivers (fullName, job_id, warehouseId, status_id, created_by_id, updated_by_id, created_at, updated_at) VALUES ('NoName', '$job_id', '$warehouseId', '1', '$createdby_id', '$createdby_id', NOW(), NOW())");
    //         }
    //     }
    //     return redirect()->back()->with('success', 'Vehicles Oil added successfully');
    // }

    // public function VehicleOilSave(Request $request)
    // { //Import loans
    //     $note = "half salary till 15-11-2023";
    //     $status = 5;
    //     $date =  "2023-11-19";
    //     $createdby_id = $updatedby_id = 75;

    //     require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
    //     $tmpfname = $request->file('select_file');

    //     $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    //     $excelObj = $excelReader->load($tmpfname);
    //     $worksheet = $excelObj->getSheet(0);
    //     $lastRow = $worksheet->getHighestRow();
    //     for ($row = 1; $row <= $lastRow; $row++) {
    //         $job_id = $worksheet->getCell('A' . $row)->getValue();
    //         $amount = $worksheet->getCell('B' . $row)->getValue();
    //         if($amount > 0) {
    //             $driver = DB::select("SELECT drivers.id from drivers where job_id = '$job_id'");
    //                 if(count($driver) > 0) {
    //                     $driverId = $driver[0]->id;
    //                     DB::insert("INSERT INTO loan (driverId, journal_date, amount, status_id, note, createdby_id, updatedby_id, created_at, updated_at) VALUES ('$driverId', '$date', '$amount', '5', '$note', '$createdby_id', '$createdby_id', NOW(), NOW())");
    //                 }
    //         }
    //     }
    //     return redirect()->back()->with('success', 'Vehicles Oil added successfully');
    // }


    public function VehicleOilSave(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        // $date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $createdby_id = $updatedby_id = 75;

        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');

        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheet(0);
        $secondsInDay = 24 * 60 * 60;
        $lastRow = $worksheet->getHighestRow();
        $check = true;
        for ($row = 1; $row <= $lastRow; $row++) {
            $plate = $worksheet->getCell('C' . $row)->getValue();
            $invoice_date = $worksheet->getCell('A' . $row)->getValue();
            $invoice_total = $worksheet->getCell('G' . $row)->getValue();
            $plate = substr($plate, 0, 4);
            if ($plate != '') {
                $vehicle = DB::select("SELECT vehicles.id, plate from vehicles where plate LIKE '%$plate%'");
                if(count($vehicle) > 0) {
                    if ($check == true) {
                        DB::update("UPDATE vehicles_oil set status = 1");
                        $check = false;
                    }
                    $baseDate = new DateTime('1899-12-30');
                    $totalSeconds = (int) ($invoice_date * $secondsInDay);
                    $resultDate = $baseDate->modify("+$totalSeconds seconds");
                    $invoice_date = $resultDate->format('Y-m-d');
                    $vehicle_id = $vehicle[0]->id;
                    DB::insert("INSERT INTO vehicles_oil (vehicle_id, invoice_total, invoice_date, added_at) VALUES ('$vehicle_id', '$invoice_total', '$invoice_date', NOW())");
                }
            }
        }
        return redirect()->back()->with('success', 'Vehicles Oil added successfully');
    }
    public function oil_info(Request $request) {
        $vehicle_id = $request->vehicle_id;
        $result = DB::select("SELECT vehicles_oil.*, vehicles.plate, vehicles.oil_check from vehicles_oil join vehicles on vehicles.id = vehicles_oil.vehicle_id WHERE vehicles_oil.status is null AND vehicle_id = '$vehicle_id' order by invoice_date");
        return view('vehicles.vehicl_oil_info')->with('result', $result);
    }
    public function OilInfoDone(Request $request) {
        $vehicle_id = $request->vehicle_id;
        DB::update("update vehicles set oil_check = 1 where id = '$vehicle_id'");
    }
    public function FuelInfoDone(Request $request) {
        $vehicle_id = $request->vehicle_id;
        DB::update("update vehicles set fuel_check = 1 where id = '$vehicle_id'");
    }

    public function fuel_info(Request $request) {
        $vehicle_id = $request->vehicle_id;
        $month = date('n');
        $year = date('Y');
        $result = DB::select("SELECT *, vehicles.plate, vehicles.allowed_fuel_price from vehicles_fuel join vehicles on vehicles.id = vehicles_fuel.vehicle_id WHERE vehicle_id = '$vehicle_id' AND year = '$year' AND month = '$month'");
        $month1 = $month - 1;
        $result1 = DB::select("SELECT *, vehicles.plate, vehicles.allowed_fuel_price from vehicles_fuel join vehicles on vehicles.id = vehicles_fuel.vehicle_id WHERE vehicle_id = '$vehicle_id' AND year = '$year' AND month = '$month1'");
        $month2 = $month1 - 1;
        $result2 = DB::select("SELECT *, vehicles.plate, vehicles.allowed_fuel_price from vehicles_fuel join vehicles on vehicles.id = vehicles_fuel.vehicle_id WHERE vehicle_id = '$vehicle_id' AND year = '$year' AND month = '$month2'");
        if(count($result) > 0) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            return view('vehicles.vehicl_fuel_info')->with('result', $result)->with('daysInMonth', $daysInMonth);
        } else if(count($result1) > 0) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month1, $year);
            return view('vehicles.vehicl_fuel_info')->with('result', $result1)->with('daysInMonth', $daysInMonth);
        } else if(count($result2) > 0) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month2, $year);
            return view('vehicles.vehicl_fuel_info')->with('result', $result2)->with('daysInMonth', $daysInMonth);
        }
    }
    public function VehicleFuel()
    {
        return view('new_porttal.vehicles.fuel_save');
    }
    public function Vehicles(Request $request)
    {
        $date = $request->date;
        $date = explode("-",$date);
        $month = $date[0];
        $year = $date[1];
        $vehicle_id = $request->filter_vehicleId;
        $table = $request->ACTION;
        if ($table == 'table') {
            $response = "";
            $vehicles = DB::select("SELECT vehicles.plate,vehicles.fuel_tag, vehicles_fuel.id, vehicles_fuel.fuel_price, vehicles_fuel.day, vehicles_fuel.month, vehicles_fuel.year FROM vehicles_fuel INNER JOIN vehicles ON
            vehicles_fuel.vehicle_id=vehicles.id WHERE vehicles_fuel.driver_id IS NULL AND `month` = '$month' AND `year` = '$year' AND vehicles.id = '$vehicle_id'");
            if (count($vehicles) > 0) {
                $i = 0;
                foreach ($vehicles as $vehicle) {
                    $i++;
                    $response .= "<tr><td>$i</td>";
                    $response .= "<td>".$vehicle->plate."</td>";
                    $response .= "<td>".$vehicle->fuel_tag."</td>";
                    $response .= "<td>".$vehicle->fuel_price."</td>";
                    $response .= "<td>".$vehicle->day."-".$vehicle->month."-".$vehicle->year."</td>";
                    $response .= "<td><input type='text' name='jobId_".$vehicle->id."'></td>";
                    $response .= "</tr>";
                }
            }
        } else {
            $vehicles = DB::select("SELECT DISTINCT vehicles.plate,vehicles.id FROM vehicles_fuel INNER JOIN vehicles ON vehicles_fuel.vehicle_id=vehicles.id WHERE vehicles_fuel.driver_id IS NULL AND `month` = '$month' AND `year` = '$year'");
            $response = "<option value=''>Select Vehicle</option>";
            if (count($vehicles) > 0) {
                foreach ($vehicles as $vehicle)
                    $response .= "<option value=".$vehicle->id.">".$vehicle->plate."</option>";
            }
        }
        return $response;
    }

    public function fuelLink(Request $request) {
        $user_id = Auth::user()->id;
        $vehicle_id = $request->filter_vehicleId;
        $date = $request->filter_month;
        $date = $request->filter_month;
        $date = explode("-",$date);
        $month = $date[0];
        $year = $date[1];
        $vehicles = DB::select("SELECT vehicles_fuel.id FROM vehicles_fuel INNER JOIN vehicles ON vehicles_fuel.vehicle_id=vehicles.id WHERE vehicles_fuel.driver_id IS NULL AND `month` = '$month' AND `year` = '$year' AND vehicles.id = '$vehicle_id'");
        if (count($vehicles) > 0) {
            $i = 0;
            foreach ($vehicles as $vehicle) {
                if (isset($request->{"jobId_" . $vehicle->id}) AND $request->{"jobId_" . $vehicle->id} != null) {
                    $job_id = $request->{"jobId_" . $vehicle->id};
                    $driver = DB::select("SELECT id FROM drivers WHERE job_id = '$job_id'");
                    if (count($driver) > 0) {
                        DB::update("UPDATE vehicles_fuel set driver_id = '$job_id', updated_by = '$user_id', updated_at = NOW() WHERE id = ".$vehicle->id);
                    }
                }
            }
        }
        return redirect()->back()->with('success', 'Driver Ids linked successfully');
    }

    public function VehicleFuelSave(Request $request)
    {
        $user_id = Auth::user()->id;
        $createdby_id = $updatedby_id = 75;

        if(isset($request->action)) {
            $month = $request->month;
            $year = $request->year;
            for ($i = 0; $i < count($request->job_ids); $i++) {
                // print_r($request->days_array[$i]);
                $vehicle_id = $request->vehicle_ids[$i];
                $days = json_decode($request->days_array[$i]);
                $fuels = json_decode($request->fuel_array[$i]);
                for ($k = 0; $k < count($days); $k++)
                {
                    $day = $days[$k];
                    $fuel = $fuels[$k];
                    DB::insert("INSERT INTO vehicles_fuel (vehicle_id, fuel_price, day, month, year, added_at) VALUES ('$vehicle_id', '$fuel', '$day', '$month', '$year', NOW())");

                }
                $price = $request->prices[$i];
                $driverId = $request->driverIds[$i];
                $note = $request->notes[$i];
                DB::insert("INSERT INTO creditnotes (driverId, amount, note, journal_date, createdby_id, updatedby_id, created_at, updated_at) VALUES ('$driverId', '$price', '$note', NOW(), '$createdby_id', '$createdby_id', NOW(), NOW())");
            }

            dd('dd');
            return redirect()->back()->with('success', 'Credit Notes added successfully');
        }
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        // $date = date("Y-m-d H:i:s");

        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $tmpfname = $request->file('select_file');
        $originalName = $tmpfname->getClientOriginalName();
        $originalName = explode(".",$originalName);
        $originalName = explode("-",$originalName[0]);
        $month = (int)$originalName[1];
        $year = (int)$originalName[0];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();
        $week_days = $response = array();

        $week_days[] = $day1 = $worksheet->getCell('C1')->getValue();
        $week_days[] = $worksheet->getCell('D1')->getValue();
        $week_days[] = $worksheet->getCell('E1')->getValue();
        $week_days[] = $worksheet->getCell('F1')->getValue();
        $week_days[] = $worksheet->getCell('G1')->getValue();
        $week_days[] = $worksheet->getCell('H1')->getValue();
        $week_days[] = $day7 = $worksheet->getCell('I1')->getValue();

        $index = 0;
        for ($row = 2; $row <= $lastRow; $row++) {
            $fuel_price = 0;
            $days_fuel_array = array();
            $days_fuel_array[] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $days_fuel_array[] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $days_fuel_array[] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $days_fuel_array[] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $days_fuel_array[] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            $days_fuel_array[] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
            $days_fuel_array[] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
            if (array_sum($days_fuel_array) > 0) {
                $plate = $worksheet->getCell('B' . $row)->getValue();
                $plate = substr($plate, 0, 4);
                $vehicle = DB::select("SELECT vehicles.id, vehicles.plate,vehicle_models.daily_fuel FROM vehicles INNER JOIN vehicle_models ON vehicles.vehicle_model_id=vehicle_models.id where plate LIKE '%$plate%'");
                if(count($vehicle) > 0) {
                    $vehicle_id = $vehicle[0]->id;
                    $checks = DB::select("SELECT DISTINCT drivers_attendance.job_id,drivers.fullName, drivers.id, count(drivers_attendance.job_id) as days FROM drivers_attendance INNER JOIN drivers ON drivers_attendance.job_id=drivers.job_id WHERE drivers_attendance.date BETWEEN '$year-$month-$day1' AND '$year-$month-$day7' AND drivers_attendance.vehicle_id='$vehicle_id' GROUP BY drivers_attendance.job_id,drivers.fullName,drivers.id");
                    $fuel_array = $days_array = array();
                    foreach($checks as $check) {

                        $job_id = $check->job_id;
                        $data = DB::select("(SELECT date FROM drivers_attendance WHERE date BETWEEN '$year-$month-$day1' AND '$year-$month-$day7' AND vehicle_id='$vehicle_id' AND job_id='$job_id' ORDER BY date LIMIT 1) UNION (
                                            SELECT date FROM drivers_attendance WHERE date BETWEEN '$year-$month-$day1' AND '$year-$month-$day7' AND vehicle_id='$vehicle_id' AND job_id='$job_id' ORDER BY date DESC LIMIT 1)");

                        if (count($data) == 1) {
                            $day = ltrim(date('d', strtotime($data[0]->date)), '0');
                            $exist = DB::select("SELECT id from vehicles_fuel where vehicle_id = '$vehicle_id' and day = '$day' and month = '$month' and year = '$year'");
                            if(count($exist) > 0) {
                                continue;
                            }
                            $fuel_price = 0;
                            $dayOfWeek = ltrim(date('d', strtotime($data[0]->date)), '0') % 7;
                            if ($dayOfWeek == 0)
                            {
                                if ($days_fuel_array[6] == 0)
                                    continue;
                                $fuel_price = $days_fuel_array[6];
                                $fuel_array[] = round($days_fuel_array[6]);
                                $days_array[] = $week_days[6];
                            } else {
                                if ($days_fuel_array[$dayOfWeek - 1] == 0)
                                    continue;
                                $fuel_price = $days_fuel_array[$dayOfWeek - 1];
                                $fuel_array[] = round($days_fuel_array[$dayOfWeek - 1]);
                                $days_array[] = $week_days[$dayOfWeek - 1];
                            }
                        } else if(count($data) > 1) {
                            $fuel_price = 0;
                            $dayOfWeek_1 = ltrim(date('d', strtotime($data[0]->date)), '0');
                            $dayOfWeek_2 = ltrim(date('d', strtotime($data[1]->date)), '0');
                            for ($z = $dayOfWeek_1; $z <= $dayOfWeek_2; $z++) {
                                $exist = DB::select("SELECT id from vehicles_fuel where vehicle_id = '$vehicle_id' and day = '$z' and month = '$month' and year = '$year'");
                                if(count($exist) > 0) {
                                    continue;

                                }
                                $dayOfWeek = $z % 7;
                                if ($dayOfWeek == 0) {
                                    if ($days_fuel_array[6] == 0)
                                        continue;
                                    $fuel_price += $days_fuel_array[6];
                                    $fuel_array[] = round($days_fuel_array[6]);
                                    $days_array[] = $week_days[6];
                                }
                                else {
                                    if ($days_fuel_array[$dayOfWeek - 1] == 0)
                                        continue;
                                    $fuel_price += $days_fuel_array[$dayOfWeek - 1];
                                    $fuel_array[] = round($days_fuel_array[$dayOfWeek - 1]);
                                    $days_array[] = $week_days[$dayOfWeek - 1];
                                }
                            }
                        } else {
                            $fuel_price = 0;
                            $k = 0;
                            foreach($days_fuel_array as $fuel) {
                                if ($fuel > 0) {
                                    $fuel_price += $fuel;
                                    $fuel_array[] = round($fuel);
                                    $days_array[] = $week_days[$k];
                                }
                                $k++;
                            }
                        }

                        $index++;
                        $response[$index]['vehicle_id'] = $vehicle_id;
                        $response[$index]['plate'] = $vehicle[0]->plate;
                        $response[$index]['daily_fuel'] = $vehicle[0]->daily_fuel;
                        $response[$index]['fullName'] = $check->fullName;
                        $response[$index]['job_id'] = $job_id;
                        $response[$index]['actual_price'] = $fuel_price;
                        $response[$index]['driverId'] = $check->id;
                        $response[$index]['days'] = $check->days;
                        $response[$index]['days_array'] = $days_array;
                        $response[$index]['fuel_array'] = $fuel_array;
                    }
                }
            }
        }
        // dd($response);
        $start_date = $year.'-'.$month.'-'.$day1;
        $last_date = $year.'-'.$month.'-'.$day7;
        return view('vehicles.fuel_save')->with('response', $response)->with('start_date', $start_date)->with('last_date', $last_date)->with('month', $month)->with('year', $year);
    }
}


function get_vehicle_info($vehicle_id) {
    $vehicle_info = array();
    $vehicle = DB::select("SELECT drivers.iqama, drivers.mobileNumber, drivers.job_id, drivers.fullName,warehouse.warehouseName,lkp_company.companyName,lkp_city.name_en AS city_name FROM vehicles
    INNER JOIN vehicle_models ON vehicles.vehicle_model_id=vehicle_models.id
    INNER JOIN delegations ON vehicles.id=delegations.vehicle_id
    INNER JOIN drivers ON delegations.driverId=drivers.id
    INNER JOIN warehouse ON drivers.warehouseId=warehouse.id
    INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id
    INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id WHERE vehicles.id='$vehicle_id' AND delegations.status = 'valid'");
    // dd($vehicle);
    if(count($vehicle) > 0) {
        $vehicle_info['driver_name'] = $vehicle[0]->fullName;
        $vehicle_info['city_name'] = $vehicle[0]->city_name;
        $vehicle_info['company_name'] = $vehicle[0]->companyName;
        $vehicle_info['warehouse_name'] = $vehicle[0]->warehouseName;
        $vehicle_info['job_id'] = $vehicle[0]->job_id;
        $vehicle_info['iqama'] = $vehicle[0]->iqama;
        $vehicle_info['mobileNumber'] = $vehicle[0]->mobileNumber;
    } else {
        $vehicle_info['driver_name'] = '';
        $vehicle_info['city_name'] = '';
        $vehicle_info['company_name'] = '';
        $vehicle_info['warehouse_name'] = '';
        $vehicle_info['job_id'] = '';
        $vehicle_info['iqama'] = '';
        $vehicle_info['mobileNumber'] = '';
    }
    return $vehicle_info;
}
function get_vehicle_table_body($payload, $city_name = null)
{
    $data = [];
    $no = 0;
    foreach ($payload as $k=>$item) {
        $days = $color = '';
        $expiry_days = '';
        if($item->expiry_days > 0) {
            $color = 'red';
            $expiry_days = $item->expiry_days;
            // $days = 'days';
        }
        $resp = '<center style="color: '.$color.'">'.$expiry_days.' '.$days.'</center>';
        $response1 = '<span style="color: #F79013;">'.$item->delegation_info["job_id"].'</span><br>'.$item->delegation_info["driver_name"].' <br> '.$item->delegation_info["city_name"].' <br> '.$item->delegation_info["company_name"].' <br> '.$item->delegation_info["warehouse_name"];
        $response2 = '<div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                    <ul class="dropdown-menu">
                        <li>
                            <a onclick="vehicleExtraInfo('."'".$item->images."'".",'".$item->plate."','".$item->name_en."','".$item->vehicle_manufacturer."','".$item->manufacturer_date."','".$item->vehicle_model."','".$item->vehicle_opreator."','".$item->SNno."','".$item->body_number."','".$item->freeExtraOtometer."','','".$item->extraOtometerCharge."','".$item->otometer."','".$item->registertion_type."','".$item->current_status."','".$item->color."','".$item->vehicle_registration_expire_date."')".'"
                            data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> View </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a onclick="vehicleEdit('. $item->vehicle_id .')" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit">Edit</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        ';
        if($item->checkup_id == '') {
            $response2 .= '
            <li>
                <a onclick="addVehicleCheckup('."'".$item->vehicle_id."'".', '."'".$item->vehicle_manufacturer."'".', '."'".$item->vehicle_model."'".', '."'".$item->manufacturer_date."'".', '."'".$item->plate."'".', '."'".$item->SNno."'".')" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view">Add Vehicle Checkup </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
                ';
        }
        $response2 .= '
        <li>
            <a onclick="vehicleHistory('."'".$item->vehicle_id."'".')" title="Delegation history" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow history">Delegation history</a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
        <button class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"  onclick="editAccessories('.$item->vehicle_id.')">Accessories</button>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>';
        $today = date("Y-m-d");
        $delegation_status = '';
        if($item->delegation_status == 'Under Process') {
            $delegation_status = '<span class="badge badge-primary">Under Process</span>';
            $response1 = '';
        } else if($item->delegation_status == 'valid' AND $today < $item->ending_date) {
            $delegation_status = '<span class="badge badge-success">Valid</span>';
        } else if($item->delegation_status == 'valid' AND $today > $item->ending_date) {
            $delegation_status = '<span class="badge badge-warning">Valid Expired</span>';
        } else if($item->delegation_status == 'cancelled') {
            $delegation_status = '<span class="badge badge-danger">Cancelled</span>';
            $response1 = '';
        } else if($item->delegation_status == 'completed') {
            $delegation_status = '<span class="badge badge-success">Completed</span>';
            $response1 = '';
        }  else if($item->delegation_status == 'completedAfterExpiry') {
            $delegation_status = '<span class="badge badge-info">Completed After Expiry</span>';
            $response1 = '';
        }

        $data[] = [
            'no' => ++$no,
            'plate' => $item->plate,
            'fuel_data' => $item->fuel_data,
            'oil_data' => $item->oil_data,
            'vehicle_expiry_date' => $resp,
            'name_en' => $item->name_en,
            'vehicle_manufacturer' => $item->vehicle_manufacturer,
            'vehicle_model' => $item->vehicle_model.', '.$item->manufacturer_date,
            'vehicle_opreator' => $item->vehicle_opreator,
            'color' => $item->color,
            'vehicle_registration_expire_date' => $item->vehicle_registration_expire_date,
            // 'vehicle_utilities_html' => $item->vehicle_utilities_html,
            'otometer' => $item->otometer,
            'registertion_type' => $item->registertion_type,
            'current_status' => $item->current_status,
            'delegation_status' => $delegation_status,
            'maintenance_location' => $item->maintenance_location,
            'response1' => $response1,
            'response2' => $response2,
            'warehouse' => $item->delegation_info["warehouse_name"],
            'driver' => $item->delegation_info["driver_name"],

        ];
    }
    return $data;
}
function get_delegated_table_body($payload)
{
    $data = [];
    $no = 1;
    foreach ($payload as $k=>$item) {
        $reference_no = $item->reference_no;
        $check = DB::select("SELECT * FROM tbl_tmm_delegation WHERE reference_no = '$reference_no'");
        if (count($check) > 0) {
            $data[] = [
                'vehicle_id' => $item->vehicle_id,
                'checkup_id' => $item->checkup_id,
                'no' => $no,
                'id' => $item->id,
                'plate' => $item->plate,
                'reference_no' => $item->reference_no,
                'tm_reference_no' => $check[0]->reference_no,
                'name_en' => $item->name_en,
                'warehouseName' => $item->warehouseName,
                'fullName' => $item->fullName,
                'iqama' => $item->iqama,
                'tm_iqama' => $check[0]->iqama,
                'mobileNumber' => $item->mobileNumber,
                'starting_date' => $item->starting_date,
                'ending_date' => $item->ending_date,
                'status' => $item->status,
            ];
        } else {
            $iqama = $item->iqama;
            $end_date = $item->ending_date;
            $check = '';
            if ($end_date != '')
                $check = DB::select("SELECT * FROM tbl_tmm_delegation WHERE iqama = '$iqama' AND end_date = '$end_date'");
            if ($check != '' AND count($check) > 0) {
                $data[] = [
                    'vehicle_id' => $item->vehicle_id,
                    'checkup_id' => $item->checkup_id,
                    'no' => $no,
                    'id' => $item->id,
                    'plate' => $item->plate,
                    'reference_no' => $item->reference_no,
                    'tm_reference_no' => $check[0]->reference_no,
                    'name_en' => $item->name_en,
                    'warehouseName' => $item->warehouseName,
                    'fullName' => $item->fullName,
                    'iqama' => $item->iqama,
                    'tm_iqama' => $check[0]->iqama,
                    'mobileNumber' => $item->mobileNumber,
                    'starting_date' => $item->starting_date,
                    'ending_date' => $item->ending_date,
                    'status' => $item->status,
                ];
            } else {
                $data[] = [
                    'vehicle_id' => $item->vehicle_id,
                    'checkup_id' => $item->checkup_id,
                    'no' => $no,
                    'id' => $item->id,
                    'plate' => $item->plate,
                    'reference_no' => $item->reference_no,
                    'tm_reference_no' => '',
                    'name_en' => $item->name_en,
                    'warehouseName' => $item->warehouseName,
                    'fullName' => $item->fullName,
                    'iqama' => $item->iqama,
                    'tm_iqama' => '',
                    'mobileNumber' => $item->mobileNumber,
                    'starting_date' => $item->starting_date,
                    'ending_date' => $item->ending_date,
                    'status' => $item->status,
                ];
            }
        }
        $no++;
    }
    return $data;
}

function get_fuel_details($vehicle_id, $allowed_fuel_price, $fuel_check) {
    $month = date('m') - 1;
    $year = date('Y');
    $result = DB::select("SELECT sum(fuel_price) as fuel from vehicles_fuel WHERE vehicle_id = '$vehicle_id' AND year = '$year' AND month = '$month'");
    $fuel = '<ul>';
    $fuel_price = 0;
    if($result[0]->fuel > 0) {
        $fuel_price = $result[0]->fuel;
        $fuel = '<li>' . $result[0]->fuel . ' for (' . $year . '/' . $month . ')</li>';
    }
    $month = $month - 1;
    $result = DB::select("SELECT sum(fuel_price) as fuel from vehicles_fuel WHERE vehicle_id = '$vehicle_id' AND year = '$year' AND month = '$month'");
    if($result[0]->fuel > 0) {
        $fuel .= '<li>' . $result[0]->fuel . ' for (' . $year . '/' . $month . ')</li>';
    }
    $month = $month - 1;
    $result = DB::select("SELECT sum(fuel_price) as fuel from vehicles_fuel WHERE vehicle_id = '$vehicle_id' AND year = '$year' AND month = '$month'");
    if($result[0]->fuel > 0) {
        $fuel .= '<li>' . $result[0]->fuel . ' for (' . $year . '/' . $month . ')</li>';
    }
    if($fuel != '<ul>' && $fuel_price > $allowed_fuel_price && $fuel_check != 1)
        $fuel .= '<button class="btnaction btn menu-icon vd_bd-red vd_red " onclick="fuel_info('.$vehicle_id.')">Info <i class="fa fa-eye"></i></button></ul>';
    else if($fuel != '<ul>')
        $fuel .= '<button class="btnaction btn menu-icon vd_bd-yellow vd_yellow " onclick="fuel_info('.$vehicle_id.')">Info <i class="fa fa-eye"></i></button></ul>';

    return $fuel;
}

function make_header($dateArray) {
    $response = '<tr><th rowspan=2>Vehicle</th>';
    foreach($dateArray as $date) {
        $response .= '<th rowspan=2>' . $date . '</th>';
    }
    $response .= '<th colspan=7><center>Summary</center></th></tr>';
    $response .= '<tr><th>Present</th><th>Absent</th><th>Available</th><th>Maintenance</th><th>Damaged</th><th>Payable days</th><th>Total</th></tr>';
    return $response;
}
function make_body($dateArray, $city_id, $company_id, $warehouse_id, $type, $vehicle_id, $current_status) {
    $available_total = $maintenance_total = $damaged_total = $present_total = $absent_total = $payable_days_total = $whole_total = 0;

    $response = $vehicle_clause = $status_clause = '';
    if ($vehicle_id > 0 AND $type == 1)
        $vehicle_clause = " AND vehicles.id = '$vehicle_id'";
    if ($current_status != '' AND $type == 1) {
        if ($current_status == 'delegeted')
            $status_clause = " AND current_status = '$current_status' AND maintenance_status IS NULL";
        else if($current_status == 'maintenance')
            $status_clause = " AND current_status = '$current_status' OR maintenance_status IS NOT NULL";
        else
            $status_clause = " AND current_status = '$current_status'";
    }
    $warehouse_clause = "1 = 1";
    if ($warehouse_id > 0)
        $warehouse_clause = " warehouse.id = '$warehouse_id'";
    if ($warehouse_id == '' AND $company_id == '' AND $city_id > 0){
        $vehicles = DB::select("SELECT vehicle_models.monthly_rent,vehicles.plate,vehicles.id,vehicles.current_status FROM vehicles INNER JOIN lkp_city ON vehicles.city_id=lkp_city.id INNER JOIN vehicle_models ON vehicles.vehicle_model_id=vehicle_models.id WHERE lkp_city.id = '$city_id'");
    } else if ($warehouse_id > 0 OR $company_id > 0){
        $companyClause = $warehouseClause = $cityClause = "";
        if ($warehouse_id > 0)
            $warehouseClause = "AND warehouse.id = '$warehouse_id'";
        if ($company_id > 0)
            $companyClause = "AND lkp_company.id = '$company_id'";
        if ($city_id > 0) {
            $cityClause = "AND lkp_city.id = '$city_id'";
        }
        $vehicles = DB::select("SELECT vehicles.id,vehicles.plate,vehicles.current_status,vehicle_models.monthly_rent FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id INNER JOIN vehicles ON drivers.vehicle_id=vehicles.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN vehicle_models ON vehicles.vehicle_model_id=vehicle_models.id WHERE 1 = 1 $companyClause $warehouseClause $vehicle_clause $status_clause $cityClause");
    } else {
        $vehicles = DB::select("SELECT vehicles.plate,vehicles.id,vehicles.current_status,vehicle_models.monthly_rent FROM vehicles INNER JOIN vehicle_models ON vehicles.vehicle_model_id=vehicle_models.id WHERE $warehouse_clause $vehicle_clause $status_clause");
    }
    foreach($vehicles as $vehicle) {
        $available = $maintenance = $damaged = $present = $absent = 0;
        $vehicle_info = get_vehicle_info($vehicle->id);
        $driver_name = $vehicle_info['driver_name'];
        $city_name = $vehicle_info['city_name'];
        $company_name = $vehicle_info['company_name'];
        $warehouse_name = $vehicle_info['warehouse_name'];
        $response .= '<tr><td>'.$vehicle->plate.'</td>';
        foreach($dateArray as $date) {
            $vehicle_status = DB::select("SELECT status from drivers_attendance WHERE vehicle_id = '$vehicle->id' AND date = '$date'");
            if (isset($vehicle_status[0]->status)) {
                if ($vehicle_status[0]->status == 'present') {
                    $status = 'P';
                    $present += 1;
                } else if ($vehicle_status[0]->status == 'absent with no excuse') {
                    $status = 'A';
                    $absent += 1;
                } else if ($vehicle_status[0]->status == 'absent with excuse') {
                    $status = 'AWE';
                    $absent += 1;
                } else if ($vehicle_status[0]->status == 'maintenance') {
                    $status = 'M';
                    $maintenance += 1;
                } else if ($vehicle_status[0]->status == 'damaged') {
                    $status = 'D';
                    $damaged += 1;
                } else if ($vehicle_status[0]->status == 'missed attendance') {
                    $status = 'MA';
                    $absent += 1;
                } else if ($vehicle_status[0]->status == 'availabe') {
                    $status = 'Stop';
                    $available += 1;
                }

            } else {
                $status = 'N/A';
                // if ($vehicle->current_status == 'availabe') {
                //     $status = 'Stop';
                //     $available += 1;
                // } else if ($vehicle->current_status == 'maintenance') {
                //     $status = 'M';
                //     $maintenance += 1;
                // } else if ($vehicle->current_status == 'damaged') {
                //     $status = 'D';
                //     $damaged += 1;
                // } else if ($vehicle->current_status == 'delegeted') {
                //     $status = 'A';
                //     $absent += 1;
                // }
            }
            if($status == 'N/A' || $status == 'M' || $status == 'D'  || $status == 'Stop') {
                $response .= '<td style="text-align: center"><button disabled class="btn btn-info btn-sm">'.$status.'</button> <i onclick="show_info()" style="cursor: pointer" title="Show Info" class="fa fa-info-circle fa-lg"></i><br></td>';
            } else {
                $response .= '<td style="text-align: center"><button disabled class="btn btn-info btn-sm">'.$status.'</button> <i onclick="show_info()" style="cursor: pointer" title="Show Info" class="fa fa-info-circle fa-lg"></i><br>
                '.$driver_name.' <br>
                '.$city_name.' <br>
                '.$company_name.' <br>
                '.$warehouse_name.'
                </td>';
            }
        }
        $payable_days = $present + $absent + $available;
        $vehicle_daily_rent = $vehicle->monthly_rent / 30;
        $total = $payable_days * $vehicle_daily_rent;
        $response .= '<td style="text-align: right">'.$present.'</td>';
        $response .= '<td style="text-align: right">'.$absent.'</td>';
        $response .= '<td style="text-align: right">'.$available.'</td>';
        $response .= '<td style="text-align: right">'.$maintenance.'</td>';
        $response .= '<td style="text-align: right">'.$damaged.'</td>';
        $response .= '<td style="text-align: right">'.$payable_days.'</td>';
        $response .= '<td style="text-align: right">'.round($total, 2).' SAR</td>';
        $response .= '</tr>';
        $available_total += $available;
        $maintenance_total += $maintenance;
        $damaged_total += $damaged;
        $present_total += $present;
        $absent_total += $absent;
        $payable_days_total += $payable_days;
        $whole_total += round($total, 2);
    }
    $length = sizeof($dateArray) + 1;
    $response_foot = '<tr><th style="text-align: center" colspan='.$length.'>Total</th>
    <th style="text-align: right">'.$present_total.'</th>
    <th style="text-align: right">'.$absent_total.'</th>
    <th style="text-align: right">'.$available_total.'</th>
    <th style="text-align: right">'.$maintenance_total.'</th>
    <th style="text-align: right">'.$damaged_total.'</th>
    <th style="text-align: right">'.$payable_days_total.'</th>
    <th style="text-align: right">'.number_format($whole_total).' SAR</th>
    </tr>';
    return array($response, $response_foot);
}
function get_vRequest_tblBody($payload) {
    $html = '';
    foreach($payload as $k=>$item) {
        $input = $item->plate;
        $parts = explode(" ", $input);
        $numberPart = array_pop($parts);
        $characterPart = implode(" ", $parts);
        $html .= '
        <tr>
            <td>'.++$k.'</td>
            <td>'.$item->city_name.'</td>
            <td>
                <table><tbody><tr><td style="border: 1px solid;">'.$numberPart.'</td><td style="border: 1px solid;">'.$characterPart.'</td></tr></tbody></table>
            </td>
            <td>
                '.$item->color.', '.$item->vehicle_manufacturer_name.', '.$item->vName.', '.$item->manufacturer_date.'
                <span> <button data-toggle="modal" data-target="#ViewVehicleModal"> <a href="#"><i class="fa fa-eye"></i></a></button></span>
            </td>
            <td> '.$item->opreatoers.'</td>
            <td>'.$item->fullName.',  <span style="color:red">'.$item->job_id.'</span> <span> <button > <a href="javascript:driver('.$item->driver_id.')"><i class="fa fa-eye"></i></a></button></span></td>
            <td style="text-align: center;">';
                if($item->driver_data == 'pending')
                    $html .= '<button disabled>Waiting DA Confrime Data</button>';

                if($item->driver_data == 'applied') {
                    if($item->supporvisor_identity_approve == 0)
                        $html .= '<button class="btn btn-light" onclick="setRequestIdAndOpenModal('.$item->requests_id.','.$item->driver_id.','.$item->supporvisor_identity_approve.')">Approve</button>';
                }
                if($item->driver_data == 'approved')
                    $html .= '<img style="width: 38px; margin: 0 auto;" src="https://btcdmins.com/images/check.png" alt="driver approved check">';
            $html .= '
            </td>
            <td>
                <span class="badge badge-warning">
                    '.$item->name_en.'
                </span>
            </td>
            <td> '. \Carbon\Carbon::parse($item->request_issue_date)->format('j F, Y') .' </td>
            <td>';
                if($item->assiment_status == 'Pending')
                    $html .= 'Waiting Driver to update data';

                if($item->assiment_status == 'sent')
                    $html .= 'Please Confirm Checkup data';

                if($item->assiment_status == 'utlity_rejected')
                 $html .= 'One or more Accessory have been Rejected';

                if($item->assiment_status == 'utlity_accepted')
                 $html .= 'Please approve Checkup images';

                if($item->assiment_status == 'image_rejected' )
                     $html .= 'One or more Checkup Image have been Rejected';

                if($item->assiment_status == 'image_accepted' )
                     $html .= 'Please Fill & confirm Delegation';

                if($item->assiment_status == 'Rejected')
                  $html .= 'Rejected & Waiting driver to re-upload Vehicle images';

                if($item->assiment_status == 'done')
                  $html .= 'Done & Waiting to return';

                if($item->assiment_status == 'finished')
                  $html .= 'Completed';
                $html .= '
            </td>
            <td>
                <textarea name="note" id="note_'.$item->assignId.'" rows="5" value="{{$item->note}}">'.$item->note.'</textarea>
                <center><button class="btn btn-primary btn-sm" onclick="saveNote('.$item->assignId.')">Save</button></center>
            </td>
            <td>
                <ul style="text-align: left;">';
                    if($item->assiment_status == 'pending') {
                        $html .= '<li>
                            <a href="#" >Waiting driver to update data</a>
                        </li>';
                    }

                    if($item->assiment_status == 'sent') {
                        $html .= '<li>
                            <a href="#" onclick="PreviewAccessoriesCheckUp('.$item->vehicle_check_id.', '.$item->plate.')" >Preview Accessories</a>
                        </li>';
                    }

                    if($item->assiment_status == 'utlity_accepted') {
                        $html .= '<li>
                            <a href="#" disabled style="text-decoration: line-through;">Preview Accessories</a>
                        </li>
                        <li>
                            <a href="#" onclick="PreviewCheckUp('.$item->vehicle_check_id.', '.$item->plate.')" >Preview Check-up</a>
                        </li>';
                    }

                    if($item->assiment_status == 'image_accepted') {
                        $html .= '
                        <li>
                            <a href="#" disabled style="text-decoration: line-through;">Preview Accessories</a>
                        </li>

                        <li>
                            <a href="#" disabled  style="text-decoration: line-through;">Preview Check-up</a>
                        </li>

                        <li>
                            <a href="#" onclick="setRequestIdAndCreate('.$item->requests_id.','.$item->driver_id.','.$item->supporvisor_identity_approve.','.$k.')" > <span>Issue new delegation</span> </a>
                        </li>';
                    }

                    if($item->assiment_status == 'utlity_rejected') {
                        $html .= '
                        <li>
                            <a href="#"  style="margin: 5px;">Waiting DA To Accessories</a>
                        </li>
                        ';
                    }
                    if($item->assiment_status == 'image_rejected' ) {
                        $html .= '
                        <li>
                            <a href="#"  style="margin: 5px;">image rejected, Waiting to reupload Images</a>
                        </li>';
                    }

                    if($item->assiment_status == 'done') {
                    $html .= '<li>
                        <a href="#"  style="margin: 5px;"><button class="btn btn-danger" >Delete</button></a>
                    </li>';
                    }
                    if($item->assiment_status == 'finished') {
                        $html .= '<li>
                            <a href="#"  style="margin: 5px;">Completed </a>
                        </li>';
                    }
                    $html .= '
                </ul>
            </td>
        </tr>';
    }
    return $html;
}
function get_supervisors($warehouse_id) {
    $supervisors  = DB::select("SELECT users.`id` FROM users INNER JOIN users_privilege ON users.id=users_privilege.user_id INNER JOIN warehouse ON users_privilege.warehouseId=warehouse.id WHERE warehouse.id='$warehouse_id' and users_privilege.user_id NOT in (69,70,8) and users.active_id = 1") ;
    $supervisor_ids = '';
    $count = count($supervisors);
    $counter = 0;
    foreach ($supervisors as $supervisor) {

        $counter++;
        if ($counter < $count) {
            $supervisor_ids .= $supervisor->name. ', ';
        } else {
            $supervisor_ids .= $supervisor->name;
        }
    }
    return $supervisor_ids;
}
function onesignal($user_id, $msg, $arMsg = '') {
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.onesignal.com/notifications?c=push",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode([
        'contents' => [
            'en' => $msg,
            'ar' => $arMsg
        ],
        'include_aliases' => [
            'external_id' => [$user_id]
            ]
        ,
        'app_id'=>'039a8b34-ae9b-431e-9ebd-3eb533432d2f',
        'target_channel'=>'push',
      ]),
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json",
        "Authorization: Basic OGVjYTY3NGMtOTQyZi00NGY1LWJhN2ItNjE3YzBkZGRhYzYw"
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // if ($err) {
    //   return false;
    // } else {
    //   return true;
    // }
}

