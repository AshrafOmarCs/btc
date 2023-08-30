@extends('AdminLTE')
@section('content')
    <style>
        .Font-Green {
            color: green;
            font-weight: bold;
        }

        .Font-Red {
            color: red;
            font-weight: bold;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Salary</h2>
        </div>
    </div>
    
    <!--Approval Modal -->
    <!-- Modal -->
        <div class="modal fade" id="ApprovalModal" tabindex="-1" role="dialog" aria-labelledby="ApprovalModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">E-Signtures</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body"> 
                    
                   <div id="e_signature" style="display:none;">
                        <table class="table" id="tblEntAttributes" style="width: 97%%;border: 1px solid #d3a45924;    margin-bottom: 15px; margin-top: 15px;  box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
                            <thead>
                             
                            <tr style="background-color: #d3a459; text-align: center !important;"> 
                                <th scope="col">EMP </th> 
                                <th scope="col">Department </th> 
                                <th scope="col">Signature </th>
                            </tr>
                            </thead>
                            <tbody > 
                            </tbody>
                        </table>
                    </div>
              </div>
              <div class="modal-footer">
                
                <!--<button type="button" class="btn btn-primary">Export StcPay File</button>-->
                
                 <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSalarySTC")}}">
                    @csrf
                    <input type="hidden" name="SQL" id="SQL">
                    <input type="hidden" name="company_Id" id="company_Id">
                    <input type="hidden" name="companyName" id="companyName">
                    <input type="hidden" name="PeriodName" id="PeriodName">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 40%">
                                <button type="submit" name="STC_Report" id="STC_Report" disabled class="btn btn-sm btn-info">STC pay
                                    Excel
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </td>
                        </tr>
 
                    </table>
                </form>
        
        
              </div>
            </div>
          </div>
        </div>
    <!-- End of Approval Modal -->
    
    
    @if(session()->has('message'))
    <br>
    
        <div class="alert alert-warning" style="margin-top: 14px;">
            {{ session()->get('message') }} <a href="{{url('Unpaid-Salary')}}">Click Here </a>.
        </div>
    @endif
    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->

    <!-- SELECT2 EXAMPLE -->
    <form method="POST" action="{{ route('Salary.store')}}">
        @csrf
        <div class="col-md-3" style="width:100%;clear:both;">
            <div id="card_box" class="box box-primary ">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <button class="button_search"><i class="fa fa-search"></i></button>
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
                            <TH>CompanyName</TH>
                            <td>
                                <select name="filter_companyId" id="filter_companyId" onchange="CityName()"
                                        class="form-control" style="width:200px;" required>
                                    <option value=""></option>
                                    @foreach($lkp_company as $lkpcompany)
                                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <TH>Period</TH>
                            <td>
                                <select name="filter_Period" id="filter_Period" class="form-control"
                                        style="width:200px;">
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <TH>CityName</TH>
                            <td>
                                <select onchange="Warehouse()" name="filter_cityId" id="filter_cityId"
                                        class="form-control">
                                </select>
                            </td>
                            <TH>Paid</TH>
                            <td>
                                <select name="filter_paid_id" id="filter_paid_id" class="form-control"
                                        style="width:180px;">
                                    <option value=""></option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>Warehouse</TH>
                            <td>
                                <select name="filter_warehouseId" id="filter_warehouseId" class="form-control">
                                </select>

                            </td>
                            <TH>E-Signtures</TH>
                            <td>
                                <a href="#"  id="ApprovalModalBtn" class="btn btn-info btn-md" style=" background-color: #1c6577; border-color: #00acd6; width: 180px;" data-toggle="modal" data-target="#ApprovalModal">Approval List</a>
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
        <center>
            <div id="salary_range"></div>
            <input name="companyId" id="companyId" type="hidden" value="">
            <input name="Period" id="Period" type="hidden" value="">
        </center>
        <table style="width:100%">
            <tr>
                <td align=right>
                    <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>&nbsp;&nbsp;Select All
                </td>
            </tr>
        </table>

        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">
                <thead>
                <tr>

                    <TH style="display:none;">City</TH>
                    <TH>Whouse</TH>
                    <TH>Driver</TH>
                    <TH>ID</TH>
                    <TH>30 Pack</TH>
                    <TH>Final Pack</TH>
                    <TH>Match</TH>
                    <TH>GAP</TH>
                    <TH>Days</TH>
                    <TH>Carried Down</TH>
                    <!--<TH>Day Loaded</TH>-->
                    <TH>Credit</TH>
                    <TH>Debit</TH>
                    <TH>Loan</TH>
                    <TH>CN</TH>
                    <TH>IND</TH>
                    <TH>Expected Salary</TH>
                    <TH>Paid Salary</TH>
                    <TH>T</TH>
                    <TH>Brought Down</TH>
                    <TH>Action</TH>
                    <TH style="display:none;">Bank Name</TH>
                    <TH style="display:none;">AccountNumber</TH>
                    <TH style="display:none;">DriverId</TH>
                    <TH style="display:none;">Account Owner Iqama</TH>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <TH colspan='4'>Total</TH>
                    <TH></TH>
                    <!--<TH></TH>-->
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                </tr>
                </tfoot>
            </table>
        </div>
        <center>
            <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">Post To Journal</button>
        </center>
    </form>
   <div>
        <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSalarySTC")}}">
            @csrf
            <input type="hidden" name="SQL" id="SQL">
            <input type="hidden" name="company_Id" id="company_Id">
            <input type="hidden" name="companyName" id="companyName">
            <input type="hidden" name="PeriodName" id="PeriodName">
            <table style="width: 100%">
                <tr>
                    <td style="width: 40%">
                        <!--<button type="submit" name="STC_Report" id="STC_Report" disabled class="btn btn-sm btn-info">STC pay-->
                        <!--    Excel-->
                        <!--</button>-->
                </tr>
                <tr>
                <button value="Migrate/Move to journal "  id="migrate" style="float:right; " class="btn btn-sm btn-warning">Migrate Selected to Journal</button>
                </tr>
            </table>
        </form>
     </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;padding: 0.0rem 1.0rem !important;" id="response">
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


    <script>
        $(document).ready(function () {

            fill_datatable();

            function fill_datatable(filter_companyId = '', filter_cityId = '', filter_warehouseId = '', filter_Period = '', filter_paid_id = '') {
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
                    "order": [[10, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,

                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
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

                        //------------------------------------------------------------------------------------
                        var api = this.api()
                        var json = api.ajax.json();
                        $('#salary_range').html(json.salary_range);
                        $('#Period').val(json.Period);
                        $('#companyId').val(json.companyId);

                        $(api.column(4).footer()).html(json.total_No_of_TP);
                        $(api.column(5).footer()).html(json.No_of_TouchPoint);
                        $(api.column(6).footer()).html(json.matching);

                        $(api.column(7).footer()).html(json.GAP);

                        $(api.column(9).footer()).html(json.carried_down);
                        $(api.column(10).footer()).html(json.credit_now);
                        $(api.column(11).footer()).html(json.debit_now);

                        $(api.column(12).footer()).html(json.Loan);
                        $(api.column(13).footer()).html(json.CreditNote);
                        $(api.column(14).footer()).html(json.IND);
                        $(api.column(15).footer()).html(json.expected_salary);
                        $(api.column(16).footer()).html(json.paid_salary);
                        $(api.column(17).footer()).html(json.matching_transaction);
                        $(api.column(18).footer()).html(json.brought_down);

                        $('#SQL').val(json.SQL);
                    },

                    ajax: {
                        url: "{{ route('Salary.index') }}",
                        data: {
                            filter_companyId: filter_companyId,
                            filter_cityId: filter_cityId,
                            filter_warehouseId: filter_warehouseId,
                            filter_Period: filter_Period,
                            filter_paid_id:filter_paid_id,
                        }
                    },

                    columns: [

                        {
                            visible: false,
                            data: 'city_name',
                            name: 'city_name'
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouseName',
                        },
                        {
                            data: 'fullName',

                            render: function (data, type, row, meta) {
                                return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                            }

                        },
                        {
                            data: 'job_id',
                            name: 'job_id'
                        },
                        {
                            data: 'total_No_of_TP',
                            name: 'total_No_of_TP',
                        },
                        {
                            data: 'No_of_TouchPoint',
                            name: 'No_of_TouchPoint',
                        },
                        {
                            data: 'matching',
                            render: function (data, type, row, meta) {
                                if (data == "Yes") {
                                    return '<span class="label label-success">' + row.matching + '</span>';
                                } else if (data == "No") {
                                    return '<span class="label label-danger">' + row.matching + '</span>';
                                }
                            }
                        },
                        {
                            data: 'GAP',
                            name: 'GAP',
                        },
                        {
                            data: 'daycount',
                            name: 'daycount',
                        },
                        {
                            data: 'carried_down',
                            render: function (data, type, row, meta) {
                                if (row.carried_down >0) {
                                    return '<span class="Font-Green">' + row.carried_down + '</span>';
                                } else if (row.carried_down <0)  {
                                    return '<span class="Font-Red">' + row.carried_down + '</span>';
                                }
                                else return '';
                            }
                        },
                        // {
                        //     data: 'day_loaded',
                        //     name: 'day_loaded',
                        // },
                        {
                            className: "Font-Green",
                            data: 'credit_now',
                            name: 'credit_now',
                        },
                        {
                            className: "Font-Red",
                            data: 'debit_now',
                            name: 'debit_now',
                        },
                        {
                            data: 'Loan',
                            name: 'Loan',
                        },
                        {
                            data: 'CreditNote',
                            name: 'CreditNote',
                        },
                        {
                            data: 'IND2',
                            render: function (data, type, row, meta) {
                                if (row.IND)
                                    return row.IND;
                                else {
                                    if (row.under_sopnsorship_id == "1") {
                                        return '<input name="IND_' + meta.row + '" type="hidden" class="form-control" style="width:25px" value="">'
                                    } else return '';
                                }
                            }
                        },

                        {
                            data: 'expected_salary',
                            name: 'expected_salary',
                        },
                        {
                            className: "dt-nowrap",
                            data: 'paid_salary',
                            render: function (data, type, row, meta) {
                                if (!row.paid_salary)
                                    return '<input name="paid_salary_' + meta.row + '" type="text" class="form-control" style="width:50px" value="' + row.edit_salary + '">' +
                                        '&nbsp;<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.driverId + '">'
                                else return row.paid_salary;
                            }
                        },
                        {
                            data: 'matching_transaction',
                            render: function (data, type, row, meta) {
                                if (data == "Yes") {
                                    return '<span class="label label-success">' + row.matching_transaction + '</span><b>' + row.amount + '</b>';
                                } else if (data == "No") {
                                    return '<span class="label label-danger">' + row.matching_transaction + '</span><b>' + row.amount + '</b>';
                                } else if (data == "Null") {
                                    return '<span class="label label-warning">' + row.matching_transaction + '</span><b>' + row.amount + '</b>';
                                }
                            }
                        },
                        {
                            data: 'brought_down',
                            render: function (data, type, row, meta) {
                                if (row.brought_down >0) {
                                    return '<span class="Font-Green">' + row.brought_down + '</span>';
                                } else if (row.brought_down <0)  {
                                    return '<span class="Font-Red">' + row.brought_down + '</span>';
                                }
                                else return '';
                            }
                        },
                        {
                            "orderable": false,
                            "searchable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            //"data": 'id',
                            "render": function (data, type, row, meta) {
                                return '<a id=' + row.driverId + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>' +
                                    '&nbsp;<a id=' + row.driverId + ' data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement"> <i class="fa fa-bars"></i> </a>';


                            }
                            //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                        },

                        {
                            visible: false,
                            data: 'bank_name_en',
                            name: 'bank_name_en',
                        },
                        {
                            visible: false,
                            data: 'accountNumber',
                            name: 'accountNumber',
                        },
                        {
                            visible: false,
                            data: 'driverId',
                            name: 'driverId',
                        },
                        {
                            visible: false,
                            data: 'iqama',
                            name: 'iqama',
                        },

                    ]
                });
            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                //alert("{{URL('/SalaryShow')}}" + "/" + id + "/" + document.getElementById('Period').value);
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/SalaryShow')}}" + "/" + id + "/" + document.getElementById('Period').value,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                    }
                });
            });

            $('#customer_data tbody').on('click', '.statement', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/statement')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                    }
                });

            });

            $('#filter').click(function () {
                if ($('#filter_companyId').val() != '' && $('#filter_Period').val() != '') {
                    
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_cityId').val(), $('#filter_warehouseId').val(), $('#filter_Period').val(), $('#filter_paid_id').val());
                    
                    $.ajax({
                        type:'POST',
                        url:"{{ route('CheckPermisions') }}",
                        data:{_token: "{{ csrf_token() }}",filter_companyId:$('#filter_companyId').val(), filter_Period:$('#filter_Period').val(), filter_paid_id:$('#filter_paid_id').val()},
                        success:function(data){
                            // btns behaiver goes here  
                            
                            var currentUser = data.data; 
                            
                            if(data.itemsCount > 0){
                                
                                if(currentUser.DidUserApproveThisInvoice == true && currentUser.IsHavePermissionToExport == true ){
                                    // able Export button
                                    // check if all emp approved invoice Or Not 
                                    if(currentUser.Does_all_approve == true){
                                         $("#STC_Report").prop('disabled', false);
                                    }
                                }else{
                                    $("#STC_Report").prop('disabled', true);
                                }
                            }
                            if(data.itemsCount > 0){
                                $("#e_signature").show(); 
                                $("#tblEntAttributes tbody").empty(); 
                                $("#tblEntAttributes tbody").append(data.payload);
                            }else{
                                $("#e_signature").hide();
                            }
                        },error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $("#e_signature").hide();
                            $("#tblEntAttributes tbody").empty();
                        }
                    });
                    
                } else {
                    if ($('#filter_companyId').val() == '')
                        alert('Select Company');
                    else if ($('#filter_Period').val() == '')
                        alert('Select Period');
                }
            });

            $('#reset').click(function () {
                $('#companyId').val('');
                $('#Period').val('');

                $('#filter_companyId').val('');
                $('#filter_cityId').empty();
                $('#filter_warehouseId').empty();
                $('#filter_Period').empty();
                $('#filter_paid_id').empty();


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });

        });


        function selectall() {

            if (document.getElementById('select-all').checked) {

                $('.aprove-checkbox').iCheck('check');

            } else
                $('.aprove-checkbox').iCheck('uncheck');
        }

        function CityName() {
            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "") {
                $('#filter_cityId').empty();
                $('#filter_warehouseId').empty();
                $('#filter_Period').empty();
            } else {

                $.getJSON("{{URL("/getPeriod")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_Period').empty();
                    $('#filter_warehouseId').empty();
                    //$('#filter_Period').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_Period').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
                //----------------------------------------------------------------------------------------------------------------------
                $.getJSON("{{URL("/getCityName")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_cityId').empty();
                    $('#filter_warehouseId').empty();
                    $('#filter_cityId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_cityId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }

        function Warehouse() {
            var filter_cityId = document.getElementById('filter_cityId').value;
            if (filter_cityId == "")
                $('#filter_warehouseId').empty();
            else {
                $.getJSON("{{URL("/getWarehouse")}}" + "/" + filter_cityId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
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

        function sheet(id, Period) {
            myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
                "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
        }
    </script>
    <script>
        function validateForm() {


            /*if ($('#filter_warehouseId').val() == '') {
                alert('يجب اختيار ال CITY');
                return false;
            }
            //if ($('#filter_clearing_type_id').val() != '2') {
            //    alert('يجب اختيار ال Clearing Type = تسليم');
            //   return false;
            //}
            if (!$('#filter_bank').prop("checked")) {
                alert('يجب اختيار ال Bank');
                return false;
            }
            if ($('#filter_paid_id').val() != '2') {
                alert('يجب اختيار ال Paid = لا');
                return false;
            }
            if ($('#filter_SettledDate').val() == '') {
                alert('يجب اختيار ال SANED SettledDate');
                return false;
            }

            if ($('#SQL').val().indexOf("drivers.id as driverId,companyName,name_en as") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }

             */
            if ($('#filter_companyId').val() == '') {
                alert('يجب اختيار ال company');
                return false;
            }
            if ($('#filter_Period').val() == '') {
                alert('يجب اختيار ال Period');
                return false;
            }
            if ($('#filter_paid_id').val() != '2') {
                alert('يجب اختيار ال Paid = لا');
                return false;
            }
            if ($('#SQL').val().indexOf("TRIM(ROUND(paid_salary,2))+0 =0") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }
            //alert($('#company_Id').val());
            $('#company_Id').val($('#filter_companyId').val());
            $('#companyName').val($("#filter_companyId option:selected").text());
            $('#PeriodName').val($("#filter_Period option:selected").text());
            //alert($('#companyName').val());
            //return false;
            return true;

        }


    </script>
@endsection




