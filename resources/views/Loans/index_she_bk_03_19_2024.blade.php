@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Loans</h2>
        </div>
        <div style="float:right;">
            <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Loan</a>
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
                        <TH>CompanyName</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required>
                                <option value=""></option>
                                @foreach($lkp_company as $lkpcompany)
                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                @endforeach
                            </select>
                        </td>

                        <TH>WarehouseName</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId[]" class="form-control"
                                    style="width:180px;" multiple>
                                <option value=""></option>
                            </select>
                            <small style="display: none; color: red" id="multiple_tag">To select multiple items, Ctrl-click each item.</small>
                        </td>
                        <TH>EMP ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>
                        <TH>Loan Type</TH>
                        <td>
                            <select id="filter_Loan_type" name="filter_Loan_type" class="form-control"
                                    style="width:180px;">
                                    <option value="0"></option>
                                 
                                    <option value="PL">Personal Loan</option>
                                    <option value="FL">Fuel Expense</option>
                                 
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Driver</TH>
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
                                            Select
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <TH>Amount</TH>
                        <td><input type="text" class="form-control" style="width:180px;" name="filter_amount"
                                   id="filter_amount" value=""></td>
                        <TH>status</TH>
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
                        <TH>Request Date</TH>
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
                        <TH>Note</TH>
                        <td><input type="text" class="form-control" name="filter_note" id="filter_note" value=""></td>
                        <TH>Updated By</TH>
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
                        <TH>Update UserType</TH>
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
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>

                    <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>
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


    </style>
    <!---------------------------------------------------------------------------------------------------------------------->

    <?php //echo Hash::make('password');?>
    <div class="table-responsive" style="width: 100%;">
        <div class="row form-group" id="pre_loader_build" style="display: none;">
            <div class="col-md-12  text-center">
                <img src="https://btcdmins.com/storage/images/preloader.gif" loading="lazy"> 
            </div>
        </div>
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <TH>Create</TH>
            <TH>Comp</TH>
            <TH>WHouse</TH>
            <TH>Job ID</TH>
            <TH>Driver</TH>
            @if(Auth::user()->user_type_id==1)
                <TH><input class="" onclick="selectall_status(1)" type="checkbox" name="select_all_status" id="select_all_status"/> Paid/Delete</TH>
                <TH>previous Balance</TH>
                <TH>Current Balance</TH>
            @endif
            <TH>Journal Date</TH>
            @if(Auth::user()->user_type_id==1)
                <TH>Journal Period</TH>
            @endif
            <TH>Amount</TH>
            <TH><input class="" onclick="selectall_status()" type="checkbox" name="select-all-status" id="select-all-status"/> Status</TH>
            <TH>Note</TH>
            <TH>Status</TH>
            <TH>Iqama</TH>
            <TH>STC No</TH>
            @if(Auth::user()->user_type_id==1)
                <TH>Create By</TH>
                <TH>Update At</TH>
            @endif
            <TH>Action</TH>
            <!--<TH style="display:none;">DriverId</TH>-->
            <!--<TH style="display:none;">Account Owner Iqama</TH>-->
            </thead>
            <tbody>
                @php $i = $amount = 0; @endphp
                @foreach($data as $row)
                @php $amount += $row->amount; 
                $status = $row->status;
                if($status == 'Ready') {
                    $color = 'green';
                }
                else if($status == 'Onhold'){
                    $color = 'orange';
                }
                else if($status == 'Paid') {
                    $color = 'Blue';
                }
                @endphp
                <tr>
                <td>{{$row->created_at}}</td>
                <td>{{$row->companyName}}</td>
                <td>{{$row->warehouseName}}</td>
                <td>{{$row->job_id}}</td>
                <td><a href="javascript:driver({{$row->driverId}})">{{$row->fullName}}</a></td>
                @if(Auth::user()->user_type_id==1)
                    <td style="text-align: center"><input class="check_status" name="ID_{{$i}}" type="checkbox" value="{{$row->id}}"></td>
                    <td>{{$row->per_priod}}</td>
                    <td>{{$row->cur_priod}}</td>
                @endif
                <td>{{$row->journal_date}}</td>
                @if(Auth::user()->user_type_id==1)
                <td>{{$row->journal_period}}</td>
                @endif
                <td>{{$row->amount}}</td>
                
                <td style="color: {{$color}};">{{$status}}</td>
                <td>{{$row->note}}</td>
                
                @php
                if ($row->status_id == "1") {
                    $body = '<td><span class="label label-warning">' . $row->loan_status . '</span></td>';
                } else if ($row->status_id == "2") {
                    $body = '<td><span class="label label-danger">' . $row->loan_status . '</span></td>';
                } else if ($row->status_id == "3") {
                    $body = '<td><span class="label label-primary">' . $row->loan_status . '</span></td>';
                } else if ($row->status_id == "4") {
                    $body = '<td><span class="label label-success">' . $row->loan_status . '</span></td>';
                } else if ($row->status_id == "5") {
                    $body = '<td><span class="label label-info">' . $row->loan_status . '</span></td>';
                }
                echo $body;
                @endphp
                
                <td>{{$row->account_owner_iqama}}</td>
                <td>{{$row->accountNumber}}</td>
                @if(Auth::user()->user_type_id==1)
                @php
                if ($row->updated_usertypeid == "4") {
                    $body = '<td></td>';
                } else {
                    $body = '<td>'.$row->name.'</td>';
                }
                echo $body;
                @endphp
                <td>{{$row->updated_at}}</td>
                @endif
                @php
                $body = '<td>';
                if ($row->status_id != "4") {
                    $body .= '<a id=' . $row->id . ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>';
                    $body .= '&nbsp;<a id=' . $row->id . ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>';
                }
                $body .= '&nbsp;<a id=' . $row->id . ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';
                if ($row->status_id == "3" || $row->status_id == "5")
                    $body .= '&nbsp;<button id=' . $row->id . ' type="button" class="btn btn-primary btn-xs updatePaid">Paid</button>';
                $body .= '</td>';
                $body .= '</tr>';
                echo $body;
                $i++;
                @endphp
                @endforeach
                
            </tbody>
            <tfoot>
            <tr>
                @if(Auth::user()->user_type_id==1)
                    <TH colspan='5'>Total</TH>
                    <TH style="display: flex; text-align: center"> 
                        <a onclick="go_to_paid()" data-original-title="Paid" title="Paid" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green"><i class="fa fa-credit-card"></i> </a>&nbsp; 
                        <a onclick="delete_loan()" data-original-title="delete" title="Delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a></TH>
                    <TH colspan='4'></TH>
                @else
                    <TH colspan='6'>Total</TH>
                @endif
                <TH><b id="amount_total">{{$amount}}</b></TH>
                <TH><button id="status_button" style="display: none" type="button" class="btn btn-primary btn-small" onclick="go_to_ready()" title="Revert status to Ready">Rev.Status</button></TH>
                @if(Auth::user()->user_type_id==1)
                    <TH colspan='7' ></TH>
                @else
                    <TH colspan='5'></TH>
                @endif
            </tr>
            </tfoot>
        </table>
        <span id="links_btn"></span>

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
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
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


    <script>
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
        function go_to_ready(){
            $('#ACTION').val('READY');
            var array = [];
            var checkboxes = document.querySelectorAll('.check-status:checked');
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
	        $('#customer_data').DataTable({
                order: [],
                // lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                paging: false,
                bAutoWidth: false, 
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
                aoColumnDefs: [
                    {
                        bSortable: false,
                        aTargets: [  ]
                    }
                ],
                responsive: true,
                processing: true,
            });

            
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
                    $('#pre_loader_build').show();
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('LoansSheControllerindex') }}",
                        data:{
                            filter_companyId: $('#filter_companyId').val(),
                            filter_warehouseId: $('#filter_warehouseId').val(),
                            filter_job_id: $('#filter_job_id').val(),
                            filter_driverId: $('#filter_driverId').val(),
                            filter_journal_date: $('#filter_journal_date').val(),
                            filter_amount: $('#filter_amount').val(),
                            filter_status_id: $('#filter_status_id').val(),
                            filter_note: $('#filter_note').val(),
                            filter_updatedby_id: $('#filter_updatedby_id').val(),
                            filter_updated_usertypeid: $('#filter_updated_usertypeid').val(),
                            filter_created_at: $('#filter_created_at').val(),
                            filter_updated_at: $('#filter_updated_at').val(),
                            _token: "{{ csrf_token() }}"
                        }, success:function(data){
                            data = data.split(":::");
                            $('#customer_data').DataTable().clear();
                                    
                            $('#customer_data').DataTable().rows.add($(data[0])).draw();
                            $('#amount_total').html(data[1]);
                            $('#pre_loader_build').hide();
                            $('#STC_Report').attr('disabled', false);
                            $("#status_button").hide();
                            if (data[2] == 0) {
                                $('#STC_Report').attr('disabled', true);
                            }
                            if (data[3] == 1) {
                              $("#status_button").show();
                            }
                            $("#SQL").val(data[4]+" and loan.status = 'Ready'");
                            $("#links_btn").hide();
                        }
                    });
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
            });
        });
        $("form#form_submit").submit(function(e) {
            $('#add_button').html('Adding...');
            $(':button[type="submit"]').prop('disabled', true);
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

            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "")
                $('#filter_warehouseId').empty();
            else {
                $('#multiple_tag').show();
                $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
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
            if ($('#filter_status_id').val() != '5') {
                alert('يجب اختيار ال Approved by Supervisor');
                return false;
            }
            if ($('#SQL').val().indexOf("loan.status_id=5") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }
            setTimeout(function() {
                location.reload();
            }, 5000);
            return true;

        }


    </script>
@endsection

 


