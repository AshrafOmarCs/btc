@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">SANED
                Clearing</h2></div>
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
    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
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


                        <TH>City</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">

                                <option value=""></option>
                                @foreach($warehouse as $warehousee)
                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>EMP ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"
                                   style="width:180px;"></td>
                        <TH>Driver Type</TH>
                        <td>
                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($lkp_driver_type as $lkp_driver_typee)
                                    <option
                                        value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                @endforeach
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
                        <TH>Clearing Type</TH>
                        <td>
                            <select name="filter_clearing_type_id" id="filter_clearing_type_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($lkp_clearing_type as $lkp_clearing_typee)
                                    <option
                                        value="{{$lkp_clearing_typee->id}}">{{$lkp_clearing_typee->clearing_type}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>

                    <tr>

                        <TH>Bank</TH>
                        <td>
                            <input type='checkbox' name='filter_bank' id='filter_bank' value="1"
                                   class="icheckbox_flat-green">
                        </td>
                        <TH>Cash</TH>
                        <td>
                            <input type='checkbox' name='filter_cash' id='filter_cash' value="1"
                                   class="icheckbox_flat-green">
                        </td>
                        @if (Auth::user()->user_type_id == 1)
                            <TH>ATM</TH>
                            <td>
                                <input type='checkbox' name='filter_ATM' id='filter_ATM' value="1"
                                       class="icheckbox_flat-green">
                            </td>
                        @else <input type="hidden" name='filter_ATM' id='filter_ATM' value="">
                        @endif
                    </tr>
                    <tr>
                        <TH>Paid</TH>
                        <td>
                            <select name="filter_paid_id" id="filter_paid_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>SANED SettledDate</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_SettledDate" id="filter_SettledDate"
                                       type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_SettledDate"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_SettledDate"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_SettledDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });


                                </script>
                            </div>
                        </td>
                        <TH>Equal</TH>
                        <td>
                            <select name="filter_Equal" id="filter_Equal" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info">Filter</button>

                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->



    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <!-- select all boxes -->


    <!---------------------------------------------------------------------------------------------------------------------->
    <style>
        .table-cell-nolrpadding {
            padding: .3em .0em !important;
        }

        .tab-boder {
            border-top: #1C1D21 solid 0.5px !important;
            border-bottom: #1C1D21 solid 0.5px !important;
            border-left: #1C1D21 solid 0.5px !important;
        }

        .red_color {
            color: red;
            font-weight: bold;
        }
    </style>
    <!---------------------------------------------------------------------------------------------------------------------->

    @if(Auth::user()->user_type_id==1 && session('Post_29')==1)
        <table style="width:100%">
            <tr>
                <td align=right>
                    <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>&nbsp;&nbsp;Select All
                </td>
            </tr>
        </table>
    @endif

    <form method="POST" action="{{ URL('/DriversSANEDClearingPost')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">

                <thead>
                <tr>
                    <TH rowspan="2">SANED Date</TH>
                    <TH rowspan="2">City</TH>
                    <TH rowspan="2">EMP ID</TH>
                    <TH rowspan="2">Driver</TH>
                    <TH rowspan="2">Paid</TH>
                    <TH rowspan="2">SANED Amount</TH>
                    <TH rowspan="2">Bander Amount</TH>
                    <TH rowspan="2">Bander Date</TH>
                    <TH rowspan="2">Driver Type</TH>
                    <TH rowspan="2">Iqama</TH>
                    <TH rowspan="2">Account Number</TH>
                    <TH rowspan="2">No Of Dispatch</TH>
                    <TH rowspan="2">Bander Commission</TH>
                    @if (Auth::user()->user_type_id == 1)
                        <TH colspan="3" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                    @else
                        <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                    @endif
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">تسليم</TH>


                </tr>
                <tr>

                    <TH>Bank</TH>
                    <TH>Cash</TH>
                    @if (Auth::user()->user_type_id == 1)
                        <TH>ATM</TH>
                    @endif
                    <TH>Bank</TH>
                    <TH>Cash</TH>

                </tr>
                </thead>

                <tfoot>
                <tr>
                    <TH colspan='5'>Total</TH>
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
                    @if (Auth::user()->user_type_id == 1)
                        <TH></TH>
                    @endif
                </tr>
                </tfoot>

            </table>
        </div>
        @if(Auth::user()->user_type_id==1 && session('Post_29')==1)

            <table style="width: 100%">
                <tr>
                    <td style="text-align: center">
                        <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">تم الدفع</button>
                    </td>
                </tr>
            </table>
        @endif
    </form>

    <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSTC")}}">
    <!-- Old Route is {{URL("/Saned-Export-Stcpay")}} -->
        @csrf
        <input type="hidden" name="SQL" id="SQL">
        <table style="width: 100%">
            <tr>
                <td style="width: 40%">
                    <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">STC pay
                        Excel
                    </button>

            </tr>
        </table>
    </form>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
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


    <script>
        $(document).ready(function () {

            fill_datatable();


            function fill_datatable(filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_clearing_type_id = '', filter_bank = '', filter_cash = '', filter_ATM = '', filter_paid_id = '', filter_Equal = '', filter_driver_type_id = '', filter_SettledDate = '') {
                var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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

                        $(api.column(5).footer()).html(json.SANED_amount);
                        $(api.column(6).footer()).html(json.Jahiz_Amount);
                        $(api.column(11).footer()).html(json.NoOfDispatch);
                        $(api.column(12).footer()).html(json.Bander_Commission);
                        $(api.column(13).footer()).html(json.bank_plus);
                        $(api.column(14).footer()).html(json.cash_plus);
                        @if (Auth::user()->user_type_id == 1)
                        $(api.column(15).footer()).html(json.ATM_plus);
                        $(api.column(16).footer()).html(json.bank_minus);
                        $(api.column(17).footer()).html(json.cash_minus);
                        @else
                        $(api.column(15).footer()).html(json.bank_minus);
                        $(api.column(16).footer()).html(json.cash_minus);
                        @endif
                        $('#SQL').val(json.SQL);

                        $(function () {
                            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                                checkboxClass: 'icheckbox_flat-blue',
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
                        url: "{{ route('DriversSANEDClearing.index') }}",
                        data: {

                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driverId: filter_driverId,
                            filter_clearing_type_id: filter_clearing_type_id,
                            filter_bank: filter_bank,
                            filter_cash: filter_cash,
                            filter_ATM: filter_ATM,
                            filter_paid_id: filter_paid_id,
                            filter_SettledDate: filter_SettledDate,
                            filter_Equal: filter_Equal,
                            filter_driver_type_id: filter_driver_type_id,

                        }
                    },

                    columns: [
                        {
                            data: 'SettledDate',
                            name: 'drivers_saned_settlement.SettledDate'
                        },

                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'AMP_ID',
                            name: 'drivers_saned_settlement.AMP_ID'
                        },
                        {
                            data: 'DriverName',
                            name: 'drivers_saned_settlement.DriverName',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                            }
                        },

                        {
                            data: 'drivers_jahiz_clearing_paid_id',
                            //"orderable": false,
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                if (!row.drivers_jahiz_clearing_paid_id) {
                                    @if(Auth::user()->user_type_id==1 && session('Post_29')==1)
                                        return '<input type="hidden" name="drivers_jahiz_clearing_id_' + meta.row + '" value="' + row.drivers_jahiz_clearing_id + '">' +
                                        '<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.id + '">';
                                    @else
                                        return '<span class="label label-warning">No</span>';
                                    @endif
                                } else return '<span class="label label-success">Yes</span>';
                            }
                        },


                        {


                            data: 'SANED_amount',
                            name: 'SANED_amount',
                            className: "table-cell-total_drivers",
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

                            className: "table-cell-total_drivers",
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
                            data: 'updated_at',
                            name: 'updated_at'
                        },

                        {
                            data: 'driver_type',
                            name: 'lkp_driver_type.driver_type'
                        },
                        {
                            data: 'account_owner_iqama',
                            name: 'drivers.account_owner_iqama'
                        },
                        {
                            data: 'accountNumber',
                            name: 'drivers.accountNumber'
                        },
                        {
                            "searchable": false,
                            data: 'NoOfDispatch',
                            name: 'NoOfDispatch',
                            render: function (data, type, row, meta) {
                                if (row.driver_type_id == null)
                                    return row.NoOfDispatch;
                                else if (row.driver_type_id != 3)
                                    return '';
                                else if (row.NoOfDispatch * 2 != row.Bander_Commission) {
                                    return '<span class="red_color">' + row.NoOfDispatch + '</span>';
                                } else
                                    return row.NoOfDispatch;


                            }
                        },

                        {
                            "searchable": false,
                            data: 'Bander_Commission',
                            name: 'Bander_Commission',
                            render: function (data, type, row, meta) {

                                if (row.driver_type_id == 3) {
                                    if (row.NoOfDispatch * 2 != row.Bander_Commission)
                                        return '<span class="red_color">' + row.Bander_Commission + '</span>';
                                    else return row.Bander_Commission;
                                } else
                                    return row.Bander_Commission;


                            }
                        },

                        {
                            "searchable": false,
                            className: "table-cell-load",
                            data: 'bank_plus',
                            name: 'bank_plus',

                        },
                        {
                            "searchable": false,
                            className: "table-cell-load",
                            data: 'cash_plus',
                            name: 'cash_plus',

                        },
                            @if (Auth::user()->user_type_id == 1)
                        {
                            "searchable": false,
                            className: "table-cell-load",
                            data: 'ATM_plus',
                            name: 'ATM_plus',

                        },
                            @endif

                        {
                            "searchable": false,
                            className: "table-cell-touchpoint",
                            data: 'bank_minus',
                            name: 'bank_minus',

                        },
                        {
                            "searchable": false,
                            className: "table-cell-touchpoint",
                            data: 'cash_minus',
                            name: 'cash_minus',

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
                    url: "{{URL('/DriversSANEDClearing')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });


            $('#filter').click(function () {
                if ($('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_clearing_type_id').val() != '' || $('#filter_bank').prop("checked") || $('#filter_cash').prop("checked") || $('#filter_ATM').prop("checked") || $('#filter_paid_id').val() != '' || $('#filter_Equal').val() != ''|| $('#filter_driver_type_id').val() != '' || $('#filter_SettledDate').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_clearing_type_id').val(), $('#filter_bank:checked').val(), $('#filter_cash:checked').val(), $('#filter_ATM:checked').val(), $('#filter_paid_id').val(), $('#filter_Equal').val(), $('#filter_driver_type_id').val(), $('#filter_SettledDate').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_clearing_type_id').val('');
                $('#filter_bank').prop("checked", false);
                $('#filter_cash').prop("checked", false);
                $('#filter_ATM').prop("checked", false);
                $('#filter_paid_id').val('');
                $('#filter_Equal').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_SettledDate').val('');


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
            myWindow1 = window.open("{{URL("/DriverJahizWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        //Date picker
        $(function () {
            $('#pakage_date').datepicker({
                autoclose: true,
                autoHide: true,
                zIndex: 9999,
            });
        });

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
    <script>
        function validateForm() {


            if ($('#filter_warehouseId').val() == '') {
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

            if ($('#SQL').val().indexOf("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is  null") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }

            return true;

        }


    </script>
@endsection




