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
                                            <select name="filter_companyId[]" id="filter_companyId" onchange="WarehouseName()" class="form-control" required>
                                                <option value="">Select Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.WarehouseName')}} </label>
                                            <select id="filter_warehouseId" name="filter_warehouseId[]" class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Vehicle Manufecturer </label>
                                            <select name="filter_vehicle_manufecturerId[]" id="filter_vehicle_manufecturerId"
                                                    class="form-control" style="width:200px;" onchange="loadModels()" required>
                                                <option value="">Select Manufecturer</option>
                                                @foreach($manufacturers as $manufacturer)
                                                    <option value="{{$manufacturer->id}}">{{$manufacturer->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Vehicle Model </label>
                                            @php $options = ""; @endphp
                                            <select name="filter_modelId[]" id="filter_modelId"
                                                    class="form-control" style="width:200px;" required>
                                                <option value="">Select Model</option>
                                                @foreach($models as $model)
                                                    <option value="{{$model->id}}">{{$model->name_en}} {{$model->manufacturer_date}}</option>
                                                    @php
                                                    $options .= '<option value="'.$model->id.'">'.$model->name_en . $model->manufacturer_date . '</option>';
                                                    @endphp
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">City </label>
                                            <select name="filter_cityId" id="filter_cityId"
                                                    class="form-control" required>
                                                <option value="">Select City</option>
                                                @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Delegation Status </label>
                                            <select id="delegation_status" name="delegation_status" class="form-control" >
                                                <option value="">Select Status</option>
                                                <option value="valid">Valid</option>
                                                <option value="expired">Expired</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Vehicle Operator </label>
                                            <select name="filter_vehicle_opreaterId" id="filter_vehicle_opreaterId"
                                                    class="form-control" required>
                                                <option value="">Select Vehicle Operator</option>
                                                @foreach($operators as $operator)
                                                <option value="{{$operator->id}}">{{$operator->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Vehicle Otometer </label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <select class="custom-select" id="filter_otometer" name="filter_otometer">
                                                    <option value="">Select Otometer</option>
                                                    <option value="=">=</option>
                                                    <option value=">">></option>
                                                    <option value="<"><</option>
                                                </select>
                                                </div>
                                                <input type="text" class="form-control" name="filter_otometer_val" id="filter_otometer_val">
                                            </div>



                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-sm-12 col-12">
                                        <div class="mb-3">
                                            <span id="reminder" style="color: red; display: none">The following vehicles are delegated vehicles because you have selected the company</span>
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
                <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal" onclick="reset_records()">{{__('drivers.Reset')}}</button>
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
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
          <button type="button" style="margin-bottom: 16px;"  class="close" data-bs-dismiss="modal" aria-label="Close">
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
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
<div class="modal fade" id="images_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Delegation Drivers Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="margin-left: 20px; width:100%;clear:both;" id="imgData">
                    <div class="row">
                        <div class="col-lg-6">
                            <h6>Vehicle Images</h6>
                        </div>
                    </div>
                    <div id="imgTable"></div>
                    <table style="width: 95%;  margin: 0 auto;" id="" class="table table-image" >
                        <thead>
                            <th>
                                Desc
                            </th>
                            <th>
                                Image
                            </th>
                            <th>
                                Desc
                            </th>
                            <th>
                                Image
                            </th>
                        </thead>
                        <tbody id="imgTbody" style="text-align: center">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
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
    @include('new_porttal.partials.edit_btn')
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
                                    <button type="button" class="btn btn-sm btn-info" onclick="sync()"><i class="bi bi-arrow-repeat"></i> Sync</button>
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
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
                                        <th rowspan="2" style="vertical-align: middle;">#</th>
                                        <th rowspan="2" style="vertical-align: middle;">PlateNumber</th>
                                        <th rowspan="2" style="vertical-align: middle;">Reference</th>
                                        <th rowspan="2" style="vertical-align: middle;">Tamm Ref</th>
                                        <th rowspan="2" style="vertical-align: middle;">City</th>
                                        <th rowspan="2" style="vertical-align: middle;">Warehouse</th>
                                        <th rowspan="2" style="vertical-align: middle;">Driver</th>
                                        <th rowspan="2" style="vertical-align: middle;">ID/Iqama</th>
                                        <th rowspan="2" style="vertical-align: middle;">Tamm Iqama</th>
                                        <th rowspan="2" style="vertical-align: middle;">Mobile</th>
                                        <th rowspan="2" style="vertical-align: middle;">Start Date</th>
                                        <th rowspan="2" style="vertical-align: middle;">Expiry Date</th>
                                        <th rowspan="2" style="vertical-align: middle;">Remaining Days</th>
                                        <th rowspan="2" style="vertical-align: middle;">Status</th>
                                        <th colspan="2" style="vertical-align: middle; text-align: center">CheckUp</th>
                                        <th rowspan="2" style="vertical-align: middle;">Action</th>
                                    </tr>
                                    <tr>
                                        <th>CheckUp start</th>
                                        <th style="border-right: 1px solid white;">CheckUp finish</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;">#</th>
                                        <th rowspan="2" style="vertical-align: middle;">PlateNumber</th>
                                        <th rowspan="2" style="vertical-align: middle;">Reference</th>
                                        <th rowspan="2" style="vertical-align: middle;">Tamm Ref</th>
                                        <th rowspan="2" style="vertical-align: middle;">City</th>
                                        <th rowspan="2" style="vertical-align: middle;">Warehouse</th>
                                        <th rowspan="2" style="vertical-align: middle;">Driver</th>
                                        <th rowspan="2" style="vertical-align: middle;">ID/Iqama</th>
                                        <th rowspan="2" style="vertical-align: middle;">Tamm Iqama</th>
                                        <th rowspan="2" style="vertical-align: middle;">Mobile</th>
                                        <th rowspan="2" style="vertical-align: middle;">Start Date</th>
                                        <th rowspan="2" style="vertical-align: middle;">Expiry Date</th>
                                        <th rowspan="2" style="vertical-align: middle;">Remaining Days</th>
                                        <th rowspan="2" style="vertical-align: middle;">Status</th>
                                        <th>CheckUp start</th>
                                        <th >CheckUp finish</th>
                                        <th rowspan="2" style="vertical-align: middle;">Action</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="border-right: 1px solid white; text-align: center">CheckUp</th>
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
            let sOption = `@php echo $options @endphp`;
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
            function imageModal(the) {
                console.log(the.src);
                $('#edit_modal').modal('show');
                let html = `<img style="width: inherit;" src="`+the.src+`">`;
                document.getElementById('response').innerHTML = html;
            }
            function sync() {
                $('#edit_modal').modal('show');
                let html = `<div style="padding-left: 10px;" class="row">
                    <div class="col-lg-6">
                        <h6>Sync Data</h6>
                    </div>
                </div>
                <form id="contact_form" method="POST" action="{{url('automation/upload')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="READ" value="vehicles">
                    <div class="row" style="padding-left: 10px;">
                        <div class="col-lg-8">
                            <b>Excel File</b>
                            <input type="file" class="form-control" name="select_file" accept=".xls, .xlsx" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
                `;
                 document.getElementById('response').innerHTML = html;
            }
            function WarehouseName() {
                var filter_companyId = document.getElementById('filter_companyId').value;
                $('#filter_warehouseId').empty();
                $.getJSON("/getWarehouseName" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }

            function daysUntil(dateString) {
                const futureDate = new Date(dateString);
                const currentDate = new Date();
                const timeDifference = futureDate - currentDate;
                const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
                return daysDifference;
            }
            function openImagesModal(id) {
                $('#images_modal').modal('show');
                $('.table-image').hide();
                $.ajax({
                    type: 'POST',
                    url: "{{url('Vehicles/getImages')}}",
                    cache: false,
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('.table-image').show();
                        document.getElementById('imgTable').innerHTML = '';
                        document.getElementById('imgTbody').innerHTML = data;
                    }
                });
            }
            function vehicleHistory(vehicle_id) {
                $('#edit_modal').modal('show');
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
            function updateDelegation(id, reference_no, iqama, start_date, end_date) {
                $('#edit_modal').modal('show');
                let html = `
                    <form method="POST" action="{{url('Vehicles/updateDelegation')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>Edit Delegation</h6>
                            </div>
                        </div>
                            <input type="hidden" name="id" value="`+id+`">
                            <div class="row">
                                <div class="col-lg-6">
                                    <b>Ref. No</b>
                                    <input type="number" class="form-control" style="width:200px;" name="ref_no" value="`+reference_no+`" placeholder="" required>
                                </div>
                                <div class="col-lg-6">
                                    <b>Iqama</b>
                                    <input type="number" class="form-control" style="width:200px;" name="iqama" value="`+iqama+`" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <b>Start Date</b>
                                    <input type="date" class="form-control" style="width:200px;" name="start_date" value="`+start_date+`" required>
                                </div>
                                <div class="col-lg-6">
                                    <b>End Date</b>
                                    <input type="date" class="form-control" style="width:200px;" name="end_date" value="`+end_date+`" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>`;
                document.getElementById('response').innerHTML = html;
                // var result = confirm("Are you sure you want to update this delegation?");
                // if (result) {
                //     $.ajax({
                //         type: 'POST',
                //         url: "{{url('Vehicles/updateDelegation')}}",
                //         cache: false,
                //         data: {
                //             id: id,
                //             _token: "{{ csrf_token() }}"
                //         },
                //         success: function (data) {
                //             if (data == 'good') {
                //                 alert('Delegation updated successfully.');
                //                 location.reload();
                //             } else {
                //                 alert('Something went wrong, Please try again.');
                //             }
                //         }
                //     });
                // }
            }
            $(document).ready(function () {
                fill_datatable();
                function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_cityId = '', filter_status = '', delegation_status = '', filter_vehicle_opreaterId = '', filter_vehicle_manufecturerId = '', filter_modelId = '', filter_otometer = '', filter_otometer_val = '') {
                    var counter = 0;
                    var dataTable = $('#customer_data').DataTable({
                        lengthMenu: [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "All"]],
                        processing: true,
                        serverSide: true,
                        // paging: false,
                        // pageLength: 10,
                        order: [1, 'asc'],
                        ajax: {
                            url: "{{ route('delegatedVehicles') }}",
                            data: {
                                filter_companyId: filter_companyId,
                                filter_warehouseId: filter_warehouseId,
                                filter_cityId: filter_cityId,
                                filter_status: filter_status,
                                delegation_status: delegation_status,
                                filter_vehicle_opreaterId: filter_vehicle_opreaterId,
                                filter_vehicle_manufecturerId: filter_vehicle_manufecturerId,
                                filter_modelId: filter_modelId,
                                filter_otometer: filter_otometer,
                                filter_otometer_value: filter_otometer_val,
                            }
                        },
                        columns: [
                            {
                                // orderable: false,
                                name: 'delegations.id',
                                data: 'no',
                            },
                            {
                                name: 'vehicles.plate',
                                data: 'plate',
                                "render": function (data, type, row, meta) {
                                    let numbersPart = row.plate.match(/\d+/g).join('');
                                    let remainingPart = row.plate.replace(numbersPart, '').trim();
                                    return `<table><tr><td style='border: 1px solid;'>`+numbersPart+`</td><td style='border: 1px solid;'>`+remainingPart+`</td></tr></table>`;
                                }
                            },
                            {
                                data: 'reference_no',
                                name: 'reference_no',
                                "render": function (data, type, row, meta) {
                                    if (row.tm_reference_no == '') {
                                        return '<span style = "color: blue">'+row.reference_no+'</span>';
                                    } else if (row.reference_no != row.tm_reference_no) {
                                        return '<span style = "color: red">'+row.reference_no+'</span>';
                                    } else {
                                        return row.reference_no;
                                    }
                                }
                            },
                            {
                                orderable: false,
                                data: 'reference_no',
                                name: 'reference_no',
                                "render": function (data, type, row, meta) {
                                    if (row.tm_reference_no == '') {
                                        return '';
                                    } else if (row.reference_no != row.tm_reference_no) {
                                        return '<span style = "color: red">'+row.tm_reference_no+'</span>';
                                    } else {
                                        return row.tm_reference_no;
                                    }
                                }
                            },
                            {
                                data: 'name_en',
                                name: 'lkp_city.name_en'
                            },
                            {
                                data: 'warehouseName',
                                name: 'warehouse.warehouseName'
                            },
                            {
                                data: 'fullName',
                                name: 'drivers.fullName'
                            },
                            {
                                data: 'iqama',
                                name: 'drivers.iqama',
                                "render": function (data, type, row, meta) {
                                    if (row.tm_iqama == '') {
                                        return '<span style = "color: blue">'+row.iqama+'</span>';
                                    } else if (row.iqama != row.tm_iqama) {
                                        return '<span style = "color: red">'+row.iqama+'</span>';
                                    } else {
                                        return row.iqama;
                                    }
                                }
                            },
                            {
                                orderable: false,
                                data: 'iqama',
                                name: 'iqama',
                                "render": function (data, type, row, meta) {
                                    if (row.tm_iqama == '') {
                                        return '';
                                    } else if (row.iqama != row.tm_iqama) {
                                        return '<span style = "color: red">'+row.tm_iqama+'</span>';
                                    } else {
                                        return row.tm_iqama;
                                    }
                                }
                            },

                            {
                                data: 'mobileNumber',
                                name: 'drivers.mobileNumber'
                            },
                            {
                                data: 'starting_date',
                                name: 'starting_date'
                            },
                            {
                                data: 'ending_date',
                                name: 'ending_date'
                            },
                            {
                                name: 'ending_date',
                                data: 'ending_date',
                                "render": function (data, type, row, meta) {
                                    return '<center style="color: red">' + daysUntil(row.ending_date) + ' Days</center>';
                                }
                            },
                            {
                                orderable: false,
                                name: 'ending_date',
                                data: 'ending_date',
                                "render": function (data, type, row, meta) {
                                    let today = new Date().toISOString().slice(0, 10);
                                    if (row.status == 'valid' && today <= row.ending_date) {
                                        return delegation_status = '<span class="badge badge-success">Valid</span>';
                                    } else if (row.status == 'valid' && today > row.ending_date) {
                                        return delegation_status = '<span class="badge badge-warning">Valid Expired</span>';
                                    } else if (row.status == 'cancelled') {
                                        return delegation_status = '<span class="badge badge-danger">Cancelled</span>';
                                    } else if (row.status == 'completed') {
                                        return delegation_status = '<span class="badge badge-success">Completed</span>';
                                    } else if (row.status == 'completedAfterExpiry') {
                                        return delegation_status = '<span class="badge badge-info">Completed After Expiry</span>';
                                    } else {
                                        return '';
                                    }
                                }
                            },
                            {
                                orderable: false,
                                name: 'delegations.id',
                                data: 'id',
                                "render": function (data, type, row, meta) {
                                    return '<button onclick="openImagesModal('+row.checkup_id+')" class="btn btn-primary"><i class="bi bi-eye"></i>View</button>'
                                }
                            },
                            {
                                orderable: false,
                                name: 'delegations.id',
                                data: 'id',
                                "render": function (data, type, row, meta) {
                                    return '<button onclick="openImagesModal('+row.returning_checkup_id+')" class="btn btn-primary"><i class="bi bi-eye"></i>View</button>'
                                }
                            },
                            {
                                orderable: false,
                                data: 'id',
                                name: 'delegations.id',
                                "render": function (data, type, row, meta) {
                                    let btn = '';
                                    // if (row.reference_no != row.tm_reference_no && row.tm_reference_no != '') {
                                        btn = `<a onclick="updateDelegation(${row.id}, ${row.reference_no}, ${row.iqama}, '${row.starting_date}', '${row.ending_date}')" title="Update Delegation" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"><i class="bi bi-pencil"></i></a>`;
                                    // }
                                    return btn + '<a onclick="vehicleHistory('+row.vehicle_id+')" title="Delegation history" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue history"><i class="bi bi-clock-history"></i> </a>';
                                }
                            },
                        ]
                    });
                    let html = '';
                    if ($('#filter_companyId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                    if ($('#filter_warehouseId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                    if ($('#filter_cityId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_cityId option:selected').text()+'</button>';
                    if ($('#delegation_status').val() != '')
                        html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#delegation_status option:selected').text()+'</button>';
                    if ($('#filter_vehicle_opreaterId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_vehicle_opreaterId option:selected').text()+'</button>';
                    if ($('#filter_vehicle_manufecturerId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_vehicle_manufecturerId option:selected').text()+'</button>';
                    if ($('#filter_modelId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_modelId option:selected').text()+'</button>';
                    if(html != '') {
                        $('#edit_btn').show();
                        $('#selectedCriteria').html(html);
                    } else {
                        $('#edit_btn').hide();
                    }
                }
                $('#filter').click(function () {
                    var filter_companyId = filter_warehouseId = filter_cityId = filter_status = delegation_status = filter_vehicle_opreaterId = filter_vehicle_manufecturerId = filter_modelId = filter_otometer = filter_otometer_val = '';
                    filter_companyId = $('#filter_companyId').val();
                    filter_warehouseId = $('#filter_warehouseId').val();
                    filter_cityId = $('#filter_cityId').val();
                    filter_status = $('#filter_status').val();
                    delegation_status = $('#delegation_status').val();
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
                    fill_datatable(filter_companyId, filter_warehouseId, filter_cityId, filter_status, delegation_status, filter_vehicle_opreaterId, filter_vehicle_manufecturerId, filter_modelId, filter_otometer, filter_otometer_val)
                });

            });

            function reset_records() {
                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_cityId').val('');
                $('#filter_status').val('');
                $('#delegation_status').val('');
                $('#filter_vehicle_opreaterId').val('');
                $('#filter_vehicle_manufecturerId').val('');
                $('#filter_modelId').val('');
                $('#filter_operatorId').val('');
                $('#filter_otometer').val('');
                $('#filter_otometer_val').val('');
            }
        </script>
    @stop
@endsection

