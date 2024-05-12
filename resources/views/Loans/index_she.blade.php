@extends('AdminLTE')
@section('content')
@section('title', __('loans.Loans'))

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">{{__('loans.Loans')}}</h2>
        </div>
        <div style="float:right;">
            <h2> 
                <button id="status_button" type="button" class="btn btn-primary btn-sm" onclick="go_to_ready()" title="Revert status to Ready">{{__('loans.Rev_Status')}}</button>
                <a onclick="go_to_paid()" data-original-title="Paid" title="Paid" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green"><i class="fa fa-credit-card"></i> </a>&nbsp;
                <a onclick="delete_loan()" data-original-title="delete" title="Delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                <a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> {{__('loans.Add_New_Loan')}}</a>
            </h2>
        </div>
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->


    <script>
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
    </script>
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box"
                                                                                             class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                        <TH>{{__('loans.CompanyName')}}</TH>
                        <td>
                            <select name="filter_companyId[]" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required multiple>
                                @foreach($lkp_company as $lkpcompany)
                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                @endforeach
                            </select>
                        </td>

                        <TH>{{__('loans.WarehouseName')}}</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId[]" class="form-control"
                                    style="width:180px;" multiple>
                                <option value=""></option> 
                            </select>
                        </td>
                        <TH>{{__('loans.EMPID')}}</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>
                        <TH>{{__('loans.LoanType')}}</TH>
                        <td>
                            <select id="filter_Loan_type" name="filter_Loan_type" class="form-control"
                                    style="width:180px;">
                                    <option value="0"></option>
                                    <option value="PL">{{__('loans.PersonalLoan')}}</option>
                                    <option value="FL">{{__('loans.FuelExpense')}}</option>
                                 
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>{{__('loans.Driver')}}</TH>
                        <td style="white-space: nowrap;">
                            <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="filter_driverId_input"
                                               id="filter_driverId_input" style="width:200px" type="text" value=""
                                               data-readonly>
                                    </td>
                                    <td>
                                        <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                            {{__('loans.Select')}}
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <TH>{{__('loans.Amount')}}</TH>
                        <td><input type="text" class="form-control" style="width:180px;" name="filter_amount"
                                   id="filter_amount" value=""></td>
                        <TH>{{__('loans.status')}}</TH>
                        <td>
                            <select id="filter_status_id" name="filter_status_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($lkp_loan_status as $lkp_loan_statuss)
                                    <option
                                        value="{{$lkp_loan_statuss->id}}">{{$lkp_loan_statuss->loan_status}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>{{__('loans.RequestDate')}}</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="filter_journal_date"
                                       id="filter_journal_date">
                                <script>
                                    $(function () {
                                        $('input[name="filter_journal_date"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_journal_date"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_journal_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>

                        </td>
                        <TH>{{__('loans.Note')}}</TH>
                        <td><input type="text" class="form-control" name="filter_note" id="filter_note" value=""></td>
                        <TH>{{__('loans.UpdatedBy')}}</TH>
                        <td>
                            <select id="filter_updatedby_id" name="filter_updatedby_id" class="form-control">
                                <option value=""></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>{{__('loans.UpdateUserType')}}</TH>
                        <td>
                            <select id="filter_updated_usertypeid" name="filter_updated_usertypeid"
                                    class="form-control">
                                <option value=""></option>
                                @foreach($lkp_user_type as $lkp_user_typee)
                                    <option
                                        value="{{$lkp_user_typee->id}}">{{$lkp_user_typee->user_type}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>{{__('loans.Created_At')}}</TH>
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
                        <TH>{{__('loans.Updated_At')}}</TH>
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
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">{{__('loans.Filter')}}</button>

                    <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">{{__('loans.Reset')}}</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <style>
        .red_color {
            color: red;
            font-weight: bold;
        }

        table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting,
        table.dataTable thead > tr > td.sorting_asc,
        table.dataTable thead > tr > td.sorting_desc,
        table.dataTable thead > tr > td.sorting {
            padding-right: 15px !important;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding-left: 4px !important;

        }
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

    </style>
    <!---------------------------------------------------------------------------------------------------------------------->

    <?php //echo Hash::make('password');?>
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
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
                <TH>previous Balance</TH>
                <TH>Current Balance</TH>
            @endif
            <TH>Journal Date</TH>
            @if(Auth::user()->user_type_id==1)
                <TH>Journal Period</TH>
            @endif
            <TH>Amount</TH>
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
                    <TH colspan='8'></TH>
                @else
                    <TH colspan='6'></TH>
                @endif
            </tr>
            </tfoot>
        </table>
    </div>
    @if(Auth::user()->user_type_id==1 && session('Post_15')==1)
    <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportLoanSheSTC")}}">
        @csrf
        <input type="hidden" name="SQL" id="SQL">
        <input type="hidden" name="companyName" id="companyName">
        <input type="hidden" name="PeriodName" id="PeriodName">
        <table style="width: 100%">
            <tr>
                <td style="width: 40%">
                    <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">STC pay
                        Excel
                    </button>

            </tr>
        </table>
    </form>
    @endif
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
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
    
    <div id="password_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:350px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('password_modal').style.display='none'"
                    class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                    title="Close Modal">&times;
                </span>
            </div>
            <form class="w3-container" action="{{URL("/GoToReadyLoan")}}" method="POST">
                @csrf
                <input type="hidden" name="ready_statuss" id="ready_statuss">
                <input type="hidden" name="ACTION" id="ACTION" value="">

                <div class="row">
                    <div class="col-lg-12">
                        <b>Please Enter Your Password</b>
                        <input type="password" class="form-control" style="width:200px;" name="password" id="password" required
                                   value="" >
                   </div>
                </div>
                <div class="w3-section">
                    <div class="w3-center">
                        <button type="submit" class="w3-btn w3-indigo">Submit</button>
                    </div>
                </div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('password_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->


    <script>
        function revert_status(id, name, job_id, amount)
        {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/Loans')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    let action = "{{URL('/Loans-revert')}}";
                    data = `<form action="`+action+`" method="POST">
                            @csrf
                            <div style="margin:20px"><h4>Reason</h4>
                            <input type="hidden" name="loan_id" value="`+id+`">
                            <h5 style="">Name: `+name+`</h5>
                            <h5 style="">Job id: `+job_id+`</h5>
                            <h5 style="">Amount: `+amount+`</h5>
                            <p style="color: red">The request for revert back to ready satge will be sent to Finance Manager.</p>
                            <textarea name="reason" id="reason" style="width: 100%; height: 200px" required></textarea>
                            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                              <button type="submit" class="w3-btn w3-green">Submit</button>
                           </div>
                            </div>
                            </form>`;
                    document.getElementById('response').innerHTML = data;
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
                document.getElementById('password_modal').style.display = 'block';
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
                document.getElementById('password_modal').style.display = 'block';
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
                document.getElementById('password_modal').style.display = 'block';
            } else {
                alert('Please select atleast one checkbox');
            }
        }
        $(document).ready(function () {
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
                    "order": [[17, "desc"]],
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
                            json.data[0].accountNumber = 966539529559;
                            console.log(json.data[0].accountNumber);
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
                            $(nRow).find('td:eq(14)').css('background-color', 'red');
                        }
                        if(aData['accountNumber_check']=='No'){
                            $(nRow).find('td:eq(15)').css('background-color', 'red');
                        }
                        @else
                        if(aData['account_owner_iqama_check']=='No'){
                            $(nRow).find('td:eq(9)').css('background-color', 'red');
                        }
                        if(aData['accountNumber_check']=='No'){
                            $(nRow).find('td:eq(10)').css('background-color', 'red');
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
                            data: 'id',
                            name: 'id',
                            render: function (data, type, row, meta) {
                                let checkbox = '';
                                return checkbox = '<span style="text-align: center"><input class="check_status" name="ID_' + checkboxCounter + '" type="checkbox" value="' + row.id + '"></span>';
                            }
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
                        {
                            data: 'loan_status',
                            name: 'lkp_loan_status.loan_status',
                            render: function (data, type, row, meta) {
                                let status = '';
                                let color = '';
                                let disabled = '';
                                let class_ = '';
                                if (row.status_id == "1") {
                                    status += '<center><span class="label label-warning">' + row.loan_status + '</span></center>';
                                } else if (row.status_id == "2") {
                                    status += '<center><span class="label label-danger">' + row.loan_status + '</span></center>';
                                } else if (row.status_id == "3") {
                                    status += '<center><span class="label label-primary">' + row.loan_status + '</span></center>';
                                } else if (row.status_id == "4") {
                                    status += '<center><span class="label label-success">' + row.loan_status + '</span></center>';
                                } else if (row.status_id == "5") {
                                    status += '<center><span class="label label-info">' + row.loan_status + '</span></center>';
                                }
                                if(row.status == 'Ready') {
                                    color = 'green';
                                    disabled = 'disabled';
                                    class_ = '';
                                } else if(row.status == 'Onhold') {
                                    color = 'orange';
                                    disabled = '';
                                    class_ = 'check-status';
                                } else if(row.status == 'Paid') {
                                    color = 'Blue';
                                    disabled = 'disabled';
                                    class_ = '';
                                }
                                let exported_by = '';
                                if (row.user_name != null)
                                    exported_by = '(' + row.user_name + ')';
                                
                                status += '<span style="text-align: center; display: block;color:'+color+';">'+row.status +'</span><center><span style="color: black !important">'+exported_by+'</span></center>';
                                return status;
                            }
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
                            data: 'name',
                            name: 'users.name',
                            render: function (data, type, row, meta) {
                                if (row.updated_usertypeid == "4") {
                                    return '';
                                } else {
                                    return row.name;
                                }
                            }
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
                            data: 'id',
                            "render": function (data, type, row, meta) {
                                checkboxCounter++;
                                var i = '';
                                if (row.status_id != "4") {
                                    @if(Auth::user()->user_type_id==1)
                                        i = i + '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>';
                                    i = i + '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>';
                                    @endif
                                } else {
                                    i = i +'&nbsp;<a onclick="revert_status(\'' +row.id + '\', \'' +row.fullName + '\', \'' +row.job_id + '\', \'' +row.amount + '\')" data-original-title="revert" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow revert"> <i class="fa fa-undo"></i> </a>';
                                }
                                i = i + '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';
                                @if(Auth::user()->user_type_id==1)
                                if (row.status_id == "3" || row.status_id == "5")
                                    i = i + '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs updatePaid">Paid</button>';
                                @endif
                                    return i


                            }
                            //onclick=\"document.getElementById('row_id').value='"+data+"'\"
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
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
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
                myWindow1 = window.open("{{URL('/Loans')}}" + "/" + id + "/edit", "",
                    "height=650,width=600,scrollbars=yes,top=1,left=1,status,resizable");


            });
            $('#customer_data tbody').on('click', '.updatePaid', function (e) {

                var id = $(this).attr('id');
                myWindow1 = window.open("{{URL('/LoanPaid')}}" + "/" + id, "",
                    "height=650,width=600,scrollbars=yes,top=1,left=1,status,resizable");

            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Loans')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
            });

            $('#filter').click(function () {
                if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_status_id').val() != '' || $('#filter_note').val() != '' || $('#filter_updatedby_id').val() != '' || $('#filter_updated_usertypeid').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_status_id').val(), $('#filter_note').val(), $('#filter_updatedby_id').val(), $('#filter_updated_usertypeid').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
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
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Loans/create")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    
                    document.getElementById('response').innerHTML = data;
                    var g = document.createElement('script');
                    var s = document.getElementsByTagName('script')[0];
                //g.text = "alert(\"hi\");"
                    g.text = "$('#journal_date').datepicker({" +
                        "format: 'dd/mm/yyyy'," +
                        "autoclose: true," +
                        "autoHide: true," +
                        "zIndex: 9999," +
                        "});"
                    s.parentNode.insertBefore(g, s);
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
            myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function driver(id) {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
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
    </script>
    <script>
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


    </script>
@endsection




