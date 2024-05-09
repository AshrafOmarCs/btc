<?php
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    // DA-Portal
    // dd($locale);

Route::group(['prefix' => 'New-Portal'], function() {

    Route::get("/",'DashoardController@index');
    Route::get("/Drivers",'DashoardController@index_drivers');


    // Muhammed Code


});
Route::get("landmarkHandlller",'AshrafController@landmarkHandlller');


Route::get("other_recored",'AshrafController@other_recored');

Route::get("getDAJournals/{driver_id}",'AshrafController@getDAJournals');

Route::get("SendHttpTpVps",'AshrafController@SendHttpTpVps');
Route::get("apiLandmark",'AshrafController@apiLandmark');
Route::get("Send-http-request",'AshrafController@apiLandmark_yyyh');

Route::get("CheckingLandmarkDAs",'AshrafController@CheckingLandmarkDAs');
Route::get("CheckingLandmarkCorrectDAs",'AshrafController@CheckingLandmarkCorrectDAs');


Route::get("Properties/emp/confirm/{token}",'AshrafController@propertiesConfirm');

Route::get("Gadi",'AshrafController@Gadi');
Route::get("Properties/Form/{user_id}",'AshrafController@CompanyProprtiesIssuanceForm');
Route::get('claims',function(){
    return view('claims');
});

Route::group(['prefix' => 'DA-Portal'], function() {
    Route::get('login','DriverLoginController@index');
    Route::get('Fill-Data','DriverLoginController@fillfulment');
});

// QR Code
Route::get('qrcode',function(){
    return view('qrcode');
});
Route::get('send-sms','SmsController@index');
Route::post('otp_compare','SmsController@otp_compare');

// Vehicles

Route::get('Vehicles/Vehicles-Requests','VehiclesController@vehicle_requests');

Route::get('mainpulate-utlities','VehiclesController@mainpulate_utlities');

//
Route::get('Vehicles','VehiclesController@index');
Route::get('Vehicles/vehicle-checkup-utilities/{vehicle_id}','VehiclesController@vehicle_checkup_utilities');
Route::post('vehicles/utilities','VehiclesController@utilities');
Route::post('vehicles/update-vehicle-checkup','VehiclesController@vaildate_checkup');
Route::POST('Vehicles/vehicle-utilities/Validate','VehiclesController@ValidateUtlity');


// Vehicles

Route::post('HandleLandmarkFile','LandmarkController@HandleLandmarkFile');
Route::get('Landmark','LandmarkController@index');

Route::post('/DriversJahiz/storeDocument','GeneralController@storeDocument');
Route::get('Drivers_jahiz_doc/{driver_id}','GeneralController@getDriverData');

Route::post('Import_DA_Dailyload/Store-invoice','Import_DA_DailyloadController@store_invoice');
Route::post('Import_DA_Dailyload/bulk-DA','Import_DA_DailyloadController@bulk_da');

Route::post('Import_DA_Dailyload/bulk-drivers','Import_DA_DailyloadController@bulk_drivers');

Route::post('Import_DA_Dailyload/storewarehouse','Import_DA_DailyloadController@storewarehouse');

Route::post('Import_DA_Dailyload/Check-DA/storeDriver','Import_DA_DailyloadController@storeDriver');
Route::get('Import_DA_Dailyload/Check-DA/preview-file/{file_id}','Import_DA_DailyloadController@preview_file');
Route::post('Import_DA_Dailyload/Check-DA/updateWarehouse','Import_DA_DailyloadController@updateWarehouse');

Route::get('Import_DA_Dailyload/Check-DA/{file_id}','Import_DA_DailyloadController@Check_DA');

Route::get('I-Mile/Manthly-report','ImileController@imileManthly');
Route::get('Import_DA_Dailyload/step/{stepNumber}','Import_DA_DailyloadController@guideSteps');
Route::post('Import_DA_Dailyload/validate','Import_DA_DailyloadController@validte');
Route::post('/Import_DA_Dailyload/StoreWarehose','Import_DA_DailyloadController@StoreWarehose');
Route::post('/Import_DA_Dailyload/Check-Drivers','Import_DA_DailyloadController@check_drivers_jquery');

// fuel request
Route::get('Fuel-Loans','fuelLoanController@index');

Route::post('Fuel-Loans/store','fuelLoanController@store');
Route::post('/Send-fuel-requests','fuelLoanController@test');


//
// Expenses Catogery
Route::get('Expenses-Type','ExpenseController@expenses_types');
Route::get('Expenses-Sub-Categories','ExpenseController@index_sub');



Route::get('Expenses','ExpenseController@index');
Route::get('Expenses-Drivers','ExpenseController@index');
Route::post('filter_expenses','ExpenseController@filter_expenses');
Route::post('getExpenses','ExpenseController@getExpenses');

// end of Expense catogery


// Approval-Pages

Route::get('Approval-Pages','ApprovalController@index');
Route::post('Approval-Pages/Update','ApprovalController@update');
Route::post('Approval-Pages/create','ApprovalController@create');

// end of Approval-Pages

// Ashraf Apis
Route::post('/Salary-revert', 'SalaryControllerShe@salaryRevert');
Route::resource('Salary_she', 'SalaryControllerShe');
Route::post('CheckPermisionsShe','SalaryControllerShe@CheckPermisions')->name('CheckPermisionsShe');
Route::post('/GoToReady', 'SalaryControllerShe@goToReady');
Route::POST('/SalaryPaidSaveShe', 'SalaryControllerShe@SalaryPaidSave');
Route::get('/SalaryPaidShe', 'SalaryControllerShe@SalaryPaid');
Route::resource('Salary', 'SalaryControllerShe');
Route::get('/SalaryPaid', 'SalaryControllerShe@SalaryPaid');
Route::POST('/SalaryPaidSave', 'SalaryControllerShe@SalaryPaidSave');

Route::post('CheckPermisions','SalaryController@CheckPermisions')->name('CheckPermisions');
Route::get('Approve-invoice/{company_id}/{period}/{user_id}','ApprovalController@approveMethod');

//  end of ashraf apis

//reCall route with more clear names
Route::get('destroy-unpaidTransaction/{recored_id}','UnpaidSalaryController@destroy_unpaidTransaction');
Route::post('destroy-unpaidTransactions','UnpaidSalaryController@destroy_unpaidTransactions');

// unpaid Salary
Route::get('supervisors_missed_attendance',function(){
    $sql = "SELECT supervisors_missed_attendance.id,supervisors_missed_attendance.date,supervisors_missed_attendance.warehouses,users.name FROM `supervisors_missed_attendance` JOIN users ON users.id = supervisors_missed_attendance.super_id WHERE supervisors_missed_attendance.date BETWEEN '2023-09-01' and '2023-09-31' ;";
    $res = DB::select($sql);
    foreach($res as $k=>$item){
        $warehouses_names;
       $warehouses_ids =  json_decode($item->warehouses);
       foreach($warehouses_ids as $key11=>$warehouse_id){
        // dd($warehouse_id);

            $ware = DB::select("SELECT * FROM `warehouse` where id =".$warehouse_id." ");
            if($key11 == 0 ){
                $warehouses_names = $ware[0]->warehouseName;
            }else{
                $warehouses_names = $warehouses_names.', '.$ware[0]->warehouseName;
            }

       }
    //    dd($warehouses_names);
       $item->warehouses_names = $warehouses_names;
        // dd(json_decode($item->warehouses));
    }
    return view('suppervisorWhoMissAtt',compact('res'));
    dd($res);
});
Route::get('Unpaid-Salary','UnpaidSalaryController@index');

// end of
// imile routes

Route::get('I-Mile/Manthly-report','ImileController@imileManthly');
Route::post('i-mile/preview','ImileController@validateFile');
Route::post('storeImileDriver','ImileController@storeImileDriver');
Route::post('I-mile/Confirm-invoice','ImileController@confirmeInvoice');

// end of imile

// outsourcepayments
Route::get('text-editor','GeneralController@text_editor');
Route::post('editor-post','GeneralController@text_post');

Route::get('Out-Source-Payments','outSourcePaymentController@index');
Route::get('Out-source-payment/create','outSourcePaymentController@create');

// end of

// noon Routes
Route::get('driver/check-if-exsist','ImileController@check');
Route::get('import_excel/noon','NoonController@noonView');
Route::post('import_excel/noon/store','NoonController@store');
Route::post('import_excel/noon/confirm','NoonController@confirm');
// end of noon route

//Imile Routes
Route::get('import_excel/General-invoices','ImileController@uploader');
Route::post('import_excel/i-mile/preview','ImileController@preview');
Route::post('import_excel/i-mile/confirme','ImileController@confirme');
Route::post('import_excel/store-user','ImileController@storeDriver');

// end i-mile Routes

// following route is for testing purposes
Route::get('import_excel/agility','agilityController@index');

// Agility Routes


// Route::get('maping','correctingController@index');

//end of Imile Routes
Route::get('maping','correctingController@index');
Route::get('correcting',function(){
    dd(str_replace('*', ',', '12893*12212'));
});
Route::get('Carfoure','carfoureController@index');
Route::get('ImileController','ImileController@index');

Route::get('Salary-stc','GeneralController@salaryStcMethod');

Route::get('SANEDPaidSaveSaned','correctingController@SANEDPaidSaveSaned');
Route::get('importNoonInvoices','NoonController@index');
Route::get('testing','GeneralController@index');

Route::post('Saned-Export-Stcpay','GeneralController@SanedExportStcpay');
Route::get('ExportTest','GeneralController@testExportFile');

Route::post('/Syinc-drivers-sanad/store','supervisorController@store');

Route::get('/Syinc-drivers-sanad','supervisorController@index');

Route::get('/newLoginPage','GeneralController@newLoginPage');

Route::post('/testSANAD/store','GeneralController@sanadStore');

Route::get('/DriversJahiz/import','GeneralController@sanadImport');

Route::post('/DriversJahiz/store','GeneralController@sanadStore');

Route::get('retriveFromSANAD_newDrivers','GeneralController@retriveFromSANAD_newDrivers');

Route::get('testQuery','GeneralController@testQuery');

Route::get('convertDate','GeneralController@convertDate');

Route::get('Transaction','GeneralController@Transaction');


Route::get('/import-excel','ImportsheetsController@index');

Route::post('/import-excel/store','ImportsheetsController@store');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', function () {
    return redirect('login');
});

Route::get('/home', 'HomeController@index');

Route::get('/getDailyRecords/{warehouseId}', 'HomeController@getDailyRecords')->name('getDailyRecords');
Route::get('/getDailyCompanyRecords/{companyId}', 'HomeController@getDailyCompanyRecords')->name('getDailyCompanyRecords');

Route::get('/ChangePassword', 'UsersController@ChangePassword');
Route::POST('/ChangePasswordSave', 'UsersController@ChangePasswordSave');

Route::resource('/UsersRole', 'UsersRoleController');
Route::get('/UsersRolePrivilage/{role_id}', 'UsersRoleController@UsersRolePrivilage');
Route::POST('/UsersRolePrivilageSave', 'UsersRoleController@UsersRolePrivilageSave');
Route::resource('/Users', 'UsersController');
Route::get('/Users/create/{type_id}', 'UsersController@create')->name('Users.create');
Route::get('/Users/{id}/edit/{type_id}', 'UsersController@edit')->name('Users.edit');
Route::get('/Supervisors', 'UsersController@index');
Route::get('/UsersPrivilage/{id}', 'UsersPrivilegeController@index');
Route::post('/UsersPrivilage', 'UsersPrivilegeController@store');
Route::get('/UserResetPass/{id}', 'UsersController@ResetPass');
Route::POST('/UserSaveResetPass', 'UsersController@SaveResetPass');
Route::resource('/Warehouses', 'WarehousesController');
//Route::resource('/company', 'CompanyController');
Route::resource('/bank', 'BankController');
Route::resource('/Drivers', 'DriversController');
//->except(['edit'])
Route::get('/Drivers/create/{type_id}', 'DriversController@create')->name('Drivers.create');
Route::get('/Drivers/{id}/edit/{type_id}', 'DriversController@edit')->name('Drivers.edit');
Route::get('/DriversJahiz', 'DriversController@index');
Route::get('/getDriversJahizMontly/{driverId}/{jahiz_period_id}', 'AjaxController@getDriversJahizMontly');
Route::POST('/DriversPost', 'DriversController@DriversPost');
Route::get('/ClearancePrint/{id}/{print}', 'DriversController@ClearancePrint');
Route::get('/ResetPass/{id}', 'DriversController@ResetPass');
Route::get('/statement/{id}', 'DriversController@statement');
Route::get('/statement_Jahiz/{id}', 'DriversController@statement_Jahiz');
Route::get('/Attachment/{id}', 'DriversController@Attachment');
Route::POST('/SaveAttachment', 'DriversController@SaveAttachment');
Route::GET('/DeleteAttachment/{name}/{id}', 'DriversController@DeleteAttachment');
Route::POST('/SaveResetPass', 'DriversController@SaveResetPass');
Route::get('/DriversSettlementList/{id}', 'DriversController@DriversSettlementList');
Route::get('/DriversClaim/{id}', 'DriversJahizClaimController@DriversClaim');
Route::POST('/DriversClaimSave', 'DriversJahizClaimController@DriversClaimSave');
Route::get('/DriversClaimDelete/{id}', 'DriversJahizClaimController@DriversClaimDelete');
Route::DELETE('/DriversClaimDeleteAction', 'DriversJahizClaimController@DriversClaimDeleteAction');
Route::get('/DriversClaimReply/{id}', 'DriversJahizClaimController@DriversClaimReply');
Route::POST('/DriversClaimReplySave', 'DriversJahizClaimController@DriversClaimReplySave');
Route::get('/DriversClaimBag/{id}', 'DriversJahizClaimController@DriversClaimBag');
Route::POST('/DriversClaimBagSave', 'DriversJahizClaimController@DriversClaimBagSave');
Route::get('/DriversClaimCommission/{id}', 'DriversJahizClaimController@DriversClaimCommission');
Route::POST('/DriversClaimCommissionSave', 'DriversJahizClaimController@DriversClaimCommissionSave');
Route::get('/DriversClaimDate/{id}', 'DriversJahizClaimController@DriversClaimDate');
Route::POST('/DriversClaimDateSave', 'DriversJahizClaimController@DriversClaimDateSave');
Route::get('/DriversClaimStatus/{id}', 'DriversJahizClaimController@DriversClaimStatus');
Route::POST('/DriversClaimStatusSave', 'DriversJahizClaimController@DriversClaimStatusSave');
Route::get('/DriversSettlement/{driverId}/{jahiz_clearing_id}', 'DriversController@DriversSettlement');
Route::POST('/DriversSettlementSave', 'DriversController@DriversSettlementSave');
Route::GET('/DriversSettlementDelete/{driverId}/{jahiz_clearing_id}', 'DriversController@DriversSettlementDelete');
Route::POST('/DriversSettlementUpdate', 'DriversController@DriversSettlementUpdate');
Route::resource('/DriversJahizClearing', 'DriversJahizClearingController');
Route::resource('/DriversSANEDClearing', 'DriversSANEDClearingController');
Route::POST('/DriversSANEDClearingPost', 'DriversSANEDClearingController@DriversSANEDClearingPost');
Route::resource('/DriversJahizClaim', 'DriversJahizClaimController');
Route::resource('/Packages', 'PackagesController');
Route::get('/DriverWindow', 'DriversController@index');
Route::get('/DriverJahizWindow', 'DriversController@index');
Route::get('/WarehouseDrivers/{id}/{name}', 'WarehouseDriversController@index');
Route::post('/WarehouseDrivers', 'WarehouseDriversController@store');
Route::resource('/Loans', 'LoansController');
Route::get('/LoanPaid/{id}', 'LoansController@updatePaid');
Route::PUT('/LoanPaidSave', 'LoansController@updatePaidSave');
Route::resource('/Journal', 'JournalController');
Route::resource('/PostPackages', 'PostPackagesController');
Route::get('/PostPackagesWindow', 'PostPackagesController@PostPackagesWindow');
Route::resource('/CreditNotes', 'CreditNotesController');
Route::POST('/CreditNotesPost', 'CreditNotesController@CreditNotesPost');
Route::get('/CreditNotesPrint/{id}', 'CreditNotesController@CreditNotesPrint');
Route::resource('/Gaps', 'GapsController');
Route::POST('/GapsPost', 'GapsController@GapsPost');
Route::resource('/Settlements', 'SettlementsController');
Route::POST('/SettlementsPost', 'SettlementsController@SettlementsPost');
// Route::resource('Salary', 'SalaryController');
Route::get('/getCityName/{companyId}', 'AjaxController@getCityName');

Route::get('SalaryShow/{id}/{Period}', 'SalaryController@SalaryShow');

Route::get('/getCityName/{companyId}', 'AjaxController@getCityName');
Route::get('/getWarehouse/{cityId}', 'AjaxController@getWarehouse');
Route::get('/getWarehouseName/{companyId}', 'AjaxController@getWarehouseName');
Route::get('/getPeriod/{companyId}', 'AjaxController@getPeriod');
Route::get('/getDays/{Year}/{Month}', 'AjaxController@getDays');

Route::get('/import_excel', 'ImportExcelController@index');
Route::post('/import_excel/import', 'ImportExcelController@import');
Route::get('/import_excel_zajil', 'ImportExcelZajilController@index');
Route::post('/import_excel_zajil/import', 'ImportExcelZajilController@import');
Route::resource('GoogleMap', 'GoogleMapController');
Route::get('/MapWindow/{id}', 'WarehousesController@MapWindow');
Route::POST('/MapWindowSave', 'WarehousesController@MapWindowSave');
Route::resource('Attendance', 'AttendanceController');
Route::get('AttendanceDrivers', 'AttendanceController@AttendanceDrivers');
Route::resource('GoogleMapTrack', 'GoogleMapTrackController');
Route::resource('GoogleMapAttend', 'GoogleMapAttendController');
Route::resource('GoogleMapUser', 'GoogleMapUserController');
Route::resource('/Company', 'CompanyController');
Route::get('/Report_Loan', 'ReportsController@Loan');
Route::get('/Report_Salary', 'ReportsController@Salary');
Route::get('/Report_Attachment', 'ReportsController@Attachment');
Route::get('/Report_Jahiz', 'ReportsController@Jahiz');
Route::get('/Report_Claim', 'ReportsController@Claim');
Route::get('/ViewLoan', 'ReportsController@ViewLoan');
Route::get('/ViewCreditNote', 'ReportsController@ViewCreditNote');
Route::get('/ViewJournal', 'ReportsController@ViewJournal');
Route::get('/ViewSalary', 'ReportsController@ViewSalary');
Route::resource('/Clearance', 'ClearanceController');
Route::resource('/Packages_Backup', 'Packages_BackupController');
Route::get('/Packages_Report', 'Packages_BackupController@Packages_Report');
Route::get('/ViewPackages_Drivers/{id}', 'Packages_BackupController@ViewPackages_Drivers');
Route::resource('/ExportInvoice', 'ExportInvoiceController');
Route::get('/ExportInvoicePrint/{New_warehouseId}/{period_id}', 'ExportInvoiceController@ExportInvoicePrint');

Route::resource('/versionControl', 'VersionController');
Route::resource('driverInvoices', 'DriverInvoiceController');

Route::POST('/ExportSalarySTC', 'ExportSTCController@ExportSalarySTC');
Route::POST('/ExportLoanSTC', 'ExportSTCController@ExportLoanSTC');

Route::POST('/ExportSTC', 'ExportSTCController@index');

Route::get('/SANEDSettlement', 'SANEDController@SANEDSettlement');
Route::POST('/SANEDSettlementSave', 'SANEDController@SANEDSettlementSave');

Route::get('/SANEDPaid', 'SANEDController@SANEDPaid');
Route::POST('/SANEDPaidSave', 'SANEDController@SANEDPaidSave');

Route::get('/SANEDImportDriverJson', 'SANEDController@SANEDImportDriverJson');
Route::POST('/SANEDImportDriverJsonSave', 'SANEDController@SANEDImportDriverJsonSave');

Route::get('/ChefzImportInvoice', 'ChefzController@ChefzImportInvoice');
Route::POST('/ChefzImportInvoiceSave', 'ChefzController@ChefzImportInvoiceSave');
Route::resource('/DriversChefzClearing', 'ChefzController');
Route::POST('/DriversChefzClearingPost', 'ChefzController@DriversChefzClearingPost');
Route::POST('/ExportChefzSTC', 'ExportSTCController@ExportChefzSTC');

Route::get('/DriversAttend', 'DriversController@DriversAttend');
Route::POST('/DriversAttendSave', 'DriversController@DriversAttendSave');

Route::get('/LoansPaid', 'LoansController@LoansPaid');
Route::POST('/LoansPaidSave', 'LoansController@LoansPaidSave');

Route::get('/SalaryPaid', 'SalaryController@SalaryPaid');
Route::POST('/SalaryPaidSave', 'SalaryController@SalaryPaidSave');

Route::POST('/ExportClaim', 'DriversJahizClaimController@ExportClaim');

Auth::routes();

