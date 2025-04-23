@extends('layout2')
@section('content')
@section('title', 'Vehicle Deduction')
<style>
    .disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .list-group-item+.list-group-item.active {
        border-top: 1px solid white;
        background-color: #0866e9;
    }
    .list-group-item.active{
        background-color: #0866e9;
    }
    #table{
        width: 90%; margin: 0 auto; margin-top: 44px;
    }
    .list-group .list-group-item {

    }
</style>



<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> {{__('drivers.Filter')}}</h5>
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
                                            <label for="country" class="form-label">{{__('companies.companyName')}}</label>
                                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                                    class="form-control" required>
                                                <option value=""></option>
                                                @foreach($lkp_company as $lkpcompany)
                                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">WarehouseName</label>
                                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control">
                                                <option value=""></option>

                                                @foreach($warehouse as $warehousee)
                                                    <option value="{{$warehousee->id}}">{{$warehousee->warehouseName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">EMP ID</label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Post</label>
                                            <select name="filter_post" id="filter_post"
                                                    class="form-control">
                                                <option value=""></option>
                                                <option value="1"> Yes</option>
                                                <option value="2"> No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Driver</label>
                                            <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                                            <span style="display: flex">
                                                <input class="form-control" name="filter_driverId_input"
                                                id="filter_driverId_input" type="text" value="" readonly>
                                                <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                                    Select
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Amount</label>
                                            <input type="text" class="form-control" name="filter_amount" id="filter_amount" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Invoice Number</label>
                                            <input type="text" class="form-control" name="filter_invoice_number" id="filter_invoice_number" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Note</label>
                                            <input type="text" class="form-control" name="filter_note" id="filter_note" value="">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">Journal Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_journal_date" name="filter_journal_date">
                                        </div>
                                    </div>


                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('companies.Created_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_created_at" name="filter_created_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('companies.Updated_At')}}</label>
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
                <button type="button" class="btn btn-dark" id="reset" data-bs-dismiss="modal">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal ExportExcel 3 -->
@php
$array = [
    0=>'Name',
    1=>'Phone',
    2=>'Email',
    3=>'IdentityNo',
    4=>'User Type',
    5=>'Role Name',
    6=>'Status',
    7=>'Created_at',
];
$module = "Vehicle Deduction";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')


<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Vehicle Deduction </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>

        </div>
    </div>
</div>
<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    @include('new_porttal.partials.edit_btn')
</div>
<!-- Row end -->


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Vehicle Deduction</div>
            </div>
            <!-- Card start -->
            <form method="POST" action="{{ URL('/fleetCreditNotesPost')}}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;"></div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                    {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
                                    <button type="button" class="btn btn-info" class="btn btn-info" type="button" onclick="add()"></i>New Deduction</button>
                                    @if(Auth::user()->user_type_id==1)
                                        <button type="submit" name="filter" class="btn btn-sm btn-info">Post To Journal</button>
                                        <button type="submit" name="delete" value="delete" class="btn btn-sm btn-danger">Delete</button>
                                    @endif
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
                        @if(Auth::user()->user_type_id==1)
                        <table style="width:100%">
                            <tr>
                                <td align=right>
                                    <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>&nbsp;&nbsp;Select All
                                </td>
                            </tr>
                        </table>
                        @endif

                        <div class="table-responsive">
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                    <TH>Credit Number</TH>
                                    <TH>Company</TH>
                                    <TH>Warehouse</TH>
                                    <TH>Type</TH>
                                    <TH>SMS Attempt</TH>
                                    <TH>EMP ID</TH>
                                    <TH>Driver</TH>
                                    <TH>previous Balance</TH>
                                    <TH>Current Balance</TH>

                                    <TH>Journal Date</TH>
                                    <TH>Journal Period</TH>

                                    <TH>Amount</TH>
                                    <TH>Note</TH>
                                    <TH>Create By</TH>
                                    <TH>Create At</TH>
                                    <TH>Post</TH>
                                    <TH>Action</TH>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                    <tr>
                                        <TH colspan='11'>Total</TH>
                                        <TH></TH>
                                        <TH colspan='5'></TH>
                                    </tr>
                                    </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        $('#filter_created_at').val('');
        $('#filter_updated_at').val('');
        $('#filter_journal_date').val('');

        $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        $('#filter_journal_date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        function sendSms(id) {
            $('#edit_modal').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{URL("/smsInfo")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function resend_msg(msg_id) {
            var result = confirm("Are you sure you want to send message attempt again?");
            if (result) {
                var postData = {
                    _token: "{{ csrf_token() }}",
                    sms_id:msg_id
                };
                $.ajax({
                    url: "{{url('/')}}/resend-sms",
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (data) {
                        var response = data;
                        if(response.status == true){
                            alert("Message sent successfully");
                            document.getElementById('edit_modal').style.display = 'none';
                            fill_datatable();
                        }else{
                            alert("Something went wrong ");
                        }
                    },

                    error: function (jqXHR, status, error) {
                        alert(status + ": " + error);
                    }
                });
            }
        }
        $(document).ready(function () {
            fill_datatable();
            function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_journal_date = '', filter_amount = '', filter_invoice_number = '', filter_note = '', filter_created_at = '', filter_updated_at = '', filter_post = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [[14, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
                        var api = this.api()
                        var json = api.ajax.json();
                        $(api.column(11).footer()).html(json.amount);

                        $(function () {
                            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                                checkboxClass: 'icheckbox_flat-green',
                                radioClass: 'iradio_flat-green'
                            });


                            $('#select-all').on('ifChecked ifUnchecked', function (event) {
                                if (document.getElementById('select-all').checked) {

                                    $('.flat-red').iCheck('check')
                                } else
                                    $('.flat-red').iCheck('uncheck');
                            });
                        });
                    },
                    ajax: {
                        url: "{{ route('FleetCreditNotes.index') }}",
                        data: {
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driverId: filter_driverId,
                            filter_journal_date: filter_journal_date,
                            filter_amount: filter_amount,
                            filter_invoice_number: filter_invoice_number,
                            filter_note: filter_note,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                            filter_post: filter_post,
                        }
                    },

                    columns: [
                        {
                            name: 'creditnotes.id',
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                return 'CN'+row.id;
                            }
                        },
                        {
                            data: 'companyName',
                            name: 'lkp_company.companyName',
                            //visible:false
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'creditType',
                            name: 'lkp_fleetCreditNotes.name'
                        },

                        {
                            name: 'sms_push_attempts.attempts',
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                if (row.attempts != null)
                                    return '<span style="cursor: pointer" onclick="sendSms('+row.id+')" class="badge badge-success">'+row.attempts+'</span>';
                                else if (row.mobileNumber == null)
                                    return '<i style="color: #f0be5c;font-size: 17px;" title="Driver mobile number is missing or incorrect" class="bi bi-exclamation-triangle" aria-hidden="true"></i>';
                                else
                                    return '<span style="cursor: pointer" onclick="sendSms('+row.id+')" class="badge badge-danger">0</span>';
                            }
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
                            data: 'per_priod',
                            name: 'balance.per_priod'
                        },
                        {
                            data: 'cur_priod',
                            name: 'balance.cur_priod'
                        },
                        {
                            data: 'journal_date',
                            name: 'journal_date'
                        },
                        {
                            data: 'journal_period',
                            name: 'journal_period',
                            bSearchable: false
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            name: 'note',
                            render: function (data, type, row, meta) {
                                if (!row.proof_file) {
                                    return row.note;
                                } else {
                                    let basePath = '/storage/FleetCreditNotes/';
                                    let files = row.proof_file.split(",");
                                    let eye = files
                                        .map(file => `<a href="${basePath}${file}" target="_blank" title="Proof File"><i class="fa fa-eye"></i></a>`)
                                        .join(" ");
                                    return `${row.note} ${eye}`;
                                }
                            }
                        },
                        {
                            data: 'name',
                            name: 'users.name'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'journal_id',
                            //"orderable": false,
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                if (!row.journal_id)
                                    return '<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.id + '">';
                                else return '<span class="badge badge-success">Yes</span>';
                            }
                        },
                        {
                            "orderable": false,
                            className: "dt-nowrap text-center",
                            "targets": -1,

                            "render": function (data, type, row, meta) {
                                var d = '';
                                if (!row.journal_id) {
                                    d = d + '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="bi bi-pencil"></i> </a>' +
                                        '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-times"></i> </a>'
                                }
                                d = d + '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye"></i> </a>';
                                d = d + '&nbsp;<a id=' + row.id + ' data-original-title="print" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue print"> <i class="bi bi-printer" aria-hidden="true"></i> </a>';
                                return d;
                            }
                        }
                    ]
                });


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();

                $('#edit_modal').modal('show');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/CreditNotes')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                e.preventDefault();

                $('#edit_modal').modal('show');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('FleetCreditNotes')}}" + "/" + id + "/edit",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                    }
                });
            });
            $('#customer_data tbody').on('click', '.print', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("CreditNotesPrint")}}" + "/" + id, "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();
            });


            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('FleetCreditNotes')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
            });


            $('#filter').click(function () {

                if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_invoice_number').val() != '' || $('#filter_note').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_post').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_invoice_number').val(), $('#filter_note').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_post').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_journal_date').val('');
                $('#filter_amount').val('');
                $('#filter_invoice_number').val('');
                $('#filter_note').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#filter_post').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });

        function driver_window() {
            myWindow1 = window.open("{{URL("/New-Portal/DriverWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function driver(id) {
            $('#edit_modal').modal('show');
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

        function add() {
            $('#edit_modal').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{ route('FleetCreditNotes.create') }}",
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
    </script>

@stop
@endsection
