@extends('layout2')
@section('content')
@section('title', 'Vehicles Report')
<div class="modal fade" id="info_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 30px">
                    <div class="col-lg-12">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <TH>Plate</TH>
                                <TH>Status</TH>
                                <TH>Start Date</TH>
                                <TH>End Date</TH>
                                <TH>Days</TH>
                            </thead>
                            <tbody id="report_body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
                                                <label for="country" class="form-label">City </label>
                                                <select id="filter_cityId" name="filter_cityId" class="form-control" onchange="loadVehicles(this.value)" >
                                                    <option value=""></option>
                                                    @foreach($lkp_city as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name_en }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Vehicles </label>
                                                <select id="filter_vehicleId" name="filter_vehicleId" class="form-control" >
                                                        <option value="">Select Vehicle</option>

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
                                                <label for="country" class="form-label">Vehicle Manufecturer </label>
                                                <select name="filter_vehicle_manufecturerId" id="filter_vehicle_manufecturerId"
                                                        class="form-control" onchange="loadModels()" required>
                                                    <option value="">Select Vehicle Manufecturer</option>
                                                    @foreach($manufacturers as $manufacturer)
                                                    <option value="{{$manufacturer->id}}">{{$manufacturer->name_en}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Vehicle Model </label>
                                                @php $options = "<option value=''>Select Vehicle Model</option>"; @endphp
                                                <select name="filter_modelId" id="filter_modelId"
                                                        class="form-control" required>
                                                    <option value="">Select Vehicle Model</option>
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
                                                <label for="country" class="form-label">Status </label>
                                                <select id="filter_status" name="filter_status" class="form-control">
                                                    <option value="availabe">Available</option>
                                                    <option value="damaged">Damaged</option>
                                                    <option value="delegeted">Delegeted</option>
                                                    <option value="maintenance">Maintenance</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-12">
                                            <label for="country" class="form-label">Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar4"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker-range" id="filter_date" name="filter_date" value="">
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
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="confirmSearch()" id="filter">{{__('drivers.Search')}}</button>
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
                    <div class="card-title">Vehicles Report</div>
                </div>
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;">By this module, you can see the report/history of vehicles for a specific date range.</div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
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
                                    <TH>Sr. No</TH>
                                    <TH >City</TH>
                                    <TH >Plate</TH>
                                    <TH >Modal</TH>
                                    <TH >Manufecturer</TH>
                                    <TH >Operator</TH>
                                    <TH >Status</TH>
                                    <TH >Start Date</TH>
                                    <TH >End Date</TH>
                                    <TH >Count</TH>
                                    <TH >Days</TH>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot id="report_foot"></tfoot>
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
            $('#filter_date').val('');
            $('#filter_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            let sOption = `@php echo $options @endphp`;
            function loadModels() {
                var selectedOption = document.getElementById('filter_vehicle_manufecturerId').value;

                var filter_vehicle_manufecturerId = document.getElementById('filter_vehicle_manufecturerId').value;
                if (filter_vehicle_manufecturerId == "")
                    $('#filter_modelId').html(sOption);
                else {
                    $.getJSON("{{URL("/getMultipleVehicleModels")}}" + "/" + selectedOption, function (json) {
                        $('#filter_modelId').empty();
                        $('#filter_modelId').append($('<option>').text('Select Vehicle Model').attr('value', ""));
                        $.each(json, function (i, obj) {
                            $('#filter_modelId').append($('<option>').text(obj.name_en).attr('value', obj.id));
                        });
                    });
                }
            }
            function loadVehicles(cityId) {

                var filter_vehicle_manufecturerId = document.getElementById('filter_vehicle_manufecturerId').value;
                if (cityId == "") {
                    $('#filter_vehicleId').empty();
                    $('#filter_vehicleId').append($('<option>').text('Select Vehicle').attr('value', ""));
                } else {
                    $.getJSON("{{URL("/getCityVehicles")}}" + "/" + cityId, function (json) {
                        $('#filter_vehicleId').empty();
                        $('#filter_vehicleId').append($('<option>').text('Select Vehicle').attr('value', ""));
                        $.each(json, function (i, obj) {
                            $('#filter_vehicleId').append($('<option>').text(obj.plate).attr('value', obj.id));
                        });
                    });
                }
            }
            $(document).ready( function () {
                $('.type').hide();
                $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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
                    //searching: false,
                    responsive: true,
                    processing: true,
                    "pagingType": "full_numbers",
                    // "autoWidth": false,
                });

            });

            function card_change() {
                if (document.getElementById('card_box').className == "box box-primary") {
                    document.getElementById('card_box').className = "box box-primary collapsed-box";
                    document.getElementById('i_box').className = "fa fa-plus";
                    document.getElementById('box-body').style.display = 'none';
                } else {
                    document.getElementById('card_box').className = "box box-primary";
                    document.getElementById('i_box').className = "fa fa-minus";
                    document.getElementById('box-body').style.display = '';
                }
            }

            function confirmSearch() {
                if ($('#filter_cityId').val() == '' || $('#filter_date').val() == '') {
                    alert('Date and City Can not Be Empty');
                } else {
                    var filter_vehicle_opreaterId = filter_vehicle_manufecturerId = filter_modelId = filter_date = filter_vehicleId = filter_status = filter_cityId = '';
                    filter_vehicle_opreaterId = $('#filter_vehicle_opreaterId').val();
                    filter_vehicle_manufecturerId = $('#filter_vehicle_manufecturerId').val();
                    filter_modelId = $('#filter_modelId').val();
                    filter_cityId = $('#filter_cityId').val();
                    filter_date = $('#filter_date').val();
                    filter_vehicleId = $('#filter_vehicleId').val();
                    filter_status = $('#filter_status').val();

                    $("#response").show();
                    $("#customer_data").hide();
                    let url = '{{url('New-Portal/Vehicles/ReportSearch')}}';
                    var postData = {
                        filter_vehicle_opreaterId: filter_vehicle_opreaterId,
                        filter_vehicle_manufecturerId: filter_vehicle_manufecturerId,
                        filter_modelId: filter_modelId,
                        filter_cityId: filter_cityId,
                        filter_date: filter_date,
                        filter_vehicleId: filter_vehicleId,
                        filter_status: filter_status,
                        _token: "{{ csrf_token() }}",
                    };
                    $.ajax({
                        url: url,
                        type: "POST",
                        cache: false,
                        data: postData,
                        success: function (data) {
                            $('#customer_data').DataTable().clear();
                            $('#customer_data').DataTable().rows.add($(data)).draw();
                            $("#response").hide();
                            $("#customer_data").show();
                        },
                        error: function (jqXHR, status, error) {
                            alert(status + ": " + error);
                        }
                    });
                }
            }

            function reset_records() {
                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_cityId').val('');
                $('#filter_date').val('');
                $('#filter_type').val('0');
                $('.type').hide();
                $('#filter_vehicleId').val('');
                $('#filter_status').val('availabe');
            }
            function showInfo(vehicle_id) {
                $('#info_modal').modal('toggle');
                let url = '{{url('New-Portal/Vehicles/ReportData')}}';
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: {
                        period: $('#filter_date').val(),
                        status: $('#filter_status').val(),
                        vehicle_id: vehicle_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        if (data == '')
                            $("#report_body").html('<tr><td colspan="5"><center>No data found!</center></td></tr>');
                        else
                            $("#report_body").html(data);
                    },
                    error: function (jqXHR, status, error) {
                        alert(status + ": " + error);
                    }
                });
            }
        </script>
    @stop
@endsection

