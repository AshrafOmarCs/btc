@extends('layout2')
@section('content')
@section('title', 'Credit Notes')
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
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal addNewUser3 -->
<div class="modal fade" id="addNewUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableLabel"><span id="bck_btn" onclick="go_back()" style="cursor: pointer; display: none; color: #B7A758"><img src="{{URL("dashboard/assets/logos/backward.png")}}" style="width: 7%"> {{__('drivers.Back')}}</span> {{__('drivers.add_driver')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="statment">
                    <h5>{{__('drivers.driver_add_method')}}: </h5>
                     <div class="row">
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Form')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/sign-form.png')}}" alt="fill form to create New driver" >
                        </div>
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Bulk')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/file.png')}}" alt="fill form to create New driver" >
                        </div>
                     </div>
                </div>
                <form id="driverForm">
                    @csrf
                    <div id="create_da_from" style="display: none">
                        <h5>{{__('drivers.select_method')}}: </h5>
                        <h6>{{__('drivers.FormData')}}</h6>
                    </div>
                </form>
                <div id="create_da_bulk" style="display: none">
                    {{-- <span onclick="go_back()" style="cursor: pointer; display: flex"><img src="https://static.thenounproject.com/png/1808051-200.png" style="width: 3%"> <h5>{{__('drivers.Back')}}</h5></span> --}}
                    <div class="row">
                        <div class="col-lg-6 mt-3">
                            <small>
                                {{__('drivers.download_description')}}.
                            </small>
                            <br />
                            <a href="{{ url('/storage/docsFormat/Drivers.csv') }}" class="btn btn-sm btn-info " style="padding: 10px"><i class="fa fa-download"></i>{{__('drivers.clickHere')}}</a>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <form method="POST" action="{{ route('Drivers/upload')}}">
                                @csrf
                                <input type="file" name="drivers_file" id="drivers_file" required><br>
                                <button type="submit" class="btn btn-success mt-4">{{__('drivers.Submit')}}</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="selectBulkOrOne" style="display: none">
                    <div class="row">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                {{-- <button type="button" class="btn btn-success" onclick="showSelectBulkOrOne('statment')">Understood</button> --}}
            </div>

        </div>
    </div>
</div>
<!--End Modal addNewUser 3 -->

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
$module = "CreditNote";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')


<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">CreditNote </h5>
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
                <div class="card-title">Credit Notes</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
                                <button type="button" class="btn btn-info" class="btn btn-info" type="button" onclick="add()"></i>Add New CreditNote</button>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    @if(Auth::user()->user_type_id==1)
                    <table style="width:100%">
                        <tr>
                            <td align=right>
                                <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>&nbsp;&nbsp;Select All
                            </td>
                        </tr>
                    </table>
                    @endif
                    <form method="POST" action="{{ URL('/CreditNotesPost')}}">
                        @csrf
                        <div class="table-responsive">
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                    <TH>Company</TH>
                                    <TH>Warehouse</TH>
                                    <TH>EMP ID</TH>
                                    <TH>Driver</TH>
                                    @if(Auth::user()->user_type_id==1)
                                    <TH>previous Balance</TH>
                                    <TH>Current Balance</TH>
                                    @endif
                                    <TH>Journal Date</TH>
                                    @if(Auth::user()->user_type_id==1)
                                    <TH>Journal Period</TH>
                                    @endif
                                    <TH>Amount</TH>
                                    <TH>Note</TH>
                                    @if(Auth::user()->user_type_id==1)
                                    <TH>Create By</TH>
                                    @endif
                                    <TH>Create At</TH>
                                    @if(Auth::user()->user_type_id==1)
                                    <TH>Post</TH>
                                    @endif
                                    <TH>Action</TH>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        @if(Auth::user()->user_type_id==1)
                                        <TH colspan='8'>Total</TH>
                                        @else
                                            <<TH colspan='5'>Total</TH>
                                        @endif
                                        <TH></TH>
                                        @if(Auth::user()->user_type_id==1)
                                            <TH colspan='5'></TH>
                                        @else
                                            <TH colspan='3'></TH>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @if(Auth::user()->user_type_id==1)
                        <center>
                            <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">Post To Journal</button>
                        </center>
                        @endif
                    </form>
                </div>
            </div>
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
        $(document).ready(function () {
            $('#filter_created_at').val('');
            $('#filter_updated_at').val('');
            $('#filter_journal_date').val('');
            // Clear the input when the cancel button is clicked
            $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_journal_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            fill_datatable();
            function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_journal_date = '', filter_amount = '', filter_invoice_number = '', filter_note = '', filter_created_at = '', filter_updated_at = '', filter_post = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    @if(Auth::user()->user_type_id==1)
                    "order": [[11, "desc"]],
                    @else
                    "order": [[7, "desc"]],
                    @endif
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
                        var api = this.api()
                        var json = api.ajax.json();
                        @if(Auth::user()->user_type_id==1)
                        $(api.column(8).footer()).html(json.amount);
                        @else
                        $(api.column(5).footer()).html(json.amount);
                        @endif

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
                        url: "{{ route('CreditNotes.index') }}",
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
                            @if(Auth::user()->user_type_id==1)
                        {
                            data: 'per_priod',
                            name: 'balance.per_priod'
                        },
                        {
                            data: 'cur_priod',
                            name: 'balance.cur_priod'
                        },
                            @endif
                        {
                            data: 'journal_date',
                            name: 'journal_date'
                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            data: 'journal_period',
                            name: 'journal_period',
                            bSearchable: false
                        },
                            @endif
                        {
                            data: 'amount',
                            name: 'amount'
                        },

                        {
                            data: 'note',
                            name: 'note'
                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            data: 'name',
                            name: 'users.name'
                        },
                            @endif
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                            @if(Auth::user()->user_type_id==1)
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
                            @endif
                        {
                            "orderable": false,
                            className: "dt-nowrap text-center",
                            "targets": -1,

                            "render": function (data, type, row, meta) {
                                let action = @json(__('drivers.Action'));
                                let view = @json(__('drivers.view'));
                                let edit = @json(__('drivers.edit'));
                                let deletee = @json(__('drivers.Delete'));
                                let html = `
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    `+action+`
                                    </button>
                                    <ul class="dropdown-menu">`;
                                        @if(Auth::user()->user_type_id==1)
                                        if (!row.journal_id) {
                                            html += `<li>
                                                <a id=` + row.id + ` data-original-title="print" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow print dropdown-item" href="#">Print</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit dropdown-item" href="#">`+edit+`</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a id=` + row.id + ` data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete dropdown-item" href="#"><span style="color:red">`+deletee+`</span></a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>`;
                                        }
                                        @endif
                                        html += `
                                        <li>
                                            <a id=` + row.id + ` data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view dropdown-item" href="#">`+view+`</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        `;

                                        html += `
                                    </ul>
                                </div>`;
                                return html;
                            }
                        }
                    ]
                });


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');

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
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/CreditNotes')}}" + "/" + id + "/edit",
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
                document.getElementById('delete_form').action = "{{URL('/CreditNotes')}}" + "/" + id;
                $('#delete_modal').modal('toggle');


            });

            $('#filter').click(function () {

                if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_invoice_number').val() != '' || $('#filter_note').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_post').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_invoice_number').val(), $('#filter_note').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_post').val());
                    let html = '';
                    if ($('#filter_companyId').val() != '')
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                    if ($('#filter_warehouseId').val() != '')
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                    if ($('#filter_job_id').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_job_id').val()+'</button>';
                    if ($('#filter_driverId').val() != '')
                        html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_driverId_input').val()+'</button>';
                    if ($('#filter_journal_date').val() != '')
                        html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_journal_date').val()+'</button>';
                    if ($('#filter_amount').val() != '')
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_amount').val()+'</button>';
                    if ($('#filter_invoice_number').val() != '')
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_invoice_number').val()+'</button>';
                    if ($('#filter_note').val() != '')
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_note').val()+'</button>';
                    if ($('#filter_post').val() != '')
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_post option:selected').text()+'</button>';

                    if ($('#filter_created_at').val() != '')
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">Created at: '+$('#filter_created_at').val()+'</button>';
                    if ($('#filter_updated_at').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Updated at: '+$('#filter_updated_at').val()+'</button>';

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
            myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function driver(id) {
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

        function add() {
            // document.getElementById('response').innerHTML = loader;
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL("/CreditNotes/create")}}",
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
