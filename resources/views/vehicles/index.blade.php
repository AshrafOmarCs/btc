@extends('AdminLTE')
@section('content')  
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
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info" onclick="confirmSearch()">Filter</button>
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
                <TH>#</TH>
                <TH >Plate</TH>
                <th scope="col">Expiry Days </th>
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
                <th scope="col">Maintenance Location </th>
                <th scope="col">Additional data </th>
                <th scope="col">Operations</th>  
            </thead>
            <tbody>
                @php $no = 0; @endphp
                @foreach ($payload as $k=>$item) 
                    @php
                    $days = $color = '';
                    if($item->expiry_days > 0) {
                        $color = 'red';
                        $days = 'days';
                    }
                    @endphp
                    @if(null !== request()->route('city_name'))
                        @php if ($item->name_en != request()->route('city_name'))
                            continue;
                        @endphp
                    @endif
                    <tr>
                        <td scope="col">{{++$no}}</td>
                        <td scope="col">{{$item->plate}} </td>
                        <td scope="col" style="color: {{$color}}">{{$item->expiry_days}}</td>
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
                        <td scope="col"> {{$item->maintenance_location}}  </td> 
                        <td scope="col"> <span style="color: #F79013;">{{ $item->delegation_info['job_id'] == '' ? '' : '('.$item->delegation_info['job_id'].')'}}</span><br> {{$item->delegation_info['driver_name']}} <br> {{$item->delegation_info['city_name']}} <br> {{$item->delegation_info['company_name']}} <br> {{$item->delegation_info['warehouse_name']}}  </td>
                        <td scope="col">
                            <a onclick="vehicleExtraInfo('{{$item->images}}','{{$item->plate}}','{{$item->name_en}}','{{$item->vehicle_manufacturer}}','{{$item->manufacturer_date}}','{{$item->vehicle_model}}','{{$item->vehicle_opreator}}','{{$item->SNno}}','{{$item->body_number}}','{{$item->freeExtraOtometer}}','','{{$item->extraOtometerCharge}}','{{$item->otometer}}','{{$item->registertion_type}}','{{$item->current_status}}','{{$item->color}}','{{$item->vehicle_registration_expire_date}}',`{{$item->vehicle_utilities_html}}`)"  data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                            <a onclick="vehicleEdit({{ $item->vehicle_id }})" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>
                            <a data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-history" aria-hidden="true"></i> </a> 
                            <!-- only if new added vehicle  -->
                             
                            @if($item->checkup_id == '')
                                <a onclick="addVehicleCheckup('{{$item->vehicle_id}}', '{{$item->vehicle_manufacturer}}', '{{$item->vehicle_model}}', '{{$item->manufacturer_date}}', '{{$item->plate}}', '{{$item->SNno}}')" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view"><i class="fa fa-check-square" aria-hidden="true"></i> </a>
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
                    <th scope="col">Expiry Days </th>
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
                    <th scope="col">Maintenance Location </th>
                    <th scope="col">Additional data </th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
        </table>
        <span id="links_btn">{{ $payload->links() }}</span>

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

            $.getJSON("https://btcdmins.com/getWarehouseName" + "/" + filter_companyId, function (json) {
                $('#filter_warehouseId').empty();
                $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });

        }
        var payload = <?php echo json_encode($payload);?>;
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
            if(images != ''){
                $('#left_image').attr("src", images['left_image']);
                $('#right_image').attr("src", images['right_image']);
                $('#rear_image').attr("src", images['rear_image']);
                $('#front_image').attr("src", front_image);
                $('#drivingWheel_image').attr("src", images['drivingWheel_image']);

                $('#front_image_a').attr("href", images['drivingWheel_image']);
                $('#right_image_a').attr("href", images['drivingWheel_image']);
                $('#rear_image_a').attr("href", images['drivingWheel_image']);
                $('#drivingWheel_image_a').attr("href", images['drivingWheel_image']); 

                // front_image_submittedBy
                $("#front_image_submittedBy").empty();
                $('#front_image_submittedBy').append(images['uploadedBy']); 
                $("#front_image_reviedBy").empty();
                $('#front_image_reviedBy').text(images['ApprovedBy'])
                $("#front_image_timeStamp").empty();
                $('#front_image_timeStamp').text(images['created_at'])

                if(images['left_image_approve'] == null){ 
                        $("#left_status").empty();
                        $('#left_status').append('NULL')
                }else{
                        $("#left_status").empty();
                        $('#left_status').append('Approved')
                }
                if(images['right_image_approve'] == null){ 
                        $("#right_status").empty();
                        $('#right_status').append('NULL')
                } else{
                        $("#right_status").empty();
                        $('#right_status').append('Approved')
                }
                if(images['front_image_approve'] == null){
                        console.log('left_image_approve NULL');
                        $("#front_status").empty();
                        $('#front_status').append('NULL')
                } else{
                        $("#front_status").empty();
                        $('#front_status').append('Approved')
                }
                if(images['rear_image_approve'] == null){
                        console.log('left_image_approve NULL');
                        $("#rear_status").empty();
                        $('#rear_status').append('NULL')
                } else{
                        $("#rear_status").empty();
                        $('#rear_status').append('Approved')
                }
                if(images['interior_image_approve'] == null){ 
                        $("#Interior_status").empty();
                        $('#Interior_status').append('NULL')
                } else{
                        $("#Interior_status").empty();
                        $('#Interior_status').append('Approved')
                }

            } else {
                $('#front_image_reviedBy').text('NONE');
                $('#front_image_submittedBy').text('NONE');
                $('#front_image_timeStamp').text('NONE');
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
        
        
        
        
        
        function vehicleExtraInfo_old(index){
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
        function addVehicleCheckup(vehicle_id, vehicle_manufacturer, vehicle_model, manufacturer_date, plate, SNno) {
            var selectedVehicle = vehicle_manufacturer+','+vehicle_model+'('+manufacturer_date+'), '+plate;
            $('#selectedVehicle').val(selectedVehicle)
            $('#vehicle_id').val(vehicle_id)
            $('#serialNumber').val(SNno)
            $('#CreateCheckupModal').modal('toggle');
        }
        
        
        function addVehicleCheckup_old(index) {
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
            // console.log(payload[index]);
            $('#vehicleId').val(index);
            $('#exampleModal').modal('toggle');
            // alert(index);
        }
        function addAccessories(index){
            console.log(payload[index].vehicle_id);
            $('#exampleModal').modal('toggle');
            alert(index);
        }
        $(document).ready( function () {
            $('#customer_data').DataTable({
                    // columnDefs: [
                    //     { targets: 2, type: 'num' } // Replace '1' with the column index you want to sort as numbers
                    // ],
                    paging: false,
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
            $('#pre_loader').show();
            var filter_companyId = filter_warehouseId = filter_cityId = filter_status = filter_vehicle_opreaterId = filter_vehicle_manufecturerId = filter_modelId = filter_otometer = filter_otometer_val = '';
            filter_companyId = $('#filter_companyId').val();
            filter_warehouseId = $('#filter_warehouseId').val();
            filter_cityId = $('#filter_cityId').val();
            filter_status = $('#filter_status').val();
            filter_vehicle_opreaterId = $('#filter_vehicle_opreaterId').val();
            filter_vehicle_manufecturerId = $('#filter_vehicle_manufecturerId').val();
            filter_modelId = $('#filter_modelId').val();
            filter_operatorId = $('#filter_operatorId').val();
            filter_otometer = $('#filter_otometer').val();
            filter_otometer_val: $('#filter_otometer_val').val();

            
            $(".response").show();
            $("#customer_data").hide();
            document.getElementsByClassName('response').innerHTML = loader;
            let url = '{{url('Vehicles/Search')}}';
            var postData = {
                filter_companyId: filter_companyId,
                filter_warehouseId: filter_warehouseId,
                filter_cityId: filter_cityId,
                filter_status: filter_status,
                filter_vehicle_opreaterId: filter_vehicle_opreaterId,
                filter_vehicle_manufecturerId: filter_vehicle_manufecturerId,
                filter_modelId: filter_modelId,
                filter_otometer: filter_otometer,
                filter_otometer_value: $('#filter_otometer_val').val(),
                _token: "{{ csrf_token() }}",
            }; 
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) { 
                    if(filter_companyId > 0)
                        $('#reminder').show();
                    else
                        $('#reminder').hide();
                    $('#customer_data').DataTable().clear();
                    $('#customer_data').DataTable().rows.add($(data)).draw();
                    $(".response").hide();
                    $("#customer_data").show();
                    $("#links_btn").hide();
                    $('#pre_loader').hide();
                },
                error: function (jqXHR, status, error) {
                    alert(status + ": " + error);
                }
            });
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