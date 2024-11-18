@extends('layout2')
@section('content')
@section('title', 'Vehicles')

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
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.CompanyName')}} </label>
                                            <select name="filter_companyId[]" id="filter_companyId" onchange="WarehouseName()" class="form-control" required multiple>
                                                <option value=""></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.WarehouseName')}} </label>
                                            <select id="filter_warehouseId" name="filter_warehouseId[]" class="form-control" multiple>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.EMPID')}} </label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.LoanType')}} </label>
                                            <select id="filter_Loan_type" name="filter_Loan_type" class="form-control">
                                                <option value="0"></option>
                                                <option value="PL">{{__('loans.PersonalLoan')}}</option>
                                                <option value="FL">{{__('loans.FuelExpense')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.Driver')}} </label>
                                            <span style="display: flex">
                                                <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                                                <input class="form-control" name="filter_driverId_input"
                                                id="filter_driverId_input" type="text" value=""
                                                readonly>
                                               <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                                {{__('loans.Select')}}
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.Amount')}} </label>
                                            <input type="text" class="form-control" name="filter_amount" id="filter_amount" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.status')}} </label>
                                            <select id="filter_status_id" name="filter_status_id" class="form-control">
                                                <option value=""></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.Note')}} </label>
                                            <input type="text" class="form-control" name="filter_note" id="filter_note" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.UpdatedBy')}} </label>
                                            <select id="filter_updatedby_id" name="filter_updatedby_id" class="form-control">
                                                <option value=""></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.UpdateUserType')}} </label>
                                            <select id="filter_updated_usertypeid" name="filter_updated_usertypeid"
                                                class="form-control">
                                                <option value=""></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.RequestDate')}} </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar4"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker-range" id="filter_journal_date" name="filter_journal_date">
                                            </div>
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
                <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>
@php
$array = [
    0=>'Create',
    1=>'Comp',
    2=>'WHouse',
    3=>'Job ID',
    4=>'Driver',
    5=>'Previous Balance',
    6=>'Current Balance',
    7=>'Journal Date',
    8=>'Journal Period',
    9=>'Amount',
    10=>'Note',
    11=>'Status',
    12=>'Attempt',
    13=>'Iqama',
    14=>'STC No',
    15=>'Create By',
    16=>'Update At',
];
$module = "Loan";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')
<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Accessories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('vehicles/utilities/update')}}">
                @csrf
               <div class="modal-body">
                   <input type="hidden" name="vehicle_id" id="vehicleId" value="">
                   <span id="utilities_div">

                   </span>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary">Save changes</button>
               </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->

<!-- Create Checkup Modal -->
<div class="modal fade" id="CreateCheckupModal" tabindex="-1" role="dialog" aria-labelledby="CreateCheckupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CreateCheckupModalLabel">Create New vehicle Checkup</h5>
          <button type="button" style="margin-bottom: 16px;"  class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{url('vehicles/update-vehicle-checkup')}}" method="post"  enctype="multipart/form-data" >
            <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label >Selected vehicle </label>
                  <input  type="text" disabled class="form-control" id="selectedVehicle" aria-describedby="emailHelp" >
                  <input type="hidden" name="vehicle_id" id="vehicle_id" >
                  <input type="hidden" name="serialNumber" id="serialNumber" >
                  {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
                <div class="form-group">
                    <label >Vehicle Otometers Read </label>
                    <input type="number" min="1" required class="form-control" name="otometerRead" style="float: left;width: 90%;"  > <span style="float: left;font-size: 18px; margin-left: 9px;color: #dd4b39;">K/M</span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Delegation Type</label>
                    <select class="form-control" required name="delegationType">
                      <option value="vehicle_receipt">Vehicle receipt</option>
                      <option value="vehicle_return">Vehicle return</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Left side image </label>
                    <div class="drop-zone" style="background-image: url('{{url('/images/vehicleSides/Image2.png')}}'); background-size: contain; background-repeat: no-repeat;max-width: 39%;color: #dd4b39;">
                        <span class="drop-zone__prompt">Drop vehicel's Left side image here or click to upload</span>
                        <input type="file" requried accept=".gif,.jpg,.jpeg,.png" name="left" class="drop-zone__input" style="display:none">
                    </div>
                </div>
                <div class="form-group">
                    <label >Right side image </label>
                    <div class="drop-zone" style="background-image: url('{{url('/images/vehicleSides/Image3.png')}}'); background-size: contain; background-repeat: no-repeat;max-width: 39%;color: #dd4b39;">
                        <span class="drop-zone__prompt">Drop vehicel's Right side image here or click to upload</span>
                        <input type="file" requried accept=".gif,.jpg,.jpeg,.png"  name="right" class="drop-zone__input" style="display:none">
                    </div>
                </div>

                <div class="form-group">
                    <label >Front side image </label>
                    <div class="drop-zone" style="background-image: url('{{url('/images/vehicleSides/Image4.png')}}'); background-size: contain; background-repeat: no-repeat;max-width: 39%;color: #dd4b39;">
                        <span class="drop-zone__prompt">Drop vehicel's Front side image here or click to upload</span>
                        <input type="file" requried accept=".gif,.jpg,.jpeg,.png"  name="front" class="drop-zone__input" style="display:none">
                    </div>
                </div>

                <div class="form-group">
                    <label >Rear side image </label>
                    <div class="drop-zone" style="background-image: url('{{url('/images/vehicleSides/Image5.png')}}'); background-size: contain; background-repeat: no-repeat;max-width: 39%;color: #dd4b39;">
                        <span class="drop-zone__prompt">Drop vehicel's Rear side image here or click</span>
                        <input type="file" requried accept=".gif,.jpg,.jpeg,.png"  name="rear" class="drop-zone__input" style="display:none">
                    </div>
                </div>

                <div class="form-group">
                    <label >Interior side image </label>
                    <div class="drop-zone" style="background-image: url('{{url('/images/vehicleSides/Image6.png')}}'); background-size: contain; background-repeat: no-repeat;max-width: 39%;color: #dd4b39;">
                        <span class="drop-zone__prompt">Drop vehicel's Interior image here or click to upload</span>
                        <input type="file" requried accept=".gif,.jpg,.jpeg,.png"  name="interior" class="drop-zone__input" style="display:none">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" value="Confirm" class="btn btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>
<!-- Create Checkup Modal -->

<!-- Vehicle extra data Modal -->
<div class="modal fade" id="VehicleExtraDataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Information</h5>
                <div class="w3-bar w3-black">
                    <button class="w3-bar-item w3-button" onclick="openCity('London')">Vehicle information</button>
                    <button class="w3-bar-item w3-button" onclick="openCity('Paris')" style="border-left: #ffffff 1px solid;">Vehicle Images </button>
                    <button class="w3-bar-item w3-button" onclick="openCity('Tokyo')" style="border-left: #ffffff 1px solid;">Summery</button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="London" class="city">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th >Plate</th>
                                <td id="plate"> </td>
                                <th >Vehicle Model </th>
                                <td id="vehcile_model"></td>
                            </tr>
                            <tr>
                                <th >Current City</th>
                                <td id="city"> </td>
                                <th >Manufacturer</th>
                                <td id="manufacturer"></td>
                            </tr>
                            <tr>
                                <th >Manufacturer year</th>
                                <td id="manufacturer_year"></td>
                                <th >Opreater company</th>
                                <td id="opreaterCompany"></td>
                            </tr>
                            <tr>
                                <th >Serial Number</th>
                                <td id="srNo"></td>
                                <th >Body Number</th>
                                <td id="bodyNumber"></td>
                            </tr>
                            <tr>
                                <th >free Extra Otometer</th>
                                <td id="freeExtraOtometer"></td>
                                <th >Extra Otometer rate  </th>
                                <td id="extraOtometerRate"></td>
                            </tr>
                            <tr>
                                <th >Vehicle Otometer</th>
                                <td id="Otometer"></td>
                                <th  >Vehicle accessories</th>
                                <td >
                                    <ul id="accessories">
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <th >Registertion type</th>
                                <td id="registertion_type"></td>
                                <th >Vehicle status</th>
                                <td id="status"></td>
                            </tr>
                            <tr>
                                <th >Color</th>
                                <td id="color"></td>
                                <th>Vehicle registration expire date</th>
                                <td id="vehicle_registration_expire_date"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="Paris" class="city" style="display:none">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Side Description</th>
                                <th colspan="3">Image</th>
                                <!--<th>Approvel Status</th>-->
                            </tr>
                            <tr>
                                <th >Left side Images</th>
                                <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img onclick="imageModal(this)" src="{{asset("images/no_imag.jpg")}}" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" id="left_image" srcset=""> </a></td>
                                <!--<td><span style="color:#dd4b39" id="left_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Right side Images</th>
                                <td colspan="3" style="text-align: center;"><a id="right_image_a" onclick="imageModal(this)" href="#"><img src="{{asset("/images/vehicleSides/Image3.png")}}" id="right_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="right_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Front side Images</th>
                                <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img onclick="imageModal(this)" src="{{asset("/images/vehicleSides/Image4.png")}}"  id="front_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_RearImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="front_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Rear side Images</th>
                                <td colspan="3" style="text-align: center;"><a id="rear_image_a" href="#"><img onclick="imageModal(this)" src="{{asset("/images/vehicleSides/Image5.png")}}" id="rear_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_LeftImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="rear_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Interior Images</th>
                                <td colspan="3" style="text-align: center;"><a id="drivingWheel_image_a" href="#"><img onclick="imageModal(this)" src="{{asset("/images/vehicleSides/Image6.png")}}" id="drivingWheel_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_RightImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="Interior_status"> </span></td>-->
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="Tokyo" class="city" style="display:none">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th >Vehicle registration expire in </th>
                                <td id="reg_expiry_days">N/A</td>
                            </tr>
                            <tr>
                                <th >Valid delegation expires in </th>
                                <td id="del_expiry_days">N/A</td>
                            </tr>
                            <tr>
                                <th >Delegations quntity</th>
                                <td id="del_quantity">N/A</td>
                            </tr>
                            <tr>
                                <th>Utilities quntity</th>
                                <td colspan="3" id="util_total"> N/A </td>
                            </tr>
                            <tr>
                                <th>Woking Days</th>
                                <td colspan="3" id="work_days"> N/A </td>
                            </tr>
                            <tr>
                                <th >Maintenance days </th>
                                <td colspan="3" id="main_days"> N/A </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
        </div>
    </div>
</div>

<!-- Vehicle extra data Modal -->
<div class="modal fade" id="driver_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Delegation Drivers Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="width:100%;clear:both;" id="driversResponse">

                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>

              {{-- <button type="submit" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="report_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicles Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('Vehicles/download_vehicles_report')}}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            Date:
                            <input type="date" name="date" id="date" class="form-control" value='{{date("Y-m-d")}}' required max="{{date("Y-m-d")}}">
                        </div>
                        <div class="col-lg-4">
                            Type:
                            <select id="type" name="type" required class="form-control">
                                <option value="">Select type</option>
                                <option value="" selected>abc</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mt-4">
                            <input type="button" class="btn btn-primary" onclick="downloadReport()" value="Show">
                        </div>
                        <div class="col-lg-2 mt-4">
                            <input type="submit" class="btn btn-success" value="Download">
                        </div>
                    </div>
                </form>
                <table id="" class="table table-bordered">
                    <thead>
                        <tr>
                            <TH>City</TH>
                            <TH>Available</TH>
                            <TH>Maintenance</TH>
                            <TH>Damaged</TH>
                            <TH>Delegated</TH>
                            <TH>Total</TH>
                        </tr>
                    </thead>
                    <tbody id="report_body"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-sm-12 col-12">
            <div id="message"></div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Vehicles Lists</div>
                </div>
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;">From this page you can view Vehicles detail. </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
                                    <form method="POST" action="{{ url('Vehicles/download_vehicles_report')}}">
                                        @csrf
                                        <a class="btn btn-sm btn-info " onclick="downloadReport()"><i class="bi bi-download"></i>Download Report</a>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div id="loader" style="display:none;">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <TH>#</TH>
                                        <TH >Plate</TH>
                                        <TH >City</TH>
                                        <th >Manufacturer </th>
                                        <th >Vehicle model </th>
                                        <th >Opreater company  </th>
                                        <th >Color </th>
                                        <th >Vehicle Otometer </th>
                                        <th >Registertion type </th>
                                        <th >Vehicle status </th>
                                        <th >Delegation status </th>
                                        <th >Additional data </th>
                                        <th >Operations</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th >#</th>
                                        <th >Plate </th>
                                        <th >City </th>
                                        <th >Manufacturer </th>
                                        <th >Vehicle model </th>
                                        <th >Opreater company  </th>
                                        <th >Color </th>
                                        <th >Vehicle Otometer </th>
                                        <th >Registertion type </th>
                                        <th >Vehicle status </th>
                                        <th >Delegation status </th>
                                        <th >Additional data </th>
                                        <th >Operations</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Card end -->
                </div>
            <!-- Card end -->
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    @section('javascript')
        <!-- Main Js Required -->
        <script src="{{asset('assets/js/main.js')}}"></script>
        <script>
        function imageModal(the) {
            $('#edit_modal').modal('show');
            let html = `<img style="width: inherit;" src="`+the.src+`">`;
            document.getElementById('response').innerHTML = html;
        }
        function downloadReport() {
            let date = $('#date').val();
            let type = $('#type').val();
            $('#report_modal').modal('show');
            document.getElementById('report_body').innerHTML = '';
            $.ajax({
                type: 'POST',
                url: "{{url('Vehicles/VehicleReport')}}",
                cache: false,
                data: {
                    date: date,
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('report_body').innerHTML = data;
                }
            });
        }
        function WarehouseName() {
            var selectElement = document.getElementById('filter_companyId');
            // Get the selected options
            var selectedOptions = [];
            for (var i = 0; i < selectElement.options.length; i++) {
                var option = selectElement.options[i];
                if (option.selected) {
                    selectedOptions.push(option.value);
                }
            }
            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "")
                $('#filter_warehouseId').empty();
            else {
                $.getJSON("{{URL("/getMultipleWarehouseName")}}" + "/" + selectedOptions, function (json) {
                    $('#filter_warehouseId').empty();
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }
        function loadModels() {
            var selectElement = document.getElementById('filter_vehicle_manufecturerId');
            // Get the selected options
            var selectedOptions = [];
            for (var i = 0; i < selectElement.options.length; i++) {
                var option = selectElement.options[i];
                if (option.selected) {
                    selectedOptions.push(option.value);
                }
            }
            var filter_vehicle_manufecturerId = document.getElementById('filter_vehicle_manufecturerId').value;
            if (filter_vehicle_manufecturerId == "")
                $('#filter_modelId').html(sOption);
            else {
                $.getJSON("{{URL("/getMultipleVehicleModels")}}" + "/" + selectedOptions, function (json) {
                    $('#filter_modelId').empty();
                    $.each(json, function (i, obj) {
                        $('#filter_modelId').append($('<option>').text(obj.name_en).attr('value', obj.id));
                    });
                });
            }
        }
        function vehicleEdit(vehicle_id) {
            $('#edit_modal').modal('show');
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                type: 'POST',
                url: "{{url('Vehicles/EditVehicle')}}",
                cache: false,
                data: {
                    vehicle_id: vehicle_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function validateUpdateForm() {

            if ($("#edit_current_status").val() == '' ) {
                alert('Please select current status')
                return false;
            }
            if ($("#edit_plate").val() == '' ) {
                alert('Please Enter Plate Number')
                return false;
            }

            $("#edit_city_id").prop("disabled", false);

            var postData = $("#contact_form").serializeArray();
            document.getElementById('response').innerHTML = loader;
            $.ajax({
               url: "{{url('Vehicles/UpdateVehicle')}}",
                type: "POST",
                cache: false,
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
        function vehicleHistory(vehicle_id) {
            $('#edit_modal').modal('show');
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                type: 'POST',
                url: "{{url('Vehicles/historyVehicle')}}",
                cache: false,
                data: {
                    vehicle_id: vehicle_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function driversInfo(vehicle_id, start_date, end_date) {
            $('#driver_modal').modal('show');
            $.ajax({
                type: 'POST',
                url: "{{url('Vehicles/historyVehicleDrivers')}}",
                cache: false,
                data: {
                    vehicle_id: vehicle_id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('driversResponse').innerHTML = data;
                }
            });
        }
        function vehicleExtraInfo(images, plate, name_en, vehicle_manufacturer, manufacturer_date, vehicle_model, vehicle_opreator, SNno, body_number, freeExtraOtometer, extraOtometerRate, extraOtometerCharge, otometer, registertion_type, current_status, color, vehicle_registration_expire_date, vehicle_utilities_html='')
        {
            $.ajax({
                type: 'POST',
                url: "{{url('Vehicles/vehicleInfo')}}",
                cache: false,
                data: {
                    plate: plate,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    let arr = data.split(":::");
                    $('#del_expiry_days').html(arr[0]);
                    $('#del_quantity').html(arr[1]);
                    $('#work_days').html(arr[2]);
                    $('#main_days').html(arr[3]);
                    $('#util_total').html(arr[4]);
                }
            });
            if(images != '') {

                let img_arr = images.split(":::");
                $('#left_image').attr("src", img_arr[0]);
                $('#right_image').attr("src", img_arr[1]);
                $('#rear_image').attr("src", img_arr[2]);
                $('#front_image').attr("src", img_arr[3]);
                $('#drivingWheel_image').attr("src", img_arr[4]);
            } else {
                $('#left_image').attr("src", '/images/no_imag.jpg');
                $('#right_image').attr("src", '/images/no_imag.jpg');
                $('#rear_image').attr("src", '/images/no_imag.jpg');
                $('#front_image').attr("src",'/images/no_imag.jpg');
                $('#drivingWheel_image').attr("src", '/images/no_imag.jpg');
            }
            // if(images != ''){
            //     $('#left_image').attr("src", images['left_image']);
            //     $('#right_image').attr("src", images['right_image']);
            //     $('#rear_image').attr("src", images['rear_image']);
            //     $('#front_image').attr("src", front_image);
            //     $('#drivingWheel_image').attr("src", images['drivingWheel_image']);

            //     $('#front_image_a').attr("href", images['drivingWheel_image']);
            //     $('#right_image_a').attr("href", images['drivingWheel_image']);
            //     $('#rear_image_a').attr("href", images['drivingWheel_image']);
            //     $('#drivingWheel_image_a').attr("href", images['drivingWheel_image']);

            //     // front_image_submittedBy
            //     $("#front_image_submittedBy").empty();
            //     $('#front_image_submittedBy').append(images['uploadedBy']);
            //     $("#front_image_reviedBy").empty();
            //     $('#front_image_reviedBy').text(images['ApprovedBy'])
            //     $("#front_image_timeStamp").empty();
            //     $('#front_image_timeStamp').text(images['created_at'])

            //     if(images['left_image_approve'] == null){
            //             $("#left_status").empty();
            //             $('#left_status').append('NULL')
            //     }else{
            //             $("#left_status").empty();
            //             $('#left_status').append('Approved')
            //     }
            //     if(images['right_image_approve'] == null){
            //             $("#right_status").empty();
            //             $('#right_status').append('NULL')
            //     } else{
            //             $("#right_status").empty();
            //             $('#right_status').append('Approved')
            //     }
            //     if(images['front_image_approve'] == null){
            //             console.log('left_image_approve NULL');
            //             $("#front_status").empty();
            //             $('#front_status').append('NULL')
            //     } else{
            //             $("#front_status").empty();
            //             $('#front_status').append('Approved')
            //     }
            //     if(images['rear_image_approve'] == null){
            //             console.log('left_image_approve NULL');
            //             $("#rear_status").empty();
            //             $('#rear_status').append('NULL')
            //     } else{
            //             $("#rear_status").empty();
            //             $('#rear_status').append('Approved')
            //     }
            //     if(images['interior_image_approve'] == null){
            //             $("#Interior_status").empty();
            //             $('#Interior_status').append('NULL')
            //     } else{
            //             $("#Interior_status").empty();
            //             $('#Interior_status').append('Approved')
            //     }

            // } else {
            //     $('#front_image_reviedBy').text('NONE');
            //     $('#front_image_submittedBy').text('NONE');
            //     $('#front_image_timeStamp').text('NONE');

            //     $('#front_image_a').attr("href", '#');
            //     $('#right_image_a').attr("href", '#');
            //     $('#front_image_a').attr("href", '#');
            //     $('#rear_image_a').attr("href", '#');
            //     $('#drivingWheel_image_a').attr("href", '#');
            // }

            $('#plate').text(plate);
            $('#city').text(name_en);
            $('#manufacturer').text(vehicle_manufacturer);
            $('#manufacturer_year').text(manufacturer_date);
            $('#vehcile_model').text(vehicle_model);
            $('#opreaterCompany').text(vehicle_opreator);
            $('#srNo').text(SNno);
            $('#bodyNumber').text(body_number);
            if(freeExtraOtometer == null){
                    $('#freeExtraOtometer').text('NULL');
            }else{
                    $('#freeExtraOtometer').text(freeExtraOtometer);
            }

            if(extraOtometerRate == null){
                $('#extraOtometerRate').text('NULL');
            }else{
                $('#extraOtometerRate').text(extraOtometerCharge);
            }
            $('#Otometer').text(otometer+ ' k/m');
            $('#registertion_type').text(registertion_type);
            $('#status').text(current_status);
            $('#color').text(color);
            $('#vehicle_registration_expire_date').text(vehicle_registration_expire_date);
            $("#accessories").empty();
            $('#accessories').append(vehicle_utilities_html);
            $('#VehicleExtraDataModal').modal('toggle');
        }

        function addVehicleCheckup(vehicle_id, vehicle_manufacturer, vehicle_model, manufacturer_date, plate, SNno) {
            var selectedVehicle = vehicle_manufacturer+','+vehicle_model+'('+manufacturer_date+'), '+plate;
            $('#selectedVehicle').val(selectedVehicle)
            $('#vehicle_id').val(vehicle_id)
            $('#serialNumber').val(SNno)
            $('#CreateCheckupModal').modal('toggle');
        }


        function editAccessories(index){
            $('#VehicleExtraDataModal').modal('hide');
            sendPostRequest(index);
            $('#vehicleId').val(index);
            $('#exampleModal').modal('toggle');
            // alert(index);
        }
        $(document).ready(function () {
            fill_datatable();
            function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_cityId = '', filter_status = '', filter_delegation = '', filter_vehicle_opreaterId = '', filter_vehicle_manufecturerId = '', filter_modelId = '', filter_otometer = '', filter_otometer_val = '') {
                $('#pre_loader').show();
                var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "All"]],
                    processing: true,
                    serverSide: true,
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
                    // paging: false,
                    // pageLength: 10,
                    order: [1, 'asc'],
                    ajax: {
                        url: "{{ route('Vehicles/Search') }}",
                        data: {
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_cityId: filter_cityId,
                            filter_status: filter_status,
                            filter_delegation: filter_delegation,
                            filter_vehicle_opreaterId: filter_vehicle_opreaterId,
                            filter_vehicle_manufecturerId: filter_vehicle_manufecturerId,
                            filter_modelId: filter_modelId,
                            filter_otometer: filter_otometer,
                            filter_otometer_value: filter_otometer_val,
                        }
                    },
                    columns: [
                        { data: 'no', name: 'vehicle_id', orderable: false },
                        {
                            data: 'plate',
                            name: 'plate',
                            "render": function (data, type, row, meta) {
                                let numbersPart = row.plate.match(/\d+/g).join('');
                                let remainingPart = row.plate.replace(numbersPart, '').trim();
                                return `<table><tr><td style='border: 1px solid;'>`+numbersPart+`</td><td style='border: 1px solid;'>`+remainingPart+`</td></tr></table>`;
                            }
                        },
                        { data: 'name_en', name: 'name_en' },
                        { data: 'vehicle_manufacturer', name: 'vehicle_manufacturer' },
                        { data: 'vehicle_model', name: 'vehicle_model' },
                        { data: 'vehicle_opreator', name: 'vehicle_opreator' },
                        { data: 'color', name: 'color' },
                        { data: 'otometer', name: 'otometer' },
                        { data: 'registertion_type', name: 'registertion_type' },
                        { data: 'current_status', name: 'current_status' },
                        { data: 'delegation_status', name: 'delegation_status' },
                        { data: 'response1', name: 'response1', orderable: false },
                        { data: 'response2', name: 'response2', orderable: false },

                    ],
                });
                $('#pre_loader').hide();
            }
            $('#filter').click(function () {
                var filter_companyId = filter_warehouseId = filter_cityId = filter_status = filter_delegation = filter_vehicle_opreaterId = filter_vehicle_manufecturerId = filter_modelId = filter_otometer = filter_otometer_val = '';
                filter_companyId = $('#filter_companyId').val();
                filter_warehouseId = $('#filter_warehouseId').val();
                filter_cityId = $('#filter_cityId').val();
                filter_status = $('#filter_status').val();
                filter_delegation = $('#filter_delegation').val();
                filter_vehicle_opreaterId = $('#filter_vehicle_opreaterId').val();
                filter_vehicle_manufecturerId = $('#filter_vehicle_manufecturerId').val();
                filter_modelId = $('#filter_modelId').val();
                filter_otometer = $('#filter_otometer').val();
                filter_otometer_val = $('#filter_otometer_val').val();
                $('#customer_data').DataTable().destroy();
                if(filter_companyId > 0)
                    $('#reminder').show();
                else
                    $('#reminder').hide();
                fill_datatable(filter_companyId, filter_warehouseId, filter_cityId, filter_status, filter_delegation, filter_vehicle_opreaterId, filter_vehicle_manufecturerId, filter_modelId, filter_otometer, filter_otometer_val)


            });

        });

        function sendPostRequest(index){
            $.ajax({
                type: 'post',
                url: "{{URL('/vehicles/utilities')}}",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data:{"_token": "{{ csrf_token() }}",'vehcile_id': index},
                success: function (data) {
                    $('#utilities_div').html(data);
                    // $('#ac_condition').val(data[0].utlity_condition);
                    // $('#radio_condition').val(data[1].utlity_condition);
                    // $('#interioirScreen_condition').val(data[2].utlity_condition);
                    // $('#speedoMeter_condition').val(data[3].utlity_condition);
                    // $('#interioirUpholstery_condition').val(data[4].utlity_condition);
                    // $('#spareTireEquipment_condition').val(data[5].utlity_condition);
                    // $('#wheels_condition').val(data[6].utlity_condition);
                    // $('#spareWheel_condition').val(data[7].utlity_condition);
                    // $('#fistAidKit_condition').val(data[8].utlity_condition);
                    // $('#key_condition').val(data[9].utlity_condition);
                    // $('#fistExtinguisher_condition').val(data[10].utlity_condition);
                    // $('#availabilityofTriangle_condition').val(data[11].utlity_condition);

                }
            });
        }
        function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }

        function reset_records() {
            $('#filter_companyId').val('');
            $('#filter_warehouseId').val('');
            $('#filter_modelId').html(sOption);

            $('#filter_companyId').val('');
            $('#filter_warehouseId').empty();
            $('#filter_cityId').val('');
            $('#filter_status').val('');
            $('#filter_delegation').val('');
            $('#filter_vehicle_opreaterId').val('');
            $('#filter_vehicle_manufecturerId').val('');
            $('#filter_modelId').val('');
            $('#filter_operatorId').val('');
            $('#filter_otometer').val('');
            $('#filter_otometer_val').val('');

        }
        function change_rent_type_text(value) {
            if(value == '0') {
                $('.individual_div').show();
                $('.company_div').hide();
                $('#rent_company_id').val('');
            } else if(value == '1') {
                $('.individual_div').hide();
                $('.company_div').show();
                $('#rent_individual').val('');
            }
        }
        function show_rent(value) {
            if(value == '5') {
                $('.rent_div').show();
            } else {
                $('.rent_div').hide();
                $("input[name='rent_type'][value='0']").prop('checked', false);
                $("input[name='rent_type'][value='1']").prop('checked', false);
                // $('#rent_type').val('');
                $('#rent_individual').val('');
                $('#rent_company_id').val('');

            }
        }
    </script>
    @stop
@endsection

