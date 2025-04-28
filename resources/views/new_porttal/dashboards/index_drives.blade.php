@extends('layout2')
@section('content')
@section('title', __('drivers.drivers'))
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
    /* td{
        vertical-align: middle !important;
        text-align: center ;
    } */
</style>


<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.Filter')}} </h5>
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
                                            <label for="country" class="form-label">{{__('drivers.Company')}} </label>
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
                                            <label for="country" class="form-label">{{__('drivers.Warehouse')}}</label>
                                            <select class="form-control" id="filter_warehouseId" name="filter_warehouseId" >
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Vehicle')}}</label>
                                            <select name="filter_vehicleId" id="filter_vehicleId" class="form-control"  required>
                                                <option value=""></option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id}}"> {{$vehicle->plate}}</option>
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
                                            <label for="country" class="form-label">{{__('drivers.EmailID')}}</label>
                                            <input type="text" class="form-control" name="filter_email_id" id="filter_email_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.JobId')}}</label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
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
                                        <label for="country" class="form-label">{{__('drivers.Account_Owner_Iqama')}}</label>
                                        <input type="text" class="form-control" name="filter_account_owner_iqama" id="filter_account_owner_iqama">
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.accountNumber')}}</label>
                                        <input type="text" class="form-control" name="filter_accountNumber" id="filter_accountNumber">
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
                                        <label for="country" class="form-label">{{__('drivers.BanderCar')}}</label>
                                        <select name="filter_bander_car_id" id="filter_bander_car_id" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
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
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal" id="reset">{{__('drivers.Reset')}}</button>
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
                <form id="driverForm" enctype="multipart/form-data">
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
    0=>'Company',
    1=>'Warehouse',
    2=>'Type',
    3=>'FullName',
    4=>'Mobile',
    5=>'Iqama',
    6=>'Job ID',
    7=>'Status',
    8=>'Total Balance',
];
$module = "Driver";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')

<!--End Modal ExportExcel 3 -->

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
        </div>
    </div>
</div>
<div class="modal fade" id="statement_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.DriverStatement')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="statement_response">
                </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sheet_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Driver </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response_sheet">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="view_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="responsee">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>

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

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('drivers.driver')}}</div>
            </div>
            <!-- Card start -->
            <form method="POST" action="{{ URL('/DriversPost')}}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;">{{__('drivers.driver_module')}} </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                    <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button>
                                    <button type="button" class="btn btn-info" class="btn btn-info" data-bs-toggle="modal" type="button" data-bs-target="#addNewDriver" onclick="addNewDriver()"></i>{{__('drivers.add_driver')}}</button>
                                    @if(Auth::user()->user_type_id==1)
                                        {{-- <button type="submit" class="btn btn-info" class="btn btn-info" type="submit"></i>On Hold</button> --}}
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999;">
                            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
                                <lottie-player
                                    src="https://assets9.lottiefiles.com/packages/lf20_usmfx6bp.json"
                                    background="transparent"
                                    speed="1"
                                    style="width: 200px; height: 200px;"
                                    loop
                                    autoplay>
                                </lottie-player>
                                <p style="margin-top:20px; font-size:18px; font-weight:bold; color:#555;">Fetching your data...</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Company')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Warehouse')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Type')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.fullName')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Mobile')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Iqama')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.JobId')}}</TH>
                                        <th class="text-center" style="vertical-align: middle;">{{__('drivers.DriverDocs')}}</th>
                                        <TH class="text-center" style="vertical-align: middle;">Driver Data</TH>
                                        <TH class="text-center" style="vertical-align: middle;">Notifications</TH>
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Status')}}</TH>
                                        @if(Auth::user()->user_type_id==1)
                                            <TH class="text-center" style="vertical-align: middle;">{{__('drivers.BanderCar')}}</TH>
                                            <TH class="text-center" style="vertical-align: middle;">{{__('drivers.total_balance')}}</TH>
                                            <TH class="text-center" style="vertical-align: middle;">OverAll</TH>
                                            <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Updated_At')}}</TH>
                                        @endif
                                        <TH class="text-center" style="vertical-align: middle;">{{__('drivers.Action')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle; display:none;">{{__('drivers.AccountNumber')}}</TH>
                                        <TH class="text-center" style="vertical-align: middle; display:none;">{{__('drivers.Account_Owner_Iqama')}}</TH>
                                        <TH style="display:none;">Ben Name</TH>
                                        <TH style="display:none;">Ben Iqama</TH>
                                        <TH style="display:none;">Ben IBAN</TH>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>

<input type="hidden" id="check" value="0">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
<script>
        // Export Excel button click event
    $(document).ready(function () {
        $('#filter_updated_at').val('');
        $('#filter_created_at').val('');

        // Clear the input when the cancel button is clicked
        $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

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
                        var alrt = 'danger';
                        alert(response.message);
                    } else {
                        var alrt = 'success';
                        $('#message').html('<div class="alert alert-'+alrt+' alert-dismissible fade show" role="alert">' + response.message + '<button type="button" onclick="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#driverForm')[0].reset();
                        $('#addNewDriver').modal('hide');
                    }

                },
                error: function(xhr) {
                    alert(response.message);

                    // $('#message').html("");
                    // document.getElementById('create_da_from').innerHTML = xhr;
                }
            });
        });
        fill_datatable();

        function fill_datatable(filter_screenId = '', filter_companyId = '', filter_warehouseId = '', filter_driver_type_id = '', filter_fullName = '', filter_mobileNumber = '', filter_iqama = '', filter_email_id = '', filter_job_id = '', filter_status_id = '', filter_account_owner_iqama = '', filter_accountNumber = '', filter_created_at = '', filter_updated_at = '', filter_bander_car_id = '', filter_Image_Identity = '', filter_Image_Passport = '', filter_Image_DrivingLicence = '', filter_Image_VehiclesRegistration = '', filter_Image_JobContract = '', filter_Image_PromissoryNote = '', filter_vehicleId = '') {
            var dataTable = $('#customer_data').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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
                ajax: {
                    url: "{{ route('Drivers.index') }}",
                    data: {
                        filter_screenId: 'Drivers',
                        filter_vehicleId: filter_vehicleId,
                        filter_companyId: filter_companyId,
                        filter_warehouseId: filter_warehouseId,
                        filter_fullName: filter_fullName,
                        filter_mobileNumber: filter_mobileNumber,
                        filter_iqama: filter_iqama,
                        filter_email_id: filter_email_id,
                        filter_job_id: filter_job_id,
                        filter_status_id: filter_status_id,
                        filter_account_owner_iqama: filter_account_owner_iqama,
                        filter_accountNumber: filter_accountNumber,
                        filter_driver_type_id, filter_driver_type_id,
                        filter_created_at: filter_created_at,
                        filter_updated_at: filter_updated_at,
                        filter_bander_car_id: filter_bander_car_id,
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
                        data: 'companyName',
                        name: 'lkp_company.companyName',
                        render: function (data, type, row, meta) {
                            let link = '';
                            if (row.company_logo == null) {
                                link = "/dashboard/assets/logos/default_imile_logo.jpg";
                            } else {
                                link = "/storage/images/" + row.company_logo;
                            }
                            return '<img src="'+link+'" style="width: 25%; margin-right: 5px">'+row.companyName;
                        }
                    },
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
                        data: 'mobileNumber',
                        name: 'mobileNumber'
                    },
                    {
                        data: 'iqama',
                        name: 'iqama'
                    },

                    {
                        data: 'job_id',
                        name: 'job_id'
                    },
                    {
                        "orderable": false,
                        name: 'job_id',
                        render: function (data, type, row, meta) {
                            var identity = promise_note = contract = '<i style="cursor: not-allowed; color: red; margin-right: 5px" class="bi bi-eye-slash"></i>';
                            if(row.Image_Identity == 1) {
                                identity = '<a target="_blank" href="/Attachment/Image_Identity/'+row.id+'.jpg"><i class="bi bi-eye-fill" title="view" style="color: green"></i></a>';
                            }
                            if(row.Image_PromissoryNote == 1) {
                                promise_note = '<a target="_blank" href="/Attachment/Image_PromissoryNote/'+row.id+'.jpg"><i class="bi bi-eye-fill" title="view" style="color: green"></i></a>';
                            }
                            if(row.Image_JobContract == 1) {
                                contract = '<a target="_blank" href="/Attachment/Image_JobContract/'+row.id+'.jpg"><i class="bi bi-eye-fill" title="view" style="color: green; margin-right: 5px"></i></a>';
                            }
                            return `<table class="inner-table">
                                <thead><tr><th style="color: white">IDENTITY</th><td class="text-center" style="">`+identity+`</td></tr><tr><th style="color: white">PROMISSORY NOTE</th><td class="text-center" style="">`+promise_note+`</td></tr><tr><th style="color: white">CONTRACT</th><td class="text-center" style="display: flex;">`+contract+` | <a target="_blank" href="/DA-Conctrats/` + row.job_id + `"><i class="bi bi-eye-fill" title="E-Contract" style="color: green; margin-left: 5px"></i></a> </td></tr></thead>
                                </table>`;
                        }
                    },
                    {
                        name: 'driver_data',
                        "className": "text-center",
                        render: function (data, type, row, meta) {
                            if (row.driver_data == 'applied') {
                                return '<button type="button" class="btn btn-primary btn-sm" onclick="setRequestIdAndOpenModal(0,' + row.id + ',0)">Approve</button>';
                            } else if (row.driver_data == 'approved') {
                                return '<a class="btn btn-success btn-sm" title="approved"><i class="bi bi-hand-thumbs-up"></i></a>';
                            } else {
                                return '<a class="btn-warning btn-sm" title="pending"><i class="bi bi-hourglass-bottom"></i></a>'
                            }
                        }
                    },
                    {
                        name: 'notificationEnabled',
                        "className": "text-center",
                        render: function (data, type, row, meta) {
                            if (row.notificationEnabled == 1)
                                return '<a class="btn btn-success btn-sm">On</a>';
                            else
                                return '<a class="btn btn-warning btn-sm">Off</a>';
                        }
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
                    @if(Auth::user()->user_type_id==1)
                    {
                        name: 'bander_car.yes_no',
                        render: function (data, type, row, meta) {
                            if (row.bander_car == "Yes") {
                                return '<span class="badge badge-success">' + row.bander_car + '</span>';

                            } else if (row.bander_car == "No") {
                                return '<span class="badge badge-danger">' + row.bander_car + '</span>';
                            }
                            else return '';
                        }
                    },

                    {
                        data: 'per_priod',
                        name: 'balance.per_priod'
                    },
                    {
                        data: 'per_priod',
                        name: 'balance.per_priod'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                        @endif
                    {
                        "orderable": false,
                        className: "dt-nowrap",
                        "targets": -1,
                        "render": function (data, type, row, meta) {
                            let action = @json(__('drivers.Action'));
                            let view = @json(__('drivers.view'));
                            let edit = @json(__('drivers.edit'));
                            let reset_password = @json(__('drivers.reset_password'));
                            let attachment = @json(__('drivers.attachment'));
                            let report_driver = @json(__('drivers.report_driver'));
                            let statement = @json(__('drivers.statement'));
                            let deletee = @json(__('drivers.Delete'));
                            let html = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                `+action+`
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a id=` + row.id + ` data-original-title="view" data-toggle="tooltip" data-placement="top" class="    view dropdown-item" href="#">`+view+`</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <input type="hidden" id="IDs_all_` + meta.row + `" name="IDs_all_` + meta.row + `" value="` + row.id + `">` + `
                                        <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="    edit dropdown-item" href="#">`+edit+`</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a id=` + row.id + ` class="dropdown-item resetpass" href="#">`+reset_password+` </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a id=` + row.id + ` data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class=" Attachment dropdown-item" href="#">`+attachment+`</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li><a class="dropdown-item" href="#">`+report_driver+`</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a id=` + row.id + ` href="#" data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="dropdown-item statement">`+statement+` </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    `;
                                    @if(Auth::user()->user_type_id==1)
                                        html += `
                                        <li><a href="#" id="` + row.id + `" data-original-title="" data-toggle="tooltip" data-placement="top" class="dropdown-item tContract"> No Liability Certificate </a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a href="#" target="_blank" id="` + row.id + `" data-original-title="" data-toggle="tooltip" data-placement="top" class="dropdown-item tec"> Temporary E-Contract </a></li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li><a id=` + row.id + ` data-original-title="delete" data-toggle="tooltip" data-placement="top" class="delete dropdown-item" href="#"><span style="color:red">`+deletee+`</span></a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>`;
                                    @endif
                                html += `</ul>
                                </div>`;

                                return html;
                        }
                    },
                    {
                        visible: false,
                        data: 'accountNumber',
                        name: 'accountNumber',
                    },
                    {
                        visible: false,
                        data: 'account_owner_iqama',
                        name: 'account_owner_iqama',
                    },
                    {
                        visible: false,
                        data: 'benName',
                        name: 'benName',
                    },
                    {
                        visible: false,
                        data: 'benIqama',
                        name: 'benIqama',
                    },
                    {
                        visible: false,
                        data: 'benIBAN',
                        name: 'benIBAN',
                    }
                ]
            });
        }
        $('#customer_data tbody').on('click', '.tec', function (e) {
            e.preventDefault();
            $('#edit_modal').modal('toggle');
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "{{URL('/tempContract')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        });
        $('#customer_data tbody').on('click', '.tContract', function (e) {
            e.preventDefault();
            $('#edit_modal').modal('toggle');
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "{{URL('/tContract')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        });
        $('#customer_data tbody').on('click', '.view', function (e) {
            e.preventDefault();
            document.getElementById('response').innerHTML = "loading";
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

        $('#customer_data tbody').on('click', '.resetpass', function (e) {
            e.preventDefault();
            document.getElementById('response').innerHTML = "loading";
            $('#edit_modal').modal('toggle');
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "{{URL('/ResetPass')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
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
                url: "{{URL('/statement')}}" + "/" + id,
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

            if ($('#filter_vehicleId').val() != '' || $('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_fullName').val() != '' || $('#filter_mobileNumber').val() != '' || $('#filter_iqama').val() != '' || $('#filter_email_id').val() != '' || $('#filter_job_id').val() != '' || $('#filter_status_id').val() != '' || $('#filter_account_owner_iqama').val() != '' || $('#filter_accountNumber').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_bander_car_id').val() != ''|| $('#filter_Image_Identity').val() != '' || $('#filter_Image_Passport').val() != '' || $('#filter_Image_DrivingLicence').val() != '' || $('#filter_Image_VehiclesRegistration').val() != '' || $('#filter_Image_JobContract').val() != '' || $('#filter_Image_PromissoryNote').val() != '') {
                $('#customer_data').DataTable().destroy();
                fill_datatable('Drivers', $('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_driver_type_id').val(), $('#filter_fullName').val(), $('#filter_mobileNumber').val(), $('#filter_iqama').val(), $('#filter_email_id').val(), $('#filter_job_id').val(), $('#filter_status_id').val(), $('#filter_account_owner_iqama').val(), $('#filter_accountNumber').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_bander_car_id').val(), $('#filter_Image_Identity').val(), $('#filter_Image_Passport').val(), $('#filter_Image_DrivingLicence').val(), $('#filter_Image_VehiclesRegistration').val(), $('#filter_Image_JobContract').val(), $('#filter_Image_PromissoryNote').val(), $('#filter_vehicleId').val());
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/New-Portal/DriverDetails")}}",
                    cache: false,
                    data : {
                        filter_screenId: 'Drivers',
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
                        filter_bander_car_id: $('#filter_bander_car_id').val(),
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
                        if ($('#filter_created_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">Created at: '+$('#filter_created_at').val()+'</button>';
                        if ($('#filter_updated_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">Updated at: '+$('#filter_updated_at').val()+'</button>';

                        if ($('#filter_Image_Identity').val() != '')
                            html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_Image_Identity option').val()+'</button>';
                        if ($('#filter_Image_Passport').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_Image_Passport option').val()+'</button>';
                        if ($('#filter_Image_DrivingLicence').val() != '')
                            html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_Image_DrivingLicence option').val()+'</button>';
                        if ($('#filter_Image_VehiclesRegistration').val() != '')
                            html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_Image_VehiclesRegistration option').val()+'</button>';
                        if ($('#filter_Image_JobContract').val() != '')
                            html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_Image_JobContract option').val()+'</button>';
                        if ($('#filter_Image_PromissoryNote').val() != '')
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_Image_PromissoryNote option').val()+'</button>';
                        if ($('#filter_bander_car_id').val() != '')
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_bander_car_id option').val()+'</button>';

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
            $('#edit_btn').hide();
            $('#filter_vehicleId').val('').trigger('change');
            $('#filter_companyId').val('');
            $('#filter_warehouseId').val('');
            $('#filter_fullName').val('');
            $('#filter_mobileNumber').val('');
            $('#filter_iqama').val('');
            $('#filter_email_id').val('');
            $('#filter_job_id').val('');
            $('#filter_status_id').val('');
            $('#filter_account_owner_iqama').val('');
            $('#filter_accountNumber').val('');
            $('#filter_driver_type_id').val('');
            $('#filter_created_at').val('');
            $('#filter_updated_at').val('');
            $('#filter_bander_car_id').val('');
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
        // link.style.visibility = 'hidden';
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
                }
            });
        } else {
            $('#create_da_bulk').show();
            $('#statment').hide();
            $('#create_da_from').hide();
        }
    }
    function add() {
        document.getElementById('edit_modal').style.display = 'block';
        $.ajax({
            type: 'GET',
            url: "{{URL("/Drivers/create/1")}}",
            contentType: "html",
            dataType: 'html',
            success: function (data) {
                document.getElementById('response').innerHTML = data;
                $('#vehicle_id_create').select2({
                    dropdownParent: $('#edit_modal')
                });
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

    function WarehouseName(type = 0) {
        if(type == 1) {
            var filter_companyId = document.getElementById('filtercompanyId').value;
            $('#filter_warehouseId').empty();
            $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                $('#filterwarehouseId').empty();
                $('#filterwarehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filterwarehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });
        } else {
            var filter_companyId = document.getElementById('filter_companyId').value;

            $('#filter_warehouseId').empty();

            $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                $('#filter_warehouseId').empty();
                $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });
        }
    }
    function sheet(id, Period) {
        $('#sheet_modal').modal('toggle');
        $.ajax({
            type: 'GET',
            url: "{{URL("/SalaryShow")}}" + "/" + id + "/" + Period,
            contentType: "html",
            dataType: 'html',
            success: function (data) {
                document.getElementById('response_sheet').innerHTML = data;
            }
        });
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
        $.ajax({
            url: formURL,
            type: "PUT",
            // cache: false,
            data: postData,
            success: function (data) {
                document.getElementById('response').innerHTML = data;
            },
            error: function (jqXHR, status, error) {
                document.getElementById('response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
                alert(status + ": " + error);
            }
        });
        return false;
    }

    function show_date(exp_date) {
        if (exp_date == '') {
            $('#expiry_tr').hide();
        } else {
            $('#expiry_tr').show();
        }
    }
    function show_record(id, type) {
        document.getElementById('responsee').innerHTML = "Loading...";
        $('#view_modal').modal('toggle');
        let urls = '';
        if(type == 'Loan')
            urls = "/Loans" + "/" + id;
        if(type == 'Credit Note')
            urls = "/CreditNotes" + "/" + id;
        $.ajax({
            type: 'GET',
            url: urls,
            contentType: "html",
            dataType: 'html',
            success: function (data) {
                document.getElementById('responsee').innerHTML = data;
            }
        });
    }
    function bankChange() {
        $("#benName").val('');
        $("#benIBAN").val('');
        $("#benIqama").val('');
    }
    var selectedDriverToApprove = '';
    function setRequestIdAndOpenModal(args,driver_id,supporvisor_identity_approve){
        $('#driving_licence').width('120px');
        $('#identity_file').width('120px');
        $('#driving_licence').attr("src", '{{asset('images/loading.gif')}}');
        $('#identity_file').attr("src", '{{asset('images/loading.gif')}}');
        $('#driver_id').val(driver_id)
        selectedDriverToApprove = driver_id;
        $.ajax({
            type: 'GET',
            url: "{{URL("/Drivers/approval-review")}}" + "/" + driver_id,
            contentType: "html",
            dataType: 'html',
            success: function (data) {
                let payload = JSON.parse(data);
                console.log(payload.payload.companyName)
                console.log(payload.payload)
                if(payload.status == true){
                    $('#project_name').text(payload.payload.companyName)
                    $('#hub_name').text(payload.payload.warehouseName)
                    $('#driver_name').text(payload.payload.fullName)
                    $('#driver_id').text(payload.payload.job_id)
                    $('#absher_no').html('<input type="number" id="dMobileNumber" value="'+payload.payload.mobileNumber+'">');
                    $('#driver_dob').html('<input type="date" id="dDob" value="'+payload.payload.dob+'">');
                    $('#email_dob').html('<input type="text" id="dEmail" value="'+payload.payload.email_id+'">');
                    $('#driver_iqama').html('<input type="text" id="dIqama" value="'+payload.payload.iqama+'">');
                    if(payload.payload.iqama == null){
                        $('#driver_identity_no').text("NULL")
                        $('#driver_identity_no').css("color:red");
                    }else{
                        $('#driver_identity_no').text(payload.payload.iqama)
                    }
                        const timeElapsed = Date.now();
                        console.log(timeElapsed);
                        $('#driving_licence').width('300px');
                        $('#driving_licence').attr("src", '/Attachment/Image_DrivingLicence/'+payload.payload['id']+'.jpg?v='+timeElapsed);



                        $('#identity_file').width('300px');
                        $('#identity_file').attr("src", '/Attachment/Image_Identity/'+payload.payload['id']+'.jpg?v='+timeElapsed);

                    if(payload.payload['driver_data'] == 'pending'){
                        $('#status_text').text('Waiting Approval')
                        $('#approveBtn').prop('disabled', false);
                    }else{
                            console.log('supporvisor_identity_approve')
                        console.log(supporvisor_identity_approve)
                        if(supporvisor_identity_approve == 1){
                            $('#status_text').text('Approved At 28-02-2023')
                            $('#approveBtn').prop('disabled', true);
                        }else{
                            $('#status_text').text('Waiting Approval ')
                            $('#approveBtn').prop('disabled', false);
                        }
                    }
                }
            }
        });
        // End of fill modal Data
        $('#DAIdentityApproveModal').modal('toggle')

    }
    function approveIdentity(){
        let request_id = selectedDriverToApprove;
        let mobileNumber = $('#dMobileNumber').val();
        let dob = $('#dDob').val();
        let email = $('#dEmail').val();
        let iqama = $('#dIqama').val();
        if (mobileNumber == '') {
            alert('Please enter Driver mobile number!')
        } else if (dob == '') {
            alert('Please enter Driver DOB date!')
        } else if (email == '') {
            alert('Please enter Driver email account!')
        } else if (iqama == '') {
            alert('Please enter Driver iqama number!')
        } else {
            $.ajax({
                type: 'GET',
                url: "{{URL("Drivers/Approve")}}" + "/" + request_id  + "/" + mobileNumber  + "/" + dob  + "/" + email  + "/" + iqama,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    let payload = JSON.parse(data);
                    if(payload.status){
                        location.reload();
                    }
                }
            });
        }
    }
    function rejectIdentity(){
        var result = confirm("Are you sure Want to reject?");
        if (result) {
            let request_id = selectedDriverToApprove;
            console.log(request_id);
            $.ajax({
                type: 'GET',
                url: "{{URL("Drivers/Reject")}}" + "/" + request_id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    let payload = JSON.parse(data);
                    if(payload.status){
                        location.reload();
                    }
                }
            });
        }
    }
    function driverInfoChange(type) {
        $('.personal').hide();
        $('.financial').hide();
        $('.'+type).show();
    }
    function newRequest(id) {
        $.ajax({
            type: 'GET',
            url: "{{URL('/tRequest')}}" + "/" + id,
            contentType: "html",
            dataType: 'html',
            success: function (data) {
                document.getElementById('response').innerHTML = data;
            }
        });
    }
    function validateTRequestForm(id) {
        var form = document.getElementById('tRequestForm');
        var formData = new FormData(form);
        var formURL = $("#tRequestForm").attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                document.getElementById('response').innerHTML = data;
            },
            error: function (jqXHR, status, error) {
                document.getElementById('response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
                alert(status + ": " + error);
            }
        });
        return false;
    }
</script>

<script>
    function check_uncheck() {
        selected = [];
        var all_array = @json($array);
        $('#forwardBtn').removeClass('disabled');
        $('#reverseBtn').addClass('disabled');
        if ($('#select_all').prop('checked')) {
            $(".select_options").addClass("active");
            let i = 0;
            all_array.forEach(element => {
                selected.push({ id: i, name: element });
                i++;
            });
        } else {
            $(".select_options").removeClass("active");
        }
    }
    function check_uncheckSecond() {
        selected = [];
        $('#forwardBtn').addClass('disabled');
        $('#reverseBtn').removeClass('disabled');
        var second_array = @json($array);
        if ($('#select_all_second').prop('checked')) {
            $(".unselect_options").removeClass("active");
        } else {
            let i = 0;
            second_array.forEach(element => {
                selected.push({ id: i, name: element });
                i++;
            });
            $(".unselect_options").addClass("active");
        }
    }
    // Export Excel button click event
    $('#exportExcelBtn').click(function() {
            var table = $('#customer_data').DataTable();
            $('#ExportExcel').modal('hide');
            var selectedColumns = [];
            selected.forEach(element => {
                if (element['id'] == 7) {
                    let id  = element['id'] + 3;
                    selectedColumns.push(id);
                } else if (element['id'] == 8) {
                    let id  = element['id'] + 4;
                    selectedColumns.push(id);
                } else {
                    selectedColumns.push(element['id']);
                }
            });
            var rowCount = table.rows().count();
            var headerRow = selected.map(obj => {
                var label = obj['name'];
                return label ? label : '';
            });

            var exportData = [headerRow];
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
