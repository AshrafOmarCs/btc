@extends('AdminLTE')
@section('content')
@section('title', 'Vehicles')

<link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #7CCBDC">
          <h5 class="modal-title" id="exampleModalLabel">Vehicle Accessories</h5>
          <button type="button" style="margin-bottom: 16px;"  class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
<div class="modal fade" id="VehicleExtraDataModal" tabindex="-1" role="dialog" aria-labelledby="VehicleExtraDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="VehicleExtraDataModalLabel">Vehicle Information</h5>
          <button type="button" style="margin-bottom: 16px;" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="w3-bar w3-black">
            <button class="w3-bar-item w3-button" onclick="openCity('London')">Vehicle information</button>
            <button class="w3-bar-item w3-button" onclick="openCity('Paris')" style="border-left: #ffffff 1px solid;">Vehicle Images </button>
            <button class="w3-bar-item w3-button" onclick="openCity('Tokyo')">Summery</button>
          </div>

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
                <!--<table style="width: 100%; margin-bottom: 15px; background-color: #a95d21; color: white;  border: 2px solid white;">-->
                <!--    <tbody>-->
                <!--        <tr>-->
                <!--            <th style="text-align: center;">Submitted by </th>-->
                <!--            <th style="text-align: center;" colspan="3" >Reviewed by </th>-->
                <!--            <th style="text-align: center;">Timestamp  </th>-->
                <!--        </tr>-->
                <!--        <tr style="text-align: center;">-->
                <!--            <td colspan="2" id="front_image_submittedBy"> </td>-->
                <!--            <td colspan="2"  id="front_image_reviedBy"></td>-->
                <!--            <td colspan="2"  id="front_image_timeStamp">Timestamp :</td>-->
                <!--        </tr>-->
                <!--    </tbody>-->
                <!--</table>-->
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Side Description</th>
                            <th colspan="3">Image</th>
                            <!--<th>Approvel Status</th>-->
                        </tr>
                        <tr>
                            <th >Left side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img src="{{asset("images/no_imag.jpg")}}" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" id="left_image" srcset=""> </a></td>
                            <!--<td><span style="color:#dd4b39" id="left_status"> </span></td>-->
                        </tr>
                        <tr>
                            <th >Right side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="right_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image3.png")}}" id="right_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="right_status"> </span></td>-->
                        </tr>
                        <tr>
                            <th >Front side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image4.png")}}"  id="front_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_RearImage" srcset=""></td>
                                <!--<td><span style="color:#dd4b39" id="front_status"> </span></td>-->
                        </tr>
                        <tr>
                            <th >Rear side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="rear_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image5.png")}}" id="rear_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_LeftImage" srcset=""></td>
                            <!--<td><span style="color:#dd4b39" id="rear_status"> </span></td>-->
                        </tr>
                        <tr>
                            <th >Interior Images</th>
                            <td colspan="3" style="text-align: center;"><a id="drivingWheel_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image6.png")}}" id="drivingWheel_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_RightImage" srcset=""></td>
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
                            <td >10 Day/s</td>
                        </tr>
                        <tr>
                            <th >Valid delegation expires in </th>
                            <td >118 Day/s</td>
                        </tr>
                        <tr>
                            <th >Delegations quntity</th>
                            <td >12</td>
                        </tr>
                        <tr>
                            <th>Utilities quntity</th>
                            <td colspan="3"> 3 </td>
                        </tr>
                        <tr>
                            <th>Woking Days</th>
                            <td colspan="3"> 165 Day </td>
                        </tr>
                        <tr>
                            <th >Maintenance days </th>
                            <td colspan="3"> 6 </td>
                        </tr>
                        <tr>
                            <th >Maintenance costs </th>
                            <td colspan="3">
                                <ul>
                                    <li>1820.00 SAR On 23-02-2023 at <span style="color:blue">AlJaber Maintenance</span></li>
                                    <li>280.00 SAR On 18-12-2022 at <span style="color:blue">Abdulrahman Sinayaa</span></li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!--<button type="button" class="btn btn-primary">Save changes</button>-->
        </div>
      </div>
    </div>
  </div>
<!-- Vehicle extra data Modal -->


    <style>
        th{
            /* background-color: #d4c8b8; */
        }
        td{
            /* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; */
            border: 1px solid white;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Vehicles Lists</h2>
        </div>
        @if(Auth::user()->user_type_id==1||session('Session_DriversCarrefour')=='yes')
            <div style="float:right;">
                <h2 style="display: flex">
                    <a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Bulk Upload</a>
                    <form method="POST" action="{{ url('Vehicles/download_vehicles_report')}}">
                        @csrf
                        &nbsp;<button type="submit" style="padding: 10px" class="btn btn-sm btn-info "> <i class="fa fa-download"></i> Download Report</button>
                    </form>
                </h2>
            </div>
        @endif
    </div>
    <!-- end of header -->
    <div class="card card-default" style="width:100%;clear:both;"></div>

        <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                        <TH>Company</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId"
                                    class="form-control" style="width:200px;" onchange="WarehouseName()">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->companyName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Warehouse</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control" style="width:200px;">
                                <option value=""></option>
                            </select>
                        </td>
                        <TH>City</TH>
                        <td>
                            <select name="filter_cityId" id="filter_cityId"
                                    class="form-control" style="width:200px;" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->name_en}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Status</TH>
                        <td>
                            <select id="filter_status" name="filter_status" class="form-control"
                                    style="width:200px;">
                                <option value="">Select Status</option>
                                <option value="availabe">Available</option>
                                <option value="damaged">damaged</option>
                                <option value="delegeted">Delegated</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <TH>Vehicle Operator</TH>
                        <td>
                            <select name="filter_vehicle_opreaterId" id="filter_vehicle_opreaterId"
                                    class="form-control" style="width:200px;" required>
                                <option value="">Select Vehicle Operator</option>
                                @foreach($operators as $operator)
                                <option value="{{$operator->id}}">{{$operator->name_en}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Vehicle Manufecturer</TH>
                        <td>
                            <select name="filter_vehicle_manufecturerId" id="filter_vehicle_manufecturerId"
                                    class="form-control" style="width:200px;" required>
                                <option value="">Select Vehicle Manufecturer</option>
                                @foreach($manufacturers as $manufacturer)
                                <option value="{{$manufacturer->id}}">{{$manufacturer->name_en}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Vehicle Model</TH>
                        <td>
                            <select name="filter_modelId" id="filter_modelId"
                                    class="form-control" style="width:200px;" required>
                                <option value="">Select Vehicle Model</option>
                                @foreach($models as $model)
                                <option value="{{$model->id}}">{{$model->name_en}} {{$model->manufacturer_date}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Vehicle Otometer</TH>
                        <td style="display: flex">
                            <select name="filter_otometer" id="filter_otometer"
                                    class="form-control" style="width:100px;" required>
                                <option value="">Select Otometer</option>
                                <option value="=">=</option>
                                <option value=">">></option>
                                <option value="<"><</option>
                            </select>
                            <input type="number" name="filter_otometer_val" id="filter_otometer_val"
                                    class="form-control" style="width:100px;" value="" required>
                        </td>

                    </tr>

                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info">Filter</button>
                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default" onclick="reset_records()">Reset</button>
                </div>
                <span id="reminder" style="color: red; display: none">The following vehicles are delegated vehicles because you have selected the city</span>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <div class="table-responsive" style="width: 100%;">
        <div class="row form-group" id="pre_loader" style="display: none;">
            <div class="col-md-12  text-center">
                <img src="https://btcdmins.com/storage/images/preloader.gif" loading="lazy">
            </div>
        </div>

        <div style="width:100%;clear:both;" class="response">

        </div>
        <table id="customer_data" class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <TH>#</TH>
                    <TH >Plate</TH>
                    <th >Fuel Price </th>
                    <th >Oil Price </th>
                    <th >Expiry Days </th>
                    <TH >City</TH>
                    <th >Manufacturer </th>
                    <th >Vehicle model </th>
                    <th >Opreater company  </th>
                    <th >Cololr </th>
                    <th >Vehicel registeration Expiry </th>
                    <th >Vehicle accessories </th>
                    <th >Vehicle Otometer </th>
                    <th >Registertion type </th>
                    <th >Vehicle status </th>
                    <th >Delegation status </th>
                    <th >Maintenance Location </th>
                    <th >Additional data </th>
                    <th >Operations</th>
                </tr>
            </thead>

            <tfoot class="thead-dark">
                <tr>
                    <th  style="border-left: 1px solid #08c !important;">#</th>
                    <th >Plate </th>
                    <th >Fuel Price </th>
                    <th >Oil Price </th>
                    <th >Expiry Days </th>
                    <th >City </th>
                    <th >Manufacturer </th>
                    <th >Vehicle model </th>
                    <th >Opreater company  </th>
                    <th >Cololr </th>
                    <th >Vehicel registeration Expiry </th>
                    <th >Vehicle accessories </th>
                    <th >Vehicle Otometer </th>
                    <th >Registertion type </th>
                    <th >Vehicle status </th>
                    <th >Delegation status </th>
                    <th >Maintenance Location </th>
                    <th >Additional data </th>
                    <th >Operations</th>
                </tr>
            </tfoot>
        </table>

    </div>


    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                    class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                    title="Close Modal">&times;
                </span>
            </div>

            <div style="width:100%;clear:both;" id="response">

            </div>
        </div>
    </div>

    <script>
        function WarehouseName() {

            var filter_companyId = document.getElementById('filter_companyId').value;

            $('#filter_warehouseId').empty();

            $.getJSON("getWarehouseName" + "/" + filter_companyId, function (json) {
                $('#filter_warehouseId').empty();
                $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });

        }
        function vehicleEdit(vehicle_id) {
            document.getElementById('edit_modal').style.display = 'block';
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
        function vehicleExtraInfo(images, plate, name_en, vehicle_manufacturer, manufacturer_date, vehicle_model, vehicle_opreator, SNno, body_number, freeExtraOtometer, extraOtometerRate, extraOtometerCharge, otometer, registertion_type, current_status, color, vehicle_registration_expire_date, vehicle_utilities_html='')
        {
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
            sendPost(index);
            $('#vehicleId').val(index);
            $('#exampleModal').modal('toggle');
            // alert(index);
        }
        $(document).ready(function () {
            fill_datatable();
            function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_cityId = '', filter_status = '', filter_vehicle_opreaterId = '', filter_vehicle_manufecturerId = '', filter_modelId = '', filter_otometer = '', filter_otometer_val = '') {
                $('#pre_loader').show();
                var dataTable = $('#customer_data').DataTable({
                lengthMenu: [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "All"]],
                processing: true,
                serverSide: true,
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
                    { data: 'fuel_data', name: 'fuel_data', orderable: false },
                    { data: 'oil_data', name: 'oil_data', orderable: false },
                    { data: 'vehicle_expiry_date', name: 'vehicle_expiry_date' },
                    { data: 'name_en', name: 'name_en' },
                    { data: 'vehicle_manufacturer', name: 'vehicle_manufacturer' },
                    { data: 'vehicle_model', name: 'vehicle_model' },
                    { data: 'vehicle_opreator', name: 'vehicle_opreator' },
                    { data: 'color', name: 'color' },
                    { data: 'vehicle_registration_expire_date', name: 'vehicle_registration_expire_date' },
                    { data: 'vehicle_utilities_html', name: 'vehicle_utilities_html', orderable: false },
                    { data: 'otometer', name: 'otometer' },
                    { data: 'registertion_type', name: 'registertion_type' },
                    { data: 'current_status', name: 'current_status' },
                    { data: 'delegation_status', name: 'delegation_status' },

                    { data: 'maintenance_location', name: 'maintenance_location' },
                    { data: 'response1', name: 'response1', orderable: false },
                    { data: 'response2', name: 'response2', orderable: false },

                    ],
                });
                $('#pre_loader').hide();
            }
            $('#filter').click(function () {
                var filter_companyId = filter_warehouseId = filter_cityId = filter_status = filter_vehicle_opreaterId = filter_vehicle_manufecturerId = filter_modelId = filter_otometer = filter_otometer_val = '';
                filter_companyId = $('#filter_companyId').val();
                filter_warehouseId = $('#filter_warehouseId').val();
                filter_cityId = $('#filter_cityId').val();
                filter_status = $('#filter_status').val();
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
                fill_datatable(filter_companyId, filter_warehouseId, filter_cityId, filter_status, filter_vehicle_opreaterId, filter_vehicle_manufecturerId, filter_modelId, filter_otometer, filter_otometer_val)


            });

        });

        function sendPost(index){
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

        function confirmSearch(){
            // $('#pre_loader').show();
            var filter_companyId = filter_warehouseId = filter_cityId = filter_status = filter_vehicle_opreaterId = filter_vehicle_manufecturerId = filter_modelId = filter_otometer = filter_otometer_val = '';
            filter_companyId = $('#filter_companyId').val();
            filter_warehouseId = $('#filter_warehouseId').val();
            filter_cityId = $('#filter_cityId').val();
            filter_status = $('#filter_status').val();
            filter_vehicle_opreaterId = $('#filter_vehicle_opreaterId').val();
            filter_vehicle_manufecturerId = $('#filter_vehicle_manufecturerId').val();
            filter_modelId = $('#filter_modelId').val();
            filter_otometer = $('#filter_otometer').val();
            filter_otometer_val = $('#filter_otometer_val').val();
            $('#customer_data').DataTable().destroy();

            fill_datatable(filter_companyId, filter_warehouseId, filter_cityId, filter_status, filter_vehicle_opreaterId, filter_vehicle_manufecturerId, filter_modelId, filter_otometer, filter_otometer_val)
        }
        function reset_records() {
            $('#filter_companyId').val('');
            $('#filter_warehouseId').val('');
            $('#filter_cityId').val('');
            $('#filter_status').val('');
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
    <script src="{{asset('dropAndDrag/src/script.js')}}"></script>
@endsection
