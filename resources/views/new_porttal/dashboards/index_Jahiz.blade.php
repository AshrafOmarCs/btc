@extends('layout2')
@section('content')
@section('title', __('drivers.JahizDrivers'))

<style>
    .disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .inner-table {
        border-collapse: collapse;
        width: 100%;
    }
    .inner-table th {
        padding: 5px;
        background-color: #4CAF50;
    }
    .inner-table td {
        padding: 8px;
        border-bottom: 1px solid #dddddd;
    }
    .list-group-item+.list-group-item.active {
        border-top: 1px solid white;
        background-color: #0866e9;
    }
    .list-group-item.active{
        background-color: #0866e9;
    }
    #table{
        width: 90%; margin: 0 auto; margin-top: 44px;
    }
    .list-group .list-group-item {

    }
    .inputBtns{
        width: 89%;
        margin: 5px;
        float: right;
    }
    /* td{
        vertical-align: middle !important;
        text-align: center ;
    } */
</style>


<!-- Modal -->
<div class="modal fade" id="AttachmentModal" tabindex="-1" role="dialog" aria-labelledby="AttachmentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <form action="{{url('DriversJahiz/storeDocument')}}" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="AttachmentModal"> {{__('drivers.Issuingdocument')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group" >
                    <label for='Driver_name1'>DA Details | المندوب</label>
                    <div id="responseDiv">

                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Document Type  | نوع المستند <span style="color:red !important">*</span></label>
                    <select class="form-control" onchange="setDocumentType()" name="documentType" id="documentType">
                        <option value="none">Choose Doc type</option>
                        <option value="150">Quittance | مخالصة </option>
                        <option value="75">Bond cancellation | الغاء سند</option>
                        <option value="clearing">Claims Clearing | تصفية مطالبات متأخرة</option>
                        <option value="bandar">Bandar Commission | عمولة بندر</option>
                    </select>
                </div>

                <b style="direction:rtl; display: none; width: 100%; float: left; margin-bottom: 10px;" class='bandar'>
                    عمولة الشركة بندر:
                    <span id="td_Bander_Commission"></span>
                </b>
                <table style="direction:rtl; display: none; width: 100%; float: left" class='bandar'>
                    <tr>
                        <th style="text-align: center">الشهر:</th>
                        <th style="text-align: center">
                            <select name="jahiz_period_id" id="jahiz_period_id"
                                class="form-control" style="width:170px;display: inline;!important; margin-bottom: 10px;">
                                <option value="">اختر الفترة</option>
                                @foreach($lkp_jahiz_period as $lkp_jahiz_periodd)
                                    <option value="{{$lkp_jahiz_periodd->id}}"> {{$lkp_jahiz_periodd->ym}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th style="text-align: center">
                            <a href="javascript:addRow();" class="btn btn-sm btn-info " style="font-size: 12px;font-family: 'Segoe UI' !important;font-weight: bold">
                                اضافة شهر
                                <i class="fa fa-plus"></i>
                            </a>
                        </th>
                    </tr>
                </table>

                <br>
                <table id="dataTabl" class="table table-striped dataTable bandar" style="padding-top: 10px; display: none" dir="rtl">
                    <thead>
                        <tr>
                            <th style="border: 1px solid;">حذف</th>
                            <th style="border: 1px solid;">الشهر</th>
                            <th style="border: 1px solid;background-color: #B1F1F0">الاسبوع(1)
                                <br>
                                40 ريال
                            </th>
                            <th style="border: 1px solid;background-color: #B1F1F0">الاسبوع(2)
                                <br>
                                40 ريال
                            </th>
                            <th style="border: 1px solid;background-color: #B1F1F0">الاسبوع(3)
                                <br>
                                35 ريال
                            </th>
                            <th style="border: 1px solid;background-color: #B1F1F0">الاسبوع(4)
                                <br>
                                35 ريال
                            </th>

                            <th style="border: 1px solid;background-color: #56E0DA">كل العمولة
                                <br>
                                150 ريال
                            </th>
                            <th style="border: 1px solid;background-color: #CD9BFF">المبلغ بالايام</th>
                        </tr>
                    </thead>
                    <tbody id="bandar_body"></tbody>
                </table>


                <label style="display: none" class='claims' for="exampleInputPassword1">Claims Clearing | تصفية مطالبات متأخرة</label>
                <table style="display: none; width: 100%" class='claims'>
                    <tr>
                        <th>{{__('drivers.Saned_amount')}}</th>
                        <th>{{__('drivers.Bandar_commission')}}</th>
                        <th>{{__('drivers.Administrativefee')}}</th>
                    </tr>
                    <tr>
                        <td><input type="number" class="calimsinputBtns" id="saned" min="0" name="saned" onchange="loadTotal(this.value)"></td>
                        <td><input type="number" class="calimsinputBtns"  id="bandar" min="0" name="bandar" onchange="loadTotal(this.value)"></td>
                        <td><input type="number" class="calimsinputBtns" id="admin" min="0" name="admin" onchange="loadTotal(this.value)"></td>
                    </tr>
                </table>
                <div class="form-group">
                    <label for="exampleInputPassword1">Amount | المبلغ </label>
                    <input type="Text" readonly value="0.00 SAR" class="form-control" id="totalAmount" name="totalAmount">
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Payment type | نوع السداد </label>
                    <table>
                        <tr>
                            <th>{{__('drivers.Cash')}}</th>
                            <td><input type="number" class="inputBtns" id="Cash" min="0" placeholder="Cash" name="cash" onchange="checkType()"></td>
                            <th>{{__('drivers.ATM')}}</th>
                            <td><input type="number" class="inputBtns"  id="ATM" min="0" placeholder="ATM" name="atm" onchange="checkType()"></td>
                            <th>{{__('drivers.BANK')}}</th>
                            <td><input type="number" class="inputBtns" id="Bank" min="0" placeholder="Bank" name="bank" onchange="checkType()"></td>
                        </tr>
                        <tr style="display: none;" class='proof_file'>
                            <th>{{__('drivers.Proof')}}</th>
                            <td><input style="margin-top: 10px" type="file" id="proof_file" name="proof_file" accept=".pdf, .jpg, .jpeg, .png"></td>
                        </tr>
                    </table>




                </div>
                <!-- <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div> -->
                <h2 id="total" style="display:none;text-align: center; margin-top: 44px;">
                    {{__('drivers.PaidAmount')}} <span style="color:red" id="sumAmount"> </span>
                    {{__('drivers.SAR')}}
                </h2>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                <button type="submit" class="btn btn-success" onclick="disableConfirmBtn()"
                    data-bs-dismiss="modal" id="confirmBtn" disabled>{{__('drivers.Confirm')}}</button>
            </div>
        </form>
        </div>
    </div>
</div>



<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> {{__('drivers.Filter')}}</h5>
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
                                            <label for="country" class="form-label">{{__('drivers.City')}}</label>
                                            <select class="form-control" id="filter_warehouseId" name="filter_warehouseId" >
                                                <option value=""></option>
                                                @foreach($warehouse as $warehousee)
                                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.fullName')}}</label>
                                            <input type="text" class="form-control" id="filter_fullName" name="filter_fullName">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Mobile')}}</label>
                                            <input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Iqama')}}</label>
                                            <input type="text" class="form-control" name="filter_iqama" id="filter_iqama">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.JobId')}}</label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.accountNumber')}}</label>
                                        <input type="text" class="form-control" name="filter_accountNumber" id="filter_accountNumber">
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Account_Owner_Iqama')}}</label>
                                        <input type="text" class="form-control" name="filter_account_owner_iqama" id="filter_account_owner_iqama">
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Status')}}</label>
                                        <select name="filter_status_id" id="filter_status_id" onchange="status()" class="form-control">
                                            <option value=""></option>

                                            @foreach($lkp_driver_status as $lkp_driver_statuss)
                                                <option
                                                    value="{{$lkp_driver_statuss->id}}">{{$lkp_driver_statuss->driver_status_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.DriverType')}}</label>
                                        <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control">
                                            <option value=""></option>
                                            @foreach($lkp_driver_type as $lkp_driver_typee)
                                                <option
                                                    value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Amount')}}</label>
                                        <select name="filter_collectionAmount" id="filter_collectionAmount" class="form-control">
                                            <option value=""></option>
                                            <option value="1">+</option>
                                            <option value="2">-</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.ImageIdentity')}}</label>
                                        <select name="filter_Image_Identity" id="filter_Image_Identity" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.ImagePassport')}}</label>
                                        <select name="filter_Image_Passport" id="filter_Image_Passport" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.ImageDrivingLicence')}}</label>
                                        <select name="filter_Image_DrivingLicence" id="filter_Image_DrivingLicence" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.ImageVehiclesRegistration')}}</label>
                                        <select name="filter_Image_VehiclesRegistration" id="filter_Image_VehiclesRegistration" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.ImagePromissoryNote')}}</label>
                                        <select name="filter_Image_PromissoryNote" id="filter_Image_PromissoryNote" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.ImageJobContract')}}</label>
                                        <select name="filter_Image_JobContract" id="filter_Image_JobContract" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.ClaimDate')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_claim_dt" name="filter_claim_dt" value="">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.SANEDDate')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_SANED_SettledDate" name="filter_SANED_SettledDate" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.BanderDate')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_jahiz_clearing_updated_at" name="filter_jahiz_clearing_updated_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Created_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_created_at" name="filter_created_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Updated_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_updated_at" name="filter_updated_at">
                                        </div>
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
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal addNewDriver3 -->
<div class="modal fade" id="addNewDriver" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableLabel"><span id="bck_btn" onclick="go_back()" style="cursor: pointer; display: none; color: #B7A758"><img src="{{URL("dashboard/assets/logos/backward.png")}}" style="width: 7%"> {{__('drivers.Back')}}</span> {{__('drivers.add_driver')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="statment">
                    <h5>{{__('drivers.driver_add_method')}}: </h5>
                     <div class="row">
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Form')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/sign-form.png')}}" alt="fill form to create New driver" >
                        </div>
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Bulk')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/file.png')}}" alt="fill form to create New driver" >
                        </div>
                     </div>
                </div>
                <form id="driverForm">
                    @csrf
                    <div id="create_da_from" style="display: none">
                        <h5>{{__('drivers.select_method')}}: </h5>
                        <h6>{{__('drivers.FormData')}}</h6>
                    </div>
                </form>
                <div id="create_da_bulk" style="display: none">
                    {{-- <span onclick="go_back()" style="cursor: pointer; display: flex"><img src="https://static.thenounproject.com/png/1808051-200.png" style="width: 3%"> <h5>{{__('drivers.Back')}}</h5></span> --}}
                    <div class="row">
                        <div class="col-lg-6 mt-3">
                            <small>
                                {{__('drivers.download_description')}}.
                            </small>
                            <br />
                            <a href="{{ url('/storage/docsFormat/Drivers.csv') }}" class="btn btn-sm btn-info " style="padding: 10px"><i class="fa fa-download"></i>{{__('drivers.clickHere')}}</a>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <form method="POST" action="{{ route('Drivers/upload')}}">
                                @csrf
                                <input type="file" name="drivers_file" id="drivers_file" required><br>
                                <button type="submit" class="btn btn-success mt-4">{{__('drivers.Submit')}}</button>
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
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                {{-- <button type="button" class="btn btn-success" onclick="showSelectBulkOrOne('statment')">Understood</button> --}}
            </div>

        </div>
    </div>
</div>
<!--End Modal addNewDriver 3 -->

<!-- Modal ExportExcel 3 -->
@php
$array = [
    0=>'City',
    1=>'Type',
    2=>'FullName',
    3=>'Actual Name',
    4=>'Mobile',
    5=>'STC Pay',
    6=>'Job ID',
    7=>'Status',
];
$module = "Driver";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div> --}}

        </div>
    </div>
</div>
<div class="modal fade" id="statement_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.DriverStatement')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="statement_response">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
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
                <h3 class="text-green" id="active_lbl">{{ number_format($analatics['active'], 0, '.', ',')}} </h3>
                <p>{{__('drivers.active')}}</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-red">
                <i class="bi bi-pie-chart"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-red" style="font-size: 19px;" id="onhold_lbl">{{ number_format($analatics['Onhold'], 0, '.', ',')}} </h3>
                <p>{{__('drivers.OnholdVacation')}}</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-blue">
                <i class="bi bi-emoji-smile"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-blue" id="terminated_lbl"> {{ number_format($analatics['Terminated'], 0, '.', ',')}} </h3>
                <p>{{__('drivers.TerminatedResigned')}}</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-yellow">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-yellow" id="wrongWarehouse_lbl"> {{ number_format($analatics['wrongWarehouse'], 0, '.', ',')}} </h3>
                <p>{{__('drivers.WrongWarehouse')}}</p>
            </div>
        </div>
    </div>
    @include('new_porttal.partials.edit_btn')
</div>
<!-- Row end -->


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('drivers.JahizDrivers')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">{{__('drivers.driver_module')}}</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" type="button" onclick="export_excel()"></i>{{__('drivers.ExportExcel')}}</button>
                                @if(Auth::user()->user_type_id==1 || session('Session_DriversJahiz')=='yes')
                                    <button type="button" class="btn btn-info" class="btn btn-info" data-bs-toggle="modal" type="button" data-bs-target="#addNewDriver" onclick="addNewDriver()"></i>{{__('drivers.add_driver')}}</button>
                                    @if(Auth::user()->email=='manager@btclogistic.com' || Auth::user()->email=='rah@btc.com' || Auth::user()->email == 'm.shehroze@btclogistic.com' || Auth::user()->email == 'a.omar@btclogistic.com' || Auth::user()->email == 'asim@btclogistic.com' )
                                        <a target="popup"
                                        onclick="window.open('{{ url('/DriversJahiz/import') }}','popup','width=800,height=600'); return false;" class="btn btn-sm btn-warning "><i class="fa fa-plus"></i>
                                        {{__('drivers.Import_SANAD_Clearing')}}</a>
                                        @endif
                                        <a target="popup"
                                            onclick="window.open('{{ url('/Syinc-drivers-sanad') }}','popup','width=600,height=600'); return false;" class="btn btn-sm btn-success "><i class="fa fa-plus"></i>
                                        {{__('drivers.Sync_Drivers')}} </a>
                                @endif

                                @if(Auth::user()->user_type_id==1)
                                    {{-- <button type="submit" class="btn btn-info" class="btn btn-info" type="submit"></i>On Hold</button> --}}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.City')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.Type')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.fullName')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.ActualName')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.Mobile')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.STCPay')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.JobId')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.Status')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2"><?php echo date('Y-m', strtotime(date('Y-m') . " -1 month"));?></TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2"><?php echo date('Y-m');?></TH>
                                    <TH class="text-center" style="background-color: #b9ad73ba" colspan="2" style="text-align: center!important;border-bottom: 0px!important;">{{__('drivers.SANED')}}</TH>
                                    <TH class="text-center" style="background-color: #b9ad73ba" colspan="2" style="text-align: center!important;border-bottom: 0px!important;">{{__('drivers.Bander')}}</TH>
                                    <TH class="text-center" style="background-color: #b9ad73ba" colspan="2" style="text-align: center!important;border-bottom: 0px!important;">مطالبة</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.Amount')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.Create')}}</TH>
                                    <TH class="text-center" style="vertical-align: middle;" rowspan="2">{{__('drivers.Action')}}</TH>
                                </tr>
                                <tr>
                                    <TH style="background-color: #b7a75842">{{__('drivers.SAR')}}</TH>
                                    <TH style="background-color: #b7a75842">{{__('drivers.Days')}}</TH>
                                    <TH style="background-color: #b7a75842">{{__('drivers.SAR')}}</TH>
                                    <TH style="background-color: #b7a75842">{{__('drivers.Days')}}</TH>
                                    <TH style="background-color: #b7a75842">{{__('drivers.SAR')}}</TH>
                                    <TH style="background-color: #b7a75842" style="border-right: 1px solid #f4f4f4!important;">{{__('drivers.Days')}}</TH>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
<input type="hidden" id="check" value="0">


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="https://btcdmins.com/AdminLTE/plugins/iCheck/icheck.min.js"></script>
    <script>
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
                            var tr = "<tr id='jahiz_period_id_"+jahiz_period_id+"'><td style='border: 1px solid'><a onclick='delete_row("+jahiz_period_id+")' href='#'><i class='bi bi-trash' title='delete row'></i></a></td><td style='border: 1px solid;color: red'>"+selectedOptionText+"<input type='hidden' value='"+jahiz_period_id+"' name='jahiz_period_ids[]'></td><td style='border: 1px solid'>"+week1+"</td><td style='border: 1px solid'>"+week2+"</td><td style='border: 1px solid'>"+week3+"</td><td style='border: 1px solid'>"+week4+"</td><td style='border: 1px solid'>"+weekAll+"</td><td style='border: 1px solid'>"+amount_by_days+"</td></tr>";
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
            $('#driverForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("Drivers.store") }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 420) {
                            var alert = 'danger';
                        } else {
                            var alert = 'success';
                        }
                        $('#message').html('<div class="alert alert-'+alert+' alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#driverForm')[0].reset();
                        $('#addNewDriver').modal('hide');
                    },
                    error: function(xhr) {
                        $('#message').html("");
                        document.getElementById('create_da_from').innerHTML = response;
                    }
                });
            });
            $('#filter_claim_dt').val('');
            $('#filter_SANED_SettledDate').val('');
            $('#filter_jahiz_clearing_updated_at').val('');
            $('#filter_created_at').val('');
            $('#filter_updated_at').val('');
            // Clear the input when the cancel button is clicked
            $('#filter_claim_dt').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_SANED_SettledDate').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_jahiz_clearing_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

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
                        url: "{{ URL('New-Portal/DriversJahiz') }}",
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
                                    return '<span class="badge badge-success">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "2") {
                                    return '<span class="badge badge-warning">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "3") {
                                    return '<span class="badge badge-danger">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "4") {
                                    return '<span class="badge badge-secondary">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "5") {
                                    return '<span class="badge badge-danger">' + row.driver_status_en + '</span>';
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
                            className: "table-success",
                            "searchable": false,
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            className: "table-danger",
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
                                let action = @json(__('drivers.Action'));
                                let view = @json(__('drivers.view'));
                                let edit = @json(__('drivers.edit'));
                                let reset_password = @json(__('drivers.reset_password'));
                                let attachment = @json(__('drivers.attachment'));
                                let report_driver = @json(__('drivers.report_driver'));
                                let statement = @json(__('drivers.statement'));
                                let deletee = @json(__('drivers.Delete'));
                                let Issuingdocuments = @json(__('drivers.Issuingdocuments'));

                                let html = `
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    `+action+`
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a id=` + row.id + ` data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view dropdown-item" href="#">`+view+`</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <input type="hidden" id="IDs_all_` + meta.row + `" name="IDs_all_` + meta.row + `" value="` + row.id + `">` + `
                                            <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit dropdown-item" href="#">`+edit+`</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>`;
                                        @if(Auth::user()->user_type_id==1)
                                            html += `<li><a id=` + row.id + ` data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete dropdown-item" href="#"><span style="color:red">`+deletee+`</span></a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            `;
                                        @endif
                                        html += `<li><a id=` + row.id + ` data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue Attachment dropdown-item" href="#">`+attachment+`</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a id=` + row.id + ` data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement">`+statement+`</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>`;

                                        if(row.driver_type_id == null){
                                            html += `<li><a id=` + row.id+ ` data-original-title="Update Driver Type To Issuing documents"  disabled data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents">Issuing documents </a></li>`;
                                        } else {
                                            html += '<li><a id=' + row.id+ ' data-original-title="Issuing documents" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents">'+Issuingdocuments+'</a></li>';
                                        }

                                        html += `<li>
                                            <hr class="dropdown-divider">
                                        </li>`;
                                        @if (Auth::user()->user_type_id == 1)
                                        if (row.warehouseId == '201' || row.warehouseId == '220' || row.warehouseId == '221') {
                                            html += '<li><a id=' + row.id + ' data-original-title="Issuing documents" data-toggle="tooltip" data-placement="top" class=" btnaction btn menu-icon vd_bd-blue vd_blue DriversSettlementList">تصفية</a><li>';
                                        }
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
                    url: "{{URL('/Drivers')}}" + "/" + id + "/edit/2",
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
                        document.getElementById('responseDiv').innerHTML = data;
                    }
                });
                $('#AttachmentModal').modal('show');

            });

            $('#customer_data tbody').on('click', '.DriversSettlementList', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');
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
                    $('#customer_data').DataTable().destroy();
                    fill_datatable('Jahiz', $('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_driver_type_id').val(), $('#filter_fullName').val(), $('#filter_mobileNumber').val(), $('#filter_iqama').val(), $('#filter_job_id').val(), $('#filter_status_id').val(), $('#filter_account_owner_iqama').val(), $('#filter_accountNumber').val(), $('#filter_claim_dt').val(), $('#filter_SANED_SettledDate').val(), $('#filter_jahiz_clearing_updated_at').val(), $('#filter_collectionAmount').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_Image_Identity').val(), $('#filter_Image_Passport').val(), $('#filter_Image_DrivingLicence').val(), $('#filter_Image_VehiclesRegistration').val(), $('#filter_Image_JobContract').val(), $('#filter_Image_PromissoryNote').val());
                    $.ajax({
                        type: 'POST',
                        url: "{{URL("/New-Portal/DriverDetails")}}",
                        cache: false,
                        data : {
                            filter_screenId: 'Jahiz',
                            filter_companyId: $('#filter_companyId').val(),
                            filter_warehouseId: $('#filter_warehouseId').val(),
                            filter_fullName: $('#filter_fullName').val(),
                            filter_mobileNumber: $('#filter_mobileNumber').val(),
                            filter_iqama: $('#filter_iqama').val(),
                            filter_job_id: $('#filter_job_id').val(),
                            filter_status_id: $('#filter_status_id').val(),
                            filter_account_owner_iqama: $('#filter_account_owner_iqama').val(),
                            filter_accountNumber: $('#filter_accountNumber').val(),
                            filter_driver_type_id: $('#filter_driver_type_id').val(),
                            filter_claim_dt: $('#filter_claim_dt').val(),
                            filter_SANED_SettledDate: $('#filter_SANED_SettledDate').val(),
                            filter_jahiz_clearing_updated_at: $('#filter_jahiz_clearing_updated_at').val(),
                            filter_created_at: $('#filter_created_at').val(),
                            filter_collectionAmount: $('#filter_collectionAmount').val(),
                            filter_updated_at: $('#filter_updated_at').val(),
                            filter_Image_Identity: $('#filter_Image_Identity').val(),
                            filter_Image_Passport: $('#filter_Image_Passport').val(),
                            filter_Image_DrivingLicence: $('#filter_Image_DrivingLicence').val(),
                            filter_Image_VehiclesRegistration: $('#filter_Image_VehiclesRegistration').val(),
                            filter_Image_JobContract: $('#filter_Image_JobContract').val(),
                            filter_Image_PromissoryNote: $('#filter_Image_PromissoryNote').val(),
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (data) {
                        let html = '';
                        if ($('#filter_companyId').val() > 0)
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                        if ($('#filter_warehouseId').val() > 0)
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                        if ($('#filter_fullName').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_fullName').val()+'</button>';
                        if ($('#filter_mobileNumber').val() != '')
                            html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_mobileNumber').val()+'</button>';
                        if ($('#filter_iqama').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_iqama').val()+'</button>';
                        if ($('#filter_job_id').val() != '')
                            html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_job_id').val()+'</button>';
                        if ($('#filter_status_id').val() > 0)
                            html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_status_id option:selected').text()+'</button>';
                        if ($('#filter_account_owner_iqama').val() != '')
                            html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_account_owner_iqama').val()+'</button>';
                        if ($('#filter_accountNumber').val() != '')
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_accountNumber').val()+'</button>';
                        if ($('#filter_driver_type_id').val() > 0)
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_driver_type_id option:selected').text()+'</button>';

                        if ($('#filter_Image_Identity').val() != '')
                            html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_Image_Identity option:selected').text()+'</button>';
                        if ($('#filter_Image_Passport').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_Image_Passport option:selected').text()+'</button>';
                        if ($('#filter_Image_DrivingLicence').val() != '')
                            html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_Image_DrivingLicence option:selected').text()+'</button>';
                        if ($('#filter_Image_VehiclesRegistration').val() != '')
                            html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_Image_VehiclesRegistration option:selected').text()+'</button>';
                        if ($('#filter_Image_JobContract').val() != '')
                            html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_Image_JobContract option:selected').text()+'</button>';
                        if ($('#filter_Image_PromissoryNote').val() != '')
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_Image_PromissoryNote option:selected').text()+'</button>';
                        if ($('#filter_claim_dt').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">Claim date: '+$('#filter_claim_dt').val()+'</button>';
                        if ($('#filter_SANED_SettledDate').val() != '')
                            html += '<button type="button" class="btn btn-outline-danger btn-rounded">Saned date: '+$('#filter_SANED_SettledDate').val()+'</button>';
                        if ($('#filter_jahiz_clearing_updated_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">Jahiz date: '+$('#filter_jahiz_clearing_updated_at').val()+'</button>';
                        if ($('#filter_collectionAmount').val() != '')
                            html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_collectionAmount option:selected').text()+'</button>';
                        if ($('#filter_created_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">Created at: '+$('#filter_created_at').val()+'</button>';
                        if ($('#filter_updated_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-light btn-rounded">Updated at: '+$('#filter_updated_at').val()+'</button>';

                        if(html != '') {
                            $('#edit_btn').show();
                            $('#selectedCriteria').html(html);
                        } else {
                            $('#edit_btn').hide();
                        }
                            $('#active_lbl').html(data.active);
                            $('#onhold_lbl').html(data.Onhold);
                            $('#terminated_lbl').html(data.Terminated);
                            $('#wrongWarehouse_lbl').html(data.wrongWarehouse);
                        }
                    });
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
        if ($("#accountNumber").val() != '' && ($("#accountNumber").val().length != 12 || $("#accountNumber").val().substring(0, 3) != '966')) {
            alert('خطا في رقم الحساب : يجب ان يبدا ب 966 ويحتوي علي 12 رقم');
            return false;
        }
        if ($("#account_owner_iqama").val() != '' && ($("#account_owner_iqama").val().length != 10 || ($("#account_owner_iqama").val().substring(0,1) != '1' && $("#account_owner_iqama").val().substring(0,1) != '2'))) {
            alert('خطا في هوية صاحب الحساب : يجب ان يبدا ب 1 او 2 ويحتوي علي 10 ارقام');
            return false;
        }
        var postData = $("#contact_form").serializeArray();
        var formURL = $("#contact_form").attr("action");
        // document.getElementById('response').innerHTML = loader;
        $.ajax({
            url: formURL,
            type: "PUT",
            // cache: false,
            data: postData,
            success: function (data) {
                // $('#edit_modal').modal('toggle');
                document.getElementById('response').innerHTML = data;
            },
            error: function (jqXHR, status, error) {
                document.getElementById('response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
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
                url: "{{URL("/Drivers/create/2")}}",
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

    // Export Excel button click event
    $('#exportExcelBtn').click(function() {
        var table = $('#customer_data').DataTable();
        $('#ExportExcel').modal('hide');
        var selectedColumns = [];
        console.log(selected);
        selected.forEach(element => {
            // if (element['id'] == 7) {
            //     let id  = element['id'] + 2;
            //     selectedColumns.push(id);
            // } else if (element['id'] == 8) {
            //     let id  = element['id'] + 3;
            //     selectedColumns.push(id);
            // } else {
                selectedColumns.push(element['id']);
            // }
        });
        var rowCount = table.rows().count();
        var headerRow = selectedColumns.map(columnId => {
            var label = $('#' + columnId).siblings('label').text();
            return label ? label : '';
        });
        var exportData = [headerRow];

        // var exportData = [selectedColumns.map(columnId => $('#' + columnId).siblings('label').text())];
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
        XLSX.writeFile(wb, 'Drivers.xlsx');
    });
</script>
@stop
@endsection

