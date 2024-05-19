@extends('layout2')
@section('content')
@section('title', __('drivers.JahizDrivers'))
<style>
    .bold {
        font-weight: 800 !important;
        cursor: pointer;
    }
    .bold_second {
        font-weight: 800 !important;
        cursor: pointer;
        color: #B7A758 !important;
    }
</style>

<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Fillter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-body">

                                <!-- Row start -->
                                <div class="row">
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Company </label>
                                            <select class="form-control" onchange="WarehouseName()" name="filter_companyId" id="filter_companyId">
                                                <option></option>
                                                @foreach ($lkp_company as $item)
                                                    <option value="{{$item->id}}">{{$item->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Warehouse</label>
                                            <select class="form-control" id="filter_warehouseId" name="filter_warehouseId" >
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Status</label>
                                            <select class="form-control" id="country">
                                                <option></option>
                                                @foreach($lkp_driver_status as $status)
                                                    <option>{{$status->driver_status_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="FullName" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="filter_fullName" name="filter_fullName" placeholder="FullName">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="Mobile" class="form-label">Mobile</label>
                                            <input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber" placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="iqama" class="form-label">Identity or Iqama</label>
                                            <input type="text" class="form-control" name="filter_iqama" id="filter_iqama" placeholder="Identity or Iqama">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="iqama" class="form-label">Driver Job ID</label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id" placeholder="Driver Job ID">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Driver Type</label>
                                            <select class="form-control"  name="filter_driver_type_id" id="filter_driver_type_id">
                                                <option></option>
                                                @foreach($lkp_driver_status as $status)
                                                    <option>{{$status->driver_status_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="accountNumber" class="form-label">STCPAY Number  </label>
                                            <input type="text" class="form-control" name="filter_accountNumber" id="filter_accountNumber"
                                                placeholder="9665*****">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="enterPassword" class="form-label">STCPAY Owner ID </label>
                                            <input type="text" class="form-control" name="filter_account_owner_iqama" id="filter_account_owner_iqama"
                                                placeholder="STCPAY Owner ID">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="enterPassword" class="form-label">Created at</label>
                                            <input type="text" class="form-control" name="filter_created_at" id="filter_created_at"
                                                placeholder="STCPAY Owner ID">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="m-0">
                                            <div class="form-label">Updated at </div>
                                            <div class="input-group">
												<span class="input-group-text">
													<i class="bi bi-calendar4"></i>
												</span>
												<input type="date" class="form-control datepicker-range" id="filter_updated_at" name="filter_updated_at">
											</div>
                                        </div>
                                    </div>
                                    {{--
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <label for="Created_by" class="form-label">Created by</label>
                                        <select class="form-control" id="Created_by">
                                            <option>Select account</option>
                                            <option>Ashraf</option>
                                            <option>Samir</option>
                                            <option>Canada</option>
                                            <option>Gremany</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                            <option>England</option>
                                            <option>Brazil</option>
                                        </select>
                                    </div> --}}

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <label for="Updated_by" class="form-label">Updated by</label>
                                        <select class="form-control" id="Updated_by">
                                            <option>Select account</option>
                                            <option>Ashraf</option>
                                            <option>Samir</option>
                                            <option>Canada</option>
                                            <option>Gremany</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                            <option>England</option>
                                            <option>Brazil</option>
                                        </select>
                                    </div>


                                </div>
                                <!-- Row end -->

                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" >Search</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal addNewDriver3 -->
<div class="modal fade" id="addNewDriver" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableLabel"><span id="bck_btn" onclick="go_back()" style="cursor: pointer; display: none; color: #B7A758"><img src="{{URL("dashboard/assets/logos/backward.png")}}" style="width: 7%"> Back</span> Add New Driver(s)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="statment">
                    <h5>Please select a method from bellow options: </h5>
                     <div class="row">
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Form')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/sign-form.png')}}" alt="fill form to create New driver" >
                        </div>
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Bulk')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/file.png')}}" alt="fill form to create New driver" >
                        </div>
                     </div>
                </div>

                <div id="create_da_from" style="display: none">
                    <h5>Please select a method from bellow options: </h5>
                      <h6>Form Data</h6>
                </div>
                <div id="create_da_bulk" style="display: none">
                    <div class="row">
                        <div class="col-lg-6 mt-3">
                            <small>
                                You can download following format file and after filling it please upload it here to save the new drivers.
                            </small>
                            <br />
                            <a href="{{ url('/storage/docsFormat/Drivers.csv') }}" class="btn btn-sm btn-info " style="padding: 10px"><i class="fa fa-download"></i>Clic {{__('automation.here')}}</a>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <form method="POST" action="{{ route('Drivers/upload')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="drivers_file" id="drivers_file" required accept=".xlsx,.xls,.csv">
                                <button type="submit" class="btn btn-success mt-4">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="selectBulkOrOne" style="display: none">
                    <div class="row">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-success" onclick="showSelectBulkOrOne('statment')">Understood</button> --}}
            </div>
        </div>
    </div>
</div>
<!--End Modal addNewDriver 3 -->

<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="ExportExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Export Driver Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Row start -->
                <div class="row">
                    <div class="col-xl-12 col-sm-12 col-12">
                        <p>Please select the required fields/criteria then click on Download button. </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-sm-4 col-4">
                        <div class="ml-4">
                            <input class="form-check-input" type="checkbox" checked value="" onclick="check_uncheck()" id="select_all" />
                            <label class="form-check-label" for="flexCheckDefault">Select All</label>
                        </div>
                        <div class="card" style="background-color: lightgrey">
                            <div class="card-body">
                                <form id="columnSelectionForm">
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="0">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_0" onclick="add_remove_bold(0)">City</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="1">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_1" onclick="add_remove_bold(1)">Type</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="2">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_2" onclick="add_remove_bold(2)">FullName</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="3">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_3" onclick="add_remove_bold(3)">Actual Name</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="4">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_4" onclick="add_remove_bold(4)">Mobile</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="5">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_5" onclick="add_remove_bold(5)">STC Pay</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="6">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_6" onclick="add_remove_bold(6)">Job ID</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input export_checks" type="checkbox" checked value="" style="display: none" id="7">
                                        <label class="form-check-label bold export_checks" for="flexCheckDefault" id="lbl_7" onclick="add_remove_bold(7)">Status</label>
                                    </div>
                                </form>

                                {{-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">STCPAY Owner Identity/Iqama</label>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4 col-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img onclick="show_selected()" style="width: 20%; cursor: pointer; margin-top: 30%" src="{{URL("dashboard/assets/logos/forward.png")}}" />
                                <br><br><br><br><br>
                                <img onclick="hide_selected()" style="width: 20%; cursor: pointer; display: none" id="backButton" src="{{URL("dashboard/assets/logos/backward.png")}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4 col-4" id="selected_fields" style="display: none">
                        <div>
                            {{-- <input class="form-check-input" type="checkbox" value="" onclick="uncheck(this)" id="flexCheckDefault"> --}}
                            <label class="form-check-label" for="flexCheckDefault" id="selected_count"></label>
                        </div>
                        <div class="card" style="background-color: lightgrey">
                            <div class="card-body">
                                <div class="form-check first_hide" id="no_0">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(0)" id="lbl_sec_0">City</label>
                                </div>
                                <div class="form-check first_hide" id="no_1">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(1)" id="lbl_sec_1">Type</label>
                                </div>
                                <div class="form-check first_hide" id="no_2">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(2)" id="lbl_sec_2">FullName</label>
                                </div>
                                <div class="form-check first_hide" id="no_3">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(3)" id="lbl_sec_3">Actual Name</label>
                                </div>
                                <div class="form-check first_hide" id="no_4">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(4)" id="lbl_sec_4">Mobile</label>
                                </div>
                                <div class="form-check first_hide" id="no_5">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(5)" id="lbl_sec_5">STC Pay</label>
                                </div>
                                <div class="form-check first_hide" id="no_6">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(6)" id="lbl_sec_6">Job ID</label>
                                </div>
                                <div class="form-check first_hide" id="no_7">
                                    <label class="form-check-label bold_second bold_unbold" for="flexCheckDefault" onclick="add_remove_bold_second(7)" id="lbl_sec_7">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row end -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" style="background-color: red">Reset</button>
                <button type="button" class="btn btn-success" style="background-color: #2661ba" id="exportExcelBtn">Download</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Driver </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
        </div>
    </div>
</div>
<div class="modal fade" id="statement_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Driver Statement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="statement_response">
            </span>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-body">
                    <p>{{__('drivers.Delete_msg')}} <span id="delete_name"></span> ?</p>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                      <button class="btn btn-danger" type="submit">Delete</button>
                  </div>
              </form>
        </div>
    </div>
</div>
<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-green">
                <i class="bi bi-handbag"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-green">{{ number_format($analatics['active'], 0, '.', ',')}} </h3>
                <p>Active</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-red">
                <i class="bi bi-pie-chart"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-red" style="font-size: 19px;">{{ number_format($analatics['Onhold'], 0, '.', ',')}} </h3>
                <p>On hold & Vacation</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-blue">
                <i class="bi bi-emoji-smile"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-blue"> {{ number_format($analatics['Terminated'], 0, '.', ',')}} </h3>
                <p>Terminated & Resigned</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-yellow">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-yellow"> {{ number_format($analatics['wrongWarehouse'], 0, '.', ',')}} </h3>
                <p>Wrong Warehouse</p>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Jahiz Drivers</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">This interface enables you to browse, edit, and add Jahiz Drivers as well as exporting their data </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>Fillter</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" type="button" onclick="export_excel()"></i>Export Excel</button>
                                <button type="button" class="btn btn-info" class="btn btn-info" data-bs-toggle="modal" type="button" data-bs-target="#addNewDriver" onclick="addNewDriver()"></i>Add new driver</button>
                                @if(Auth::user()->user_type_id==1)
                                    <button type="submit" class="btn btn-info" class="btn btn-info" type="submit"></i>On Hold</button>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table custom-table">
                            <thead>
                                <tr>
                                    <TH rowspan="2">{{__('drivers.City')}}</TH>
                                    <TH rowspan="2">{{__('drivers.Type')}}</TH>
                                    <TH rowspan="2">{{__('drivers.fullName')}}</TH>
                                    <TH rowspan="2">{{__('drivers.ActualName')}}</TH>
                                    <TH rowspan="2">{{__('drivers.Mobile')}}</TH>
                                    <TH rowspan="2">{{__('drivers.STCPay')}}</TH>
                                    <TH rowspan="2">{{__('drivers.JobId')}}</TH>
                                    <TH rowspan="2">{{__('drivers.Status')}}</TH>
                                    <TH rowspan="2"><?php echo date('Y-m', strtotime(date('Y-m') . " -1 month"));?></TH>
                                    <TH rowspan="2"><?php echo date('Y-m');?></TH>
                                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">{{__('drivers.SANED')}}</TH>
                                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">{{__('drivers.Bander')}}</TH>
                                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">مطالبة</TH>
                                    <TH rowspan="2">{{__('drivers.Amount')}}</TH>
                                    <TH rowspan="2">{{__('drivers.Create')}}</TH>
                                    <TH rowspan="2">{{__('drivers.Action')}}</TH>
                                </tr>
                                <tr>
                                    <TH>{{__('drivers.SAR')}}</TH>
                                    <TH>{{__('drivers.Days')}}</TH>
                                    <TH>{{__('drivers.SAR')}}</TH>
                                    <TH>{{__('drivers.Days')}}</TH>
                                    <TH>{{__('drivers.SAR')}}</TH>
                                    <TH style="border-right: 1px solid #f4f4f4!important;">{{__('drivers.Days')}}</TH>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
<input type="hidden" id="check" value="0">
<script>
        function export_excel() {
            $('#backButton').hide();
            $('#exportExcelBtn').prop('disabled', true);
            $('#selected_fields').hide();
            $('.export_checks').prop('checked', true);
            $(".export_checks").addClass("bold");
            $('#ExportExcel').modal('toggle');
        }
        function check_uncheck() {
            if ($('#select_all').prop('checked')) {
                $('.export_checks').prop('checked', true);
                $(".export_checks").addClass("bold");
            } else {
                $('.export_checks').prop('checked', false);
                $(".export_checks").removeClass("bold");
            }
        }
        function uncheck(the) {
            if (the.checked) {
                $('#exportExcelBtn').prop('disabled', true);
                $(".bold_unbold").removeClass("bold_second");
            } else {
                $('#exportExcelBtn').prop('disabled', false);
                $(".bold_unbold").addClass("bold_second");
            }
        }
        function add_remove_bold(id) {
            if($('#check').val() == 0) {
                $('#exportExcelBtn').prop('disabled', true);
                $("#lbl_"+id).toggleClass("bold");
                let checkbox = $("#"+id);
                checkbox.prop("checked", !checkbox.prop("checked"));
                $('#check').val(1);
            } else {
                alert("Please click on Add or Remove button!");
            }
        }
        function add_remove_bold_second(id) {
            if($('#check').val() == 0) {
                $('#exportExcelBtn').prop('disabled', true);
                $("#lbl_sec_"+id).toggleClass("bold_second");
                $("#lbl_sec_"+id).hide();
                let checkbox = $("#"+id);
                $("#lbl_"+id).toggleClass("bold");
                checkbox.prop("checked", !checkbox.prop("checked"));
                $('#check').val(1);
            } else {
                alert("Please click on Add or Remove button!");
            }
        }
        function show_selected() {
            $('#check').val(0);
            $('#exportExcelBtn').prop('disabled', true);
            $('#selected_fields').hide();
            $('.first_hide').hide();
            let count = 0;
            $('#columnSelectionForm input[type="checkbox"]').each(function() {
                if ($(this).is(':checked')) {
                    $('#no_'+$(this).attr('id')).show();
                    $("#lbl_sec_"+$(this).attr('id')).addClass("bold_second");
                    $("#lbl_sec_"+$(this).attr('id')).show();
                    count++;
                }
            });
            $('#backButton').hide();
            if (count > 0) {
                $('#exportExcelBtn').prop('disabled', false);
                $('#selected_fields').show();
                $('#backButton').show();
            }
            $('#selected_count').html("UnSelect (<span style='color: red'>"+count+"</span>)");
        }
        function hide_selected() {
            $('#check').val(0);
            $('#selected_fields').hide();
            $('#exportExcelBtn').prop('disabled', true);
            $('.first_hide').hide();
            let count = 0;
            $('#columnSelectionForm input[type="checkbox"]').each(function() {
                if ($(this).is(':checked')) {
                    $('#no_'+$(this).attr('id')).show();
                    count++;
                }
            });
            $('#backButton').hide();
            if (count > 0) {
                $('#exportExcelBtn').prop('disabled', false);
                $('#backButton').show();
                $('#selected_fields').show();
            }
            $('#selected_count').html("UnSelect (<span style='color: red'>"+count+"</span>)");
        }

        // Export Excel button click event
        $('#exportExcelBtn').click(function() {
            var table = $('#customer_data').DataTable();
            $('#ExportExcel').modal('hide');
            var selectedColumns = [];
            $('#columnSelectionForm input[type="checkbox"]').each(function() {
                if ($(this).is(':checked')) {
                    selectedColumns.push($(this).attr('id'));
                }
            });
            var rowCount = table.rows().count();
            var exportData = [selectedColumns.map(columnId => $('#' + columnId).siblings('label').text())];
            var rowCount = table.rows().count();
            for (var i = 0; i < rowCount; i++) {
                var rowData = [];
                selectedColumns.forEach(function(columnId) {

                    var cellData = table.cell(i, columnId).data();
                    if (cellData == null) {
                        rowData.push('');
                    } else {
                        rowData.push(cellData); // Or provide a placeholder value
                    }
                });
                exportData.push(rowData);
            }
            if (exportData[0].length === 0) {
                alert('No columns selected for export!');
                return;
            }
            var ws = XLSX.utils.aoa_to_sheet(exportData);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, 'Jahiz Drivers.xlsx');
        });
        function update_total(new_val, the = '') {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var sum = 0;
            checkboxes.forEach(function(checkbox) {
                sum += parseInt(checkbox.value) || 0;
            });
            for (var i = 1; i <= 100; i++) {
                var value = parseInt($('#amount_by_days_' + i).val()) || 0;
                sum += value;
            }
            $('#td_Bander_Commission').html(sum);
            $('#totalAmount').val(sum);

            // var pre_value = parseInt($('#td_Bander_Commission').html());
            // var total = parseInt(new_val);

            // if (pre_value > 0)
            //     if (the == '')
            //         var total = parseInt($('#td_Bander_Commission').html()) + parseInt(new_val);
            //     else if(the.checked)
            //         var total = parseInt($('#td_Bander_Commission').html()) + parseInt(new_val);
            //     else
            //         var total = parseInt($('#td_Bander_Commission').html()) - parseInt(new_val);

            // $('#td_Bander_Commission').html(total);
        }
        function addRow() {
            var driverId = $("input[name='Driver_id']").val();
            var job_id = $("input[name='job_id']").val();

            var jahiz_period_id = $('#jahiz_period_id').val();
            if (jahiz_period_id > 0) {
                if($('#jahiz_period_id_'+jahiz_period_id).length) {
                    alert("You already selected this period! Select a different one.");
                } else {
                    $.ajax({
                        type: 'GET',
                        url: "{{URL('/DriversSettlementGet')}}" + "/" + driverId + "/" + jahiz_period_id,
                        contentType: "html",
                        dataType: 'html',
                        success: function (data) {
                            data = data.split(":::");
                            var week1 = data[0];
                            var week2 = data[1];
                            var week3 = data[2];
                            var week4 = data[3];
                            var weekAll = data[4];
                            var amount_by_days = data[5];
                            if (week1 == 0) {
                                week1 = "<input type='checkbox' id='week1_"+jahiz_period_id+"' name='week1_"+jahiz_period_id+"' onclick='update_total(40, this)' value='40'>";
                            }
                            if (week2 == 0) {
                                week2 = "<input type='checkbox' id='week2_"+jahiz_period_id+"' name='week2_"+jahiz_period_id+"' onclick='update_total(40, this)' value='40'>";
                            }
                            if (week3 == 0) {
                                week3 = "<input type='checkbox' id='week3_"+jahiz_period_id+"' name='week3_"+jahiz_period_id+"' onclick='update_total(35, this)' value='35'>";
                            }
                            if (week4 == 0) {
                                week4 = "<input type='checkbox' id='week4_"+jahiz_period_id+"' name='week4_"+jahiz_period_id+"' onclick='update_total(35, this)' value='35'>";
                            }
                            if (weekAll == 0) {
                                weekAll = "<input type='checkbox' id='weekAll_"+jahiz_period_id+"' name='weekAll_"+jahiz_period_id+"' onclick='update_total(150, this)' value='150'>";
                            }
                            if (amount_by_days == 0) {
                                amount_by_days = "<input style='width:70px' id='amount_by_days_"+jahiz_period_id+"' type='number' min='0' onchange='update_total(this.value)' name='amount_by_days_"+jahiz_period_id+"' value=''>";
                            }
                            var selectedOptionText = $("#jahiz_period_id option:selected").text();
                            var tr = "<tr id='jahiz_period_id_"+jahiz_period_id+"'><td style='border: 1px solid'><a onclick='delete_row("+jahiz_period_id+")' href='#'><i class='fa fa-trash-o' title='delete row'></i></a></td><td style='border: 1px solid;color: red'>"+selectedOptionText+"<input type='hidden' value='"+jahiz_period_id+"' name='jahiz_period_ids[]'></td><td style='border: 1px solid'>"+week1+"</td><td style='border: 1px solid'>"+week2+"</td><td style='border: 1px solid'>"+week3+"</td><td style='border: 1px solid'>"+week4+"</td><td style='border: 1px solid'>"+weekAll+"</td><td style='border: 1px solid'>"+amount_by_days+"</td></tr>";
                            $("#dataTabl tbody").append(tr);
                        },
                        error: function (jqXHR, status, error) {
                            document.getElementById('response').innerHTML = "Error: " + error;
                            alert(status + ": " + error);
                        }
                    });

                }
            } else {
                alert("Please Select a Period!")
            }
        }
        function delete_row(jahiz_period_id) {
            var pre_value = parseInt($('#td_Bander_Commission').html());
            if ($('#week1_'+jahiz_period_id).prop('checked'))
                pre_value = pre_value - 40;
            if ($('#week2_'+jahiz_period_id).prop('checked'))
                pre_value = pre_value - 40;
            if ($('#week3_'+jahiz_period_id).prop('checked'))
                pre_value = pre_value - 35;
            if ($('#week4_'+jahiz_period_id).prop('checked'))
                pre_value = pre_value - 35;
            if ($('#weekAll_'+jahiz_period_id).prop('checked'))
                pre_value = pre_value - 150;
            let amount_by_days = parseInt($('#amount_by_days_'+jahiz_period_id).val());
            if ($('#amount_by_days_'+jahiz_period_id).val() > 0)
                pre_value = pre_value - amount_by_days;
            $('#td_Bander_Commission').html(pre_value);
            $('#jahiz_period_id_'+jahiz_period_id).remove();
        }
        $(document).ready(function () {

            fill_datatable();

            function fill_datatable(filter_screenId = '', filter_companyId = '', filter_warehouseId = '', filter_driver_type_id = '', filter_fullName = '', filter_mobileNumber = '', filter_iqama = '', filter_job_id = '', filter_status_id = '', filter_account_owner_iqama = '', filter_accountNumber = '', filter_claim_dt = '', filter_SANED_SettledDate = '', filter_jahiz_clearing_updated_at = '', filter_collectionAmount = '', filter_created_at = '', filter_updated_at = '', filter_Image_Identity = '', filter_Image_Passport = '', filter_Image_DrivingLicence = '', filter_Image_VehiclesRegistration = '', filter_Image_JobContract = '', filter_Image_PromissoryNote = '') {
                var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    dom: 'lBfrtip',
                    "buttons": [
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            exportOptions: {

                                modifier: {
                                    search: 'applied',
                                    order: 'applied'
                                }
                            }
                        }
                    ],
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    ajax: {
                        url: "{{ route('Drivers.index') }}",
                        data: {
                            filter_screenId: 'Jahiz',
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_fullName: filter_fullName,
                            filter_mobileNumber: filter_mobileNumber,
                            filter_iqama: filter_iqama,
                            filter_job_id: filter_job_id,
                            filter_status_id: filter_status_id,
                            filter_account_owner_iqama: filter_account_owner_iqama,
                            filter_accountNumber: filter_accountNumber,
                            filter_driver_type_id, filter_driver_type_id,
                            filter_claim_dt: filter_claim_dt,
                            filter_SANED_SettledDate: filter_SANED_SettledDate,
                            filter_jahiz_clearing_updated_at: filter_jahiz_clearing_updated_at,
                            filter_created_at: filter_created_at,
                            filter_collectionAmount: filter_collectionAmount,
                            filter_updated_at: filter_updated_at,
                            filter_Image_Identity: filter_Image_Identity,
                            filter_Image_Passport: filter_Image_Passport,
                            filter_Image_DrivingLicence: filter_Image_DrivingLicence,
                            filter_Image_VehiclesRegistration: filter_Image_VehiclesRegistration,
                            filter_Image_JobContract: filter_Image_JobContract,
                            filter_Image_PromissoryNote: filter_Image_PromissoryNote,
                        }
                    },

                    columns: [
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'driver_type',
                            name: 'lkp_driver_type.driver_type',
                        },
                        {
                            //className: "dt-nowrap",
                            data: 'fullName',
                            name: 'fullName'
                        },
                        {
                            data: 'actualName',
                            name: 'actualName'
                        },

                        {
                            data: 'mobileNumber',
                            name: 'mobileNumber'
                        },
                        {
                            data: 'accountNumber',
                            name: 'accountNumber'
                        },

                        {
                            data: 'job_id',
                            name: 'job_id'
                        },
                        {
                            data: 'driver_status_en',
                            name: 'lkp_driver_status.driver_status_en',
                            render: function (data, type, row, meta) {
                                if (row.status_id == "1") {
                                    return '<span class="label label-success">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "2") {
                                    return '<span class="label label-warning">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "3") {
                                    return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "4") {
                                    return '<span class="label label-default">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "5") {
                                    return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                }
                            }
                        },

                        {
                            "searchable": false,
                            data: 'per_priod',
                            name: 'per_priod'
                        },
                        {
                            "searchable": false,
                            data: 'cur_priod',
                            name: 'cur_priod'
                        },
                        {
                            "searchable": false,
                            data: 'SANED_amount',
                            name: 'SANED_amount',
                            render: function (data, type, row, meta) {
                                if (row.SANED_amount == null)
                                    return '';
                                else if (row.SANED_amount != row.Jahiz_Amount) {
                                    return '<span class="red_color">' + row.SANED_amount + '</span>';
                                } else if (row.SANED_amount == null)
                                    return '';
                                else
                                    return row.SANED_amount;
                            }
                        },

                        {
                            "searchable": false,
                            data: 'SANED_SettledDate',
                            name: 'SANED_SettledDate'
                        },
                        {
                            "searchable": false,
                            data: 'Jahiz_Amount',
                            name: 'Jahiz_Amount',
                            render: function (data, type, row, meta) {
                                if (row.Jahiz_Amount == null)
                                    return '';
                                else if (row.SANED_amount != row.Jahiz_Amount) {
                                    return '<span class="red_color">' + row.Jahiz_Amount + '</span>';
                                } else
                                    return row.Jahiz_Amount;


                            }
                        },
                        {
                            "searchable": false,
                            data: 'Last_Clear',
                            name: 'Last_Clear'
                        },
                        {
                            className: "table-cell-load",
                            "searchable": false,
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            className: "table-cell-touchpoint",
                            "searchable": false,
                            data: 'Claim_After',
                            name: 'Claim_After'
                        },
                        {
                            data: 'openBalance',
                            name: 'openBalance'
                        },
                        {
                            "searchable": false,
                            data: 'created_at2',
                            name: 'created_at2'
                        },
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            //"data": 'id',
                            "render": function (data, type, row, meta) {
                                // <button type="button" class="btn btn-light"><i class="bi bi-list text-green"></i> </button>
                                let html = `
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a id=` + row.id + ` data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view dropdown-item" href="#">View</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <input type="hidden" id="IDs_all_` + meta.row + `" name="IDs_all_` + meta.row + `" value="` + row.id + `">` + `
                                            <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit dropdown-item" href="#">Edit</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>`;
                                        @if(Auth::user()->user_type_id==1)
                                            html += `<li><a id=` + row.id + ` data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete dropdown-item" href="#"><span style="color:red">Delete</span></a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            `;
                                        @endif
                                        html += `<li><a id=` + row.id + ` data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue Attachment dropdown-item" href="#">Attachment</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a id=` + row.id + ` data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement">Statement</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>`;

                                        if(row.driver_type_id == null){
                                            html += `<li><a id=` + row.id+ ` data-original-title="Update Driver Type To Issuing documents"  disabled data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents">Issuing documents </a></li>`;
                                        } else {
                                            html += '<li><a id=' + row.id+ ' data-original-title="Issuing documents" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents">Issuing documents </a></li>';
                                        }

                                        html += `<li>
                                            <hr class="dropdown-divider">
                                        </li>`;
                                        @if (Auth::user()->user_type_id == 1)
                                        if (row.warehouseId == '201' || row.warehouseId == '220' || row.warehouseId == '221') {
                                            html += '<li><a id=' + row.id + ' type="button" class="btn btn-primary btn-xs DriversSettlementList">تصفية</a><li>';
                                        }
                                        @else
                                            html += '<li><a id=' + row.id + ' type="button" class="btn btn-primary btn-xs DriversSettlementList">تصفية</a><li>';
                                        @endif
                                        html += `<li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    </ul>
                                </div>`;
                                return html;
                            }
                        },
                    ]
                });

            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = "loading";
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Drivers')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                //e.preventDefault();
                $('#edit_modal').modal('toggle');
                document.getElementById('response').innerHTML = "loading";

                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Drivers')}}" + "/" + id + "/edit/1",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                        // $('#vehicle_id').select2({
                        //     dropdownParent: $('#edit_modal')
                        // });
                    }
                });
            });

            $('#customer_data tbody').on('click', '.statement', function (e) {
                e.preventDefault();
                document.getElementById('statement_response').innerHTML = "loading";
                $('#statement_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/statement_Jahiz')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('statement_response').innerHTML = data;
                    }
                });

            });

            $('#customer_data tbody').on('click', '.Attachment', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("Attachment")}}" + "/" + id, "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();

            });

            $('#customer_data tbody').on('click', '.documents', function (e) {
                e.preventDefault();
                $('.bandar').hide();
                var id = $(this).attr('id');
                $('#totalAmount').val('0.00 SAR')
                $('#Cash').val(0.00)
                $('#ATM').val(0.00)
                $('#Bank').val(0.00)
                $('#total').hide();
                $("option:selected").prop("selected", false)
                // $("#documentType select").val("none").change();


                $.ajax({
                    type: 'GET',
                    url: "{{URL('Drivers_jahiz_doc/')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        console.log(data);
                        document.getElementById('responseDiv').innerHTML = data;
                    }
                });
                $('#AttachmentModal').modal('show');

            });

            $('#customer_data tbody').on('click', '.DriversSettlementList', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversSettlementList')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;


                    }
                });
            });
            $('#customer_data tbody').on('click', '.DriversClaim', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversClaim')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                        var g = document.createElement('script');
                        var s = document.getElementsByTagName('script')[0];

                        g.text = "$('#claim_dt').datepicker({" +
                            "format: 'dd/mm/yyyy'," +
                            "autoclose: true," +
                            "autoHide: true," +
                            "zIndex: 9999," +
                            "});"
                        s.parentNode.insertBefore(g, s);


                    }
                });
            });

            $('#customer_data tbody').on('click', '.Clearance', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("ClearancePrint")}}" + "/" + id + "/0", "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();
            });
            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Drivers')}}" + "/" + id;
                $('#delete_modal').modal('toggle');
            });

            $('#filter').click(function () {

                if ($('#filter_warehouseId').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_fullName').val() != '' || $('#filter_mobileNumber').val() != '' || $('#filter_iqama').val() != '' || $('#filter_job_id').val() != '' || $('#filter_status_id').val() != '' || $('#filter_account_owner_iqama').val() != '' || $('#filter_accountNumber').val() != '' || $('#filter_claim_dt').val() != '' || $('#filter_SANED_SettledDate').val() != '' || $('#filter_jahiz_clearing_updated_at').val() != '' || $('#filter_collectionAmount').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_Image_Identity').val() != '' || $('#filter_Image_Passport').val() != '' || $('#filter_Image_DrivingLicence').val() != '' || $('#filter_Image_VehiclesRegistration').val() != '' || $('#filter_Image_JobContract').val() != '' || $('#filter_Image_PromissoryNote').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable('Jahiz', $('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_driver_type_id').val(), $('#filter_fullName').val(), $('#filter_mobileNumber').val(), $('#filter_iqama').val(), $('#filter_job_id').val(), $('#filter_status_id').val(), $('#filter_account_owner_iqama').val(), $('#filter_accountNumber').val(), $('#filter_claim_dt').val(), $('#filter_SANED_SettledDate').val(), $('#filter_jahiz_clearing_updated_at').val(), $('#filter_collectionAmount').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_Image_Identity').val(), $('#filter_Image_Passport').val(), $('#filter_Image_DrivingLicence').val(), $('#filter_Image_VehiclesRegistration').val(), $('#filter_Image_JobContract').val(), $('#filter_Image_PromissoryNote').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {

                $('#filter_warehouseId').val('');
                $('#filter_fullName').val('');
                $('#filter_mobileNumber').val('');
                $('#filter_iqama').val('');
                $('#filter_job_id').val('');
                $('#filter_status_id').val('');
                $('#filter_account_owner_iqama').val('');
                $('#filter_accountNumber').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_claim_dt').val('');
                $('#filter_SANED_SettledDate').val('');
                $('#filter_jahiz_clearing_updated_at').val('');
                $('#filter_collectionAmount').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#filter_Image_Identity').val('');
                $('#filter_Image_Passport').val('');
                $('#filter_Image_DrivingLicence').val('');
                $('#filter_Image_VehiclesRegistration').val('');
                $('#filter_Image_JobContract').val('');
                $('#filter_Image_PromissoryNote').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });

        function setDocumentType(){
            $('.claims').hide();
            $('.bandar').hide();
            $('.calimsinputBtns').val(0.00);
            $('#totalAmount').prop('readonly', true);
                var selectedOption= $('#documentType :selected').val();
            //  alert(selectedOption);
                $('#Cash').val(0.00);
                $('#ATM').val(0.00);
                $('#Bank').val(0.00);
                $('#total').hide();
                if(selectedOption == 'none'){
                    $('#totalAmount').val('Select DocumentType');
                    alert('يجب اختيار نوع المعاملة');
                }
                else if(selectedOption == 150){
                    $('#totalAmount').val('150.00 SAR')
                } else if(selectedOption == 75){
                    $('#totalAmount').val('75.00 SAR')
                } else if(selectedOption == 'clearing'){
                    $('.claims').show();
                    $('#totalAmount').val('');
                } else if(selectedOption == 'bandar') {
                    let driver_type = $('#driver_type').val();
                    if (driver_type == 2) {
                        $('.bandar').show();
                        $('#totalAmount').prop('readonly', true);
                    } else {
                        $('.bandar').hide();
                        $('#totalAmount').prop('readonly', false);
                    }
                    $('.claims').hide();
                    $('#bandar_body').html('');
                    $('#totalAmount').val('');
                }
                checkType();
        }
        function loadTotal() {
            let saned = $('#saned').val();
            let bandar = $('#bandar').val();
            let admin = $('#admin').val();
            var total = parseFloat(saned)+parseFloat(bandar)+parseFloat(admin);
            $('#totalAmount').val(total);
        }
        function checkType() {
            var selectedOption= $('#documentType :selected').val();
            if(selectedOption == 'none'){
                $('#exampleInputAmount').val('Select DocumentType')
                    alert('يجب اختيار نوع المعاملة');
                }else{
                if($('#Cash').val() == ''){
                    cash = 0.00;
                }else{
                    cash = $('#Cash').val();
                }
                if($('#ATM').val() == ''){
                    atm = 0.00;
                }else{
                    atm = $('#ATM').val();
                }
                if($('#Bank').val() == ''){
                    bank = 0.00;
                }else{
                    bank = $('#Bank').val();
                }
                var total = parseFloat(bank)+parseFloat(atm)+parseFloat(cash);
                $('#proof_file').prop('required', false);
                $('.proof_file').hide();
                if( total > 0){
                    $('#total').show();
                    $('#sumAmount').text(total);
                    if(atm > 0 || bank > 0) {
                        $('.proof_file').show();
                        $('#proof_file').prop('required', true);
                    }
                    if(selectedOption == 'clearing') {
                        let saned = $('#saned').val();
                        let bandar = $('#bandar').val();
                        let admin = $('#admin').val();
                        var total_amo = parseFloat(saned)+parseFloat(bandar)+parseFloat(admin);
                        if(total == total_amo){
                            $("#confirmBtn").prop('disabled', false);
                        }else{
                            $("#confirmBtn").prop('disabled', true);
                        }
                    } else if(selectedOption == 'bandar') {
                        let totalAmount = $("#totalAmount").val();
                        if(total == totalAmount){
                            $("#confirmBtn").prop('disabled', false);
                        }else{
                            $("#confirmBtn").prop('disabled', true);
                        }
                    } else {
                        if(total == selectedOption){
                            $("#confirmBtn").prop('disabled', false);
                        }else{
                            $("#confirmBtn").prop('disabled', true);
                        }
                    }
                }else{
                    $("#confirmBtn").prop('disabled', true);
                }
            }
            // alert(total);
        }
        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers/create/2")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;
                }
            });
        }

        function status() {
            var status_id = document.getElementById('status_id').value;
            if (status_id == "3")
                document.getElementById("Termination_Reason").style.display = '';
            else
                document.getElementById("Termination_Reason").style.display = 'none';
        }


        function sheet(id, Period) {
            myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
                "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function AddDriversSettlement(id) {
            //e.preventDefault();
            // var id = $(this).attr('id');

            myWindow1 = window.open("{{URL("DriversSettlement")}}" + "/" + id + "/0", "mywin",
                "height=900,width=820,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }

        function EditDriversSettlement(driverId, jahiz_clearing_id) {
            myWindow1 = window.open("{{URL("DriversSettlement")}}" + "/" + driverId + "/" + jahiz_clearing_id, "mywin",
                "height=900,width=820,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }

        function DeleteDriversSettlement(driverId, jahiz_clearing_id) {
            if (confirm("هل انت متاكد من مسح هذه التصفية?") == true) {
                //e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                //document.getElementById('edit_modal').style.display = 'block';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversSettlementDelete')}}" + "/" + driverId + "/" + jahiz_clearing_id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                    },
                    error: function (jqXHR, status, error) {
                        document.getElementById('response').innerHTML = "Error: " + error;
                        alert(status + ": " + error);
                    }
                });
            } else {

            }

        }

        function DriversSettlementList(driverId) {
            //e.preventDefault();
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversSettlementList')}}" + "/" + driverId,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

        function disableConfirmBtn(){
            // $("#confirmBtn").prop('disabled', true);
            $("#confirmBtn").click();
        }
        function validateForm() {
            //e.preventDefault();
            //document.getElementById('response').innerHTML = loader;
            //document.getElementById('edit_modal').style.display = 'block';
            if (document.getElementById('accountNumber')) {
                if ($("#accountNumber").val() != '' && ($("#accountNumber").val().length != 12 || $("#accountNumber").val().substring(0, 3) != '966')) {
                    alert('خطا في رقم الحساب : يجب ان يبدا ب 966 ويحتوي علي 12 رقم');
                    return false;
                }
                if ($("#account_owner_iqama").val() != '' && ($("#account_owner_iqama").val().length != 10 || ($("#account_owner_iqama").val().substring(0, 1) != '1' && $("#account_owner_iqama").val().substring(0, 1) != '2'))) {
                    alert('خطا في هوية صاحب الحساب : يجب ان يبدا ب 1 او 2 ويحتوي علي 10 ارقام');
                    return false;
                }
            }

            var postData = $("#contact_form").serializeArray();
            //alert(postData);
            var formURL = $("#contact_form").attr("action");
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                url: formURL,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) {
                    document.getElementById('response').innerHTML = data;


                },
                error: function (jqXHR, status, error) {
                    alert(status + ": " + error);
                }
            });
            return false;
        }

        function go_back() {
            $('#create_da_bulk').hide();
            $('#create_da_from').hide();
            $('#statment').show();
            $('#bck_btn').hide();
        }
        function addNewDriver(){
            $('#create_da_bulk').hide();
            $('#create_da_from').hide();
            $('#statment').show();
            $('#bck_btn').hide();
        }
        function showSelectBulkOrOne(args){
            var link = document.getElementById('statment');


            link.style.display = 'none'; //or
            var link = document.getElementById('selectBulkOrOne');
            link.style.display = 'block'; //or
        }
        function handleContent(args){
            $('#bck_btn').show();
            if(args == 'Form'){
                $('#create_da_bulk').hide();
                $('#statment').hide();
                $('#create_da_from').show();
                document.getElementById('create_da_from').innerHTML = 'Loading';
                $.ajax({
                    type: 'GET',
                    url: "{{URL("/Drivers/create/1")}}",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('create_da_from').innerHTML = data;
                        // $('#vehicle_id_create').select2({
                        //     dropdownParent: $('#edit_modal')
                        // });
                    }
                });

            }else{
                $('#create_da_bulk').show();
                $('#statment').hide();
                $('#create_da_from').hide();
            }
        }
</script>


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="https://btcdmins.com/AdminLTE/plugins/iCheck/icheck.min.js"></script>

@stop
@endsection

