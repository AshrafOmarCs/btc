@extends('layout2')
@section('content')
@section('title', 'Jahiz Claims')

<!-- Modal ExportExcel 3 -->
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
                                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control">
                                                <option value=""></option>
                                                @foreach($warehouse as $warehousee)
                                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">EMP ID </label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Driver Type </label>
                                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_driver_type as $lkp_driver_typee)
                                                    <option
                                                        value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Driver </label>
                                            <span class="d-flex">
                                                <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                                                <input class="form-control" name="filter_driverId_input"
                                                id="filter_driverId_input" type="text" value="" readonly>
                                                <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                                    Select
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">Claim Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_claim_dt" name="filter_claim_dt">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">Last SettledDate</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_lastSettlementDate" name="filter_lastSettlementDate">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Claim Status </label>
                                            <select id="filter_claim_status_id" name="filter_claim_status_id" placeholder="Select ..." class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_claim_status as $lkp_claim_statuss)
                                                    <option
                                                        value="{{$lkp_claim_statuss->id}}">{{$lkp_claim_statuss->status_txt}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Image PromissoryNote </label>
                                            <select name="filter_Image_PromissoryNote" id="filter_Image_PromissoryNote" class="form-control">
                                                <option value=""></option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">Created_At</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_created_at" name="filter_created_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">Updated_At</label>
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
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal" id="reset">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>
@php
$array = [
    0=>'Company',
    1=>'Warehouse',
    2=>'City',
    3=>'Job Id',
    4=>'Driver',
    5=>'Phone',
    6=>'Iqama',
    7=>'STC Pay',
    8=>'Last Settelment date',
    9=>'Amount',
];
@endphp
@include('new_porttal.partials.export_excel')


<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ URL('New-Portal/DriversClaimDeleteAction')}}" onsubmit="return validateDelete()" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <input type="hidden" name="drivers_jahiz_claim_id" id="drivers_jahiz_claim_id" value="">
                <div class="modal-body">
                    <p>{{__('drivers.Delete_msg')}} <span id="delete_name"></span> ?</p>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                      <button class="btn btn-danger" type="submit">{{__('drivers.Delete')}}</button>
                  </div>
              </form>
        </div>
    </div>
</div>
<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    @include('new_porttal.partials.edit_btn')
</div>

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Jahiz Claim</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">By this module, you can see the claims deduction information for each driver by selecting a specific date range. </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <form method="POST" action="{{URL("/ExportClaim")}}">
                                    @csrf
                                    <input type="hidden" name="SQL" id="SQL">
                                    <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">Claim
                                        Excel
                                    </button>
                                </form>
                                {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
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
                                <tr>
                                    <TH rowspan="2">Update At</TH>
                                    <TH rowspan="2">City</TH>
                                    <TH rowspan="2">EMP ID</TH>
                                    <TH rowspan="2">Driver</TH>
                                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">SANED</TH>
                                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">Bander</TH>
                                    <TH rowspan="2">Last Settlement Date</TH>
                                    <TH rowspan="2">Claim Amount</TH>
                                    <TH rowspan="2">موعد السداد</TH>
                                    <TH rowspan="2">رسوم الشنطة</TH>
                                    <TH rowspan="2">عمولة بندر</TH>
                                    <TH rowspan="2">Reply</TH>
                                    @if(session('Delete_27')==1)
                                        <TH rowspan="2">Action</TH>
                                    @endif
                                </tr>
                                <tr>
                                    <TH>SAR</TH>
                                    <TH>Days</TH>
                                    <TH>SAR</TH>
                                    <TH style="border-right: 1px solid #f4f4f4!important;">Days</TH>
                                </tr>

                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <TH colspan='9'>Total</TH>
                                    <TH></TH>
                                    <TH colspan='4'></TH>
                                    @if (session('Delete_27')==1)
                                        <TH></TH>
                                    @endif
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
            $('#filter_claim_dt').val('');
            $('#filter_lastSettlementDate').val('');
            $('#filter_created_at').val('');
            $('#filter_updated_at').val('');

            $('#filter_claim_dt').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_lastSettlementDate').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            fill_datatable();
            function fill_datatable(filter_warehouseId = '', filter_job_id = '', filter_driver_type_id = '', filter_driverId = '', filter_claim_dt = '', filter_lastSettlementDate = '', filter_claim_status_id = '', filter_Image_PromissoryNote = '', filter_created_at = '', filter_updated_at = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [[0, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        var api = this.api()
                        var json = api.ajax.json();

                        $(api.column(9).footer()).html(json.amount);
                        $('#SQL').val(json.SQL);

                    },
                    ajax: {
                        url: "{{ route('DriversJahizClaim.index') }}",
                        data: {

                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driver_type_id: filter_driver_type_id,
                            filter_driverId: filter_driverId,
                            filter_claim_dt: filter_claim_dt,
                            filter_lastSettlementDate: filter_lastSettlementDate,
                            filter_claim_status_id: filter_claim_status_id,
                            filter_Image_PromissoryNote: filter_Image_PromissoryNote,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                        }
                    },

                    columns: [

                        {
                            data: 'updated_at',
                            name: 'drivers_jahiz_claim.updated_at'
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'job_id',
                            name: 'drivers.job_id'
                        },
                        {
                            data: 'fullName',
                            name: 'drivers.fullName',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                            }
                        },

                        {
                            "searchable": false,
                            data: 'SANED_amount',
                            name: 'SANED_amount',
                            render: function (data, type, row, meta) {
                                if (row.SANED_amount == null)
                                    return '';
                                else if (row.SANED_amount != row.Jahiz_Amount) {
                                    return '<span class="red_color">' + row.SANED_amount + '</span>';
                                } else if (row.SANED_amount == null)
                                    return '';
                                else
                                    return row.SANED_amount;


                            }
                        },

                        {
                            "searchable": false,
                            data: 'SANED_SettledDate',
                            name: 'SANED_SettledDate'
                        },

                        {
                            "searchable": false,
                            data: 'Jahiz_Amount',
                            name: 'Jahiz_Amount',
                            render: function (data, type, row, meta) {
                                if (row.Jahiz_Amount == null)
                                    return '';
                                else if (row.SANED_amount != row.Jahiz_Amount) {
                                    return '<span class="red_color">' + row.Jahiz_Amount + '</span>';
                                } else
                                    return row.Jahiz_Amount;


                            }
                        },
                        {
                            "searchable": false,
                            data: 'Last_Clear',
                            name: 'Last_Clear'
                        },
                        {
                            className: 'green_color',
                            data: 'lastSettlementDate',
                            name: 'drivers.lastSettlementDate'
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            render: function (data, type, row, meta) {
                                return '<b>' + row.amount + '</b>';
                            }
                        },
                        {
                            data: 'claim_dt',
                            name: 'claim_dt',
                            "render": function (data, type, row, meta) {
                                return row.claim_dt + '<br><button onclick="claim_dt(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">+</button>';
                            }
                        },

                        {
                            data: 'bag_fee',
                            name: 'bag_fee',
                            "render": function (data, type, row, meta) {
                                return row.bag_fee + '<br><button onclick="bag_fee(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">+</button>';
                            }
                        },
                        {
                            data: 'Bander_Commission',
                            name: 'Bander_Commission',
                            "render": function (data, type, row, meta) {
                                return row.Bander_Commission + '<br><button onclick="Bander_Commission(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">+</button>';
                            }
                        },
                        {
                            "sortable": false,
                            data: 'drivers_jahiz_claim_reply',
                            name: 'drivers_jahiz_claim_reply',
                            render: function (data, type, row, meta) {
                                var all = '';
                                if (row.drivers_jahiz_claim_reply) {
                                    var str = row.drivers_jahiz_claim_reply;
                                    all += '<table  style="width:auto" class="tab-boder">';
                                    var res = str.split(";;");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("__");
                                        if (one[3] == '') {
                                            all += '<td>' + one[0] + '</td>';
                                            all += '<td>' + one[2] + '</td>';
                                            all += '<th>' + one[1] + '</th>';
                                        } else {
                                            if (one[0] != '') {
                                                all += '<td style="background-color: #00FF80">' + one[3] + '</td>';
                                                all += '<td rowspan="2">' + one[2] + '</td>';
                                                all += '<th rowspan="2">' + one[1] + '</th>';
                                                all += '</tr><tr><td>' + one[0] + '</td>';
                                            } else {
                                                all += '<td style="background-color: #00FF80">' + one[3] + '</td>';
                                                all += '<td >' + one[2] + '</td>';
                                                all += '<th >' + one[1] + '</th>';

                                            }
                                        }

                                        all += '</tr>';
                                    }
                                    all += '</table>';


                                } else
                                    all = '';
                                return all + '<button onclick="Claim_Replay(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">اضافة رد</button>' +
                                    '&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="Claim_Status(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">اضافة حالة</button>';
                            }


                        },
                            @if(session('Delete_27')==1)
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            "render": function (data, type, row, meta) {
                                return '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash-fill"></i> </a>'
                            }

                        },
                        @endif
                    ]
                });


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();

                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversJahizClaim')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });


            $('#filter').click(function () {
                if ($('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_claim_dt').val() != '' || $('#filter_lastSettlementDate').val() != '' || $('#filter_claim_status_id').val() != '' || $('#filter_Image_PromissoryNote').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driver_type_id').val(), $('#filter_driverId').val(), $('#filter_claim_dt').val(), $('#filter_lastSettlementDate').val(), $('#filter_claim_status_id').val(), $('#filter_Image_PromissoryNote').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                    let html = '';
                        if ($('#filter_warehouseId').val() > 0)
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';

                        if ($('#filter_driver_type_id').val() > 0)
                            html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_driver_type_id option:selected').text()+'</button>';
                        if ($('#filter_job_id').val() != '')
                            html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_job_id').val()+'</button>';
                        if ($('#filter_driverId_input').val() != '')
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_driverId_input').val()+'</button>';
                        if ($('#filter_claim_status_id').val() > 0)
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_claim_status_id option:selected').text()+'</button>';

                        if ($('#filter_claim_dt').val() != '')
                            html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_claim_dt option').val()+'</button>';
                        if ($('#filter_lastSettlementDate').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_lastSettlementDate option').val()+'</button>';
                        if ($('#filter_created_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_created_at option').val()+'</button>';
                        if ($('#filter_updated_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_updated_at').val()+'</button>';
                        if ($('#filter_Image_PromissoryNote').val() != '')
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_Image_PromissoryNote option:selected').text()+'</button>';

                        if(html != '') {
                            $('#edit_btn').show();
                            $('#selectedCriteria').html(html);
                        } else {
                            $('#edit_btn').hide();
                        }
                } else {
                    alert('Select filter option');
                }
            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                // document.getElementById('delete_modal').style.display = 'block';
                $('#delete_modal').modal('toggle');
                $('#drivers_jahiz_claim_id').val(id);
            });
            $('#reset').click(function () {
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_claim_dt').val('');
                $('#filter_lastSettlementDate').val('');
                $('#filter_claim_status_id').val('');
                $('#filter_Image_PromissoryNote').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });


        function status() {
            var status_id = document.getElementById('status_id').value;
            if (status_id == "3")
                document.getElementById("Termination_Reason").style.display = '';
            else
                document.getElementById("Termination_Reason").style.display = 'none';
        }

        function driver_window() {
            $('#filter_driverId').val('');
            $('#filter_driverId_input').val('');
            myWindow1 = window.open("{{URL("/New-Portal/DriverJahizWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function driver(id) {
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }

        function WarehouseName() {
            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "")
                $('#filter_warehouseId').empty();
            else {
                $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }

        function Claim_Replay(id) {
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimReply')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }

        function Claim_Status(id) {
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimStatus')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

        function bag_fee(id) {
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimBag')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }

        function Bander_Commission(id) {
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimCommission')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

        function claim_dt(id) {
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimDate')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }

        function validateForm() {
            var postData = $("#contact_form").serializeArray();
            var formURL = $("#contact_form").attr("action");
            $.ajax({
                url: formURL,
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

        function validateDelete() {
            var postData = $("#delete_form").serializeArray();
            var formURL = $("#delete_form").attr("action");
            $.ajax({
                url: formURL,
                type: "DELETE",
                cache: false,
                data: postData,
                success: function (data) {
                    alert('Success! Record deleted successfully')
                    $('#delete_modal').modal('toggle');
                },
                error: function (jqXHR, status, error) {
                    document.getElementById('delete_response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
                    alert(status + ": " + error);
                }
            });
            return false;
        }

    </script>
@stop
@endsection
