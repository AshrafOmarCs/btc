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
    Route::get('lang/{lang}',function($lang){
        session(['locale' => $lang]);
        return redirect()->back();
    });
Route::group(['prefix' => 'New-Portal'], function() {

    Route::get("/",'DashoardController@index');
    Route::get("/Drivers",'DashoardController@index_drivers');
    Route::get('/DriversJahiz', 'DashoardController@index_drivers');
    Route::post('/Drivers/upload', 'DashoardController@drivers_save')->name('Drivers/upload');
    Route::get('/ChangePassword', 'UsersController@ChangePassword');
    Route::POST('/ChangePasswordSave', 'UsersController@ChangePasswordSave');
    Route::get("/Users",'UsersController@index');
    Route::get('/Supervisors', 'UsersController@index');
    Route::post('/DriverDetails', 'DashoardController@DriverDetails')->name('DriverDetails');
    Route::get('/Documents', 'DocumentsController@index');
    Route::get('/UploadDocuments', 'DocumentsController@upload_index');
    Route::get('/ContractsQuotation', 'ContractsQuotationController@index');


    // Route::resource('/Drivers', 'DriversController');
    // Ashraf Code
    Route::get("/Filter-layout",'AshrafController@Filter_layout');

    // Muhammed Code


});
Route::get("CheckingLandmarkDAs",'AshrafController@CheckingLandmarkDAs');
Route::get('/getJournalPeriod/{companyId}', 'ClaimsDeductionController@getJournalPeriod');

Route::get("Properties/emp/confirm/{token}",'PropertyIssuanceController@propertiesConfirm');
Route::get("Properties/Form/{user_id}/{type}",'PropertyIssuanceController@CompanyProprtiesIssuance');

Route::get('/use-db', function () {
    $sql = "select * from drivers where warehouseId =342";
    $payload = DB::select($sql);
    foreach($payload as $qty=>$item){
        if($item->job_id[0].$item->job_id[1] == "NG"){
              $sql = "UPDATE `drivers` SET job_id = 'NG".str_replace($item->job_id[0].$item->job_id[1], "",$item->job_id)."' where job_id='".$item->job_id."'";
            $res = DB::select($sql);
        }else{

        }

    }
    dd('done');
    Artisan::call('storage:link');

});


Route::get('Development',function(){
    return view('LandingPages.bunca-info');
});
Route::get('testing',function(){
    return view('LandingPages.testing');
});

// TermsAndCondions
Route::get('terms-and-conditoin',function(){
    return view('termsAndCondion');
});
Route::get('bunca',function(){
    return view('LandingPages.bunca-info');
});
Route::get("Coding-Route",function(){
    $sql = "SELECT drivers.job_id,drivers.fullName,warehouse.warehouseName,lkp_company.companyName,lkp_city.name_en,drivers_attachments.Image_JobContract,drivers_attachments.Image_PromissoryNote FROM `drivers` JOIN warehouse on warehouse.id = drivers.warehouseId JOIN lkp_company on lkp_company.id = warehouse.companyId JOIN lkp_city on lkp_city.id = warehouse.cityId JOIN drivers_attachments on drivers_attachments.driverId = drivers.id WHERE warehouse.cityId= 12 AND lkp_company.id != 6 ORDER BY `drivers_attachments`.`Image_PromissoryNote` ASC";
    $res = DB::select($sql);
    foreach($res as $key=>$item){
        $sql2 = "SELECT journal.*,drivers.job_id FROM `journal` JOIN drivers on drivers.id = journal.driverId WHERE journal.journal_type_id = 6 and drivers.job_id = '".$item->job_id."' and date(journal.created_at) BETWEEN '2023-09-01' and '2023-12-13' ORDER BY `journal`.`created_at` ASC";
        $journal_rec = DB::select($sql2);
        if(count($journal_rec)>0){
            $item->last_settelments = $journal_rec[0]->created_at;
        }else{
            $item->last_settelments = NULL;
        }
    }
});
Route::get('/linkstorage', function () {
    Artisan::call('config:cache');
    dd('Done');
});
Route::get('print-webhook','webhookController@print_webhook');

Route::get('sendSMS','SmsHandlerController@sendSMS');

Route::get('csrf-token','webhookController@updateVehicles');

Route::post('Transaction-History/Search','Transaction_historyController@search');
Route::get('Transaction-History','Transaction_historyController@index');
Route::post('Vehicles/CheckUp-Accessories-Handler','VehiclesController@accessoriesHandler');
Route::post('Vehicles/CheckUpImageHandler','VehiclesController@checkUpImageHandler');
Route::get('Vehicles/Check-up/{checkUp_id}','VehiclesController@getCheckUp');
Route::get('Vehicles','VehiclesController@index');
Route::get('Vehicles/create-delegation','VehiclesController@create_delegation');


// Vehicles
Route::get('Drivers/approval-review/{driver_id}','VehiclesController@approval_review');

Route::get('Vehicles/Vehicles-Requests','VehiclesController@vehicle_requests');

// Ashraf Code
Route::post('HandleLandmarkFile','LandmarkController@HandleLandmarkFile');
Route::get('Landmark','LandmarkController@index');

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
// Ashraf Code

Route::post('/DriversJahiz/storeDocument','GeneralController@storeDocument');
Route::get('Drivers_jahiz_doc/{driver_id}','GeneralController@getDriverData');

Route::get('debug/ApiRequest','DebugController@ApiRequest');



// Fuel Routes
// fuel request
Route::get('Fuel-Loans','fuelLoanController@index');
Route::post('Fuel-Loans/Filter','fuelLoanController@index');
Route::post('Fuel-Loans/store','fuelLoanController@store');
Route::post('Fuel-Loans/store-all','fuelLoanController@storeAll');
Route::post('/Send-fuel-requests','fuelLoanController@test');

// end fuel routes
// Approval-Pages

Route::get('Approval-Pages','ApprovalController@index');
Route::post('Approval-Pages/Update','ApprovalController@update');
Route::post('Approval-Pages/create','ApprovalController@create');

// end of Approval-Pages

// Ashraf Apis

Route::post('CheckPermisions','SalaryController@CheckPermisions')->name('CheckPermisions');
Route::get('Approve-invoice/{company_id}/{period}/{user_id}','ApprovalController@approveMethod');

//  end of ashraf apis


// ASIM Routes
Route::get('Export-jahiz-clearing-report','supervisorController@exprt_clearance_to_excel');

// end ASIM
//reCall route with more clear names
Route::get('destroy-unpaidTransaction/{recored_id}','UnpaidSalaryController@destroy_unpaidTransaction');
Route::post('destroy-unpaidTransactions','UnpaidSalaryController@destroy_unpaidTransactions');

// unpaid Salary

Route::get('Unpaid-Salary','UnpaidSalaryController@index');
// UNPaid Salary

// imile routes

// Route::get('I-Mile/Manthly-report','ImileController@imileManthly');
// Route::post('i-mile/preview','ImileController@imileManthlyPreview');
// Route::post('storeImileDriver','ImileController@storeImileDriver');
// Route::post('I-mile/Confirm-invoice','ImileController@confirmeInvoice');
// imile routes

Route::get('I-Mile/Manthly-report','ImileController@imileManthly');
Route::post('i-mile/preview','ImileController@validateFile');
Route::post('storeImileDriver','ImileController@storeImileDriver');
Route::post('I-mile/Confirm-invoice','ImileController@confirmeInvoice');

// end of imile
// end of imile


// transactions history Routes
Route::post('getWarehouse','transactionHistory@getWarehouse');
Route::post('Filter-Transaction-History','transactionHistory@excuteTransactionFilter');

Route::get('getCities/{company_id}/{city_id}','transactionHistory@getCities');
Route::get('Loans-Transaction-History','transactionHistory@loansHistory');
Route::get('Jahiz-Transaction-History','transactionHistory@jahizHistory');
// Route::get('Transaction-History','transactionHistory@index');


// Route::get('Transaction-History','transactionHistory@index');
Route::get('LoadHistory/{driver_id}','transactionHistory@LoadHistory');

// Debuging Routes
Route::get('SyicJahizClaims','supervisorController@syicJahizClaims');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

// noon Routes
Route::get('driver/check-if-exsist','ImileController@check');
Route::get('import_excel/noon','NoonController@noonView');
Route::post('import_excel/noon/store','NoonController@store');
Route::post('import_excel/noon/confirm','NoonController@confirm');
// end of noon route

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    dd('Done');
});


//Imile Routes
Route::get('import_excel/General-invoices','ImileController@uploader');
Route::post('import_excel/i-mile/preview','ImileController@preview');
Route::post('import_excel/i-mile/confirme','ImileController@confirme');
Route::post('import_excel/store-user','ImileController@storeDriver');

// end i-mile Routes


Route::post('/Syinc-drivers-sanad/store','supervisorController@store');

Route::get('/Syinc-drivers-sanad','supervisorController@index');


Route::get('retriveFromSANAD_newDrivers','GeneralController@retriveFromSANAD_newDrivers');

// ashraf code
Route::post('/testSANAD/store','GeneralController@sanadStore');
Route::get('/DriversJahiz/import','GeneralController@sanadImport');
Route::post('/DriversJahiz/store','GeneralController@sanadStore');
Route::post('/DriversJahiz/updateFile','GeneralController@updateFile');

// ashraf code

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

// its Muhammad start
// Define a fallback route to redirect to the home page
Route::fallback(function () {
    return redirect()->back()->with('error', "Something went wrong");
});
Route::get('/registration-zid-partner',function() {
    return view('LandingPages.land_page');
});
Route::get('/company-info',function(){
    return view('LandingPages.company-info');
});
Route::get('/DriversSettlementGet/{driverId}/{jahiz_period_id}', 'DriversController@DriversSettlementGet');
// Route::get('/Logs','LogsController@index');

Route::delete('/Logs/delete/{id}', 'LogsController@delete')->name('Logs/delete/{id}');
// Route::post('/Logs/search', 'LogsController@search')->name('Logs/search');

Route::get('/Logs','LogsController@index')->name('Logs');

Route::get('Actions','AutomationController@index_new');
Route::delete('/automation/reject/{id}', 'AutomationController@rejectSettlement')->name('automation/reject/{id}');
Route::get('automation/get/{id}','AutomationController@getSettlement')->name('automation/get/{id}');
Route::post('/automation/settlementAccept', 'AutomationController@acceptSettlement')->name('automation/settlementAccept');


Route::get('automation','AutomationController@index');
Route::post('Automation/download_file','AutomationController@download_file')->name('Automation/download_file');
Route::post('/automation/upload','AutomationController@upload_file')->name('automation/upload');
Route::get('/automation/approval/{type}/{reason}/{ids}','AutomationController@approval')->name('automation/approval');
Route::post('/automation/approval','AutomationController@approved')->name('automation/approval');

Route::get('union','UnionController@index');
Route::get('/Union/create', 'UnionController@create')->name('Union.create');
Route::POST('Union/store', 'UnionController@store')->name('Union.store');
Route::get('/Union/get/{id}', 'UnionController@get')->name('Union.get');
Route::POST('/Union/delete', 'UnionController@delete')->name('Union.delete');

Route::GET('/systems', 'LandingPageController@system');

Route::GET('/Information/{type}', 'LandingPageController@index');
Route::POST('/Information/store', 'LandingPageController@store')->name('Information/store');

Route::GET('Vehicles/VehicleOilSave', 'VehiclesController@VehicleOil');
Route::POST('/VehicleOilSave', 'VehiclesController@VehicleOilSave');
Route::POST('Vehicles/OilInfo', 'VehiclesController@oil_info');
Route::POST('Vehicles/OilInfoDone', 'VehiclesController@OilInfoDone');

Route::GET('Vehicles/VehicleFuelSave', 'VehiclesController@VehicleFuel');
Route::POST('/VehicleFuelSave', 'VehiclesController@VehicleFuelSave');
Route::POST('Vehicles/FuelInfo', 'VehiclesController@fuel_info');
Route::POST('Vehicles/FuelInfoDone', 'VehiclesController@FuelInfoDone');
Route::POST('Vehicles/download_vehicles_report', 'VehiclesController@download_vehicles_report');

// Property issuance start
Route::get('Properties/PropertyIssuance', 'PropertyIssuanceController@index_assign');
Route::post('/PropertyIssuance/get_back_devices', 'PropertyIssuanceController@get_back_devices')->name('PropertyIssuance/get_back_devices');
Route::post('/PropertyIssuance/get_devices_from_emp', 'PropertyIssuanceController@get_devices_back')->name('PropertyIssuance/get_devices_from_emp');
Route::post('/PropertyIssuance/device_confirmation', 'PropertyIssuanceController@devices_confirmation')->name('PropertyIssuance/device_confirmation');
Route::post('/PropertyIssuance/confirm_devices_for_emp', 'PropertyIssuanceController@confirm_devices_for_emp')->name('PropertyIssuance/confirm_devices_for_emp');
Route::post('/PropertyIssuance/filter_devices', 'PropertyIssuanceController@search')->name('PropertyIssuance/filter_devices');

Route::get('Properties/index', 'PropertyIssuanceController@index_new');
Route::get('Properties/Property', 'PropertyIssuanceController@index');
Route::post('/PropertyIssuance/create', 'PropertyIssuanceController@create');
Route::post('/PropertyIssuance/store', 'PropertyIssuanceController@store')->name('PropertyIssuance/store');
Route::delete('/PropertyIssuance/cat_delete/{id}', 'PropertyIssuanceController@cat_delete')->name('ContractsQuotation/cat_delete/{id}');
Route::post('/PropertyIssuance/getRecord', 'PropertyIssuanceController@get');
Route::post('/PropertyIssuance/update', 'PropertyIssuanceController@update')->name('PropertyIssuance/update');
Route::delete('/PropertyIssuance/delete/{id}', 'PropertyIssuanceController@delete')->name('ContractsQuotation/delete/{id}');
Route::post('/PropertyIssuance/property_assign', 'PropertyIssuanceController@property_assign')->name('PropertyIssuance/property_assign');
Route::post('/PropertyIssuance/get_devices', 'PropertyIssuanceController@get_devices');
Route::get('/total_devices/{id}', 'PropertyIssuanceController@get_total_devices');
Route::get('/available_devices/{id}', 'PropertyIssuanceController@get_available_devices');

// Property issuance end
// Contracts Quotation start
Route::get('/verification/{id}', 'ContractsQuotationController@validateOTP');
Route::post('/verification', 'ContractsQuotationController@confirmation')->name('verification');
Route::post('/ContractsQuotation/phoneEmailVerification', 'ContractsQuotationController@phoneEmailVerification');

Route::get('/ContractsQuotation', 'ContractsQuotationController@index');
Route::post('/ContractsQuotation/create', 'ContractsQuotationController@create');
Route::post('/ContractsQuotation/store', 'ContractsQuotationController@store')->name('ContractsQuotation/store');
Route::post('/ContractsQuotation/getRecord', 'ContractsQuotationController@get');
Route::post('/ContractsQuotation/update', 'ContractsQuotationController@update')->name('ContractsQuotation/update');
Route::delete('/ContractsQuotation/delete/{id}', 'ContractsQuotationController@delete')->name('ContractsQuotation/delete/{id}');
Route::post('/ContractsQuotation/add_approval', 'ContractsQuotationController@add_approval')->name('ContractsQuotation/add_approval');
Route::post('/ContractsQuotation/reject_quotation', 'ContractsQuotationController@reject_quotation')->name('ContractsQuotation/reject_quotation');
Route::get('/QuotationAccept/{id}', 'ContractsQuotationController@company_quotation_accept');
Route::post('/QuotationAccept', 'ContractsQuotationController@company_quotation_accept_data')->name('QuotationAccept');
Route::get('/QuotationReject/{id}', 'ContractsQuotationController@company_quotation_reject');
Route::post('/QuotationReject', 'ContractsQuotationController@company_quotation_reject_reason')->name('QuotationReject');
Route::post('/ContractsQuotation/reject_file', 'ContractsQuotationController@reject_file')->name('ContractsQuotation/reject_file');
Route::post('/ContractsQuotation/getCompany', 'ContractsQuotationController@getCompany')->name('ContractsQuotation/getCompany');
Route::post('/ContractsQuotation/getItem', 'ContractsQuotationController@getItem')->name('ContractsQuotation/getItem');

Route::post('/ContractsQuotation/showContract', 'ContractsQuotationController@showContract');
Route::post('/ContractsQuotation/verification', 'ContractsQuotationController@verification');
Route::post('/ContractsQuotation/sendContract', 'ContractsQuotationController@sendContract')->name('ContractsQuotation/sendContract');

Route::get('/ContractAccept/{id}', 'ContractsQuotationController@company_contract_accept');
Route::post('/ContractAccept', 'ContractsQuotationController@company_contract_accept_data')->name('ContractAccept');
Route::get('/ContractReject/{id}', 'ContractsQuotationController@company_contract_reject');
Route::post('/ContractReject', 'ContractsQuotationController@company_contract_reject_reason')->name('ContractReject');
Route::post('/Contract/{id}', 'ContractsQuotationController@contract');
Route::get('/Contract/{id}', 'ContractsQuotationController@contract');
// Contracts Quotation end

Route::resource('/LoansShe', 'LoansSheController');
Route::get('Loans/Search','LoansSheController@search')->name('Loans/Search');

Route::get('Loans/index','LoansSheController@index')->name('Loans/index');
Route::get('Loans/Search_bk','LoansSheController@search')->name('Loans/Search_bk');


Route::POST('/LoansSheControllerindex', 'LoansSheController@index');
Route::POST('/ExportLoanSheSTC', 'ExportSTCController@ExportLoanSheSTC');
Route::post('/GoToReadyLoan', 'LoansSheController@goToReady');
Route::post('/Loans-revert', 'LoansSheController@loansRevert');
Route::get('/approval/{type}/{reason}/{id}/{check}','LoansSheController@approval');

Route::post('/Saned-revert', 'DriversSANEDClearingControllerShe@sanedRevert');
Route::post('/apply-settlement', 'DriversSANEDClearingControllerShe@applySettlement');
// Route::get('/approval/{type}/{reason}/{id}/{check}','DriversSANEDClearingControllerShe@approval');
Route::post('/Salary-revert', 'SalaryControllerShe@salaryRevert');

Route::resource('DriversSANEDClearingShe', 'DriversSANEDClearingControllerShe');
Route::POST('/ExportSTCShe', 'ExportSTCController@ExportSTCShe');
Route::post('/GoToReadySaned', 'DriversSANEDClearingControllerShe@goToReady');
Route::POST('/DriversSANEDClearingControllerSheindex', 'DriversSANEDClearingControllerShe@index');
Route::POST('/DriversSANEDClearingPostShe', 'DriversSANEDClearingControllerShe@DriversSANEDClearingPost');

Route::POST('/ExportSalarySTCShe', 'ExportSTCController@ExportSalarySTCShe');

Route::resource('Salary_she', 'SalaryControllerShe');
Route::post('CheckPermisionsShe','SalaryControllerShe@CheckPermisions')->name('CheckPermisionsShe');
Route::post('/GoToReady', 'SalaryControllerShe@goToReady');
Route::POST('/SalaryPaidSaveShe', 'SalaryControllerShe@SalaryPaidSave');
Route::get('/SalaryPaidShe', 'SalaryControllerShe@SalaryPaid');

Route::get('/ClaimsDeduction/SyncJahiz', 'ClaimsDeductionController@index_jahiz');
Route::post('/ClaimsDeduction/SyncJahiz/Search', 'ClaimsDeductionController@search_jahiz');
Route::post('/ClaimsDeduction/SyncJahiz/SearchDrivers', 'ClaimsDeductionController@search_jahiz_drivers');

Route::get('/ClaimsDeduction', 'ClaimsDeductionController@index');
Route::post('/ClaimsDeduction/Search', 'ClaimsDeductionController@search');

Route::get('/cron_send_email', 'CronJobController@send_email');
Route::get('/cron_vehicle_attendance', 'CronJobController@vehicle_attendance');
Route::get('/cron_vehicle_attendance_test', 'CronJobController@vehicle_attendance_test');

Route::get('/contract_expiry_email', 'CronJobController@contract_expiry_email');

Route::post('Vehicles/EditVehicle','VehiclesController@edit_vehicle');
Route::post('Vehicles/UpdateVehicle','VehiclesController@update_vehicle');

Route::get('Vehicles/Report','VehiclesController@report_index');
Route::post('Vehicles/ReportSearch','VehiclesController@report_search');
Route::post('vehicles/utilities','VehiclesController@utilities');
Route::post('vehicles/utilities/update','VehiclesController@utilitiesUpdate');

Route::post('Vehicles/Search','VehiclesController@search_old');
Route::get('Vehicles/Search','VehiclesController@search')->name('Vehicles/Search');
Route::post('Vehicles/VehicleInfo','HomeController@vehicles_info');
Route::get('Vehicles/{city_name}','VehiclesController@index');
Route::get('Vehicles/{city_name}/{type}','VehiclesController@index');
Route::get('Vehicles/{city_name}/{type}/{companyName}/{warehouseName}','VehiclesController@index');

Route::get('/DriversAttendance', 'DriversController@attendance');
Route::post('DriversAttendance/Search','DriversController@attendance_search');
Route::post('DriversAttendance/update','DriversController@attendance_update');

Route::get('/documents/{file}', 'DocumentsController@show_file');
Route::get('/Documents', 'DocumentsController@index');
Route::get('/UploadDocuments', 'DocumentsController@upload_index');
Route::post('/storeDocuments', 'DocumentsController@upload_store');

Route::get('/UserWasrehouses/{id}/{name}', 'UsersController@get_warehouses');
Route::post('/update_warehouse', 'UsersController@updateUserWarehouses');

// Muhammad Close

Route::get('/Supervisors', 'UsersController@index');
Route::get('/UsersPrivilage/{id}', 'UsersPrivilegeController@index');
Route::post('/UsersPrivilage', 'UsersPrivilegeController@store');
Route::get('/UserResetPass/{id}', 'UsersController@ResetPass');
Route::POST('/UserSaveResetPass', 'UsersController@SaveResetPass');
Route::resource('/Warehouses', 'WarehousesController');
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

Route::resource('/DriversSANEDClearing', 'DriversSANEDClearingControllerShe');
Route::POST('/DriversSANEDClearingPost', 'DriversSANEDClearingController@DriversSANEDClearingPost');
Route::resource('/DriversJahizClaim', 'DriversJahizClaimController');
Route::resource('/Packages', 'PackagesController');
Route::get('/DriverWindow', 'DriversController@index');
Route::get('/DriverJahizWindow', 'DriversController@index');
Route::get('/WarehouseDrivers/{id}/{name}', 'WarehouseDriversController@index');
Route::post('/WarehouseDrivers', 'WarehouseDriversController@store');
// Route::resource('/Loans', 'LoansController');
Route::resource('/Loans', 'LoansSheController');
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
Route::resource('Salary', 'SalaryControllerShe');

Route::get('SalaryShow/{id}/{Period}', 'SalaryController@SalaryShow');

Route::get('/getCityName/{companyId}', 'AjaxController@getCityName');
Route::get('/getWarehouse/{cityId}', 'AjaxController@getWarehouse');
Route::get('/getWarehouseByCompany/{companyId}', 'AjaxController@getWarehouseByCompany');
Route::get('/getWarehouseByCityCompany/{cityId}/{companyId}', 'AjaxController@getWarehouseByCityCompany');
Route::get('/getWarehouseName/{companyId}', 'AjaxController@getWarehouseName');
Route::get('/getMultipleWarehouseName/{companyId}', 'AjaxController@getMultipleWarehouseName');

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

// Route::get('/SalaryPaid', 'SalaryController@SalaryPaid');
// Route::POST('/SalaryPaidSave', 'SalaryController@SalaryPaidSave');

Route::get('/SalaryPaid', 'SalaryControllerShe@SalaryPaid');
Route::POST('/SalaryPaidSave', 'SalaryControllerShe@SalaryPaidSave');


Route::POST('/ExportClaim', 'DriversJahizClaimController@ExportClaim');

Auth::routes();
