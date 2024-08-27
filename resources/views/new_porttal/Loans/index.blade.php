@extends('layout2')
@section('content')
@section('title', __('loans.Loans'))
<style>
    .circle {
        width: 21px;
        height: 20px;
        border-radius: 50%;
        background-color: red;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .red_color {
        color: red;
        font-weight: bold;
    }
</style>
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
                                            <label for="country" class="form-label">{{__('loans.CompanyName')}} </label>
                                            <select name="filter_companyId[]" id="filter_companyId" onchange="WarehouseName()" class="form-control" required multiple>
                                                <option value=""></option>
                                                @foreach($lkp_company as $lkpcompany)
                                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.WarehouseName')}} </label>
                                            <select id="filter_warehouseId" name="filter_warehouseId[]" class="form-control" multiple>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.EMPID')}} </label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.LoanType')}} </label>
                                            <select id="filter_Loan_type" name="filter_Loan_type" class="form-control">
                                                <option value="0"></option>
                                                <option value="PL">{{__('loans.PersonalLoan')}}</option>
                                                <option value="FL">{{__('loans.FuelExpense')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.Driver')}} </label>
                                            <span style="display: flex">
                                                <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                                                <input class="form-control" name="filter_driverId_input"
                                                id="filter_driverId_input" type="text" value=""
                                                readonly>
                                               <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                                {{__('loans.Select')}}
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.Amount')}} </label>
                                            <input type="text" class="form-control" name="filter_amount" id="filter_amount" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.status')}} </label>
                                            <select id="filter_status_id" name="filter_status_id" class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_loan_status as $lkp_loan_statuss)
                                                    <option
                                                        value="{{$lkp_loan_statuss->id}}">{{$lkp_loan_statuss->loan_status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.Note')}} </label>
                                            <input type="text" class="form-control" name="filter_note" id="filter_note" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.UpdatedBy')}} </label>
                                            <select id="filter_updatedby_id" name="filter_updatedby_id" class="form-control">
                                                <option value=""></option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.UpdateUserType')}} </label>
                                            <select id="filter_updated_usertypeid" name="filter_updated_usertypeid"
                                                class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_user_type as $lkp_user_typee)
                                                    <option
                                                        value="{{$lkp_user_typee->id}}">{{$lkp_user_typee->user_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('loans.RequestDate')}} </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar4"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker-range" id="filter_journal_date" name="filter_journal_date">
                                            </div>
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
                <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal ExportExcel 3 -->
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
$module = "Loan";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')

<!--End Modal ExportExcel 3 -->

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Loan </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
        </div>
    </div>
</div>



<div class="modal fade" id="password_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Authentication </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="w3-container" action="{{URL("/GoToReadyLoan")}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ready_statuss" id="ready_statuss">
                    <input type="hidden" name="ACTION" id="ACTION" value="">

                    <div class="row">
                        <div class="col-lg-12">
                            <b>Please Enter Your Password</b>
                            <input type="password" class="form-control" name="password" id="password" required
                                       value="" >
                       </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{__('drivers.Submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="reverse_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="rev_response"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                <button class="btn btn-primary" type="submit">{{__('drivers.Submit')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- End of Approval Modal -->

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
                <div class="card-title">{{__('loans.Loans')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">From this page you can view drivers Loans detail. </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button>
                                <button id="status_button" type="button" class="btn btn-primary btn-sm" onclick="go_to_ready()" title="Revert status to Ready"><i class="bi bi-skip-backward-circle-fill"></i>{{__('loans.Rev_Status')}}</button>
                                <button class="btn btn-success" onclick="go_to_paid()" title="Paid"><i class="bi bi-credit-card-2-front-fill"></i> </button>
                                <button class="btn btn-danger" onclick="delete_loan()" title="Delete"> <i class="bi bi-trash-fill"></i></button>
                                <a href="javascript:add();" class="btn btn-sm btn-info "><i class="bi bi-plus"></i> {{__('loans.Add_New_Loan')}}</a>
                                @if(Auth::user()->user_type_id==1 && session('Post_15')==1)
                                    <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportLoanSheSTC")}}">
                                        @csrf
                                        <input type="hidden" name="SQL" id="SQL">
                                        <input type="hidden" name="companyName" id="companyName">
                                        <input type="hidden" name="PeriodName" id="PeriodName">
                                        <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">STC pay
                                            Excel
                                        </button>
                                    </form>
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
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                @if(Auth::user()->user_type_id==1)
                                <TH><input class="" onclick="selectall_status(1)" type="checkbox" name="select_all_status" id="select_all_status"/></TH>
                                @endif
                                <TH>Create</TH>
                                <TH>Comp</TH>
                                <TH>WHouse</TH>
                                <TH>Job ID</TH>
                                <TH>Driver</TH>
                                @if(Auth::user()->user_type_id==1)
                                    <TH>Previous Balance</TH>
                                    <TH>Current Balance</TH>
                                @endif
                                <TH>Journal Date</TH>
                                @if(Auth::user()->user_type_id==1)
                                    <TH>Journal Period</TH>
                                @endif
                                <TH>Amount</TH>
                                <TH>OverAll Balance</TH>
                                <TH>Note</TH>
                                <TH>Status</TH>
                                <TH>Attempt</TH>
                                <TH>Iqama</TH>
                                <TH>STC No</TH>
                                @if(Auth::user()->user_type_id==1)
                                    <TH>Create By</TH>
                                    <TH>Update At</TH>
                                @endif
                                <TH>Action</TH>
                                <TH style="display:none;">DriverId</TH>
                                <TH style="display:none;">Account Owner Iqama</TH>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    @if(Auth::user()->user_type_id==1)
                                        <TH colspan='10'>Total</TH>
                                    @else
                                        <TH colspan='6'>Total</TH>
                                    @endif
                                    <TH></TH>
                                    @if(Auth::user()->user_type_id==1)
                                        <TH colspan='9'></TH>
                                    @else
                                        <TH colspan='7'></TH>
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
            function revert_status(id, name, job_id, amount)
            {
                $('#reverse_modal').modal('toggle');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Loans')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        let action = "{{URL('/Loans-revert')}}";
                        data = `<form action="`+action+`" method="POST">
                                @csrf
                                <div><h4>Reason</h4>
                                <input type="hidden" name="loan_id" value="`+id+`">
                                <h5 style="">Name: `+name+`</h5>
                                <h5 style="">Job id: `+job_id+`</h5>
                                <h5 style="">Amount: `+amount+`</h5>
                                <p style="color: red">The request for revert back to ready satge will be sent to Finance Manager.</p>
                                <textarea name="reason" id="reason" style="width: 100%; height: 200px" required></textarea>
                                </div>
                                </form>`;
                        document.getElementById('rev_response').innerHTML = data;
                    }
                });
            }
            function selectall_status(type = null) {
                if(type == 1) {
                    if (document.getElementById('select_all_status').checked)
                        $('.check_status').attr('checked', true);
                    else
                        $('.check_status').attr('checked', false);
                } else {
                    if (document.getElementById('select-all-status').checked)
                        $('.check-status').attr('checked', true);
                    else
                        $('.check-status').attr('checked', false);
                }
            }
            function go_to_ready() {
                $('#ACTION').val('READY');
                var array = [];
                var checkboxes = document.querySelectorAll('.check_status:checked');
                if(checkboxes.length > 0) {
                    for (var i = 0; i < checkboxes.length; i++) {
                    array.push(checkboxes[i].value)
                    }
                    $('#ready_statuss').val(array);
                    $('#password_modal').modal('toggle');
                } else {
                    alert('Please select atleast one checkbox');
                }
            }
            function go_to_paid(){
                $('#ACTION').val('PAID');
                var array = [];
                var checkboxes = document.querySelectorAll('.check_status:checked');
                if(checkboxes.length > 0) {
                    for (var i = 0; i < checkboxes.length; i++) {
                    array.push(checkboxes[i].value)
                    }
                    $('#ready_statuss').val(array);
                    $('#password_modal').modal('toggle');
                } else {
                    alert('Please select atleast one checkbox');
                }
            }
            function delete_loan(){
                $('#ACTION').val('DELETE');
                var array = [];
                var checkboxes = document.querySelectorAll('.check_status:checked');
                if(checkboxes.length > 0) {
                    for (var i = 0; i < checkboxes.length; i++) {
                    array.push(checkboxes[i].value)
                    }
                    $('#ready_statuss').val(array);
                    $('#password_modal').modal('toggle');
                } else {
                    alert('Please select atleast one checkbox');
                }
            }
            $(document).ready(function () {
                $('#filter_updated_at').val('');
                $('#filter_created_at').val('');
                $('#filter_journal_date').val('');

                $('#filter_journal_date').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                var checkboxCounter = 0;
                fill_datatable();
                function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_journal_date = '', filter_amount = '', filter_status_id = '', filter_note = '', filter_updatedby_id = '', filter_updated_usertypeid = '', filter_created_at = '', filter_updated_at = '',filter_Loan_type = '') {
                    var filter_Loan_type = document.getElementById('filter_Loan_type').value;
                    // alert(filter_Loan_type);
                    var dataTable = $('#customer_data').DataTable({
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
                        serverSide: true,
                        @if(Auth::user()->user_type_id==1)
                        "order": [[18, "desc"]],
                        @else
                        "order": [[0, "desc"]],
                        @endif
                        "pagingType": "full_numbers",
                        "autoWidth": false,
                        "fnDrawCallback": function (settings) {
                            $('[data-toggle="tooltip"]').tooltip();
                            var api = this.api()
                            var json = api.ajax.json();
                            if (json && json.data && json.data.length > 0) {
                                // json.data[0].accountNumber = 966539529559;
                                // console.log(json.data[0].accountNumber);
                                @if(Auth::user()->user_type_id==1)
                                    $(api.column(10).footer()).html(json.amount);
                                @else
                                    $(api.column(6).footer()).html(json.amount);
                                @endif
                                $('#SQL').val(json.SQL + " and loan.status = 'Ready'");
                            } else {
                                @if(Auth::user()->user_type_id==1)
                                    $(api.column(10).footer()).html('');
                                @else
                                    $(api.column(6).footer()).html('');
                                @endif
                                $('#SQL').val("");
                                console.log("JSON data is empty or undefined.");
                            }
                        },
                        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                        //alert(aData['account_owner_iqama_check']);
                            @if(Auth::user()->user_type_id==1)
                            if(aData['account_owner_iqama_check']=='No'){
                                $(nRow).find('td:eq(15)').css('background-color', 'red');
                            }
                            if(aData['accountNumber_check']=='No'){
                                $(nRow).find('td:eq(16)').css('background-color', 'red');
                            }
                            @else
                            if(aData['account_owner_iqama_check']=='No'){
                                $(nRow).find('td:eq(10)').css('background-color', 'red');
                            }
                            if(aData['accountNumber_check']=='No'){
                                $(nRow).find('td:eq(11)').css('background-color', 'red');
                            }
                            @endif

                        },
                        ajax: {
                            url: "{{ route('Loans/index') }}",
                            data: {
                                filter_companyId: filter_companyId,
                                filter_warehouseId: filter_warehouseId,
                                filter_job_id: filter_job_id,
                                filter_Loan_type:filter_Loan_type,
                                filter_driverId: filter_driverId,
                                filter_journal_date: filter_journal_date,
                                filter_amount: filter_amount,
                                filter_status_id: filter_status_id,
                                filter_note: filter_note,
                                filter_updatedby_id: filter_updatedby_id,
                                filter_updated_usertypeid: filter_updated_usertypeid,
                                filter_created_at: filter_created_at,
                                filter_updated_at: filter_updated_at,
                            }
                        },

                        columns: [
                            @if (Auth::user()->user_type_id == 1)
                            {
                                orderable: false,
                                data: 'checkbox',
                                name: 'id',
                            },
                            @endif
                            {
                                data: 'created_at',
                                name: 'created_at',
                                render: function (data, type, row, meta) {
                                    return row.created_at;
                                }
                            },
                            {
                                data: 'companyName',
                                name: 'lkp_company.companyName'
                            },
                            {
                                data: 'warehouseName',
                                name: 'warehouse.warehouseName'
                            },
                            {
                                data: 'job_id',
                                name: 'drivers.job_id'
                            },
                            {
                                data: 'fullName',
                                name: 'drivers.fullName',

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
                                name: 'journal_date',
                                bSearchable: false
                            },
                                @endif
                            {
                                data: 'amount',
                                name: 'amount'
                            },
                            {
                                data: 'overall',
                                name: 'amount'
                            },
                            {
                                data: 'note',
                                name: 'note',
                                render: function (data, type, row, meta) {
                                    if(row.proof_file == null) {
                                        return row.note;
                                    } else {
                                        return row.note + ' <a title="Proof File" target="_blank" href="/storage/images/' + row.proof_file + '"> <i class="fa fa-eye"></i></a>';
                                    }
                                }

                            },
                            {
                                data: 'loan_status',
                                name: 'lkp_loan_status.loan_status',
                            },
                            {
                                data: 'export_attempt',
                                name: 'export_attempt',
                                render: function (data, type, row, meta) {
                                        return '<center><div class="circle">'+row.export_attempt+'</div></center>';
                                }
                            },
                            {

                                data: 'account_owner_iqama',
                                name: 'drivers.account_owner_iqama',
                            },

                            {
                                data: 'accountNumber',
                                name: 'drivers.accountNumber'
                            },
                                @if(Auth::user()->user_type_id==1)
                            {
                                data: 'createdby_id',
                                name: 'users.name',
                            },
                            {
                                data: 'updated_at',
                                name: 'updated_at'
                            },
                                @endif
                            {
                                "orderable": false,
                                className: "dt-nowrap",
                                "targets": -1,
                                data: 'action',
                            },
                            {
                                visible: false,
                                data: 'driverId',
                                name: 'loan.driverId',
                            },
                            {
                                visible: false,
                                data: 'account_owner_iqama',
                                name: 'drivers.account_owner_iqama',
                            },

                        ]
                    });


                }

                $('#customer_data tbody').on('click', '.view', function (e) {
                    e.preventDefault();
                    $('#edit_modal').modal('toggle');
                    var id = $(this).attr('id');
                    $.ajax({
                        type: 'GET',
                        url: "{{URL('/Loans')}}" + "/" + id,
                        contentType: "html",
                        dataType: 'html',
                        success: function (data) {

                            document.getElementById('response').innerHTML = data;

                        }
                    });
                });
                $('#customer_data tbody').on('click', '.edit', function (e) {
                    var id = $(this).attr('id');
                    $('#edit_modal').modal('toggle');
                    var id = $(this).attr('id');
                    $.ajax({
                        type: 'GET',
                        url: "{{URL('/Loans')}}" + "/" + id + "/edit",
                        contentType: "html",
                        dataType: 'html',
                        success: function (data) {
                            document.getElementById('response').innerHTML = data;
                        }
                    });
                });
                $('#customer_data tbody').on('click', '.updatePaid', function (e) {
                    var id = $(this).attr('id');
                    $('#edit_modal').modal('toggle');
                    var id = $(this).attr('id');
                    $.ajax({
                        type: 'GET',
                        url: "{{URL('/LoanPaid')}}" + "/" + id + "",
                        contentType: "html",
                        dataType: 'html',
                        success: function (data) {
                            document.getElementById('response').innerHTML = data;
                        }
                    });
                });

                $('#customer_data tbody').on('click', '.delete', function (e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    document.getElementById('delete_form').action = "{{URL('/Loans')}}" + "/" + id;
                    $('#delete_modal').modal('toggle');
                });

                $('#filter').click(function () {
                    if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_status_id').val() != '' || $('#filter_note').val() != '' || $('#filter_updatedby_id').val() != '' || $('#filter_updated_usertypeid').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                        $('#customer_data').DataTable().destroy();
                        fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_status_id').val(), $('#filter_note').val(), $('#filter_updatedby_id').val(), $('#filter_updated_usertypeid').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                        let html = '';
                        let selectedTexts = [];
                        $('#filter_companyId option:selected').each(function() {
                            selectedTexts.push($(this).text());
                        });
                        let selectedCompanies = selectedTexts.join(', ');
                        selectedTexts = [];
                        $('#filter_warehouseId option:selected').each(function() {
                            selectedTexts.push($(this).text());
                        });
                        let selectedWarehouse = selectedTexts.join(', ');

                        if (selectedCompanies != '')
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+selectedCompanies+'</button>';
                        if (selectedWarehouse != '')
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+selectedWarehouse+'</button>';
                        if ($('#filter_job_id').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_job_id').val()+'</button>';
                        if ($('#filter_driverId_input').val() != '')
                            html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_driverId_input').val()+'</button>';
                        if ($('#filter_amount').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_amount').val()+'</button>';
                        if ($('#filter_status_id').val() > 0)
                            html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_status_id option:selected').text()+'</button>';
                        if ($('#filter_note').val() != '')
                            html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_note').val()+'</button>';
                        if ($('#filter_updatedby_id').val() != '')
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_updatedby_id option:selected').text()+'</button>';
                        if ($('#filter_driver_type_id').val() > 0)
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_driver_type_id option:selected').text()+'</button>';
                        if ($('#filter_created_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">Created at: '+$('#filter_created_at').val()+'</button>';
                        if ($('#filter_updated_at').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">Updated at: '+$('#filter_updated_at').val()+'</button>';
                        if ($('#filter_journal_date').val() != '')
                            html += '<button type="button" class="btn btn-outline-danger btn-rounded">Journal Date: '+$('#filter_journal_date').val()+'</button>';

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
                    $('#filter_status_id').val('');
                    $('#filter_note').val('');
                    $('#filter_updatedby_id').val('');
                    $('#filter_updated_usertypeid').val('');
                    $('#filter_created_at').val('');
                    $('#filter_updated_at').val('');
                    $('#customer_data').DataTable().destroy();
                    fill_datatable();
                });
            });


            function add() {
                $('#edit_modal').modal('toggle');
                $.ajax({
                    type: 'GET',
                    url: "{{URL("/Loans/create")}}",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                    }
                });
            }

            function status() {
                var status_id = document.getElementById('status_id').value;
                if (status_id == "3")
                    document.getElementById("Termination_Reason").style.display = '';
                else
                    document.getElementById("Termination_Reason").style.display = 'none';
            }

            function driver_window() {
                myWindow1 = window.open("{{URL("New-Portal/DriverWindow")}}", "",
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

            function WarehouseName() {

                var selectElement = document.getElementById('filter_companyId');

                // Get the selected options
                var selectedOptions = [];
                for (var i = 0; i < selectElement.options.length; i++) {
                    var option = selectElement.options[i];
                    if (option.selected) {
                        selectedOptions.push(option.value);
                    }
                }

                var filter_companyId = document.getElementById('filter_companyId').value;
                if (filter_companyId == "")
                    $('#filter_warehouseId').empty();
                else {
                    $.getJSON("{{URL("/getMultipleWarehouseName")}}" + "/" + selectedOptions, function (json) {
                        $('#filter_warehouseId').empty();
                        $.each(json, function (i, obj) {
                            $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                        });
                    });
                }
            }
            function validateForm() {

                //alert($('#SQL').val());
                //return false;

                if ($('#filter_status_id').val() != '5') {
                    alert('يجب اختيار ال Approved by Supervisor');
                    return false;
                }

                if ($('#SQL').val().indexOf("loan.status_id=5") == -1) {
                    alert('يجب الضغط علي  Filter');
                    return false;
                }

                return true;

            }
            function check_uncheck() {
                selected = [];
                var all_array = @json($array);
                $('#forwardBtn').removeClass('disabled');
                $('#reverseBtn').addClass('disabled');
                if ($('#select_all').prop('checked')) {
                    $(".select_options").addClass("active");
                    let i = 0;
                    all_array.forEach(element => {
                        selected.push({ id: i, name: element });
                        i++;
                    });
                } else {
                    $(".select_options").removeClass("active");
                }
            }
            function check_uncheckSecond() {
                selected = [];
                $('#forwardBtn').addClass('disabled');
                $('#reverseBtn').removeClass('disabled');
                var second_array = @json($array);
                if ($('#select_all_second').prop('checked')) {
                    $(".unselect_options").removeClass("active");
                } else {
                    let i = 0;
                    second_array.forEach(element => {
                        selected.push({ id: i, name: element });
                        i++;
                    });
                    $(".unselect_options").addClass("active");
                }
            }

            // Export Excel button click event
            $('#exportExcelBtn').click(function() {
                var table = $('#customer_data').DataTable();
                $('#ExportExcel').modal('hide');
                var selectedColumns = [];
                selected.forEach(element => {
                    if (element['id'] == 0)
                        selectedColumns.push(1);
                    else if (element['id'] == 1)
                        selectedColumns.push(2);
                    else if (element['id'] == 2)
                        selectedColumns.push(3);
                    else if (element['id'] == 3)
                        selectedColumns.push(4);
                    else if (element['id'] == 4)
                        selectedColumns.push(5);
                    else if (element['id'] == 5)
                        selectedColumns.push(6);
                    else if (element['id'] == 6)
                        selectedColumns.push(7);
                    else if (element['id'] == 7)
                        selectedColumns.push(8);
                    else if (element['id'] == 8)
                        selectedColumns.push(9);
                    else if (element['id'] == 9)
                        selectedColumns.push(10);
                    else if (element['id'] == 10)
                        selectedColumns.push(11);
                    else if (element['id'] == 11)
                        selectedColumns.push(12);
                    else if (element['id'] == 12)
                        selectedColumns.push(13);
                    else if (element['id'] == 13)
                        selectedColumns.push(14);
                    else if (element['id'] == 14)
                        selectedColumns.push(15);
                    else if (element['id'] == 15)
                        selectedColumns.push(16);
                    else if (element['id'] == 16)
                        selectedColumns.push(17);
                });
                var rowCount = table.rows().count();
                var headerRow = selected.map(obj => {
                    var label = obj['name'];
                    return label ? label : '';
                });
                var exportData = [headerRow];

                // var exportData = [selectedColumns.map(columnId => $('#' + columnId).siblings('label').text())];
                var rowCount = table.rows().count();
                for (var i = 0; i < rowCount; i++) {
                    var rowData = [];
                    selectedColumns.forEach(function(columnId) {
                        var cellData = table.cell(i, columnId).data();
                        if (cellData == null) {
                            rowData.push('');
                        } else {
                            rowData.push(cellData); // Or provide a placeholder value
                        }
                    });
                    exportData.push(rowData);
                }
                if (exportData[0].length === 0) {
                    alert('No columns selected for export!');
                    return;
                }
                var ws = XLSX.utils.aoa_to_sheet(exportData);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                XLSX.writeFile(wb, 'Loans.xlsx');
            });
        </script>
    @stop
@endsection
