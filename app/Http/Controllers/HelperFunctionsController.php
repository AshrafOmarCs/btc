<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use DateInterval;
use PHPExcel;
use PHPExcel_IOFactory;


class HelperFunctionsController extends Controller
{
    public static function readCsvData($CSVfp) {
        // $safeName = time().rand(1111,9999).'.csv';
        // $tep->path = 'storage/importSANAD/files/'.$safeName;
        // $CSVfp = fopen(url('').'/'.$tep->path, "r");
        $records = array();
        fgetcsv($CSVfp);
        while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) {
            $records[] = $data;
        }
        fclose($CSVfp);
        return $records;
    }

    public static function readExcelData($filePath, $numCells)
    {
        // $filePath = Storage::disk('public')->path('importSANAD/files/' . $safeName);
        require_once(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $excelReader = PHPExcel_IOFactory::createReaderForFile($filePath);
        $excelObj = $excelReader->load($filePath);
        $worksheet = $excelObj->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        for ($row = $highestRow; $row >= 1; $row--) {
            $cellValue = $worksheet->getCell('A' . $row)->getValue(); // Assuming column A contains data
            if (!empty($cellValue)) {
                $actualHighestRow = $row;
                break;
            }
        }
        $data = [];
        // Loop through each row
        for ($row = 2; $row <= $actualHighestRow; ++$row) {
            $rowData = [];
            // Loop through each cell in the row up to the specified number of cells
            for ($col = 'A'; $col <= chr(64 + $numCells); ++$col) {
                $cellValue = $worksheet->getCell($col . $row)->getValue();
                $rowData[] = $cellValue;
            }
            $data[] = $rowData;
        }
        return $data;
    }
    // Function to evaluate a mathematical expression
    public static function evaluateExpression($expression, $rowData) {
        // Replace column references with corresponding values from the row data
        $expression = preg_replace_callback('/[A-Z]+\d+/', function($match) use ($rowData) {
            list($col, $row) = sscanf($match[0], '%[A-Z]%d');
            $colIndex = ord($col) - 65; // 'A' has ASCII code 65
            return $rowData[$colIndex];
        }, $expression);

        // Evaluate the expression
        $result = null;
        try {
            $result = eval("return $expression;");
        } catch (Throwable $e) {
            // Handle any errors that occur during evaluation
            // For example, if the expression is invalid
            // You can log the error or return a default value
            $result = null;
        }
        return $result;
    }


    public static function getDriverData($driverId) {
        $driver = DB::select("SELECT * FROM drivers WHERE id = '$driverId'");
        return $driver[0];
    }
    public static function getInfo($table, $column = '', $id = '') {
        $whereClause = '';
        if ($column == '')
            $column = 'id';
        if($id != '')
            $whereClause = "WHERE $column = '$id'";
        $result = DB::select("SELECT * FROM $table $whereClause");
        return $result;
    }
    public static function add_log($lastQuery = '', $warehouse_ids = '', $loan_ids = '') {
        $done_by = Auth::user()->id;
        if(!empty($loan_ids))
            $loan_ids = json_encode($loan_ids);
        else
            $loan_ids = null;
        if(!empty($warehouse_ids))
            $warehouse_ids = json_encode($warehouse_ids);
        else
            $warehouse_ids = null;
        $log_id = DB::table('tbl_events_log')->insertGetId([
            'action' => $lastQuery,
            'done_at' => now(),
            'done_by' => $done_by,
            'warehouse_ids' => $warehouse_ids,
            'loan_ids' => $loan_ids
        ]);
        return $log_id;
    }

    // public static function add_log($lastQuery = '', $warehouse_ids = '', $loans_ids = '') {
    //     if($loans_ids != '')
    //         $loans_ids = json_encode($loans_ids);
    //     if($warehouse_ids != '')
    //         $warehouse_ids = json_encode($warehouse_ids);
    //     $done_by = Auth::user()->id;
    //     // if ($lastQuery == '') {
    //     //     $query = DB::getQueryLog();
    //     //     $lastQuery = end($query)['query'];
    //     // }
    //     // $lastQuery = self::clean_string($lastQuery);
    //     DB::insert("INSERT INTO tbl_events_log (action, done_at, done_by, warehouse_ids, loan_ids) VALUES ('$lastQuery', NOW(), '$done_by', '$warehouse_ids', '$loans_ids')");
    // }

    public static function clean_string($str) {
        $special_chars = array("'", "\"", ",", ";", "<", ">", "!", "@", "#", "$", "^", "*", "+", "=", "?", "[", "]", "{", "}", "|", "\\", "~", "`");
        return $str = str_replace($special_chars, "", $str);
    }

    public static function one_year_later_date($date) {
        $oneYearLater = new \DateTime($date);
        $oneYearLater->add(new DateInterval('P1Y'));
        return $oneYearLater->format('Y-m-d');
    }
    public static function generateOTP($digits) {
        $otp = '';
        for ($i = 0; $i < $digits; $i++) {
            $otp .= rand(0, 9);
        }
        return $otp;
    }
    function warehouse_supervisor($warehouse_id) {
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
    public static function send_email($recipients, $ccRecipients, $msg, $subject, $file_path = 1) {
        // $recipients = [
        //     'm.shehroze@btclogistic.com',
        // ];
        try {
            Mail::send([], [], function ($message) use ($recipients, $ccRecipients, $msg, $subject, $file_path) {
                $message->to($recipients)
                        ->cc($ccRecipients)
                        ->subject($subject)
                        ->setBody($msg, 'text/html');
                $file_path = storage_path('app/public/CompanyQuotation/' . $file_path);
                if (file_exists($file_path)) {
                    $message->attach($file_path);
                }

            });

        } catch (Exception $e) {
            // Handle the exception, log the error, or display an error message.
            echo "Error: " . $e->getMessage();
        }
        if (count(Mail::failures()) > 0) {
            return false;
        } else {
            return true;
        }
    }


}
