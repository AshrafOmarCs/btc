<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;
use Auth;
use DB;
use Illuminate\Http\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use Illuminate\Validation\ValidationException;
use DateTime;
use App\Temporary;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AutomationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index() {
        $companies = DB::select("SELECT * FROM lkp_company WHERE status = 'active'");
        return view('new_porttal.Automation.index')->with('companies', $companies);
    }
    function index_new() {
        $actions = DB::select("SELECT tbl_actions.*, users.name FROM tbl_actions join users on tbl_actions.created_by = users.id");
        foreach ($actions as $action) {
            $warehouse = "";
            $jahiz_ids = $action->jahiz_ids;
            $settlement_ids = $action->ids;
            $jahizs = DB::select("SELECT SUM(cash) as total FROM drivers_jahiz_clearing WHERE drivers_jahiz_clearing.id in ($jahiz_ids)");
            $action->total = $jahizs[0]->total;
            $settlements = DB::select("SELECT distinct warehouse.warehouseName FROM drivers_saned_settlement join drivers ON drivers.job_id = drivers_saned_settlement.AMP_ID JOIN warehouse ON warehouse.id = drivers.warehouseId WHERE drivers_saned_settlement.id in ($settlement_ids) order by drivers.id");
            foreach ($settlements as $settlement) {
                $warehouse .= $settlement->warehouseName . " ";
            }
            $action->warehouse = $warehouse;
        }
        return view('new_porttal.Automation.index_new')->with('actions', $actions);
    }
    function rejectSettlement($id) {
        $action = DB::select("SELECT tbl_actions.ids, tbl_actions.jahiz_ids FROM tbl_actions WHERE tbl_actions.id = '$id'");
        $settlement_ids = explode(",", $action[0]->ids);
        $user_id = Auth::user()->id;
        $made_by = Auth::user()->name;
        $msg = "<b>$made_by</b> Rejected these settlements.";
        HelperFunctionsController::add_log($msg, '', $settlement_ids);
        DB::delete("DELETE from tbl_actions WHERE id = '$id'");
        return back()->with('success', 'Rejected successfully');
    }
    function getSettlement($id) {
        $action = DB::select("SELECT tbl_actions.*, users.name FROM tbl_actions join users on tbl_actions.created_by = users.id WHERE tbl_actions.id = '$id'");
        $settlement_ids = $action[0]->ids;
        $jahiz_ids = $action[0]->jahiz_ids;
        $settlements = DB::select("SELECT drivers_saned_settlement.*, warehouse.warehouseName FROM drivers_saned_settlement join drivers ON drivers.job_id = drivers_saned_settlement.AMP_ID JOIN warehouse ON warehouse.id = drivers.warehouseId WHERE drivers_saned_settlement.id in ($settlement_ids) order by drivers.id");
        $jahizs = DB::select("SELECT cash FROM drivers_jahiz_clearing join drivers ON drivers_jahiz_clearing.driverId = drivers.id WHERE drivers_jahiz_clearing.id in ($jahiz_ids) order by drivers.id");
        return view('new_porttal.Actions.getSettlement')->with('action', $action)->with('settlements', $settlements)->with('jahizs', $jahizs);
    }
    function acceptSettlement(Request $request) {
        $id = $request->id;
        DB::update("UPDATE tbl_actions set status = 'Closed' WHERE id = '$id'");
        $action = DB::select("SELECT tbl_actions.ids, tbl_actions.jahiz_ids FROM tbl_actions WHERE tbl_actions.id = '$id'");
        $settlement_ids = explode(",", $action[0]->ids);
        $jahiz_ids = explode(",", $action[0]->jahiz_ids);
        $date = date("Y-m-d H:i:s");
        $i = 0;
        $user_id = Auth::user()->id;
        $made_by = Auth::user()->name;
        foreach($settlement_ids as $id) {
            DB::update("UPDATE drivers_saned_settlement
            SET status = 'Paid', exported_by = '$user_id', updated_by = '$user_id', updated_at = NOW(), drivers_jahiz_clearing_paid_id = " . $jahiz_ids[$i] . ",
            paid_dt = '" . $date . "',
            paid_by_id = " . Auth::user()->id . "
            where id = " . $id);
            $i++;
        }
        $i = 0;
        foreach($jahiz_ids as $id) {
            DB::update("UPDATE drivers_jahiz_clearing
            SET updated_by_id = '$user_id', updated_at = NOW(), paid_id = " . $settlement_ids[$i] . ",
            paid_dt = '" . $date . "',
            paid_by_id = " . Auth::user()->id . "
            where id = " . $id);
            $i++;
        }
        $msg = "<b>$made_by</b> Paid these settlements.";
        HelperFunctionsController::add_log($msg, '', $settlement_ids);
        return back()->with('success', 'Done');
    }
    public function download_file(Request $request)
    {
        $download_type = $request->input('download_type');

        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        require(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        if($download_type == 'note' || $download_type == 'settlement') {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Hub name')
            ->setCellValueExplicit('B1', 'AMP/Job id')
            ->setCellValueExplicit('C1', 'Name')
            ->setCellValueExplicit('D1', 'Note')
            ->setCellValueExplicit('E1', 'Amount')
            ;
        } else if($download_type == 'daily') {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A1', 'Hub name')
            ->setCellValueExplicit('B1', 'AMP/Job id')
            ->setCellValueExplicit('C1', 'Name')
            ->setCellValueExplicit('D1', 'Amount')
            ;
        }

        // $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(37.89);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(24);

        $objPHPExcel->setActiveSheetIndex(0);
        $date = date("Y-m-d H-i-s");
        $type = $request->type;
        $fileName = 'Excel_' . $download_type . $date . '.xlsx';
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

    function upload_file(Request $request) {
        $user_id = Auth::user()->id;
        $credit_debbit = $request->input('credit_debit');

        if(null == $request->input('credit_debit'))
            $credit_debbit = $request->input('credit_debbit');

        $date = now()->toDateTimeString();
        $status_id = $request->input('status_id');
        $createdby_id = $updatedby_id = 75;
        $journal_date = $request->input('journal_date');
        $journal_check = $request->input('journal_check');
        $note = $request->input('note');
        $made_by = Auth::user()->name;
        require_once(app_path() . '/Libraries/PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php');
        $loan_id = array();
        if(isset($request->ACTION)) {
            //  This section is for Insert and Rollback
            try {
                $journal_date = $request->input('journal_date_1');
                $SQL = $request->input('SQL');
                if ($request->ACTION == 'R-Salary') {
                    $loans = DB::select("$SQL");
                    foreach($loans as $loan) {
                        $id = $loan->id;
                        $job_id = $loan->job_id;
                        $loan_id[] = $id;
                        DB::delete("DELETE from journal where id = '$id'");
                        // DB::delete("DELETE from packages_report where journal_id = '$id'");
                    }
                    $act = "<b>$made_by</b> deleted the Salaries";
                    HelperFunctionsController::add_log($act, '', $loan_id);
                    $done = 'deleted';
                } else if ($request->ACTION == 'R-Loan') {
                    $loans = DB::select("$SQL");
                    foreach($loans as $loan) {
                        $id = $loan->id;
                        $loan_id[] = $id;
                        $check = DB::select("SELECT journal_id FROM loan WHERE id = '$id'");
                        if(count($check) > 0) {
                            $journal_id = $check[0]->journal_id;
                            DB::delete("DELETE from journal where id = '$journal_id'");
                        }
                        DB::delete("DELETE from loan where id = '$id'");
                    }
                    $act = "<b>$made_by</b> deleted the Loans";
                    HelperFunctionsController::add_log($act, '', $loan_id);
                    $done = 'deleted';
                } else if ($request->ACTION == 'R-CreditNote') {
                    $loan_id = $request->input('loan_id');
                    foreach($loan_id as $id ) {
                        $check = DB::select("SELECT journal_id FROM creditnotes WHERE id = '$id'");
                        if(count($check) > 0) {
                            $journal_id = $check[0]->journal_id;
                            DB::delete("DELETE from journal where id = '$journal_id'");
                        }
                        DB::delete("DELETE from creditnotes where id = '$id'");
                    }
                    $done = 'deleted';
                } else if ($request->ACTION == 'R-Settlement') {
                    $loan_id = $request->input('loan_id');
                    foreach($loan_id as $id ) {
                        $check = DB::select("SELECT journal_id FROM settlements WHERE id = '$id'");
                        if(count($check) > 0) {
                            $journal_id = $check[0]->journal_id;
                            DB::delete("DELETE from journal where id = '$journal_id'");
                        }
                        DB::delete("DELETE from settlements where id = '$id'");
                    }
                    $done = 'deleted';
                } else {
                    $journal_date = $request->input('journal_date');
                    $journal_date = Carbon::parse($journal_date)->format('Y-m-d');
                    $done = 'updated';
                    $safeName = basename($request->input('path'));
                    $filePath = Storage::disk('public')->path('journal/imile/' . $safeName);
                    $excelReader = PHPExcel_IOFactory::createReaderForFile($filePath);
                    $excelObj = $excelReader->load($filePath);
                    $worksheet = $excelObj->getSheet(0);
                    $highestRow = $worksheet->getHighestRow();

                    if($request->ACTION == 'Settlement') {
                        for ($row = 2; $row <= $highestRow; $row++) {
                            $warehouse = $worksheet->getCell('A' . $row)->getValue();
                            $data = DB::select("SELECT warehouse.id, companyName FROM lkp_company INNER JOIN warehouse ON lkp_company.id=warehouse.companyId WHERE warehouse.warehouseName = '$warehouse'");
                            $warehouse_id = $data[0]->id;
                            $data = $data[0]->companyName;
                            $job_id = $worksheet->getCell('B' . $row)->getValue();
                            $name = $worksheet->getCell('C' . $row)->getValue();
                            $note = $worksheet->getCell('D' . $row)->getValue();
                            $credit = $debit = 0;
                            if ($credit_debbit == 'credit')
                                $credit = $worksheet->getCell('E' . $row)->getValue();
                            if ($credit_debbit == 'debit')
                                $debit = $worksheet->getCell('E' . $row)->getValue();

                            // dd($credit_debbit);
                            $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                            if (count($driver) > 0) {
                                $driverId = $driver[0]->id;
                            } else {
                                $driverId = DB::table('drivers')->insertGetId([
                                    'warehouseId' => $warehouse_id,
                                    'fullName' => $name,
                                    'job_id' => $job_id,
                                    'created_by_id' => $user_id,
                                    'updated_by_id' => $user_id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                            $check = DB::select("SELECT driverId FROM settlements WHERE driverId = '$driverId' AND journal_date = '$journal_date'");
                            if(count($check) > 0) { } else {
                                $settlement_id = DB::table('settlements')->insertGetId([
                                    'driverId' => $driverId,
                                    'journal_date' => $journal_date,
                                    'credit' => $credit,
                                    'debit' => $debit,
                                    'note' => $note,
                                    'createdby_id' => $user_id,
                                    'updatedby_id' => $user_id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);

                                if ($journal_check == 'on') {
                                    $journal_id = DB::table('journal')->insertGetId([
                                        'driverId' => $driverId,
                                        'journal_date' => $journal_date,
                                        'credit' => $credit,
                                        'debit' => $debit,
                                        'note' => $note,
                                        'status' => 'Paid',
                                        'post_id' => $settlement_id,
                                        'journal_type_id' => '7',
                                        'createdby_id' => $user_id,
                                        'updatedby_id' => $user_id,
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                    DB::update("UPDATE settlements set journal_id = '$journal_id' WHERE id = '$settlement_id'");
                                }
                            }
                        }
                    } else if ($request->ACTION == 'Loan' || $request->ACTION == 'Loans') {
                        for ($row = 2; $row <= $highestRow; $row++) {
                            $warehouse = $worksheet->getCell('A' . $row)->getValue();
                            $data = DB::select("SELECT warehouse.id, companyName FROM lkp_company INNER JOIN warehouse ON lkp_company.id=warehouse.companyId WHERE warehouse.warehouseName = '$warehouse'");
                            $warehouse_id = $data[0]->id;
                            $data = $data[0]->companyName;

                            $job_id = $worksheet->getCell('B' . $row)->getValue();
                            $name = $worksheet->getCell('C' . $row)->getValue();
                            $amount = $worksheet->getCell('D' . $row)->getValue();
                            $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                            if (count($driver) > 0) {
                                $driverId = $driver[0]->id;
                            } else {
                                $driverId = DB::table('drivers')->insertGetId([
                                    'warehouseId' => $warehouse_id,
                                    'fullName' => $name,
                                    'job_id' => $job_id,
                                    'created_by_id' => $user_id,
                                    'updated_by_id' => $user_id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                            $credit = DB::select("SELECT sum(credit) as credit FROM journal WHERE `driverId` = '$driverId'");
                            $current_credit = $credit[0]->credit;
                            $debit = DB::select("SELECT sum(debit) as debit FROM journal WHERE  `driverId` = '$driverId'");
                            $current_debit = $debit[0]->debit;
                            $current_balance = round($current_credit - $current_debit, 2);
                            if ($request->ACTION == 'Loan') {
                                $expected = $amount;
                            } else {
                                if($current_balance >= 0) {
                                    $expected = $amount;
                                } else if ($current_balance < 0) {
                                    $expected = $current_balance + $amount;
                                }
                                if (round($expected) <= 0) {
                                    continue;
                                }
                            }
                            $check_amount = round($expected);
                            $check = DB::select("SELECT driverId FROM loan WHERE driverId = '$driverId' AND journal_date = '$journal_date' AND amount = '$check_amount'");
                            if(count($check) > 0) { } else {
                                $loan_id = DB::table('loan')->insertGetId([
                                    'driverId' => $driverId,
                                    'journal_date' => $journal_date,
                                    'amount' => $check_amount,
                                    'note' => $note[0],
                                    'createdby_id' => $user_id,
                                    'updatedby_id' => $user_id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                    'status_id' => $status_id
                                ]);
                                if ($status_id == '4') {
                                    $journal_id = DB::table('journal')->insertGetId([
                                        'driverId' => $driverId,
                                        'journal_date' => $journal_date,
                                        'debit' => $check_amount,
                                        'note' => $note[0],
                                        'post_id' => $loan_id,
                                        'journal_type_id' => '1',
                                        'createdby_id' => $user_id,
                                        'updatedby_id' => $user_id,
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                    DB::update("UPDATE loan set journal_id = '$journal_id' WHERE id = '$loan_id'");
                                }
                            }
                        }
                    } else if($request->ACTION == 'CreditNote') {
                        for ($row = 2; $row <= $highestRow; $row++) {
                            $warehouse = $worksheet->getCell('A' . $row)->getValue();

                            $data = DB::select("SELECT warehouse.id, companyName FROM lkp_company INNER JOIN warehouse ON lkp_company.id=warehouse.companyId WHERE warehouse.warehouseName = '$warehouse'");
                            $warehouse_id = $data[0]->id;
                            $data = $data[0]->companyName;

                            $job_id = $worksheet->getCell('B' . $row)->getValue();
                            $name = $worksheet->getCell('C' . $row)->getValue();
                            $note = $worksheet->getCell('D' . $row)->getValue();
                            $amount = $worksheet->getCell('E' . $row)->getValue();

                            $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                            if (count($driver) > 0) {
                                $driverId = $driver[0]->id;
                            } else {
                                $driverId = DB::table('drivers')->insertGetId([
                                    'warehouseId' => $warehouse_id,
                                    'fullName' => $name,
                                    'job_id' => $job_id,
                                    'created_by_id' => $user_id,
                                    'updated_by_id' => $user_id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                            // $check = DB::select("SELECT driverId FROM creditnotes WHERE driverId = '$driverId' AND journal_date = '$journal_date' AND amount = '$amount'");
                            // if(count($check) > 0) { } else {

                                $creditnote_id = DB::table('creditnotes')->insertGetId([
                                    'driverId' => $driverId,
                                    'journal_date' => $journal_date,
                                    'amount' => $amount,
                                    'note' => $note,
                                    'createdby_id' => $user_id,
                                    'updatedby_id' => $user_id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);

                                if ($journal_check == 'on') {
                                    $journal_id = DB::table('journal')->insertGetId([
                                        'driverId' => $driverId,
                                        'journal_date' => $journal_date,
                                        'debit' => $amount,
                                        'note' => $note,
                                        'status' => 'Paid',
                                        'post_id' => $creditnote_id,
                                        'journal_type_id' => '3',
                                        'createdby_id' => $user_id,
                                        'updatedby_id' => $user_id,
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                    DB::update("UPDATE creditnotes set journal_id = '$journal_id' WHERE id = '$creditnote_id'");
                                }
                            // }
                        }
                    }
                }
                return redirect('New-Portal/automation')->with('success', 'Data '.$done.' successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['msg' => $e]);
            }
        } else { // get records to view in blade(unroll and roll)
            // This section to get the records for verification to unroll
            if(isset($request->READ) AND $request->READ == 'Unroll') {
                $module = $request->input('module');
                $companyId = $request->input('companyId');
                $warehouseClause = '';
                if (is_array($request->warehouseId) > 0) {
                    $warehouseClause = 'warehouseId in(' . implode(",", $request->warehouseId) .') AND';
                }
                $journal_date = explode(" - ", $request->journal_date_1);
                if($module == 'Loan') {
                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $total_amount = 0;
                    $model = 'Loan';
                    $operation = 'Reverse Loan';
                    $amount = 0;
                    $SQL = "SELECT loan.id, loan.amount, loan.note, warehouse.id as warehouse_id, warehouse.warehouseName,lkp_company.companyName,drivers.job_id,drivers.fullName,loan.driverId,loan.journal_id FROM loan INNER JOIN drivers ON loan.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE $warehouseClause companyId = '$companyId' AND loan.status_id <> 4 AND loan.journal_date between STR_TO_DATE('$journal_date[0]','%d/%m/%Y') AND STR_TO_DATE('$journal_date[1]','%d/%m/%Y')";
                    $salaries = DB::select($SQL);
                    foreach($salaries as $salary) {
                        $warehouse_id = $salary->warehouse_id;
                        $warehouse = $salary->warehouseName;
                        $company = $salary->companyName;
                        $job_id = $salary->job_id;
                        $name = $salary->fullName;
                        $note = $salary->note;
                        $loan_id = $salary->id;
                        $total_amount += $amount = $salary->amount;
                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $response_arr = array();
                        // dd($journal_date[1]);
                        $date = DateTime::createFromFormat('d/m/Y', $journal_date[1]);
                        $formattedDate = $date->format('Y-m-d');

                        $respnse .= generate_tr_unroll($model, $job_id, $name, $driver, $amount, $warehouse_id, $warehouse, $formattedDate, $note, '', $loan_id);
                    }
                } else if($module == 'Half-salary') {
                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $total_amount = 0;
                    $model = 'Salary';
                    $operation = 'Reverse Salary';
                    $debit = $amount = 0;
                    $SQL = "SELECT journal.id,journal.credit,journal.debit,journal.note,journal.driverId,warehouse.id AS warehouse_id,warehouse.warehouseName,lkp_company.companyName,drivers.job_id,drivers.fullName,journal.id,journal.driverId,journal.note,journal.debit,journal.credit FROM journal INNER JOIN drivers ON drivers.id=journal.driverId INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE journal_type_id=6 AND $warehouseClause companyId = '$companyId' AND journal.status <> 'Paid' AND journal.journal_date between STR_TO_DATE('$journal_date[0]','%d/%m/%Y') AND STR_TO_DATE('$journal_date[1]','%d/%m/%Y')";
                    $salaries = DB::select($SQL);
                    foreach($salaries as $salary) {
                        $warehouse_id = $salary->warehouse_id;
                        $warehouse = $salary->warehouseName;
                        $company = $salary->companyName;
                        $job_id = $salary->job_id;
                        $name = $salary->fullName;
                        $note = $salary->note;
                        $loan_id = $salary->id;
                        $total_amount += $amount = $salary->credit;
                        $total_amount += $debit = $salary->debit;
                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $response_arr = array();
                        // dd($journal_date[1]);
                        $date = DateTime::createFromFormat('d/m/Y', $journal_date[1]);
                        $formattedDate = $date->format('Y-m-d');

                        $respnse .= generate_tr_unroll($model, $job_id, $name, $driver, $amount, $warehouse_id, $warehouse, $formattedDate, $note, $debit, $loan_id);
                    }

                } else if($module == 'CreditNote') {
                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $total_amount = 0;
                    $model = 'CreditNote';
                    $operation = 'CreditNote Reverse';
                    $debit_amount = $amount = 0;
                    $SQL = "SELECT creditnotes.id,creditnotes.amount,creditnotes.note,creditnotes.driverId,creditnotes.journal_id,warehouse.id AS warehouse_id,warehouse.warehouseName,lkp_company.companyName,drivers.job_id,drivers.fullName FROM creditnotes INNER JOIN drivers ON creditnotes.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE creditnotes.journal_id is null AND $warehouseClause companyId = '$companyId' AND creditnotes.journal_date between STR_TO_DATE('$journal_date[0]','%d/%m/%Y') AND STR_TO_DATE('$journal_date[1]','%d/%m/%Y')";
                    $salaries = DB::select($SQL);
                    foreach($salaries as $salary) {
                        $warehouse_id = $salary->warehouse_id;
                        $warehouse = $salary->warehouseName;
                        $company = $salary->companyName;
                        $job_id = $salary->job_id;
                        $name = $salary->fullName;
                        $note = $salary->note;
                        $loan_id = $salary->id;
                        $total_amount += $debit_amount = $salary->amount;
                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $response_arr = array();
                        // dd($journal_date[1]);
                        $date = DateTime::createFromFormat('d/m/Y', $journal_date[1]);
                        $formattedDate = $date->format('Y-m-d');

                        $respnse .= generate_tr_unroll($model, $job_id, $name, $driver, $amount, $warehouse_id, $warehouse, $formattedDate, $note, $debit_amount, $loan_id);
                    }
                } else if($module == 'Settlement') {
                    $credit_check = $request->input('credit');
                    $debit_check = $request->input('debit');
                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $total_amount = 0;
                    $model = 'Settlement';
                    $operation = 'Settlement Reverse';
                    $debit_amount = $amount = 0;
                    if($credit_check == 'credit' AND $debit_check == 'debit') {
                        $SQL = "SELECT settlements.id,settlements.credit,settlements.debit,settlements.note,settlements.driverId,settlements.journal_id,warehouse.id AS warehouse_id,
                        warehouse.warehouseName,lkp_company.companyName,drivers.job_id,drivers.fullName FROM settlements INNER JOIN drivers ON settlements.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id
                        INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE settlements.journal_id is null and $warehouseClause companyId = '$companyId' AND settlements.journal_date between STR_TO_DATE('$journal_date[0]','%d/%m/%Y') AND STR_TO_DATE('$journal_date[1]','%d/%m/%Y')";
                    } else if($credit_check == 'credit') {
                        $SQL = "SELECT settlements.id,settlements.credit,settlements.debit,settlements.note,settlements.driverId,settlements.journal_id,warehouse.id AS warehouse_id,
                        warehouse.warehouseName,lkp_company.companyName,drivers.job_id,drivers.fullName FROM settlements INNER JOIN drivers ON settlements.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id
                        INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE settlements.journal_id is null and settlements.credit > 0 AND $warehouseClause companyId = '$companyId' AND settlements.journal_date between STR_TO_DATE('$journal_date[0]','%d/%m/%Y') AND STR_TO_DATE('$journal_date[1]','%d/%m/%Y')";
                    } else if ($debit_check == 'debit') {
                        $SQL = "SELECT settlements.id,settlements.credit,settlements.debit,settlements.note,settlements.driverId,settlements.journal_id,warehouse.id AS warehouse_id,
                        warehouse.warehouseName,lkp_company.companyName,drivers.job_id,drivers.fullName FROM settlements INNER JOIN drivers ON settlements.driverId=drivers.id INNER JOIN warehouse ON drivers.warehouseId=warehouse.id
                        INNER JOIN lkp_company ON warehouse.companyId=lkp_company.id WHERE settlements.journal_id is null and settlements.debit > 0 AND $warehouseClause companyId = '$companyId' AND settlements.journal_date between STR_TO_DATE('$journal_date[0]','%d/%m/%Y') AND STR_TO_DATE('$journal_date[1]','%d/%m/%Y')";
                    } else {
                        return redirect()->back()->withErrors(['msg' => 'Please select atleast one option(Credit or Debit).']);
                    }
                    $salaries = DB::select($SQL);
                    foreach($salaries as $salary) {
                        $warehouse_id = $salary->warehouse_id;
                        $warehouse = $salary->warehouseName;
                        $company = $salary->companyName;
                        $job_id = $salary->job_id;
                        $name = $salary->fullName;
                        $note = $salary->note;
                        $loan_id = $salary->id;
                        $total_amount += $amount = $salary->credit;
                        $total_amount += $debit_amount = $salary->debit;
                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $response_arr = array();
                        // dd($journal_date[1]);
                        $date = DateTime::createFromFormat('d/m/Y', $journal_date[1]);
                        $formattedDate = $date->format('Y-m-d');

                        $respnse .= generate_tr_unroll($model, $job_id, $name, $driver, $amount, $warehouse_id, $warehouse, $formattedDate, $note, $debit_amount, $loan_id);
                    }
                }
                return view('new_porttal.Automation.verify_unroll')->with('SQL', $SQL)->with('records', $respnse)->with('model', $model)->with('operation_type', $operation)->with('journal_date', $journal_date[0] . '-' . $journal_date[1])
                    ->with('amount', $total_amount)->with('new_drivers', $new_drivers)->with('total_drivers', $total_drivers)->with('company', $company)->with('expected', $expected)
                    ->with('note', $note);
            }
            $this->validate($request, [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            $tmpfname = $request->file('select_file');
            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
            $excelObj = $excelReader->load($tmpfname);
            $worksheet = $excelObj->getSheet(0);
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; ++$row) {
                if(isset($request->READ) AND $request->READ == 'daily' OR isset($request->READ) AND $request->READ == 'Loans') {
                    if ($worksheet->getCell('E' . $row)->getValue() !== null) {
                        return redirect()->back()->withErrors(['msg' => 'The format of file is not fine.']);
                        break;
                    }
                } else if(isset($request->READ) AND $request->READ == 'creditNote' OR isset($request->READ) AND $request->READ == 'settlement') {
                    if (null === $worksheet->getCell('E' . $row)->getValue() || '' === $worksheet->getCell('E' . $row)->getValue()) {
                        return redirect()->back()->withErrors(['msg' => 'The format of file is not fine.']);
                        break;
                    }
                }
                $warehouse = $worksheet->getCell('A' . $row)->getValue();
                $check = DB::select("SELECT warehouseName from warehouse where warehouseName = '$warehouse'");
                if (count($check) > 0) {
                } else {
                    return redirect()->back()->withErrors(['msg' => 'The Warehoses('.$warehouse.') does not exist please add first then proceed.']);
                    break;
                }
            }
            $file = $request->select_file;

            if(isset($request->READ) AND $request->READ == 'daily') {
                try {
                    $tep = new Temporary();
                    $safeName = 'daily_' . date("Y-m-d_H-i-s") . '.xlsx';
                    $fileSaved = \Storage::put('public/journal/imile/'.$safeName,\File::get($file));
                    if($fileSaved == true){
                        $tep->path = 'storage/app/public/journal/imile/'.$safeName;
                        $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) );
                        $tep->save();
                    }

                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $total_amount = 0;
                    $model = 'Loans';

                    for ($row = 2; $row <= $highestRow; $row++) {
                        $warehouse = $worksheet->getCell('A' . $row)->getValue();

                        $company = DB::select("SELECT warehouse.id, companyName FROM lkp_company INNER JOIN warehouse ON lkp_company.id=warehouse.companyId WHERE warehouse.warehouseName = '$warehouse'");
                        $warehouse_id = $company[0]->id;
                        $company = $company[0]->companyName;

                        $job_id = $worksheet->getCell('B' . $row)->getValue();
                        $name = $worksheet->getCell('C' . $row)->getValue();
                        $amount = $worksheet->getCell('D' . $row)->getValue();
                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $total_amount += $amount;
                        $total_drivers += 1;
                        $response_arr = array();
                        if (count($driver) > 0) {
                            $response_arr[] = generate_tr($model, $job_id, $name, $driver, $amount, $warehouse_id, $warehouse, $journal_date, $note);
                        } else {
                            $new_drivers += 1;
                            $response_arr[] = generate_tr($model, $job_id, $name, '', $amount, $warehouse_id, $warehouse, '', $note);
                        }
                        $respnse .= $response_arr[0][0];
                        if ($response_arr[0][1] > 0)
                            $expected += $response_arr[0][1];
                    }
                    $operation_type = "Half-Salary as loans";
                    return view('new_porttal.Automation.verify')->with('records', $respnse)->with('model', $model)->with('operation_type', $operation_type)->with('journal_date', $journal_date)
                    ->with('amount', $total_amount)->with('new_drivers', $new_drivers)->with('total_drivers', $total_drivers)->with('company', $company)->with('expected', $expected)
                    ->with('note', $note)->with('status_id', $status_id)->with('path', $tep->path)->with('credit_debbit', $credit_debbit);
                } catch (ValidationException $e) {
                    // Catch the ValidationException and handle it
                    return back()->with('error', 'Validation error: ' . $e->getMessage());
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['msg' => $e]);
                }
            } else if(isset($request->READ) AND $request->READ == 'Loans') {
                try {
                    $tep = new Temporary();
                    $safeName = 'loan_'.date("Y-m-d_H-i-s") . '.xlsx';
                    $fileSaved = \Storage::put('public/journal/imile/'.$safeName,\File::get($file));
                    if($fileSaved == true){
                        $tep->path = 'storage/app/public/journal/imile/'.$safeName;
                        $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) );
                        $tep->save();
                    }
                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $total_amount = 0;
                    $model = 'Loan';
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $warehouse = $worksheet->getCell('A' . $row)->getValue();

                        $company = DB::select("SELECT warehouse.id, companyName FROM lkp_company INNER JOIN warehouse ON lkp_company.id=warehouse.companyId WHERE warehouse.warehouseName = '$warehouse'");
                        $warehouse_id = $company[0]->id;
                        $company = $company[0]->companyName;

                        $job_id = $worksheet->getCell('B' . $row)->getValue();
                        $name = $worksheet->getCell('C' . $row)->getValue();
                        $amount = $worksheet->getCell('D' . $row)->getValue();
                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $total_amount += $amount;
                        $total_drivers += 1;
                        $response_arr = array();
                        if (count($driver) > 0) {
                            $response_arr[] = generate_tr($model, $job_id, $name, $driver, $amount, $warehouse_id, $warehouse, $journal_date, $note);
                        } else {
                            $new_drivers += 1;
                            $response_arr[] = generate_tr($model, $job_id, $name, '', $amount, $warehouse_id, $warehouse, '', $note);
                        }
                        $respnse .= $response_arr[0][0];
                        $expected += $response_arr[0][1];
                    }
                    $operation_type = "Loans";
                    return view('new_porttal.Automation.verify')->with('records', $respnse)->with('model', $model)->with('operation_type', $operation_type)->with('journal_date', $journal_date)
                    ->with('amount', $total_amount)->with('new_drivers', $new_drivers)->with('total_drivers', $total_drivers)->with('company', $company)->with('expected', $expected)
                    ->with('note', $note)->with('status_id', $status_id)->with('path', $tep->path)->with('credit_debbit', $credit_debbit);
                } catch (ValidationException $e) {
                    // Catch the ValidationException and handle it
                    return back()->with('error', 'Validation error: ' . $e->getMessage());
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['msg' => $e]);
                }
            } else if(isset($request->READ) AND $request->READ == 'creditNote') {
                try {
                    $tep = new Temporary();
                    $safeName = 'creditNote_'.date("Y-m-d_H-i-s") . '.xlsx';
                    $fileSaved = \Storage::put('public/journal/imile/'.$safeName,\File::get($file));
                    if($fileSaved == true){
                        $tep->path = 'storage/app/public/journal/imile/'.$safeName;
                        $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) );
                        $tep->save();
                    }
                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $total_amount = 0;
                    $model = 'CreditNote';
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $warehouse = $worksheet->getCell('A' . $row)->getValue();

                        $company = DB::select("SELECT warehouse.id, companyName FROM lkp_company INNER JOIN warehouse ON lkp_company.id=warehouse.companyId WHERE warehouse.warehouseName = '$warehouse'");
                        $warehouse_id = $company[0]->id;
                        $company = $company[0]->companyName;

                        $job_id = $worksheet->getCell('B' . $row)->getValue();
                        $name = $worksheet->getCell('C' . $row)->getValue();
                        $note = $worksheet->getCell('D' . $row)->getValue();
                        $amount = $worksheet->getCell('E' . $row)->getValue();

                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $total_amount += $amount;
                        $total_drivers += 1;
                        $response_arr = array();
                        if (count($driver) > 0) {
                            $response_arr[] = generate_tr($model, $job_id, $name, $driver, $amount, $warehouse_id, $warehouse, $journal_date, $note);
                        } else {
                            $new_drivers += 1;
                            $response_arr[] = generate_tr($model, $job_id, $name, '', $amount, $warehouse_id, $warehouse, '', $note);
                        }
                        $respnse .= $response_arr[0][0];
                        $expected += $response_arr[0][1];
                    }
                    $operation_type = "CreditNote";
                    return view('new_porttal.Automation.verify')->with('records', $respnse)->with('model', $model)->with('operation_type', $operation_type)->with('journal_date', $journal_date)
                    ->with('amount', $total_amount)->with('new_drivers', $new_drivers)->with('total_drivers', $total_drivers)->with('company', $company)->with('expected', $expected)
                    ->with('note', $note)->with('journal_check', $journal_check)->with('path', $tep->path)->with('credit_debbit', $credit_debbit);
                } catch (ValidationException $e) {
                    // Catch the ValidationException and handle it
                    return back()->with('error', 'Validation error: ' . $e->getMessage());
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['msg' => $e]);
                }
            } else if(isset($request->READ) AND $request->READ == 'settlement') {
                try {
                    $tep = new Temporary();
                    $safeName = 'settlement_'.date("Y-m-d_H-i-s") . '.xlsx';
                    $fileSaved = \Storage::put('public/journal/imile/'.$safeName,\File::get($file));
                    if($fileSaved == true){
                        $tep->path = 'storage/app/public/journal/imile/'.$safeName;
                        $tep->journal_date = date("Y-m-d", strtotime($request->journal_date) );
                        $tep->save();
                    }
                    $credit_amount = $debit_amount = 0;
                    $company = $respnse = '';
                    $expected = $total_drivers = $new_drivers = $amount = 0;
                    $model = 'Settlement';
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $warehouse = $worksheet->getCell('A' . $row)->getValue();

                        $company = DB::select("SELECT warehouse.id, companyName FROM lkp_company INNER JOIN warehouse ON lkp_company.id=warehouse.companyId WHERE warehouse.warehouseName = '$warehouse'");
                        $warehouse_id = $company[0]->id;
                        $company = $company[0]->companyName;

                        $job_id = $worksheet->getCell('B' . $row)->getValue();
                        $name = $worksheet->getCell('C' . $row)->getValue();
                        $note = $worksheet->getCell('D' . $row)->getValue();
                        if ($credit_debbit == 'credit')
                            $credit_amount = $worksheet->getCell('E' . $row)->getValue();
                        if ($credit_debbit == 'debit')
                            $debit_amount = $worksheet->getCell('E' . $row)->getValue();

                        $driver = DB::select("SELECT * FROM drivers WHERE `job_id` = '$job_id'");
                        $amount += $credit_amount;
                        $amount += $debit_amount;
                        $total_drivers += 1;
                        $response_arr = array();
                        if (count($driver) > 0) {
                            $response_arr[] = generate_tr($model, $job_id, $name, $driver, $credit_amount, $warehouse_id, $warehouse, $journal_date, $note, $debit_amount);
                        } else {
                            $new_drivers += 1;
                            $response_arr[] = generate_tr($model, $job_id, $name, '', $credit_amount, $warehouse_id, $warehouse, '', $note, $debit_amount);
                        }
                        $respnse .= $response_arr[0][0];
                        $expected += $response_arr[0][1];
                    }
                    $operation_type = "Settlement";
                    return view('new_porttal.Automation.verify')->with('records', $respnse)->with('model', $model)->with('operation_type', $operation_type)->with('journal_date', $journal_date)
                    ->with('amount', $amount)->with('new_drivers', $new_drivers)->with('total_drivers', $total_drivers)->with('company', $company)->with('expected', $expected)
                    ->with('note', $note)->with('journal_check', $journal_check)->with('path', $tep->path)->with('credit_debbit', $credit_debbit);
                } catch (ValidationException $e) {
                    // Catch the ValidationException and handle it
                    return back()->with('error', 'Validation error: ' . $e->getMessage());
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['msg' => $e]);
                }
            }
        }
    }

}

function generate_tr($model, $job_id = '', $name = '', $driver = [], $amount = '', $warehouse_id = '', $warehouse = '', $journal_date = '', $note = '', $debit_amount = '') {
    $current_month_credit = $current_month_debit = $current_balance = $carried_down = $expected = $t_credit = $t_debit = 'N/A';
    if(count($driver) > 0) {
        // 2024-01-02
        $to = explode("-",$journal_date);
        $month = $to[1];
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[2]);
        $last = $to[0] . "-" . $to[1] . "-" . $days;
        $first = $to[0] . "-" . $to[1] . "-01";

        $name = $driver[0]->fullName;
        $driverId = $driver[0]->id;
        // current month
        $credit = DB::select("SELECT sum(credit) as credit FROM journal WHERE  `driverId` = '$driverId' AND journal_date BETWEEN '$first' AND '$last'");
        $current_month_credit = round($credit[0]->credit, 2);
        $debit = DB::select("SELECT sum(debit) as debit FROM journal WHERE  `driverId` = '$driverId' AND journal_date BETWEEN '$first' AND '$last'");
        $current_month_debit = round($debit[0]->debit, 2);
        // end
        // All previous except current month PAST
        $credit = DB::select("SELECT sum(credit) as credit FROM journal WHERE  `driverId` = '$driverId' AND journal_date < '$first'");
        $previous_credit = $credit[0]->credit;
        $debit = DB::select("SELECT sum(debit) as debit FROM journal WHERE  `driverId` = '$driverId' AND journal_date < '$first'");
        $previous_debit = $debit[0]->debit;
        $carried_down = round($previous_credit - $previous_debit, 2);
        // end
        // Current/Complete balance, PAST ae well FUTURE
        $credit = DB::select("SELECT sum(credit) as credit FROM journal WHERE `driverId` = '$driverId'");
        $current_credit = $credit[0]->credit;
        $debit = DB::select("SELECT sum(debit) as debit FROM journal WHERE  `driverId` = '$driverId'");
        $current_debit = $debit[0]->debit;
        $current_balance = round($current_credit - $current_debit, 2);
        // end
        if ($model == 'Loan' || $model == 'CreditNote') {
            $expected = $amount;
        } else {
            if($current_balance >= 0) {
                $expected = $amount;
            } else if ($current_balance < 0) {
                $expected = $current_balance + $amount;
            }
        }
        $registration = '<button type="button" class="btn btn-success" style="border-radius: 20px; cursor: auto;">Registered</button>';
    } else {
        $registration = '<button type="button" class="btn btn-warning" style="border-radius: 20px; cursor: auto;">New Driver</button>';
        $expected = $amount;
        $driverId = 'new';
    }
    $tr = '<tr>';
    $tr .= '<td>'.$warehouse.'</td>';
    $tr .= '<td>'.$name.'</td>';
    $tr .= '<td>'.$job_id.'</td>';
    $tr .= '<td style="padding: 10px">'.$registration.'</td>';
    $tr .= '<td style="padding: 10px">'.$note.'</td>';
    $tr .= '<td>'.$carried_down.'</td>';
    $tr .= '<td>'.$current_balance.'</td>';
    if($model != 'Salary') {
        if($model != 'Settlement') {
            $tr .= '<td>'.$current_month_credit.'</td>';
            $tr .= '<td>'.$current_month_debit.'</td>';
        }
    }
    $tr .= '<td>'.$amount.'</td>';
    if($model == 'Settlement' OR $model == 'Salary') {
        $tr .= '<td>'.$debit_amount.'</td>';
        $tr .= '<input type="hidden" name="warehouse_id[]" value="'.$warehouse_id.'">';
        $tr .= '<input type="hidden" name="driverId[]" value="'.$driverId.'">';
        $tr .= '<input type="hidden" name="credit_amount[]" value="'.$amount.'">';
        $tr .= '<input type="hidden" name="debit_amount[]" value="'.$debit_amount.'">';
    } else {
        if($model != 'CreditNote')
            $tr .= '<td>'.$expected.'</td>';
        if($expected > 0) {
            $tr .= '<input type="hidden" name="warehouse_id[]" value="'.$warehouse_id.'">';
            $tr .= '<input type="hidden" name="driverId[]" value="'.$driverId.'">';
            $tr .= '<input type="hidden" name="amount[]" value="'.$expected.'">';
        }
    }

    $tr .= '<input type="hidden" name="job_id[]" value="'.$job_id.'">';
    $tr .= '<input type="hidden" name="fullname[]" value="'.$name.'">';
    $tr .= '<input type="hidden" name="note[]" value="'.$note.'">';
    $tr .= '</tr>';
    $arr = array();
    $arr[] = $tr;
    $arr[] = $expected;
    return $arr;
}

function generate_tr_unroll($model, $job_id = '', $name = '', $driver = [], $amount = '', $warehouse_id = '', $warehouse = '', $journal_date = '', $note = '', $debit_amount = '', $loan_id = '') {
    $current_month_credit = $current_month_debit = $current_balance = $carried_down = $t_credit = $t_debit = 'N/A';
        // 2024-01-02
        $to = explode("-",$journal_date);
        $month = $to[1];
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $to[2]);
        $last = $to[0] . "-" . $to[1] . "-" . $days;
        $first = $to[0] . "-" . $to[1] . "-01";

        $name = $driver[0]->fullName;
        $driverId = $driver[0]->id;
        // current month
        $credit = DB::select("SELECT sum(credit) as credit FROM journal WHERE  `driverId` = '$driverId' AND journal_date BETWEEN '$first' AND '$last'");
        $current_month_credit = round($credit[0]->credit, 2);
        $debit = DB::select("SELECT sum(debit) as debit FROM journal WHERE  `driverId` = '$driverId' AND journal_date BETWEEN '$first' AND '$last'");
        $current_month_debit = round($debit[0]->debit, 2);
        // end
        // All previous except current month PAST
        $credit = DB::select("SELECT sum(credit) as credit FROM journal WHERE  `driverId` = '$driverId' AND journal_date < '$first'");
        $previous_credit = $credit[0]->credit;
        $debit = DB::select("SELECT sum(debit) as debit FROM journal WHERE  `driverId` = '$driverId' AND journal_date < '$first'");
        $previous_debit = $debit[0]->debit;
        $carried_down = round($previous_credit - $previous_debit, 2);
        // end
        // Current/Complete balance, PAST ae well FUTURE
        $credit = DB::select("SELECT sum(credit) as credit FROM journal WHERE `driverId` = '$driverId'");
        $current_credit = $credit[0]->credit;
        $debit = DB::select("SELECT sum(debit) as debit FROM journal WHERE  `driverId` = '$driverId'");
        $current_debit = $debit[0]->debit;
        $current_balance = round($current_credit - $current_debit, 2);
        // end

        $registration = '<button type="button" class="btn btn-success" style="border-radius: 20px; cursor: auto;">Registered</button>';

    $tr = '<tr>';
    $tr .= '<td>'.$warehouse.'</td>';
    $tr .= '<td>'.$name.'</td>';
    $tr .= '<td>'.$job_id.'</td>';
    $tr .= '<td style="padding: 10px">'.$registration.'</td>';
    $tr .= '<td style="padding: 10px">'.$note.'</td>';
    $tr .= '<td>'.$carried_down.'</td>';
    $tr .= '<td>'.$current_balance.'</td>';
    $tr .= '<td>'.$amount.'</td>';
    $tr .= '<td>'.$debit_amount.'</td>';
    $tr .= '<input type="hidden" name="warehouse_id[]" value="'.$warehouse_id.'">';
    $tr .= '<input type="hidden" name="driverId[]" value="'.$driverId.'">';
    $tr .= '<input type="hidden" name="credit_amount[]" value="'.$amount.'">';
    $tr .= '<input type="hidden" name="debit_amount[]" value="'.$debit_amount.'">';
    $tr .= '<input type="hidden" name="job_id[]" value="'.$job_id.'">';
    $tr .= '<input type="hidden" name="fullname[]" value="'.$name.'">';
    $tr .= '<input type="hidden" name="note[]" value="'.$note.'">';
    $tr .= '<input type="hidden" name="loan_id[]" value="'.$loan_id.'">';
    $tr .= '</tr>';
    return $tr;
}


