@extends('layout2')
@section('content')
@section('title', __('drivers.drivers'))
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
    <div class="modal-dialog">
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
                                            <input type="date" class="form-control datepicker-range" id="filter_created_at" name="filter_created_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Updated_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="date" class="form-control datepicker-range" id="filter_updated_at" name="filter_updated_at">
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
<div class="modal fade" id="ExportExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.ExportDriverExcel')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Row start -->
                <div class="row">
                    <div class="col-xl-12 col-sm-12 col-12">
                        <p>{{__('drivers.criteria_msg')}}. </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="table">
                            {{-- End Header --}} 
                            <tr>
                                <td>
                                   <input type="checkbox" name="" id=""> Select all
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    <input type="checkbox" name="" id=""> Unselect all
                                </td>
                            </tr>
                            {{-- End Header --}} 
                    
                    
                            {{-- Body --}} 
                            @php 
                    
                            $array = [
                                0=>'Company name',
                                1=>'Hub',
                                2=>'Driver name',
                                3=>'Driver ID',
                                4=>'Balance',
                                5=>'Suppervisor', 
                            ]; 
                            @endphp
                            <tr>
                                <td>
                                    <ul class="list-group"> 
                                        @foreach($array as $k=>$option)
                                            <li class="list-group-item"  id="option{{$k}}" onclick="selectOption('{{$k}}')" style="cursor: pointer;">{{$option}}</li>
                                        @endforeach  
                                    </ul>
                                </td>
                                <td style="text-align: center;">
                                    <img style="width: 37px;    margin-top: 4px;" src="{{asset('assets/2735071.png')}}" alt="">
                                    <br>
                                    <img style="width: 37px; margin-top: 53px;" src="{{asset('assets/2985161.png')}}" alt="">
                                </td>
                                <td>
                                    <ul class="list-group"> 
                                        @foreach($array as $k=>$option)
                                            <li class="list-group-item"  id="unselect_option{{$k}}" onclick="unselectOption('{{$k}}')" style="    cursor: pointer;"> &nbsp </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>  
                            {{-- End Body --}}
                    
                    
                            {{-- Footer --}}
                            <tr>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td style="text-align: right;">
                                    Total Select (<span style="color: red">3</span>)
                                </td>
                            </tr>  
                            {{-- End-Footer --}}
                        </table>
                    </div>
                </div>
                <!-- Row end -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" style="background-color: red">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-success" style="background-color: #2661ba" id="exportExcelBtn">{{__('drivers.Download')}}</button>
            </div>
        </div>
    </div>
</div>

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
<div class="modal fade" id="delete_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-body">
                    <p>{{__('drivers.Delete_msg')}} <span id="delete_name"></span> ?</p>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                      <button class="btn btn-danger" type="submit">{{__('drivers.Delete')}}</button>
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
                <h3 class="text-red" style="font-size: 19px;">{{ number_format($analatics['Onhold'], 0, '.', ',')}} </h3>
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
                <h3 class="text-blue"> {{ number_format($analatics['Terminated'], 0, '.', ',')}} </h3>
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
                <h3 class="text-yellow"> {{ number_format($analatics['wrongWarehouse'], 0, '.', ',')}} </h3>
                <p>{{__('drivers.WrongWarehouse')}}</p>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-10"> 
                    <div class="custom-btn-group">
                        <button type="button" class="btn btn-outline-primary btn-rounded">iMile</button>
                        <button type="button" class="btn btn-outline-secondary btn-rounded">Riyadh Munesia </button>
                        <button type="button" class="btn btn-outline-warning btn-rounded">(2024-02-01 - 2024-02-31)</button>
                        <button type="button" class="btn btn-outline-success btn-rounded">Paid</button>
                        <button type="button" class="btn btn-outline-danger btn-rounded">Danger</button>
                        
                        <button type="button" class="btn btn-outline-info btn-rounded">Active</button>
                        <button type="button" class="btn btn-outline-light btn-rounded">Created by Ashraf</button> 
                    </div>  
                </div>
                <div class="col-2">
                    <!-- Card start -->
                    
                            <div class="custom-btn-group"> 
                                <button type="button" style="    margin: 0 auto;"  class="btn btn-outline-light btn-rounded">Edit</button> 
                            </div>
                            
                    <!-- Card end --> 
                </div>
            </div> 
        </div>
    </div>
    </div>
    
</div>
<style>
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
</style>

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
                        <div class="table-responsive">
                            <table id="customer_data" class="table custom-table">
                                <thead>
                                    <TH>{{__('drivers.Company')}}</TH>
                                    <TH>{{__('drivers.Warehouse')}}</TH>
                                    <TH>{{__('drivers.Type')}}</TH>
                                    <TH>{{__('drivers.fullName')}}</TH>
                                    <TH>{{__('drivers.Mobile')}}</TH>
                                    <TH>{{__('drivers.Iqama')}}</TH>
                                    <TH>{{__('drivers.JobId')}}</TH>
                                    <th>{{__('drivers.DriverDocs')}}</th>
                                    <TH>{{__('drivers.AppStatus')}}</TH>
                                    <TH>{{__('drivers.Status')}}</TH>
                                    @if(Auth::user()->user_type_id==1)
                                        {{-- <TH>{{__('drivers.OnHold')}} --}}
                                            {{-- <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>
                                        </TH> --}}

                                        <TH>{{__('drivers.BanderCar')}}</TH>
                                        <TH>{{__('drivers.total_balance')}}</TH>
                                        {{-- <TH>{{__('drivers.PBalance')}}</TH>
                                        <TH>{{__('drivers.CBalance')}}</TH> --}}
                                        <TH>{{__('drivers.Updated_At')}}</TH>
                                    @endif
                                    <TH>{{__('drivers.Action')}}</TH>


                                    <TH style="display:none;">{{__('drivers.AccountNumber')}}</TH>
                                    <TH style="display:none;">{{__('drivers.Account_Owner_Iqama')}}</TH>


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
            XLSX.writeFile(wb, 'Drivers.xlsx');
        });
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
                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
                        // $(function () {
                        //     $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                        //         checkboxClass: 'icheckbox_flat-red',
                        //         radioClass: 'iradio_flat-red'
                        //     });


                        //     $('#select-all').on('ifChecked ifUnchecked', function (event) {
                        //         if (document.getElementById('select-all').checked) {

                        //             $('.flat-red').iCheck('check')
                        //         } else
                        //             $('.flat-red').iCheck('uncheck');
                        //     });
                        // });
                    },
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

                                return '<img src="/dashboard/assets/logos/default_imile_logo.jpg" style="width: 25%; margin-right: 5px">'+row.companyName;

                            //     if (row.Company_Image == 1) {
                            //         image = `/Attachment/Company_Image/`+row.id+`.jpg`;
                            //     }
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
                        // {
                            // data: 'vehicle',
                            // name: 'vehicle',
                        // },
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
                                    <thead><tr><th style="color: white">IDENTITY</th><td class="text-center" style="">`+identity+`</td></tr><tr><th style="color: white">PROMISSORY NOTE</th><td class="text-center" style="">`+promise_note+`</td></tr><tr><th style="color: white">CONTRACT</th><td class="text-center" style="display: flex;">`+contract+` | <a target="_blank" href="/Attachment/Image_JobContract/'+row.id+'.jpg"><i class="bi bi-eye-fill" title="E-Contract" style="color: green; margin-left: 5px"></i></a> </td></tr></thead>
                                    </table>`;
                            }
                        },
                        {
                            "orderable": false,
                            data: 'app_status',
                            name: 'driver_status_en',
                            render: function (data, type, row, meta) {
                                    return '<span class="badge badge-warning">Not Yet</span>';
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
                        // {
                        //     "orderable": false,
                        //     "className": "text-center",
                        //     "render": function (data, type, row, meta) {
                        //         var i = '';
                        //         i = '<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.id + '"';
                        //         if (row.status_id == "5")
                        //             i = i + ' checked ';
                        //         i = i + '>';
                        //         if (row.status_id == "5")
                        //             i = i + '&nbsp;' + row.onhold_date;
                        //         return i;


                        //     }
                        // },
                        {
                            //data: 'driver_status_en',
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
                        // {
                        //     data: 'cur_priod',
                        //     name: 'balance.cur_priod'
                        // },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                            @endif
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            //"data": 'id',
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
                                        </li>
                                        <li>
                                            <a id=` + row.id + ` class="dropdown-item resetpass" href="#">`+reset_password+` </a>
                                        </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a id=` + row.id + ` data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue Attachment dropdown-item" href="#">`+attachment+`</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li><a class="dropdown-item" href="#">`+report_driver+`</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a id=` + row.id + ` data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement">`+statement+` </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    `;
                                    @if(Auth::user()->user_type_id==1)
                                        html += `<li><a id=` + row.id + ` data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete dropdown-item" href="#"><span style="color:red">`+deletee+`</span></a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>`;
                                    @endif
                                    html += `</ul>
                                    </div>`;

                                    return html;
                            }
                        },
                                //     if(Auth::user()->user_type_id==1)
                                //         '&nbsp;<a id=' + row.id + ' data-original-title="Clearance" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-black vd_black Clearance"> C </a>' +
                                //     endif
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
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
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
    function add() {
        // document.getElementById('response').innerHTML = loader;
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
        myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
            "height=1000,width=750,scrollbars=yes,top=1,left=1,status,resizable");
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
        // e.preventDefault();
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

    function show_date(exp_date) {
        if (exp_date == '') {
            $('#expiry_tr').hide();
        } else {
            $('#expiry_tr').show();
        }
    }
</script>
<script>
    function selectOption(args){
        var option_id = 'option'+args;
         
        var option_id = document.getElementById(option_id);
        
        // console.log(element.classList);
        var classList = option_id.classList
        classList.forEach(element => {
            if(element == 'active'){
                classList.remove("active");
            }else{
                classList.add("active");
            }
        });
        // console.log(index);
    }
</script>
@stop
@endsection

