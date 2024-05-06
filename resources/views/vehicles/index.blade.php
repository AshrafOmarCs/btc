@extends('AdminLTE')
@section('content')  
<link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" style="margin-bottom: 16px;"  class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         
        <div class="modal-body">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Utility Name</th>
                    <th scope="col">Status</th> 
                  </tr>
                </thead>
                <tbody> 
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td> 
                    </tr>  
                </tbody>
              </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
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
                <table style="width: 100%; margin-bottom: 15px; background-color: #a95d21; color: white;  border: 2px solid white;">
                    <tbody>
                        <tr>
                            <th style="text-align: center;">Submitted by </th>
                            <th style="text-align: center;" colspan="3" >Reviewed by </th>
                            <th style="text-align: center;">Timestamp  </th>
                        </tr>
                        <tr style="text-align: center;">
                            <td colspan="2" id="front_image_submittedBy"> </td>
                            <td colspan="2"  id="front_image_reviedBy"></td>
                            <td colspan="2"  id="front_image_timeStamp">Timestamp :</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped">
                    <tbody> 
                        <tr>
                            <th>Side Description</th>
                            <th colspan="3">Image</th>
                            <th>Approvel Status</th>
                        </tr> 
                        <tr>
                            <th >Left side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image2.png")}}" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" id="left_image" srcset=""> </a></td> 
                            <td><span style="color:#dd4b39" id="left_status"> </span></td>
                        </tr> 
                        <tr>
                            <th >Right side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="right_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image3.png")}}" id="right_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_FrontImage" srcset=""></td> 
                                <td><span style="color:#dd4b39" id="right_status"> </span></td>
                        </tr> 
                        <tr>
                            <th >Front side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="front_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image4.png")}}"  id="front_image" style="max-width: 413px; max-height: 243px;" alt="LastCheckup_RearImage" srcset=""></td> 
                                <td><span style="color:#dd4b39" id="front_status"> </span></td>
                        </tr>
                        <tr>
                            <th >Rear side Images</th>
                            <td colspan="3" style="text-align: center;"><a id="rear_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image5.png")}}" id="rear_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_LeftImage" srcset=""></td> 
                            <td><span style="color:#dd4b39" id="rear_status"> </span></td>
                        </tr>
                        <tr>
                            <th >Interior Images</th>
                            <td colspan="3" style="text-align: center;"><a id="drivingWheel_image_a" href="#"><img src="{{asset("/images/vehicleSides/Image6.png")}}" id="drivingWheel_image" style="max-width: 413px; max-height: 243px;"  alt="LastCheckup_RightImage" srcset=""></td> 
                            <td><span style="color:#dd4b39" id="Interior_status"> </span></td>
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
          <button type="button" class="btn btn-primary">Save changes</button>
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
                <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Bulk Upload</a>
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
                        <TH>Company Name</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required>
                                <option value=""></option>
                                
                            </select>
                        </td> 
                        <TH>Warehouse Name</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;"> 
                                <option value=""></option> 
                            </select>
                        </td>
                        <TH>full Name</TH>
                        <td><input type="text" class="form-control" style="width:180px;" id="filter_fullName"
                                   name="filter_fullName"></td>
                    </tr>
                    <tr> 
                        <TH>Mobile</TH>
                        <td><input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber">
                        </td>
                        <TH>Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_iqama" id="filter_iqama"></td>

                        <TH>Email ID</TH>
                        <td><input type="text" class="form-control" name="filter_email_id" id="filter_email_id"></td>

                    </tr>

                    <tr>
                        <TH>Job ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>

                        <TH>Status</TH>
                        <td>
                            <select name="filter_status_id" id="filter_status_id" onchange="status()"
                                    class="form-control">
                                <option value=""></option>

                               
                            </select>
                        </td>
                        <TH>Account_Owner_Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_account_owner_iqama"
                                   id="filter_account_owner_iqama">
                        </td>

                    </tr>


                    <tr>

                        <TH>accountNumber</TH>
                        <td><input type="text" class="form-control" name="filter_accountNumber"
                                   id="filter_accountNumber"></td>
                        <TH>Driver Type</TH>
                        <td>
                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control">
                                <option value=""></option>
                                
                            </select>
                        </td>

                        <TH>Bander Car</TH>
                        <td>
                            <select name="filter_bander_car_id" id="filter_bander_car_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Image Identity</TH>
                        <td>
                            <select name="filter_Image_Identity" id="filter_Image_Identity" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image Passport</TH>
                        <td>
                            <select name="filter_Image_Passport" id="filter_Image_Passport" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image DrivingLicence</TH>
                        <td>
                            <select name="filter_Image_DrivingLicence" id="filter_Image_DrivingLicence"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <TH>Image VehiclesRegistration</TH>
                        <td>
                            <select name="filter_Image_VehiclesRegistration" id="filter_Image_VehiclesRegistration"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image JobContract</TH>
                        <td>
                            <select name="filter_Image_JobContract" id="filter_Image_JobContract" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image PromissoryNote</TH>
                        <td>
                            <select name="filter_Image_PromissoryNote" id="filter_Image_PromissoryNote"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Created_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_created_at" id="filter_created_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_created_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_created_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_created_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });

                                </script>
                            </div>
                        </td>
                        <TH>Updated_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" id="filter_updated_at" name="filter_updated_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_updated_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_updated_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_updated_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });

                                </script>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info">Filter</button>

                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <div class="table-responsive" style="width: 100%;">

        <table id="customer_data" class="table table-bordered table-striped table-responsive">
            <thead>
                <TH>#</TH>
                <TH >Plate</TH>
                <TH >City</TH>
                <th scope="col">Manufacturer </th>
                <th scope="col">Vehicle model </th> 
                <th scope="col">Opreater company  </th> 
                <th scope="col">Cololr </th>
                <th scope="col">Vehicel registeration Expiry </th> 
                <th scope="col">Vehicle accessories </th>  
                <th scope="col">Vehicle Otometer </th> 
                <th scope="col">Registertion type </th>  
                <th scope="col">Vehicle status </th>   
                <th scope="col">Additional data </th>
                <th scope="col">Operations</th>  
            </thead>
            <tbody>
                @foreach ($payload as $k=>$item) 
                    <tr>
                        <td scope="col">#</td>
                        <td scope="col">{{$item->plate}} </td>
                        <td scope="col">{{$item->name_en}} </td>
                        <td scope="col">{{$item->vehicle_manufacturer}} </td>
                        <td scope="col">{{$item->vehicle_model}}, {{$item->manufacturer_date}}</td> 
                        <td scope="col">{{$item->vehicle_opreator}} </td> 
                        <td scope="col">{{$item->color}} </td> 
                        <td scope="col">{{$item->vehicle_registration_expire_date}} </td>  
                        <td scope="col"> 
                            <ul>
                               {!!$item->vehicle_utilities_html!!}
                            </ul> 
                        </td>  
                        <td scope="col">{{$item->otometer}} </td> 
                        <td scope="col"> {{$item->registertion_type}} </td> 
                        <td scope="col"> {{$item->current_status}}  </td>   
                        <td scope="col"> Additional data </td>
                        <td scope="col">
                            <a onclick="vehicleExtraInfo({{$k}})"  data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                            <a id="" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>
                            <a data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-history" aria-hidden="true"></i> </a> 
                            <!-- only if new added vehicle  -->
                             
                            @if($item->checkup_id == '')
                                <a onclick="addVehicleCheckup({{$k}})" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-check-square" aria-hidden="true"></i> </a>
                            @else
                                @php   
                                    if($item->vehicle_utilities =='')  {
                                        echo '<a href="'.url('/Vehicles/vehicle-checkup-utilities/'.$item->checkup_id).'" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view">Set vehicle accessories </a>';
                                    }else{
                                         
                                    }
                                @endphp 
                               
                            @endif
                            <!-- only if new added vehicle  --> 
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="border-left: 1px solid #08c !important;">#</th>
                    <th scope="col">Plate </th>
                    <th scope="col">City </th> 
                    <th scope="col">Manufacturer </th>
                    <th scope="col">Vehicle model </th> 
                    <th scope="col">Opreater company  </th> 
                    <th scope="col">Cololr </th>
                    <th scope="col">Vehicel registeration Expiry </th> 
                    <th scope="col">Vehicle accessories </th>  
                    <th scope="col">Vehicle Otometer </th> 
                    <th scope="col">Registertion type </th>  
                    <th scope="col">Vehicle status </th>   
                    <th scope="col">Additional data </th>
                    <th scope="col">Operations</th>
                </tr>
        </thead>
        </table>
    </div>

    <script>
        var payload = <?php echo json_encode($payload);?>;
        function vehicleExtraInfo(index){
            
            console.log(payload[index].images)
            if(payload[index].images != ''){
                $('#left_image').attr("src", payload[index].images['left_image']);
                $('#right_image').attr("src", payload[index].images['right_image']);
                $('#rear_image').attr("src", payload[index].images['rear_image']);
                $('#front_image').attr("src", payload[index].images['front_image']);
                $('#drivingWheel_image').attr("src", payload[index].images['drivingWheel_image']);

                $('#front_image_a').attr("href", payload[index].images['drivingWheel_image']);
                $('#right_image_a').attr("href", payload[index].images['drivingWheel_image']);
                $('#front_image_a').attr("href", payload[index].images['drivingWheel_image']);
                $('#rear_image_a').attr("href", payload[index].images['drivingWheel_image']);
                $('#drivingWheel_image_a').attr("href", payload[index].images['drivingWheel_image']); 

                // front_image_submittedBy
                $("#front_image_submittedBy").empty();
                $('#front_image_submittedBy').append(payload[index].images['uploadedBy']); 
                $("#front_image_reviedBy").empty();
                $('#front_image_reviedBy').text(payload[index].images['ApprovedBy'])
                $("#front_image_timeStamp").empty();
                $('#front_image_timeStamp').text(payload[index].images['created_at'])

                if(payload[index].images['left_image_approve'] == null){ 
                    $("#left_status").empty();
                    $('#left_status').append('NULL')
                }else{
                    $("#left_status").empty();
                    $('#left_status').append('Approved')
                }
                if(payload[index].images['right_image_approve'] == null){ 
                    $("#right_status").empty();
                    $('#right_status').append('NULL')
                } else{
                    $("#right_status").empty();
                    $('#right_status').append('Approved')
                }
                if(payload[index].images['front_image_approve'] == null){
                    console.log('left_image_approve NULL');
                    $("#front_status").empty();
                    $('#front_status').append('NULL')
                } else{
                    $("#front_status").empty();
                    $('#front_status').append('Approved')
                }
                if(payload[index].images['rear_image_approve'] == null){
                    console.log('left_image_approve NULL');
                    $("#rear_status").empty();
                    $('#rear_status').append('NULL')
                } else{
                    $("#rear_status").empty();
                    $('#rear_status').append('Approved')
                }
                if(payload[index].images['interior_image_approve'] == null){ 
                    $("#Interior_status").empty();
                    $('#Interior_status').append('NULL')
                } else{
                    $("#Interior_status").empty();
                    $('#Interior_status').append('Approved')
                }

            }else{
                $('#front_image_reviedBy').text('NONE')
                $('#front_image_submittedBy').text('NONE')
                $('#front_image_timeStamp').text('NONE')
                $('#left_image').attr("src", '/images/vehicleSides/Image2.png');
                $('#right_image').attr("src", '/images/vehicleSides/Image3.png');
                $('#rear_image').attr("src", '/images/vehicleSides/Image5.png');
                $('#front_image').attr("src",'/images/vehicleSides/Image4.png');
                $('#drivingWheel_image').attr("src", '/images/vehicleSides/Image6.png');

                $('#front_image_a').attr("href", '#');
                $('#right_image_a').attr("href", '#');
                $('#front_image_a').attr("href", '#');
                $('#rear_image_a').attr("href", '#');
                $('#drivingWheel_image_a').attr("href", '#'); 
            }

            $('#plate').text(payload[index].plate);
            $('#city').text(payload[index].name_en);
            $('#manufacturer').text(payload[index].vehicle_manufacturer);
            $('#manufacturer_year').text(payload[index].manufacturer_date);
            $('#vehcile_model').text(payload[index].vehicle_model);
            $('#opreaterCompany').text(payload[index].vehicle_opreator);
            $('#srNo').text(payload[index].SNno);
            $('#bodyNumber').text(payload[index].body_number);
            if(payload[index].freeExtraOtometer == null){
                $('#freeExtraOtometer').text('NULL');
            }else{
                $('#freeExtraOtometer').text(payload[index].freeExtraOtometer);
            }

            if(payload[index].extraOtometerRate == null){
                $('#extraOtometerRate').text('NULL');
            }else{
                $('#extraOtometerRate').text(payload[index].extraOtometerCharge);
            } 
            $('#Otometer').text(payload[index].otometer+ ' k/m');
            $('#registertion_type').text(payload[index].registertion_type);
            $('#status').text(payload[index].current_status);
            $('#color').text(payload[index].color);
            $('#vehicle_registration_expire_date').text(payload[index].vehicle_registration_expire_date);
            $("#accessories").empty();
            $('#accessories').append(payload[index].vehicle_utilities_html); 
            $('#VehicleExtraDataModal').modal('toggle');
        }
        function addVehicleCheckup(index) {
            // selectedVehicle
            console.log(payload[index])
            var selectedVehicle = payload[index].vehicle_manufacturer+','+payload[index].vehicle_model+'('+payload[index].manufacturer_date+'), '+payload[index].plate;
            $('#selectedVehicle').val(selectedVehicle)
            $('#vehicle_id').val(payload[index].vehicle_id)
            $('#serialNumber').val(payload[index].SNno)
            $('#CreateCheckupModal').modal('toggle');
        }
        function editAccessories(index){ 
            $('#VehicleExtraDataModal').modal('hide');
            sendPost(index);
            console.log(payload[index]);
            $('#exampleModal').modal('toggle');
            alert(index);
        }
        function addAccessories(index){
            console.log(payload[index].vehicle_id);
            $('#exampleModal').modal('toggle');
            alert(index);
        }
        $(document).ready( function () {
            $('#customer_data').DataTable();
        });
        function sendPost(index){
            $.ajax({
                    type: 'post',
                    url: "{{URL('/vehicles/utilities')}}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{"_token": "{{ csrf_token() }}",'vehcile_id':payload[index].vehicle_id}, 
                    success: function (data) {
                         console.log(data);
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
    </script>
    <script src="{{asset('dropAndDrag/src/script.js')}}"></script> 
@endsection