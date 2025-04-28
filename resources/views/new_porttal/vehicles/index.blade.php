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
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                @endforeach
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
                                            <label for="country" class="form-label">Vehicle Manufecturer </label>
                                            <select name="filter_vehicle_manufecturerId[]" id="filter_vehicle_manufecturerId" multiple
                                                    class="form-control" style="width:200px;" onchange="loadModels()" required>
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
                                            <select name="filter_modelId[]" id="filter_modelId" multiple
                                                    class="form-control" style="width:200px;" required>
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
                                            <label for="country" class="form-label">Status </label>
                                            <select id="filter_status" name="filter_status" class="form-control" >
                                                <option value="">Select Status</option>
                                                <option value="availabe">Available</option>
                                                <option value="damaged">damaged</option>
                                                <option value="maintenance">Maintenance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Delegation Status </label>
                                            <select id="filter_delegation" name="filter_delegation" class="form-control" >
                                                <option value="">Select Delegation</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Accessories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('New-Portal/vehicles/utilities/update')}}">
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
        <form action="{{url('New-Portal/vehicles/update-vehicle-checkup')}}" method="post"  enctype="multipart/form-data" >
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
<style>
    .carousel-inner {
        width: 100%;
    }
    .carousel-item {
        text-align: center;
    }
    .circle {
        width: 21px;
        height: 20px;
        border-radius: 50%;
        background-color: red;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .vehicle-model-column {
        width: 150px;
        max-width: 150px;
        min-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<!-- Vehicle extra data Modal -->
<div class="modal fade" id="VehicleExtraDataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                      <ul class="navbar-nav">
                        <li class="nav-item">
                          <a class="nav-link" onclick="openCity('London')" href="#">Vehicle information</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" onclick="openCity('Tokyo')" href="#">Summery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="openCity('Lahore')" href="#">Attachments</a>
                        </li>

                      </ul>
                    </div>
                </nav>
                <div id="London" class="city">
                    <div class="Carousel_Example">
                        <div class="col-12">
                            <h4>Vehicle Images <span class="vehiclePlate"></span></h4>
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                    <li data-target="#myCarousel" data-slide-to="3"></li>
                                    <li data-target="#myCarousel" data-slide-to="4"></li>
                                </ol>

                                <!-- Slides -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a href="#"><img onclick="imageModal(this)" src="{{asset("/images/vehicleSides/Image4.png")}}" style="width: 730px; height: 400px; object-fit: cover;" id="front_image">
                                            <div class="carousel-caption d-none d-md-block">
                                                <span class="circle circleText" style="position: absolute;top: -235px;left: -90px;"></span>
                                                <h3>Front side Image</h3>
                                                <p class="vehiclePlate"></p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="carousel-item">
                                        <a href="#"><img onclick="imageModal(this)" src="{{asset("/images/vehicleSides/Image6.png")}}" id="drivingWheel_image" style="width: 730px; height: 400px; object-fit: cover;">
                                            <div class="carousel-caption d-none d-md-block">
                                                <span class="circle circleText" style="position: absolute;top: -235px;left: -90px;"></span>
                                                <h3>Interior Image</h3>
                                                <p class="vehiclePlate"></p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="carousel-item">
                                        <a href="#"><img onclick="imageModal(this)" src="{{asset("images/no_imag.jpg")}}" style="width: 730px; height: 400px; object-fit: cover;" alt="LastCheckup_FrontImage" id="left_image">
                                            <div class="carousel-caption d-none d-md-block">
                                                <span class="circle circleText" style="position: absolute;top: -235px;left: -90px;"></span>
                                                <h3>Left side Image</h3>
                                                <p class="vehiclePlate"></p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="carousel-item">
                                        <a href="#"><img onclick="imageModal(this)" src="{{asset("images/no_imag.jpg")}}" style="width: 730px; height: 400px; object-fit: cover;" alt="LastCheckup_FrontImage" id="right_image">
                                            <div class="carousel-caption d-none d-md-block">
                                                <span class="circle circleText" style="position: absolute;top: -235px;left: -90px;"></span>
                                                <h3>Right side Image</h3>
                                                <p class="vehiclePlate"></p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="carousel-item">
                                        <a href="#"><img onclick="imageModal(this)" src="{{asset("/images/vehicleSides/Image5.png")}}" id="rear_image" style="width: 730px; height: 400px; object-fit: cover;" alt="LastCheckup_LeftImage">
                                            <div class="carousel-caption d-none d-md-block">
                                                <span class="circle circleText" style="position: absolute;top: -235px;left: -90px;"></span>
                                                <h3>Rear side Image</h3>
                                                <p class="vehiclePlate"></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <!-- Controls -->
                                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>

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
                <div id="Lahore" class="city" style="display:none">
                    <style>
                        .attachment-card {
                            position: relative;
                            border: 1px solid #ddd;
                            border-radius: 8px;
                            padding: 10px;
                            text-align: center;
                            display: grid;
                            margin-top: 5px;
                        }
                        .attachment-card img, embed {
                            max-width: 100%;
                            height: 100px;
                            object-fit: cover;
                            border-radius: 4px;
                        }
                    </style>
                    <div class="row" >
                        <div id="others" class="d-flex flex-wrap">
                            <div class="col-md-4" style="display:none;">
                                <div class="attachment-card" style="height: 135px;">
                                    <form method="POST" id="others_form" action="{{ url('New-Portal/Vehicles/registration')}}" enctype='multipart/form-data' onsubmit="return validateOthersForm()">
                                        @csrf
                                        <input type="file" accept=".jpg,.jpeg,.png,.pdf" name="others[]" id="click_on_submit_dropify" data-height="90" data-width="50" required>
                                        <input type="hidden" name="plate" class="plateCard" value="" required>
                                        <input type="submit" style="padding: 5px" class="btn btn-primary" value="Save" id="save_btn_dropify">
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4" onclick="click_on_submit_btn()" style="cursor: pointer">
                                <div class="attachment-card" style="height: 135px;">
                                    <center>
                                        <img id="previewImage" src="" alt="Pdf file uploaded" style="width:100px; height:auto;">
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <button type="button" class="btn btn-primary" onclick="click_on_save_btn_dropify()" id="submitBtn"></button>

              </div>
        </div>
    </div>
</div>

<!-- Vehicle extra data Modal -->

<div class="modal fade" id="report_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicles Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('New-Portal/Vehicles/download_vehicles_report')}}">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="date" class="form-label">Date:</label>
                            <input type="date" name="date" id="date" class="form-control"
                                   value='{{date("Y-m-d")}}' required max="{{date("Y-m-d")}}">
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type:</label>
                            <select id="type" name="type" required class="form-select">
                                <option value="">Select type</option>
                                <option value="" selected>All</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="button" class="btn btn-primary" onclick="downloadReport()">Show</button>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-success">Download</button>
                        </div>
                    </div>
                </form>
                <table id="" class="table table-bordered mt-3">
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
<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
        </div>
    </div>
</div>
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
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
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
                                    <a class="btn btn-sm btn-info " onclick="downloadReport()" style="color: white"><i class="bi bi-download"></i>Download Report</a>
                                    <a href="#" class="btn btn-sm btn-info" onclick="forceAssign()"> <i class="bi bi-paperclip"></i> Force Assign</a>
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
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
                                        <TH>#</TH>
                                        <TH >Plate</TH>
                                        <TH >City</TH>
                                        <th >Manufacturer </th>
                                        <th >Vehicle model </th>
                                        <th >Opreater company  </th>
                                        <th >Color </th>
                                        <th >Otometer </th>
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
            $(document).ready(function () {
                $('#myCarousel').carousel({
                    interval: 2000,
                    pause: false  // keep sliding even if mouse hovers
                });

                // Optional: handle manual click for next/prev
                $(".carousel-control-prev").click(function () {
                    $('#myCarousel').carousel('prev');
                });

                $(".carousel-control-next").click(function () {
                    $('#myCarousel').carousel('next');
                });
                fill_datatable();
                function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_cityId = '', filter_status = '', filter_delegation = '', filter_vehicle_opreaterId = '', filter_vehicle_manufecturerId = '', filter_modelId = '', filter_otometer = '', filter_otometer_val = '') {
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
                            url: "{{ route('New-Portal/Vehicles/Search') }}",
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
                                    return `<table style="width: max-content;"><tr><td style='border: 1px solid;'>`+numbersPart+`</td><td style='border: 1px solid;'>`+remainingPart+`</td></tr></table>`;
                                }
                            },
                            // { data: 'vehicle_expiry_date', name: 'vehicle_expiry_date' },
                            { data: 'name_en', name: 'name_en' },
                            { data: 'vehicle_manufacturer', name: 'vehicle_manufacturer' },
                            { data: 'vehicle_model', name: 'vehicle_model', className: 'vehicle-model-column' },
                            { data: 'vehicle_opreator', name: 'vehicle_opreator', className: 'vehicle-model-column' },
                            { data: 'color', name: 'color' },
                            // { data: 'vehicle_registration_expire_date', name: 'vehicle_registration_expire_date' },
                            // { data: 'vehicle_utilities_html', name: 'vehicle_utilities_html', orderable: false },
                            { data: 'otometer', name: 'otometer' },
                            { data: 'registertion_type', name: 'registertion_type', className: 'vehicle-model-column' },
                            { data: 'current_status', name: 'current_status', className: 'vehicle-model-column' },
                            { data: 'delegation_status', name: 'delegation_status', className: 'vehicle-model-column' },

                            { data: 'response1', name: 'response1', orderable: false },
                            { data: 'response2', name: 'response2', orderable: false },

                        ],
                        columnDefs: [
                            {
                                targets: 4,
                                width: '300px'
                            }
                        ],
                    });
                    let html = '';
                    if ($('#filter_companyId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                    if ($('#filter_warehouseId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                    if ($('#filter_cityId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_cityId option:selected').text()+'</button>';
                    if ($('#filter_status').val() != '')
                        html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_status option:selected').text()+'</button>';
                    if ($('#filter_delegation').val() != '')
                        html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_delegation option:selected').text()+'</button>';
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
            function updateVehicleDriver(vehicle_id, delegation_id) {
                $('#edit_modal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: "{{url('New-Portal/Vehicles/updateVehicleDriver')}}" + "/" + vehicle_id + "/" + delegation_id,
                    cache: false,
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                        $('#job_id').select2({
                            dropdownParent: $('#edit_modal')
                        });
                    }
                });
            }
            function imageModal(the) {
                $('#edit_modal').modal('show');
                let html = `<img style="width: -webkit-fill-available;" src="`+the.src+`">`;
                document.getElementById('response').innerHTML = html;
            }
            function downloadReport() {
                let date = $('#date').val();
                let type = $('#type').val();
                $('#report_modal').modal('show');
                document.getElementById('report_body').innerHTML = '';
                $.ajax({
                    type: 'POST',
                    url: "{{url('New-Portal/Vehicles/VehicleReport')}}",
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
            function forceAssign(vehicle_id) {
                $('#edit_modal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: "{{url('New-Portal/Vehicles/forceAssign')}}",
                    cache: false,
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                        $('#job_id').select2({
                            dropdownParent: $('#edit_modal')
                        });
                    }
                });
            }
            function deleteVehicleAssignment(id) {
                var result = confirm("Are you sure to remove this assignment?");
                if (result) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('New-Portal/Vehicles/deleteVehicleAssignment') }}/" + id,
                        cache: false,
                        success: function (data) {
                            if (data == 'good')
                                alert("Assignment Deleted successfully.")
                            else
                                alert("Something Went wrong.")

                            $('#edit_modal').modal('hide');
                        }
                    });
                }
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
            function vehicleEdit(vehicle_id) {
                $('#edit_modal').modal('show');
                $.ajax({
                    type: 'POST',
                    url: "{{url('New-Portal/Vehicles/EditVehicle')}}",
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
                $.ajax({
                   url: "{{url('New-Portal/Vehicles/UpdateVehicle')}}",
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
                $.ajax({
                    type: 'POST',
                    url: "{{url('New-Portal/Vehicles/historyVehicle')}}",
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
                    url: "{{url('New-Portal/Vehicles/historyVehicleDrivers')}}",
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
                $('.plateCard').val(plate);
                loadImages();

                if(images != '') {
                    let img_arr = images.split(":::");
                    $('#left_image').attr("src", "/" + img_arr[0]);
                    $('#right_image').attr("src", "/" + img_arr[1]);
                    $('#rear_image').attr("src", "/" + img_arr[2]);
                    $('#front_image').attr("src", "/" + img_arr[3]);
                    $('#drivingWheel_image').attr("src", "/" + img_arr[4]);
                } else {
                    $('#left_image').attr("src", '/images/no_imag.jpg');
                    $('#right_image').attr("src", '/images/no_imag.jpg');
                    $('#rear_image').attr("src", '/images/no_imag.jpg');
                    $('#front_image').attr("src",'/images/no_imag.jpg');
                    $('#drivingWheel_image').attr("src", '/images/no_imag.jpg');
                }

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
            function deleteImage(plate, fileName) {
                var result = confirm("Are you sure to remove this file?");
                if (result) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('New-Portal/Vehicles/deleteVehicleFile') }}",
                        data: {
                            plate: plate,
                            fileName: fileName,
                            _token: "{{ csrf_token() }}"
                        },
                        cache: false,
                        success: function (data) {
                            alert(data);
                            loadImages();
                        }
                    });
                }
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

            function sendPostRequest(index){
                $.ajax({
                    type: 'post',
                    url: "{{URL('New-Portal/vehicles/utilities')}}",
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
            function click_on_submit_btn() {
                document.getElementById('click_on_submit_dropify').click();
            }
            function click_on_save_btn_dropify() {
                document.getElementById('save_btn_dropify').click();
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
        function validateOthersForm () {
            $('#submitBtn').html("Saving...");
            var form = document.getElementById('others_form');
            var formData = new FormData(form);
            var formURL = $("#others_form").attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    alert(data);
                    $('#submitBtn').hide();
                    const previewImage = document.getElementById("previewImage");
                    previewImage.src = "https://cdn.pixabay.com/photo/2016/01/03/00/43/upload-1118929_1280.png";
                    loadImages();
                },
                error: function (jqXHR, status, error) {
                    document.getElementById('response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
                    alert(status + ": " + error);
                }
            });
            return false;
        }
        function loadImages() {
            let plate = $('.plateCard').val();
            $('.vehiclePlate').html(plate);
            $('#submitBtn').hide();
            const previewImage = document.getElementById("previewImage");
            previewImage.src = "https://cdn.pixabay.com/photo/2016/01/03/00/43/upload-1118929_1280.png";
            $.ajax({
                type: 'POST',
                url: "{{url('New-Portal/Vehicles/vehicleInfo')}}",
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

                    $('.remDiv').remove();
                    $('#others').prepend(arr[5] === '0' ? '' : arr[5]);

                    const statusMap = {
                        valid: { text: "Valid", color: "green" },
                        maintenance: { text: "Maintenance", color: "yellow" },
                        available: { text: "Available", color: "blue" },
                        damaged: { text: "Damaged", color: "red" },
                        expired: { text: "Expired", color: "black" },
                        cancelled: { text: "Cancelled", color: "orange" },
                        completed: { text: "Completed", color: "orange" },
                        CompletedAfterExpiry: { text: "Completed After Expiry", color: "orange" }
                    };
                    const status = arr[6];
                    const { text = "Unknown", color = "gray" } = statusMap[status] || {};
                    $('.circleText').html(text).css('backgroundColor', color);

                    const fileInput = document.getElementById("click_on_submit_dropify");
                    const previewImage = document.getElementById("previewImage");
                    fileInput.addEventListener("change", function () {
                        const file = this.files[0];
                        if (file) {
                          const reader = new FileReader();
                          reader.onload = function (e) {
                            previewImage.src = e.target.result;
                          };
                          reader.readAsDataURL(file);
                          $('#submitBtn').html("Save");
                          $('#submitBtn').show();

                        }
                    });
                }
            });
        }
        </script>
    @stop
@endsection
