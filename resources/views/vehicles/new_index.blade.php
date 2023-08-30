@extends('AdminLTE')
@section('content')  
<link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">

<!-- Vehicle extra data Modal -->

@php
$company_name = request()->route('companyName');
$warehouse_name = request()->route('warehouseName');
$city_name = request()->route('city_name');
$type = request()->route('type');
@endphp
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
        
    </div>
    <!-- end of header -->
    <div class="card card-default" style="width:100%;clear:both;"></div>

        <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary ">
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
                                @if($company->companyName == $company_name)
                                <option selected value="{{$company->id}}">{{$company->companyName}}</option>
                                @else
                                <option value="{{$company->id}}">{{$company->companyName}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                        <TH>Warehouse</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control" style="width:200px;">
                                <option value="">{{$warehouse_name}}</option>
                                
                            </select>
                        </td>
                        <TH>City</TH>
                        <td>
                            <select name="filter_cityId" id="filter_cityId"
                                    class="form-control" style="width:200px;" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                @if($city->name_en == $city_name)
                                <option selected value="{{$city->id}}">{{$city->name_en}}</option>
                                @else
                                <option value="{{$city->id}}">{{$city->name_en}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td> 
                        <TH>Status</TH>
                        <td>
                            <select id="filter_status" name="filter_status" class="form-control"
                                    style="width:200px;"> 
                                <option value="">Select Status</option>
                                <option {{$type == 'available' ? 'selected' : ''}} value="availabe">Available</option>
                                <option {{$type == 'damaged' ? 'selected' : ''}} value="damaged">damaged</option>
                                <option {{$type == 'done_attendance' || $type == 'maintenance_' || $type == 'pending_attendance' || $type == 'present' || $type == 'absent_ex' || $type == 'absent_no_ex' ? 'selected' : ''}} value="delegeted">Delegated</option>
                                <option {{$type == 'maintenance' ? 'selected' : ''}} value="maintenance">Maintenance</option>
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
                            <input type="number" name="filter_otometer_value" id="filter_otometer_value"
                                    class="form-control" style="width:100px;" required>
                        </td>
                        
                    </tr>
                   
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info" onclick="confirmSearch()">Filter</button>

                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default" onclick="reset_records()">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <div class="table-responsive" style="width: 100%;">
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
                <th scope="col">Vehicle Otometer </th> 
                <th scope="col">Registertion type </th>  
                <th scope="col">Vehicle status </th>  
                <th scope="col">Maintenance Location </th>
            </thead>
            <tbody>
                @php $no = 0; @endphp
                @foreach ($payload as $k=>$item) 
                    @if(null !== request()->route('city_name'))
                        @php if ($item->name_en != request()->route('city_name'))
                            continue;
                        @endphp
                    @endif
                    <tr>
                        <td scope="col">{{++$no}}</td>
                        <td scope="col">{{$item->plate}} </td>
                        <td scope="col"><center>{{$item->expiry_days}} </center></td>
                        <td scope="col">{{$item->name_en}} </td>
                        <td scope="col">{{$item->vehicle_manufacturer}} </td>
                        <td scope="col">{{$item->vehicle_model}}, {{$item->manufacturer_date}}</td> 
                        <td scope="col">{{$item->vehicle_opreator}} </td> 
                        <td scope="col">{{$item->color}} </td> 
                        <td scope="col">{{$item->vehicle_registration_expire_date}} </td>  
                        <td scope="col">{{$item->otometer}} </td> 
                        <td scope="col"> {{$item->registertion_type}} </td> 
                        <td scope="col"> {{$item->current_status}}  </td> 
                        <td scope="col"> {{$item->maintenance_location}}  </td> 
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
                    <th scope="col">Vehicle Otometer </th> 
                    <th scope="col">Registertion type </th>  
                    <th scope="col">Vehicle status </th>  
                    <th scope="col">Maintenance Location </th>
                </tr>
        </thead>
        </table>
    </div>
    
    <script>

        
        $(document).ready( function () {
            $('#customer_data').DataTable();
        });
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
        function confirmSearch(){ 
            var city_name = '{{$city_name}}';
            var filter_companyId = filter_warehouseId = filter_cityId = filter_status = filter_vehicle_opreaterId = filter_vehicle_manufecturerId = filter_modelId = filter_otometer = filter_otometer_value = '';
            filter_companyId = $('#filter_companyId').val();
            filter_warehouseId = $('#filter_warehouseId').val();
            filter_cityId = $('#filter_cityId').val();
            filter_status = $('#filter_status').val();
            filter_vehicle_opreaterId = $('#filter_vehicle_opreaterId').val();
            filter_vehicle_manufecturerId = $('#filter_vehicle_manufecturerId').val();
            filter_modelId = $('#filter_modelId').val();
            filter_operatorId = $('#filter_operatorId').val();
            filter_otometer = $('#filter_otometer').val();
            filter_otometer_value: $('#filter_otometer_value').val();

            
            $(".response").show();
            $("#customer_data").hide();
            // document.getElementsByClassName('response').innerHTML = loader;
            let url = '{{url('Vehicles/Search')}}';
            var postData = {
                city_name: city_name,
                filter_companyId: filter_companyId,
                filter_warehouseId: filter_warehouseId,
                filter_cityId: filter_cityId,
                filter_status: filter_status,
                filter_vehicle_opreaterId: filter_vehicle_opreaterId,
                filter_vehicle_manufecturerId: filter_vehicle_manufecturerId,
                filter_modelId: filter_modelId,
                filter_otometer: filter_otometer,
                filter_otometer_value: filter_otometer_value,
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
            $('#filter_otometer_value').val('');
        }
    </script>
    <script src="{{asset('dropAndDrag/src/script.js')}}"></script> 
@endsection