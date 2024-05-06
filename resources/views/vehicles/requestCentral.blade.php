@extends('AdminLTE')
@section('content')  
<link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">
   
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
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Vehicles Requests</h2>
        </div>
        @if(Auth::user()->user_type_id==1||session('Session_DriversCarrefour')=='yes')
            <div style="float:right;">
                {{-- <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Bulk Upload</a>
                </h2> --}}
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
                <TH >City</TH>
                <TH >Plate</TH>                
                <th scope="col">Vehicle </th> 
                <th scope="col">Opreater Company </th> 
                <th scope="col">DA </th>  
                <th scope="col">Request type </th>  
                <th scope="col">Request Date </th>  
                <th scope="col">Status</th>   
                <th scope="col">Vehicle check </th>
                <th>Identity Approvel</th>
                <th scope="col">Operations</th>  
            </thead>
            <tbody>
                @php    
                      
                @endphp  
                @foreach($payload as $k=>$item)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$item->city_name}}</td>
                        <td>{{$item->plate}}</td>
                        <td>
                            {{$item->vehicle_manufacturer_name}}, {{$item->vName}},{{$item->manufacturer_date}} 
                        </td>
                        <td>{{$item->opreatoers}}</td> 
                        <td>{{$item->fullName}}</td>
                        <td>
                            <span class="badge badge-warning"> 
                                {{$item->name_en}}
                            </span>
                        </td>
                        <td>{{$item->request_issue_date}}</td>
                        <td>
                            <span class="badge badge-info"> 
                                {{$item->status}}
                            </span> 
                        </td>
                        <td> 
                            <button>Preview</button>
                        </td>
                        <td>
                            <button>Preview</button>    
                        </td>
                        <td>
                            Issue Delegation  
                        </td> 

                    </tr>
                @endforeach
            </tbody>
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="border-left: 1px solid #08c !important;">#</th> 
                    <TH >City</TH>
                    <TH >Plate</TH>                
                    <th scope="col">Vehicle </th> 
                    <th scope="col">Opreater Company </th> 
                    <th scope="col">DA </th>  
                    <th scope="col">Request type </th>  
                    <th scope="col">Request Date </th>  
                    <th scope="col">Status</th>   
                    <th scope="col">Vehicle check </th>
                    <th>Identity Approvel</th>
                    <th scope="col">Operations</th>  
                </tr>
        </thead>
        </table>
    </div>
 
    <script src="{{asset('dropAndDrag/src/script.js')}}"></script> 
@endsection