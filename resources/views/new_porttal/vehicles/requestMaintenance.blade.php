@extends('layout2')
@section('content')
@section('title', 'Vehicles Maintenance Requests')

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
$module = "Vehicles Maintenance Requests";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')
<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle </h5>
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
<div class="modal fade" id="ViewDAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Driver </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="Dresponse">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="maintenanceRequest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DAIdentityApproveModalLabel">Maintenance Request Spare Parts </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link" onclick="showHide('requestData')" id="requestDataNav" href="#">Request Data</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="showHide('attachmentsData')" href="#" id="attachmentsCount" href="#"></a>
                    </li>

                  </ul>
                </div>
            </nav>
            <span id="maintenanceRequestBody">

            </span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <div class="card-title">Vehicles Maintenance Requests</div>
                </div>
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;">From this page you can view Vehicles Maintenance Requests. </div>
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
                            <table id="customer_data" class="table table-bordered" style="table-layout: fixed;">
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
                                    <th scope="col">Additional Data</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Action</th>
                                </thead>
                                <tbody id="tbl_body">
                                    @php $k = 0; @endphp
                                    @foreach($requests as $item)
                                        @php $k += 1; @endphp
                                        <tr>
                                            <td>{{$k}}</td>
                                            <td>{{$item->city_name}}</td>
                                            <td>
                                                @php
                                                preg_match_all('/\d+/', $item->plate, $matches);
                                                $numbersPart = implode('', $matches[0]);
                                                $remainingPart = trim(preg_replace('/\d+/', '', $item->plate));
                                                @endphp
                                                <table><tbody><tr><td style="border: 1px solid;">{{$numbersPart}}</td><td style="border: 1px solid;">{{$remainingPart}}</td></tr></tbody></table>
                                            </td>
                                            <td>
                                                {{$item->color}}, {{$item->vehicle_manufacturer_name}}, {{$item->vName}}, {{$item->manufacturer_date}}
                                            </td>
                                            <td> {{$item->opreatoers}}</td>
                                            <td>{{$item->fullName}},  <span style="color:red">{{$item->job_id}}</span> <span><a href="javascript:driver('{{$item->driver_id}}')"><i class="bi bi-eye"></i></a></span></td>
                                            <td style="text-align: center;">
                                                N/A
                                            </td>
                                            <td>
                                                <span class="badge badge-warning" style="color: #056748;background-color: #ffffff;padding: 8px;margin: 4px;border: 1px solid #dcdcdc;">
                                                    <img style="width: 30px; margin-bottom: 0px;" src="https://i.ibb.co/6cY31vKb/maintenance-icon-18893.png" alt="maintenance-icon-18893" border="0" />Maintenance Request
                                                </span>
                                            </td>
                                            <td> {{ \Carbon\Carbon::parse($item->request_issue_date)->format('j F, Y') }} </td>
                                            <td>
                                                @if($item->status == 'done')
                                                    <span class="label label-success">
                                                        Approved
                                                    </span>
                                                @else
                                                    <span class="label label-danger">
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <p>Last Check-Up Date: @if ($item->last_checkUp == 'N/A') N/A @else {{ \Carbon\Carbon::parse($item->last_checkUp)->format('j F, Y') }} @endif</p>
                                            </td>
                                            <td>
                                                <textarea name="note" rows="5" disabled>{{$item->internal_note}}</textarea>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" type="button" onclick="viewParts({{$item->id}})" data-toggle="modal" data-target="#maintenanceRequest">View</button> &nbsp;&nbsp;
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <TH >City</TH>
                                        <TH >Plate</TH>
                                        <th scope="col">Vehicle </th>
                                        <th scope="col">Opreater Company </th>
                                        <th scope="col">DA </th>
                                        <th scope="col">DA Approval </th>
                                        <th scope="col">Request type </th>
                                        <th scope="col">Request Date </th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Additional Data</th>
                                        <th scope="col">Note</th>
                                        <th scope="col">Action </th>
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
        function viewParts(request_id) {
            $.ajax({
                type: 'POST',
                url: "{{url('New-Portal/Vehicles/maintenanceInfo')}}",
                cache: false,
                data: {
                    request_id: request_id,
                    page: 'maintenance',
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    data = data.split(":::");
                    document.getElementById('maintenanceRequestBody').innerHTML = data[1];
                    $('#attachmentsCount').html("Attachments ("+data[0]+")");
                }
            });
        }
        function showHide(type) {
            $('#requestData').hide();
            $('#attachmentsData').hide();
            setTimeout(function() {
                $('#'+type).show();

            }, 1000);
        }
        function imageModal(the) {
            console.log(the.src);
            document.getElementById('edit_modal').style.display = 'block';
            let html = `<img style="width: inherit;" src="`+the.src+`">`;
            document.getElementById('response').innerHTML = html;
        }
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

        $(document).ready(function () {

            fill_datatable();
            function fill_datatable() {
                var counter = 0;
                var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "All"]],
                    serverSide: false,
                    dom: 'lBfrtip',
                    scrollX: true,
                    columnDefs: [
                        {
                            targets: [3,4,5,6,8,9,10],
                            width: '150px'
                        }
                    ],
                });
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
                fill_datatable();
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
        function driver(id) {
            $('#ViewDAModal').modal('toggle')
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('Dresponse').innerHTML = data;
                }
            });

            // ViewDAModal on click #edit_modalCancelBtn
        }
        </script>
    @stop
@endsection

