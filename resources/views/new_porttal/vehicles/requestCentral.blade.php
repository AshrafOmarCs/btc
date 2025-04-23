@extends('layout2')
@section('content')
@section('title', 'Vehicles')
<style>
    .btn-success {
        background-color: #00a65a;
        border-color: #008d4c;
        width: 203px;
        height: 30px;
        margin-left: 18px;
    }
    #approvingIdentityTble td{
        border: 1px solid #cfcfcf !important;
        padding: 5px !important;
    }

    #front_side,#rear_side,#right_side,#left_side,#intiror_side{
        border-radius: 11px;
        margin-top: 10px;
    }
    .table-image {
      td, th {
        vertical-align: middle;
      }
      .container {
          padding: 2rem 0rem;
        }

        h4 {
          margin: 2rem 0rem 1rem;
        }
    }
    #checkUpTable td{
        text-align: center;
    }
    #priv_intiror_side,#priv_left_side,#priv_right_side,#priv_rear_side,#priv_front_side,#front_side{
        width: 141px;
        margin-top: 13px;
    }
</style>
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
                                            <label for="country" class="form-label">Company Name </label>
                                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                                    class="form-control" required>
                                                <option value=""></option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Warehouse Name </label>
                                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">City</label>
                                            <select name="filter_cityId" id="filter_cityId"
                                                    class="form-control" required>
                                                <option value=""></option>
                                                @foreach($cities as $city)
                                                    <option value="{{$city->city_id}}">{{$city->name_en}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Job ID </label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Status </label>
                                            <select name="filter_status_id" id="filter_status_id" onchange="status()"
                                                class="form-control">
                                            <option value=""></option>
                                            <option value="pending">Pending</option>
                                            <option value="sent">Sent</option>
                                            <option value="utlity_rejected">Utlity Rejected</option>
                                            <option value="image_rejected">Images Rejected</option>
                                            <option value="checkUpIsApproved">checkUpIsApproved</option>
                                            <option value="image_accepted">Images Accepted</option>
                                            <option value="utlity_accepted">Utlity Accepted</option>
                                            <option value="delegation_issued">Delegation Issued</option>
                                            <option value="done">Done</option>
                                            <option value="finished">Finished</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Request Type</label>
                                            <select name="filter_request_id" id="filter_request_id"
                                                    class="form-control">
                                                <option value=""></option>
                                                @foreach($rTypes as $rType)
                                                    <option value="{{$rType->id}}">{{$rType->name_en}}</option>
                                                @endforeach
                                            </select>
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
                <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal" onclick="reset_records()">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
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
$module = "Vehicle";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')
<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Image </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="imgResponse">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ViewDAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Driver </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ViewVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                                <th >Cololr</th>
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
                                <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img onclick="imageModal(this)" src="https://btcdmins.com/images/no_imag.jpg" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" id="left_image" srcset=""> </a></td>
                                <!--<td><span style="color:#dd4b39" id="left_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Right side Images</th>
                                <td colspan="3" style="text-align: center;"><a id="right_image_a" onclick="imageModal(this)" href="#"><img src="https://btcdmins.com/images/vehicleSides/Image3.png" id="right_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="right_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Front side Images</th>
                                <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img onclick="imageModal(this)" src="https://btcdmins.com/images/vehicleSides/Image4.png"  id="front_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_RearImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="front_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Rear side Images</th>
                                <td colspan="3" style="text-align: center;"><a id="rear_image_a" href="#"><img onclick="imageModal(this)" src="https://btcdmins.com/images/vehicleSides/Image5.png" id="rear_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_LeftImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="rear_status"> </span></td>-->
                            </tr>
                            <tr>
                                <th >Interior Images</th>
                                <td colspan="3" style="text-align: center;"><a id="drivingWheel_image_a" href="#"><img onclick="imageModal(this)" src="https://btcdmins.com/images/vehicleSides/Image6.png" id="drivingWheel_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_RightImage" srcset=""></td>
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

<!-- Modal -->

<!-- Create Checkup Modal -->
<div class="modal fade" id="DAIdentityApproveModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CreateCheckupModalLabel">Driver Identity Approveal</h5>
          <button type="button" style="margin-bottom: 16px;"  class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <div class="modal-body">
                <table style="width: 95%;  margin: 0 auto;" id="approvingIdentityTble">
                    <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Driver Name:</span > <span id="driver_name">Loading...</span>, <span id="driver_id">Loading...</span></td>
                        <td ><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Status:</span> <button  disabled id="status_text">Loading status</button> <input type="hidden" name="driver_id" id="driver_id"></td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Iqama number:</span > <span id="driver_iqama">Loading...</span> </td>
                        <td ><span style="font-size: 13px; font-family: monospace; font-weight: bold;"> </td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Project:</span > <span id="project_name">Loading...</span></td>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">HUB/Warehouse :</span> <span id="hub_name">Loading...</span></td>
                    </tr>
                     <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Absher Number:</span > <span id="absher_no">Loading...</span> </td>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">DOB :</span> <span id="driver_dob">Loading...</span></td>
                    </tr>
                     <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Email:</span > <span id="email_dob">Loading...</span> </td>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Appling location  :</span> <span id="driver_dob">24.2254, 46.888</span> <button class="btn btn-success" style="height: 33px;  margin-left: 18px;"> Google Map</button></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><img style="width: 120px;" id="identity_file" src="{{asset('images/iqama.png')}}"></td>
                        <td style="text-align: center;"><img style="width: 120px;" id="driving_licence" src="{{asset('images/driving-license.png')}}"></td>
                    </tr>
                    <tr style="font-size: 16px;">
                        <td style="text-align: center;padding: 8px;"><span>Identity image</span></td>
                        <td style="text-align: center;padding: 8px;"><span>Driving image</span></td>
                    </tr>

                     <tr style="font-size: 16px;">
                        <td style="text-align: center;padding: 8px;"><span>Are you sure about confirming driver info</span></td>
                        <td style="text-align: center;padding: 8px;">
                            <input type="radio" name="enable_btn" value="no" checked>NO  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            <input type="radio" name="enable_btn" value="Yes" checked>Yes
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="rejectIdentity()" id="rejectBtn">Reject</button>
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="approveIdentity()" id="approveBtn">Approve</button>
            </div>
        </form>
      </div>
    </div>
</div>
<!-- Create Checkup Modal -->

<!-- Vehicle extra data Modal -->
<div class="modal fade" id="delegationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Issue Delegation Doc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table style="width: 95%;  margin: 0 auto;">
                    <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Driver :</span> <span id="job_id">Loading</span> </td>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Vehicle Plate  :</span>  <span id="plate_no">Loading</span> . </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Starting date:</span >   </td>
                        <td>  <input type="date"> </td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Ending date:</span >   </td>
                        <td>  <input type="date"> </td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Allowed Geographical Area :</span > <input type="text" placeholder="الرياض,جدة,,,الخ">  </td>
                    </tr>
                     <tr>
                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Current Otometer Read</span> : <span style="color:red">106,002</span> K/M </td>
                     </tr>
                     <tr>

                        <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Otometer Read</span> : <span style="color:red">106,202</span> K/M Approved by Ashraf (<span style="cursor: pointer;color: blue; font-size: 15px; font-weight: bold;">Edit</span>)</td>
                     </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="approveIdentity()" id="approveBtn">Proceed</button>
              </div>
        </div>
    </div>
</div>

<!-- Vehicle extra data Modal -->
<div class="modal fade" id="vehicleAccessoryCheckUpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table style="width: 95%;  margin: 0 auto;" id="checkUpTable" class="table table-image">
                    <tr>
                        <td>
                            Accessory description
                        </td>
                         <td>
                            Current Status
                        </td>
                        <td>
                            Proposed Status
                        </td>
                        <td>
                            Rejection count
                        </td>
                        <td>
                            Approval Status
                        </td>

                        <td>
                            Select to reject
                        </td>
                    </tr>
                    <tbody id="accessoriesTable">

                    </tbody>
                    <div >

                    </div>

                </table>
                <label for="exampleFormControlTextarea1" >Rejection reason (<span style="color:grey">Optional</span>)</label>
                <textarea class="form-control" id="rejection_reason"  rows="3"></textarea>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
              <input type="hidden" name="checkUp_id" id="checkUp_id">
              <button type="button" class="btn btn-primary"  id="approveAccessoryBtn" data-bs-dismiss="modal" onclick="vaidateAccessory()">Proceed</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="vehicleCheckUpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleCheckUpModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table style="width: 95%;  margin: 0 auto;" id="checkUpTable" class="table table-image">
                    <tr>
                        <td>
                            Desc
                        </td>
                         <td>
                            Prive Image
                        </td>
                        <td>
                            new image
                        </td>
                        <td>
                            Reject
                        </td>
                    </tr>

                    <tr id="checkUpImages">
                        <td>
                            Front-side
                        </td>
                         <td>
                            <img id="priv_front_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/no_imag.jpg')}}' alt="priv front-side">
                        </td>
                         <td>
                            <img id="front_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="front-side">
                        </td>`

                        <td>
                            <input type="checkbox"  value="front">
                        </td>

                    </tr>

                    <tr>
                        <td>
                            Rear-side
                        </td>
                         <td>
                            <img id="priv_rear_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/no_imag.jpg')}}' alt="priv Rear-side">
                        </td>
                         <td>
                            <img id="rear_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Rear-side">
                        </td>

                        <td>
                            <input type="checkbox" value="rear">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Right-side
                        </td>
                         <td>
                            <img id="priv_right_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/no_imag.jpg')}}' alt="priv Right-side">
                        </td>
                         <td>
                            <img id="right_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Right-side">
                        </td>
                        <td>
                            <input type="checkbox" value="right">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Left-side
                        </td>
                         <td>
                            <img id="priv_left_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/no_imag.jpg')}}' alt="priv Front-side">
                        </td>
                         <td>
                            <img id="left_side" onclick="openViewVehicleModal(this.src)" style="cursor: pointer" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Front-side">
                        </td>
                        <td>
                            <input type="checkbox" value="left">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Intiror-side
                        </td>
                         <td>
                            <img onclick="openViewVehicleModal(this.src)" id="priv_intiror_side" style="cursor: pointer" src='{{asset('images/no_imag.jpg')}}' alt="priv Intiror-side">
                        </td>
                         <td>
                            <img onclick="openViewVehicleModal(this.src)" id="intiror_side" style="cursor: pointer" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Intiror-side">
                        </td>
                       <td>
                            <input type="checkbox" value="interior">
                        </td>
                    </tr>

                    <tr>
                        <td style="margin-top: 14px;">
                            Otometer Read: <span style="color:red">*</span>
                        </td>
                        <td style="margin-top: 14px;">
                            <input type="number" min="0" id="otometer_read" placeholder="Please Enter Otometer Read" ><br>
                        </td>
                        <td style="text-align: center;">
                            Rejection reason: <span style="color:red">*</span><br>
                            <small>If applicable</small>
                        </td>
                        <td>
                            <textarea id="checkupRejectionReason"></textarea>
                        </td>
                        <td>
                            <!--<button>Reject(3)</button>-->
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="margin-top: 17px;" id="refNo">
                           <small style="font-size: 13px;">Reference No: <span style="color:red">*</span></small>
                           <input type="number" id="reference_no" name="reference_no">
                        </td>
                        <td colspan="2" style="margin-top: 17px;">
                           <small style="font-size: 13px;">Vehicle previous otometer: <span style="color: #b50808;" id="oto_reading"></span> </small>
                           <input type="hidden" id="vehicle_id" name="vehicle_id">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="checkUpImageHandler()" id="approveBtn2">Approve</button>
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
                    <div class="card-title">Vehicles Requests</div>
                </div>
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;">From this page you can view Vehicles Requests. </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
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
                                    <TH>#</TH>
                                    <TH >City</TH>
                                    <TH scope="col" style="width: 8%">NumberPlate</TH>
                                    <th scope="col">Vehicle </th>
                                    <th scope="col">Opreater Company</th>
                                    <th scope="col">DA </th>
                                    <th scope="col">DA Approval </th>
                                    <th scope="col">Request type </th>
                                    <th scope="col">Request Date </th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Procedures</th>
                                </thead>
                                <tbody id="tbl_body">
                                    @if(sizeof($payload) > 0)
                                        @foreach($payload as $k=>$item)
                                            <tr>
                                                <td>{{$k+1}}</td>
                                                <td>{{$item->city_name}}</td>
                                                <td>
                                                    @php
                                                    preg_match_all('/\d+/', $item->plate, $matches);
                                                    $numbersPart = implode('', $matches[0]);
                                                    $remainingPart = trim(preg_replace('/\d+/', '', $item->plate));
                                                    @endphp
                                                    <table style="width: max-content;"><tbody><tr><td style="border: 1px solid;">{{$numbersPart}}</td><td style="border: 1px solid;">{{$remainingPart}}</td></tr></tbody></table>
                                                </td>
                                                <td>
                                                    {{$item->color}}, {{$item->vehicle_manufacturer_name}}, {{$item->vName}}, {{$item->manufacturer_date}}
                                                    <span>@php echo $item->vehicleExtraInfo; @endphp</span>
                                                </td>
                                                <td> {{$item->opreatoers}}</td>
                                                <td>{{$item->fullName}},  <span style="color:red">{{$item->job_id}}</span> <span> <button > <a href="javascript:driver('{{$item->driver_id}}')"><i class="bi bi-eye"></i></a></button></span></td>
                                                <td style="text-align: center;">
                                                    @if($item->driver_data == 'pending')
                                                        <button disabled>Waiting DA Confrime Data</button>
                                                    @endif

                                                    @if($item->driver_data == 'applied')
                                                        @if($item->supporvisor_identity_approve == 0)
                                                        <button class="btn btn-light" onclick="setRequestIdAndOpenModal('{{$item->requests_id}}','{{$item->driver_id}}','{{$item->supporvisor_identity_approve}}')">Approve</button>
                                                        @endif
                                                    @endif

                                                    @if($item->driver_data == 'approved')
                                                        <img style="width: 38px; margin: 0 auto;" src="{{url('/images/check.png')}}" alt="driver approved check">
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-warning">
                                                        {{$item->name_en}}
                                                    </span>
                                                </td>
                                                <td> {{ \Carbon\Carbon::parse($item->request_issue_date)->format('j F, Y') }} </td>
                                                <td>
                                                    @if($item->assiment_status == 'Pending')
                                                        {{'Waiting Driver to update data'}}
                                                    @endif
                                                    @if($item->assiment_status == 'sent')
                                                    {{'Please Confirm Checkup data'}}
                                                    @endif

                                                    @if($item->assiment_status == 'utlity_rejected')
                                                    {{'One or more Accessory have been Rejected'}}
                                                    @endif
                                                    @if($item->assiment_status == 'utlity_accepted')
                                                    {{'Please approve Checkup images'}}
                                                    @endif
                                                    @if($item->assiment_status == 'image_rejected' )
                                                        {{'One or more Checkup Image have been Rejected'}}
                                                    @endif
                                                    @if($item->assiment_status == 'image_accepted' )
                                                        {{'Please Fill & confirm Delegation'}}
                                                    @endif
                                                    @if($item->assiment_status == 'Rejected')
                                                    {{'Rejected & Waiting driver to re-upload Vehicle images'}}
                                                    @endif


                                                    @if($item->assiment_status == 'done')
                                                    {{'Done & Waiting to return'}}
                                                    @endif

                                                    @if($item->assiment_status == 'finished')
                                                    {{'Completed'}}
                                                    @endif

                                                </td>
                                                <td>
                                                    <textarea name="note" id="note_{{$item->assignId}}" rows="5" value="{{$item->note}}">{{$item->note}}</textarea>
                                                    <center><button class="btn btn-primary btn-sm" onclick="saveNote({{$item->assignId}})">Save</button></center>
                                                </td>
                                                <td>
                                                    <ul style="text-align: left;">
                                                        @if($item->assiment_status == 'pending')
                                                            <li>
                                                                <a href="#" >Waiting driver to update data</a>
                                                            </li>
                                                        @endif

                                                        @if($item->assiment_status == 'sent')
                                                            <li>
                                                                <a href="#" onclick="PreviewAccessoriesCheckUp('{{$item->vehicle_check_id}}', '{{$item->plate}}')" >Preview Accessories</a>
                                                            </li>
                                                        @endif

                                                        @if($item->assiment_status == 'utlity_accepted')
                                                            <li>
                                                                <a href="#" disabled style="text-decoration: line-through;">Preview Accessories</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" onclick="PreviewCheckUp('{{$item->vehicle_check_id}}', '{{$item->plate}}',  '{{$item->createdCompanyId}}')" >Preview Check-up</a>
                                                            </li>
                                                        @endif

                                                        @if($item->assiment_status == 'image_accepted')

                                                            <li>
                                                                <a href="#" disabled style="text-decoration: line-through;">Preview Accessories</a>
                                                            </li>

                                                            <li>
                                                                <a href="#" disabled  style="text-decoration: line-through;">Preview Check-up</a>
                                                            </li>

                                                            <li>
                                                                <a href="#" onclick="setRequestIdAndCreate('{{$item->requests_id}}','{{$item->driver_id}}','{{$item->supporvisor_identity_approve}}','{{$k}}')" > <span  >Issue new delegation</span> </a>
                                                            </li>

                                                        @endif

                                                        @if($item->assiment_status == 'utlity_rejected')
                                                            <li>
                                                                <a href="#"  style="margin: 5px;">Waiting DA To Accessories</a>
                                                            </li>
                                                        @endif

                                                        @if($item->assiment_status == 'image_rejected' )
                                                            <li>
                                                                <a href="#"  style="margin: 5px;">image rejected, Waiting to reupload Images</a>
                                                            </li>
                                                        @endif

                                                        @if($item->assiment_status == 'done')
                                                            <li>
                                                                <a href="#"  style="margin: 5px;"><button class="btn btn-danger" >Delete</button></a>
                                                            </li>
                                                        @endif
                                                        @if($item->assiment_status == 'finished')
                                                            <li>
                                                                <a href="#"  style="margin: 5px;">{{'Completed'}} </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="12"><center>No data found!</center></td></tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <TH >City</TH>
                                        <TH >Plate</TH>
                                        <th scope="col">Vehicle </th>
                                        <th scope="col">Opreater Company </th>
                                        <th scope="col">DA </th>
                                        <th scope="col">DA Approval </th>
                                        <th scope="col">Request type </th>
                                        <th scope="col">Request Date </th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Note</th>
                                        <th scope="col">Procedures </th>
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

            $('#filter_created_at').val('');
            $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_updated_at').val('');
            $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            function updateUtility(id, utlity_condition) {
                $.ajax({
                    type: 'POST',
                    url: "{{url('Vehicles/updateUtility')}}",
                    cache: false,
                    data: {
                        id: id,
                        utlity_condition: utlity_condition,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        if (data == 'good') {
                            console.log('good');
                        } else {
                            console.log('bad');
                        }
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
            $('#filter').click(function () {
                var filter_companyId = filter_warehouseId = filter_cityId = filter_job_id = filter_status_id = filter_request_id = filter_created_at = filter_updated_at = '';
                filter_companyId = $('#filter_companyId').val();
                filter_warehouseId = $('#filter_warehouseId').val();
                filter_cityId = $('#filter_cityId').val();
                filter_job_id = $('#filter_job_id').val();
                filter_status_id = $('#filter_status_id').val();
                filter_request_id = $('#filter_request_id').val();
                filter_created_at = $('#filter_created_at').val();
                filter_updated_at = $('#filter_updated_at').val();
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/VehicleRequest/searchRequest")}}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        filter_companyId: filter_companyId,
                        filter_warehouseId: filter_warehouseId,
                        filter_cityId: filter_cityId,
                        filter_job_id: filter_job_id,
                        filter_status_id: filter_status_id,
                        filter_request_id: filter_request_id,
                        filter_created_at: filter_created_at,
                        filter_updated_at: filter_updated_at,
                    },
                    success: function (data) {
                        $('#tbl_body').html(data);
                    }
                });

            });
            function reset_records() {
                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_warehouseId').empty();
                $('#filter_cityId').val('');
                $('#filter_job_id').val('');
                $('#filter_status_id').val('');
                $('#filter_request_id').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
            }

            function saveNote(assignId) {
                let note = $('#note_'+assignId).val();
                if (note == '')
                    alert("Please enter note then click on save.");
                else {
                    $.ajax({
                        type: 'POST',
                        url: "{{URL("/VehicleRequest/saveNote")}}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            assignId: assignId,
                            note: note
                        },
                        success: function (data) {
                            if (data  == 'good')
                                alert("Note Saved Successfully.");
                            else
                                alert("Something went wrong. Please try again!");
                        }
                    });
                }

            }
            selectedDriverToApprove = '';
            $( document ).ready(function() {

                $("input[name='enable_btn']").on( "change", function() {
                  var enable_btn = document.getElementsByName('enable_btn');
                //   if(enable_btn.length>0){
                //       array.forEach(element => {
                //         if(element == 'yes'){

                //         }else{
                //             element
                //         }
                //     });
                //   }

                } );
            });
            function driver(id) {
                $('#ViewDAModal').modal('toggle')
                $.ajax({
                    type: 'GET',
                    url: "{{URL("/Drivers")}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                    }
                });

                // ViewDAModal on click #edit_modalCancelBtn
            }

            // request_id
            // open modal and set request_id function
            function setRequestIdAndOpenModal(args,driver_id,supporvisor_identity_approve){

                // $('#approveBtn').prop('disabled', true);
                $('#driving_licence').width('120px');
                $('#identity_file').width('120px');
                $('#driving_licence').attr("src", '{{asset('images/loading.gif')}}');
                $('#identity_file').attr("src", '{{asset('images/loading.gif')}}');

                $('#driver_id').val(driver_id)
                selectedDriverToApprove = driver_id;
                // Fill modal Data

                // Post Request to get Driver data

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


                            // if(payload.payload['licenseProof'] == null){
                            //     $('#driving_licence').attr("src", '{{asset('images/driving-license.png')}}');
                            //     $('#driving_licence').width('200px');
                            // }else{
                            //     $('#driving_licence').width('300px');
                            //     $('#driving_licence').attr("src", '/'+payload.payload['licenseProof']);
                            // }
                            // if(payload.payload['identityProof'] == null){
                            //     // width: 200px;
                            //     $('#identity_file').attr("src", '{{asset('images/iqama.png')}}');
                            //     $('#identity_file').width('200px');
                            // }else{
                            //     $('#identity_file').width('300px');
                            //     $('#identity_file').attr("src", '/Attachment/Image_Identity/'+payload.payload['id']+'.jpg');
                            // }

                                const timeElapsed = Date.now();
                                // timeElapsed = timeElapsed.toDateString(); // "Sun Jun 14 2020"
                                console.log(timeElapsed);
                                $('#driving_licence').width('300px');
                                $('#driving_licence').attr("src", '/Attachment/Image_DrivingLicence/'+payload.payload['id']+'.jpg?v='+timeElapsed);
                                // $('#driving_licence').attr("alt", payload.payload['id']);



                                $('#identity_file').width('300px');
                                $('#identity_file').attr("src", '/Attachment/Image_Identity/'+payload.payload['id']+'.jpg?v='+timeElapsed);

                            if(payload.payload['driver_data'] == 'pending'){
                                $('#status_text').text('Waiting Approval')
                                $('#approveBtn').prop('disabled', false);
                                // $(':input[type="submit"]').prop('disabled', false);
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
            function approveIdentity() {
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

            function PreviewCheckUp(args, plate, createdCompanyId){
                $('#createdCompanyId').val(createdCompanyId);
                if(createdCompanyId != 18) {
                    $('#refNo').show();
                } else {
                    $('#refNo').hide();
                }
                $('#vehicleCheckUpModalLabel').html('Vehicle (' + plate + ')');
                $('#checkUp_id').val(args);
                $.ajax({
                    type: 'GET',
                    url: "{{URL("Vehicles/Check-up")}}" + "/" + args,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        let payload = JSON.parse(data);

                        if(payload.status){
                            let payloadData = payload.data;
                            $('#accessoriesTable').html(payloadData.accssorieTable)
                            console.log()
                            let checkUp = payloadData.checkUp;
                            let checkUpPrev = payloadData.checkUpPrev;
                            if(checkUpPrev == '') {
                                $('#priv_front_side').width('250px');
                                $('#priv_front_side').attr("src",  '{{url('')}}'+'/images/no_imag.jpg');
                                $('#priv_rear_side').width('250px');
                                $('#priv_rear_side').attr("src",  '{{url('')}}'+'/images/no_imag.jpg');
                                $('#priv_right_side').width('250px');
                                $('#priv_right_side').attr("src",  '{{url('')}}'+'/images/no_imag.jpg');
                                $('#priv_left_side').width('250px');
                                $('#priv_left_side').attr("src",  '{{url('')}}'+'/images/no_imag.jpg');
                                $('#priv_intiror_side').width('250px');
                                $('#priv_intiror_side').attr("src",  '{{url('')}}'+'/images/no_imag.jpg');
                            } else {
                                $('#priv_front_side').width('300px');
                                $('#priv_front_side').attr("src",  '{{url('')}}'+'/'+checkUpPrev.front_image);
                                $('#priv_rear_side').width('300px');
                                $('#priv_rear_side').attr("src",  '{{url('')}}'+'/'+checkUpPrev.rear_image);
                                $('#priv_right_side').width('300px');
                                $('#priv_right_side').attr("src",  '{{url('')}}'+'/'+checkUpPrev.right_image);
                                $('#priv_left_side').width('300px');
                                $('#priv_left_side').attr("src",  '{{url('')}}'+'/'+checkUpPrev.left_image);
                                $('#priv_intiror_side').width('300px');
                                $('#priv_intiror_side').attr("src",  '{{url('')}}'+'/'+checkUpPrev.drivingWheel_image);
                            }
                            $('#front_side').width('300px');
                            $('#front_side').attr("src",  '{{url('')}}'+'/'+checkUp.front_image);
                            $('#rear_side').width('300px');
                            $('#rear_side').attr("src",  '{{url('')}}'+'/'+checkUp.rear_image);

                            $('#left_side').width('300px');
                            $('#left_side').attr("src",  '{{url('')}}'+'/'+checkUp.left_image);

                            $('#right_side').width('300px');
                            $('#right_side').attr("src",  '{{url('')}}'+'/'+checkUp.right_image);

                            $('#intiror_side').width('300px');
                            $('#intiror_side').attr("src",  '{{url('')}}'+'/'+checkUp.drivingWheel_image);

                            $('#oto_reading').html(checkUpPrev.otometer + ' KM');
                            $('#vehicle_id').val(checkUp.vehicle_id);

                            // rear_side,right_side,left_side,intiror_side
                            $('#vehicleCheckUpModal').modal('toggle');

                        }

                    }
                });
                console.log(args)
            }
            function openViewVehicleModal(args){
                $('#edit_modal').modal('toggle');
                let html = `<img style="width: inherit;" src="`+args+`">`;
                document.getElementById('imgResponse').innerHTML = html;

            }
            function BackVehicleCheckup(){
                $('#vehicleCheckUpModal').modal('toggle')
                $('#ViewVehicleImageModal').modal('hide')

            }
            const change = src => {
                document.getElementById('main').src = src
            }
            function PreviewAccessoriesCheckUp(args, plate){
                $('#vehicleAccessoryCheckUpModalLabel').html('Vehicle (' + plate + ')');
                console.log(args)
                 $.ajax({
                    type: 'GET',
                    url: "{{URL("Vehicles/Check-up")}}" + "/" + args,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        let payload = JSON.parse(data);

                        if(payload.status){
                            let payloadData = payload.data;
                            //
                            $('#checkUp_id').val(args)
                            $('#accessoriesTable').html(payloadData.accssorieTable)
                            $('#vehicleAccessoryCheckUpModal').modal('toggle')
                        }

                    }
                });


            }
            function vaidateAccessory(){
                let checkUp_id = $('#checkUp_id').val();
                let checkedAccessories = selectedCheckbox();
                // check if reject check box is selected
                if(checkedAccessories.length>0){
                    // send Rejction
                    let payload = {
                        "check_id":checkUp_id,
                        "items":checkedAccessories,
                        "rejction_reason":$('#rejection_reason').val(),
                        "action":"reject"
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{URL("Vehicles/CheckUp-Accessories-Handler")}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",payload},
                        success: function (data) {
                            location.reload();
                            alert('Done');
                        }
                    });
                } else {
                    // send Approval
                    let payload = {
                        "check_id":checkUp_id,
                        "items":[],
                        "rejction_reason":null,
                        "action":"approve"
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{URL("Vehicles/CheckUp-Accessories-Handler")}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",payload},
                        success: function (data) {
                            location.reload();
                            alert('Done');
                            // document.getElementById('response').innerHTML = data;
                        }
                    });
                }


                $('#approveAccessoryBtn').prop('disabled', false);
            }
            function selectedCheckbox(){
                var array = []
                var checkboxes = document.querySelectorAll('#accessoriesTable input[type=checkbox]:checked')

                for (var i = 0; i < checkboxes.length; i++) {
                  // console.log(checkboxes[i].value);
                  array.push(checkboxes[i].value)
                }
                return array;
            }
            function checkUpImageHandler(){
                let otometer_read = $('#otometer_read').val();
                let vehicle_id = $('#vehicle_id').val();
                if(otometer_read == '' || otometer_read == null){
                    alert('Otometer read can not be empty');
                    return false;
                }
                let createdCompanyId = $('#createdCompanyId').val();
                let reference_no = '';
                if (createdCompanyId != 18) {
                    reference_no = $('#reference_no').val();
                    if(reference_no == '' || reference_no == null){
                        alert('Reference No can not be empty');
                        return false;
                    }
                }

                let checkUp_id = $('#checkUp_id').val();

                var array = []
                var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

                for (var i = 0; i < checkboxes.length; i++) {
                    array.push(checkboxes[i].value)
                }


                let skippedCheckUpImages = array;

                // check if reject check box is selected
                if(skippedCheckUpImages.length>0){
                    let checkupRejectionReason = $('#checkupRejectionReason').val();
                    if(checkupRejectionReason == null || checkupRejectionReason == ''){
                        alert('Reject Reason Can not be empty');
                        return 0;
                    }
                    // rejected by supervisor
                    // send http
                    //  URL : Vehicles/CheckUpImageHandler
                    let payload = {
                        "check_id":checkUp_id,
                        "items":skippedCheckUpImages,
                        "rejction_reason":$('#checkupRejectionReason').val(),
                        "Otometer_Read":$('#otometer_read').val(),
                        "reference_no" : reference_no,
                        "vehicle_id" : vehicle_id,
                        "action":"reject"
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{URL("Vehicles/CheckUpImageHandler")}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",payload},
                        success: function (data) {
                            location.reload();

                            // document.getElementById('response').innerHTML = data;
                        }
                    });
                    console.log(skippedCheckUpImages);
                }else{
                    let payload = {
                        "check_id":checkUp_id,
                        "items":[],
                        "rejction_reason":null,
                        "Otometer_Read":$('#otometer_read').val(),
                        "reference_no" : reference_no,
                        "vehicle_id" : vehicle_id,
                        "action":"approve"
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{URL("Vehicles/CheckUpImageHandler")}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",payload},
                        success: function (data) {
                            location.reload();
                            document.getElementById('response').innerHTML = data;
                        }
                    });
                }
            }
            function setRequestIdAndCreate(args,driver_id,supporvisor_identity_approve,index){

                var arrayFromPHP = <?php echo json_encode($payload); ?>;
                arrayFromPHP = arrayFromPHP[index];
                // job_id,project_details
                $("#job_id").empty();
                $('#job_id').text(arrayFromPHP['job_id'])

                $("#project_details").empty();
                $('#plate_no').text(arrayFromPHP['plate'])
                // http request
                console.log(arrayFromPHP);
                $('#delegationModal').modal('toggle')
            }
            function setApproveBTN(){
                var checked_radio = document.querySelector('input[name="driverHavePromassyNote"]:checked').value;

                if(checked_radio == 'yes'){
                    $('#approveBtn2').prop('disabled', false);
                }else{
                    $('#approveBtn2').prop('disabled', true);
                }
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
                $('#ViewVehicleModal').modal('toggle');
            }
            function openCity(cityName) {
                var i;
                var x = document.getElementsByClassName("city");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                document.getElementById(cityName).style.display = "block";
            }
        </script>
    @stop
@endsection

