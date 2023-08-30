 
@extends('AdminLTE')
@section('title','Upload Daily Load')
@section('content') 
<style>
    .btn-info {
        background-color: #155261;
        border-color: #444;
    }
    .btn-info:hover {
        background-color: #1a6173;
        border-color: #444;
    }
    .subHeader{
        background-color: #c14232;
        color: #fff;
        width: 82%;
        border-radius: 7px;
        padding: 7px;
        text-align: center;
        margin: 0 auto;
        box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
    }
    .textLeft{
        text-align: left !important;
    }
    .salary12{
        display:none;
    }
</style>
<div style="width:100%;text-align: center;">
    <progress id="file" value="{{$options['processBar']}}" max="100" style="width: 97%;"> {{$options['processBar']}}% </progress>
</div>
<link rel="stylesheet" href="{{asset('dropAndDrag/style.css')}}">
<style>
    td,th{
        text-align:center
    }
</style>



    <!-- Update Warehose Info -->     
        <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
            <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
                <div class="w3-center"><br>
                    <span onclick="document.getElementById('edit_modal').style.display='none'"
                        class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                        title="Close Modal">&times;</span>
                </div>

                <div style="width:100%;clear:both;" id="response">
                </div>
                <br>
                <br>
            </div>
        </div>
        <div id="delete_modal" class="w3-modal">
            <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
                <div class="w3-center"><br>
                    <span onclick="document.getElementById('delete_modal').style.display='none'"
                        class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                        title="Close Modal">&times;</span>
                </div>
                <header class="w3-container w3-text-indigo w3-margin-top-64">
                    <h1>Delete</h1>
                </header>
                <form class="w3-container" action="" method="POST" id="delete_form">
                    {{method_field('DELETE')}}
                    @csrf
                    <div class="w3-section">
                        <p>Are you sure, you want to delete <span id="delete_name"></span> ?</p>
                        <div class="w3-center">
                            <button type="submit" class="w3-btn w3-indigo"> Delete</button>
                        </div>
                    </div>
                </form>
                <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                    <button onclick="document.getElementById('delete_modal').style.display='none'" type="button"
                            class="w3-btn w3-red">Cancel
                    </button>
                </div>
            </div>
        </div>
    <!-- Update Warehose Info -->

    <!-- Modal Warehouse-->
    <div class="modal fade" id="warehouseEditModal" tabindex="-1" role="dialog" aria-labelledby="warehouseEditModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warehouseEditModal">warehouseEditModal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="responseWarehose">
                <form>
                    <div class="form-group">
                        <label for="warehouseInputEmail1">Warehose Name</label>
                        <input type="text" name="warehouseName" disabled class="form-control" id="warehouseInputEmail1" aria-describedby="warehouseHelp" placeholder="Enter Warehouse name" required>
                    </div>
                    <div class="form-group">
                        <label for="priceInputEmail1">Delivery price(Saturday-Friday)</label>
                        <input type="number"  min="1" max="20" name="warehousePrice" id ="warehousePrice"class="form-control" id="priceInputEmail1" aria-describedby="priceHelp" placeholder="Enter Delivery price" required>
                    </div> 
                     
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editConfirmBtn" onclick="updateWarehouse()">Update </button>
            </div>
            </div>
        </div>
    </div>
    <!-- end Modal warehouse -->
    @if($options['step'] == 'check-DA' || $options['step'] == 'Check-warehouse')
        <!-- Modal Check DA  -->
        <style>
            .modal-body th{ 
                width: 30%; 
            }
            .modal-body td,th{
                text-align: center;
                border: 1px solid black;
            }
            .modal-body .table > thead > tr > th { 
                border-bottom: 1px solid black;
            }
            .certrilize{
                width: 97%;
                margin: 0 auto;
                margin-bottom: 10px;
            }
        </style>
    @endif
    @if($options['step'] == 'Check-warehouse') 
        <!-- Modal Confirm Warehose-->
            <div class="modal fade" id="warehouseModal" tabindex="-1" role="dialog" aria-labelledby="warehouseModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="warehouseModalLabel">Adding Warehose</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                        <!-- <span aria-hidden="true">&times;</span> -->
                        </button>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                    <img  src="{{url('images/loading.gif')}}" id="warehoseLoding" style="width: 100%; margin: 0 auto;display:none;" alt="" srcset="">
                    <img  src="{{url('images/sucsussfulCheck.gif')}}" id="warehoseDone" style="width: 100%; margin: 0 auto;display:none;" alt="" srcset="">
                         
                        <button id="continuoeNextBtn" style="display:none;text-align: center; margin: 10px; width: 66%;" class="btn btn-primary">Continue</button>
                        <table class="table table-dark" id="warehouseTable">
                            <thead>
                                <tr style="background-color: #000; color: white;">
                                    <th>Header </th>
                                    <th>Value </th>
                                </tr>
                                <tr>
                                <th scope="col">Warehose name</th>
                                <td><p  id="warehoseName"></p></td> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr> 
                                    <th scope="col">Selected Company</th>
                                    <td><p  id="companyName"></p></td> 
                                </tr> 
                                <tr>
                                    <th scope="col">Selected City</th>
                                    <td><p id="cityName"></p></td> 
                                </tr> 
                                <tr>
                                    <th scope="col">Status</th> 
                                    <td><p id="status_id"></p></td>
                                    
                                </tr> 
                                <tr>
                                    <th scope="col">Delivery Price</th>
                                    <td><p id="delivery_price"></p></td> 
                                </tr> 
                                <tr>
                                    <th scope="col">CreateStamp </th>
                                    <td><p>{{Auth::user()->name}},@php   $mytime = Carbon\Carbon::now(); echo $mytime->toDateTimeString();   @endphp  </p></td> 
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer" id="warehouseTable2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="ConfirmBtn" onclick="storeWarehouse()">Confirm</button>
                    </div>
                    </div>
                </div>
            </div> 
        <!-- Modal Confirm Warehose-->
    @endif
    <!-- bellow registered da modal -->
    @if($options['step'] == 'check-DA')
        <!-- Modal -->
        <div class="modal fade" id="registeredDaModal" tabindex="-1" role="dialog" aria-labelledby="registeredDaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registeredDaModalLabel">Registered DA List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">HUB Name</th>
                                <th scope="col">Company</th>
                                <th scope="col">DA Name</th>
                                <th scope="col">AMP</th>
                                <th scope="col">DA Type</th>    
                                <th colspan="2">addtional info</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($payload['registeredDA'] as $index=>$driver)
                        
                                <tr>
                                    <td scope="col" >{{$index + 1}}</td>  
                                    <td scope="col" >{{$driver['hub_name']}}</td>  
                                    <td scope="col"> 
                                         {{$driver['extraDate']->company_name}} 
                                    </td>
                                    <th scope="col">{{$driver['daName']}} </th>
                                    <th scope="col">{{$driver['amp']}} </th>
                                    <th scope="col">{{$driver['driver_type']}}</th>
                                    @if($driver['driver_type'] == 'Monthly Salary')
                                        <th>
                                            @if($driver['fuel_per_day'] == '')
                                               <span style="color:red">NULL</span>
                                            @else

                                            {{$driver['fuel_per_day']}} 

                                            @endif
                                            SAR                                        
                                        </th>
                                        <th>
                                            @if($driver['basic_salary'] == '')
                                               <span style="color:red">NULL</span>
                                            @else

                                            {{$driver['basic_salary']}} 

                                            @endif 
                                            SAR
                                        
                                        </th>
                                    @else
                                        <th colspan="2">
                                            @if($driver['extraDate']->deliveryPrice == '' || $driver['extraDate']->deliveryPrice == 0)
                                               <span style="color:red">NULL</span>
                                            @else

                                            {{$driver['extraDate']->deliveryPrice}}

                                            @endif 
                                            
                                        </th>

                                    @endif
                                </tr>
                        @endforeach
                        </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
                </div>
            </div>
        </div>

    @endif
    @if($options['step'] == 'check-DA')
        <!-- Modal Check DA  -->

        <div class="modal fade" id="daConfirmModal" tabindex="-1" role="dialog" aria-labelledby="daConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="daConfirmModalLabel">Confirm DA Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-dark">
                        <thead>
                            <tr style="background-color: #000; color: white;">
                                <th class="textLeft">Header </th>
                                <th>Value </th>
                            </tr> 
                        </thead>
                        <tbody>
                            <tr> 
                                <th scope="col"class="textLeft">Driver Name</th>
                                <td>
                                    <p id="daName"></p>
                                </td> 
                            </tr> 
                            <tr>
                                <th scope="col"class="textLeft">Driver AMP</th>
                                <td>
                                    <p id="daAMP"></p>
                                </td> 
                            </tr> 
                            <tr>
                                <th scope="col"class="textLeft">Driver Contract type </th> 
                                <td>
                                    <p id="daType"></p>
                                </td> 
                            </tr> 

                            <tr id="salarySection" style="display:none;">
                                <th scope="col"class="textLeft">Salary</th>
                                <td>
                                    <p id="daSalary"></p>
                                </td>
                                
                            </tr> 
                            <tr id="salarySection1" style="display:none;">
                                <th scope="col"class="textLeft">Fuel per day </th>
                                <td>
                                    <p id="daFuel"></p>
                                </td>

                                
                            </tr> 
                            <tr>
                                <th scope="col"class="textLeft">Company </th>
                                <td>
                                    <p id="daCompany">Noon</p>
                                </td>
                                
                            </tr> 
                            <tr>
                                <th scope="col"class="textLeft">Warehose </th>
                                <td>
                                    <p id="daWarehouse">RUH Staion</p>
                                </td>
                                
                            </tr>  
                            <tr>
                                <th scope="col"class="textLeft">Created By </th>
                                <td>
                                    <p><span style="color: #04c;">{{Auth::user()->name}}</span> </p>
                                </td>
                                
                            </tr> 
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="hidden" name="DriverIndex" id="DriverIndex">
                    <button type="button" class="btn btn-primary" name="confirmAddNewDA_BTN" onclick="confirmAddNewDA()">Confirm DA Info</button>
                </div>
                </div>
            </div>
        </div>
        <!-- end Modal Check DA  -->
    @endif

    @if($options['step'] == 'initialize')
        <div style="width: 88%; margin: 0 auto;">
            <h5 class="certrilize" style="margin-top: 14px; ">- Upload the dailyload Excel sheet</h5>
            <p class="certrilize">  Drop file Bellow or click on the squire to choose file and continue </p>
            <form action="{{url('Import_DA_Dailyload/validate')}}" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="drop-zone">
                    <span class="drop-zone__prompt">Drop file here or click to upload</span>
                    <input type="file" name="myFile" class="drop-zone__input" style="display:none">
                </div>  
                <!--<a href="{{url('Import_DA_Dailyload/step/Check-warehouse')}}">Next</a>-->
                <input type="submit" value="Confirm" class="btn btn-info" style="float: right; margin-top: 32px; margin-right: 53px;">
            </form>
        </div>
    @endif

    @if($options['step'] == 'Check-warehouse')
        <h5 class="certrilize">- Checking warehouses </h5>
        <p class="certrilize">  On this page you have to add bellow warehouse in order to continue </p>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$Result['registered_warehoses']}} </h3>

              <p>Total registered warehouse</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$Result['unregistered_warehouse_qty']}} </h3>

              <p>Total Unregistered warehouse</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"><span style="font-size: 45px;">+</span></i>
            </div>
            <!-- <a hrefs"#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div> 
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{$Result['total_warehouse_qty']}}</h3>

              <p>Total Report warehouses</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <!-- <a hrefs"#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        
        <table class="table" id="myTable" style="margin: 0 auto;width: 97%;">
            <thead class="thead-dark">
                <tr style="background-color: #0d4a2dd6; color: #e8e5e5;">
                <th scope="col" >#</th>  
                <th scope="col">New HUB Name</th>  
                <th scope="col">Company </th>
                <th scope="col">City </th>
                <th scope="col">Ststus</th>
                <th scope="col">Saturday-Friday Prices</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody> 
                @foreach($Result['payload'] as $k=>$payload)
                    <input type="hidden" name="filePath" value="{{$options['filePath']}}">
                    @if($k%2 == 0) 
                        <tr id="row{{$k}}">
                            <th scope="row" style="border: 1px solid #f4f4f4;">{{$k+1}}</th>
                            <td><p class="subHeader">{{$payload}}</p></td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleFormControlSelect2">Select Company</label> -->
                                    <select class="form-control" id="selectCompany{{$k}}" name="selectCompany$k">
                                        <option disabled selected value="NULL">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->companyName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleFormControlSelect2">Select City</label> -->
                                    <select class="form-control" id="selectCity{{$k}}" name="selectCity{{$k}}">
                                        <option disabled selected >Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleFormControlSelect2">Select City</label> -->
                                    <select class="form-control" id="selectedStatus{{$k}}" >
                                        <option disabled selected >Select Status</option>
                                        <option value="0">inctive</option>
                                        <option value="1">active</option>
                                        <option value="2">Vacation</option>
                                        <option value="3">On Hold</option>
                                        <option value="4">Terminated</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleInputEmail1"></label> -->
                                    <input type="number" class="form-control"  min="1" id="deleiveryPrice{{$k}}" style="width: 91%; margin: 0 auto;" placeholder="Delivery price per shpment">
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                            </td>
                            <td>
                                <a href="#" class="btn btn-info" style="width: 100%;" onclick="confirmAddingWarehouse({{$k}})">Add</a>
                            </td>
                        </tr> 
                    @else 

                        <tr style="background-color: #d9e5f4;">
                            <th scope="row" style="border: 1px solid #f4f4f4;">{{$k+1}}</th>
                            <td><p class="subHeader">{{$payload}}</p></td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleFormControlSelect2">Select Company</label> -->
                                    <select class="form-control" id="selectCompany{{$k}}" name="selectCompany$k">
                                        <option disabled selected>Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->companyName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleFormControlSelect2">Select City</label> -->
                                    <select class="form-control" id="selectCity{{$k}}" name="selectCity{{$k}}">
                                        <option disabled selected >Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleFormControlSelect2">Select City</label> -->
                                    <select class="form-control" id="selectedStatus{{$k}}" >
                                        <option disabled selected >Select Status</option>
                                        <option value="0">inctive</option>
                                        <option value="1">active</option>
                                        <option value="2">Vacation</option>
                                        <option value="3">On Hold</option>
                                        <option value="4">Terminated</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="exampleInputEmail1"></label> -->
                                    <input type="number" class="form-control" id="deleiveryPrice{{$k}}" min="1" aria-describedby="emailHelp" style="width: 91%; margin: 0 auto;" placeholder="Delivery price per shpment">
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                            </td>
                            <td>
                                <a href="#" class="btn btn-info" style="width: 100%;" onclick="confirmAddingWarehouse({{$k}})">Add</a>
                            </td>
                        </tr> 
                    @endif
                       

                @endforeach
                <tr style="background-color: #0d4a2dd6; color: #e8e5e5;">
                <th scope="col"> - </th>  
                <th scope="col"> - </th>  
                <th scope="col"> - </th>
                <th scope="col"> - </th>
                <th scope="col"> - </th>
                <th scope="col"> - </th>
                <th scope="col"> - </th>
                </tr>
                <tr>
                    <td colspan="7">
                        <!-- <a href="{{url('Import_DA_Dailyload/step/check-DA')}}" style="float: right;" class="btn btn-primary">Continue</a> -->
                    </td>
                </tr>
            </tbody> 
        </table> 
    @endif

    @if($options['step'] == 'check-DA')  
        @php    
            $generalNumbers = $payload['quntity'];  
        @endphp
        <style>
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                border: 1px solid #000000;
                border-top: 1px solid #000000 !important;
                text-align: center;
            }
        </style>
        <h5 class="certrilize" style="width: 97%;  margin: 0 auto;">- Checking New Drivers</h5>
        <p class="certrilize" style="width: 97%;  margin: 0 auto;margin-bottom: 8px;">  Add new DA and Specify their DA Type,Salary,Fuel per day </p>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$generalNumbers['qtyRegisteredDA']}} </h3>

              <p>Total registered DA</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a class="small-box-footer" data-toggle="modal" data-target="#registeredDaModal">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$generalNumbers['qtyUnregisteredDA']}} </h3>

              <p>Total unregistered/Need to be Update DA</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <!-- <a hrefs"#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{$generalNumbers['totalDA']}}</h3>

              <p>Total DA</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <!-- <a hrefs"#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <form action="{{url('Import_DA_Dailyload/bulk-DA')}}" method="post">
            @csrf
            <table class="table" style="margin: 0 auto;width: 97%;">
                <thead class="thead-dark">
                    <tr style="background-color: #0d4a2dd6; color: #e8e5e5;">
                        <th scope="col" >#</th>  
                        <th scope="col">HUB Name</th>  
                        <th scope="col">Company </th>
                        <th scope="col">City </th>
                        <th scope="col">Ststus</th>
                        <th scope="col">DA Name</th>
                        <th scope="col">DA AMP ID</th>
                        <th scope="col">DA Type</th>
                        <th scope="col" colspan="2">Extra Information</th> 
                        <!-- <th scope="col">Action</th> -->
                    </tr>
                </thead>
            

                    

                    <tbody>
                        @foreach($payload['unregisteredDA'] as $index=>$driver) 
                        
                        <input type="hidden" name="job_id[]" value="{{$driver['amp']}}">
                        <input type="hidden" name="fullName[]" value="{{$driver['daName']}}">
                        <input type="hidden" name="warehouseId[]" value="{{$driver['extraDate']->warehouse_id}}"> 
                        <input type="hidden" name="driverTypes[]" id="driverTypes{{$index}}" value="3"> 
                        <input type="hidden" name="file_id" value="{{$payload['file_info']['file_id']}}"> 
                        @php     
                            $extraDate = $driver['extraDate'];
                            $extraDate = $driver['extraDate'];  
                        @endphp
                        <tr>
                            <td scope="col" >{{$index + 1}}</td>  
                            <td scope="col" >
                                
                            @if($extraDate->deliveryPrice == 0)
                            <span style="color:red;font-weight:bold">
                                {{$extraDate->warehouseName}} 
                                <a onclick="editWarehose({{$index}},{{$extraDate->warehouse_id}},{{$extraDate->deliveryPrice}})" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>
                            </span> 
                            @else
                            {{$extraDate->warehouseName}} 

                            @endif 
                                
                            
                            </td>  
                            <td scope="col">{{$extraDate->company_name}} </td>
                            <td scope="col">{{$extraDate->city_name}} </td>
                            <td scope="col">
                            @if($driver['DaStatus'] == false)
                                <span class="badge bg-red">New</span>
                            @else
                                <span class="badge " style="background-color: #00a65a !important;" >Set DA Type</span> 
                            @endif
                            </td>
                            <td scope="col">{{$driver['daName']}}</td>
                            <td scope="col">{{$driver['amp']}}</td>
                            <td scope="col">
                                @foreach($options['driverTypes'] as $driver_type) 
                                    <div class="form-check" style="text-align: left;"> 
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="driverTypes{{$index}}" onchange="setDriver_type({{$index}},{{$driver_type->id}})" id="{{$index}}@if($driver_type->id == 3){{'shipment'}}@endif" value="{{$driver_type->id}}" @if($driver_type->id == 3) checked="checked" @endif required><label style="margin-left: 13px; font-size: 12px;">{{$driver_type->driver_type}} @if($driver_type->id !=2)( @if($extraDate->deliveryPrice == 0) <span style="color:red"> {{$extraDate->deliveryPrice}} </span> @else {{$extraDate->deliveryPrice}} @endif  Per Shipment) @endif</labels>
                                        </label>
                                    </div> 
                                @endforeach
                            </td>
                            
                                <td scope="col" class="salary12" id="fuelPerDay{{$index}}" width="11%">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Fuel per day (Optional)</label>
                                        <input type="number" class="form-control" id="fuelPerday{{$index}}" name="fuelPerday[]" aria-describedby="emailHelp" style="width: 91%; margin: 0 auto;text-align: center;" placeholder="Fuel per day">
                                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>
                                </td>
                                <td scope="col" class="salary12" id="salary{{$index}}" width="12%">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Basic salary (Mandatory)</label>
                                        <input type="number" name="salary[]" class="form-control" id="basicSalary{{$index}}" name="basicSalary{{$index}}" aria-describedby="emailHelp" style="width: 91%; margin: 0 auto;text-align: center;" placeholder="Basic salary">
                                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>
                                </td>
                            
                            
                                <td scope="col" colspan="2" id="shipment{{$index}}" >No Additional Info required</td> 
                            
                            <!-- <td scope="col"> <button class="btn btn-info" onclick="addNewDriver({{$index}})">Add</button></td> -->
                        </tr> 
                        @endforeach
                        <!-- <tr>
                            <td scope="col" >#</td>  
                            <td scope="col">HUB Name</td>  
                            <td scope="col">Company </td>
                            <td scope="col">City </td>
                            <td scope="col">Ststus</td>
                            <td scope="col">DA Name</td>
                            <td scope="col">DA AMP ID</td>
                            <td scope="col">DA Type</td>
                            <td scope="col">Fuel per day</td>
                            <td scope="col">Basic salary</td>
                            <td scope="col">BTNs</td>

                        </tr>   -->
                    </tbody> 
                
                <thead class="thead-dark">
                    <tr style="background-color: #0d4a2dd6; color: #e8e5e5;">
                        <th scope="col" >-</th>  
                        <th scope="col">-</th>  
                        <th scope="col">- </th>
                        <th scope="col">- </th>
                        <th scope="col">-</th>
                        <th scope="col">-</th>
                        <th scope="col">-</th>
                        <th scope="col">-</th>
                        <th scope="col">-</th>
                        <th scope="col"><input type="submit" value="Confirm"></th>
                        <!-- <th scope="col">-</th> -->
                    </tr>
                    <tr >
                        <th scope="col" colspan="11" style="border: none;">
                        <!-- <a href="{{url('Import_DA_Dailyload/step/preview-recoreds')}}" class="btn btn-primary" style="float: right;">Continue</a> -->
                        </th>   
                    </tr>
                </thead>
            </table> 
        </form>
    @endif

    @if($options['step'] == 'preview-recoreds') 
    
        <h5 class="certrilize" style="width: 97%;  margin: 0 auto;">- Preview Invoice recoreds details</h5>
        <p class="certrilize" style="width: 97%;  margin: 0 auto;margin-bottom: 8px;">  Here you can check the invoice for last time before commit an action to store recored to Bander system </p>
        <form action="{{url('/Import_DA_Dailyload/Store-invoice')}}" method="post">
            @csrf
            <table class="table" style="margin: 0 auto;width: 97%;">
                <thead class="thead-dark">
                    <tr style="background-color: #0d4a2dd6; color: #e8e5e5;">
                        <th scope="col" >#</th>  
                        <th scope="col">HUB Name</th>  
                        <th scope="col">AMP ID </th>
                        <th scope="col" style="    width: 1%;">DA Name </th>
                        
                        <th scope="col">Journal date</th>
                        <th scope="col" style="width: 1%;">No_of_TP </th>
                        <th scope="col" style="width: 1%;">reverse package</th>
                        <th scope="col" style="width: 1%;">Total No_of_TP</th>
                        <th scope="col">Driver Type</th>
                        <th scope="col" >Basic Salary</th>  
                        <th scope="col"> Calculate method </th>  
                        <th>Status Income</th>
                        <th scope="col" colspan="2">Net Amount </th>  
                    </tr>
                </thead>
                <tbody>
                    
                    @php    
                    $GrandTotal = 0;
                    $GrandShiment = 0;
                    $totalReverse_picked = 0;
                    $totalTotal_no_TP = 0;
                    $Total_no_TP = 0;
                    $credit = 0;
                    $debit = 0;
                    @endphp
                    
                    @foreach($payload['registeredDA'] as $k=>$recored)
                    @php 
                    
                    if($recored['driver_type'] == 'Monthly Salary'){
                            $GrandTotal = $GrandTotal+$recored['dayRate'];
                    }else{
                            $GrandTotal = $GrandTotal+number_format((float)($recored['Reverse_picked']+$recored['did'])*$recored['extraDate']->deliveryPrice, 2, '.', '');
                    }
                    $totalReverse_picked = $totalReverse_picked + $recored['Reverse_picked'];
                    
                    $Total_no_TP = $Total_no_TP + $recored['did']; 
                    $GrandShiment = $GrandShiment + ($recored['Reverse_picked']+$recored['did']);
                    @endphp
                        <tr>
                            <td scope="col" >{{$k+1}}</td>  
                            <td scope="col">{{$recored['hub_name']}} (<span style="color:red">{{$recored['extraDate']->deliveryPrice}} Per shipment</span> )</td>  
                            <td scope="col"> {{$recored['amp']}} <input type="hidden" name="amp[]" value="{{$recored['amp']}}"> <input type="hidden" name="DA_ids[]" value="{{$recored['driver_id']}}"></td>
                            <td scope="col">{{$recored['daName']}}<input type="hidden" name="daName[]" value="{{$recored['daName']}}"></td>
                            
                            <td scope="col">{{$recored['journal_date']}} <input type="hidden" name="journal_date[]" value="{{$recored['journal_date']}}"></td>
                            <td scope="col">{{$recored['did']}} </td>
                            <td scope="col">{{$recored['Reverse_picked']}}</td>
                            <td scope="col"><span style="background-color: #fbee00; border-radius: 49%;"> {{$recored['Reverse_picked']+$recored['did']}} <input type="hidden" name="totalPack[]" value="{{$recored['Reverse_picked']+$recored['did']}}"></span></td>
                            <td scope="col">{{$recored['driver_type']}}</td>
                            @if($recored['driver_type'] == 'Monthly Salary') 

                                <td scope="col"> {{$recored['basic_salary']}}   </td>
                                <td scope="col" > 
                                    {{$recored['dayRate']}}  * 1
                                </td>
                                <td>
                                    @php  
                                        $realIncome = ($recored['Reverse_picked']+$recored['did'])*$recored['extraDate']->deliveryPrice;
    
                                        $summryIncomeVsSalary = $realIncome - ($recored['basic_salary']/26); 
                                        $summryIncomeVsSalary = number_format((float)($summryIncomeVsSalary), 2, '.', '') ;
                                    @endphp


                                    @if($summryIncomeVsSalary>0) 
                                        <span style="color:green">
                                            @php   $credit = $credit+$summryIncomeVsSalary;    @endphp
                                            {{$summryIncomeVsSalary}} SAR <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        </span>
                                    @else 
                                        @php   $debit = $debit+$summryIncomeVsSalary;    @endphp
                                        <span style="color:red">
                                            {{$summryIncomeVsSalary}} SAR <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                        </span> 
                                    @endif
                                </td>
                            @else
                            
                            <td scope="col"  cplspan="2">{{$recored['extraDate']->deliveryPrice}}</td> 
                            <td scope="col"  cplspan="2">{{$recored['extraDate']->deliveryPrice}}*{{$recored['Reverse_picked']+$recored['did']}}</td> 
                            <td>
                                <span style="color:green">
                                {{number_format((float)($recored['Reverse_picked']+$recored['did']), 2, '.', '') }} 
                                 SAR <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                </span>
                            </td>
                            @endif 
                            
                            @if($recored['driver_type'] == 'Monthly Salary') 
                                
                                <td scope="col"  cplspan="2">

                                    <input type="number" id="editedNetSalary{{$k}}" name=''  style="display:none; width: 84px;"  value="{{$recored['dayRate']}}"> 
                                    <div  id="dayRate{{$k}}">
                                        <div id="dayRateLabel{{$k}}" style="margin-top: 5px;">
                                        {{$recored['dayRate']}} SAR
                                        </div>
                                        @if($summryIncomeVsSalary>0) 
                                        @else 
                                            <span style="color:blue;display:none;cursor: pointer;" id="dismissDayRate{{$k}}" onclick="dismissDayRate({{$k}},'')"><i style="    float: right; margin-top: 4px;" class="fa fa-times" aria-hidden="true"></i></span><br>
                                            <span style="color:blue;display:none;cursor: pointer;" id="dayRateBtnConfirm{{$k}}" onclick="ConfirmDayRate({{$k}},'')">(Confirm)</span>
                                            <span style="color:blue;cursor: pointer;" id="dayRateBtnChange{{$k}}" onclick="editDayRate({{$k}})">(Change)</span>
                                        @endif                                         
                                        <input type="hidden" name="netSalary[]" id="netSalary{{$k}}" value="{{$recored['dayRate']}}">
                                    </div>
                                </td> 
                            @else
                                <td scope="col"  cplspan="2"> {{number_format((float)($recored['Reverse_picked']+$recored['did'])*$recored['extraDate']->deliveryPrice, 2, '.', '') }} SAR <input type="hidden" name="netSalary[]" value="{{number_format((float)($recored['Reverse_picked']+$recored['did'])*$recored['extraDate']->deliveryPrice, 2, '.', '') }}"></td>  
                            @endif
                        </tr>  
                    @endforeach 
                </tbody> 
                <thead class="thead-dark">
                    <tr style="background-color: #0d4a2dd6; color: #e8e5e5;">
                            <th scope="col" ></th>  
                            <th scope="col">-</th>  
                            <th scope="col">- </th>
                            <th scope="col">- </th>
                            <th scope="col">-</th>
                            <th scope="col"> </th>
                            <th scope="col"> </th> 
                            <th scope="col"> </th>
                            <th scope="col">-</th>
                            <th scope="col">-</th>
                            <th scope="col">
                                Drop 
                                <span style="color:red">
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </span> 
                            </th>
                            <th scope="col">Benefit 
                                <span style="color:green">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                </span></th> 
                            <th scope="col">Grand Total</th>
                    </tr>
                    <tr style="background-color: #0d4a2dd6; color: #e8e5e5;">
                        <th scope="col" >{{$k+1}}</th>  
                        <th scope="col">-</th>  
                        <th scope="col">- </th>
                        <th scope="col">- </th>
                        <th scope="col">-</th>
                        <th scope="col">{{$Total_no_TP}}</th>
                        <th scope="col">{{$totalReverse_picked}}</th> 
                        <th scope="col">{{$GrandShiment}}</th>
                        <th scope="col">-</th>
                        <th scope="col">-</th>
                        <th scope="col">
                            
                            {{number_format((float)$debit, 2, '.', '') }} 
                            
                            SAR</th>
                        <th scope="col">{{number_format((float)$credit, 2, '.', '') }}  SAR</th> 
                        <th scope="col">{{$GrandTotal}} SAR</th>
                    </tr>
                    <tr >
                        <th scope="col" colspan="13" style="border: none;">
                        <button type="submit" class="btn btn-primary" style="float: right;">Continue</button>
                        </th>   
                    </tr>
                </thead>
            </table> 
        </form>
    @endif

    <!-- JS SCRIPTS ON CODITIONS -->
    @if($options['step'] == 'check-DA')
        <script> 

            function editWarehose(args,warehouse_id,deliveryPrice) {
                
                $('#editConfirmBtn').val(warehouse_id);
                $('#warehouseEditModal').modal('show');  
                var arrayFromPHP = <?php echo json_encode($payload['unregisteredDA']); ?>;
                // console.log(arrayFromPHP[args])
                arrayFromPHP = arrayFromPHP[args]; 
                
                $('#warehouseInputEmail1').val(arrayFromPHP['hub_name']);
               
                var deliveryPrice = arrayFromPHP['extraDate'];
                $('#warehousePrice').val(deliveryPrice['deliveryPrice']);
                // $('#priceInputEmail1').val(deliveryPrice['deliveryPrice']);
                // priceInputEmail1,,warehouseInputEmail1
                

                // $.ajax({
                //     type: 'GET',
                //     url: "#" + "/" + args + "/edit",
                //     contentType: "html",
                //     dataType: 'html',
                //     success: function (data) {
                //         document.getElementById('responseWarehose').innerHTML = data;
                       
                //         // document.getElementById('warehouseEditModal').style.display = 'block';
                //     }
                // });
            } 
            function setDriver_type(driver_id,valueee){
            // $('input[type=radio][name=driver_type]').change(function() {
                var radioValue = $("input[type='radio'][name='driverTypes"+driver_id+"']:checked").val();
                 
                 $('#driverTypes'+driver_id).val(radioValue)
                // var driver_id = $('input[type=radio][name=driver_type'+args+']').attr('id'); 
                // alert(driver_id);
                driver_id = driver_id;
                console.log('driver_id : '+driver_id);
                var salaryElementId = '#salary'+driver_id;
                var fuelPerDay = '#fuelPerDay'+driver_id;
                var shipmentElementId = '#shipment'+driver_id;
                if(valueee == 2){
                    // driver type is salary
                    // add required to input
                    $("#fuelPerday"+driver_id).prop('required',false); 
                    $("#basicSalary"+driver_id).prop('required',true);  
                    $(shipmentElementId).hide();
                    $(salaryElementId).show();
                    $(fuelPerDay).show();
                }else{
                    $("#fuelPerday"+driver_id).prop('required',false); 
                    $("#basicSalary"+driver_id).prop('required',false);  
                    $(shipmentElementId).show();
                    $(salaryElementId).hide();
                    $(fuelPerDay).hide();
                } 
                // if (this.value == 1) {
                //     // ...
                // }
                // else if (this.value == 'transfer') {
                //     // ...
                // }
            };
            function addNewDriver(args) {    
                // confirmAddNewDA_BTN
                // alert(args);
                $("#DriverIndex").val(args);
               
                
                // $('#confirmAddNewDA_BTN').val(args)
                var radioBtnValue = "input[name=driver_type"+args+"]:checked"; 
                radioBtnValue = document.querySelector(radioBtnValue).value;
                
                var checkboxName = 'driver_type'+args
                checkboxName = $('input[type=radio][name='+checkboxName+']').attr('id') 
                var arrayFromPHP = <?php echo json_encode($payload); ?>;
                var driverList = <?php echo json_encode($payload['unregisteredDA']); ?>;
                var warehouseId = '';
                var driverType = '';
                var fullName = '';
                var job_id = '';
                var status_id = ''; 
                driverList = driverList[args];
                var extraData = driverList['extraDate']; 


                
                if(radioBtnValue == 1 || radioBtnValue == 3){ 
                            $('#salarySection').hide()
                            $('#salarySection1').hide() 
                            $('#daName').text(driverList['daName']);
                            $('#daAMP').text(driverList['amp']); 
                            $('#daCompany').text(extraData['company_name']);
                            $('#daWarehouse').text(extraData['warehouseName']);
                            
                            $('#daType').text($('input:radio:checked').next('label:first').html());
                            // $('#daSalary').text($('#basicSalary'+args).val()+'.00 SAR'); 

                            $('#warehouseModal').modal('show');  
                            $('#daConfirmModal').modal('show'); 
                }else{
                    if($('#basicSalary'+args).val() == ''){
                        alert('Basic salary is Required ');
                    }else{ 
                            $('#salarySection').show()
                            $('#salarySection1').show() 
                            $('#daName').text(driverList['daName']);
                            $('#daAMP').text(driverList['amp']); 
                            $('#daCompany').text(extraData['company_name']);
                            $('#daWarehouse').text(extraData['warehouseName']);
                            $('#daType').text($('input:radio:checked').next('label:first').html());
                            $('#daSalary').text($('#basicSalary'+args).val()+'.00 SAR'); 
                            if($('#fuelPerday'+args).val() == ''){ 
                            }else{
                                $('#daFuel').text($('#fuelPerday'+args).val()+'.00 SAR'); 
                            }
                            $('#warehouseModal').modal('show');  
                            $('#daConfirmModal').modal('show'); 
                        // }
                    }
                }  

                // document.getElementById("ConfirmBtn").value = args;
                // $('#warehoseName').text(arrayFromPHP[args]); 
                
            }  
            function updateWarehouse(){
                var file_id = <?php echo json_encode($options['file_id']); ?>; 
                if($('#warehousePrice').val() != ''){ 
                    $.ajax({
                        type: 'post',
                        url: "{{URL('/Import_DA_Dailyload/Check-DA/updateWarehouse')}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",'warehouse_id':$('#editConfirmBtn').val(),'deliveryPrice':$('#warehousePrice').val()}, 
                        success: function (data) {
                            if(data['status'] == true){
                                $(location).prop("href", "{{url('/Import_DA_Dailyload/Check-DA')}}"+"/"+file_id)
                            }
                        }
                    });
                }else{
                    alert('Price empty');
                }
            }
            function confirmAddNewDA(){
                
                var args = $('input[name=DriverIndex]').val();
                // alert(args)
                var radioBtnValue = "input[name=driver_type"+args+"]:checked"; 
                radioBtnValue = document.querySelector(radioBtnValue).value;
                
                var checkboxName = 'driver_type'+args
                checkboxName = $('input[type=radio][name='+checkboxName+']').attr('id') 
                var arrayFromPHP = <?php echo json_encode($payload); ?>;
                var driverList = <?php echo json_encode($payload['unregisteredDA']); ?>;
               
                driverList = driverList[args];
                // alert(driverList['daName'])
                var extraData = driverList['extraDate'];  
                var warehouseId = extraData['warehouse_id'];
                var driverType = radioBtnValue; 
                var fullName = driverList['daName'];
                var job_id = driverList['amp'];
                var status_id = 1; 
                var payload = 
                {
                    job_id:job_id,
                    fullName:fullName,
                    warehouseId:warehouseId,
                    status_id:1,
                    driver_type_id:driverType,
                    basic_salary:null,
                    fuel_per_day:null
                };
                
                if(radioBtnValue == 1 || radioBtnValue == 3){
                }else{
                    if($('#basicSalary'+args).val() == ''){
                        alert('Basic salary is Required ');
                    }else{  
                        payload['basic_salary'] = $('#basicSalary'+args).val();
                            
                        if($('#fuelPerday'+args).val() == ''){ 
                        }else{ 
                            payload['fuel_per_day'] = $('#fuelPerday'+args).val()
                            // $('#daFuel').text($('#fuelPerday'+args).val()+'.00 SAR'); 
                        } 
                    }
                }
                $.ajax({
                        type: 'post',
                        url: "{{URL('/Import_DA_Dailyload/Check-DA/storeDriver')}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",payload}, 
                        success: function (data) {
                            if(data['status'] == true){
                                var file_id = <?php echo json_encode($options['file_id']); ?>; 
                                $(location).prop("href", "{{url('/Import_DA_Dailyload/Check-DA')}}"+"/"+file_id)
                            }
                        }
                    });
            }
        </script>
    @endif

    @if($options['step'] == 'Check-warehouse')
        <script>
            function confirmAddingWarehouse(args){
                var arrayFromPHP = <?php echo json_encode($Result['payload']); ?>;
                // console.log(arrayFromPHP[args]);
                // id is warehoseName 
                if($('#selectCompany'+args).find(":selected").text() == 'Select Company'){
                        alert("Select Company To continue");
                }else{
                    if($('#selectCity'+args).find(":selected").text() == 'Select City'){
                        alert("Select City To continue");
                    }else{
                        if($('#selectedStatus'+args).find(":selected").text() == 'Select Status'){
                            alert("Select Status To continue");
                        }else{
                            if($('#deleiveryPrice'+args).val() == 0 || $('#deleiveryPrice'+args).val() == ''){
                                alert("Select delivery Price To continue");
                            }else{
                                // ConfirmBtn
                                
                                document.getElementById("ConfirmBtn").value = args;
                                $('#warehoseName').text(arrayFromPHP[args]); 
                                $('#companyName').text($('#selectCompany'+args).find(":selected").text());
                                $('#cityName').text($('#selectCity'+args).find(":selected").text());
                                $('#status_id').text($('#selectedStatus'+args).find(":selected").text());
                                $('#delivery_price').text($('#deleiveryPrice'+args).val());
                                $('#warehouseModal').modal('show'); 
                            }
                        }
                    }
                } 
            }
            function storeWarehouse(){
                var filePath = '';
                $('#warehoseLoding').show() 
                $('#warehouseTable').hide()
                $('#warehouseTable2').hide()
                var arrayFromPHP = <?php echo json_encode($Result['payload']); ?>;
                var filePath = <?php echo json_encode($options['filePath']); ?>;
                var file_id = <?php echo json_encode($options['file_id']); ?>;
                console.log(file_id);
                var args = document.getElementById("ConfirmBtn").value;
                $('#warehoseName').text(arrayFromPHP[args]);
                $('#companyName').text($('#selectCompany'+args).find(":selected").text());
                $('#cityName').text($('#selectCity'+args).find(":selected").text());
                $('#status_id').text($('#selectedStatus'+args).find(":selected").text());
                $('#delivery_price').text($('#deleiveryPrice'+args).val()); 
                // document.getElementById("myTable").deleteRow(args+1);
                 
                $.ajax({
                    type: 'post',
                    url: "{{URL('/Import_DA_Dailyload/StoreWarehose')}}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{"_token": "{{ csrf_token() }}",'warehoseName':arrayFromPHP[args],'companyID':$('#selectCompany'+args).find(":selected").val(),'cityID':$('#selectCity'+args).find(":selected").val(),'status_id':$('#selectedStatus'+args).find(":selected").val(),'delivery_price':$('#deleiveryPrice'+args).val(),'currentIndex':args,'filePath':filePath,'file_id':file_id}, 
                    success: function (data) {
                        // console.log(data);
                        if(data['status'] == true){
                            if(data['DoneAddingWarehouse'] == false){
                                $('#warehoseLoding').hide() 
                                $('#warehoseDone').show() 
                                location.reload(); 
                            }else{
                                $('#warehoseLoding').hide() 
                                $('#warehoseDone').show() 
                                $('#continuoeNextBtn').show()
                                // location.reload(); 
                            }
                            
                            
                        }
                    }
                });
            }
            $( "#continuoeNextBtn" ).click(function() {
                var file = <?php echo json_encode($options);?>;
                $.ajax({
                    type: 'post',
                    url: "{{URL('/Import_DA_Dailyload/Check-Drivers')}}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{"_token": "{{ csrf_token() }}",'file_id':file['file_id'],'filePath':file['filePath']}, 
                    success: function (data) {
                        if(data['status']){
                            $(location).prop("href", "{{url('/Import_DA_Dailyload/Check-DA')}}"+"/"+file['file_id'])
                        }else{
                            alert('Error occured While storing driver on line : 1069');
                            $(location).prop("href", "{{url('/Import_DA_Dailyload/Check-DA')}}"+"/"+file['file_id'])
                        }
                    }
                });
            });

        </script>  
    @endif

    <script>
        function ConfirmDayRate(args) {
            console.log(args); 
            // dayRateLabel
            
            $('#dayRateLabel'+args).text($('#editedNetSalary'+args).val()+' SAR')
            $('#editedNetSalary'+args).hide();
            $('#dayRateLabel'+args).show();
            $('#dayRateBtnChange'+args).show();
            $('#dayRateBtnConfirm'+args).hide();
            $('#dismissDayRate'+args).hide(); 
            $('#dayRate'+args).show();
            document.getElementById("netSalary"+args).value = 10
        }
        function dismissDayRate(args){
            $('#editedNetSalary'+args).hide();
            $('#dayRateLabel'+args).show();
            $('#dayRateBtnChange'+args).show();
            $('#dayRateBtnConfirm'+args).hide();
            $('#dismissDayRate'+args).hide(); 
            $('#dayRate'+args).show();
        }
        function editDayRate(args) {
            // dayRate editedNetSalary 
            
            $('#editedNetSalary'+args).show();
            $('#dayRateLabel'+args).hide();
            $('#dayRateBtnChange'+args).hide();
            $('#dayRateBtnConfirm'+args).show();
            $('#dismissDayRate'+args).show();
            $('#editedNetSalary'+args).value();
            $('#dayRate'+args).hide();
            console.log(args)
        }
    </script>
    <!-- JS SCRIPTS ON CODITIONS -->
    <script src="{{asset('dropAndDrag/script.js')}}"></script> 
    <!-- partial -->
    <!--<script  src="{{asset('dropAndDrag/script.js')}}"></script>-->
@endsection