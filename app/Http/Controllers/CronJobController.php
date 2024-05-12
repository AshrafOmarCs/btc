<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
function make_table($results, $today) {
    $table = '<table style="width:100%; border:1px solid black;">
    <tr>
        <th colspan="6" style="border:1px solid black;background-color: #7CCBDC;">'.$today.'</th>
    </tr>
    <tr>
        <th style="border:1px solid black;background-color: #7CCBDC;">Sr. No</th>
        <th style="border:1px solid black;background-color: #7CCBDC;">Company Name</th>
        <th style="border:1px solid black;background-color: #7CCBDC;">Warehouse Name</th>
        <th style="border:1px solid black;background-color: #7CCBDC;">City</th>
        <th style="border:1px solid black;background-color: #7CCBDC;">Vehicles</th>
        <th style="border:1px solid black;background-color: #7CCBDC;">Supervisors</th>
    </tr>';
    $sr_no = $total = 0;
    $check = false;
    foreach ($results as  $result) {
        $warehouse_id = $result->id;
        $attendance_check  = DB::select("SELECT warehouse_id FROM drivers_attendance WHERE warehouse_id='$warehouse_id' AND `date` = '$today'");
        if (count($attendance_check) == 0) {
            $check = true;
            $warehouseName = $result->warehouseName;
            $companyName = $result->companyName;
            $city_name = $result->name_en;
            $vehicles  = DB::select("SELECT vehicle_id,current_status, warehouseId FROM drivers INNER JOIN vehicles ON drivers.vehicle_id=vehicles.id WHERE vehicle_id IS NOT NULL AND vehicles.current_status='delegeted' AND vehicles.vehicle_opreater_id <> '5' AND vehicles.maintenance_status IS NULL AND warehouseId = '$result->id'");
            if(count($vehicles) == 0)
                continue;
            $total += count($vehicles);
            $supervisor_names = get_supervisors($warehouse_id);
            $table .= '<tr>
            <td style="border:1px solid black;">'.++$sr_no.'</td>
            <td style="border:1px solid black;">'.$companyName.'</td>
            <td style="border:1px solid black;">'.$warehouseName.'</td>
            <td style="border:1px solid black;">'.$city_name.'</td>
            <td style="border:1px solid black;">'.count($vehicles).'</td>
            <td style="border:1px solid black;">'.$supervisor_names.'</td>
            </tr>';
        }
    }
    $table .= '<tr><td style="border:1px solid black; text-align: center" colspan="4">Total</td><td style="border:1px solid black;" colspan="2">'.$total.'</td></tr>';
    $table .= '</table>';
    if ($check) {
        return $table;
    } else {
        return '0';
    }
}

function get_supervisors($warehouse_id) {
    $supervisors  = DB::select("SELECT users.`name` FROM users INNER JOIN users_privilege ON users.id=users_privilege.user_id INNER JOIN warehouse ON users_privilege.warehouseId=warehouse.id WHERE warehouse.id='$warehouse_id' and users_privilege.user_id NOT in (69,70,8) and users.active_id = 1") ;
    $supervisor_names = '';
    $count = count($supervisors);
    $counter = 0;
    foreach ($supervisors as $supervisor) {
        
        $counter++;
        if ($counter < $count) {
            $supervisor_names .= $supervisor->name. ', ';                    
        } else {
            $supervisor_names .= $supervisor->name;
        }
    }
    return $supervisor_names;
}

function get_recipients($results) {
    foreach($results as $result) {
        $supervisor  = DB::select("SELECT users.email,warehouseName,`name` FROM warehouse INNER JOIN users_privilege ON warehouse.id=users_privilege.warehouseId INNER JOIN users ON users_privilege.user_id=users.id WHERE warehouse.id = '$result->id' AND JSON_CONTAINS(allowed_warehouse_attendance, '[$result->id]')");
        if(count($supervisor) > 0)
            $recipients[] = $supervisor[0]->email;
    }
    return $recipients;
}

class CronJobController extends Controller
{
    public function send_email(){
        date_default_timezone_set('Asia/Riyadh');
        $current_time = date('h:i a');
        $today = date("Y-m-d");
        // $today = '2023-08-02';
        // $current_time =  '11:00 pm';
        // dd($today);
        // $results  = DB::select("SELECT DISTINCT warehouse.id,warehouse.warehouseName,lkp_company.companyName,lkp_city.name_en,lkp_city.id as city_id FROM drivers JOIN warehouse ON warehouse.id=drivers.warehouseId JOIN lkp_company ON lkp_company.id=warehouse.companyId INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id WHERE drivers.vehicle_id IS NOT NULL");
        // echo $table = make_table($results, $today);
        // dd('ss');
        if ($current_time == '11:00 pm') {
            $results  = DB::select("SELECT DISTINCT warehouse.id,warehouse.warehouseName,lkp_company.companyName,lkp_city.name_en,lkp_city.id as city_id FROM drivers JOIN warehouse ON warehouse.id=drivers.warehouseId JOIN lkp_company ON lkp_company.id=warehouse.companyId INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id WHERE drivers.vehicle_id IS NOT NULL");
            $table = make_table($results, $today);
            
    
            if ($table !== '0') {
                $msg = '<b>Dear BTC Team</b>,<br ><br >
                This is an automated email to inform you that the mentioned supervisors of the bellow warehouses did not perform the attendance for the date of <b>'.$today.'</b>, Kindly Check the bellow table for more details : <br ><br >';
                $recipient = '';
                $msg .= $table;
                $msg .= '<br /> <br /> <br />';
                $msg .= 'Best Regards. <br />';
                $msg .= 'System generated Email. <br />';
                
                // $recipients = get_recipients($results);
                // dd($recipients);
                
                $recipients = [
                    // 'shehroze511@gmail.com',
                    'samir@btclogistic.com',
                    // 'a.omar@btclogistic.com',
                    // Add more recipients here as needed
                ];
                
                $ccRecipients = [
                    'manager@btclogistic.com',
                    'hr@btclogistic.com',
                    'finance@btclogistic.com',
                    'rayan@btclogistic.com',
                    'waleed.almutairi@btclogistic.com',
                    'a.omar@btclogistic.com'
                ];
                $subject = "Vehicle Attendance Status Report ($today)";
                Mail::send([], [], function ($message) use ($recipients, $ccRecipients, $msg, $subject) {
                    $message->to($recipients)
                            ->cc($ccRecipients)
                            ->subject($subject)
                            ->setBody($msg, 'text/html');
                });
    
                // Optionally, you can check if the email was sent successfully
                if (count(Mail::failures()) > 0) {
                    return response()->json(['message' => 'Failed to send email.'], 500);
                }
    
                return response()->json(['message' => 'Email sent successfully.']);
            }
            return response()->json(['message' => 'No need to send emails.']);
        }else {
            return response()->json(['message' => 'Its Not 11 PM.']);
        }
   }
   
   
   public function vehicle_attendance_test() {
        $today = '2023-11-23';
        $day = 25;
        while ($day > 0) {
            $today = '2023-11-' . $day;
            $day--;
            $vehicles  = DB::select("SELECT * FROM vehicles WHERE vehicle_opreater_id <> '5' AND current_status IN ('damaged','maintenance', 'availabe', 'delegeted')");
            foreach ($vehicles as $vehicle) {
                $driver  = DB::select("SELECT drivers.job_id,drivers.warehouseId,lkp_company.id FROM drivers INNER JOIN warehouse ON warehouse.id=drivers.warehouseId INNER JOIN lkp_company ON lkp_company.id=warehouse.companyId WHERE drivers.vehicle_id = '$vehicle->id'");
                $job_id = $warehouse_id =  $company_id =  $status = '';
                if (count($driver) > 0) {
                    $job_id = $driver[0]->job_id;
                    $warehouse_id = $driver[0]->warehouseId;
                    $company_id = $driver[0]->id;
                    if ($vehicle->current_status == 'delegeted' AND $vehicle->maintenance_status == 1)
                        $status = 'maintenance';
                    else if ($vehicle->current_status == 'delegeted')
                        $status = 'missed attendance';
                    else
                        $status = $vehicle->current_status;
                        echo $vehicle->id . 'aa<br>';
                    } else {
                        $job_id = '';
                        $warehouse_id = '';
                        $company_id = '';
                        $status = $vehicle->current_status;
                        if ($status == 'delegeted')
                            $status = 'availabe';
                        echo $vehicle->id . 'bb<br>';
                    }
                    $attendance_check  = DB::select("SELECT * FROM drivers_attendance WHERE vehicle_id = '$vehicle->id' AND `date` = '$today'");
                    if (count($attendance_check) > 0)
                        continue;
                    echo 'gg';
                    DB::insert("INSERT into drivers_attendance (job_id, company_id, warehouse_id, vehicle_id, `status`, `date`) values ('$job_id', '$company_id', '$warehouse_id', '$vehicle->id', '$status', '$today')");
    
            }
        }
        dd('dd');
        
   }

    public function vehicle_attendance() {
        date_default_timezone_set('Asia/Riyadh');
        $current_time = date('h:i a');
        // $today = '2023-07-12';
        $today = date("Y-m-d");
        if ($current_time == '11:05 pm') {
            $vehicles  = DB::select("SELECT * FROM vehicles WHERE vehicle_opreater_id <> '5' AND current_status IN ('damaged','maintenance', 'availabe', 'delegeted')");
            foreach ($vehicles as $vehicle) {
                $driver  = DB::select("SELECT drivers.job_id,drivers.warehouseId,lkp_company.id FROM drivers INNER JOIN warehouse ON warehouse.id=drivers.warehouseId INNER JOIN lkp_company ON lkp_company.id=warehouse.companyId WHERE drivers.vehicle_id = '$vehicle->id'");
                $job_id = $warehouse_id =  $company_id =  $status = '';
                if (count($driver) > 0) {
                    $job_id = $driver[0]->job_id;
                    $warehouse_id = $driver[0]->warehouseId;
                    $company_id = $driver[0]->id;
                    if ($vehicle->current_status == 'delegeted' AND $vehicle->maintenance_status == 1)
                        $status = 'maintenance';
                    else if ($vehicle->current_status == 'delegeted')
                        $status = 'missed attendance';
                    else
                        $status = $vehicle->current_status;
                } else {
                    $job_id = '';
                    $warehouse_id = '';
                    $company_id = '';
                    $status = $vehicle->current_status;
                    if ($status == 'delegeted')
                        $status = 'availabe';
                }
                $attendance_check  = DB::select("SELECT * FROM drivers_attendance WHERE vehicle_id = '$vehicle->id' AND `date` = '$today'");
                if (count($attendance_check) > 0)
                    continue;
                DB::insert("INSERT into drivers_attendance (job_id, company_id, warehouse_id, vehicle_id, `status`, `date`) values ('$job_id', '$company_id', '$warehouse_id', '$vehicle->id', '$status', '$today')");
            }
            $warehouses = DB::select("SELECT warehouse_id FROM `drivers_attendance` WHERE `date` = '$today' AND `status` = 'missed attendance'");
            // missed attendance supervisors start
            if(count($warehouses) > 0) {
                $warehouseIds = array();
                foreach($warehouses as $warehouse)
                    $warehouseIds[] = $warehouse->warehouse_id;
                $result = DB::select("SELECT users.`id` AS user_id,GROUP_CONCAT(warehouse.id) AS warehouse_ids FROM users INNER JOIN users_privilege ON users.id=users_privilege.user_id INNER JOIN warehouse ON users_privilege.warehouseId=warehouse.id WHERE warehouse.id IN (" . implode(",", $warehouseIds) . ") AND users_privilege.user_id NOT IN (69,70,8) AND users.active_id=1 GROUP BY users.`id`");
                foreach($result as $row)
                {
                    $super_id = $row->user_id;
                    $warehouses = $row->warehouse_ids;
                    DB::insert("INSERT into supervisors_missed_attendance (super_id, date, warehouses) values ('$super_id', '$today', '[$warehouses]')");
                }
            }
            // missed attendance supervisors end
            return response()->json(['message' => 'Done with Vehicle Attendance.']);
        } else {
            return response()->json(['message' => $current_time.'Its Not 11 PM.']);
        }
    }
    
    public function contract_expiry_email() {
        // $recipients = [
        //         'm.shehroze@btclogistic.com',
        //     ];
        //     $ccRecipients = [
        //         // 'shehroze511@gmail.com',
        //     ];
        //     $subject = "Contract with BTC";
        //     $msg = 'testing';
        //     $check = HelperFunctionsController::send_email($recipients, $ccRecipients, $msg, $subject);
            
        //     dd($check);
            
        $today = date("Y-m-d");
        $today = date("Y-m-d");
        $oneMonthLater = date("Y-m-d", strtotime("+1 month", strtotime($today)));
        $results = DB::select("SELECT * FROM contracts_quotations where cont_end_date < '$oneMonthLater' AND expiry_email is null");
        foreach ($results as $result) {
            $id = $result->id;
            $company = $result->companyName;
            DB::update("UPDATE contracts_quotations set expiry_email = '1' where id = '$id'");
            $msg = "Hi $company, <br>Its a gentle reminder that your contract with BTC will be expire after one month please renew it.";
            $msg .= '<br /> <br /> <br />';
            $msg .= 'Best Regards. <br />';
            $msg .= 'System generated Email. <br />';
            $recipients = [
                'm.shehroze@btclogistic.com',
            ];
            $ccRecipients = [
                // 'shehroze511@gmail.com',
            ];
            $subject = "Contract with BTC";
            $check = HelperFunctionsController::send_email($recipients, $ccRecipients, $msg, $subject);
            if ($check == false) {
                return response()->json(['message' => 'Failed to send email.'], 500);
            }
        }
        return response()->json(['message' => 'Emails sent successfully.']);
    }
}