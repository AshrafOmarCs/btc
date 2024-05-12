<?php

namespace App\Http\Controllers;
use Auth;
use App\Vehicle;
use App\Temporary;
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

class VehiclesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function download_vehicles_report(Request $request)
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

        return view('vehicles.vehicle_edit')->with('vehicle', $vehicle)->with('vehicle_models', $vehicle_models)->with('vehicle_opreators', $vehicle_opreators)
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

        
        DB::update("UPDATE vehicles set rent_type = '$request->rent_type', rent_individual = '$request->rent_individual', rent_company_id = '$request->rent_company_id', plate = '$request->plate' $columns,registertion_type = '$request->registertion_type', vehicle_model_id = '$request->vehicle_model_id',
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


        return view('vehicles.vehicle_edit')->with('vehicle', $vehicle)->with('vehicle_models', $vehicle_models)->with('vehicle_opreators', $vehicle_opreators)
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
        $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.rent_type, vehicles.rent_company_id, vehicles.rent_individual, vehicles.maintenance_location, vehicles.vehicle_expiry_date, vehicle_models.name_en as 'vehicle_model',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer',vehicles.plate,vehicles.checkup_id,vehicles.id as 'vehicle_id',vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en as 'vehicle_opreator' FROM `vehicles` 
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
            if($item->checkup_id == ''){
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
            $date1 = new DateTime($item->vehicle_expiry_date);
            $interval = $date1->diff($today);
            $days = $interval->format('%a');
            $item->expiry_days = $days; 
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
            return view('vehicles.index',compact('payload','utilities', 'cities', 'operators', 'manufacturers', 'models', 'operators', 'companies'));
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
        $vehicle_opreater_id = $request->filter_vehicle_opreaterId;
        $filter_vehicle_manufecturerId = $request->filter_vehicle_manufecturerId;
        $filter_modelId = $request->filter_modelId;
        $filter_otometer = $request->filter_otometer;
        $filter_otometer_value = $request->filter_otometer_value;

        $city_name = $request->city_name;
        $type = $request->type;

        $company_clause = "";
        if ($company_id > 0)
            $company_clause = "AND lkp_company.id = $company_id";
        $warehouse_clause = "";
        if ($warehouse_id > 0)
            $warehouse_clause = "AND warehouse.id = $warehouse_id";

        $city_clause = "";
        if ($city_id > 0)
            $city_clause = "AND vehicles.city_id = $city_id";
        $status_clause = "";
        if ($status != '')
            $status_clause = "AND vehicles.current_status = '$status'";
        if ($status == 'maintenance')
            $status_clause = "AND (vehicles.current_status = '$status' OR vehicles.maintenance_status = '1')";
        $operator_clause = "";
        if ($vehicle_opreater_id > 0)
            $operator_clause = "AND vehicles.vehicle_opreater_id = $vehicle_opreater_id";


        $manufecturer_clause = "";
        if ($filter_vehicle_manufecturerId > 0)
            $manufecturer_clause = "AND vehicle_models.vehicle_manufacturer_id = $filter_vehicle_manufecturerId";
        $model_clause = "";
        if ($filter_modelId > 0)
            $model_clause = "AND vehicles.vehicle_model_id = $filter_modelId";
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
            $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.vehicle_expiry_date,vehicles.maintenance_location,vehicle_models.name_en AS vehicle_model,vehicle_models.manufacturer_date,vehicle_manufacturers.name_en AS vehicle_manufacturer,vehicles.plate,vehicles.checkup_id,vehicles.id AS vehicle_id,vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en AS vehicle_opreator FROM vehicles JOIN vehicle_models ON vehicle_models.id=vehicles.vehicle_model_id JOIN vehicle_manufacturers ON vehicle_manufacturers.id=vehicle_models.vehicle_manufacturer_id JOIN lkp_city ON lkp_city.id=vehicles.city_id JOIN vehicle_opreators ON vehicle_opreators.id=vehicles.vehicle_opreater_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id
                WHERE 1 = 1 $company_clause $warehouse_clause $city_clause $AND $status_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause";
        } else {
            $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.vehicle_expiry_date, vehicles.maintenance_location, vehicle_models.name_en as 'vehicle_model',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer',vehicles.plate,vehicles.checkup_id,vehicles.id as 'vehicle_id',vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en as 'vehicle_opreator' FROM `vehicles`
                    JOIN vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
                    JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
                    JOIN lkp_city ON lkp_city.id = vehicles.city_id
                    JOIN vehicle_opreators ON vehicle_opreators.id = vehicles.vehicle_opreater_id
                    WHERE 1 = 1 $city_clause $AND $status_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause";
        }
        $columns = ['no', 'plate', 'fuel_data', 'oil_data', 'vehicle_expiry_date', 'name_en', 'vehicle_manufacturer', 'vehicle_model', 'vehicle_opreator', 'color', 'vehicle_registration_expire_date', 'vehicle_utilities_html', 'otometer', 'registertion_type', 'current_status', 'maintenance_location', 'response1', 'response2'];
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $search = $request->input('search.value');
        if (!empty($search)) {
            $payload = DB::select($sql);
            $totalData = count($payload);

            $sql .= " AND plate LIKE '%$search%' OR vehicle_expiry_date LIKE '%$search%' OR vehicle_manufacturers.name_en LIKE '%$search%' OR vehicle_models.name_en LIKE '%$search%' OR vehicle_opreators.name_en LIKE '%$search%' OR color LIKE '%$search%' OR vehicle_registration_expire_date LIKE '%$search%' OR otometer LIKE '%$search%' OR registertion_type LIKE '%$search%' OR current_status LIKE '%$search%' OR maintenance_location LIKE '%$search%' ORDER BY vehicles.id $dir LIMIT $start, $limit";
            $payload = DB::select($sql);
            $totalFiltered = count($payload);
        } else {
            $payload = DB::select($sql);
            $totalData = count($payload);
            $totalFiltered = $totalData;
            $sql .= " ORDER BY $order $dir LIMIT $start, $limit";
            $payload = DB::select($sql);
        }
        foreach ($payload as $key => $item) {
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
            if($item->checkup_id == ''){
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
            $date1 = new DateTime($item->vehicle_expiry_date);
            $interval = $date1->diff($today);
            $days = $interval->format('%a');
            $item->expiry_days = $days;
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
            else if (count($check_oil) > 1 && $item->oil_check != 1) {
                $item->oil_data = '<button style="color: black !important; background-color: red;" class="btnaction btn menu-icon vd_bd-red vd_red" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
            } else {
                $item->oil_data = '<button class="btnaction btn menu-icon vd_bd-yellow vd_yellow" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
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
    
    
    public function search_old(Request $request)
    {
        $toDay = date("Y-m-d");
        $today = new DateTime(); // Current date
        $city_id = $request->filter_cityId;
        $company_id = $request->filter_companyId;
        $warehouse_id = $request->filter_warehouseId;
        $type = $request->type;
        $status = $request->filter_status;
        $vehicle_opreater_id = $request->filter_vehicle_opreaterId;
        $filter_vehicle_manufecturerId = $request->filter_vehicle_manufecturerId;
        $filter_modelId = $request->filter_modelId;
        $filter_otometer = $request->filter_otometer;
        $filter_otometer_value = $request->filter_otometer_value;

        $city_name = $request->city_name;
        $type = $request->type;

        $company_clause = "";
        if ($company_id > 0)
            $company_clause = "AND lkp_company.id = $company_id";
        $warehouse_clause = "";
        if ($warehouse_id > 0)
            $warehouse_clause = "AND warehouse.id = $warehouse_id";
            
        $city_clause = "";
        if ($city_id > 0)
            $city_clause = "AND vehicles.city_id = $city_id";
        $status_clause = "";
        if ($status != '')
            $status_clause = "AND vehicles.current_status = '$status'";
        if ($status == 'maintenance')
            $status_clause = "AND (vehicles.current_status = '$status' OR vehicles.maintenance_status = '1')";
        $operator_clause = "";
        if ($vehicle_opreater_id > 0)
            $operator_clause = "AND vehicles.vehicle_opreater_id = $vehicle_opreater_id";
            
        
        $manufecturer_clause = "";
        if ($filter_vehicle_manufecturerId > 0)
            $manufecturer_clause = "AND vehicle_models.vehicle_manufacturer_id = $filter_vehicle_manufecturerId";
        $model_clause = "";
        if ($filter_modelId > 0)
            $model_clause = "AND vehicles.vehicle_model_id = $filter_modelId";
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
            $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.vehicle_expiry_date,vehicles.maintenance_location,vehicle_models.name_en AS vehicle_model,vehicle_models.manufacturer_date,vehicle_manufacturers.name_en AS vehicle_manufacturer,vehicles.plate,vehicles.checkup_id,vehicles.id AS vehicle_id,vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en AS vehicle_opreator FROM vehicles JOIN vehicle_models ON vehicle_models.id=vehicles.vehicle_model_id JOIN vehicle_manufacturers ON vehicle_manufacturers.id=vehicle_models.vehicle_manufacturer_id JOIN lkp_city ON lkp_city.id=vehicles.city_id JOIN vehicle_opreators ON vehicle_opreators.id=vehicles.vehicle_opreater_id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id
                WHERE 1 = 1 $company_clause $warehouse_clause $city_clause $AND $status_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause";
        } else {
            $sql = "SELECT vehicles.oil_check, vehicles.allowed_fuel_price, vehicles.fuel_check, vehicles.vehicle_expiry_date, vehicles.maintenance_location, vehicle_models.name_en as 'vehicle_model',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer',vehicles.plate,vehicles.checkup_id,vehicles.id as 'vehicle_id',vehicles.freeExtraOtometer,vehicles.SNno,vehicles.body_number,vehicles.current_status,vehicles.otometer,vehicles.vehicle_registration_expire_date,vehicles.recive_date,vehicles.registertion_type,vehicles.extraOtometerCharge,vehicles.color,lkp_city.name_en,vehicle_opreators.name_en as 'vehicle_opreator' FROM `vehicles` 
                    JOIN vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id
                    JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id
                    JOIN lkp_city ON lkp_city.id = vehicles.city_id
                    JOIN vehicle_opreators ON vehicle_opreators.id = vehicles.vehicle_opreater_id
                    WHERE 1 = 1 $city_clause $AND $status_clause $operator_clause $manufecturer_clause $model_clause $otometer_clause order by vehicles.id";
        }
        $payload = DB::select($sql);
        foreach ($payload as $key => $item) {
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
            if($item->checkup_id == ''){
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
            $date1 = new DateTime($item->vehicle_expiry_date);
            $interval = $date1->diff($today);
            $days = $interval->format('%a');
            $item->expiry_days = $days; 
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
            else if (count($check_oil) > 1 && $item->oil_check != 1) {
                $item->oil_data = '<button style="color: black !important; background-color: red;" class="btnaction btn menu-icon vd_bd-red vd_red" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
            } else {
                $item->oil_data = '<button class="btnaction btn menu-icon vd_bd-yellow vd_yellow" onclick="oil_info('.$item->vehicle_id.')">Oil <i class="fa fa-eye"></i></button></ul>';
            }
        } 
        $response = get_vehicle_table_body_old($payload, $city_name);
        return $response;
    }
    public function utilitiesUpdate(Request $request) {
        // dd($request);
        $user_id = Auth::user()->id;
        $vehicleId = $request->vehicle_id;
        // $ac_condition = $request->ac_condition;
        // $radio_condition = $request->radio_condition;
        // $interioirScreen_condition = $request->interioirScreen_condition;
        // $speedoMeter_condition = $request->speedoMeter_condition;
        // $interioirUpholstery_condition = $request->interioirUpholstery_condition;
        // $spareTireEquipment_condition = $request->spareTireEquipment_condition;
        // $wheels_condition = $request->wheels_condition;
        // $spareWheel_condition = $request->spareWheel_condition;
        // $fistAidKit_condition = $request->fistAidKit_condition;
        // $key_condition = $request->key_condition;
        // $fistExtinguisher_condition = $request->fistExtinguisher_condition;
        // $availabilityofTriangle_condition = $request->availabilityofTriangle_condition;
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
        
        $sql = "SELECT requests.id as 'requests_id', requests.status,requests.created_at as 'request_issue_date',requests.created_by,requests.supporvisor_identity_approve,requests.vehicle_check_id,request_types.name_en,vehicles.*,vehicle_checks.admin_approve_by,vehicle_models.name_en as 'vName',vehicle_models.manufacturer_date,vehicle_manufacturers.name_en as 'vehicle_manufacturer_name',lkp_city.name_en as 'city_name',vehicle_opreators.name_en as 'opreatoers',drivers.fullName,drivers.job_id,drivers.id as 'driver_id',drivers.driver_data FROM `requests` JOIN request_types on request_types.id = requests.request_type_id JOIN vehicles ON vehicles.id = requests.vehicle_id JOIN vehicle_checks on vehicle_checks.id = requests.vehicle_check_id join vehicle_models ON vehicle_models.id = vehicles.vehicle_model_id JOIN vehicle_manufacturers ON vehicle_manufacturers.id = vehicle_models.vehicle_manufacturer_id join lkp_city on lkp_city.id = vehicles.city_id JOIN vehicle_opreators on vehicle_opreators.id = vehicles.vehicle_opreater_id JOIN drivers on drivers.id = requests.driverId";
        $payload = DB::select($sql);  
        
        if(count($payload)>0){
            
            foreach($payload as $k=>$item){ 
                if($item->supporvisor_identity_approve == 0){
                }else{
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
        return view('vehicles.requestCentral',compact('payload'));
    }
    public function approval_review($driver_id){
        $drivers = "SELECT drivers.id,drivers.fullName,drivers.iqama,drivers.identityProof,drivers.licence_no,drivers.licenseProof,warehouse.warehouseName,lkp_company.companyName FROM `drivers` JOIN warehouse on warehouse.id = drivers.warehouseId JOIN lkp_company on lkp_company.id = warehouse.companyId where drivers.id =".$driver_id." ";
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
                $html = "
            <tr>
                <td>".$vehicle_utlity_previewItem['name_en']."</td>
                <td style='color:red'>".$vehicle_utlity_previewItem['current_status']."</td>
                <td style='color:red'>".$vehicle_utlity_previewItem['checkup_status']."</td>
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
        
       
        $prive_checkUp = "SELECT * FROM `vehicles` WHERE id=".$checkUp[0]->vehicle_id." ";
        $prive_checkUp = DB::select($prive_checkUp); 
        
        $prive_checkup_utlities = '';
  
        if(count($prive_checkUp)>0){
            
            if($prive_checkUp[0]->checkup_id == null){
                // there is no priv check-ups its new vehicle 
                // dd('no priv check-ups ');
                $prive_checkUp = null; 
            }else{
                $prive_checkUp = null; 
            }
            
        }
        $payload = [
                'checkUp'=>$checkUp[0],
                'privCheckUp'=>$prive_checkUp[0],
                'checkUp_utlities'=>$vehicle_utlity_preview,
                'accssorieTable'=>$accssorieTable
        ]; 
        return response()->json(['status'=>true,'data'=>$payload],200);
    }
    function accessoriesHandler(Request $request){
        // dd($request->payload['action']);
        if($request->payload['action'] == 'approve'){
            $payload = Vehicle_checkUp_utlitie::where('vehicle_check_id',$request->payload['check_id'])->get();
 

            foreach($payload as $k=>$item){
                // $payload
                $item->approval = 'approved'; 
                $item->updated_by = Auth::user()->id;
                $item->save(); 
                // return response()->json(['status'=>true,"payload"=>$item],200);
            }
            // dd($request->payload['check_id']);
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
                
        }else{
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
            
            
        }
        
        
    }
    function checkUpImageHandler(Request $request){
        $check_id = $request->payload['check_id'];
        $vehicleCheckup = VehicleCheckup::find($check_id);
        // dd($vehicleCheckup);
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
            
            $assign_vehicle = Assign_vehicle::where('checkup_id',$request->payload['check_id'])->get();
            if(count($assign_vehicle)>0){
                if($flag == true){
                    $assign_vehicle[0]->status = 'image_rejected';
                }else{
                    $assign_vehicle[0]->status = 'image_accepted';
                }
                
                if($request->payload['rejction_reason'] == null)
                    $assign_vehicle[0]->rejection_reason = $request->payload['rejction_reason'];
                else
                    $assign_vehicle[0]->rejection_reason = null;
                
                $assign_vehicle[0]->save(); 
            }
        }
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
        return view('vehicles.fuel_save');
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
    $vehicle = DB::select("SELECT drivers.job_id, drivers.fullName,warehouse.warehouseName,lkp_company.companyName,lkp_city.name_en AS city_name FROM vehicles INNER JOIN vehicle_models ON vehicles.vehicle_model_id=vehicle_models.id INNER JOIN drivers ON vehicles.id=drivers.vehicle_id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id WHERE vehicles.id='$vehicle_id'");
    // dd($vehicle);
    if(count($vehicle) > 0) {
        $vehicle_info['driver_name'] = $vehicle[0]->fullName;
        $vehicle_info['city_name'] = $vehicle[0]->city_name;
        $vehicle_info['company_name'] = $vehicle[0]->companyName;
        $vehicle_info['warehouse_name'] = $vehicle[0]->warehouseName;
        $vehicle_info['job_id'] = $vehicle[0]->job_id;
    } else {
        $vehicle_info['driver_name'] = '';
        $vehicle_info['city_name'] = '';
        $vehicle_info['company_name'] = '';
        $vehicle_info['warehouse_name'] = '';
        $vehicle_info['job_id'] = '';
    }
    return $vehicle_info;
} 
function get_vehicle_table_body($payload, $city_name = null)
{
    $data = [];
    $no = 0;
    foreach ($payload as $k=>$item) {
        $days = $color = '';
        $expiry_days = 0;
        if($item->expiry_days > 0) {
            $color = 'red';
            $expiry_days = $item->expiry_days;
            // $days = 'days';
        }
        $resp = '<center style="color: '.$color.'">'.$expiry_days.' '.$days.'</center>';
        $response1 = '<span style="color: #F79013;">'.$item->delegation_info["job_id"].'</span><br>'.$item->delegation_info["driver_name"].' <br> '.$item->delegation_info["city_name"].' <br> '.$item->delegation_info["company_name"].' <br> '.$item->delegation_info["warehouse_name"];
        $response2 = '<a onclick="vehicleExtraInfo('."'".$item->images."'".",'','".$item->name_en."','".$item->vehicle_manufacturer."','".$item->manufacturer_date."','".$item->vehicle_model."','".$item->vehicle_opreator."','".$item->SNno."','".$item->body_number."','".$item->freeExtraOtometer."','','".$item->extraOtometerCharge."','".$item->otometer."','".$item->registertion_type."','".$item->current_status."','".$item->color."','".$item->vehicle_registration_expire_date."')".'" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
        <a onclick="vehicleEdit('. $item->vehicle_id .')" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>
        <a data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-history" aria-hidden="true"></i> </a>';

        if($item->checkup_id == '') {
            $response2 .= '<a onclick="addVehicleCheckup('."'".$item->vehicle_id."'".', '."'".$item->vehicle_manufacturer."'".', '."'".$item->vehicle_model."'".', '."'".$item->manufacturer_date."'".', '."'".$item->plate."'".', '."'".$item->SNno."'".')" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-check-square" aria-hidden="true"></i> </a>';
        } else {
            if($item->vehicle_utilities =='')  {
                $response2 .= '<a href="'.url('/Vehicles/vehicle-checkup-utilities/'.$item->checkup_id).'" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view">Set vehicle accessories </a>';
            }
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
            'vehicle_utilities_html' => $item->vehicle_utilities_html,
            'otometer' => $item->otometer,
            'registertion_type' => $item->registertion_type,
            'current_status' => $item->current_status,
            'maintenance_location' => $item->maintenance_location,
            'response1' => $response1,
            'response2' => $response2,

        ];
    }
    return $data;
}
function get_vehicle_table_body_old($payload, $city_name = null)
{
    $response = '';
    $no = 0;
    foreach ($payload as $k=>$item) {
        $days = $color = '';
        $expiry_days = 0;
        if($item->expiry_days > 0) {
            $color = 'red';
            $expiry_days = $item->expiry_days;
            // $days = 'days';
        }
        $response .= '<tr>
            <td scope="col">'.++$no.'</td>
            <td scope="col">'.$item->plate.'</td>';
            if ($city_name == null) { 
                $response .= '<td scope="col">'.$item->fuel_data.'</td>
                <td scope="col">'.$item->oil_data.'</td>';
            }
            $response .= '<td scope="col"><center style="color: '.$color.'">'.$expiry_days.' '.$days.'</center></td>
            <td scope="col">'.$item->name_en.' </td>
            <td scope="col">'.$item->vehicle_manufacturer.' </td>
            <td scope="col">'.$item->vehicle_model.', '.$item->manufacturer_date.'</td> 
            <td scope="col">'.$item->vehicle_opreator.' </td> 
            <td scope="col">'.$item->color.' </td> 
            <td scope="col">'.$item->vehicle_registration_expire_date.' </td>';
            if ($city_name == null) {
            $response .= '<td scope="col"> 
                <ul>
                    '.$item->vehicle_utilities_html.'
                </ul> 
            </td>';
            }
            $response .= '<td scope="col">'.$item->otometer.' </td> 
            <td scope="col"> '.$item->registertion_type.' </td> 
            <td scope="col"> '.$item->current_status.'  </td> 
            <td scope="col"> '.$item->maintenance_location.'  </td>'; 
            if ($city_name == null) {
            $response .= '<td scope="col"><span style="color: #F79013;">'.$item->delegation_info["job_id"].'</span><br>'.$item->delegation_info["driver_name"].' <br> '.$item->delegation_info["city_name"].' <br> '.$item->delegation_info["company_name"].' <br> '.$item->delegation_info["warehouse_name"].'</td>
            <td scope="col">
                <a onclick="vehicleExtraInfo('."'".$item->images."'".",'','".$item->name_en."','".$item->vehicle_manufacturer."','".$item->manufacturer_date."','".$item->vehicle_model."','".$item->vehicle_opreator."','".$item->SNno."','".$item->body_number."','".$item->freeExtraOtometer."','','".$item->extraOtometerCharge."','".$item->otometer."','".$item->registertion_type."','".$item->current_status."','".$item->color."','".$item->vehicle_registration_expire_date."')".'" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>

                <a onclick="vehicleEdit('. $item->vehicle_id .')" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>
                <a data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-history" aria-hidden="true"></i> </a>';
                    
                if($item->checkup_id == '') {
                    $response .= '<a onclick="addVehicleCheckup('."'".$item->vehicle_id."'".', '."'".$item->vehicle_manufacturer."'".', '."'".$item->vehicle_model."'".', '."'".$item->manufacturer_date."'".', '."'".$item->plate."'".', '."'".$item->SNno."'".')" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-check-square" aria-hidden="true"></i> </a>';
                } else {
                    if($item->vehicle_utilities =='')  {
                        $response .= '<a href="'.url('/Vehicles/vehicle-checkup-utilities/'.$item->checkup_id).'" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view">Set vehicle accessories </a>';
                    }
                }
        $response .= '</td>';
        }
        $response .= '</tr>';
    }
    return $response;
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

